let map;
var shops = [];
var open_hours = [];
var reviews = [];
var logos = [];
var markers = [];
var services = [];
var weekdays = [null, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
const philippines = { lat: 15.48650806221586, lng: 120.97341297443519 };
var radiusCircle;


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

function haversine_distance(mk1, mk2) {
  var R = 6371.0710; // Radius of the Earth in miles
  var rlat1 = mk1.position.lat() * (Math.PI/180); // Convert degrees to radians
  var rlat2 = mk2.position.lat() * (Math.PI/180); // Convert degrees to radians
  var difflat = rlat2-rlat1; // Radian difference (latitudes)
  var difflon = (mk2.position.lng()-mk1.position.lng()) * (Math.PI/180); // Radian difference (longitudes)

  var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat/2)*Math.sin(difflat/2)+Math.cos(rlat1)*Math.cos(rlat2)*Math.sin(difflon/2)*Math.sin(difflon/2)));
  return d;
}

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: philippines.lat, lng: philippines.lng },
    zoom: 13,
    disableDefaultUI: true,
    zoomControl: true,
    streetViewControl: true,
  });

  var blueCircle = {
        strokeColor: "#a3acf9",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#a3acf9",
        fillOpacity: 0.35,
        map: map,
        center: map.center,
        radius: 5000 // in meters
    };
  radiusCircle = new google.maps.Circle(blueCircle);

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

function getDistance(marker1, marker2, addUnit=false) {
  if (addUnit) {
    return haversine_distance(marker1, marker2).toFixed(2) + " km";
  }else {
    return haversine_distance(marker1, marker2);
  }

}

function updateRadius(radiusCircle, marker, radius=null) {
  if (radius != null) {
    radiusCircle.setRadius(Number(radius * 1000));
    radiusCircle.setCenter(marker.position);
  }else {
    radiusCircle.setCenter(marker.position);
  }
}

function showPosition(position, device) {
  device.position = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
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

function sortShopList(a, b){
    return ($(b).data('distance')) < ($(a).data('distance')) ? 1 : -1;
}

$(document).ready(function(){
  var device = {
    position: new google.maps.LatLng(
      philippines.lat,
      philippines.lng
    )
  }
  getLocation(device);

  $('#max_distance').on('input', function() {
    $('#max_distance_indicator').text(this.value);
    updateRadius(radiusCircle, device, this.value);
  });

  $('#max_distance').on('change', function() {
    $('#max_distance_indicator').text(this.value);
    updateLocation(device);
    updateShopList($('input[type=radio][name=type]:checked').val(), services);
  });

  $('input[type=radio][name=type]').change(function() {
    updateShopList(this.value, services);
  });

  $("input[type=checkbox][name='service[]']").change(function() {
    if (this.checked) {
      services.push(this.value);
    }else {
      services.splice($.inArray(this.value, services), 1);
    }
    updateShopList($('input[type=radio][name=type]:checked').val(), services);
  });

  function getLocation(device) {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          device.position = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
          // console.log('Location enabled: ' + device.position);
          updateRadius(radiusCircle, device);
          updateShopList($('input[type=radio][name=type]:checked').val(), services);
          map.panTo(device.position);
        },
        () => {
          device.position = new google.maps.LatLng(philippines.lat, philippines.lng);
          // console.log('Location disabled: ' + device.position);
          updateRadius(radiusCircle, device);
          updateShopList($('input[type=radio][name=type]:checked').val(), services);
          map.panTo(device.position);
        }
      );
    }else {
      device.position = new google.maps.LatLng(philippines.lat, philippines.lng);
      // console.log('Location permission not available: ' + device.position);
      updateRadius(radiusCircle, device);
      updateShopList($('input[type=radio][name=type]:checked').val(), services);
      map.panTo(device.position);
    }
  }

  function updateLocation(device) {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          device.position = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
          // console.log('Location enabled: ' + device.position);
          updateRadius(radiusCircle, device);
        },
        () => {
          device.position = new google.maps.LatLng(philippines.lat, philippines.lng);
          // console.log('Location disabled: ' + device.position);
          updateRadius(radiusCircle, device);
        }
      );
    }else {
      device.position = new google.maps.LatLng(philippines.lat, philippines.lng);
      updateRadius(radiusCircle, device);
      // console.log('Location permission not available: ' + device.position);
    }
  }

  function updateShopList(shopType, services=null){
    $.ajax({
      url:'/shops/list',
      type:'GET',
      data: {
        type: shopType,
        services: services,
      },
      dataType:'json',
      success:function(response){
        // Clear Previous Search
        $.each(markers, function (key, mark) {
          mark.setMap(null);
        });
        markers = [];
        $('#shops-list').empty();

        // Loop through returned shops list
        $.each(response.shops, function(key, shop) {
          var marker = new google.maps.Marker({
            position: new google.maps.LatLng(shop.lat, shop.lng),
            map: map,
            title: shop.name
          });

          // Removes map marker if not within radius
          if (getDistance(device, marker) > $("#max_distance").val() && radiusCircle.radius > 0) {
            marker.setMap(null);
            return;
          }

          markers.push(marker);

          var listItem = '<a href="#map"><li class="list-group-item list-group-item-action text-center">'+ shop.name +'</li></a>';

          var listItem = document.createElement('a');
          listItem.href = '#map';
          listItem.classList.add('list-group-item', 'list-group-item-action', 'text-center');
          var bold = document.createElement("strong");
          var listItemContent = document.createTextNode(shop.name.toString());
          bold.appendChild(listItemContent);
          var br = document.createElement("br");
          var listItemAddress = document.createTextNode(shop.address.toString());

          listItem.appendChild(bold);
          listItem.appendChild(br);
          listItem.appendChild(listItemAddress);

          var br = document.createElement("br");
          listItem.appendChild(br);

          updateLocation(device);
          var listItemDistance = document.createTextNode(getDistance(device, marker, true));
          listItem.appendChild(listItemDistance);
          $(listItem).data('distance', getDistance(device, marker));

          $(listItem).on("click", () => {
            // Triggers a click event on the marker which pans the map and opens the InfoWindow
            new google.maps.event.trigger( marker, 'click' );
          });


          $('#shops-list').append(listItem);

          var contentString =
            '<div id="content">' +
              '<div id="siteNotice">' +
              '</div>' +
              '<a href="' + app_url +'/shop/' + shop.id + '">';
              $.ajax({
                url:'/shop/'+shop.id+'/logo',
                type:'GET',
                dataType:'json',
                success:function(response){
                  if (!$.isEmptyObject(response)) {
                    contentString += '<img src="/img/'+ response.path +'" class="img-fluid" style="width: 150px">';
                  }
                },complete:function(){
                  contentString +=
                    '<h3 id="firstHeading" class="firstHeading">'+ shop.name +'</h3>' +
                    '</a>' +
                    '<div id="bodyContent">' +
                      "<p>" + shop.address + "</p>";
                  $.ajax({
                    url:'/shop/'+shop.id+'/ratings',
                    type:'GET',
                    dataType:'json',
                    success:function(response){
                      console.log(response);
                      if (response.review_count > 0) {
                        // contentString += "<p>" + (parseFloat(response.review_average)).toFixed(2) + "&#9733 (" + response.review_count + ")</p>";
                        contentString += "<p>" + response.review_average + "&#9733 (" + response.review_count + " reviews)</p>";
                      }else {
                        contentString += "<p>0&#9733"+ " (" + response.review_count + " reviews)</p>";
                      }
                    },complete:function(){
                      $.ajax({
                        url:'/shop/'+shop.id+'/open_hours',
                        type:'GET',
                        dataType:'json',
                        success:function(response){
                          $.each(response, function(key, open_hours) {
                            contentString += '<p><b>' + weekdays[open_hours.day] + '</b> ' + open_hours.time_start.slice(0, -3) + ' ~ ' + open_hours.time_end.slice(0, -3) + '</p>';
                          })
                        },complete:function(){
                          contentString+=
                          "<a href='" + app_url + "/shop/" + shop.id + "'>View Shop Page</a>" +
                          "</div>" +
                          "</div>";
                          attachInfoWindow(marker, contentString);
                        }
                      })
                    }
                  })
                }
              })


        });

        // After Looping through Shops List
        $("#shops-list a").sort(sortShopList) // sort elements
                .appendTo('#shops-list'); // append again to the list
        // console.log(markers);
      },error:function(err){

      }
    })
  }
  updateShopList($('input[type=radio][name=type]:checked').val(), services);
});
