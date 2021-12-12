@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>{{ __('Admins List') }}</h3></div>
                <div class="card-body">
                  <div class="row justify-content-end text-right">
                    <div class="col-md-12">
                      <a class="btn btn-success col-md-2" href="{{ route('admin.add') }}" type="button" role="button" name="button">Add New Admin</a>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-hover col-sm-12">
                        <thead>
                          <tr>
                            <th scope="col">ID #</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Type</th>
                            <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          @isset($data)
                            @foreach ($data as $key => $value)
                            <tr>
                              <th scope="row">{{ $value->id }}</th>
                              <td>{{ $value->name }}</td>
                              <td>{{ $value->email}}</td>
                              <td>{{ $value->mobile}}</td>
                              <td>{{ $value->type }}</td>
                              <td>
                                @if (Auth::user()->type == 'admin' && Auth::user()->id == 1 && $value->id != 1)
                                <a class="btn btn-danger col-md-12" href="" type="button" role="button" name="button">Delete</a>
                                @endif
                              </td>
                            </tr>
                            @endforeach
                          @endisset
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <!-- <form method="POST" action="{{ route('register') }}">
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
                  </form> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
