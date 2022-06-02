@extends('layouts.app')

@section('custom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!-- Script to initialize image -->
<script type="text/javascript" async>
  var asset_url = '{{ URL::asset("/img/") }}'
</script>
<script defer type="text/javascript" src="{{ asset('js/search.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/imagePreviewModal.js') }}"></script>
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
                      <form>
                        <div class="form-group">
                          <input type="text" class="form-control" id="search" placeholder="Search">
                        </div>
                      </form>
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">ID #</th>
                            <th scope="col">User ID</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Request Type</th>
                            <th scope="col">User Type</th>
                            <th scope="col">Shop ID</th>
                            <th scope="col">Shop Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody id="list">
                          @isset($data)
                            @foreach ($data as $key => $value)
                            <tr>
                              <th scope="row">{{ $value->id }}</th>
                              <td>{{ $value->user_id }}</td>
                              <td>{{ $value->name ? $value->name : '' }}</td>
                              <td>{{ $value->request_type }}</td>
                              <td>{{ $value->change_to_user_type }}</td>
                              <td>{{ $value->shop_id }}</td>
                              <td>{{ $value->shop_name ? $value->shop_name : '' }}</td>
                              <td class="text-center">
                                @if($value->approved)
                                  <p class="text-success">Approved</p>
                                @elseif($value->rejected)
                                  <p class="bg-danger text-white">Rejected</p>
                                @else
                                  <p class="bg-secondary text-white">Awaiting Action</p>
                                @endif
                              </td>
                              <td>
                                @if($value->request_type == 'change-user-type')
                                  <a class="btn btn-info col"
                                    data-toggle="modal"
                                    data-target="#requestModal"
                                    data-reject-form-action="{{ route('admin.pending-requests.reject', ['id' => $value->id, 'request_type' => $value->request_type]) }}"
                                    data-approve-form-action="{{ route('admin.shopowners.edit', ['id' => $value->user_id, 'type' => $value->change_to_user_type]) }}"
                                    data-id="{{ $value->id }}"
                                    data-user-id="{{ $value->user_id }}"
                                    data-name="{{ $value->name }}"
                                    data-email="{{ $value->email }}"
                                    data-email-verified-at="{{ $value->email_verified_at }}"
                                    data-img-id="{{ App\Models\Image::where('user_id', $value->user_id)->where('type', 'id')->first()->path ?? '#' }}"
                                    data-mobile="{{ $value->mobile }}"
                                    data-request-type='{{ $value->request_type }}'
                                    data-change-to-user-type="{{ $value->change_to_user_type }}"
                                    type="button" role="button" name="button"
                                  >
                                    View
                                  </a>
                                @endif

                                @if($value->request_type == 'add-new-shop')
                                  <a class="btn btn-info col"
                                    data-toggle="modal"
                                    data-target="#requestModal"
                                    data-reject-form-action="{{ route('admin.pending-requests.reject', ['id' => $value->id, 'request_type' => $value->request_type]) }}"
                                    data-approve-form-action="{{ route('admin.shops.approve', ['id' => $value->shop_id]) }}"
                                    data-id="{{ $value->id }}"
                                    data-user-id="{{ $value->user_id }}"
                                    data-user-type="{{ $value->user_type }}"
                                    data-name="{{ $value->name }}"
                                    data-email="{{ $value->email }}"
                                    data-email-verified-at="{{ $value->email_verified_at }}"
                                    data-img-id="{{ App\Models\Image::where('user_id', $value->user_id)->where('type', 'id')->first()->path ?? '#' }}"
                                    data-img-shop-doc="{{ App\Models\Image::where('shop_id', $value->shop_id)->where('type', 'doc')->first()->path ?? '#' }}"
                                    data-mobile="{{ $value->mobile }}"
                                    data-shop-id="{{ $value->shop_id }}"
                                    data-shop-name="{{ $value->shop_name }}"
                                    data-shop-url="{{ route('admin.shop', ['id' => $value->shop_id]) }}"
                                    data-request-type='{{ $value->request_type }}'
                                    data-change-to-user-type="{{ $value->change_to_user_type }}"
                                    type="button" role="button" name="button"
                                  >
                                    View
                                  </a>
                                @endif

                                @if($value->request_type == 'report-review')
                                  @php
                                  $review = App\Models\Review::where('id', $value->review_id)->first()
                                  @endphp
                                  <a class="btn btn-info col"
                                    data-toggle="modal"
                                    data-target="#requestModal"
                                    data-reject-form-action=""
                                    data-approve-form-action="{{ route('admin.shops.reviews.delete', ['id' => $review->id]) }}"
                                    data-id="{{ $value->id }}"
                                    data-user-id="{{ $value->user_id }}"
                                    data-name="{{ $value->name }}"
                                    data-reported-user-id="{{ $review->user->id }}"
                                    data-reported-user-name="{{ $review->user->name }}"
                                    data-reported-user-email="{{ $review->user->email }}"
                                    data-reported-user-type="{{ $review->user->type }}"
                                    data-report-reason="{{ $value->report_reason }}"
                                    data-review-id="{{ $value->review_id }}"
                                    data-review-text="{{ $review->review_text }}"
                                    data-shop-id="{{ $value->shop_id }}"
                                    data-shop-name="{{ $value->shop_name }}"
                                    data-shop-url="{{ route('admin.shop', ['id' => $value->shop_id]) }}"
                                    data-request-type='{{ $value->request_type }}'
                                    type="button" role="button" name="button"
                                  >
                                    View
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
                            <div class="row">
                              <div class="col-md-12">
                                <p id='modalMessage'></p>
                                <ul class="list-group list-group-flush text-left" id="name">

                                </ul>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12 justify-content-center">
                                <div class="row">
                                  <div class="col">
                                    <form class="" action="#" method="post" id="approveForm">
                                      @csrf
                                      <button class="btn btn-primary col" id="approveRequestButton" type="submit">Approve</button>
                                    </form>
                                  </div>
                                  <div class="col">
                                    <form class="" action="#" method="post" id='rejectForm'>
                                      @csrf
                                      <button class="btn btn-danger col" id="approveRequestButton" type="submit">Reject</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div> -->
                        </div>
                      </div>
                    </div>

                    <!-- Image Preview Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" name="deleteModal">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Image</h5>
                            <button type="button" class="close" data-dismiss="modal" data-target="#deleteModal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body text-center">
                            <div class="row">
                              <div class="col">
                                <img src="#" class="img-fluid" id="modalImagePreview" alt="...">
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" data-target="#deleteModal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Image Preview Modal -->
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
