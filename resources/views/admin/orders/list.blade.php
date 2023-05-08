@extends('layouts.admin')

@section('title')
    Заказы
@endsection

@section('admin')
    <div class="container-fluid">
        <section class="mb-5">
            <div class="col-lg-7">
                <h1>Заказы</h1>
                <small>Всего заказов: {{ $countOrders }}</small>
            </div>
        </section>
        <section class="mb-3">
            <form action="{{ route('admin.orders.list') }}" method="get">
                <div class="d-flex flex-wrap">
                    <div class="me-2">
                        <input type="text" name="id" value="{{ old('id') }}" class="form-control"
                            placeholder="Идентификатор">
                    </div>
                    <div class="me-2">
                        <select name="sort" class="form-select">
                            <option @if (old('sort') == 'created_at|desc') selected @endif value="created_at|desc">Сначала новые
                            </option>
                            <option @if (old('sort') == 'created_at|asc') selected @endif value="created_at|asc">Сначала старые
                            </option>
                        </select>
                    </div>
                    <div class="me-2">
                        <select name="status" class="form-select">
                            <option value="" selected class="text-muted">Статус заказа</option>
                            <option @if (old('status') == 'created') selected @endif value="created">Новый</option>
                            <option @if (old('status') == 'cancaled') selected @endif value="cancaled">Отменен</option>
                            <option @if (old('status') == 'in_road') selected @endif value="in_road">В пути</option>
                            <option @if (old('status') == 'expecting') selected @endif value="expecting">Ожидает</option>
                            <option @if (old('status') == 'completed') selected @endif value="completed">Доставлен</option>
                        </select>
                    </div>
                    <div class="me-3">
                        <a href="{{ route('admin.orders.list') }}" class="btn btn-outline-dark">сбросить</a>
                        <button type="submit" class="btn btn-dark">применить</button>
                    </div>
                </div>
            </form>
        </section>
        <section>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">номер</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Получатель</th>
                        <th scope="col">Телефон</th>
                        <th scope="col">Дата</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <th scope="row">{{ $order->id }}</th>
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
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->phone }}</td>
                            {{-- <td>{{ $category->title }}</td> --}}
                            <td>{{ date_format(date_create($order->created_at), 'd.m.Y') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.edit', ['order' => $order->id]) }}"
                                    class="btn btn-dark btn-sm">Подробнее</a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="fs-5 text-center py-5">
                                    <div class="mb-3">Заказы не найдены</div>
                                    <a href="{{ route('admin.orders.list') }}" class="btn btn-dark btn-sm">Сбросить
                                        фильтры</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        </div>
    @endsection
