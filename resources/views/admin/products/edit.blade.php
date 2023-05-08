@extends('layouts.admin')

@section('title')
    {{ $product->title }}
@endsection

@section('script-code')
    <script>
        $("#btn-edit").click(() => {
            let formData = new FormData();
            formData.append("title", $("#title").val());
            formData.append("category", $("#category").val());
            formData.append("price", $("#price").val());
            formData.append("sale", $("#sale").val());
            formData.append("count", $("#count").val());
            formData.append("description", $("#description").val());
            formData.append("image", $("#image")[0].files[0]);
            formData.append("status", $("#status").val());
            formData.append("visibility", $(".visibility")[1].checked ? 1 : 0);

            $(".attribute").each((i, e) => {
                formData.append(`attributes[${e.dataset.title}]`, e.value);
            })

            $.ajax({
                url: "{{ route('api.admin.products.edit', ['product' => $product->id]) }}",
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(e) {
                    console.log(e)
                    localStorage.setItem("message-success", e.message)
                    showAlert([e.message], 'alert-success')
                    // w
                    location.reload();
                },
                error: function(e) {
                    console.log(e)
                    showAlert(e.responseJSON.data.errors, 'alert-danger')
                }
            })
        })

        createFile("{{ asset($product->image) }}", 0).then(async file => {
            let fileList = await new DataTransfer();
            await fileList.items.add(file);
            // $("#image")[0].files = fileList.files
            let image = document.createElement("img");
            image.src = URL.createObjectURL(file);
            image.classList.add("w-100");
            document.getElementById("image-preview").append(image);
        })

        async function createFile(url, index) {
            let response = await fetch(url);
            let data = await response.blob();
            let metadata = {
                type: 'image/jpeg'
            };
            var file = new File([data], `изображение.jpg`, metadata);

            return file;
        }

        $("#image").on("change", function() {
            $("#image-preview").empty();
            let image = document.createElement("img");
            image.src = URL.createObjectURL(this.files[0]);
            image.classList.add("w-100");
            document.getElementById("image-preview").append(image);
        })

        $("#btn-remove").click(() => {
            $.ajax({
                url: "{{ route('api.admin.products.remove', ['product' => $product->id]) }}",
                method: 'POST',
                success: function(e) {
                    console.log(e)
                    localStorage.setItem("message-success", e.message)
                    window.location = e.data.url;
                },
                error: function(e) {
                    console.log(e)
                    showAlert(e.responseJSON.data.errors, 'alert-danger')
                }
            })
        })

        $(".btn-remove-attribute").click(function() {
            $(this).parent().remove();
        })

        $("#btn-add-attribute").click(() => {

            let value = $("#attribute-value").val();
            let repeat = false
            $(".attribute").each((i, e) => {
                if (e.dataset.title == value) repeat = true;
            })

            if (!value || repeat) return

            let inputGroup = document.createElement("div");
            inputGroup.classList.add("input-group");
            inputGroup.classList.add("mb-2");

            let span = document.createElement("span");
            span.textContent = value;
            span.classList.add("input-group-text");

            let input = document.createElement("input");
            input.classList.add("form-control");
            input.classList.add("attribute");
            input.dataset.title = value;

            let btnRemove = document.createElement("button");
            btnRemove.classList.add("btn");
            btnRemove.classList.add("btn-danger");
            btnRemove.textContent = "Удалить";
            btnRemove.addEventListener("click", function() {
                $(this).parent().remove();
            })

            inputGroup.append(span);
            inputGroup.append(input);
            inputGroup.append(btnRemove);
            $("#attributes-list").append(inputGroup);
        })
    </script>
@endsection


@section('admin')
    <div class="container-fluid">
        <section class="mb-4">
            <div class="d-flex flex-wrap align-items-end">
                <h1 class="me-3">{{ $product->title }}</h1>
            </div>
            @if (!$product->visibility)
                <h4><span class="badge admin-badge bg-secondary">Товар скрыт для пользователей</span></h4>
            @endif
        </section>
        <div class="mb-2">
            <a href="{{ route('admin.products.list') }}" class="btn btn-sm btn-outline-dark">Назад</a>
        </div>
        <div class="border mb-5">
            <div class="row g-0">
                <div class="col-lg-12 col-xl-9 p-4">
                    <div class="row gy-4">
                        <div class="col-lg-5">
                            <div class="mb-3">
                                <label for="title" class="form-label">Название *</label>
                                <input value="{{ $product->title }}" type="text" class="form-control" id="title">
                                <div class="form-text">Уникальное, например: <b>iPhone 13 mini 256Gb Pink</b></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-3">
                            <div class="mb-3">
                                <label for="category" class="form-label">Категория *</label>
                                <select class="form-select" name="category" id="category">
                                    <option value="">-</option>
                                    @foreach ($categories as $category)
                                        <option data-attributes="{{ $category->parentAttributes }}"
                                            @if ($product->category == $category->id) selected @endif value="{{ $category->id }}">
                                            {{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-3">
                            <div class="mb-3">
                                <label for="price" class="form-label">Цена *</label>
                                <div class="input-group">
                                    <input value="{{ $product->price }}" class="form-control" type="number"
                                        id="price">
                                    <span class="input-group-text">₽.</span>
                                </div>
                                <div class="form-text">Только цифры</div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-3">
                            <div class="mb-3">
                                <label for="sale" class="form-label">Цена со скидкой</label>
                                <input value="{{ $product->sale }}" class="form-control" type="number" id="sale">
                                <div class="form-text">Если цена со скидкой указана, товар будет отмечен как акция, Если она
                                    не нужна, впишите 0 или оставьте поле
                                    пустым</div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-2">
                            <div class="mb-3">
                                <label for="count" class="form-label">Количество * </label>
                                <input class="form-control" value="{{ $product->count }}" type="number" id="count">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="description" class="form-label">Описание</label>
                                <textarea id="description" rows="4" class="form-control">{{ $product->description }}</textarea>
                                <div class="form-text">Не обязательно</div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="mb-3">
                                <label for="image" class="form-label">Изображение категории *</label>
                                <input class="form-control" type="file" id="image">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="mb-3">
                                <label for="status" class="form-label">Отображать товар как *</label>
                                <select name="status" class="form-select" id="status">
                                    <option @if ($product->status == 'normal') selected @endif value="normal">Обычный
                                    </option>
                                    <option @if ($product->status == 'new') selected @endif value="new">Новинка
                                    </option>
                                    <option @if ($product->status == 'hit') selected @endif value="hit">Хит</option>
                                </select>
                                <div class="form-text">Если у товара есть цена со скидкой, то он всегда отображается как
                                    акция</div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="mb-3">
                                <label for="visibility" class="form-label">Скрыть товар</label>
                                <div class="form-check">
                                    <input class="form-check-input visibility" value="0"
                                        @if ($product->visibility == 0) checked @endif type="radio"
                                        name="flexRadioDefault" id="published">
                                    <label class="form-check-label" for="published">Да</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input visibility" value="1"
                                        @if ($product->visibility == 1) checked @endif type="radio"
                                        name="flexRadioDefault" id="hidden">
                                    <label class="form-check-label" for="hidden">Нет</label>
                                </div>
                                <div class="form-text">Скрытый товар не могут смотреть пользователи</div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">Характеристики товара</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="attribute-value">
                                    <button class="btn btn-dark" id="btn-add-attribute">Добавить</button>
                                </div>
                                <div class="form-text">Не обязательно</div>
                            </div>
                            <div id="attributes-list">
                                @foreach ($attributes as $attribute)
                                    <div class="input-group mb-2">
                                        <span class="input-group-text">{{ $attribute->title }}</span>
                                        <input type="text" class="form-control attribute"
                                            data-title="{{ $attribute->title }}" value="{{ $attribute->value }}">
                                        <button class="btn btn-danger" id="btn-remove-attribute">Удалить</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mt-3">
                                <a href="{{ route('admin.products.list') }}" class="btn btn-outline-dark">Отмена</a>
                                <button class="btn btn-dark" id="btn-edit">Сохранить</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3">
                    <div class="h-100 border-start d-flex flex-column p-2">
                        <div class="card border-0">
                            <div class="card-body">
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
                                <div class="px-1 mb-4" id="image-preview">
                                </div>
                                <div class="">{{ $product->title }}</div>
                                <div class="mb-3">
                                    <span class="fa fa-star text-body-tertiary"></span>
                                    <span class="fa fa-star text-body-tertiary"></span>
                                    <span class="fa fa-star text-body-tertiary"></span>
                                    <span class="fa fa-star text-body-tertiary"></span>
                                    <span class="fa fa-star text-body-tertiary"></span>
                                </div>
                                @if ($product->sale)
                                    <div class="mb-3 d-flex align-items-center">
                                        <div class="old-price me-4">{{ number_format($product->price, 0, 0, ' ') }} ₽
                                        </div>
                                        <div class="new-price">{{ number_format($product->sale, 0, 0, ' ') }} ₽</div>
                                    </div>
                                @else
                                    <div class="mb-3 fs-5 fw-semibold">{{ number_format($product->price, 0, 0, ' ') }} ₽
                                    </div>
                                @endif
                                <div class="d-flex flex-nowrap justify-content-between">
                                    <div class="input-group me-1" style="width: 90px">
                                        <button
                                            class="btn btn-sm btn-outline-secondary border-dark-subtle btn-count disabled">-</button>
                                        <input type="text" value="1"
                                            class="form-control form-control-sm border-dark-subtle text-center px-0 disabled"
                                            disabled>
                                        <button
                                            class="btn btn-sm btn-outline-secondary border-dark-subtle btn-count disabled">+</button>
                                    </div>
                                    <button class="btn btn-sm btn-dark disabled" style="width: 150px">
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
                                {{-- @else
                                    <div class="d-flex flex-nowrap justify-content-between">
                                        <button class="btn btn-sm btn-outline-danger w-100 disabled">
                                            <span>Нет в наличии</span>
                                        </button>
                                    </div>
                                @endif --}}
                            </div>
                        </div>
                        <div class="mt-5">
                            <a href="{{ route('catalog.product', ['title_eng' => $product->title_eng]) }}" target="_blank"
                                class="btn btn-warning mb-2">Посмотреть товар на сайте</a>
                            <button class="btn btn-danger mb-2" data-bs-toggle="modal"
                                data-bs-target="#modal-confirm">Удалть товар</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection


@section('modal')
    <div class="modal fade" id="modal-confirm">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header bg-warning">
                    <h1 class="modal-title fs-5" id="modal-label">Подтвердите действие</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body modal-confirm-text">
                    <div>Вы действительно хотите удалить товар: </div>
                    <div><b>{{ $product->title }}</b></div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-danger" id="btn-remove"
                        data-bs-dismiss="modal">Удалить</button>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
@endsection
