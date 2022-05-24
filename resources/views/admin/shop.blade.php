@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-2 col-sm-4">
        @isset($logo)
        <img src="{{ asset('img/'.Auth::user()->id.'/'.$logo->path) }}" class="img-fluid" alt="...">
        @endisset
      </div>
      <div class="col-8 col-sm-12 text-center">
        <h2>{{ $shop->name }}</h2>
        <h5>{{ $shop->address }}</h5>
      </div>

      <div class="col-md-12">
          <div class="card">
              <div class="card-header">
                @include('admin.shop-nav-tabs')
              </div>

              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <form method="POST" action="#">
                      @csrf
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

                      <div class="form-group row mb-0">
                        <label for="edit" class="col-md-4 col-form-label"></label>
                        <div class="col-md-6">
                          <a type="button" role="button" href="{{ route('shopowner.shop.edit') }}" class="btn btn-primary col-md-12">
                            {{ __('Edit') }}
                          </a>
                        </div>
                      </div>

                      <label for="location" class="col col-form-label text-md-center"><h3>{{ __('Location') }}</h3></label>
                      <div class="form-group row">
                          <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                          <div class="col-md-6">
                              <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $shop->address }}" readonly>
                          </div>
                      </div>

                    </form>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <!-- <label for="location" class="col-md-4 col-form-label text-md-right">{{ __('Location') }}</label> -->
                    <div class="col-md-12" style="width: 100%; height: 500px">
                      <div id="map" style="width:100%;height:100%"></div>
                      <script type="text/javascript">
                        let map;
                        var shops = [];
                        const philippines = { lat: 15.5000569, lng: 120.9109837 };

                        async function getShops(id) {
                          let response = await fetch ('{{ env("APP_URL")}}/api/shops/' + id);
                          let data = await response.json();
                          // console.log(data);
                          return data;
                        };

                        function listShops(data) {
                          var shop = data.shops;
                          // console.log(shop);
                          // document.getElementById("lat").value = shop.lat;
                          // document.getElementById("lng").value = shop.lng;

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
                            center: { lat: {{$shop->lat}}, lng: {{$shop->lng}} },
                            zoom: 14,
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
              </div>
          </div>
      </div>
    </div>
</div>
@endsection
