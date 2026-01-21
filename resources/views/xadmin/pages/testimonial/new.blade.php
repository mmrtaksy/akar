@extends('xadmin.layouts.default')
@section('content')
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            background-color: #f5f5f5;
        }

        .form-signin {
            max-width: 800px;
            padding: 15px;
        }

        .form-group {
            margin: .5em 0;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>

    <main class="form-signin w-100 m-auto">
        <form action="{{ route('testimonial_create') }}" method="post">
            <h1 class="h3 mb-3 fw-normal">{{ $data ? strtoupper($lang) . ' için Kaydı Düzenle' : strtoupper($lang) . ' için Yeni Kayıt Oluştur' }} </h1>


            <div class="form-group">
                <div class="form-floating">
                    <input type="text" name="title" class="form-control" placeholder="."
                        value="{{ $data ? $data->title : '' }}">
                    <label>Başlık</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-floatinxg">
                    <textarea name="content" class="form-control" rows="15" placeholder="İçerik">{{ $data ? $data->content : '' }}</textarea>
                </div>
            </div>


            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Kaydet</button>
            @if ($data)
                @if($data->lang != 'tr')
                <input type="hidden" value="{{ $data->xid }}" name="xid">
                @else
                <input type="hidden" value="{{ $data->id }}" name="id">
                @endif
                <input type="hidden" value="{{ $data->lang }}" name="lang">
            @endif



        </form>
    </main>
@endsection
