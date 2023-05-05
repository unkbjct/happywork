@extends('layouts.admin')

@section('title')
    Создание новой категрии
@endsection

@section('script-code')
    <script>
        $("#btn-create").click(() => {
            let formData = new FormData();
            formData.append("title", $("#title").val());
            formData.append("parent", $("#parent").val());
            formData.append("image", $("#image")[0].files[0]);

            $.ajax({
                url: "{{ route('api.admin.categories.create') }}",
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
            image.classList.add("w-100");
            document.getElementById("image-preview").append(image);
        })
    </script>
@endsection

@section('admin')
    <div class="container-fluid">
        <section class="mb-5">
            <h1>Создание новой категории</h1>
        </section>
        <div class="mb-2">
            <a href="{{ route('admin.categories.list') }}" class="btn btn-sm btn-outline-dark">Назад</a>
        </div>
        <section class="border p-4">
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="title" class="form-label">Название категории *</label>
                        <input type="text" class="form-control" id="title">
                        <div class="form-text">Уникальное, например: <b>Телефоны</b></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="parent" class="form-label">Родительская категоия *</label>
                        <select class="form-select" name="parent" id="parent">
                            <option value="">-</option>
                            @foreach ($categories as $category)
                                {{-- @if ($thisCategory->parent_id == $category->id) selected @endif --}}
                                <option data-attributes="{{ $category->parentAttributes }}" value="{{ $category->id }}">
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
                <div class="col-lg-12">
                    <div>
                        <button class="btn btn-dark" id="btn-create">Создать категорию</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
