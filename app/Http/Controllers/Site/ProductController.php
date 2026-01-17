<?php

namespace App\Http\Controllers\Site;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Review;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        if (isset($_GET["sortBy"])) {
            switch ($_GET["sortBy"]) {
                case "Назва":
                    $sortBy = "title";
                    break;

                case "Ціна вниз":
                    $sortBy = "priceD";
                    break;

                case "Ціна вгору":
                    $sortBy = "priceU";
                    break;

                case "Найдавніше":
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
            $is_set = true;
            foreach (Session::get("orders") as $order) {
                if ($order[0] == $request->post("order")) {
                    $order[1]++;
                    $is_set = false;
                }
                $orders[] = $order;
            }
            if ($is_set == true) {
                $orders[] = [$request->post("order"), 1, $request->post("price")];
            }
            Session::put("orders", $orders);
            if (Session::has("is_order")) {
                Session::forget("is_order");
            }
        } else {
            Session::put("orders", [0 => [$request->post("order"), 1, $request->post("price")]]);
            if (Session::has("is_order")) {
                Session::forget("is_order");
            }
        }
        return to_route("orderIndex");
    }

    public function product(int $id)
    {
        $product = Product::getProduct($id);
        $allReviews = Review::getAllReviews($id, ["sortBy" => "rating"], true);
        $sumRating = 0;
        $ratingCount = [
            5 => 0,
            4 => 0, 
            3 => 0, 
            2 => 0, 
            1 => 0
        ];
        foreach ($allReviews as $key => $review) {
            $ratingCount[$review->rating]++;
            $sumRating += $review->rating;
        }
        if ($sumRating == 0) {
            $avgRating = 0;
        } else {
            $avgRating = round($sumRating / count($allReviews), 2);
        }
        return view("site/products/product", compact("product", "allReviews", "avgRating", "ratingCount"));
    }
}
