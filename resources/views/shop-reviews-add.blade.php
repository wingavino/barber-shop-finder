@extends('layouts.app')

@section('custom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/rating.js') }}"></script>
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
          @include('shop-nav-tabs')
        </div>
        <div class="card-body text-center">
          <form method="POST" action="{{ route('shop.reviews.add', ['id' => $shop->id]) }}">
            @csrf
            <h3>{{ __('Add Review')}}</h3>
            <div class="form-group row">
              <label for="rating" class="col-md-4 col-form-label text-md-right">{{ __('Rating') }}</label>
              <div class="col-md-6">
                <div class="input-group">
                  <input id="rating" type="range" class="form-control @error('rating') is-invalid @enderror" name="rating" min="1" max="5" step="1" value="{{ old('rating', 3) }}" style="padding:0;" required>
                  <div class="input-group-append">
                    <div class="input-group-text" id="rating_indicator">
                      3★
                    </div>
                  </div>
                  @error('rating')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
            </div>

            <div class="form-group row">
                <label for="review_text" class="col-md-4 col-form-label text-md-right">{{ __('Review Text') }}</label>

                <div class="col-md-6">
                    <!-- <input id="review_text" type="textarea" class="form-control @error('review_text') is-invalid @enderror" name="review_text" value="{{ old('review_text') }}" autocomplete="review_text"> -->
                    <textarea id="review_text" name="review_text" class="form-control @error('review_text') is-invalid @enderror" value="{{ old('review_text') }}" maxlength="30000" rows="8"></textarea>

                    @error('review_text')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-0">
              <label for="submit" class="col-md-4 col-form-label text-md-right"></label>
              <div class="col-md-6">
                  <button type="submit" class="btn btn-primary col-md-12">
                      {{ __('Save') }}
                  </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
