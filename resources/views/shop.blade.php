@extends('layouts.app')

@section('content')

<script>
$(document).ready(function(){
  function updateCurrentTicket(){
    $.ajax({
      url:'/queue/{{ $shop->queue->id }}/current_ticket',
      type:'GET',
      dataType:'json',
      success:function(response){
        var current_ticket = '';
        var btn_status = '';
        var queue_length = 0;

        if(response.queue.current_ticket){
          current_ticket = response.queue.current_ticket;

          $('#current_ticket').removeClass('btn-danger').addClass('btn-primary');
        }else {
          current_ticket = 'None';

          $('#current_ticket').removeClass('btn-primary').addClass('btn-danger');
        }

        if (response.queue_length) {
          queue_length = response.queue_length;
        }

        $('#current_ticket').empty();
        $('#queue_length').empty();
        $('#current_ticket').append(current_ticket);
        $('#queue_length').append('Current Queue Length: ' + queue_length);

      },error:function(err){
        $('#current_ticket').empty();
        $('#queue_length').empty();
      }
    }).then(function(){
      setTimeout(updateCurrentTicket, 3000);
    });
  }
  updateCurrentTicket();
});
</script>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-2 col-sm-4">
      @isset($logo)
      <img src="{{ asset('img/'.$logo->path) }}" class="img-fluid" alt="...">
      @endisset
    </div>
    <div class="col-8 col-sm-12 text-center">
      <h2>{{ $shop->name }}</h2>
      <h5>{{ $shop->address }}</h5>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          @include('shop-nav-tabs')
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-md-8 order-last order-md-first">
              <form method="POST" action="#">
                @csrf

                <label for="open_hours" class="col col-form-label text-md-center"><h3>{{ __('Open Hoursssss') }}</h3></label>

                @foreach($open_hours as $i)
                <div class="form-group row">
                  <label for="open_hours_day_{{$i}}" class="col-md-3 col-form-label text-md-right">
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
                  <div class="col-md-9 input-group">
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

                <label for="contact" class="col col-form-label text-md-center"><h3>{{ __('Contact Information') }}</h3></label>
                @isset($shop->owner_name)
                <div class="form-group row">
                  <label for="owner_name" class="col-md-3 col-form-label text-md-right">{{ __('Owner\'s Name') }}</label>

                  <div class="col-md-9">
                    <input id="owner_name" type="text" class="form-control @error('owner_name') is-invalid @enderror" name="owner_name" value="{{ $shop->owner_name }}" readonly>
                  </div>
                </div>
                @endisset
                @isset($shop->user->mobile)
                <div class="form-group row">
                  <label for="owner_number" class="col-md-3 col-form-label text-md-right">{{ __('Owner\'s Phone Number') }}</label>

                  <div class="col-md-9">
                    <input id="owner_number" type="text" class="form-control @error('owner_number') is-invalid @enderror" name="owner_number" value="{{ $shop->user->mobile }}" readonly>
                  </div>
                </div>
                @endisset
                @isset($shop->mobile)
                <div class="form-group row">
                  <label for="mobile" class="col-md-3 col-form-label text-md-right">{{ __('Shop Phone Number') }}</label>

                  <div class="col-md-9">
                    <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ $shop->mobile }}" readonly>
                  </div>
                </div>
                @endisset

                <label for="location" class="col col-form-label text-md-center"><h3>{{ __('Location') }}</h3></label>
                <div class="form-group row">
                    <label for="address" class="col-md-3 col-form-label text-md-right">{{ __('Address') }}</label>

                    <div class="col-md-9">
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $shop->address }}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                </div>
              </form>
            </div>
            <!-- Queue -->
              <div class="col-md-4 order-first order-md-last">
                <div class="card">
                <div class="card-header">
                  Queue
                </div>

                  <div class="card-body">
                    @if($shop->owner_id)
                      <h3>Now Serving:
                        <button id="current_ticket" class="btn btn-danger disabled" type="button" name="button">None</button>
                      </h3>

                      <h3 id="queue_length">
                        Current Queue Length:
                        @isset($shop->queue->ticket)
                          {{ $shop->queue->ticket->count() }}
                        @endisset
                      </h3>

                      @auth
                        @if(Auth::user()->ticket->where('queue_id', $shop->queue->id)->first())
                          @if(Auth::user()->ticket->where('queue_id', $shop->queue->id)->first()->queue->shop_id == $shop->id)
                            <h3>Your Ticket:
                              <button class="btn btn-success disabled" type="button" name="button">
                                {{ Auth::user()->ticket->where('queue_id', $shop->queue->id)->first()->ticket_number }}
                              </button>
                            </h3>
                            <form method="POST" action="{{ route('shop.ticket.cancel', [$shop->id]) }}">
                              @csrf
                              <div class="form-group row mb-0 justify-content-center">
                                <button type="submit" class="btn btn-danger col-md-12">
                                  {{ __('Cancel Ticket') }}
                                </button>
                              </div>
                            </form>
                            @endif
                        @else
                          @if($shop->queue->is_closed)
                            <div class="form-group row mb-0 justify-content-center">
                              <button class="btn btn-danger col-md-12 disabled">
                                {{ __('Queue is closed') }}
                              </button>
                            </div>
                          @else
                            @if(Auth::user()->type == 'user')
                            <form method="POST" action="{{ route('shop.ticket', [$shop->id]) }}">
                              @csrf
                              <div class="form-group row mb-0 justify-content-center">
                                <button type="submit" class="btn btn-success col-md-12">
                                  {{ __('Get New Ticket') }}
                                </button>
                              </div>
                            </form>
                            @endif
                          @endif
                        @endif
                      @else
                        @if($shop->queue->is_closed)
                          <div class="form-group row mb-0 justify-content-center">
                            <button class="btn btn-danger col-md-12 disabled">
                              {{ __('Queue is closed') }}
                            </button>
                          </div>
                        @endif
                      @endauth
                    @else
                      <h3>Queueing online unavailable for this shop</h3>
                    @endif
                  </div>
                </div>
              </div>
            <!-- /Queue -->
          </div>

          <div class="row">
            <div class="col-md-12">
                <div class="col" style="width: 100%; height: 500px">
                  <div id="map" style="width:100%;height:100%"></div>
                <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
                <script type="text/javascript">
                  let map;
                  var shops = [];
                  const philippines = { lat: 15.5000569, lng: 120.9109837 };
                  
                  async function getShops(id) {
                    let response = await fetch ('{{ env("APP_URL")}}/api/shops/' + id);
                    let data = await response.json();
                    return data;
                  };

                  function listShops(data) {
                    var shop = data.shops;
                    // console.log(shop);


                    shops.push({
                      'title':  shop.name,
                      'position': {lat: shop.lat, lng: shop.lng},
                    });
                  }


                  async function initMap() {
                    const icon = document.createElement("div");
                    icon.innerHTML = '<i class="fa-solid fa-scissors"></i>'

                    const faPin = new google.maps.marker.PinElement({
                      glyph: icon,                      
                    });

                    await getShops({{$shop->id}})
                    .then(
                      data => listShops(data)
                    );

                    map = new google.maps.Map(document.getElementById("map"), {
                      center: { lat: {{$shop->lat}}, lng: {{$shop->lng}} },
                      zoom: 14,
                      mapId: 'f1371a49d1f250fc',
                    });

                    for (var i = 0; i < shops.length; i++) {
                      var shop = shops[i];
                      var latlng = new google.maps.LatLng(shop.position.lat, shop.position.lng);
                      var marker = new google.maps.marker.AdvancedMarkerElement({
                        position: latlng,
                        map: map,
                        title: shop.title,
                        content: faPin.element
                      });
                      google.maps.event.addListener(marker, 'dragend', function(event){
                        // When marker is dragged, do this

                      });
                    }
                  }
                </script>
                <script async src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap&libraries=marker"></script>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
