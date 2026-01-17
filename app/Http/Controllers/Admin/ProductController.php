<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Services\GoogleTagManeger;
use Mockery\Undefined;

class ProductController extends Controller
{
    protected GoogleTagManeger $service;

    public function __construct(GoogleTagManeger $service)
    {
        $this->service = $service;
    }

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
        return view("admin/products/index", compact("allProducts", "allSubcategories", "allCategories", "categoryIds", "categoryIdsJson"));
    }

    public function create()
    {
        $allSubcategories = Subcategory::getSubcategories();
        return view("admin/products/create", compact("allSubcategories"));
    }

    public function store(ProductRequest $request)
    {
        $allProducts = Product::getAllProducts();
        if (isset($allProducts[0])) {
            $pictureNumber = $allProducts->last()->id + 1;
        } else {
            $pictureNumber = 1;
        }
        $fileTypeArr = explode(".", $request->all("picture")["picture"]->getClientOriginalName());
        $fileType = $fileTypeArr[count(explode(".", $request->all("picture")["picture"]->getClientOriginalName())) - 1];
        $fileName = "productPicture-" . $pictureNumber . "." . $fileType;
        $targetFile = "../resources/img/" . $fileName;
        Product::productCreate($request->validated(), $fileName);
        move_uploaded_file($request->file("picture")->getRealPath(), $targetFile);
        return to_route("adminProductIndex");
    }

    public function edit(int $id)
    {
        $product = Product::getProduct($id);
        $allSubcategories = Subcategory::getSubcategories();
        return view("admin/products/edit", compact("product", "allSubcategories"));
    }

    public function update(ProductRequest $request, $id)
    {  
        if($request->all("picture")["picture"] !== null) {
            $product = Product::getProduct($id);
            $path = public_path('../resources/img/' . $product->picture);
            if (File::exists($path)) {
                File::delete($path);
            }

            $targetFile = "../resources/img/" . $product->picture;
            move_uploaded_file($request->file("picture")->getRealPath(), $targetFile);
        }

        Product::productUpdate($request->validated(), $id);
        return to_route("adminProduct", $id);
    }

    public function delete($id)
    {
        $product = Product::getProduct($id);
        $path = public_path('../resources/img/' . $product->picture);
        if (File::exists($path)) {
            File::delete($path);
        }
        Product::productDelete($id);
        return to_route("adminProductIndex");
    }

    public function product(int $id)
    {
        $product = Product::getProduct($id);
        $productGTM = $this->service->viewProductPage($product);
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

        return view("admin/products/product", compact("product", "productGTM", "allReviews", "avgRating", "ratingCount"));
    }
}
