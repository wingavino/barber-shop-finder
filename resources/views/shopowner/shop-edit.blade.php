@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="col-md-2 col-sm-4">
            @isset($logo)
            <img src="{{ asset('img/'.Auth::user()->id.'/'.$logo->path) }}" class="img-fluid" alt="...">
            @endisset
          </div>
          <div class="col-8 col-sm-12 text-center">
            <h2>{{ $shop->name }}</h2>
            <h5>{{ $shop->address }}</h5>
          </div>

          <div class="card">
            <div class="card-header">
              @include('shopowner.shop-nav-tabs')
            </div>

            <div class="card-body">
              <a class="btn btn-primary" href="{{ route('shopowner.shop') }}">Back</a>
              <form method="POST" action="{{ route('shopowner.shop.edit', ['id' => $shop->id]) }}">
                  @csrf
                  <div class="form-group row">
                      <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                      <div class="col-md-6">
                          <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ __($shop->name) }}" required autocomplete="name" autofocus>

                          @error('name')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div>

                  <div class="form-group row">
                    <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Shop Type') }}</label>

                    <div class="col-md-6">
                        <select class="custom-select" id="type" name="type" aria-label="Select Shop Type">
                          <option value="Salon" {{ $shop->type == 'salon' ? 'selected' : '' }}>Salon</option>
                          <option value="Barber" {{ $shop->type == 'barber' ? 'selected' : ''}}>Barber</option>
                        </select>

                        @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                  <label for="open_hours" class="col col-form-label text-md-center"><h3>{{ __('Open Hours') }}</h3></label>

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
                          @foreach($open_hours as $open_hour)
                            @if($open_hour->day == $i)
                              <input id="open_hours_day_{{$i}}" type="checkbox" class="@error('open_hours_day_{{$i}}') is-invalid @enderror" name="open_hours_day[]" value="{{$i}}" checked>
                              @break
                            @endif

                            @if($loop->last)
                              <input id="open_hours_day_{{$i}}" type="checkbox" class="@error('open_hours_day_{{$i}}') is-invalid @enderror" name="open_hours_day[]" value="{{$i}}">
                            @endif
                          @endforeach
                        </div>
                      </div>
                      @foreach($open_hours as $open_hour)
                        @if($open_hour->day == $i)
                          <input id="open_hours_start[{{$i}}]" type="time" class="form-control @error('open_hours_start[{{$i}}]') is-invalid @enderror" name="open_hours_start[{{$i}}]" value="{{ old('open_hours_start[$i]', $open_hour->time_start) }}">
                          <input id="open_hours_end[{{$i}}]" type="time" class="form-control @error('open_hours_end[{{$i}}]') is-invalid @enderror" name="open_hours_end[{{$i}}]" value="{{ old('open_hours_end[$i]', $open_hour->time_end) }}">
                          @break
                        @endif

                        @if($loop->last)
                        <input id="open_hours_start[{{$i}}]" type="time" class="form-control @error('open_hours_start[{{$i}}]') is-invalid @enderror" name="open_hours_start[{{$i}}]" value="{{ old('open_hours_start[$i]') }}">
                        <input id="open_hours_end[{{$i}}]" type="time" class="form-control @error('open_hours_end[{{$i}}]') is-invalid @enderror" name="open_hours_end[{{$i}}]" value="{{ old('open_hours_end[$i]') }}">
                        @endif
                      @endforeach
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

                  <label for="location" class="col col-form-label text-md-center"><h3>{{ __('Location') }}</h3></label>
                  <div class="form-group row">
                      <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                      <div class="col-md-6">
                          <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $shop->address }}" required>
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
                      <p>Drag the marker to the appropriate location</p>
                      <div class="col-md-12" style="width: 100%; height: 500px">
                        <div id="map" style="width:100%;height:100%"></div>
                        <script type="text/javascript">
                        let map;
                        var shops = [];
                        const philippines = { lat: 15.48650806221586, lng: 120.97341297443519 };

                        async function getShops(id) {
                          let response = await fetch ('{{env("APP_URL")}}/api/shops/' + id);
                          let data = await response.json();

                          return data;
                        };

                        function listShops(data) {
                          var shop = data.shops;

                          document.getElementById("lat").value = shop.lat;
                          document.getElementById("lng").value = shop.lng;

                          shops.push({
                            'title':  shop.name,
                            'position': {lat: shop.lat, lng: shop.lng},
                          });
                        }

                        async function initMap() {
                          await getShops({{$shop->id}})
                          .then(
                            data => listShops(data)
                          );

                          map = new google.maps.Map(document.getElementById("map"), {
                            center: { lat: philippines.lat, lng: philippines.lng },
                            zoom: 14,
                          });

                          for (var i = 0; i < shops.length; i++) {
                            var shop = shops[i];
                            var latlng = new google.maps.LatLng(shop.position.lat, shop.position.lng);
                            var marker = new google.maps.Marker({
                              position: latlng,
                              map: map,
                              title: shop.title,
                              draggable: true,
                            });
                            google.maps.event.addListener(marker, 'dragend', function(event){
                              // When marker is dragged, do this
                              document.getElementById("lat").value = event.latLng.lat();
                              document.getElementById("lng").value = event.latLng.lng();
                            });

                            google.maps.event.addListener(map, 'click', function(event){
                              // When map is clicked, do this
                              marker.setPosition(event.latLng);
                              document.getElementById("lat").value = event.latLng.lat();
                              document.getElementById("lng").value = event.latLng.lng();
                            });
                          }
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
