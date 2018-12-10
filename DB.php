<?php
function connect($servername, $username, $password){
  // Create connection
  $conn = new mysqli($servername, $username, $password);

  // Check connection
  if ($conn->connect_error) die("Connection to DB failed: " . $conn->connect_error . "\n");
  echo "Connected to mySQL server\n";

  // Create database if doesn't exist
  $sql = "CREATE DATABASE IF NOT EXISTS user_upload";
  if (!$conn->query($sql)) die("Error creating database: " . $conn->error . "\n");
  if (!$conn->select_db("user_upload")) die("Error connecting to database: " . $conn->error . "\n"); 
  echo "Connected to Database 'user_upload'\n";
  return $conn;
}
?>