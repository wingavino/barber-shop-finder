@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>{{ __('User Details') }}</h3></div>

                <div class="card-body">
                  <form method="POST" action="{{ route('register') }}">
                      @csrf
                      <div class="form-group row">
                          <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                          <div class="col-md-6">
                              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ __(Auth::user()->name) }}" required autocomplete="name" disabled>

                              @error('name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Mobile') }}</label>

                          <div class="col-md-6">
                              <input id="name" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ __(Auth::user()->mobile) }}" autocomplete="mobile" disabled>

                              @error('mobile')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                          <div class="col-md-6">
                              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ __(Auth::user()->email) }}" required autocomplete="email" disabled>

                              @error('email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row justify-content-center">
                          <div class="col-md-6 offset-md-2">
                              <a class="btn btn-primary col-md-12" href="{{ Route('profile.edit') }}">
                                  {{ __('Edit') }}
                              </a>
                          </div>
                      </div>

                      <div class="form-group row justify-content-center">
                          <div class="col-md-6 offset-md-2">
                              <a class="btn btn-primary col-md-12" href="{{ Route('profile.edit.password') }}">
                                  {{ __('Change Password') }}
                              </a>
                          </div>
                      </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
