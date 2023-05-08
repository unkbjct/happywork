<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function edit(Request $request, Order $order)
    {
        $order->status = $request->status;
        $order->save();

        return response([
            'ok' => true,
            'message' => 'Заказ успрешно изменен',
            'data' => []
        ], 200);
    }
}
