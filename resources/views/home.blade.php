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
      <div class="col-md-12">
        <div class="card" style="width: 100%;">
          <div class="card-header">
            <div class="row">
              <div class="col-12">
                <form>
                  <div class="form-group">
                    <input type="text" class="form-control" id="search" placeholder="Search">
                  </div>
                </form>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <label>Filter By Shop Type: </label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="" value="salon" checked>
                  <label class="form-check-label" for="inlineCheckbox1">Salon</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="" value="barber" checked>
                  <label class="form-check-label" for="inlineCheckbox1">Barber</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <label>Filter By Service: </label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="" value="haircut" checked>
                  <label class="form-check-label" for="inlineCheckbox1">Haircut</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="" value="hairdye">
                  <label class="form-check-label" for="inlineCheckbox1">Hair Dye</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 order-first col-sm-12 order-sm-first col-md-3 order-md-first" style="max-height:500px; overflow-y:auto;">
        <div class="card" style="width: 100%;">
          <div class="card-header text-center">
            <a class="text-dark" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
              <h5 class="card-title">Barber Shops List</h5>
            </a>
          </div>
          <div class="collapse show" id="collapseExample">
            <ul class="list-group list-group-flush" id="shops-list">
            </ul>
          </div>
        </div>
      </div>
      <div class="col-12 order-last col-sm-12 order-sm-last col-md-9 order-md-last" style="width: 500px; height: 500px">
        <div id="map" style="width:100%;height:100%"></div>
      </div>
    </div>
</div>
@endsection
