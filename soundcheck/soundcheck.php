<!DOCTYPE html>
<head>
	<title>soundcheck</title>
	<meta carset="UTF-8">
	<!-- normalizes the different default styles of all browsers to one nutral -->
	<link rel="stylesheet" type="text/css" href="styles/norm.css">
	<!-- google fonts -->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300;600&display=swap" rel="stylesheet">
	<!-- eigenes stylesheet -->
	<link rel="stylesheet" type="text/css" href="styles/stylesheet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

	<script src="scripts/ytplayer.js"></script>

</head>
<body>

    <div id="intro">soundcheck</h2>
    	
    	<p class="fade-in" id="click">click</p>
    </div>

    <div id="content" class="closed">
    	<!-- <div id="x">X</div> -->
    	<img id="x" src="images/x_2.png">
    	<div id="videoWrap">
	    	<div id="video"></div>
    	</div>
    	<audio id="audioPlayer" controls>
    		<source id="audioSource">
    	</audio>
    	<div id="text">
	    	<h1 id="projekt"></h1>
	    	<h2 id="nameK"></h2>
	    	<p id="description"></p>
	    	<a id="website" href=""></a>
    	</div>
    </div>
    <!-- <div id="playPause">
    </div> -->

    <div id="map"></div>

    <?php
    	include "../db.php";

		// connection
		$con = new mysqli($servername, $dbUsername, $dbPassword, $dbName);
		if( !conn ) {
			die("Connection failed: " . mysqli_connect_error());
		}

		// mysql abfrage
		// $sql = "SELECT usersName, projectName, projectDescription, ytLink, lat, lng, fileName FROM test";
		$sql = "SELECT * FROM soundcheck";
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
		var_dump($rows);

		$con->close();
    ?>


	<script type="text/javascript" >
		// holt sich das php array und macht daraus ein js objekt
		var data = <?php echo json_encode($rows); ?>;
		console.log(data);

		var markers = [];
		var count;
		var active_m;
	
		// karte aufsetzen
		var map = L.map("map").setView([0, 0], 3);
		map.options.minZoom = 3;
		map.setMaxBounds([[90, -250], [-80, 250]]);

		//edus map:
		L.tileLayer("https://api.mapbox.com/styles/v1/zyxetc/ckl5efafz2aqt17mu8abux77z/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1Ijoienl4ZXRjIiwiYSI6ImNra3ZvcWs5ZTA4czIyeG80dnNlZWk5eDEifQ.eeJhDOpUW6uzdsEMnpmlcg", {	
		    attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',    
		}).addTo(map);

		map.zoomControl.setPosition('bottomright');
		// marker icon definieren
		var blackIcon = L.icon({
			iconUrl: 'images/antenne.png',
			iconSize: [26, 40],
			iconAnchor: [13, 40],
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
			// console.log("marger gesetzt");
		}
		// console.log(myFeatureGroup);

		function groupClick(event) {
		  // console.log("Marker: " + event.layer.count);
		  active_m = event.layer.count;
		  // console.log(event.layer);
		  map.flyTo(event.latlng, 8);
		  drawContent(active_m);
		}
		// console.log(markers);

		// console.log(data[13].fileName);

		var menu = true;
		var content = document.getElementById("content");
		var video = document.getElementById("video");
		var videoWrap = document.getElementById("videoWrap");
		var player = document.getElementById("audioPlayer");
		var audioSource = document.getElementById("audioSource");
		var projekt = document.getElementById("projekt");
		var nameK = document.getElementById("nameK");
		var description = document.getElementById("description");
		var website = document.getElementById("website");
		var x = document.getElementById("x");

		x.addEventListener("click", function(event){
				content.classList.add("closed");
				content.classList.remove("active");
				menu = true;
				player.pause();
				ytPlayer.pauseVideo();

		});

		function drawContent(_index){
			console.log(data[_index]);
			console.log(video);

			if(menu){
				content.classList.remove("closed");
				content.classList.add("active");
				// ytPlayer.playVideo();
			}

			// wenn uploaded file nicht existiert
			if (data[_index].fileName === ""){
				// console.log("ho");
				player.style.display ="none";
				video.style.display ="block";
				ytPlayer.loadVideoById(data[_index].ytLink);

			// wenn ein file upgeloaded wurde
			} else {
				// console.log("hi");
				player.style.display = "initial";
				videoWrap.style.display = "none";

				// console.log(data[_index].fileName);
				audioSource.src = "../eintragen/uploads/" + data[_index].fileName;
				audioSource.setAttribute("type", "audio/wav");
				player.load();
				player.play();
			}

			

			projekt.innerHTML = data[_index].projectName; 
			nameK.innerHTML =  data[_index].usersName;
			
			description.innerHTML = data[_index].projectDescription;
			website.setAttribute("href", data[_index].url);
			website.innerHTML = data[_index].url;
			
			menu = true;
		}
	</script>
	<script src="scripts/intro.js"></script>


</body>
</html>
