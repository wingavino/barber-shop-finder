@extends('layouts.app')

@section('custom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/deleteModal.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 col-sm-4">
          @isset($logo)
          <img src="{{ asset('img/'.$logo->path) }}" class="img-fluid" alt="...">
          @endisset
        </div>
        <div class="col-8 col-sm-12 text-center">
          <h2>{{ $shop->name }}</h2>
          <h5>{{ $shop->address }}</h5>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  @include('admin.shop-nav-tabs')
                </div>
                <div class="card-body">
                  <!-- <div class="row justify-content-end text-right">
                    <div class="col-md-12">
                      <a class="btn btn-success col-md-2" href="{{ route('admin.shop.services.add', ['id' => $shop->id]) }}" type="button" role="button" name="button">Add New Shop Service</a>
                    </div>
                  </div> -->

                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Service Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Price</th>
                            <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>

                          @isset($shop_services)
                            @foreach ($shop_services as $shop_service => $service)
                            <tr>
                              <td>{{ $service->id }}</td>
                              <td>{{ $service->name }}</td>
                              <td>{{ $service->category }}</td>
                              <td>₱{{ $service->price }}</td>

                              <!-- <td>
                                <a class="btn btn-primary col-md-4" href="{{ route('admin.shop.services.edit', ['id' => $shop->id, 'service_id' => $service->id]) }}" type="button" role="button" name="button">Edit</a>
                                <button class="btn btn-danger col-md-4" data-toggle="modal" data-target="#deleteModal" data-form-action="{{ route('admin.shop.services.delete', ['id' => $shop->id, 'service_id' => $service->id]) }}" data-id="{{ $service->id }}" data-service-id="{{ $service->id }}" data-name="{{ $service->name }}" data-price="{{ $service->price }}">Delete</button>
                              </td> -->
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
                                  <p>Please confirm that you want to delete the following service.</p>
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
