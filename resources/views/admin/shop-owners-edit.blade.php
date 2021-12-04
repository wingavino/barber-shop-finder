@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Account Type') }}</div>

                <div class="card-body text-center">
                    <form method="POST" action="{{ route('admin.shopowners.edit', [$user->id, $type]) }}">
                        @csrf
                        <div class="form-group row justify-content-center">
                            <div class="col-md-12">
                              <p>Please type "<b>{{ $type }}</b>" to confirm the following changes:</p>
                            </div>

                            <div class="col-md-12">
                              <p><b>ID:</b> {{$user->id}} <b>Name:</b> {{$user->name}} <b>Email:</b> {{$user->email}} <b>Type:</b> {{$user->type}}</p>
                            </div>

                            <div class="col-md-12">
                              <br><h5>To</h5><br>
                            </div>

                            <div class="col-md-12">
                              <p><b>ID:</b> {{$user->id}} <b>Name:</b> {{$user->name}} <b>Email:</b> {{$user->email}} <b>Type:</b> {{$type}}</p>
                            </div>

                            <div class="col-md-6">
                                <input id="confirm" type="text" class="form-control @error('confirm') is-invalid @enderror" name="confirm" value="{{ old('confirm') }}" required autocomplete="confirm" autofocus>

                                @error('confirm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0 justify-content-center">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary col-md-12">
                                    {{ __('Continue') }}
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
