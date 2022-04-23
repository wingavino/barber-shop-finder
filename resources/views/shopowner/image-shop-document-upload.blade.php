@extends('layouts.app')

@section('custom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/imagePreview.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <h3 class="text-center mb-5">Upload Business Permit</h3>
                </div>

                <div class="card-body">
                  <!-- ID Upload -->
                  <div class="container mt-5">
                    <p class="text-center mb-5">Please upload the shop's Business Permit. <br> The document should be fully visible in the picture and text should not be blurry.</p>
                    <form action="{{ route('shopowner.img.shop.doc') }}" method="post" enctype="multipart/form-data">
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
                            <div class="idPreview justify-content-center text-center">
                              @if(Auth::user()->shop->image->where('type', 'doc')->first())
                                <h3 class="text-success">Document already uploaded, you may upload again if you need to change the image.</h3>
                                <img src="{{ asset('img/'.Auth::user()->id.'/'.Auth::user()->shop->image->where('type', 'doc')->first()->path) }}" class="col-md-6 img-thumbnail">
                              @endif
                            </div>
                        </div>

                        <div class="custom-file">
                            <input type="file" name="imgFile" class="custom-file-input" id="img_id">
                            <label class="custom-file-label" for="img_id">Choose image</label>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                            Upload Image
                        </button>
                    </form>
                  </div>
                  <!-- ID Upload End -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
