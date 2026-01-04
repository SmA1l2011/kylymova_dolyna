<?php

namespace App\Http\Controllers\Site;

use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(int $id)
    {
        $allReviews = Review::getAllReviews($id, ["sortBy" => "rating"], true);
        return view("site/products/reviews", compact("allReviews"));
    }

    public function store(ReviewRequest $request)
    {
        Review::reviewCreate($request->validated());
        return to_route("productReviews", $request->post("product_id"));
    }
}
