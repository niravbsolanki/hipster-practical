importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyC-Jpe28WUNtRma60Ec5M0Lfu5u-5OT_aE",
    authDomain: "practical-844aa.firebaseapp.com",
    databaseURL: "https://practical-844aa-default-rtdb.firebaseio.com",
    projectId: "practical-844aa",
    storageBucket: "practical-844aa.appspot.com",
    messagingSenderId: "1053504922767",
    appId: "1:1053504922767:web:feb76b8e2e7f7ad85e3cfa",
    measurementId: "G-XHFCDZKH7L"
});

const messaging = firebase.messaging();

// ✅ Background push handler
messaging.setBackgroundMessageHandler(function(payload) {
  console.log("[firebase-messaging-sw.js] Received background message", payload);

  return self.registration.showNotification(payload.notification.title, {
    body: payload.notification.body,
    icon: payload.notification.icon || "/default-icon.png",
  });
});
