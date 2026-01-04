<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Subcategory;
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
                case "title":
                    $sortBy = "title";
                    break;

                case "price down":
                    $sortBy = "priceD";
                    break;

                case "price up":
                    $sortBy = "priceU";
                    break;

                default:
                    $sortBy = "id";
                    break;
            }
        } else {
            $sortBy = "id";
        }
        $filters = [];
        foreach ($_GET as $key => $value) {
            $filters[$key] = $value;
        }
        $allSubcategories = Subcategory::getSubcategories();
        $allProducts = Product::getAllProducts($sortBy, $filters);
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
        return view("admin/products/index", compact("allProducts", "allSubcategories"));
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

        return view("admin/products/product", compact("product", "productGTM"));
    }
}
