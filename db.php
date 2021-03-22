<?php 
	// LOCAL
	$servername = "localhost:3310";
	$dbUsername = "root";
	$dbPassword = "1234";
	$dbName = "klingt_org";

	// SERVER
	// $servername = "localhost:3306";
	// $dbUsername = "vradar";
	// $dbPassword = "Yaeboh1xen";
	// $dbName = "velakradar";

	// connection
	$con = new mysqli($servername, $dbUsername, $dbPassword, $dbName);
	if( $con -> connect_errno ) {
		die("Connection failed: " . mysqli_connect_error());
	};

	// echo "connection to database";
?>