@extends('layouts.app')

@section('custom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/reportModal.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 col-sm-4">
          @isset($logo)
          <img src="{{ asset('img/'.Auth::user()->id.'/'.$logo->path) }}" class="img-fluid" alt="...">
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
                  <div class="row">
                    <div class="col">
                      @isset($review_average)
                        <p>{{ round($review_average, 2) }}&#9733;
                      @else
                        0&#9733;
                      @endisset
                      @isset($review_count)
                        Average from {{ $review_count }} reviews.</p>
                      @endisset
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">User Name</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Review</th>
                            <th scope="col">Time of Review</th>
                            <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          @isset($shop_reviews)
                            @foreach ($shop_reviews as $shop_review => $review)
                            <tr>
                              <td>{{ $review->user->name }}</td>
                              <td>{{ $review->rating }}</td>
                              <td>{{ $review->review_text }}</td>
                              <td>{{ $review->updated_at }}</td>
                              <td>
                                @if( App\Models\PendingRequest::where('review_id', $review->id)->where('user_id', Auth::user()->id)->first() )
                                  <p class="text-muted">Report Submitted</p>
                                @else
                                  <a class="btn btn-info col"
                                  data-toggle="modal"
                                  data-target="#reportModal"
                                  data-report-form-action="{{ route('shop.reviews.report', ['id' => $review->shop->id, 'review_id' => $review->id, 'request_type' => 'report-review', 'user_id' => Auth::user()->id]) }}"
                                  data-id="{{ $review->id }}"
                                  data-shop-id="{{ $review->shop->id }}"
                                  data-shop-name="{{ $review->shop->name }}"
                                  data-rating="{{ $review->rating }}"
                                  data-reported-user-id="{{ $review->user_id }}"
                                  data-reported-user-name="{{ $review->user->name }}"
                                  data-review-text="{{ $review->review_text }}"
                                  data-request-type='report-review'
                                  data-user-id="{{ Auth::user()->id }}"
                                  type="button" role="button" name="button"
                                  >
                                    Report
                                  </a>
                                @endif
                              </td>
                            </tr>
                            @endforeach
                          @endisset
                        </tbody>
                      </table>
                    </div>
                  </div>

                </div>
            </div>

            <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true" name="reportModal">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Report Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body text-center">
                    <form class="" action="#" method="post" id="reportForm">
                      @csrf
                      <div class="row">
                        <div class="col-md-12">
                          <p id='modalMessage'></p>
                          <label for="report_reason"><b>Reason</b></label>
                          <select class="custom-select" id="report_reason" name="report_reason" aria-label="Select Reason">
                            <option value="inappropriate" selected>Inappropriate Content</option>
                            <option value="spam">Spam</option>
                            <option value="hate-speech">Hate Speech</option>
                          </select>
                          <ul class="list-group list-group-flush text-left" id="name">

                          </ul>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 justify-content-center">
                          <div class="row">
                            <div class="col">
                                <button class="btn btn-primary col" id="reportButton" type="submit">Report</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div> -->
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
