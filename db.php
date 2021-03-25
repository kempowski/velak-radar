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
	$mountPoints = array(
		"XKru6FMY" => "vvv1",
		"jAT4f4tp" => "vvv2",
		"DBj6eF2B" => "vvv3",
		"ynjcE9Z5" => "vvv4",
		"G6XW8aZ8" => "vvv5",
		"2FAzjySd" => "vvv6",
		"Z5uTtE46" => "vvv7",
		"kq9fUq4m" => "vvv8",
		"h5PVqGtN" => "vvv9"
	);

	$streamDatum = "2021-03-23";
?>