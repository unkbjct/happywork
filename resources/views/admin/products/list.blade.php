@extends('layouts.admin')

@section('title')
    Товары
@endsection

@section('admin')
    <div class="container-fluid">
        <section class="mb-5">
            <h1>Товары</h1>
            <small>Всего товаров: {{ $countProducts }}</small>
            <div class="mt-2">
                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-outline-dark">Добавить новый товар</a>
            </div>
        </section>
        <section class="mb-3">
            <form action="{{ route('admin.products.list') }}" method="get">
                <div class="d-flex flex-wrap">
                    <div class="me-2">
                        <input type="text" name="id" value="{{ old('value') }}" class="form-control"
                            placeholder="Идентификатор">
                    </div>
                    <div class="me-2">
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control"
                            placeholder="Название">
                    </div>
                    <div class="me-2">
                        <select class="form-select" name="category" id="category">
                            <option value="">Категория</option>
                            @foreach ($categories as $category)
                                <option @if (old('category') == $category->id) selected @endif
                                    data-attributes="{{ $category->parentAttributes }}" value="{{ $category->id }}">
                                    {{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="me-3">
                        <a href="{{ route('admin.products.list') }}" class="btn btn-outline-dark">сбросить</a>
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
                        <th scope="col">название</th>
                        <th scope="col">Категория</th>
                        <th scope="col">цена (₽)</th>
                        <th scope="col">Количество</th>
                        <th scope="col">цена по акции</th>
                        <th scope="col">рейтинг</th>
                        {{-- <th scope="col">показывае</th> --}}
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <th scope="row">{{ $product->id }}</th>
                            <td>
                                <a href="{{ route('admin.products.edit', ['product' => $product->id]) }}">
                                    {{ $product->title }}
                                </a>
                            </td>
                            <td>
                                <a
                                    href="{{ route('admin.categories.edit', ['category' => $product->category_id]) }}">{{ $product->category_title }}</a>
                            </td>
                            {{-- <td>{{ $category->title }}</td> --}}
                            <td>{{ number_format($product->price, 0, 0, ' ') }}</td>
                            <td>{{ $product->count }}</td>
                            <td>{{ $product->sale ? number_format($product->sale, 0, 0, ' ') . ' ₽' : 'нет' }}</td>
                            <td>{{ $product->rating }} ({{ $product->rating_count }})</td>
                            <td>
                                <a href="{{ route('admin.products.edit', ['product' => $product->id]) }}"
                                    class="btn btn-dark btn-sm">Подробнее</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="fs-5 text-center py-5">
                                <div class="mb-3">товары не найдены</div>
                                <a href="{{ route('admin.products.list') }}" class="btn btn-dark btn-sm">Сбросить
                                    фильтры</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>
@endsection
