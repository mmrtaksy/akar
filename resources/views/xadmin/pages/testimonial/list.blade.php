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
            max-width: 1200px;
            padding: 15px;
            background: #fff;
        }
    </style>



    <main class="form-signin w-100 m-auto">
        <h1 class="h3 mb-3 fw-normal d-flex justify-content-between align-items-center"> <span>Müşteri Yorumları</span> <a
                href="{{ route('testimonial_new') }}" class="btn btn-primary">Yeni Yorum
                Ekle</a> </h1>

        <div class="table-responsive"> 
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Başlık</th>
                        <th scope="col">Kaydedildi</th>
                        <th scope="col">Güncellendi</th>
                        <th scope="col" width="150">Güncelle</th>
                        <th scope="col" width="50">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->updated_at }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('testimonial_new', ['id' => $item->id]) }}">TR</a>
                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('testimonial_new', ['id' => $item->id, 'lang' => 'en']) }}">EN</a>
                            </td>
                            <td>
                                <a class="btn btn-danger btn-sm"
                                    href="{{ route('testimonial_delete', ['id' => $item->id]) }}">Sil</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



    </main>
@endsection
