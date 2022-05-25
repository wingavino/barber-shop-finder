let map;
var shops = [];
var open_hours = [];
var reviews = [];
var logos = [];
var markers = [];
var weekdays = [null, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
const philippines = { lat: 15.48650806221586, lng: 120.97341297443519 };

async function getShops() {
  let response = await fetch (app_url + '/api/shops');
  let data = await response.json();
  return data;
};

async function getOpenHours() {
  let response = await fetch (app_url +'/api/open_hours');
  let data = await response.json();
  return data;
};

async function getReviews() {
  let response = await fetch (app_url + '/api/reviews');
  let data = await response.json();
  return data;
};

async function getImages() {
  let response = await fetch (app_url + '/api/images');
  let data = await response.json();
  return data;
};

async function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: philippines.lat, lng: philippines.lng },
    zoom: 13,
    disableDefaultUI: true,
    zoomControl: true,
    streetViewControl: true,
  });

  infowindow = new google.maps.InfoWindow();

  map.addListener('click', function() {
    if (infowindow) infowindow.close();
  });

  const locationButton = document.createElement("button");

  locationButton.textContent = "Go to Current Location";
  locationButton.classList.add("custom-map-control-button");
  map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
  locationButton.addEventListener("click", () => {
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };

          infowindow.setPosition(pos);
          infowindow.setContent("Location found.");
          // infowindow.open(map);
          map.setCenter(pos);
        },
        () => {
          handleLocationError(true, infowindow, map.getCenter());
        }
      );
    } else {
      // Browser doesn't support Geolocation
      handleLocationError(false, infowindow, map.getCenter());
    }
  });
}

function attachInfoWindow(marker, info) {

  marker.addListener("click", () => {
    infowindow.setContent(info);
    infowindow.open(marker.get("map"), marker);
    map.panTo(marker.getPosition());
    // map.setZoom(15);
  });
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(
    browserHasGeolocation
      ? "Error: The Geolocation service failed."
      : "Error: Your browser doesn't support geolocation."
  );
  infoWindow.open(map);
}
