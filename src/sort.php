<?php
include 'storedInfo.php';
echo '<!DOCTYPE html>
<html lang="en"
<head>
<meta charset="utf-8" />
<title>assignment4-part2</title>
</head>
<body>';

$out_id = NULL;
$out_category = NULL;
$out_length = NULL;
$out_rented = NULL;
$out_name = NULL;

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "kernsbi-db", $myPassword, "kernsbi-db");

	foreach($_POST as $key=>$value){
		$filter = $value;
	}
	if($filter == "All Movies"){
		if(!($stmt = $mysqli->prepare("SELECT id, name, category, length, rented FROM movies"))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}	
		if(!$stmt->execute()) {
			echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		if(!$stmt->bind_result($out_id, $out_name, $out_category, $out_length, $out_rented)) {
			echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}
	$i = 0;
	$catHolder = array();
	$catTableHolder = array();
	$rentedTableHolder = array();
	$lengthTableHolder = array();
	$idTableHolder = array();
	$nameTableHolder = array();

	while ($stmt->fetch()) {
		$catHolder[$i] = $out_category;
		$catTableHolder[$i] = $out_category;
		$rentedTableHolder[$i] = $out_rented;
		$lengthTableHolder[$i] = $out_length;
		$idTableHolder[$i] = $out_id;
		$nameTableHolder[$i] = $out_name;
		$i++;
	}
	$stmt->close();
	echo '<table border="1">';
	echo '<tr><td>' . "ID";
	echo '<td>' . "Title";
	echo '<td>' . "Category";
	echo '<td>' . "Length";
	echo '<td>' . "Rented";

	for($r = 0; $r < $i; $r++){
		echo '<tr>';
		echo '<td>' . $idTableHolder[$r];
		echo '<td>' . $nameTableHolder[$r];
		echo '<td>' . $catTableHolder[$r];
		echo '<td>' . $lengthTableHolder[$r];
		if($rentedTableHolder[$r] == 1){
			echo '<td>checked out';
		}
		if($rentedTableHolder[$r] == 0){
			echo '<td>available';
		}
		echo '<td><button name=' . $idTableHolder[$r] . "remove" . ' type="button">Remove</button>';
		if($rentedTableHolder[$r] == 1){
			echo '<td><button name=' . $idTableHolder[$r] . "checkin" . ' type="button">Check In</button>';
		}
		if($rentedTableHolder[$r] == 0){
			echo '<td><button name=' . $idTableHolder[$r] . "checkout" . ' type="button">Check Out</button>';
		}
	}
	echo '</table>';
	}
	
	else if($filter != "All Movies"){
		if(!($stmt = $mysqli->prepare("SELECT id, name, category, length, rented FROM movies WHERE category=?"))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		$stmt->bind_param('s', $filter);
		if(!$stmt->execute()) {
			echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		if(!$stmt->bind_result($out_id, $out_name, $out_category, $out_length, $out_rented)) {
			echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		$i = 0;
		$catHolder = array();
		$catTableHolder = array();
		$rentedTableHolder = array();
		$lengthTableHolder = array();
		$idTableHolder = array();
		$nameTableHolder = array();

		while ($stmt->fetch()) {
			$catHolder[$i] = $out_category;
			$catTableHolder[$i] = $out_category;
			$rentedTableHolder[$i] = $out_rented;
			$lengthTableHolder[$i] = $out_length;
			$idTableHolder[$i] = $out_id;
			$nameTableHolder[$i] = $out_name;
			$i++;
		}
		$stmt->close();
		echo '<table border="1">';
		echo '<tr><td>' . "ID";
		echo '<td>' . "Title";
		echo '<td>' . "Category";
		echo '<td>' . "Length";
		echo '<td>' . "Rented";

		for($r = 0; $r < $i; $r++){
			echo '<tr>';
			echo '<td>' . $idTableHolder[$r];
			echo '<td>' . $nameTableHolder[$r];
			echo '<td>' . $catTableHolder[$r];
			echo '<td>' . $lengthTableHolder[$r];
			if($rentedTableHolder[$r] == 1){
				echo '<td>checked out';
			}
			if($rentedTableHolder[$r] == 0){
				echo '<td>available';
			}
			echo '<td><button name=' . $idTableHolder[$r] . "remove" . ' type="button">Remove</button>';
			if($rentedTableHolder[$r] == 1){
				echo '<td><button name=' . $idTableHolder[$r] . "checkin" . ' type="button">Check In</button>';
			}
			if($rentedTableHolder[$r] == 0){
				echo '<td><button name=' . $idTableHolder[$r] . "checkout" . ' type="button">Check Out</button>';
			}
		}
	echo '</table>';
	}
echo "Click <a href='http://web.engr.oregonstate.edu/~kernsbi/assignment4-part2/interface.php'>here</a> to return to the interface";

echo '</body>';
echo '</html>';
?>