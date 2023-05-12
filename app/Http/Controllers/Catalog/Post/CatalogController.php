<?php

namespace App\Http\Controllers\Catalog\Post;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Order_product;
use App\Models\Product;
use App\Models\Product_attribute;
use App\Models\Review;
use App\Models\User;
use Faker\Extension\Extension;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function favorite(Request $request)
    {
        if (!Auth::check()) {
            return response([
                'ok' => false,
                'data' => [
                    'errors' => [
                        'auth' => 'Вы должны быть авторизованы, чтобы добавить товар в избранное',
                    ]
                ]
            ], 403);
        }
        $favorites = json_decode(Cookie::get("favorites", '[]'));
        if (in_array($request->product, $favorites)) {
            array_splice($favorites, array_search($request->product, $favorites), 1);
            $message = "Товар удален из избранного";
            $remove = true;
        } else {
            array_push($favorites, $request->product);
            $message = "Товар добавлен в избранное";
            $remove = false;
        }

        return response([
            'ok' => true,
            'message' => $message,
            'data' => [
                'remove' => $remove,
                'count' => sizeof($favorites)
            ]
        ], 200)->withCookie(cookie()->forever('favorites', json_encode($favorites)));
    }

    public function cartAdd(Request $request)
    {
        // Cookie::queue(Cookie::forget('cartCount'));
        // Cookie::queue(Cookie::forget('cart'));
        // return;
        $cart = json_decode(Cookie::get("cart", '[]'));
        $find = false;
        for ($i = 0; $i < sizeof($cart); $i++) {
            if ($cart[$i]->id == $request->product) {
                $find = true;
                break;
            }
        }

        if ($find) {
            $cart[$i]->count = $cart[$i]->count + $request->count;
        } else {
            array_push($cart, [
                'id' => $request->product,
                'count' => $request->count,
            ]);
        }

        $cartCount = Cookie::get('cartCount', 0);
        $cartCount += $request->count;

        $product = Product::find($request->product);

        return response([
            'ok' => true,
            'message' => "Товар успешно добавлен в козрину",
            'data' => [
                'product' => $product,
                'image' => asset($product->image),
            ]
        ], 200)->withCookie(cookie()->forever('cart', json_encode($cart)))->withCookie(cookie()->forever('cartCount', json_encode($cartCount)));
    }

    public function cartEdit(Request $request)
    {
        // Cookie::queue(Cookie::forget('cartCount'));
        // Cookie::queue(Cookie::forget('cart'));
        // return;
        $cart = json_decode(Cookie::get("cart", '[]'));
        $cartCount = Cookie::get('cartCount', 0);

        foreach ($cart as $cartItem) {
            if ($cartItem->id == $request->product) {
                $cartCount -= $cartItem->count;
                $cartItem->count = $request->count;
                $cartCount += $cartItem->count;
            };
        }
        return response([
            'ok' => true,
            'message' => "Корзина была изменена",
            'data' => []
        ], 200)->withCookie(cookie()->forever('cart', json_encode($cart)))->withCookie(cookie()->forever('cartCount', json_encode($cartCount)));
    }

    public function cartRemove(Request $request)
    {
        $cart = json_decode(Cookie::get("cart", '[]'));
        $cartCount = Cookie::get('cartCount', 0);


        if (sizeof($cart) === 1) {
            Cookie::queue(Cookie::forget('cartCount'));
            Cookie::queue(Cookie::forget('cart'));
        } else {
            for ($i = 0; $i < sizeof($cart); $i++) {
                if ($cart[$i]->id == $request->product) {
                    $cartCount -= $cart[$i]->count;
                    break;
                };
            }
            array_splice($cart, $i, 1);
        }

        return response([
            'ok' => true,
            'message' => "Товар удален из корзины",
            'data' => []
        ], 200)->withCookie(cookie()->forever('cart', json_encode($cart)))->withCookie(cookie()->forever('cartCount', json_encode($cartCount)));
    }

    public function cartClear()
    {
        Cookie::queue(Cookie::forget('cart'));
        Cookie::queue(Cookie::forget('cartCount'));

        return response([
            'ok' => true,
            'message' => "Корзина пуста",
            'data' => []
        ], 200);
    }

    public function order(Request $request)
    {

        $validation = $request->validate([
            'name' => 'required|max:222',
            'phone' => 'required|max:222',
        ], [], [
            'name' => 'Имя',
            'phone' => 'Телефон',
        ]);

        $order = new Order();
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->city = $request->city;
        $order->street = $request->street;
        $order->house = $request->house;
        $order->apart = $request->apart;
        $order->comment = $request->comment;
        $order->delivery = $request->delivery;
        $order->amount = $request->amount;
        $order->delivery_price = $request->delivery_price;
        $order->user = $request->user;
        $order->save();

        $cart = json_decode(Cookie::get("cart", '[]'));

        foreach ($cart as $cartItem) {
            $tmpProduct = Product::find($cartItem->id);
            $orderProduct = new Order_product();
            $orderProduct->order_id = $order->id;
            $orderProduct->product = $tmpProduct->id;
            $orderProduct->count = $cartItem->count;
            $orderProduct->price = ($tmpProduct->sale) ? $tmpProduct->sale : $tmpProduct->price;
            $orderProduct->save();
        }

        Cookie::queue(Cookie::forget('cart'));
        Cookie::queue(Cookie::forget('cartCount'));



        return response([
            'ok' => true,
            'message' => "Заказ успешно создан",
            'data' => [
                'url' => route('user.history'),
            ]
        ], 200);
    }

    public function catalog(Request $request, $titleEng = null)
    {

        $treeCategories = Category::all();
        $treeCategories->transform(function ($category) {
            $category = $this->buildChildTree($category);
            return $category;
        });
        $treeCategories = $treeCategories->reject(function ($item) {
            return $item->parent_id !== null;
        });

        if ($request->has('q') && $request->q) {
            $words = explode(" ", $request->q);
            $products = Product::where("visibility", 1);
            foreach ($words as $word) {
                $products->where("title", "LIKE", "%{$word}%");
            }
            $products = $products->get();

            return response([
                'ok' => true,
                'message' => null,
                'data' => [
                    'categories' => new Collection(),
                    'parentCategories' => new Collection(),
                    'treeCategories' => $treeCategories,
                    'products' => $products,
                ]
            ], 200);
        }


        if (!$titleEng) {
            return response([
                'ok' => true,
                'message' => null,
                'data' => [
                    'parentCategories' => new Collection(),
                    'categories' => Category::whereNull("depth")->get(),
                    'treeCategories' => $treeCategories,
                    'products' => new Collection(),
                ]
            ], 200);
        }

        $category = Category::where("title_eng", $titleEng)->first();

        if (!$category) return abort(404);

        $products = Product::select();

        $category->nextLevel = Category::where("parent_id", $category->id)->get();
        $category->childList = new Collection();
        $category->childList->push($category);
        $category = $this->buildChildList($category, $category);


        $tmpCategoriesList = [];
        foreach ($category->childList as $child) {
            array_push($tmpCategoriesList, $child->id);
        }
        $category->childList = new Collection();

        $products->whereIn("products.category", $tmpCategoriesList);
        $products = $products->where("visibility", 1)->get();

        $parentCategories = new Collection();
        $tmpCategory = $category;
        while (true) {
            $parentCategories->push($tmpCategory);
            if (!$tmpCategory->parent_id) break;
            $tmpCategory = Category::find($tmpCategory->parent_id);
        }
        $parentCategories = $parentCategories->sortBy("depth");


        // dd($category);

        return response([
            'ok' => true,
            'message' => null,
            'data' => [
                'parentCategories' => $parentCategories,
                'category' => $category,
                'products' => $products,
                'treeCategories' => $treeCategories,
            ]
        ], 200);
    }

    public function product(Product $product)
    {
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

        return response([
            'ok' => true,
            'message' => null,
            'data' => [
                'product' => $product,
                'parentCategories' => $parentCategories,
                'attributes' => $attributes,
                'reviews' => $reviews,
            ]
        ], 200);
    }


    public function productsIn(Request $request)
    {
        $products = Product::whereIn("id", $request->products)->orderByDesc("id")->get();
        return response([
            'ok' => true,
            'message' => null,
            'data' => [
                'products' => $products,
            ]
        ], 200);
    }

    public function history(Request $request)
    {
        $user = User::where("api_token", $request->apiToken)->first();

        $orders = Order::where("user", $user->id)->orWhere("phone", $user->phone)->orderByDesc("id")->get();
        return response([
            'ok' => true,
            'message' => null,
            'data' => [
                'orders' => $orders,
            ]
        ], 200);
    }

    public function orderInfo(Request $request)
    {
        $order = Order::find($request->order);

        $orderProducts = Order_product::where("order_id", $order->id)
            ->join("products", "order_products.product", "=", "products.id")
            ->select("products.title", "products.id", "order_products.count", "order_products.price")
            ->get();

        return response([
            'ok' => true,
            'message' => null,
            'data' => [
                'order' => $order,
                'orderProducts' => $orderProducts,
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
