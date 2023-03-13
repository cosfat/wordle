if( 'function' === typeof importScripts) {
    importScripts('https://js.pusher.com/beams/service-worker.js');
    addEventListener('message', onMessage);

    function onMessage(e) {
        // do some work here
    }
}
