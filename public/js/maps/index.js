let map;
var shops = [];
var open_hours = [];
var reviews = [];
var markers = [];
var weekdays = [null, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
const philippines = { lat: 15.5000569, lng: 120.9109837 };

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

    map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: 15.5000569, lng: 120.9109837 },
      zoom: 8,
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
          "</div>" +
          '<h3 id="firstHeading" class="firstHeading">'+ shop.title +'</h3>' +
          '<div id="bodyContent">' +
            "<p><b>("+ shop.position.lat + ", " + shop.position.lng +")</b>";

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
          map.setZoom(13);
        });
      }
    }

    map.addListener('click', function() {
      if (infowindow) infowindow.close();
    });

  }
