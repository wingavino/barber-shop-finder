@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" href="#">
                        {{ __('Shop Details') }}
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('shopowner.shop.images') }}">
                        {{ __('Shop Images') }}
                      </a>
                    </li>
                  </ul>
                </div>

                <div class="card-body">
                  <form method="POST" action="#">
                      @csrf
                      <div class="form-group row">
                          <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                          <div class="col-md-6">
                              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ __($shop->name) }}" required autocomplete="name" autofocus readonly>

                              @error('name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <label for="open_hours" class="col col-form-label text-md-center"><h3>{{ __('Open Hours') }}</h3></label>

                      @foreach($open_hours as $i)
                      <div class="form-group row">
                        <label for="open_hours_day_{{$i}}" class="col-md-4 col-form-label text-md-right">
                          @switch($i->day)
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
                          <!-- <div class="input-group-prepend">
                            <div class="input-group-text">
                              <input id="open_hours_day_{{$i}}" type="checkbox" class="@error('open_hours_day_{{$i}}') is-invalid @enderror" name="open_hours_day[]" value="{{$i}}" checked>
                            </div>
                          </div> -->
                          <input id="open_hours_start[{{$i}}]" type="time" class="form-control @error('open_hours_start[{{$i}}]') is-invalid @enderror" name="open_hours_start[{{$i}}]" value="{{ $i->time_start }}" readonly>
                          <input id="open_hours_end[{{$i}}]" type="time" class="form-control @error('open_hours_end[{{$i}}]') is-invalid @enderror" name="open_hours_end[{{$i}}]" value="{{ $i->time_end }}" readonly>
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
                      @endforeach

                      <label for="location" class="col col-form-label text-md-center"><h3>{{ __('Location') }}</h3></label>

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
                          <div class="col-md-12" style="width: 100%; height: 500px">
                            <div id="map" style="width:100%;height:100%"></div>
                            <script type="text/javascript">
                            let map;
                            var shops = [];
                            const philippines = { lat: 15.5000569, lng: 120.9109837 };

                            async function getShops(id) {
                              let response = await fetch ('http://localhost:8000/api/shops/' + id);
                              let data = await response.json();
                              // console.log(data);
                              return data;
                            };

                            function listShops(data) {
                              var shop = data.shops;
                              // console.log(shop);
                              document.getElementById("lat").value = shop.lat;
                              document.getElementById("lng").value = shop.lng;

                              shops.push({
                                'title':  shop.name,
                                'position': {lat: shop.lat, lng: shop.lng},
                              });
                              // console.log(shops);
                            }


                            async function initMap() {
                              await getShops({{$shop->id}})
                              .then(
                                data => listShops(data)
                              );

                              map = new google.maps.Map(document.getElementById("map"), {
                                center: { lat: 15.5000569, lng: 120.9109837 },
                                zoom: 8,
                              });

                              for (var i = 0; i < shops.length; i++) {
                                var shop = shops[i];
                                var latlng = new google.maps.LatLng(shop.position.lat, shop.position.lng);
                                var marker = new google.maps.Marker({
                                  position: latlng,
                                  map: map,
                                  title: shop.title,
                                });
                                google.maps.event.addListener(marker, 'dragend', function(event){
                                  // When marker is dragged, do this
                                  document.getElementById("lat").value = event.latLng.lat();
                                  document.getElementById("lng").value = event.latLng.lng();
                                });
                                // console.log(marker);
                              }
                              // marker.setMap(map);



                            }
                            </script>
                            <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
                            <script async src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap"></script>
                          </div>
                        </div>
                      </div>

                      <div class="form-group row mb-0 justify-content-center">
                          <div class="col-md-6">
                              <a type="button" role="button" href="{{ route('shopowner.shop.edit') }}" class="btn btn-primary col-md-12">
                                  {{ __('Edit') }}
                              </a>
                          </div>
                      </div>
                      <!-- <div class="form-group row mb-0 justify-content-center">
                          <div class="col-md-6">
                              <button type="submit" class="btn btn-primary col-md-12">
                                  {{ __('Save') }}
                              </button>
                          </div>
                      </div> -->
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
