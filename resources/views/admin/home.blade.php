@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div> -->
        <div class="col-md-3" style="max-height:500px; overflow-y:auto;">
          <div class="card" style="width: 100%;">
            <div class="card-header">
              Barber Shops List
            </div>
            <ul class="list-group list-group-flush" id="shops-list">
            </ul>
          </div>
        </div>

        <div class="col-md-9" style="width: 500px; height: 500px">
          <script type="text/javascript">
          let map;
          var shops = [];
          var markers = [];
          const philippines = { lat: 15.5000569, lng: 120.9109837 };

          async function getShops() {
            let response = await fetch ('http://localhost:8000/api/shops');
            let data = await response.json();
            return data;
          };

          var marker

          function listShops(data) {
            // console.log(data);
            Object.entries(data.shops).forEach(([key, value]) => {
              var listItem = document.createElement('a');
              listItem.href = '#';
              listItem.classList.add('list-group-item', 'list-group-item-action');
              var listItemContent = document.createTextNode(value.name.toString());
              listItem.appendChild(listItemContent);

              listItem.addEventListener("click", () => {
                // map.panTo(new google.maps.LatLng(value.lat, value.lng));
                new google.maps.event.trigger( markers[key], 'click' );
              });

              document.getElementById("shops-list").appendChild(listItem);
              shops.push({
                'title':  value.name,
                'position': {lat: value.lat, lng: value.lng},
              });
              console.log(shops);
            });
          }

          var infowindow;
            async function initMap() {
              await getShops()
              .then(
                data => listShops(data)
              );

              map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 15.5000569, lng: 120.9109837 },
                zoom: 8,
              });

              infowindow = new google.maps.InfoWindow();
              for (var i = 0; i < shops.length; i++) {
                var shop = shops[i];
                var latlng = new google.maps.LatLng(shop.position.lat, shop.position.lng);

                // var infowindow = new google.maps.InfoWindow({
                //   content: contentString,
                // });

                var marker = new google.maps.Marker({
                  position: latlng,
                  map: map,
                  title: shop.title
                });

                markers.push(marker);

                var contentString =
                  '<div id="content">' +
                  '<div id="siteNotice">' +
                  "</div>" +
                  '<h3 id="firstHeading" class="firstHeading">'+ shop.title +'</h3>' +
                  '<div id="bodyContent">' +
                  "<p><b>"+ shop.title +"</b>" +
                  "</div>" +
                  "</div>";

                attachInfoWindow(marker, contentString);

                function attachInfoWindow(marker, info) {
                  // const infowindow = new google.maps.InfoWindow({
                  //   content: info,
                  // });

                  marker.addListener("click", () => {
                    infowindow.setContent(info);
                    infowindow.open(marker.get("map"), marker);
                    map.panTo(marker.getPosition());
                  });
                }
                console.log(marker);
              }

              map.addListener('click', function() {
                if (infowindow) infowindow.close();
              });



              // google.maps.event.addListener(marker, 'dragend', function(event){
              //   // When marker is dragged, do this
              //   document.getElementById("lat").value = event.latLng.lat();
              //   document.getElementById("lng").value = event.latLng.lng();
              // });
            }
          </script>
          <div id="map" style="width:100%;height:100%"></div>
          <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
          <script async src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap"></script>
        </div>
    </div>
</div>
@endsection
