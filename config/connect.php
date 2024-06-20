<?php
$servername = "localhost";
$username = "username";
$password = "password";
$db = "netflix_db";
$port = "3333";

try {
  $conn = new PDO("mysql:host=$servername;port=$port;dbname=$db", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>