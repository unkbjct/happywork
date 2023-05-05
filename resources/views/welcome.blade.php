@extends('layouts.main')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('public/css/swiper-bundle.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('public/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('public/js/welcome.js') }}"></script>
@endsection

@section('main')
    <div class="container">
        <section class="mb-5">
            <div class="row gy-4">
                <div class="col-lg-9">
                    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('public/storage/images/promo/slide-1.jpg') }}" class="d-block w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('public/storage/images/promo/slide-2.jpg') }}" class="d-block w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('public/storage/images/promo/slide-3.jpg') }}" class="d-block w-100">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card border-2 border-warning">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <span class="h5 m-0">Хиты продаж</span>
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
                        </div>
                        <div class="swiper swiper-hits">
                            <div class="swiper-wrapper">
                                @for ($i = 0; $i < 3; $i++)
                                    <div class="swiper-slide">
                                        <div class="card-body product-body">
                                            <div class="bdg bdg-danger">ХИТ</div>
                                            <div class="px-5 mb-4">
                                                <img class="w-100"
                                                    src="{{ asset('public/storage/images/products/iphone.png') }}">
                                            </div>
                                            <div class="info">
                                                <div class="">iPhone 13 {{ $i }} 128Gb Pink</div>
                                                <div class="mb-3">
                                                    <span class="fa fa-star text-body-tertiary"></span>
                                                    <span class="fa fa-star text-body-tertiary"></span>
                                                    <span class="fa fa-star text-body-tertiary"></span>
                                                    <span class="fa fa-star text-body-tertiary"></span>
                                                    <span class="fa fa-star text-body-tertiary"></span>
                                                </div>
                                                <div class="mb-3 fs-5 fw-semibold">{{ number_format(60130, 0, 0, ' ') }} ₽
                                                </div>
                                                <button class="btn btn-dark w-100">
                                                    <span class="text-warning me-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" fill="currentColor" class="bi bi-cart3"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                                        </svg>
                                                    </span>
                                                    <span>В корзину</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mb-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span class="h5">Новинки</span>
                    <div class="arrows">
                        <div class="arrow news-back">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                                <path
                                    d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z" />
                            </svg>
                        </div>
                        <div class="arrow news-next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                <path
                                    d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="swiper swiper-news">
                    <div class="swiper-wrapper">
                        @for ($i = 0; $i < 10; $i++)
                            <div class="swiper-slide">
                                <div class="card-body border-end product-body">
                                    <div class="bdg bdg-dark">НОВИНКА</div>
                                    <div class="px-1 mb-4">
                                        <img class="w-100"
                                            src="{{ asset('public/storage/images/products/iphone.png') }}">
                                    </div>
                                    <div class="">iPhone 13 {{ $i }} 128Gb Pink</div>
                                    <div class="mb-3">
                                        <span class="fa fa-star text-body-tertiary"></span>
                                        <span class="fa fa-star text-body-tertiary"></span>
                                        <span class="fa fa-star text-body-tertiary"></span>
                                        <span class="fa fa-star text-body-tertiary"></span>
                                        <span class="fa fa-star text-body-tertiary"></span>
                                    </div>
                                    <div class="mb-3 fs-5 fw-semibold">{{ number_format(60130, 0, 0, ' ') }} ₽
                                    </div>
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
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                                                    <path
                                                        d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                                </svg>
                                            </span>
                                            <span>В корзину</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </section>
        <section class="mb-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span class="h5">Популярные товары</span>
                    <div class="arrows">
                        <div class="arrow tops-back">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                                <path
                                    d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z" />
                            </svg>
                        </div>
                        <div class="arrow tops-next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                <path
                                    d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="swiper swiper-tops">
                    <div class="swiper-wrapper">
                        @for ($i = 0; $i < 10; $i++)
                            <div class="swiper-slide">
                                <div class="card-body border-end product-body">
                                    <div class="bdg bdg-warning">АКЦИЯ</div>
                                    <div class="px-1 mb-4">
                                        <img class="w-100"
                                            src="{{ asset('public/storage/images/products/iphone.png') }}">
                                    </div>
                                    <div class="">iPhone 13 {{ $i }} 128Gb Pink</div>
                                    <div class="mb-3">
                                        <span class="fa fa-star text-body-tertiary"></span>
                                        <span class="fa fa-star text-body-tertiary"></span>
                                        <span class="fa fa-star text-body-tertiary"></span>
                                        <span class="fa fa-star text-body-tertiary"></span>
                                        <span class="fa fa-star text-body-tertiary"></span>
                                    </div>
                                    <div class="mb-3 d-flex align-items-center">
                                        <div class="old-price me-4">{{ number_format(60130, 0, 0, ' ') }} ₽
                                        </div>
                                        <div class="new-price">{{ number_format(60130, 0, 0, ' ') }} ₽</div>
                                    </div>
                                    @if ($i == 4)
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
                        @endfor
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
