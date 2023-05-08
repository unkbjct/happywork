<?php

namespace App\Http\Controllers\Admin\Get;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_product;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function list(Request $request)
    {
        $request->flash();
        $orders = Order::select();

        if ($request->has('id') && $request->id) $orders->where("id", "=", $request->id);
        if ($request->has('status') && $request->status) $orders->where("status", "=", $request->status);

        if ($request->has('sort')) {
            $orders->orderBy(explode("|", $request->sort)[0], explode("|", $request->sort)[1]);
        } else {
            $orders->orderByDesc("id");
        }

        $orders = $orders->get();

        $countOrders = Order::count();

        return view("admin.orders.list", [
            'orders' => $orders,
            'countOrders' => $countOrders,
        ]);
    }

    public function edit(Order $order)
    {
        $orderProducts = Order_product::where("order_id", $order->id)
            ->join("products", "order_products.product", "=", "products.id")
            ->select("products.title", "products.id", "order_products.count", "order_products.price")
            ->get();

        return view("admin.orders.edit", [
            'order' => $order,
            'orderProducts' => $orderProducts,
        ]);
    }
}
