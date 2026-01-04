<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    public $table = 'subcategories';
    public $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     */
    public $fillable = [
        'category_id',
        'title',
        'description',
    ];

    public static function getSubcategories($category_id = null, $id = null)
    {
        if ($category_id !== null && $id !== null) {
            return DB::table("subcategories")->where('category_id', $category_id)->where('id', $id)->get();
        } elseif ($category_id !== null && $id == null) {
            return DB::table("subcategories")->where('category_id', $category_id)->get();
        } elseif ($category_id == null && $id == null) {
            return DB::table("subcategories")->get();
        } else {
            return DB::table("subcategories")->where('id', $id)->get();
        }
    }

    public static function subcategoryCreate($data, $category_id)
    {
        DB::table("subcategories")->insert([
            "category_id" => $category_id,
            "title" => $data["title"],
            "description" => $data["description"],
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }

    public static function subcategoryUpdate($data, $id, $category_id)
    {
        DB::table("subcategories")->where('id', $id)->update([
            "category_id" => $category_id,
            "title" => $data["title"],
            "description" => $data["description"],
            "updated_at" => now(),
        ]);
    }

    public static function subcategoryDelete($id)
    {
        DB::table("subcategories")->where('id', $id)->delete();
    }
}
