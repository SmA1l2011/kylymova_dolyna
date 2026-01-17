<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'orders';
    public $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     */
    public $fillable = [
        'product_id',
        'customer_id',
        'count',
        'total',
    ];

    public static function getAllOrders($sortBy = "id", $filters = [])
    {
        $query = Order::query();
        if (!empty($filters["minPrice"])) {
            $query->where("price", ">=", $filters["minPrice"]);
        }
        if (!empty($filters["maxPrice"])) {
            $query->where("price", "<=", $filters["maxPrice"]);
        }
        if (!empty($filters["user_id"]) && $filters["user_id"] !== "all") {
            $query->where("user_id", $filters["user_id"]);
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

    public static function ordersCreate($data)
    {
        DB::table("orders")->insert([
            "product_id" => $data["product_id"],
            "user_id" => $data["user_id"],
            "user_info" => $data["user_info"],
            "count" => $data["count"],
            "price" => $data["price"],
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }

    public static function orderDelete($id)
    {
        DB::table("orders")->where('id', $id)->delete();
    }
}
