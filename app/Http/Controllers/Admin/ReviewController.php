<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Review;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $allProducts = Product::getAllProducts();
        if (isset($_GET["sortBy"])) {
            switch ($_GET["sortBy"]) {
                case "id товару":
                    $sortBy = "product_id";
                    break;

                case "рейтинг":
                    $sortBy = "rating";
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
        $allReviews = Review::getAllReviews(null, $_GET, false, $sortBy);
        return view("admin/reviews/index", compact("allReviews", "allProducts"));
    }

    public function store(Request $request)
    {
        $is_active = 0;
        switch ($request["is_active"]) {
            case 'підтверджений':
                $is_active = "not approve";
            break;
                
            default:
                $is_active = "approve";
            break;
        }
        Review::reviewApprove($request["id"], $is_active);
        return to_route("adminReviewIndex");
    }
}
