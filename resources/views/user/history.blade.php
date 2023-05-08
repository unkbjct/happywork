@extends('layouts.user')

@section('title')
    Мои заказы
@endsection

@section('script-code')
    <script></script>
@endsection

@section('user')
    <div class="p-3">
        <div class="mb-4">
            <h1 class="h3">Мои заказы</h1>
        </div>
        <div class="table-responsive-xl">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Получатель</th>
                        <th scope="col">Сумма заказа</th>
                        <th scope="col">Статус заказа</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <th scope="row">{{ $order->id }}</th>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->name }}</td>
                            <td>{{ number_format($order->amount + $order->delivery_price, 0, 0, ' ') }} ₽</td>
                            <td>
                                @switch($order->status)
                                    @case('created')
                                        Новый
                                    @break

                                    @case('in_road')
                                        В пути
                                    @break

                                    @case('expecting')
                                        Ожидает получателя
                                    @break

                                    @case('canceled')
                                        Отменен
                                    @break

                                    @default
                                        Получен
                                @endswitch
                            </td>
                            <td><a href="{{ route('user.order.info', ['order' => $order->id]) }}"
                                    class="btn btn-dark btn-sm">Детали</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
