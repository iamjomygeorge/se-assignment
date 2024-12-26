<?php
// Include the database connection file
require_once("connection.php");

if (isset($_POST['update'])) {
	// Escape special characters in a string for use in an SQL statement
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$age = mysqli_real_escape_string($conn, $_POST['age']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);	
	
	// Check for empty fields
	if (empty($name) || empty($age) || empty($email)) {
		if (empty($name)) {
			echo "<font color='red'>Name field is empty.</font><br/>";
		}
		
		if (empty($age)) {
			echo "<font color='red'>Age field is empty.</font><br/>";
		}
		
		if (empty($email)) {
			echo "<font color='red'>Email field is empty.</font><br/>";
		}
	} else {
		// Update the database table
		$result = mysqli_query($conn, "UPDATE example SET `name` = '$name', `age` = '$age', `email` = '$email' WHERE `id` = $id");
		
		// Display success message
		echo "<p><font color='green'>Data updated successfully!</p>";
		echo "<a href='home.php'>View Result</a>";
	}
}