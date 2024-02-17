<?php

$servername = "localhost";
$username = "u844191798_adm";
$password = "U7e/TmW*)cXT}u2F";
$db_name = "u844191798_adm";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, $db_name);