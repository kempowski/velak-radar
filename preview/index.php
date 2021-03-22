<!DOCTYPE html>
<head>
	<title>velak radar</title>
	<meta carset="UTF-8">
	<!-- normalizes the different default styles of all browsers to one nutral -->
	<link rel="stylesheet" type="text/css" href="styles/norm.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300;600&display=swap" rel="stylesheet">
	<!-- eigenes stylesheet -->
	<link rel="stylesheet" type="text/css" href="styles/stylesheet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>
<body>

    <div id="intro">
    	<h3>First Stream on 27th of february </h3>
    	<p>Velakradar is an online platform hosted by velak – a non-profit organisation for experimental music and soundart based in Vienna. On the Velakradar-Soundmap you can listen to live-streams of spaces and environments all over the world. The live-streams get recorded and will stay accessible to listen to. Just click on the icons on the map in order to listen.</p>

    </div>


    </div>
    <!-- <div id="playPause">
    </div> -->

    <div id="map"></div>

	<script type="text/javascript" >
		// holt sich das php array und macht daraus ein js objekt
		var data = <?php echo json_encode($rows); ?>;
		// console.log(data);

		var markers = [];
		var count;
		var active_m;
	
		// karte aufsetzen
		var map = L.map("map").setView([0, 0], 3);
		map.options.minZoom = 3;
		map.setMaxBounds([[84.67351256610522, -174.0234375], [-58.995311187950925, 223.2421875]]);
		console.log(map.getZoom());
		L.tileLayer("https://api.mapbox.com/styles/v1/zyxetc/ckl5efafz2aqt17mu8abux77z/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1Ijoienl4ZXRjIiwiYSI6ImNra3ZvcWs5ZTA4czIyeG80dnNlZWk5eDEifQ.eeJhDOpUW6uzdsEMnpmlcg", {	
		// L.tileLayer("https://api.mapbox.com/styles/v1/kempowski/ckk2f6lw9357y17qg2kudt7n4/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1Ijoia2VtcG93c2tpIiwiYSI6ImNrazJkaHQ5dDEwNjUycHJyb2NqY2F3YzEifQ.ft44TqrejcgpQFbCS0fe3g", {		// hoehendaten bw
		// L.tileLayer("https://api.maptiler.com/tiles/hillshades/{z}/{x}/{y}.png?key=UOullAIM1M3UqacZg3FU", {		// hoehendaten bw
		// L.tileLayer("https://api.maptiler.com/maps/topographique/256/{z}/{x}/{y}.png?key=UOullAIM1M3UqacZg3FU", {	// topografie
		// L.tileLayer("https://api.maptiler.com/tiles/satellite/{z}/{x}/{y}.jpg?key=UOullAIM1M3UqacZg3FU", {	// raw satellite
		    attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',    
		}).addTo(map);

		// marker icon definieren
		var blackIcon = L.icon({
			// iconUrl: 'images/pin_25x41.png',
			// shadowUrl: 'images/shadow_39x35.png',
			iconUrl: 'images/test.png',
			iconSize: [40, 34],
			shadowSize: [39, 35],
			iconAnchor: [12, 41],
			shadowAnchor: [20, 34]
		});

		var myFeatureGroup = L.featureGroup().addTo(map).on("click", groupClick);
		
		// setzt marker
		for (var i = 0; i < data.length; i++){
			count = i;
			// console.log(typeof(data[i].lng));
			var latitude = parseFloat(data[i].lat);
			var longitude = parseFloat(data[i].lng);
			// console.log(latitude);
			// console.log(longitude);
			var m = new L.marker([latitude, longitude], {icon: blackIcon}).addTo(myFeatureGroup);

			markers.push(m);
			m.count = count;
		}
		console.log(myFeatureGroup);

		var lat = document.getElementById("lat");
		var lng = document.getElementById("lng");

		function groupClick(event) {
		  console.log("Marker: " + event.layer.count);
		  active_m = event.layer.count;
		  console.log(event.layer);
		  map.flyTo(event.latlng, 8);
		  drawContent(active_m);
		}
		// console.log(markers);

		var menu = false;
		var content = document.getElementById("content");
		var video = document.getElementById("video");
		var player = document.getElementById("audioPlayer");
		var audioSource = document.getElementById("audioSource");
		var nameK = document.getElementById("nameK");
		var description = document.getElementById("description");
		var x = document.getElementById("x");

		x.addEventListener("click", function(event){
				content.classList.add("closed");
				content.classList.remove("active");
				menu = false;
				player.pause();
		});

		function drawContent(_index){
			

			if(!menu){
				content.classList.remove("closed");
				content.classList.add("active");
			}

			video.innerHTML = '<iframe width="380" height="228" src="https://www.youtube.com/embed/' + data[_index].ytLink + '?autoplay=1?rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
			
			// audioSource.src = "eintragen/uploads/" + data[_index].fileName;
			// audioSource.setAttribute("type", "audio/wav");

			// player.load();
			// player.play();

			nameK.innerHTML =  data[_index].usersName;
			
			description.innerHTML = data[_index].projectDescription;
			
			menu = true;
		}
	</script>
	<script src="scripts/intro.js"></script>

</body>
</html>
