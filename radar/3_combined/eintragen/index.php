<!DOCTYPE html>
<head>
	<title>Velak Radar Submit</title>
	<meta carset="UTF-8">
	<!-- normalizes the different default styles of all browsers to one nutral -->
	<link rel="stylesheet" type="text/css" href="styles/norm.css">
	<!-- own stylesheet -->
	<link rel="stylesheet" type="text/css" href="styles/stylesheet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>
<body>
	<form action="submit_project.php" method="POST" enctype="multipart/form-data">
		<h1>velak radar submission:</h1>
		<div class="inputGroup">
			<label for="name">Name</label>
			<input type="text" id="name" name="name" required="">
		</div>
		<div class="inputGroup">
			<label for="email">Email</label>
			<input type="email" id="email" name="email" required=""> 
		</div>
		<div class="inputGroup">
			<label for="projectName">Project Name</label>
			<input type="text" id="projectName" name="projectName" required="">
		</div>
		<div class="inputGroupUnder">
			<label for="description">Description</label>
			<textarea type="text" id="description" name="description" required=""></textarea>
		</div>

		<div>
			<input type="radio" id="upload" name="audioType" value="upload">
			  <label for="upload">Upload</label><br>
			  <input type="radio" id="stream" name="audioType" value="stream">
			  <label for="female">Stream</label><br>
		</div>


		<div class="inputGroup">
			<input type="file" name="sound">
			
		</div>
		<div class="inputGroup">
			<label for="ytLink">Youtube Embed Code:</label>
			<input type="text" id="ytLink" name="ytLink" required="">
		</div>
		<div>
			<label for="">Location:</label>
			
	        <div id="map"></div>
        </div>
        <div class="inputGroup">
	        <label for="lat">Latitude:</label>
	        <input type="text" name="lat" id="lat" required="">
        </div>
        <div class="inputGroup">
	        <label for="lng">Longitude:</label>
	        <input type="text" name="lng" id="lng" required="">
        </div>
		
			<button type="submit" name="submit">upload</button>
	</form>


	<script type="text/javascript" src="scripts/map.js"></script>
	<script type="text/javascript" src="scripts/option.sjs"></script>
</body>
</html>
