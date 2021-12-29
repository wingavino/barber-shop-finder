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
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">Service Name</th>
                            <th scope="col">Price</th>
                          </tr>
                        </thead>
                        <tbody>
                          @isset($shop_services)
                            @foreach ($shop_services as $shop_service => $service)
                            <tr>
                              <td>{{ $service->name }}</td>
                              <td>₱{{ $service->price }}</td>
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
