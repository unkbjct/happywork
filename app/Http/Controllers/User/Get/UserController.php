<?php

namespace App\Http\Controllers\User\Get;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Order_product;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    public function signup()
    {
        return view('user.signup');
    }

    public function login()
    {
        return view('user.login');
    }

    public function profile()
    {


        return view('user.profile', [
            'sectionName' => 'Мой кабинет',
            'treeCategories' => $this->categoriesTree(),
            'parentCategories' => new Collection(),
        ]);
    }

    public function favorite()
    {

        $products = Product::whereIn("id", json_decode(Cookie::get('favorites', '[]')))->get();

        return view('user.favorite', [
            'sectionName' => 'Избранные товары',
            'treeCategories' => $this->categoriesTree(),
            'parentCategories' => new Collection(),
            'products' => $products,
        ]);
    }

    public function history()
    {

        $orders = Order::where("user", Auth::user()->id)->orWhere("phone", Auth::user()->phone)->orderByDesc("id")->get();
        // $orderProducts = Order_product

        return view('user.history', [
            'sectionName' => 'Мои заказы',
            'treeCategories' => $this->categoriesTree(),
            'parentCategories' => new Collection(),
            'orders' => $orders,
        ]);
    }

    public function cart()
    {
        $cart = json_decode(Cookie::get('cart', '[]'));
        $products = new Collection();
        $amount = 0;

        foreach ($cart as $cartItem) {
            $tmpProduct = Product::find($cartItem->id);
            $tmpProduct->cartCount = $cartItem->count;
            $tmpProduct->currentPrice = $tmpProduct->sale ? $tmpProduct->sale : $tmpProduct->price;
            $products->push($tmpProduct);
            $amount += $cartItem->count * (($tmpProduct->sale) ? $tmpProduct->sale : $tmpProduct->price);
        }

        return view('user.cart', [
            'products' => $products,
            'amount' => $amount,
        ]);
    }

    public function order(Order $order)
    {

        $orderProducts = Order_product::where("order_id", $order->id)
            ->join("products", "order_products.product", "=", "products.id")
            ->select("products.title", "products.id", "order_products.count", "order_products.price")
            ->get();

        return view('user.order', [
            'order' => $order,
            'orderProducts' => $orderProducts,
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function categoriesTree()
    {
        $treeCategories = Category::all();
        $treeCategories->transform(function ($category) {
            $category = $this->buildChildTree($category);
            return $category;
        });
        $treeCategories = $treeCategories->reject(function ($item) {
            return $item->parent_id !== null;
        });
        return $treeCategories;
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
