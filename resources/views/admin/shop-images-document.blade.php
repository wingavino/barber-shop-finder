@extends('layouts.app')

@section('custom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/imagePreview.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 col-sm-4">
            @isset($logo)
            <img src="{{ asset('img/'.$logo->path) }}" class="img-fluid" alt="...">
            @endisset
        </div>
        <div class="col-8 col-sm-12 text-center">
            <h2>{{ $shop->name }}</h2>
            <h5>{{ $shop->address }}</h5>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <!-- <h3 class="text-center mb-5">Upload Business Permit</h3> -->
                  @include('admin.shop-nav-tabs')
                </div>

                <div class="card-body">
                    <!-- ID Upload -->
                    <div class="container mt-5">
                        <!-- <p class="text-center mb-5">Please upload the shop's Business Permit. <br> The document should be fully visible in the picture and text should not be blurry.</p> -->
                            <div class="user-image mb-3 text-center">
                                <div class="idPreview justify-content-center text-center">
                                    @if($shop->image->where('type', 'doc')->first())
                                        <img src="{{ asset('img/'.$user->id.'/'.$shop->image->where('type', 'doc')->first()->path) }}" class="col-md-6 img-thumbnail">
                                    @endif
                                </div>
                            </div>
                    </div>
                  <!-- ID Upload End -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
