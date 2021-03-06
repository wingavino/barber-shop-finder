@extends('layouts.app')

@section('custom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!-- Script to initialize map and Retrieve list of shops -->
<script type="text/javascript" async>
  var app_url = "{{env('APP_URL')}}";
</script>

<script defer type="text/javascript" src="{{ asset('js/maps/index.js') }}"></script>

<script defer type="text/javascript" src="{{ asset('js/maps/search.js') }}"></script>

<!-- Async script executes immediately and must be after any DOM elements used in callback. -->
<script defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap"></script>

<script type="text/javascript" src="{{ asset('js/requestAlert.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3" style="max-height:500px; overflow-y:auto;">
          <div class="card" style="width: 100%;">
            <div class="card-header text-center">
              <a class="text-dark" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <h5 class="card-title">Barber Shops List</h5>
              </a>
              <form>
                <div class="form-group">
                  <input type="text" class="form-control" id="search" placeholder="Search">
                </div>
              </form>
            </div>
            <div class="collapse show" id="collapseExample">
              <ul class="list-group list-group-flush" id="shops-list">
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-9" style="width: 500px; height: 500px">
          <div id="map" style="width:100%;height:100%"></div>
        </div>
    </div>
</div>
@endsection
