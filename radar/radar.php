<!DOCTYPE html>
<head>
	<title>velak radar</title>
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

    <div id="intro">
    	<h2>velak radar</h2>
    	<p>Velakradar is an online platform hosted by velak – a non-profit organisation for experimental music and soundart based in Vienna. On the Velakradar-Soundmap you can listen to live-streams of spaces and environments all over the world. The live-streams get recorded and will stay accessible to listen to. Just click on the icons on the map in order to listen.</p>
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
	    	<a id="website" href="" target="_blank"></a>
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
		$sql = "SELECT * FROM livestream";
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
		console.log(data);

		var markers = [];
		var count;
		var active_m;
	
		// karte aufsetzen
		var map = L.map("map").setView([0, 0], 3);
		map.options.minZoom = 3;
		map.setMaxBounds([[90, -250], [-80, 250]]);


		// icon als svg
		let svgIcon = "<svg version='1.1' id='sendeIcon' xmlns='http://www.w3.org/2000/svg' x='0px' y='0px'  viewBox='0 0 28.7 43.9' style='enable-background:new 0 0 28.7 43.9;' xml:space='preserve'><path class='circle' d='M12.3,8.2c0.5-0.5,1.2-0.8,2-0.8s1.4,0.3,2,0.8c1.1,1.1,1.1,2.8,0,3.9s-2.8,1.1-3.9,0S11.2,9.3,12.3,8.2z'/><g> <path class='ray1' d='M24.5,20.3l-1.4-1.4c4.8-4.8,4.8-12.7,0-17.5L24.5,0C30.1,5.6,30.1,14.7,24.5,20.3z'/> <path class='ray1' d='M4.2,20.3C-1.4,14.7-1.4,5.6,4.2,0l1.4,1.4c-4.8,4.8-4.8,12.7,0,17.5L4.2,20.3z'/></g><g> <path class='ray2' d='M20.9,16.7l-1.4-1.4c2.8-2.8,2.8-7.4,0-10.2l1.4-1.4C24.5,7.2,24.5,13.1,20.9,16.7z'/> <path class='ray2' d='M7.9,16.7c-1.7-1.7-2.7-4-2.7-6.5s1-4.8,2.7-6.5l1.4,1.4c-1.4,1.4-2.1,3.2-2.1,5.1s0.8,3.7,2.1,5.1L7.9,16.7z'  /></g><path class='antenne' d='M15.7,14c0.6-0.2,1.1-0.5,1.6-1c1.6-1.6,1.6-4.1,0-5.7s-4.1-1.6-5.7,0s-1.6,4.1,0,5.7c0.5,0.5,1,0.8,1.6,1 L5.3,44l8-7.8l10.1,7L15.7,14z M13,8.7c0.4-0.4,0.9-0.6,1.4-0.6s1,0.2,1.4,0.6c0.8,0.8,0.8,2.1,0,2.9c-0.8,0.8-2.1,0.8-2.9,0 S12.2,9.5,13,8.7z M14.5,17l3,11.4l-5-3.6L14.5,17z M9.1,37.5l2.8-10.6l4.7,3.4L9.1,37.5z M18.2,31.3l1.8,7l-5.3-3.7L18.2,31.3z'/></svg>"; 
// let svgIcon = "<svg xmlns='http://www.w3.org/2000/svg' width='1000' height='1000'><path d='M2,111 h300 l-242.7,176.3 92.7,-285.3 92.7,285.3 z' fill='#000000'/></svg>";		console.log(svgIcon);
		
		// let myIconUrl = encodeURI("data:image/svg+xml," + svgIcon).replace('#','%23');
		let myIconUrl = "data:image/svg+xml," +  encodeURI(svgIcon);
		console.log(myIconUrl);
		//edus map:
		//edus map:
		L.tileLayer("https://api.mapbox.com/styles/v1/zyxetc/ckl5efafz2aqt17mu8abux77z/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1Ijoienl4ZXRjIiwiYSI6ImNra3ZvcWs5ZTA4czIyeG80dnNlZWk5eDEifQ.eeJhDOpUW6uzdsEMnpmlcg", {	
		    attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',    
		}).addTo(map);

		map.zoomControl.setPosition('bottomright');
		// marker icon definieren
		var blackIcon = L.icon({
			iconUrl: myIconUrl,
			iconSize: [26, 40],
			iconAnchor: [13, 40],
		});

		var myFeatureGroup = L.featureGroup().addTo(map).on("click", groupClick);

		


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
				player.style.display ="none";
				video.style.display ="block";
				ytPlayer.loadVideoById(data[_index].ytLink);

			// wenn ein file upgeloaded wurde
			} else if (data[_index].ytLink === "") {
				console.log("hi");
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
			website.setAttribute("href", "http://" + data[_index].url);

			website.innerHTML = data[_index].url;
			
			menu = true;
		}
	</script>
	<script src="scripts/intro.js"></script>

</body>
</html>
