<?php

namespace App\Http\Controllers\Admin\Get;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class CategoriesController extends Controller
{
    public function list(Request $request)
    {
        $request->flash();

        $categories = Category::select()->orderByDesc('id');
        if ($request->has('id') && $request->id) $categories->where("id", "=", $request->id);
        if ($request->has('title') && $request->title) $categories->where("title", "LIKE", "%{$request->title}%");
        $categories = $categories->get();

        $treeCategories = Category::all();

        $countCategories = Category::count();

        $categories->transform(function ($category) {
            $category->parent_title = ($category->parent_id) ? Category::find($category->parent_id)->title : 'нет';
            return $category;
        });

        $treeCategories->transform(function ($category) {
            $category = $this->buildChildTree($category);
            return $category;
        });

        $treeCategories = $treeCategories->reject(function ($item) {
            return $item->parent_id !== null;
        });

        // dd($categories);

        return view('admin.categories.list', [
            'countCategories' => $countCategories,
            'categories' => $categories,
            'treeCategories' => $treeCategories,
        ]);
    }

    public function create(Request $request)
    {
        $categories = Category::select()->orderBy('title')->get();

        return view('admin.categories.create', [
            'categories' => $categories,
        ]);
    }



    public function edit(Category $category)
    {
        $categories = Category::select()->orderBy('title')->get();

        $category->childList = new Collection();
        $category = $this->buildChildList($category, $category);

        foreach ($categories as $key => $value) {
            if ($value->id == $category->id) $categories->forget($key);
            foreach ($category->childList as $thiscCategoryChild) {
                if ($value->id == $thiscCategoryChild->id) {
                    $categories->forget($key);
                    break;
                }
            }
        }

        return view('admin.categories.edit', [
            'thisCategory' => $category,
            'categories' => $categories,
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

    function filter(Object $list, Request $request): Object
    {
        $request->flash();
        foreach ($request->input() as $key => $value) {
            if ($key === "_token") continue;
            if ($value === null) continue;
            if (str_contains($key, "id")) {
                $list->where(str_replace("_", ".", $key), $value);
                continue;
            }
            $list->where(str_replace("_", ".", $key), "like", "%{$value}%");
        }
        return $list->orderByDesc('id');
    }
}
