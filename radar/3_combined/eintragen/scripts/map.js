var map = L.map("map").setView([0, 0], 1);
L.tileLayer("https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=UOullAIM1M3UqacZg3FU", {
    attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',    
}).addTo(map);
var marker = L.marker([48.21271099518516, 16.352115906374642]).addTo(map);

var marker;

var lat = document.getElementById("lat");
var lng = document.getElementById("lng");

map.on('click', function(e) {
    if(marker)
        map.removeLayer(marker);
    console.log(e.latlng); // e is an event object (MouseEvent in this case)
    marker = L.marker(e.latlng).addTo(map);

    lat.value = e.latlng["lat"];
    lng.value = e.latlng["lng"];

});