@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Delete Shop') }}</div>

                <div class="card-body text-center">
                    <form method="POST" action="{{ route('admin.shops.delete', ['id' => $id]) }}">
                        @csrf
                        <div class="form-group row justify-content-center">
                            <label for="confirm" class=" col-form-label text-md-right">{{ __('') }}</label>
                            <p>Please type '<b>{{$name}}</b>' to confirm that you want to delete this shop.</p>
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
                                <button type="submit" class="btn btn-danger col-md-12">
                                    {{ __('Delete') }}
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
