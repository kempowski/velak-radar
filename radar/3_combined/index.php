<!DOCTYPE html>
<head>
	<title>velak radar</title>
	<meta carset="UTF-8">
	<!-- normalizes the different default styles of all browsers to one nutral -->
	<link rel="stylesheet" type="text/css" href="styles/norm.css">
	<!-- own stylesheet -->
	<link rel="stylesheet" type="text/css" href="styles/stylesheet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>
<body>

    
    <div id="content" class="closed">
    	<!-- <div id="x">X</div> -->
    	<img id="x" src="images/x.png">
    	<div id="video"></div>
    	<audio id="audioPlayer" controls>
    		<source id="audioSource">
    	</audio>
    	<div id="text">
	    	<h1 id="projekt"></h1>
	    	<h1 id="nameK"></h1>
	    	<p id="description"></p>
    	</div>
    </div>
    <!-- <div id="playPause">
    </div> -->

    <div id="map"></div>
    <?php

    	$servername = "localhost:3309";
		$dbUsername = "root";
		$dbPassword = "1234";
		$dbName = "klingt_org";

		// connection
		$con = new mysqli($servername, $dbUsername, $dbPassword, $dbName);
		if( !conn ) {
			die("Connection failed: " . mysqli_connect_error());
		}
		// mysql abfrage
		$sql = "SELECT usersName, projectName, projectDescription, ytLink, lat, lng, fileName FROM test";
		// resultat
		$result = $con->query($sql);

		// $response = $result->fetch_all($sql);
		// print_r($result);
		$json = json_encode($result);
		// echo $json;


		if ($result->num_rows > 0) {
		// output data of each row
			while($row = $result->fetch_assoc()) {
				//konvertiert das php objekt in ein php array
				$rows[] = $row;
			}
		} else {
			echo "0 results";
		}
		// var_dump($rows);

		$con->close();
    ?>


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
		console.log(map.getZoom());
		L.tileLayer("https://api.maptiler.com/tiles/hillshades/{z}/{x}/{y}.png?key=UOullAIM1M3UqacZg3FU", {		// hoehendaten bw
		// L.tileLayer("https://api.maptiler.com/maps/topographique/256/{z}/{x}/{y}.png?key=UOullAIM1M3UqacZg3FU", {	// topografie
		// L.tileLayer("https://api.maptiler.com/tiles/satellite/{z}/{x}/{y}.jpg?key=UOullAIM1M3UqacZg3FU", {	// raw satellite
		    attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',    
		}).addTo(map);

		// marker icon definieren
		var blackIcon = L.icon({
			iconUrl: 'images/pin_25x41.png',
			shadowUrl: 'images/shadow_39x35.png',
			iconSize: [25, 41],
			shadowSize: [39, 35],
			iconAnchor: [12, 41],
			shadowAnchor: [9, 32]
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
		  map.flyTo(event.latlng, 13);
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

			video.innerHTML = '<iframe width="500" height="315" src="https://www.youtube.com/embed/' + data[_index].ytLink + '?autoplay=1?rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
			
			audioSource.src = "eintragen/uploads/" + data[_index].fileName;
			audioSource.setAttribute("type", "audio/wav");

			player.load();
			player.play();

			nameK.innerHTML =  data[_index].usersName;
			
			description.innerHTML = data[_index].projectDescription;
			
			menu = true;
		}
	</script>
</body>
</html>
