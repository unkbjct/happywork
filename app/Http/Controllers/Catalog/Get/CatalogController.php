<?php

namespace App\Http\Controllers\Catalog\Get;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_attribute;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CatalogController extends Controller
{
    public function catalog(Request $request, $titleEng = null)
    {

        // dd($titleEng);

        $treeCategories = Category::all();
        $treeCategories->transform(function ($category) {
            $category = $this->buildChildTree($category);
            return $category;
        });
        $treeCategories = $treeCategories->reject(function ($item) {
            return $item->parent_id !== null;
        });

        $watched = new Collection();
        if (Cookie::get("watched")) {
            $tmpBy3 = [];
            for ($i = 0; $i < sizeof(json_decode(Cookie::get("watched"))); $i++) {
                array_push($tmpBy3, Product::find(array_reverse(json_decode(Cookie::get("watched")))[$i]));
                if (($i + 1) % 3 === 0 || sizeof(json_decode(Cookie::get("watched"))) === $i + 1) {
                    $watched->push($tmpBy3);
                    $tmpBy3 = [];
                }
            }
        }


        if ($request->has('q') && $request->q) {
            $words = explode(" ", $request->q);
            $products = Product::where("visibility", 1);
            foreach ($words as $word) {
                $products->where("title", "LIKE", "%{$word}%");
            }
            $products = $products->get();

            if ($products->count() === 1) {
                return redirect()->route("catalog.product", ['title_eng' => $products[0]->title_eng]);
            }

            return view('catalog', [
                'parentCategories' => new Collection(),
                'treeCategories' => $treeCategories,
                'products' => $products,
                'watched' => $watched,
            ]);
        }

        if (!$titleEng) {
            return view('catalog', [
                'parentCategories' => new Collection(),
                'categories' => Category::whereNull("depth")->get(),
                'treeCategories' => $treeCategories,
                'products' => new Collection(),
                'watched' => $watched,
            ]);
        }

        $category = Category::where("title_eng", $titleEng)->first();

        if (!$category) return abort(404);

        $products = Product::select();

        $category->nextLevel = Category::where("parent_id", $category->id)->get();
        // dd($category);
        $category->childList = new Collection();
        $category->childList->push($category);
        $category = $this->buildChildList($category, $category);
        $tmpCategoriesList = [];
        foreach ($category->childList as $child) {
            array_push($tmpCategoriesList, $child->id);
        }
        $products->whereIn("products.category", $tmpCategoriesList);


        $products = $products->get();
        // dd($products);

        $parentCategories = new Collection();
        $tmpCategory = $category;
        while (true) {
            $parentCategories->push($tmpCategory);
            if (!$tmpCategory->parent_id) break;
            $tmpCategory = Category::find($tmpCategory->parent_id);
        }
        $parentCategories = $parentCategories->sortBy("depth");


        return view('catalog', [
            'parentCategories' => $parentCategories,
            'category' => $category,
            'products' => $products,
            'treeCategories' => $treeCategories,
            'watched' => $watched,
        ]);
    }


    public function product($titleEng)
    {
        $product = Product::where("title_eng", $titleEng)->first();
        if (!$product) abort(404);

        $parentCategories = new Collection();
        $tmpCategory = Category::find($product->category);
        while (true) {
            $parentCategories->push($tmpCategory);
            if (!$tmpCategory->parent_id) break;
            $tmpCategory = Category::find($tmpCategory->parent_id);
        }
        $parentCategories = $parentCategories->sortBy("depth");

        $attributes = Product_attribute::where("product", $product->id)->get();

        $reviews = Review::where("product", $product->id)->get();

        $watched = new Collection();
        if (Cookie::get("watched")) {
            $tmpBy3 = [];
            for ($i = 0; $i < sizeof(json_decode(Cookie::get("watched"))); $i++) {
                array_push($tmpBy3, Product::find(array_reverse(json_decode(Cookie::get("watched")))[$i]));
                if (($i + 1) % 3 === 0 || sizeof(json_decode(Cookie::get("watched"))) === $i + 1) {
                    $watched->push($tmpBy3);
                    $tmpBy3 = [];
                }
            }
        }

        return view('product', [
            'product' => $product,
            'parentCategories' => $parentCategories,
            'attributes' => $attributes,
            'reviews' => $reviews,
            'watched' => $watched,
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

    function buildChildTree($item)
    {
        $children = Category::where("parent_id", $item->id)->get();
        $children->transform(function ($child) {
            $this->buildChildTree($child);
            return $child;
        });
        $item->children = $children;
        return $item;
    }
}
