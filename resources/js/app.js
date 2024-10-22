require("./bootstrap");
import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true,
});

window.Echo.channel("chat").listen(".message.sent", (event) => {
    console.log(event.message);
    // Lakukan sesuatu dengan pesan baru, misalnya tambahkan ke UI
});
