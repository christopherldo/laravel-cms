@extends('adminlte::page')

@section('title', 'Editar página')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <h5>
                <i class="icon fas fa-ban"></i>
                Erro!
            </h5>
            <ul class="mt-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4>Editar página</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pages.update', ['page' => $page->id]) }}" class="form-horizontal" method="POST">
                @csrf @method('PUT')
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">
                        Nome completo:
                    </label>
                    <div class="col-sm-10">
                        <input type="text" name="title" value="{{ $page->title }}"
                            class="form-control @error('title') is-invalid @enderror" id="title">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="body" class="col-sm-2 col-form-label">
                        Corpo:
                    </label>
                    <div class="col-sm-10">
                        <textarea name="body" id="body" class="form-control bodyfield">{{ $page->body }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <input type="submit" value="Salvar" class="btn btn-success">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea.bodyfield',
            height: 300,
            menubar: false,
            plugins: ['link', 'table', 'image', 'autoresize', 'lists'],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | table | link image | bullist numlist',
            content_css: [
                '{{ asset(' / css / content.css ') }}'
            ],
            images_upload_url: '{{ route('imageupload') }}',
            images_upload_credentials: true,
            convert_urls: false
        });

    </script>

    <style>
        .tox-notifications-container {
            display: none !important;
        }

    </style>
@endsection
