<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'products';
    public $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     */
    public $fillable = [
        'subcategory_id',
        'title',
        'price',
        'picture',
    ];

    public static function getAllProducts($sortBy = "id", $filters = [], $productsArr = [], $categoryIds = [])
    {
        $query = Product::query();
        if (!empty($filters["title"])) {
            $query->where("title", "like", "%" . $filters["title"] . "%");
        }
        if (!empty($filters["minPrice"])) {
            $query->where("price", ">=", $filters["minPrice"]);
        }
        if (!empty($filters["maxPrice"])) {
            $query->where("price", "<=", $filters["maxPrice"]);
        }
        if (!empty($filters["category"]) && $filters["category"] !== "all") {
            if (empty($filters["subcategory"]) || $filters["subcategory"] == "all") {
                foreach ($categoryIds[$filters["category"]] as $categoryId) {
                    $query->where("subcategory_id", $categoryId->id, NULL, "or");
                }
            }
        }
        if (!empty($filters["subcategory"]) && $filters["subcategory"] !== "all") {
            $query->where("subcategory_id", $filters["subcategory"]);
        }
        if (!empty($productsArr)) {
            $arr = [];
            foreach ($productsArr as $product) {
                if (isset($product[0])) {
                    $arr[] = $product[0];
                }
            }
            $query->whereIn("id", $arr);
        }
        $query = $query->get();
        switch ($sortBy) {
            case "newest":
                $products = $query->sortBy("created_at", SORT_REGULAR, "desc");
            break;

            case "oldest":
                $products = $query->sortBy("created_at");
            break;

            case "priceU":
                $products = $query->sortBy("price");
            break;
            
            case "priceD":
                $products = $query->sortBy("price", SORT_REGULAR, "desc");
            break;
            
            default:
                $products = $query->sortBy($sortBy);
            break;
        }
        return $products;
    }

    public static function productCreate($data, $picture)
    {
        DB::table("products")->insert([
            "subcategory_id" => $data["subcategory_id"],
            "title" => $data["title"],
            "price" => $data["price"],
            "picture" => $picture,
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }

    public static function productUpdate($data, $id)
    {
        DB::table("products")->where('id', $id)->update([
            "subcategory_id" => $data["subcategory_id"],
            "title" => $data["title"],
            "price" => $data["price"],
            "updated_at" => now(),
        ]);
    }

    public static function productDelete($id)
    {
        DB::table("products")->where('id', $id)->delete();
    }

    public static function getProduct($id): Product
    {
        return Product::findOrFail($id);
    }
}
