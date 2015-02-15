<?php
include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "kernsbi-db", $myPassword, "kernsbi-db");

$stmt = $mysqli->prepare("DELETE FROM movies WHERE 1");
$stmt->execute();

$stmt->close();
header("Location: http://web.engr.oregonstate.edu/~kernsbi/assignment4-part2/interface.php", true);
?>