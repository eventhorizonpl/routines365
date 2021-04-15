export default class ReminderMessageShow {
  constructor(el) {
    this.el = el;
    this.token = el.dataset.value;
    this.url = 'http://api.routines365.local/index.php/api/v1/reminder-message/browser-notifications-list';
    this.askNotificationPermission();
    this.backgroundCheck();
  }

  backgroundCheck() {
    let timestamp = parseInt(this.getLastCheckTimestamp());

    if ((timestamp == null) || (timestamp + 10000 < Date.now())) {
      this.checkNotifications();
    }
  }

  checkNotifications() {
    console.log('check');
    console.log(this.url);
    console.log(this.token);
    this.setLastCheckTimestamp();
  }

  getLastCheckTimestamp() {
    return localStorage.getItem('lastCheckTimestamp');
  }

  setLastCheckTimestamp() {
    return localStorage.setItem('lastCheckTimestamp', Date.now());
  }

  askNotificationPermission() {
    function checkNotificationPromise() {
      try {
        Notification.requestPermission().then();
      } catch(e) {
        return false;
      }

      return true;
    }
    // function to actually ask the permissions
    function handlePermission(permission) {
      // set the button to shown or hidden, depending on what the user answers
      if(Notification.permission === 'denied' || Notification.permission === 'default') {
        notificationBtn.style.display = 'block';
      } else {
        notificationBtn.style.display = 'none';
      }
    }

    // Let's check if the browser supports notifications
    if (!('Notification' in window)) {
      console.log("This browser does not support notifications.");
    } else {
      if (checkNotificationPromise()) {
        console.log('aa');
        Notification.requestPermission();
/*
        Notification.requestPermission()
        .then((permission) => {
          handlePermission(permission);
        })
*/
      } else {
        console.log('bbb');
/*
        Notification.requestPermission(function(permission) {
          handlePermission(permission);
        });
*/
      }
    }
  }
}

document.querySelectorAll('#token').forEach(widget => new ReminderMessageShow(widget));
