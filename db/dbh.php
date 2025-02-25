

<?php
	$dbUSerName =   "root";
    $dbServerName = "localhost";
    $dbPassword = "";
    $dbName = "trainme";

	$conn =mysqli_connect($dbServerName,$dbUSerName,$dbPassword,$dbName);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
?>
