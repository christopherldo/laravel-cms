@extends('adminlte::page')

@section('title', 'Nova página')

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
            <h4>Nova página</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pages.store') }}" class="form-horizontal" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">
                        Título:
                    </label>
                    <div class="col-sm-10">
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="form-control @error('title') is-invalid @enderror" id="title">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="body" class="col-sm-2 col-form-label">
                        Corpo:
                    </label>
                    <div class="col-sm-10">
                        <textarea name="body" id="body" class="form-control bodyfield">{{ old('title') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <input type="submit" value="Criar" class="btn btn-success">
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
