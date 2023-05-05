@extends('layouts.admin')

@section('title')
    Добавление нового товара
@endsection

@section('script-code')
    <script>
        $("#btn-create").click(() => {
            let formData = new FormData();
            formData.append("title", $("#title").val());
            formData.append("category", $("#category").val());
            formData.append("price", $("#price").val());
            formData.append("sale", $("#sale").val());
            formData.append("count", $("#count").val());
            formData.append("description", $("#description").val());
            formData.append("image", $("#image")[0].files[0]);

            $.ajax({
                url: "{{ route('api.admin.products.create') }}",
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
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


        $("#image").on("change", function() {
            $("#image-preview").empty();
            let image = document.createElement("img");
            image.src = URL.createObjectURL(this.files[0]);
            image.classList.add("w-50");
            image.classList.add("mx-auto");
            document.getElementById("image-preview").append(image);
        })
    </script>
@endsection

@section('admin')
    <div class="container-fluid">
        <section class="mb-5">
            <h1>Добавление нового товара</h1>
        </section>
        <section>
            <div class="mb-3">
                <a href="{{ route('admin.products.list') }}" class="btn btn-sm btn-outline-dark">Назад</a>
            </div>
            <div>
                <p>При добавлении товара, он поумолчанию <b>скрыт для пользователей</b> и имеет статус <b>Новый, если не указана цена со скидкой</b>.</p>
            </div>
        </section>
        <section class="border p-4">
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="title" class="form-label">Название *</label>
                        <input type="text" class="form-control" id="title">
                        <div class="form-text">Уникальное, например: <b>iPhone 13 mini 256Gb Pink</b></div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-2">
                    <div class="mb-3">
                        <label for="category" class="form-label">Категория *</label>
                        <select class="form-select" name="category" id="category">
                            <option value="">-</option>
                            @foreach ($categories as $category)
                                <option data-attributes="{{ $category->parentAttributes }}" value="{{ $category->id }}">
                                    {{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-2">
                    <div class="mb-3">
                        <label for="price" class="form-label">Цена *</label>
                        <div class="input-group">
                            <input class="form-control" type="number" id="price">
                            <span class="input-group-text">₽.</span>
                        </div>
                        <div class="form-text">Только цифры</div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-2">
                    <div class="mb-3">
                        <label for="sale" class="form-label">Акция/скидка</label>
                        <div class="input-group">
                            <input class="form-control" type="number" id="sale">
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="form-text">Если она не нужна, впишите 0 или оставьте поле
                            пустым</div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-2">
                    <div class="mb-3">
                        <label for="count" class="form-label">Количество * </label>
                        <input class="form-control" type="number" id="count">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="title" class="form-label">Описание</label>
                        <textarea id="description" rows="4" class="form-control"></textarea>
                        <div class="form-text">Не обязательно</div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="image" class="form-label">Изображение категории *</label>
                        <input class="form-control" type="file" id="image">
                    </div>
                </div>
                <div class="col-lg-4">
                    <label for="image" class="form-label">Предпросмотр изображения</label>
                    <div id="image-preview" class="p-5 d-flex" style="box-shadow: inset 0 0 10px rgba(30, 30, 30, .2)">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div>
                        <button class="btn btn-dark" id="btn-create">Создать товар</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
