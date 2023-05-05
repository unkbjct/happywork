@extends('layouts.main')

@section('title')
    Каталог
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('public/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/catalog.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('public/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('public/js/catalog.js') }}"></script>
@endsection

@section('main')
    <div class="container">
        <section class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-secondary" href="{{ route('home') }}">Главная</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a class="text-secondary"
                            href="{{ route('catalog') }}">Каталог</a></li>
                    @foreach ($parentCategories as $parentCategory)
                        <li class="breadcrumb-item active" aria-current="page"><a class="text-secondary"
                                href="{{ route('catalog.search', ['title_eng' => $parentCategory->title_eng]) }}">{{ $parentCategory->title }}</a>
                        </li>
                    @endforeach
                </ol>
            </nav>
        </section>
        <section class="border">
            <div class="swiper swiper-promo">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img class="w-100" src="{{ asset('public/storage/images/promo/catalog/slide-1-catalog.jpg') }}">
                    </div>
                    <div class="swiper-slide">
                        <img class="w-100" src="{{ asset('public/storage/images/promo/catalog/slide-2-catalog.jpg') }}">
                    </div>
                </div>
            </div>
            <div class="row gy-0">
                <div class="col-lg-3">
                    <div class="pt-4 px-3 mb-4">
                        <a class="text-dark text-decoration-none" href="{{ route('catalog') }}">
                            <h5>Каталог</h5>
                        </a>
                        <div class="categories-tree">
                            @foreach ($treeCategories as $treeItem)
                                @include('components.catalogCategoryTree')
                            @endforeach
                        </div>
                    </div>
                    <div class="pt-4 px-3">
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 m-0">Вы смотрели</span>
                            <div class="arrows">
                                <div class="arrow hit-back">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                                        <path
                                            d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z" />
                                    </svg>
                                </div>
                                <div class="arrow hit-next">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                        <path
                                            d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="swiper swiper-watched">
                            <div class="swiper-wrapper">
                                @foreach ($watched as $watch)
                                    <div class="swiper-slide">
                                        @foreach ($watch as $watchItem)
                                            <div class="card-body product-body d-flex ">
                                                <div class="w-25 me-3">
                                                    <a
                                                        href="{{ route('catalog.product', ['title_eng' => $watchItem->title_eng]) }}">
                                                        <img class="w-100" src="{{ asset($watchItem->image) }}">
                                                    </a>
                                                </div>
                                                <div class="info w-75">
                                                    <div class="">
                                                        <a class="text-decoration-none text-dark"
                                                            href="{{ route('catalog.product', ['title_eng' => $watchItem->title_eng]) }}">
                                                            <div class="swiper-slide-title">{{ $watchItem->title }}</div>
                                                        </a>
                                                    </div>
                                                    <div class="mb-2">
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <span
                                                                class="fa fa-star @if ($watchItem->rating > $i) text-warning @else text-body-tertiary @endif"></span>
                                                        @endfor
                                                    </div>
                                                    @if ($watchItem->sale)
                                                        <div class="mb-4 d-flex align-items-center">
                                                            <div class="new-price">
                                                                {{ number_format($watchItem->sale, 0, 0, ' ') }} ₽
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="mb-4 fs-5 fw-semibold">
                                                            {{ number_format($watchItem->price, 0, 0, ' ') }} ₽
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="pt-3 border-start" style="min-height: 100%">
                        <div class="px-4">
                            <h1 class="h3 mb-5">
                                @if (isset($category))
                                    {{ $category->title }}
                                @else
                                    Каталог
                                @endif
                            </h1>
                        </div>
                        @if ($products->isNotEmpty())
                            <div class="filters bg-secondary-subtle p-3">
                                <form class="d-flex flex-wrap">
                                    <div>
                                        <select name="sort" class="form-select form-select-sm">
                                            <option value="" selected>Сортировать по</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        @endif
                        @if (isset($category) && $category->nextLevel->isNotEmpty())
                            <div class="categories-children-list p-3 border-bottom">
                                <div class="row gy-4 justify-content-center">
                                    @foreach ($category->nextLevel as $subCategory)
                                        <div class="col-sm-6 col-lg-4 col-xl-3">
                                            <div class="card h-100">
                                                <div class="card-header text-center bg-white d-flex align-items-center justify-content-center"
                                                    style="height: 100px">
                                                    <h6>{{ $subCategory->title }}</h6>
                                                </div>
                                                <div class="card-body h-100 d-flex flex-column">
                                                    <div class="px-0 mb-4 my-auto">
                                                        <a
                                                            href="{{ route('catalog.search', ['title_eng' => $subCategory->title_eng]) }}">
                                                            <img class="w-100" src="{{ asset($subCategory->image) }}">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if (isset($categories))
                            <div class="categories-children-list p-3 border-bottom">
                                <div class="row gy-4 justify-content-center">
                                    @foreach ($categories as $subCategory)
                                        <div class="col-sm-6 col-lg-4 col-xl-3">
                                            <div class="card h-100">
                                                <div class="card-header text-center bg-white d-flex align-items-center justify-content-center"
                                                    style="height: 100px">
                                                    <h6>{{ $subCategory->title }}</h6>
                                                </div>
                                                <div class="card-body h-100 d-flex flex-column">
                                                    <div class="px-0 mb-4 my-auto">
                                                        <a
                                                            href="{{ route('catalog.search', ['title_eng' => $subCategory->title_eng]) }}">
                                                            <img class="w-100" src="{{ asset($subCategory->image) }}">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="products-list">
                            <div class="row g-0">
                                @forelse ($products as $product)
                                    <div class=" col-sm-6 col-lg-3 card product-card border-0 border-end border-bottom">
                                        <div class="card-body h-100 d-flex flex-column">
                                            @if ($product->sale)
                                                <div class="bdg bdg-warning">Акция</div>
                                            @else
                                                @switch($product->status)
                                                    @case('new')
                                                        <div class="bdg bdg-dark">НОВИНКА</div>
                                                    @break

                                                    @case('hit')
                                                        <div class="bdg bdg-danger">ХИТ</div>
                                                    @break

                                                    @default
                                                @endswitch
                                            @endif
                                            <div class="px-1 mb-4">
                                                <a
                                                    href="{{ route('catalog.product', ['title_eng' => $product->title_eng]) }}">
                                                    <img class="w-100" src="{{ asset($product->image) }}">
                                                </a>
                                            </div>
                                            <div class="mt-auto">

                                                <div class="">
                                                    <a class="text-decoration-none text-dark"
                                                        href="{{ route('catalog.product', ['title_eng' => $product->title_eng]) }}">
                                                        {{ $product->title }}
                                                    </a>
                                                </div>
                                                <div class="mb-3">
                                                    <span class="fa fa-star text-body-tertiary"></span>
                                                    <span class="fa fa-star text-body-tertiary"></span>
                                                    <span class="fa fa-star text-body-tertiary"></span>
                                                    <span class="fa fa-star text-body-tertiary"></span>
                                                    <span class="fa fa-star text-body-tertiary"></span>
                                                </div>
                                                @if ($product->sale)
                                                    <div class="mb-3 d-flex align-items-center">
                                                        <div class="old-price me-4">
                                                            {{ number_format($product->price, 0, 0, ' ') }} ₽
                                                        </div>
                                                        <div class="new-price">
                                                            {{ number_format($product->sale, 0, 0, ' ') }} ₽
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="mb-3 fs-5 fw-semibold">
                                                        {{ number_format($product->price, 0, 0, ' ') }} ₽
                                                    </div>
                                                @endif
                                                @if ($product->count)
                                                    <div class="d-flex flex-nowrap justify-content-between">
                                                        <div class="input-group me-1" style="width: 90px">
                                                            <button
                                                                class="btn btn-sm btn-outline-secondary border-dark-subtle btn-count">-</button>
                                                            <input type="text" value="1"
                                                                class="form-control form-control-sm border-dark-subtle text-center px-0">
                                                            <button
                                                                class="btn btn-sm btn-outline-secondary border-dark-subtle btn-count">+</button>
                                                        </div>
                                                        <button class="btn btn-sm btn-dark" style="width: 150px">
                                                            <span class="text-warning">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" fill="currentColor"
                                                                    class="bi bi-cart3" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                                                </svg>
                                                            </span>
                                                            <span>В корзину</span>
                                                        </button>
                                                    </div>
                                                @else
                                                    <div class="d-flex flex-nowrap justify-content-between">
                                                        <button class="btn btn-sm btn-outline-danger w-100 disabled">
                                                            <span>Нет в наличии</span>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection
