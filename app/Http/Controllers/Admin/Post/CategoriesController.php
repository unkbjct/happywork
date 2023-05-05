<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function create(Request $request)
    {
        $validation = $request->validate([
            'title' => 'required|unique:categories',
            'image' => 'required|image',
        ], [], [
            'title' => 'Название категории',
            'image' => 'Изображение',
        ]);

        $path = $request->file('image')->store('/images/categories/' . Str::slug($request->title, '-'), 'public');

        $category = new Category();
        $category->title = $request->title;
        $category->title_eng = Str::slug($request->title, '-');
        $category->image = 'public/storage/' . $path;
        $category->parent_id = ($request->parent) ? $request->parent : null;
        $category->depth = ($request->parent) ? Category::find($request->parent)->depth + 1 : null;
        $category->save();

        return response([
            'ok' => true,
            'message' => 'Категория добавлена успешно',
            'data' => [
                'url' => route('admin.categories.list'),
            ]
        ], 200);
    }

    public function edit(Request $request, Category $category)
    {
        $validation = $request->validate([
            'title' => 'required',
            // 'image' => 'required|image',
        ], [], [
            'title' => 'Название категории',
            // 'image' => 'Изображение',
        ]);

        $errs = [];
        if ($category->title != $request->title && Category::where('title', $request->title)->first()) $errs['title'] = 'Данное название категории уже используется!';
        if ($errs) {
            return response([
                'ok' => false,
                'data' => [
                    'errors' => $errs
                ]
            ], 422);
        };

        if ($request->hasFile('image')) {
            Storage::delete(str_replace("public/storage/", "public/", $category->image));
            $path = $request->file('image')->store('/images/categories/' . Str::slug($request->title, '-'), 'public');
            $category->image = 'public/storage/' . $path;
        }


        $category->title = $request->input('titleRus');
        $category->title = $request->title;
        $category->title_eng = Str::slug($request->title, '-');
        // $category->visibility = $request->visibility;
        $category->parent_id = ($request->parent) ? $request->parent : null;
        $category->depth = ($request->parent) ? Category::find($request->parent)->depth + 1 : null;
        $category->save();

        return response([
            'ok' => true,
            'message' => 'Категория отредактирована успешно!',
            'data' => [
                'url' => route('admin.categories.list'),
            ]
        ], 200);
    }


    public function remove(Category $category)
    {
        // $category->childList = new Collection();
        // $category->childList->push($category);
        // $category = $this->buildChildList($category, $category);
        // foreach ($category->childList as $child) {
        //     $products = Product::where("category", $category->id)->get();
        //     if ($products->isNotEmpty()) {
        //         return response([
        //             'ok' => false,
        //             'data' => [
        //                 'errors' => [
        //                     'error' => 'Категорию нельзя удалить. У этой категроии или у дочерних категорий есть товары, сначала удалите их!',
        //                 ]
        //             ]
        //         ], 422);
        //     }
        // }



        $category->delete();



        return response([
            'ok' => true,
            'message' => 'Категория удалена успешно!',
            'data' => [
                'url' => route('admin.categories.list'),
            ]
        ], 200);
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
