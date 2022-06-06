@extends('layouts.app')

@section('custom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/imagePreview.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="col-md-2 col-sm-4">
              @isset($logo)
              <img src="{{ asset('img/'.Auth::user()->id.'/'.$logo->path) }}" class="img-fluid" alt="...">
              @endisset
            </div>
            <div class="col-8 col-sm-12 text-center">
              <h2>{{ $shop->name }}</h2>
              <h5>{{ $shop->address }}</h5>
            </div>
            <div class="card">
                <div class="card-header">
                  @include('shopowner.shop-nav-tabs')
                </div>

                <div class="card-body">
                  <!-- Logo Upload -->
                  <a class="btn btn-primary" href="{{ route('shopowner.shop') }}">Back</a>
                  <div class="container mt-5">
                    <h3 class="text-center mb-5">Upload Logo</h3>
                    <form action="{{ route('shopowner.shop.images.logo.upload', ['id' => Auth::user()->shop->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="user-image mb-3 text-center">
                            <div class="logoPreview justify-content-center text-center"></div>
                        </div>

                        <div class="custom-file">
                            <input type="file" name="logoFile" class="custom-file-input" id="logo">
                            <label class="custom-file-label" for="logo">Choose image</label>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                            Upload Image
                        </button>
                    </form>
                  </div>
                  <!-- Logo Upload End -->

                  <!-- Image Upload -->
                  <div class="container mt-5">
                    <h3 class="text-center mb-5">Upload Images</h3>
                    <form action="{{ route('shopowner.shop.images.upload') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="user-image mb-3 text-center">
                            <div class="imgPreview"></div>
                        </div>

                        <div class="custom-file">
                            <input type="file" name="imageFile[]" class="custom-file-input" id="images" multiple="multiple">
                            <label class="custom-file-label" for="images">Choose image</label>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                            Upload Images
                        </button>
                    </form>
                  </div>
                  <!-- Image Upload End -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
