@extends('layouts.app')

@section('custom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/changeUserTypeModal.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>{{ __('Users List') }}</h3></div>
                <div class="card-body">
                  <div class="row justify-content-end text-right">
                    <div class="col-md-12">
                      <!-- <a class="btn btn-success col-md-2" href="{{ route('admin.shopowners.add') }}" type="button" role="button" name="button">Add New Shop Owner</a> -->
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-hover">
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
                            @forelse ($data as $key => $value)
                                <tr>
                                  <th scope="row">{{ $value->id }}</th>
                                  <td>{{ $value->name }}</td>
                                  <td>{{ $value->email}}</td>
                                  <td>{{ $value->mobile}}</td>
                                  <td>{{ $value->type }}</td>
                                  <td>
                                    <!-- @if ($value->type == 'user')
                                    <a class="btn btn-info col-md-6" data-toggle="modal" data-target="#changeUserTypeModal" data-form-action="{{ route('admin.shopowners.edit', [$value->id, 'shopowner']) }}" data-id="{{ $value->id }}" data-name="{{ $value->name }}" data-type='shopowner' type="button" role="button" name="button">Change User Type to Shop Owner</a>
                                    @endif
                                    @if ($value->type == 'shopowner')
                                    <a class="btn btn-info col-md-6" data-toggle="modal" data-target="#changeUserTypeModal" data-form-action="{{ route('admin.shopowners.edit', [$value->id, 'user']) }}" data-id="{{ $value->id }}" data-name="{{ $value->name }}" data-type='user' type="button" role="button" name="button">Change User Type to Regular User</a>
                                    @endif -->
                                  </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                        {{ $data->links() }}
                      </table>
                      {{ $data->links() }}
                    </div>

                    <div class="modal fade" id="changeUserTypeModal" tabindex="-1" aria-labelledby="changeUserTypeModalLabel" aria-hidden="true" name="changeUserTypeModal">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="changeUserTypeModalLabel">Confirm Edit</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body text-center">
                            <form class="" action="#" method="post">
                              @csrf
                              <div class="row">
                                <div class="col-md-12">
                                  <p id='modalMessage'></p>
                                  <h4 id='name'></h4>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12 justify-content-center">
                                  <button class="btn btn-primary col-md-6" id="changeUserTypeButton" type="submit">Continue</button>
                                </div>
                              </div>
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
