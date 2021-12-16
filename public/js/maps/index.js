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
      'title':  value.name,
      'position': {lat: value.lat, lng: value.lng},
    });
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

        marker.addListener("click", () => {
          infowindow.setContent(info);
          infowindow.open(marker.get("map"), marker);
          map.panTo(marker.getPosition());
        });
      }
    }

    map.addListener('click', function() {
      if (infowindow) infowindow.close();
    });

  }
