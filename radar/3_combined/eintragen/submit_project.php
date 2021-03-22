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
// echo "db connected<br>";



if (isset($_POST["submit"])){
	
	$name = $_POST["name"];
	$email = $_POST["email"];
	$projectName = $_POST["projectName"];
	$projectDescription = $_POST["description"];
	$ytLink = $_POST["ytLink"];
	$lat = $_POST["lat"];
	$lng = $_POST["lng"];

	// fileopload
	// if statement checkt ob kein file ausgewaehlt ist
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
		// print_r($file);

		$allowed = array('mp3', 'ogg', 'wav', 'jpg');

		if( in_array($fileActualExt, $allowed)){
			if($fileError === 0){
				// if($fileSize < 10000000)	
					// $fileNameNew = uniqid('', true) . '.' . $fileActualExt;
					$fileNameNew = $name . '.' . $fileActualExt;
					$fileDestination = 'uploads/' . $fileNameNew;
					move_uploaded_file($fileTmpName, $fileDestination);
					// echo("uploaded");
			} else {
				echo "there was an error uploading your file";
			}
		} else {
			echo "you cant upload files of this type<br>";
		}
	}

	// string fuer die datenbank
	$gesamt = $name . " " . $email . " " . $projectName . " " . $projectDescription . " " . $ytLink . " " . $lat . " " . $lng . " " . $fileNameNew;

	if ($con->connect_error){
		die("iwas ging schief" .$con->connect_error); 
	}

	$stmt = $con->prepare("INSERT INTO test (usersName, usersEmail, projectName, projectDescription, ytLink, lat, lng, fileName) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
	// echo "set";

	$stmt->bind_param("ssssssss", $name, $email, $projectName, $projectDescription, $ytLink, $lat, $lng, $fileNameNew);
	echo "<div id='erfolg'>succesful submitted</div>";

	$stmt->execute();
	$stmt->close();
	$conn->close();


};

?>


