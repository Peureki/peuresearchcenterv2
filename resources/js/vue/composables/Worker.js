self.onmessage = function (e) {
    if (e.data === 'start') {
        let interval = setInterval(() => {
        // Your interval-based logic here
        // Post results back to the main thread if needed
            self.postMessage(/* data to send back to main thread */);
        }, 1000);
    } else if (e.data === 'stop') {
        clearInterval(interval);
    }
};