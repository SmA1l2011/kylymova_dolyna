<?php

namespace App\Http\Controllers\Site;

use App\Models\Subreview;
use App\Http\Requests\SubreviewRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubreviewController extends Controller
{
    public function index(int $product_id, int $id)
    {
        $allSubreviews = Subreview::getAllSubreviews($id, [], true);
        return view("site/products/subreviews", compact("allSubreviews"));
    }

    public function store(SubreviewRequest $request)
    {
        Subreview::subreviewCreate($request->validated());
        return to_route("subreviewIndex", [$request->post("product_id"), $request->post("review_id")]);
    }
}
