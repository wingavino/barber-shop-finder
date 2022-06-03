@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 col-sm-4">
          @isset($logo)
          <img src="{{ asset('img/'.Auth::user()->id.'/'.$logo->path) }}" class="img-fluid" alt="...">
          @endisset
        </div>
        <div class="col-8 col-sm-12 text-center">
          <h2>{{ $shop->name }}</h2>
          <h5>{{ $shop->address }}</h5>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  @include('shopowner.shop-nav-tabs')
                </div>

                <div class="card-body text-center">
                  <h3>{{ __('Edit Shop Service') }}</h3>
                  @isset($shop_service)
                    <form method="POST" action="{{ route('shopowner.shop.services.edit', ['id' => $shop->id,'service_id' => $shop_service->id]) }}">
                        @csrf
                        <div class="form-group row">
                            <label for="id" class="col-md-4 col-form-label text-md-right">{{ __('Service ID') }}</label>

                            <div class="col-md-6">
                                <input id="id" type="text" class="form-control @error('id') is-invalid @enderror" name="id" value="{{ old('id', $shop_service->id) }}" autocomplete="id" autofocus disabled>

                                @error('id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Service Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $shop_service->name) }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                          <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

                          <div class="col-md-6">
                              <select class="custom-select" id="category" name="category" aria-label="Select Service Category">
                                <option value="Haircut" {{ $shop_service->category == 'Haircut' ? 'selected' : '' }}>Haircut</option>
                                <option value="Kid's Haircut" {{ $shop_service->category == "Kid's Haircut" ? 'selected' : '' }}>Kid's Haircut</option>
                                <option value="Facial Shave" {{ $shop_service->category == 'Facial Shave' ? 'selected' : '' }}>Facial Shave</option>
                                <option value="Hair Color" {{ $shop_service->category == 'Hair Color' ? 'selected' : '' }}>Hair Color</option>
                                <option value="Hair Treatment" {{ $shop_service->category == 'Hair Treatment' ? 'selected' : '' }}>Hair Treatment</option>
                                <option value="Perm" {{ $shop_service->category == 'Perm' ? 'selected' : '' }}>Perm</option>
                                <option value="Rebond" {{ $shop_service->category == 'Rebond' ? 'selected' : '' }}>Rebond</option>
                                <option value="Other" {{ $shop_service->category == 'Other' ? 'selected' : '' }}>Other</option>
                              </select>

                              @error('category')
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
                              <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" min="0.00" step="any" value="{{ old('price', $shop_service->price) }}" required autocomplete="price">

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
                  @endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
