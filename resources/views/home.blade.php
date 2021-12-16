@extends('layouts.app')

@section('custom-scripts')
<!-- Script to initialize map and Retrieve list of shops -->
<script type="text/javascript" src="{{ asset('js/maps/index.js') }}"></script>

<!-- Async script executes immediately and must be after any DOM elements used in callback. -->
<script async src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3" style="max-height:500px; overflow-y:auto;">
          <div class="card" style="width: 100%;">
            <div class="card-header">
              Barber Shops List
            </div>
            <ul class="list-group list-group-flush" id="shops-list">
            </ul>
          </div>
        </div>
        <div class="col-md-9" style="width: 500px; height: 500px">
          <div id="map" style="width:100%;height:100%"></div>
        </div>
    </div>
</div>
@endsection
