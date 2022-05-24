@extends('layouts.app')

@section('custom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script defer type="text/javascript" src="{{ asset('js/search.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/deleteModal.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>{{ __('Shops List') }}</h3></div>
                <div class="card-body">
                  <div class="row justify-content-end text-right">
                    <div class="col-md-12">
                      <a class="btn btn-success col-md-2" href="{{ route('admin.shops.add') }}" type="button" role="button" name="button">Add New Shop</a>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <form>
                        <div class="form-group">
                          <input type="text" class="form-control" id="search" placeholder="Search">
                        </div>
                      </form>
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">Shop ID #</th>
                            <th scope="col">Shop Name</th>
                            <th scope="col">Shop Address</th>
                            <th scope="col">Owner's Name</th>
                            <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody id="list">
                          @isset($data)
                            @foreach ($data as $key => $value)
                            <tr>
                              <th scope="row">{{ $value->id }}</th>
                              <td>{{ $value->name }}</td>
                              <td>{{ $value->address }}</td>
                              <td>{{ $value->owner_name }}</td>
                              <td>
                                <a class="btn btn-primary col-md-4" href="{{ route('admin.shops.edit', ['id' => $value->id]) }}" type="button" role="button" name="button">Edit</a>
                                <button class="btn btn-danger col-md-4" data-toggle="modal" data-target="#deleteModal" data-form-action="{{ route('admin.shops.delete', ['id' => $value->id]) }}" data-id="{{ $value->id }}" data-name="{{ $value->name }}">Delete</button>
                              </td>
                            </tr>
                            @endforeach
                          @endisset
                        </tbody>
                      </table>
                    </div>

                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" name="deleteModal">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body text-center">
                            <form class="" action="#" method="post">
                              @csrf
                              <div class="row">
                                <div class="col-md-12">
                                  <p>Please confirm that you want to delete the following shop.</p>
                                  <h4 id='name'></h4>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12 justify-content-center">
                                  <button class="btn btn-danger col-md-6" id="deleteButton" type="submit">Delete</button>
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
