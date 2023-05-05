<?php

namespace App\Http\Controllers\Admin\Get;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function list(Request $request)
    {
        $request->flash();

        $products = Product::orderByDesc('id');
        if ($request->has('id') && $request->id) $products->where("products.id", "=", $request->id);
        if ($request->has('title') && $request->title) $products->where("products.title", "LIKE", "%{$request->title}%");
        if ($request->has('category') && $request->category) {
            $category = Category::find($request->category);
            $category->childList = new Collection();
            $category->childList->push($category);
            $category = $this->buildChildList($category, $category);
            $tmpCategoriesList = [];
            foreach ($category->childList as $child) {
                array_push($tmpCategoriesList, $child->id);
            }
            $products->whereIn("products.category", $tmpCategoriesList);
        }


        $products->join("categories", "products.category", "=", "categories.id")
            ->select("products.*", "categories.title as category_title", "categories.id as category_id");
        $products = $products->get();

        $countProudcts = Product::count();
        $categories = Category::orderBy("title")->get();

        return view('admin.products.list', [
            'products' => $products,
            'countProducts' => $countProudcts,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $categories = Category::orderBy("title")->get();
        return view('admin.products.create', [
            'categories' => $categories,
        ]);
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy("title")->get();
        $attributes = Product_attribute::where("product", $product->id)->get();
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'attributes' => $attributes,
        ]);
    }


    function buildChildList($category, $item)
    {
        $children = Category::where("parent_id", "=", $item->id)->get();
        foreach ($children as $child) {
            $category->childList->push($child);
            $this->buildChildList($category, $child);
        }
        return $category;
    }
}
