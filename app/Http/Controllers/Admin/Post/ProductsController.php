<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Product_attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function create(Request $request)
    {
        $validation = $request->validate([
            'title' => 'required|unique:products',
            'image' => 'required|image',
            'price' => 'required|numeric',
            'count' => 'required|numeric',
            'category' => 'required',
            'description' => 'max:5000',
        ], [], [
            'title' => 'Название',
            'image' => 'Изображение',
            'price' => 'Цена',
            'count' => 'Количество',
            'category' => 'Категория',
            'description' => 'Описание',
        ]);

        $path = $request->file('image')->store('images/products/' . Str::slug($request->title, '-'), 'public');

        $product = new Product();
        $product->title = $request->title;
        $product->title_eng = Str::slug($request->title, '-');
        $product->price = $request->price;
        $product->sale = $request->sale;
        $product->count = $request->count;
        $product->category = $request->category;
        $product->description = $request->description;
        $product->image = "public/storage/{$path}";
        $product->save();

        return response([
            'ok' => true,
            'message' => 'Товар добавлен успешно',
            'data' => [
                'url' => route('admin.products.list'),
            ]
        ], 200);
    }

    public function edit(Request $request, Product $product)
    {
        $validation = $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'count' => 'required|numeric',
            'category' => 'required',
            'description' => 'max:5000',
        ], [], [
            'title' => 'Название',
            'price' => 'Цена',
            'count' => 'Количество',
            'category' => 'Категория',
            'description' => 'Описание',
        ]);

        $errs = [];
        if ($product->title != $request->title && Product::where("title", $request->title)->first()) $errs['title'] = 'Данное название категории уже используется!';
        if ($errs) {
            return response([
                'ok' => false,
                'data' => [
                    'errors' => $errs
                ]
            ], 422);
        };


        if ($request->hasFile('image')) {
            Storage::delete(str_replace("public", "", $product->image));
            $path = $request->file('image')->store('images/products/' . Str::slug($request->title, '-'), 'public');
            $product->image = "public/storage/{$path}";
        }

        if ($product->title != $request->title) {
            $product->title = $request->title;
            $product->title_eng = Str::slug($request->title, '-');
        }
        if ($product->price != $request->price) $product->price = $request->price;
        if ($product->sale != $request->sale) $product->sale = $request->sale;
        if ($product->count != $request->count) $product->count = $request->count;
        if ($product->category != $request->category) $product->category = $request->category;
        if ($product->status != $request->status) $product->status = $request->status;
        if ($product->visibility != $request->visibility) $product->visibility = $request->visibility;
        if ($product->description != $request->description) $product->description = $request->description;
        $product->save();

        Product_attribute::where("product", $product->id)->delete();


        if ($request->has('attributes')) {
            foreach ($request->input('attributes') as $title => $value) {
                $prodAttr = new Product_attribute();
                $prodAttr->product = $product->id;
                $prodAttr->title = $title;
                $prodAttr->value = $value;
                $prodAttr->save();
            }
        }


        return response([
            'ok' => true,
            'message' => 'Товар отредактирован успешно',
            'data' => []
        ], 200);
    }

    public function remove(Request $request, Product $product)
    {
        $product->delete();

        return response([
            'ok' => true,
            'message' => 'Товар удалена успешно!',
            'data' => [
                'url' => route('admin.products.list'),
            ]
        ], 200);
    }
}
