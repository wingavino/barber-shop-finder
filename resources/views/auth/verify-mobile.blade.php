@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Phone Number') }} {{ $pinId }}</div>

                <div class="card-body text-center">
                    @if (session('error'))
                        <div class="alert alert-success" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{ __('Please enter the OTP sent to your number: ') }}
                    <form method="POST" action="{{ route('verify.mobile.pin', ['pinId' => $pinId]) }}">
                        @csrf
                        <div class="form-group row">
                          <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Mobile')}}</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ Auth::user()->mobile }}" placeholder="+639xxxxxxxxx" required>
                            @error('mobile')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="verification_code" class="col-md-4 col-form-label text-md-right">{{ __('Verification Code')}}</label>
                          <div class="col-md-6">
                            <input type="tel" class="form-control @error('verification_code') is-invalid @enderror" name="verification_code" value="{{ old('verification_code') }}" required>
                            @error('verification_code')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="resend" class="col-md-4 col-form-label text-md-right">{{ __('')}}</label>
                          <div class="col-md-6">
                            <a href="{{ route('verify.mobile.send') }}">{{ __("Didn't receive a code? Click here to resend.") }}</a>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="submit" class="col-md-4 col-form-label text-md-right"></label>
                          <div class="col-md-6">
                              <button type="submit" class="btn btn-primary col-md-12">
                                  {{ __('Verify') }}
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
