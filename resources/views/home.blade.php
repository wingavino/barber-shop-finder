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
    <div class="col-12 col-lg-4" style="max-height:100vh; overflow-y:auto;">
      <div class="card" style="width: 100%;">
        <div class="card-header text-center">
          <div class="row">
            <div class="col-12">
              <form>
                <div class="form-group">
                  <input type="text" class="form-control" id="search" placeholder="Search">
                </div>
              </form>
            </div>
          </div>
          <a class="text-dark" data-toggle="collapse" href="#collapseFilter" role="button" aria-expanded="false" aria-controls="collapseFilter">
            <h5 class="card-title">Filter:</h5>
          </a>
        </div>
        <div class="collapse show" id="collapseFilter">
          <ul class="list-group list-group-flush" id="filter">
            <li class="list-group-item">
              By Shop Type:
              <div class="row">
                <div class="col-12">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="" value="salon" >
                    <label class="form-check-label" for="inlineCheckbox1">Salon</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="" value="barber" >
                    <label class="form-check-label" for="inlineCheckbox1">Barber</label>
                  </div>
                </div>
              </div>
            </li>
            <li class="list-group-item">
              By Service:
              <div class="row">
                <div class="col-12">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="" value="haircut">
                    <label class="form-check-label" for="inlineCheckbox1">Haircut</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="" value="hairdye">
                    <label class="form-check-label" for="inlineCheckbox1">Hair Dye</label>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="card" style="width: 100%;">
        <div class="card-header text-center">
          <a class="text-dark" data-toggle="collapse" href="#collapseShopList" role="button" aria-expanded="false" aria-controls="collapseShopList">
            <h5 class="card-title">Barber Shops List</h5>
          </a>
        </div>
        <div class="collapse show" id="collapseShopList">
          <ul class="list-group list-group-flush" id="shops-list">
          </ul>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-8 order-last" style="width: 75%; height: 100vh">
      <div id="map" style="width:100%;height:100%"></div>
    </div>
  </div>
</div>
@endsection
