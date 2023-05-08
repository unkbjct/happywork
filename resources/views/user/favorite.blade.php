@extends('layouts.user')

@section('title')
    Избранные товары
@endsection

@section('script-code')
    <script></script>
@endsection

@section('user')
    <div class="">
        <div class="p-3">
            <h1 class="h3">Избранные товары</h1>
        </div>
        <div>
            <div class="row g-0 border-top">
                @forelse ($products as $product)
                    <div class=" col-sm-6 col-lg-4 col-xl-3 card product-card border-0 border-end border-bottom">
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
                            <div class="btn-favorite @if (Cookie::has('favorites') && in_array($product->id, json_decode(Cookie::get('favorites')))) active @endif border"
                                data-product-id="{{ $product->id }}">
                                <svg class="not-fill" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-suit-heart" viewBox="0 0 16 16">
                                    <path
                                        d="m8 6.236-.894-1.789c-.222-.443-.607-1.08-1.152-1.595C5.418 2.345 4.776 2 4 2 2.324 2 1 3.326 1 4.92c0 1.211.554 2.066 1.868 3.37.337.334.721.695 1.146 1.093C5.122 10.423 6.5 11.717 8 13.447c1.5-1.73 2.878-3.024 3.986-4.064.425-.398.81-.76 1.146-1.093C14.446 6.986 15 6.131 15 4.92 15 3.326 13.676 2 12 2c-.777 0-1.418.345-1.954.852-.545.515-.93 1.152-1.152 1.595L8 6.236zm.392 8.292a.513.513 0 0 1-.784 0c-1.601-1.902-3.05-3.262-4.243-4.381C1.3 8.208 0 6.989 0 4.92 0 2.755 1.79 1 4 1c1.6 0 2.719 1.05 3.404 2.008.26.365.458.716.596.992a7.55 7.55 0 0 1 .596-.992C9.281 2.049 10.4 1 12 1c2.21 0 4 1.755 4 3.92 0 2.069-1.3 3.288-3.365 5.227-1.193 1.12-2.642 2.48-4.243 4.38z" />
                                </svg>
                                <svg class="fill" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-suit-heart-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1z" />
                                </svg>
                            </div>
                            <div class="px-1 mb-4">
                                <a href="{{ route('catalog.product', ['title_eng' => $product->title_eng]) }}">
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
                                                class="btn btn-sm btn-outline-secondary border-dark-subtle btn-count btn-count-minus">-</button>
                                            <input type="number" value="1"
                                                class="form-control form-control-sm border-dark-subtle text-center px-0 count-product">
                                            <button
                                                class="btn btn-sm btn-outline-secondary border-dark-subtle btn-count btn-count-plus">+</button>
                                        </div>
                                        <button class="btn btn-sm btn-dark add-to-cart" style="width: 150px"
                                            data-product-id="{{ $product->id }}">
                                            <span class="text-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
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
                        <div class="p-3">
                            <div class="px-3 py-2 text-white bg-warning">
                                <div>Ваш список избранных товаров пуст. Вы можете добавлять сюда товары из <a class="text-white" href="{{route('catalog')}}">каталога</a></div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endsection
