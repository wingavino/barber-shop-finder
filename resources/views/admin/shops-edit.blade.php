@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>{{ __('Edit Shop Details') }}</h3></div>

                <div class="card-body">
                  <form method="POST" action="{{ route('admin.shops.edit', [$shop->id]) }}">
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
                          <label for="owner_id" class="col-md-4 col-form-label text-md-right">{{ __('Owner Name') }}</label>

                          <div class="col-md-6">
                              <!-- <input id="owner_name" type="text" class="form-control @error('owner_name') is-invalid @enderror" name="owner_name" value="{{ old('owner_name') }}" required autocomplete="owner_name"> -->
                              <select class="custom-select" id="owner_id" name="owner_id" aria-label="Select Owner Name">
                                <option value="">None</option>
                                @if ($shop->owner_id == 1)
                                  <option value="1" selected>Admin</option>
                                @else
                                  <option value="1">Admin</option>
                                @endif
                                @foreach($shopowners as $shopowner)
                                  @if (isset($shop->user->id) && $shop->user->id == $shopowner->id)
                                    <option value="{{$shopowner->id}}" selected>{{$shopowner->id . ' - ' . $shopowner->name}}</option>
                                  @else
                                    <option value="{{$shopowner->id}}">{{$shopowner->id . ' - ' . $shopowner->name}}</option>
                                  @endif
                                @endforeach
                              </select>

                              @error('owner_name')
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
                            var shops = [];
                            const philippines = { lat: 15.5000569, lng: 120.9109837 };

                            async function getShops(id) {
                              let response = await fetch ('{{env("APP_URL")}}/api/shops/' + id);
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
                                  draggable: true,
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

                      <!-- <div class="form-group row">
                          <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Mobile') }}</label>

                          <div class="col-md-6">
                              <input id="name" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ __(Auth::user()->mobile) }}" autocomplete="mobile">

                              @error('mobile')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div> -->

                      <!-- <div class="form-group row">
                          <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                          <div class="col-md-6">
                              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ __(Auth::user()->email) }}" required autocomplete="email">

                              @error('email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div> -->

                      <!-- <div class="form-group row">
                          <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                          <div class="col-md-6">
                              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                              @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                          <div class="col-md-6">
                              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                          </div>
                      </div> -->

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
