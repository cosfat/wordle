import _ from 'lodash';
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

 import Echo from 'laravel-echo';

 import Pusher from 'pusher-js';
 window.Pusher = Pusher;
var csrf = document.querySelector('meta[name="csrf-token"]').content;
Pusher.logToConsole = true;
 window.Echo = new Echo({
     broadcaster: 'pusher',
     cluster: 'mt1',
     key: "f19ca6a0a53117758a5d",
     forceTLS: true,
     channelAuthorization: {
         endpoint: "/broadcasting/auth",
         headers: { "X-CSRF-Token": csrf },
     },
     authEndpoint: "/broadcasting/auth",
 });


import * as PusherPushNotifications from "@pusher/push-notifications-web";

const beamsClient = new PusherPushNotifications.Client({
    instanceId: "b057dbbd-15b7-48ba-9ce3-6e9bfa5e3bba",
});

beamsClient.start().then(() => {
    // Build something beatiful 🌈
});
