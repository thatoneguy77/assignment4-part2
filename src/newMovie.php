<?php
include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "kernsbi-db", $myPassword, "kernsbi-db");

$name = htmlspecialchars($_GET["title"]);
$category = htmlspecialchars($_GET["category"]);
$length = htmlspecialchars($_GET["length"]);
$rented = htmlspecialchars($_GET["rented"]);

	if(!($stmt = $mysqli->prepare("INSERT INTO movies(name, category, length, rented) VALUES (?, ?, ?, ?)"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if(!$stmt->bind_param('ssis', $name, $category, $length, $rented)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->close();
	header("Location: http://web.engr.oregonstate.edu/~kernsbi/assignment4-part2/interface.php", true);
?>