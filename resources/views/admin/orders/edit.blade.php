@extends('layouts.admin')

@section('title')
    Заказ № {{ $order->id }}
@endsection

@section('script-code')
    <script>
        $("#btn-save").click(function() {
            $.ajax({
                url: "{{ route('api.admin.orders.edit', ['order' => $order->id]) }}",
                method: 'post',
                data: {
                    status: $("#status").val(),
                },
                success: response => {
                    showAlert([response.message], 'alert-success')
                    localStorage.setItem("message-success", response.message)
                    location.reload();
                },
                error: response => {
                    console.log(response)
                }
            })
        })
    </script>
@endsection

@section('admin')
    <div class="container-fluid">

        <section>
            <div class="row g-0 gy-4">
                <div class="col-lg-6 px-4">
                    <div class="mb-3">
                        <h1>Заказ № {{ $order->id }}</h1>
                    </div>
                    <div class="mb-5">
                        <a href="{{ route('admin.orders.list') }}" class="btn btn-sm btn-outline-dark">Назад</a>
                    </div>
                </div>
                <div class="col-lg-6 border-start">
                    <div class="px-4">
                        <div class="mb-3 me-5">
                            <span>Статус заказ: </span>
                            <span class="fw-semibold">
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
                            </span>
                        </div>
                        <div class="mb-3 me-3">
                            <label for="status" class="form-label me-2">Изменить статус заказа</label>
                            <select name="" id="status" class="form-select form-select-sm">
                                <option @if ($order->status == 'created') selected @endif value="created">Новый</option>
                                <option @if ($order->status == 'in_road') selected @endif value="in_road">В пути</option>
                                <option @if ($order->status == 'expecting') selected @endif value="expecting">Ожидает получателя
                                </option>
                                <option @if ($order->status == 'completed') selected @endif value="completed">Получен</option>
                                <option @if ($order->status == 'canceled') selected @endif value="canceled">Отменен</option>
                            </select>
                        </div>
                        <button class="btn btn-sm btn-outline-dark" id="btn-save"
                            data-oreder-id="{{ $order->id }}">Сохранить</button>
                    </div>
                </div>
            </div>
        </section>
        <section class="mb-4">
        </section>

        <section class="border p-4">
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
    </div>
    </div>
@endsection
