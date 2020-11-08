export default class ProfileEdit {
  constructor(el) {
    this.el = el;
    this.findTimeZoneButton = this.el.querySelector('#find_time_zone');
/*
    this.hiddenCountry = document.querySelector('.country-lov');
*/
    if (null != this.findTimeZoneButton) {
      this.findTimeZoneButton.addEventListener('click', this.onFindTimeZoneButtonClicked.bind(this));
    }
/*
    if (null != this.hiddenCountry) {
      this.hiddenCountry.addEventListener('click', this.onHiddenCountryChanged.bind(this));
    }
*/
  }

  onFindTimeZoneButtonClicked(event) {
    event.preventDefault();
    this.getLocation();
  }
/*
  onHiddenCountryChanged(event) {
    event.preventDefault();
    console.log(event);
  }
*/
  getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(this.showPosition);
    } else {
      console.log("Geolocation is not supported by this browser.");
    }
  }

  showPosition(position) {
    if (position.coords) {
      let latitude = position.coords.latitude;
      let longitude = position.coords.longitude;
      let tzlookup = require("tz-lookup");
      let element = document.getElementById('profile_timeZone');
      let timezone = tzlookup(latitude, longitude);
      element.value = timezone;
    }
  }
}

document.querySelectorAll('form[name="profile"]').forEach(widget => new ProfileEdit(widget));
