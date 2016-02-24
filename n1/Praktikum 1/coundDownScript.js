//väikeste täiendustega, aga põhimõtteliselt http://stackoverflow.com/questions/6981838/timestamp-countdown-in-javascript-and-php

    // tunni plaani märgitud eksami lõpu aja timestamp 1465126200000

var timestamp = 1465126200000 - Date.now();

timestamp /= 1000; // from ms to seconds

function component(x, v) {
    return Math.floor(x / v);
}

//var $div = $('div');

setInterval(function() { // execute code each second

    timestamp--; // decrement timestamp with one second each second

    var days    = component(timestamp, 24 * 60 * 60),      // calculate days from timestamp
        hours   = component(timestamp,      60 * 60) % 24, // hours
        minutes = component(timestamp,           60) % 60, // minutes
        seconds = component(timestamp,            1) % 60; // seconds

    if(1465126200000 > Date.now()){
            document.getElementById("time").innerHTML = "Eksami lõpuni on: " + days + " päeva, " + hours + ":" + minutes + ":" + seconds;
    } else document.getElementById("time").innerHTML = "Eksami on läbi. Istu. Viis.";


}, 1000); // interval each second = 1000 ms