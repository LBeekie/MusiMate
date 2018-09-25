<?php
include "connect.php";

	//$qry = "SELECT SUM(volume) AS value_sum FROM soundmap"; 
	$sql = "SELECT volume FROM soundmap";


	$result = $conn->query($sql);
	$total = 0;
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$total += $row['volume'];
		}
		echo $total;
	}
?>