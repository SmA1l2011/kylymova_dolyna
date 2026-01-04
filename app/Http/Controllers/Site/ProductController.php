<?php

namespace App\Http\Controllers\Site;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        if (isset($_GET["sortBy"])) {
            switch ($_GET["sortBy"]) {
                case "title":
                    $sortBy = "title";
                    break;

                case "price down":
                    $sortBy = "priceD";
                    break;

                case "price up":
                    $sortBy = "priceU";
                    break;

                case "oldest":
                    $sortBy = "oldest";
                    break;

                default:
                    $sortBy = "newest";
                    break;
            }
        } else {
            $sortBy = "newest";
        }
        $filters = [];
        foreach ($_GET as $key => $value) {
            $filters[$key] = $value;
        }
        $allCategories = Category::getAllCategories();
        $allSubcategories = Subcategory::getSubcategories();
        $categoryIds = [];
        foreach ($allCategories as $category) {
            $categoryIds[$category->id] = [];
        }

        foreach ($allSubcategories as $subcategory) {
            foreach ($categoryIds as $key => $categoryId) {
                if ($subcategory->category_id == $key) {
                    $categoryIds[$key][] = $subcategory;
                }
            }
        }
        $allProducts = Product::getAllProducts($sortBy, $filters, [], $categoryIds);
        $categoryIdsJson = json_encode($categoryIds);

        foreach ($allProducts as $key => $product) {
            $isOk = false;
            foreach (explode(" ", $product->title) as $title) {
                if (strlen($title) > 16 && $isOk === false) {
                    $isOk = true;
                }
            }
            if ($isOk === true) {
                $allProducts[$key]->isScroll = true;
            } else {
                $allProducts[$key]->isScroll = false;
            }
        }
        return view("site/products/index", compact("allProducts", "allSubcategories", "allCategories", "categoryIds", "categoryIdsJson"));
    }

    public function store(Request $request)
    {
        if (Session::has("orders")) {
            $orders = [];
            $orders[] = [$request->post("order"), 1, $request->post("price")];
            foreach (Session::get("orders") as $order) {
                $orders[] = $order;
            }
            Session::put("orders", $orders);
        } else {
            Session::put("orders", [0 => [$request->post("order"), 1, $request->post("price")]]);
        }
        return to_route("orderIndex");
    }

    public function product(int $id)
    {
        $product = Product::getProduct($id);
        return view("site/products/product", compact("product"));
    }
}
