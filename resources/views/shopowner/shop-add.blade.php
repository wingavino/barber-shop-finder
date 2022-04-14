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

                        <label for="open_hours" class="col-md-4 col-form-label text-md-right">{{ __('Open Hours') }}</label>

                        @for($i = 1; $i <= 7; $i++)
                        <div class="form-group row">
                          <label for="open_hours_day_{{$i}}" class="col-md-4 col-form-label text-md-right">
                            @switch($i)
                              @case(1)
                                {{ __('Monday') }}
                                @break

                              @case(2)
                                {{ __('Tuesday') }}
                                @break

                              @case(3)
                                {{ __('Wednesday') }}
                                @break

                              @case(4)
                                {{ __('Thursday') }}
                                @break

                              @case(5)
                                {{ __('Friday') }}
                                @break

                              @case(6)
                                {{ __('Saturday') }}
                                @break

                              @default
                                {{ __('Sunday') }}
                                @break

                            @endswitch
                          </label>
                          <div class="col-md-6 input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <input id="open_hours_day_{{$i}}" type="checkbox" class="@error('open_hours_day_{{$i}}') is-invalid @enderror" name="open_hours_day[]" value="{{$i}}">
                              </div>
                            </div>
                            <input id="open_hours_start[{{$i}}]" type="time" class="form-control @error('open_hours_start[{{$i}}]') is-invalid @enderror" name="open_hours_start[{{$i}}]" value="{{ old('open_hours_start[$i]') }}">
                            <input id="open_hours_end[{{$i}}]" type="time" class="form-control @error('open_hours_end[{{$i}}]') is-invalid @enderror" name="open_hours_end[{{$i}}]" value="{{ old('open_hours_end[$i]') }}" >
                            @error('open_hours_start[$i]')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            @error('open_hours_end[$i]')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                        </div>
                        @endfor

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">

                                @error('address')
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
