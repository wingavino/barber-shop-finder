@extends('layouts.app')

@section('custom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/deleteModal.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  @include('shop-nav-tabs')
                </div>
                <div class="card-body">
                  @if(Auth::check())
                    @if(Auth::user()->type == 'user' && !Auth::user()->review->where('shop_id', $shop->id)->first())
                      <div class="row justify-content-end">
                        <div class="col text-right">
                          <a class="btn btn-primary" href="{{ route('shop.reviews.add', ['id' => $shop->id]) }}">Add a Review</a>
                        </div>
                      </div>
                    @endif
                  @endif
                  <div class="row">
                    <div class="col">
                      @isset($review_average)
                        <p>{{ round($review_average, 2) }}
                      @endisset
                      @isset($review_count)
                        Average rating from {{ $review_count }} reviews.</p>
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
                            </tr>
                            @endforeach
                          @endisset
                        </tbody>
                      </table>
                    </div>
                  </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
