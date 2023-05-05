@extends('layouts.admin')

@section('title')
    Категории
@endsection

@section('admin')
    <div class="container-fluid">
        <section class="mb-5">
            <div class="col-lg-7">
                <h1>Категории товаров</h1>
                <small>Всего категорий: {{ $countCategories }}</small>
                <div class="mt-2 mb-2">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-outline-dark">Добавить новую
                        категорию</a>
                    <button class="btn btn-dark btn-sm" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTree">Показать/Скрыть дерево категорий</button>
                </div>
                <div class="py-3">
                    <div class="collapse" id="collapseTree">
                        <div class="card card-body">
                            @each('components.categoryTree', $treeCategories, 'category')
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mb-3">
            <form action="{{ route('admin.categories.list') }}" method="get">
                <div class="d-flex flex-wrap">
                    <div class="me-2">
                        <input type="text" name="id" value="{{ old('value') }}" class="form-control"
                            placeholder="Идентификатор">
                    </div>
                    <div class="me-2">
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control"
                            placeholder="Название категории">
                    </div>
                    <div class="me-3">
                        <a href="{{ route('admin.categories.list') }}" class="btn btn-outline-dark">сбросить</a>
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
                        {{-- <th scope="col">показывае</th> --}}
                        <th scope="col">Родительская категория</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <th scope="row">{{ $category->id }}</th>
                            <td>{{ $category->title }}</td>
                            {{-- <td>{{ $category->title }}</td> --}}
                            <td>{{ $category->parent_title }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', ['category' => $category->id]) }}"
                                    class="btn btn-dark btn-sm">Подробнее</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="fs-5 text-center py-5">
                                <div class="mb-3">Категории не найдены</div>
                                <a href="{{ route('admin.categories.list') }}" class="btn btn-dark btn-sm">Сбросить
                                    фильтры</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
        <section class="my-5">

        </section>
    </div>
@endsection
