@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="col-md-2 col-sm-4">
              @isset($logo)
              <img src="{{ asset('img/'.$logo->path) }}" class="img-fluid" alt="...">
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

                <div class="card-body text-center">
                  <h3>{{ __('Add New Shop Employee') }}</h3>
                    <form method="POST" action="{{ route('shopowner.shop.employees.add') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Employee Name') }}</label>

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
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>

                            <div class="col-md-6">
                                <select class="custom-select form-control @error('type') is-invalid @enderror" id="type" name="type" aria-label="Select Employee Type">
                                  <option value="employee" selected>Employee</option>
                                  <option value="barber">Barber</option>
                                  <option value="stylist">Stylist</option>
                                  <option value="other">Other</option>
                                </select>
                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email (Optional)') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" title="Caution: This may allow unintended access if the wrong email is linked. Please check that the email entered is correct.">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->

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
