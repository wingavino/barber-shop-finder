@extends('layouts.app')

@section('custom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!-- Script to initialize map and Retrieve list of shops -->
<script type="text/javascript" async>
  var app_url = "{{env('APP_URL')}}";
</script>



<script type="text/javascript" src="{{ asset('js/maps/map.js') }}"></script>

<!-- Async script executes immediately and must be after any DOM elements used in callback. -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap&libraries=marker"></script>



<script type="text/javascript" src="{{ asset('js/maps/search.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/requestAlert.js') }}"></script>
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-4" style="max-height:80vh; overflow-y:auto;">
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
            <h5 class="card-title" id="collapseFilterText">Filterrr -</h5>
          </a>
        </div>
        <div class="collapse show" id="collapseFilter">
          <ul class="list-group list-group-flush" id="filter">
            <li class="list-group-item">
              By Shop Type:
              <div class="row">
                <div class="col-12">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="type1"  name="type" value="all" checked>
                    <label class="form-check-label" for="type1">All</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="type2"  name="type" value="salon">
                    <label class="form-check-label" for="type2">Salon</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="type3"  name="type" value="barber">
                    <label class="form-check-label" for="type3">Barber</label>
                  </div>
                </div>
              </div>
            </li>
            <li class="list-group-item">
              By Service:
              <div class="row">
                  <!-- <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="" value="all" checked>
                    <label class="form-check-label" for="">All</label>
                  </div> -->
                <div class="col-6">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input service" type="checkbox" id='service1' name="service[]" value="Haircut">
                    <label class="form-check-label" for="service1">Haircut</label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input service" type="checkbox" id='service2' name="service[]" value="Kid's Haircut">
                    <label class="form-check-label"for="service2">Kid's Haircut</label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input service" type="checkbox" id='service3' name="service[]" value="Facial Shave">
                    <label class="form-check-label"for="service3">Facial Shave</label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input service" type="checkbox" id='service4' name="service[]" value="Hair Color">
                    <label class="form-check-label"for="service4">Hair Color</label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input service" type="checkbox" id='service5' name="service[]" value="Hair Color">
                    <label class="form-check-label"for="service5">Hair Treatment</label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input service" type="checkbox" id='service6' name="service[]" value="Perm">
                    <label class="form-check-label"for="service6">Perm</label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input service" type="checkbox" id='service7' name="service[]" value="Rebond">
                    <label class="form-check-label"for="service7">Rebond</label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input service" type="checkbox" id='service8' name="service[]" value="Other">
                    <label class="form-check-label"for="service8">Other</label>
                  </div>
                </div>
              </div>
            </li>
            <li class="list-group-item">
              Max Distance (km):
              <div class="row">
                <div class="col-12">
                  <div class="form-inline">
                    <div class="col-10">
                      <input class="form-control-range" type="range" id="max_distance"  name="type" min="0" max="10" step="1" value=5>
                    </div>
                    <div class="col-2">
                      <label id="max_distance_indicator" for="max_distance">5</label>
                    </div>
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
            <h5 class="card-title" id="collapseShopListText">Shops List -</h5>
          </a>
        </div>
        <div class="collapse show" id="collapseShopList">
          <ul class="list-group list-group-flush" id="shops-list">
          </ul>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-8 order-lg-last" style="width: 100%; height: 80vh">
      <div id="map" style="width:100%;height:100%"></div>
    </div>
  </div>
</div>
@endsection
