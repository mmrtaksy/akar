@extends('layouts.default', ['title' => $data->name . ' ' . $data->surname, 'image' => ''])
@section('content')

    <!-- content start -->
    <section class="wrapperSection">
        <div class="container">
            <div class="row">
                <div class="col-md-12">


                    <div class="ls-widget">
                        <div class="tabs-box">



                            <div class="widget-title">
                                <h4>Ayarlar</h4>
                                <div class="actions">
                                    <a href="{{ route('userSetting') }}">Sayfayı Yenile</a>
                                    @auth
                                        @if (Auth::user()->id == $data->id)
                                            <a href="{{ route('userDashboard', ['slug' => Auth::user()->slug]) }}">Profile
                                                Dön</a>
                                        @endif
                                    @endauth
                                </div>
                            </div>


                            <div class="widget-content d-flex flex-column justify-content-center align-items-center">


                                <div class="default-tabs tabs-box w-100">
                                    <!--Tabs Box-->
                                    <ul class="tab-buttons clearfix justify-content-center">
                                        <li class="tab-btn active-btn" data-tab="#tab1">Genel Ayarlar</li>
                                        <li class="tab-btn" data-tab="#tab2">Galeri</li>
                                    </ul>

                                    <div class="w-100 relative">
                                        @if (session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="tabs-content w-100">
                                        <!--Tab-->
                                        <div class="tab active-tab" id="tab1">

                                            <div class="candidate-block-three col-sm-12">
                                                <div class="d-flex flex-column justify-content-center align-items-center">


                                                    <div class="candidate-block-three col-xl-6 col-md-12 col-sm-12">
                                                        <div class="inner-box">

                                                            <div class="default-form login-form w-100">
                                                                <form action="{{ route('updatePost') }}" method="post"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col col-12 col-md-6">
                                                                            <div class="mb-3 form-group">
                                                                                <label for="floatingInput1">Adınız</label>
                                                                                <input type="text" id="floatingInput1"
                                                                                    name="name" required
                                                                                    placeholder="Adınızı girin"
                                                                                    value="{{ $data->name }}" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col col-12 col-md-6">
                                                                            <div class="mb-3 form-group">
                                                                                <label
                                                                                    for="floatingInput2">Soyadınız</label>
                                                                                <input type="text" id="floatingInput2"
                                                                                    name="surname" required
                                                                                    placeholder="Soyadınızı girin"
                                                                                    value="{{ $data->surname }}" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col col-12 col-md-6">
                                                                            <div class="mb-3 form-group">
                                                                                <label for="floatingInput3">Email</label>
                                                                                <input type="email" id="floatingInput3"
                                                                                    name="email" required
                                                                                    placeholder="Email adresinizi girin"
                                                                                    value="{{ $data->email }}" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col col-12 col-md-6">
                                                                            <div class="mb-3 form-group">
                                                                                <label for="floatingInput4">Telefon</label>
                                                                                <input type="text" id="floatingInput4"
                                                                                    name="phone" required
                                                                                    placeholder="Telefon numaranızı girin"
                                                                                    value="{{ $data->phone }}" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 form-group">
                                                                        <label for="floatingInput5">Hakkınızda</label>
                                                                        <textarea type="text" id="floatingInput5" name="about" placeholder="Kendinizi tanıtın">{{ $data->about }}</textarea>
                                                                    </div>
                                                                    <div class="mb-3 form-group">
                                                                        <label for="floatingInput6">Profil Resmi</label>
                                                                        <input type="file" id="floatingInput6"
                                                                            name="avatar" />
                                                                    </div>
                                                                    <div class="mb-3 form-group">
                                                                        <label for="floatingCity">Hizmet Verdiğiniz
                                                                            İl</label>
                                                                        <div class="form-floating">
                                                                            <select name="city_id"
                                                                                class="form-control {{ $data->city_id ? 'setAutoLoad' : '' }} "
                                                                                placeholder="." required id="handleCities"
                                                                                data-countiesId="{{ $data->counties_id }}">
                                                                                <option value="">SEÇ</option>
                                                                                @foreach ($cities as $item)
                                                                                    @if ($data && $data->city_id == $item->id)
                                                                                        <option value="{{ $item->id }}"
                                                                                            selected>
                                                                                            {{ $item->name }}</option>
                                                                                    @endif
                                                                                    <option value="{{ $item->id }}">
                                                                                        {{ $item->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <label>İl*</label>
                                                                        </div>
                                                                    </div>


                                                                    <div class="mb-3 form-group">
                                                                        <label for="floatingCategory">Hizmet Verdiğiniz
                                                                            Kategori</label>
                                                                        <div class="form-floating">
                                                                            <select name="category_id" class="form-control">
                                                                                <option value="">SEÇ</option>
                                                                                @foreach ($category as $item)
                                                                                    @if ($catuser && $catuser->category_id == $item->id)
                                                                                        <option value="{{ $item->id }}"
                                                                                            selected>
                                                                                            {{ $item->name }}</option>
                                                                                    @else
                                                                                        <option
                                                                                            value="{{ $item->id }}">
                                                                                            {{ $item->name }}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                            <label>Kategoriyi Seç*</label>
                                                                        </div>
                                                                    </div>

                                                                    <button class="w-100 theme-btn btn-style-one bg-blue"
                                                                        type="submit">
                                                                        Bilgileri Güncelle
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--Tab-->
                                        <div class="tab" id="tab2">

                                            <div class="candidate-block-three col-sm-12">
                                                <div class="d-flex flex-column justify-content-center align-items-center">



                                                    <div class="candidate-block-three col-xl-6 col-md-12 col-sm-12">
                                                        <div class="inner-box">

                                                            <div class="default-form login-form w-100">
                                                                <form action="{{ route('uploadGallery') }}" method="post"
                                                                    enctype="multipart/form-data">
                                                                    @csrf

                                                                    <div class="mb-3 form-group">
                                                                        <label for="floatingFileInput">Yeni Resim Ekle</label>
                                                                        <input type="file" multiple id="floatingFileInput" name="file[]" />
                                                                    </div>




                                                                    <button class="w-100 theme-btn btn-style-one bg-blue"
                                                                        type="submit">
                                                                        Galeriyi Güncelle
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>




                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
    <!-- /.content end -->
@endsection
