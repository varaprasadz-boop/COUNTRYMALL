importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-auth.js');

firebase.initializeApp({
    apiKey: "AIzaSyCXKXkYfq93-oaJudisP-hq7dkzcdR1e4s",
    authDomain: "country-mall-in.firebaseapp.com",
    projectId: "country-mall-in",
    storageBucket: "country-mall-in.firebasestorage.app",
    messagingSenderId: "56638539518",
    appId: "1:56638539518:web:68a55a0032ffb0915247af",
    measurementId: "G-H0WVMCF3HY"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    return self.registration.showNotification(payload.data.title, {
        body: payload.data.body || '',
        icon: payload.data.icon || ''
    });
});