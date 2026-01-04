<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subcategory;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SubcategoryRequest;

class SubcategoryController extends Controller
{
    public function index(int $category_id)
    {
        $subcategories = Subcategory::getSubcategories($category_id);
        return view("admin/subcategories/index", compact("subcategories"));
    }

    public function create()
    {
        return view("admin/subcategories/create");
    }

    public function store(SubcategoryRequest $request)
    {
        Subcategory::subcategoryCreate($request->validated(), $request->post("category_id"));
        return to_route("subcategoryIndex", $request->post("category_id"));
    }

    public function edit(int $category_id, int $id)
    {
        $allCategories = Category::getAllCategories();
        $subcategory = Subcategory::getSubcategories(null, $id)[0];
        return view("admin/subcategories/edit", compact("allCategories", "subcategory"));
    }

    public function update(SubcategoryRequest $request, $id)
    {
        Subcategory::subcategoryUpdate($request->validated(), $id, $request->post("category_id"));
        return to_route("subcategoryIndex", $request->post("oldCategory_id"));
    }

    public function delete(int $id)
    {
        Subcategory::subcategoryDelete($id);
        return back();
    }
}
