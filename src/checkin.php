<?php
include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "kernsbi-db", $myPassword, "kernsbi-db");

$rId = htmlspecialchars($_GET["id"]);
$checkedIn = 0;

if(!($stmt = $mysqli->prepare("UPDATE movies SET rented=? WHERE id = ?"))) {
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
$stmt->bind_param('ii', $checkedIn, $rId);
if(!$stmt->execute()) {
	echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
$stmt->close();
header("Location: http://web.engr.oregonstate.edu/~kernsbi/assignment4-part2/interface.php", true);
?>