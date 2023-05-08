@extends('layouts.main')

@section('title')
    {{ $product->title }}
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('public/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/product.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('public/js/swiper-bundle.min.js') }}"></script>
@endsection

@section('script-code')
    <script>
        let productId = "{{ $product->id }}";

        $.ajax({
            url: "{{ route('api.catalog.watched') }}",
            method: 'post',
            data: {
                product: productId,
            },
            success: (e) => {
                // showAlert(e.message, 'alert-success')
            },
            error: (e) => {
                console.log(e)
                // showAlert(e.responseJSON.data.errors, 'alert-danger')
            }
        })

        let reviewScore = null;

        $("#btn-add-review").click(function() {
            $.ajax({
                url: "{{ route('api.catalog.product.review', ['product' => $product->id]) }}",
                method: 'post',
                data: {
                    userId: this.dataset.user,
                    name: $("#review-name").val(),
                    comment: $("#review-comment").val(),
                    type: $(".review-type:checked").val(),
                    rating: reviewScore,
                },
                success: (e) => {
                    showAlert([e.message], 'alert-success')
                },
                error: (e) => {
                    console.log(e)
                    showAlert(e.responseJSON.data.errors, 'alert-danger')
                }
            })
        })

        $(".review-star").click(function(e) {
            $(".review-star").each((i, e) => {
                $(e).removeClass("checked");
            })
            this.classList.add("checked")
            for (let i = 0; i < this.dataset.score; i++) {
                $($(".review-star")[i]).addClass("checked");
            }
            reviewScore = this.dataset.score;
        })

        new Swiper('.swiper-hits', {
            slidesPerView: 1,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            navigation: {
                nextEl: '.hit-next',
                prevEl: '.hit-back',
            },
        });
    </script>
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
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
                </ol>
            </nav>
        </section>
        <section class="mb-4">
            <div class="card">
                <div class="card-header d-flex flex-wrap">
                    <h1 class="h3">{{ $product->title }}</h1>
                    <div class="ms-auto">
                        <button class="btn border product-page btn-favorite @if (Cookie::has('favorites') && in_array($product->id, json_decode(Cookie::get('favorites')))) active @endif"
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
                        </button>
                        <button class="btn btn-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="gray"
                                class="bi bi-list-columns" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M0 .5A.5.5 0 0 1 .5 0h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 0 .5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 2h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 4h10a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 6h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 8h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="">
                            @for ($i = 0; $i < 5; $i++)
                                <span
                                    class="fa fa-star @if ($product->rating > $i) text-warning @else text-body-tertiary @endif"></span>
                            @endfor
                            <span>({{ $product->rating_count }})</span>
                            <span class="ms-3">Наличие товара: @if ($product->count)
                                    <span class="text-primary">В наличии</span>
                                @else
                                    <span class="text-danger">Отсутствует</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="row gy-4">
                        <div class="col-lg-4">
                            <div>
                                <img class="w-100" src="{{ asset($product->image) }}">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="mt-4">
                                <p>{{ $product->description }}</p>
                                <div class="mb-3">
                                    <a href="#description">Перейти к описанию</a>
                                </div>
                                <div class="row g-0">
                                    <div class="col-4">
                                        <div class="d-flex align-items-center justify-content-left ps-2 border-end">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="50"
                                                height="50" fill="var(--bs-warning)" class="bi bi-shield-fill-check"
                                                viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647z" />
                                            </svg>
                                            <span class="fw-semibold">Оригинальная продукция</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex align-items-center justify-content-left ps-2 border-end">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="50"
                                                height="50" fill="var(--bs-warning)" class="bi bi-arrow-repeat"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                                <path fill-rule="evenodd"
                                                    d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                                            </svg>
                                            <span class="fw-semibold">Гарантия Возврата</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex align-items-center justify-content-left ps-2">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="50"
                                                height="50" fill="var(--bs-warning)" class="bi bi-wallet"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M0 3a2 2 0 0 1 2-2h13.5a.5.5 0 0 1 0 1H15v2a1 1 0 0 1 1 1v8.5a1.5 1.5 0 0 1-1.5 1.5h-12A2.5 2.5 0 0 1 0 12.5V3zm1 1.732V12.5A1.5 1.5 0 0 0 2.5 14h12a.5.5 0 0 0 .5-.5V5H2a1.99 1.99 0 0 1-1-.268zM1 3a1 1 0 0 0 1 1h12V2H2a1 1 0 0 0-1 1z" />
                                            </svg>
                                            <span class="fw-semibold">Гарантия лучшей цены</span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="border mt-4 border-warning border-3 p-2">
                                @if ($product->sale)
                                    <div class="mb-4 d-flex align-items-center">
                                        <div class="old-price me-4">
                                            {{ number_format($product->price, 0, 0, ' ') }} ₽
                                        </div>
                                        <div class="new-price">
                                            {{ number_format($product->sale, 0, 0, ' ') }} ₽
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-4 fs-5 fw-semibold">
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
                </div>
            </div>
        </section>
        <section id="description">
            <div class="row gy-4">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header pb-0 px-0 border-bottom-0">
                            <nav>
                                <div class="nav nav-tabs px-4">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#nav-description">Описание</button>
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#nav-delivery">Доставка</button>
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#nav-reviews">Отзывы</button>
                                </div>
                            </nav>
                        </div>
                        <div class="card-body p-0">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-description">
                                    @if ($attributes->isEmpty())
                                        <div class="card-body">
                                            {{ $product->description }}
                                        </div>
                                    @else
                                        <ul class="list-group">
                                            @foreach ($attributes as $attribute)
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-lg-5">
                                                            <div class="border-end">
                                                                {{ $attribute->title }}:
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            {{ $attribute->value }}
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="nav-delivery">
                                    <div class="card border-0 mb-4">
                                        <div class="card-header border-bottom-0">
                                            <h4>Вариант 1: Курьером в черте города</h4>
                                        </div>
                                        <div class="card-body">
                                            <h5>Стоимость доставки зависит от суммы заказа</h5>
                                            <div>Для заказов больше <span class="fw-semibold">500 рублей</span> - доставка
                                                <span class="fw-semibold">0 рублей</span>
                                            </div>
                                            <div>Для заказов меньше <span class="fw-semibold">500 рублей</span> - доставка
                                                <span class="fw-semibold">0 рублей</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border-0 mb-4">
                                        <div class="card-header border-bottom-0">
                                            <h4>Вариант 2: Самовывоз ТЦ "Мармелад"</h4>
                                        </div>
                                        <div class="card-body">
                                            <div>Великий Новгород, ул. Ломоносова, 29, ТЦ "Мармелад" 1 этаж</div>
                                            <div>Стоимость доставки: <span class="fw-semibold">0 рублей</span></div>
                                        </div>
                                    </div>
                                    <div class="card border-0 mb-4">
                                        <div class="card-header border-bottom-0">
                                            <h4>Вариант 3: Курьером по Новгородской области</h4>
                                        </div>
                                        <div class="card-body">
                                            <div>Стоимость доставки: <span class="fw-semibold">500 рублей</span></div>
                                        </div>
                                    </div>
                                    <div class="card border-0 mb-4">
                                        <div class="card-header border-bottom-0">
                                            <h4>Вариант 4: Самовывоз ТД "Русь"</h4>
                                        </div>
                                        <div class="card-body">
                                            <div>Великий Новгород, ул. Большая Санкт-Петербургская, 25. ТД "Русь" </div>
                                            <div>Стоимость доставки: <span class="fw-semibold">0 рублей</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-reviews">
                                    <div class="card border-0">
                                        <div class="row g-0">
                                            <div class="col-lg-8">
                                                <div class="card-body">
                                                    @foreach ($reviews as $review)
                                                        <div class="mb-3">
                                                            <div class="mb-3">
                                                                <span class="me-3">
                                                                    @for ($i = 0; $i < 5; $i++)
                                                                        <span
                                                                            class="fa fa-star @if ($review->rating > $i) text-warning @else text-body-tertiary @endif"></span>
                                                                    @endfor
                                                                </span>
                                                                <span class="fw-semibold me-3">{{ $review->name }}</span>
                                                                <small
                                                                    class="text-muted">{{ date_format(date_create($review->created_at), 'Y.m.d') }}</small>
                                                            </div>
                                                            <div class="mb-3">Отзыв - <span class="fw-semibold">
                                                                    @if ($review->type == 'plus')
                                                                        Положительный
                                                                    @else
                                                                        Отрицательный
                                                                    @endif
                                                                </span></div>
                                                            <div>
                                                                <div class="fw-semibold">Комментарий: </div>
                                                                <div>{{ $review->comment }}</div>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div
                                                class="@if ($reviews->isEmpty()) col-lg-12 @else col-lg-4 border-start @endif">
                                                @if (Auth::check())
                                                    <div class="">
                                                        <div class="card-header border-bottom-0">
                                                            <h3>Новый отзыв</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="mb-3">
                                                                <div class="mb-2">Оценка товара * </div>
                                                                <span class="fa fa-star review-star text-body-tertiary"
                                                                    data-score="1"></span>
                                                                <span class="fa fa-star review-star text-body-tertiary"
                                                                    data-score="2"></span>
                                                                <span class="fa fa-star review-star text-body-tertiary"
                                                                    data-score="3"></span>
                                                                <span class="fa fa-star review-star text-body-tertiary"
                                                                    data-score="4"></span>
                                                                <span class="fa fa-star review-star text-body-tertiary"
                                                                    data-score="5"></span>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="review-name" class="form-label">Имя *</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ Auth::user()->name }}" id="review-name">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="review-comment" class="form-label">Комментарий
                                                                    *</label>
                                                                <textarea id="review-comment" class="form-control" rows="3"></textarea>
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="visibility" class="form-label">В целом Ваш
                                                                    отзыв</label>
                                                                <div class="form-check">
                                                                    <input class="form-check-input review-type"
                                                                        value="plus" type="radio" name="review-type"
                                                                        id="plus" checked>
                                                                    <label class="form-check-label"
                                                                        for="plus">Положительный</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input review-type"
                                                                        value="minus" type="radio" name="review-type"
                                                                        id="minus">
                                                                    <label class="form-check-label"
                                                                        for="minus">Отрицательный</label>
                                                                </div>
                                                            </div>
                                                            <div class="">
                                                                <button class="btn btn-dark" id="btn-add-review"
                                                                    data-user="{{ Auth::user()->id }}">Добавить
                                                                    отзыв</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="text-center fw-semibold h-100 d-flex flex-column">
                                                        <div class="my-auto text-muted py-5">
                                                            <div class="mb-4">
                                                                Вы должны быть авторизованы чтобы оставить отзыва на товар
                                                            </div>
                                                            <a href="{{ route('user.login') }}"
                                                                class="btn btn-sm btn-dark">Войти</a>
                                                            <a href="{{ route('user.signup') }}"
                                                                class="btn btn-sm btn-dark">Зарегестрироваться</a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
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
                        </div>
                        <div class="swiper swiper-hits">
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
                                                    <div class="">
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <span
                                                                class="fa fa-star @if ($watchItem->rating > $i) text-warning @else text-body-tertiary @endif"></span>
                                                        @endfor
                                                    </div>
                                                    @if ($watchItem->sale)
                                                        <div class="d-flex align-items-center">
                                                            <div class="new-price">
                                                                {{ number_format($watchItem->sale, 0, 0, ' ') }} ₽
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="fs-5 fw-semibold">
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
            </div>
        </section>
    </div>
@endsection
