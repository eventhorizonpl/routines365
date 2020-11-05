var tzlookup = require("tz-lookup");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    console.log("Geolocation is not supported by this browser.");
  }
}

function showPosition(position) {
  if (position.coords) {
    let latitude = position.coords.latitude;
    let longitude = position.coords.longitude;
    let timezone = tzlookup(latitude, longitude);
    let element = document.getElementById('profile_timeZone');
    element.value = timezone;
  }
}

getLocation();
