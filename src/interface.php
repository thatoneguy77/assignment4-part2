<?php
include 'storedInfo.php';

echo '<!DOCTYPE html>
<html lang="en"
<head>
<meta charset="utf-8" />
<title>assignment4-part2</title>
</head>
<body>';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "kernsbi-db", $myPassword, "kernsbi-db");
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
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

echo '<form action="http://web.engr.oregonstate.edu/~kernsbi/assignment4-part2/newMovie.php?" method="get">
<fieldset>
Movie Title <input type="text" name="title" required><br>
Movie Category <input type="text" name="category"><br>
Movie Length <input type="number" min="1" name="length"><br>
Rented <input type="radio" name="rented" required value="1">Yes
<input type="radio" name="rented" checked="checked" value=0>No<br>
<input type="submit" value="Add Movie"><br>
</fieldset>
</form>';

echo '<p>';

echo '<form action="http://web.engr.oregonstate.edu/~kernsbi/assignment4-part2/sort.php?" method="post">
<select name="myFilter">
<option value="All Movies">All Movies</option>';
$catOptions = array_merge(array_flip(array_flip($catHolder)));//Ome_Henk http://php.net/manual/en/function.array-unique.php
for($t = 0; $t < count($catOptions); $t++){
	if(!empty($catOptions[$t])){
		echo '<option value="' . $catOptions[$t] . '">' . $catOptions[$t] . '</option>';
	}
}
echo '<input type="submit" value="Sort">
</form>';

echo '<form action="http://web.engr.oregonstate.edu/~kernsbi/assignment4-part2/removeAll.php?" method="get">
<input type="submit" value="Delete All Movies"><br>
</form>';

echo '<p>';

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
	echo '<td><button onclick=window.location.href="http://web.engr.oregonstate.edu/~kernsbi/assignment4-part2/remove.php/?id=' . $idTableHolder[$r] . '"' . ' name=' . $idTableHolder[$r] . "remove" . ' type="button">Remove</button>';
	if($rentedTableHolder[$r] == 1){
		echo '<td><button onclick=window.location.href="http://web.engr.oregonstate.edu/~kernsbi/assignment4-part2/checkin.php/?id=' . $idTableHolder[$r] . '"' .' name=' . $idTableHolder[$r] . "checkin" . ' type="button">Check In</button>';
	}
	if($rentedTableHolder[$r] == 0){
		echo '<td><button onclick=window.location.href="http://web.engr.oregonstate.edu/~kernsbi/assignment4-part2/checkout.php/?id=' . $idTableHolder[$r] . '"' .' name=' . $idTableHolder[$r] . "checkout" . ' type="button">Check Out</button>';
	}
}

echo '</table>';
echo '</body>';
echo '</html>';

?>