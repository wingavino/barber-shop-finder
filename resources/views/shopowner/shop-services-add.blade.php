@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add New Shop Service') }}</div>

                <div class="card-body text-center">
                    <form method="POST" action="{{ route('shopowner.shop.services.add') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Service Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                          <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}</label>
                          <div class="col-md-6">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  ₱
                                </div>
                              </div>
                              <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" min="0.00" step="any" value="{{ old('price', 0.00) }}" required autocomplete="price">

                              @error('price')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
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
