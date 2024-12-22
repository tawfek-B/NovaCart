// import './bootstrap';
import Pusher from 'pusher-js';

// Initialize Pusher
const pusher = new Pusher('89c88cd7ae2be1594e4c', {
    cluster: 'mt1',
});

// Subscribe to the 'messages' channel
const channel = pusher.subscribe('NovaCart');

// Bind to the 'message.sent' event
channel.bind('OrderShipmentStatusUpdated', function(data) {
    console.log('Received message:', data.message);
});
