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

var marker

function listShops(data) {
  Object.entries(data.shops).forEach(([key, value]) => {
    var listItem = document.createElement('a');
    listItem.href = '#map';
    listItem.classList.add('list-group-item', 'list-group-item-action', 'text-center');
    var bold = document.createElement("strong");
    var listItemContent = document.createTextNode(value.name.toString());
    bold.appendChild(listItemContent);
    var br = document.createElement("br");
    var listItemAddress = document.createTextNode(value.address.toString());

    listItem.appendChild(bold);
    listItem.appendChild(br);
    listItem.appendChild(listItemAddress);

    listItem.addEventListener("click", () => {
      // Triggers a click event on the marker which pans the map and opens the InfoWindow
      new google.maps.event.trigger( markers[key], 'click' );
    });
    document.getElementById("shops-list").appendChild(listItem);

    shops.push({
      'id': value.id,
      'title':  value.name,
      'address': value.address,
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

function listReviews(data) {
  Object.entries(data.reviews).forEach(([key, value]) => {
    reviews.push({
      'id':  value.id,
      'shop_id': value.shop_id,
      'user_id': value.user_id,
      'rating': value.rating,
      'review_text': value.review_text,
      'created_at': value.created_at,
      'updated_at': value.updated_at,
    });
  });
}

function listLogos(data) {
  Object.entries(data.logos).forEach(([key, value]) => {
    logos.push({
      'id':  value.id,
      'shop_id': value.shop_id,
      'user_id': value.user_id,
      'path': value.path,
      'type': value.type,
      'created_at': value.created_at,
      'updated_at': value.updated_at,
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

    await getReviews()
    .then(
      data => listReviews(data),
    );

    await getImages()
    .then(
      data => listLogos(data),
    );

    map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: philippines.lat, lng: philippines.lng },
      zoom: 13,
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
        '<div id="content">' +
          '<div id="siteNotice">' +
          '</div>';
          for (var l = 0; l < logos.length; l++) {
            if (logos[l].shop_id == shop.id) {
              contentString += '<img src="'+app_url+'/img/'+logos[l].path+'" class="img-fluid" style="width: 150px">';
            }
          }
          contentString +=
          '<h3 id="firstHeading" class="firstHeading">'+ shop.title +'</h3>' +
          '<div id="bodyContent">' +
            // "<p><b>("+ shop.position.lat + ", " + shop.position.lng +")</b></p>" +
            "<p>" + shop.address + "</p>"
            ;

        var review_count = 0;
        var rating_total = 0;
        for (var j = 0; j < reviews.length; j++) {
          if (reviews[j].shop_id == shop.id) {
            review_count++;
            rating_total += reviews[j].rating;
          }
        }
        var rating_average = rating_total / review_count;

        if (!$.isNumeric(rating_average)) {
          rating_average = 0;
        }

        contentString += '<p>' + rating_average  + '&#9733; Average from ' + review_count + ' reviews.</p>';

      for (var j = 0; j < open_hours.length; j++) {
        if (open_hours[j].shop_id == shop.id) {
          var time_start = open_hours[j].time_start.slice(0, -3);
          var time_end = open_hours[j].time_end.slice(0, -3);
          var day = weekdays[open_hours[j].day];

          contentString += '<p><b>' + day + '</b> ' + time_start + ' ~ ' + time_end + '</p>';
        }
      }

      contentString +=
            "<a href='" + app_url + "/shop/" + shop.id + "'>View Shop Page</a>" +
          "</div>" +
        "</div>";

      attachInfoWindow(marker, contentString);

      function attachInfoWindow(marker, info) {

        marker.addListener("click", () => {
          infowindow.setContent(info);
          infowindow.open(marker.get("map"), marker);
          map.panTo(marker.getPosition());
          // map.setZoom(15);
        });
      }
    }

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


    map.addListener('click', function() {
      if (infowindow) infowindow.close();
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
