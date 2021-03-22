<!DOCTYPE html>
<head>
	<title>velak radar submit</title>
	<meta carset="UTF-8">
	<!-- normalizes the different default styles of all browsers to one nutral -->
	<link rel="stylesheet" type="text/css" href="styles/norm.css">
	<!-- own stylesheet -->
	<link rel="stylesheet" type="text/css" href="styles/stylesheet.css">

</head>
<body>

<?php
ini_set('display_errors', 1);

include "../db.php";

if (isset($_POST["submit"])){
	// echo("hi");
	
	$submitType = $_POST["submitType"];

	$name = $_POST["name"];
	$email = $_POST["email"];
	$projectName = $_POST["projectName"];
	$projectDescription = $_POST["description"];
	$url = $_POST["url"];
	$ytLink = $_POST["ytLink"];
	$lat = $_POST["lat"];
	$lng = $_POST["lng"];

	// fileopload
	// if statement checkt ob kein file ausgewaehlt ist
	// print_r($_FILES);
	// echo($_FILES['sound']);


	if (!($_FILES['sound']["error"] == 4)){
		$file = $_FILES['sound'];
		$fileName = $_FILES['sound']['name'];
		$fileTmpName = $_FILES['sound']['tmp_name'];
		$fileSize = $_FILES['sound']['size'];
		$fileError = $_FILES['sound']['error'];
		$fileType = $_FILES['sound']['type'];

		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));

		// echo ($fileName);
		// echo "<br>";
		print_r($file);

		$allowed = array('mp3', 'ogg', 'wav');

		if( in_array($fileActualExt, $allowed)){
			if($fileError === 0){
				// if($fileSize < 10000000)	
					// $fileNameNew = uniqid('', true) . '.' . $fileActualExt;
					$fileNameNew = $name . '.' . $fileActualExt;
					$fileDestination = 'uploads/' . $fileNameNew;
					move_uploaded_file($fileTmpName, $fileDestination);
					echo("uploaded");
			} else {
				echo "there was an error uploading your file";
			}
		} else {
			echo "you cant upload files of this type<br>";
		}
	}	else {
		$fileNameNew = ""; 
	}

	// string fuer die datenbank
	$gesamt = $name . " " . $email . " " . $projectName . " " . $projectDescription . " " . $ytLink . " " . $lat . " " . $lng . " " . $fileNameNew . " " . $url;

	if ($con->connect_error){
		die("iwas ging schief" .$con->connect_error); 
	}

	if ($submitType == "soundcheck") {
		$stmt = $con->prepare("INSERT INTO soundcheck (usersName, usersEmail, projectName, projectDescription, ytLink, lat, lng, fileName, url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);");
		$stmt->bind_param("sssssssss", $name, $email, $projectName, $projectDescription, $ytLink, $lat, $lng, $fileNameNew, $url);
	}
	if ($submitType == "livestream") {
		$stmt = $con->prepare("INSERT INTO livestream (usersName, usersEmail, projectName, projectDescription, ytLink, lat, lng, fileName, url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);");
		$stmt->bind_param("sssssssss", $name, $email, $projectName, $projectDescription, $ytLink, $lat, $lng, $fileNameNew, $url);	
	}

	

	$stmt->execute();
	$stmt->close();
	$con->close();


};

?>
	<div id="wrap">
		<h3>succesful submitted</h3>
		<div id='erfolg'>
			<a class="nav" id="livestream" href='../index.php'>livestream</a>

			<a class="nav" id="soundcheck" href='../soundcheck/soundcheck.php'>soundcheck</a>
		</div>
	</div>


</body>
</html>