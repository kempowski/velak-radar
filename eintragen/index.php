<!DOCTYPE html>
<head>
	<title>velak radar submit</title>
	<meta carset="UTF-8">
	<!-- normalizes the different default styles of all browsers to one nutral -->
	<link rel="stylesheet" type="text/css" href="styles/norm.css">
	<!-- own stylesheet -->
	<link rel="stylesheet" type="text/css" href="styles/stylesheet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

	<script	  src="https://code.jquery.com/jquery-3.5.1.min.js"
			  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
			  crossorigin="anonymous">
	</script>
</head>
<body>
	<form action="submit_project.php" method="POST" enctype="multipart/form-data">
		<h1>velak radar submission:</h1>
			<label>id</label>
			<input id="mountpoint" type="text" name="mountpoint" required="">
			<button id="verifyBtn" type="button" onclick="veri()">verify</button>
			<?php 

				include "../db.php";

				// var_dump($mountPoints); ?>

				<script type="text/javascript">
				    var mountpoints = <?php echo json_encode($mountPoints); ?>;
				</script>

		<div id="correct">
			<div>
				<label for="submitType">Where do you want to submit your stream:</label><br>
				<input type="radio" id="soundcheck" name="submitType" value="soundcheck" required=""> Soundcheck<br>
				<input type="radio" id="livestream" name="submitType" value="livestream">
				Livestream<br>
			</div>
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
				<label for="description">Description (max. 400 character)</label>
				<textarea type="text" id="description" name="description" required="" maxlength="400"></textarea>
			</div>
			<div class="inputGroup">
				<label for="url">URL for your webiste (optional)</label>
				<input type="text" id="url" name="url" placeholder="www.example.xyz">
			</div>

			<!-- <div id="audioTypeSelect">
				<div>
					<label id="audioS" for="audioType">Type:</label><br>

					<input type="radio" id="upload" name="audioType" value="upload" required=""> Upload<br>
					<input type="radio" id="stream" name="audioType" value="stream">
					Stream<br>
				</div>
				
				<div class="inputGroup" id="uploadBox">
					<input id="file" type="file" name="sound">
				</div>

				<div class="inputGroup" id="ytLinkBox">
					<label for="ytLink">Youtube Embed Code:</label><br>
					<input type="text" id="ytLink" name="ytLink" >
				</div>

			</div> -->


			


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
		</div>
	</form>


	<script type="text/javascript" src="scripts/map.js"></script>
	<script type="text/javascript" src="scripts/options.js"></script>
</body>
</html>
