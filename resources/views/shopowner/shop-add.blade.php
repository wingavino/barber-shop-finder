@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add New Shop') }}</div>

                <div class="card-body text-center">
                    <form method="POST" action="{{ route('shopowner.shop.add') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Shop Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lat" class="col-md-4 col-form-label text-md-right">{{ __('Latitude') }}</label>

                            <div class="col-md-6">
                                <input id="lat" type="text" class="form-control @error('lat') is-invalid @enderror" name="lat" value="{{ old('lat') }}" required autocomplete="name" readonly>

                                @error('lat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lng" class="col-md-4 col-form-label text-md-right">{{ __('Longitude') }}</label>

                            <div class="col-md-6">
                                <input id="lng" type="text" class="form-control @error('lng') is-invalid @enderror" name="lng" value="{{ old('lng') }}" required autocomplete="name" readonly>

                                @error('lng')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-12">
                            <!-- <label for="location" class="col-md-4 col-form-label text-md-right">{{ __('Location') }}</label> -->
                            <p>Drag the marker to the appropriate location</p>
                            <div class="col-md-12" style="width: 100%; height: 500px">
                              <div id="map" style="width:100%;height:100%"></div>
                              <script type="text/javascript">
                              let map;

                              const philippines = { lat: 15.5000569, lng: 120.9109837 };
                              document.getElementById("lat").value = philippines.lat;
                              document.getElementById("lng").value = philippines.lng;

                              function initMap() {

                                map = new google.maps.Map(document.getElementById("map"), {
                                  center: { lat: 15.5000569, lng: 120.9109837 },
                                  zoom: 8,
                                });

                                var marker = new google.maps.Marker({
                                  position: philippines,
                                  draggable: true,
                                  map: map
                                });

                                google.maps.event.addListener(marker, 'dragend', function(event){
                                  // When marker is dragged, do this
                                  document.getElementById("lat").value = event.latLng.lat();
                                  document.getElementById("lng").value = event.latLng.lng();
                                });
                              }
                              </script>
                              <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
                              <script async src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap"></script>
                            </div>
                          </div>
                        </div>

                        <div class="form-group row mb-0 justify-content-center">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary col-md-12">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
