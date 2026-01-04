<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Review extends Model
{
    public $table = 'reviews';
    public $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     */
    public $fillable = [
        'product_id',
        'customer_id',
        'rating',
        'comment',
    ];

    public static function getAllReviews($id = null, $get = [], $is_site = false)
    {
        $query = DB::table("reviews")->join("users", "reviews.user_id", "=", "users.id")
            ->select("reviews.*", "users.name");
        if ($is_site == true) {
            $query->where("reviews.is_active", true);
        }
        if ($id !== null) {
            $query->where("reviews.product_id", $id);
        }
        if (isset($get["is_active"]) && $get["is_active"] !== "all") {
            $query->where("reviews.is_active", $get["is_active"] == "yes" ? true : false);
        }
        if (isset($get["product_id"]) && $get["product_id"] !== "all") {
            $query->where("reviews.product_id", $get["product_id"]);
        }
        if (isset($get["sortBy"])) {
            $query->orderBy($get["sortBy"], $get["sortBy"] == "rating" ? "desc" : "asc");
        } else {
            $query->orderBy("id");
        }
        $reviews = $query->get();
        return $reviews;
    }

    public static function reviewCreate($data)
    {
        DB::table("reviews")->insert([
            "product_id" => $data["product_id"],
            "user_id" => $data["user_id"],
            "rating" => $data["rating"],
            "comment" => $data["comment"],
            "is_active" => false,
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }

    public static function reviewApprove($id, $is_active)
    {
        DB::table("reviews")->where('id', $id)->update([
            "is_active" => $is_active == "approve" ? 1 : 0,
        ]);
    }
}
