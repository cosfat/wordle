<script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
<script type="module">
    if( 'function' === typeof importScripts) {
        importScripts('https://js.pusher.com/beams/service-worker.js');
        addEventListener('message', onMessage);

        function onMessage(e) {
            // do some work here
        }
    }
</script>



<script type="module">
    const beamsClient = new PusherPushNotifications.Client({
        instanceId: 'b057dbbd-15b7-48ba-9ce3-6e9bfa5e3bba',
    });

    beamsClient.start()
        .then(() => beamsClient.addDeviceInterest('hello'))
        .then(() => console.log('Successfully registered and subscribed!'))
        .catch(console.error);
</script>
