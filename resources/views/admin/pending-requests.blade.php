@extends('layouts.app')

@section('custom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/requestModal.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>{{ __('Requests List') }}</h3></div>
                <div class="card-body">
                  <!-- <div class="row justify-content-end text-right">
                    <div class="col-md-12">
                      <a class="btn btn-success col-md-2" href="{{ route('admin.shopowners.add') }}" type="button" role="button" name="button">Add New Shop Owner</a>
                    </div>
                  </div> -->

                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">ID #</th>
                            <th scope="col">User ID</th>
                            <th scope="col">Request Type</th>
                            <th scope="col">User Type</th>
                            <th scope="col">Shop ID</th>
                            <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          @isset($data)
                            @foreach ($data as $key => $value)
                            <tr>
                              <th scope="row">{{ $value->id }}</th>
                              <td>{{ $value->user_id }}</td>
                              <td>{{ $value->request_type}}</td>
                              <td>{{ $value->change_to_user_type}}</td>
                              <td>{{ $value->shop_id }}</td>
                              <td>
                                @if($value->request_type == 'change-user-type')
                                  <a class="btn btn-info col-md-6"
                                    data-toggle="modal"
                                    data-target="#requestModal"
                                    data-form-action="{{ route('admin.shopowners.edit', ['id' => $value->user_id, 'type' => $value->change_to_user_type]) }}"
                                    data-id="{{ $value->id }}"
                                    data-user-id="{{ $value->user_id }}"
                                    data-name="{{ $value->name }}"
                                    data-request-type='{{ $value->request_type }}'
                                    data-change-to-user-type="{{ $value->change_to_user_type }}"
                                    type="button" role="button" name="button"
                                  >
                                    Approve
                                  </a>
                                @endif

                                @if($value->request_type == 'add-new-shop')
                                  <a class="btn btn-info col-md-6"
                                    data-toggle="modal"
                                    data-target="#requestModal"
                                    data-form-action="{{ route('admin.shops.approve', ['id' => $value->shop_id]) }}"
                                    data-id="{{ $value->id }}"
                                    data-user-id="{{ $value->user_id }}"
                                    data-name="{{ $value->name }}"
                                    data-shop-id="{{ $value->shop_id }}"
                                    data-shop-name="{{ $value->shop_name }}"
                                    data-request-type='{{ $value->request_type }}'
                                    data-change-to-user-type="{{ $value->change_to_user_type }}"
                                    type="button" role="button" name="button"
                                  >
                                    Approve
                                  </a>
                                @endif
                              </td>
                            </tr>
                            @endforeach
                          @endisset
                        </tbody>
                      </table>
                    </div>

                    <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true" name="requestModal">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="requestModalLabel">Confirm Approval</h5>
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
                                  <button class="btn btn-primary col-md-6" id="approveRequestButton" type="submit">Continue</button>
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