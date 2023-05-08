@extends('layouts.main')

@section('main')
    <div class="container">
        <section class="mb-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-secondary" href="{{ route('home') }}">Главная</a></li>
                    <li class="breadcrumb-item"><a class="text-secondary" href="{{ route('user.history') }}">Мои заказы</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Карточка заказа</li>
                </ol>
            </nav>
        </section>
        <section>
            <div class="card card-body">
                <div class="mb-3">
                    <h1 class="h3">Карточка заказа</h1>
                </div>
                <div>
                    <div class="fw-semibold fs-5 mb-4">Заказ № {{ $order->id }}</div>

                    <ul class="list-group mb-5">
                        <li class="list-group-item p-0">
                            <div class="row">
                                <div class="col-lg-6 p-2 border-end text-end">
                                    Создан:
                                </div>
                                <div class="col-lg-6 p-2">
                                    {{ $order->created_at }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item p-0" style="background-color: #f8f9fa">
                            <div class="row">
                                <div class="col-lg-6 p-2 border-end text-end">
                                    Сумма заказа:
                                </div>
                                <div class="col-lg-6 p-2">
                                    {{ number_format($order->amount, 0, 0, ' ') }} рублей
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item p-0">
                            <div class="row">
                                <div class="col-lg-6 p-2 border-end text-end">
                                    Способ доставки:
                                </div>
                                <div class="col-lg-6 p-2">
                                    {{ $order->delivery }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item p-0" style="background-color: #f8f9fa">
                            <div class="row">
                                <div class="col-lg-6 p-2 border-end text-end">
                                    Стоимость доставки:
                                </div>
                                <div class="col-lg-6 p-2">
                                    {{ number_format($order->delivery_price, 0, 0, ' ') }} рублей
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item p-0">
                            <div class="row">
                                <div class="col-lg-6 p-2 border-end text-end">
                                    Имя получателя:
                                </div>
                                <div class="col-lg-6 p-2">
                                    {{ $order->name }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item p-0" style="background-color: #f8f9fa">
                            <div class="row">
                                <div class="col-lg-6 p-2 border-end text-end">
                                    Телефон:
                                </div>
                                <div class="col-lg-6 p-2">
                                    {{ $order->phone }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item p-0">
                            <div class="row">
                                <div class="col-lg-6 p-2 border-end text-end">
                                    Почта:
                                </div>
                                <div class="col-lg-6 p-2">
                                    {{ $order->email ? $order->email : 'Не указан' }}
                                </div>
                            </div>
                        </li>
                        @if ($order->delivery == 'Курьером в черте города' || $order->delivery == 'Курьером по Новгородской области')
                            <li class="list-group-item p-0" style="background-color: #f8f9fa">
                                <div class="row">
                                    <div class="col-lg-6 p-2 border-end text-end">
                                        Город доставки:
                                    </div>
                                    <div class="col-lg-6 p-2">
                                        {{ $order->city ? $order->city : 'Не указан' }}
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item p-0">
                                <div class="row">
                                    <div class="col-lg-6 p-2 border-end text-end">
                                        Адрес доставки:
                                    </div>
                                    <div class="col-lg-6 p-2">
                                        {{ $order->street ? "$order->street, $order->house, кв $order->apart" : 'Не указан' }}
                                    </div>
                                </div>
                            </li>
                        @endif
                        <li class="list-group-item p-0" style="background-color: #f8f9fa">
                            <div class="row">
                                <div class="col-lg-6 p-2 border-end text-end">
                                    Комментарий:
                                </div>
                                <div class="col-lg-6 p-2">
                                    {{ $order->comment ? $order->comment : 'нет' }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item p-0">
                            <div class="row">
                                <div class="col-lg-6 p-2 border-end text-end">
                                    Статус заказа:
                                </div>
                                <div class="col-lg-6 p-2">
                                    @switch($order->status)
                                        @case('created')
                                            Новый
                                        @break

                                        @case('in_road')
                                            'В процессе доставки'
                                        @break

                                        @case('expecting')
                                            'В процессе доставки'
                                        @break

                                        @case('canceled')
                                            'Отменен'
                                        @break

                                        @default
                                            'Получен'
                                    @endswitch
                                </div>
                            </div>
                        </li>
                    </ul>

                    <div class="fw-semibold fs-5 mb-4">Позиции товара</div>
                    <table class="table table-bordered fw-normal text-center mb-4">
                        <thead>
                            <tr style="background-color: #f8f9fa">
                                <td>Название товара</td>
                                <td>Цена</td>
                                <td>Кол-во</td>
                                <td>Общая сумма</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderProducts as $product)
                                <tr>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ number_format($product->price, 0, 0, ' ') }} Рублей.</td>
                                    <td>{{ $product->count }} шт.</td>
                                    <td>{{ number_format($product->price * $product->count, 0, 0, ' ') }} Рублей.</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>Доставка ({{ $order->delivery }})</td>
                                <td>{{ number_format($order->delivery_price, 0, 0, ' ') }} Рублей.</td>
                                <td>{{ 1 }} шт.</td>
                                <td>{{ number_format($order->delivery_price, 0, 0, ' ') }} Рублей.</td>
                            </tr>
                            <tr style="background-color: #f8f9fa">
                                <td colspan="2" class="text-end">Итого:</td>
                                <td colspan="2">{{ number_format($order->amount + $order->delivery_price, 0, 0, ' ') }}
                                    Рублей.</td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="{{route('user.history')}}" class="btn btn-dark">Назад</a>
                </div>
            </div>
        </section>
    </div>
@endsection
