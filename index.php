<?php
	// date_default_timezone_set('CET'); 
	// $aktuellesDatum = date("Y.D.M H:m");


	// $livestreamStart = date_create("2020-02-27 19:00", timezone_open("Europe/Berlin"));

	// echo $aktuellesDatum;
	// echo "<br>";

	// echo date_format($livestreamStart);


	// // if( $aktuellesDatum >= $livestreamStart) {
	// // 	// echo ("hithere");
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Location: '. 'radar/radar.php');
	// } else {
		// header('Location: '."preview/index.php");
	// }
?>