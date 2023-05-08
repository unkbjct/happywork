@extends('layouts.main')

@section('styles')
    <link rel="stylesheet" href="{{ asset('public/css/catalog.css') }}">
@endsection

@section('main')
    <div class="container">
        <section class="mb-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-secondary" href="{{ route('home') }}">Главная</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $sectionName }}</li>
                </ol>
            </nav>
        </section>
        <section class="border">
            <div class="row g-0">
                <div class="col-lg-3 border-end">
                    <div class="pt-4 px-2">

                        <div class="profile-nav">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link ps-2 py-1 text-dark" aria-current="page" href="#">
                                        <h5>Меню</h5>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link ps-2 py-1 text-dark  @if (Route::currentRouteName() == 'user.profile') active @endif"
                                        aria-current="page" href="{{ route('user.profile') }}">Мой кабинет</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link ps-2 py-1 text-dark  @if (Route::currentRouteName() == 'user.favorite') active @endif"
                                        href="{{ route('user.favorite') }}">Избранное</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link ps-2 py-1 text-dark  @if (Route::currentRouteName() == 'user.history') active @endif"
                                        href="{{ route('user.history') }}">История
                                        заказов</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link ps-2 py-1 text-dark" href="{{ route('user.logout') }}">Выход</a>
                                </li>
                            </ul>
                            <div class="pt-4 px-2 mb-4">
                                <a class="text-dark text-decoration-none" href="{{ route('catalog') }}">
                                    <h5>Каталог</h5>
                                </a>
                                <div class="categories-tree">
                                    @foreach ($treeCategories as $treeItem)
                                        @include('components.catalogCategoryTree')
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    @yield('user')
                </div>
            </div>
        </section>
    </div>
@endsection
