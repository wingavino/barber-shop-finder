let map;
var shops = [];
var open_hours = [];
var markers = [];
var weekdays = [null, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
const philippines = { lat: 15.5000569, lng: 120.9109837 };

async function getShops() {
  let response = await fetch ('http://localhost:8000/api/shops');
  let data = await response.json();
  return data;
};

async function getOpenHours() {
  let response = await fetch ('http://localhost:8000/api/open_hours');
  let data = await response.json();
  return data;
};

var marker

function listShops(data) {
  Object.entries(data.shops).forEach(([key, value]) => {
    var listItem = document.createElement('a');
    listItem.href = '#';
    listItem.classList.add('list-group-item', 'list-group-item-action');
    var listItemContent = document.createTextNode(value.name.toString());
    listItem.appendChild(listItemContent);

    listItem.addEventListener("click", () => {
      // Triggers a click event on the marker which pans the map and opens the InfoWindow
      new google.maps.event.trigger( markers[key], 'click' );
    });
    document.getElementById("shops-list").appendChild(listItem);

    shops.push({
      'id': value.id,
      'title':  value.name,
      'position': {lat: value.lat, lng: value.lng},
    });
  });
}

function listOpenHours(data) {
  Object.entries(data.open_hours).forEach(([key, value]) => {
    open_hours.push({
      'id':  value.id,
      'shop_id': value.shop_id,
      'day': value.day,
      'time_start': value.time_start,
      'time_end': value.time_end,
    });
  });
}

var infowindow;
  async function initMap() {
    await getShops()
    .then(
      data => listShops(data),
    );

    await getOpenHours()
    .then(
      data => listOpenHours(data),
    );

    map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: 15.5000569, lng: 120.9109837 },
      zoom: 8,
      styles: [
        { elementType: "geometry", stylers: [{ color: "#333333" }] },
        { elementType: "labels.text.stroke", stylers: [{ color: "#242f3e" }] },
        { elementType: "labels.text.fill", stylers: [{ color: "#746855" }] },
        {
          featureType: "administrative.locality",
          elementType: "labels.text.fill",
          stylers: [{ color: "#d59563" }],
        },
        {
          featureType: "poi",
          elementType: "labels.text.fill",
          stylers: [{ color: "#d59563" }],
        },
        {
          featureType: "poi.park",
          elementType: "geometry",
          stylers: [{ color: "#263c3f" }],
        },
        {
          featureType: "poi.park",
          elementType: "labels.text.fill",
          stylers: [{ color: "#6b9a76" }],
        },
        {
          featureType: "road",
          elementType: "geometry",
          stylers: [{ color: "#38414e" }],
        },
        {
          featureType: "road",
          elementType: "geometry.stroke",
          stylers: [{ color: "#212a37" }],
        },
        {
          featureType: "road",
          elementType: "labels.text.fill",
          stylers: [{ color: "#9ca5b3" }],
        },
        {
          featureType: "road.highway",
          elementType: "geometry",
          stylers: [{ color: "#746855" }],
        },
        {
          featureType: "road.highway",
          elementType: "geometry.stroke",
          stylers: [{ color: "#1f2835" }],
        },
        {
          featureType: "road.highway",
          elementType: "labels.text.fill",
          stylers: [{ color: "#f3d19c" }],
        },
        {
          featureType: "transit",
          elementType: "geometry",
          stylers: [{ color: "#2f3948" }],
        },
        {
          featureType: "transit.station",
          elementType: "labels.text.fill",
          stylers: [{ color: "#d59563" }],
        },
        {
          featureType: "water",
          elementType: "geometry",
          stylers: [{ color: "#17263c" }],
        },
        {
          featureType: "water",
          elementType: "labels.text.fill",
          stylers: [{ color: "#515c6d" }],
        },
        {
          featureType: "water",
          elementType: "labels.text.stroke",
          stylers: [{ color: "#17263c" }],
        },
      ],
    });

    infowindow = new google.maps.InfoWindow();
    for (var i = 0; i < shops.length; i++) {
      var shop = shops[i];
      var latlng = new google.maps.LatLng(shop.position.lat, shop.position.lng);
      var shop_open_hours = [];


      var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: shop.title
      });

      markers.push(marker);

      var contentString =
        '<div id="content" class="text-black">' +
          '<div id="siteNotice">' +
          "</div>" +
          '<h3 id="firstHeading" class="firstHeading">'+ shop.title +'</h3>' +
          '<div id="bodyContent">' +
            "<p><b>("+ shop.position.lat + ", " + shop.position.lng +")</b>";

      for (var j = 0; j < open_hours.length; j++) {
        if (open_hours[j].shop_id == shop.id) {
          var time_start = open_hours[j].time_start.slice(0, -3);
          var time_end = open_hours[j].time_end.slice(0, -3);
          var day = weekdays[open_hours[j].day];

          contentString += '<p><b>' + day + '</b> ' + time_start + ' ~ ' + time_end + '</p>';
        }
      }

      contentString +=
            "<a class='text-black' href='http://localhost:8000/shop/" + shop.id + "'>View Shop Page</a>" +
          "</div>" +
        "</div>";

      attachInfoWindow(marker, contentString);

      function attachInfoWindow(marker, info) {

        marker.addListener("click", () => {
          infowindow.setContent(info);
          infowindow.open(marker.get("map"), marker);
          map.panTo(marker.getPosition());
          map.setZoom(13);
        });
      }
    }

    map.addListener('click', function() {
      if (infowindow) infowindow.close();
    });

  }
