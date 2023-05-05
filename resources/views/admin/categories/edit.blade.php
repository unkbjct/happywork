@extends('layouts.admin')

@section('title')
    Редактирование - {{ $thisCategory->title }}
@endsection

@section('script-code')
    <script>
        $("#btn-edit").click(() => {
            let formData = new FormData();
            formData.append("title", $("#title").val());
            formData.append("parent", $("#parent").val());
            formData.append("image", $("#image")[0].files[0]);


            $.ajax({
                url: "{{ route('api.admin.categories.edit', ['category' => $thisCategory->id]) }}",
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(e) {
                    showAlert([e.message], 'alert-success')
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
            image.classList.add("w-100");
            document.getElementById("image-preview").append(image);
        })

        createFile("{{ asset($thisCategory->image) }}", 0).then(async file => {
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

        $("#btn-remove").click(() => {
            $.ajax({
                url: "{{ route('api.admin.categories.remove', ['category' => $thisCategory->id]) }}",
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
    </script>
@endsection

@section('admin')
    <div class="container-fluid">
        <section class="mb-5">
            <h1>Категория - {{ $thisCategory->title }}</h1>
        </section>
        <div class="mb-2">
            <a href="{{ route('admin.categories.list') }}" class="btn btn-sm btn-outline-dark">Назад</a>
        </div>
        <section class="border p-4">
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="title" class="form-label">Название категории *</label>
                        <input value="{{ $thisCategory->title }}" type="text" class="form-control" id="title">
                        <div class="form-text">Уникальное, например: <b>Телефоны</b></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="parent" class="form-label">Родительская категоия *</label>
                        <select class="form-select" name="parent" id="parent">
                            <option value="">-</option>
                            @foreach ($categories as $category)
                                <option @if ($thisCategory->parent_id == $category->id) selected @endif
                                    data-attributes="{{ $category->parentAttributes }}" value="{{ $category->id }}">
                                    {{ $category->title }}</option>
                            @endforeach
                        </select>
                        <div class="form-text"> Ничего не выбирайте если нет родительской категории или она не нужна.</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="image" class="form-label">Изображение категории *</label>
                        <input class="form-control" type="file" id="image">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="image-preview" id="image-preview">

                    </div>
                </div>
                {{-- <div class="col-lg-6">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" @if ($thisCategory->visibility) checked @endif type="checkbox"
                                role="switch" id="visibility">
                            <label class="form-check-label" for="visibility">Отображать категоию</label>
                        </div>
                        <div class="form-text">Если отображение выключено, все товары и подкатегории <b>не</b> видны
                            пользователям.</div>
                    </div>
                </div> --}}
                <div class="col-lg-12">
                    <div class="d-flex">
                        <a href="{{ route('admin.categories.list') }}" class="btn btn-outline-dark me-2">Отмена</a>
                        <button class="btn btn-dark" id="btn-edit">Сохранить</button>
                        <button class="btn btn-danger ms-auto" data-bs-toggle="modal"
                            data-bs-target="#modal-confirm">Удалить категорию</button>
                    </div>
                </div>
            </div>
        </section>
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
                    <div>Вы действительно хотите удалить категорию: </div>
                    <div><b>{{ $thisCategory->title }}</b></div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-danger" id="btn-remove" data-bs-dismiss="modal">Удалить</button>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
@endsection
