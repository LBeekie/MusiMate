<?php

$function = $_REQUEST["functions"];
if($function == "login") {
	$uID = uniqid();
	$name = $_REQUEST["name"];
	setcookie("uID", $uID, time() + (86400 / 2), "/");
	//setcookie("name", $name, time() + (86400 * 30), "/");

	$sql = "INSERT INTO soundmap (ID, name, place, volume)
	VALUES ('$uID', '$name', '0', '0')";


	include "connect.php";
	if ($conn->query($sql) === TRUE) {

	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
} elseif($function == "table") {
	$table = $_REQUEST["table"];
	$uID = $_COOKIE["uID"];
	
	$sql = "UPDATE soundmap SET place = '$table' WHERE ID='$uID'";


	include "connect.php";
	if ($conn->query($sql) === TRUE) {

	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
} elseif($function == "volume") {
	$volume = $_REQUEST["volume"];
	$uID = $_COOKIE["uID"];
	
	$sql = "UPDATE soundmap SET volume = '$volume' WHERE ID='$uID'";


	include "connect.php";
	if ($conn->query($sql) === TRUE) {

	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
} elseif($function == "getVolume") {
	include "connect.php";

	
	$sql = "SELECT volume FROM soundmap WHERE place='table1'";


	$result = $conn->query($sql);
	$total = 0;
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$total += $row['volume'];
		}
		echo $total;
	}
}




?>