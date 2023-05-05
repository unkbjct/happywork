<?php

namespace App\Http\Controllers\Catalog\Post;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CatalogController extends Controller
{
    public function review(Request $request, Product $product)
    {
        $validation = $request->validate([
            'name' => 'required|max:222',
            'comment' => 'required|max:5000',
            'userId' => 'required',
            'rating' => 'required',
        ], [], [
            'name' => 'Имя',
            'comment' => 'Комментарий',
            'userId' => 'Быть авторизованным',
            'rating' => 'Оценка товара',
        ]);

        $review = new Review();
        $review->product = $product->id;
        $review->user = $request->userId;
        $review->name = $request->name;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->type = $request->type;
        $review->save();

        $product->rating_count = $product->rating_count + 1;
        $product->rating_sum = $product->rating_sum + $request->rating;
        $product->rating = $product->rating_sum / $product->rating_count;
        $product->save();

        return response([
            'ok' => true,
            'message' => 'Отзыв добавлен успешно',
            'data' => []
        ], 200);
    }


    public function watched(Request $request)
    {
        // Cookie::queue(Cookie::forget('watched'));
        $watched = json_decode(Cookie::get("watched", '[]'));
        if (array_search($request->product, $watched) !== false) array_splice($watched, array_search($request->product, $watched), 1);
        array_push($watched, $request->product);
        if (sizeof($watched) > 12) array_splice($watched, 0, 1);
        return response([
            'ok' => true,
            'message' => $watched,
            'data' => []
        ], 200)->withCookie(cookie()->forever('watched', json_encode($watched)));
    }
}
