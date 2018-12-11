<?php
function connect($host, $username, $password){
  // Create connection
  $conn = new mysqli($host, $username, $password);

  // Check connection
  if ($conn->connect_error) die("\nConnection to DB failed, " . ($password ? 'Check -h -u -p fields: ' : 'Supply password with -p if required: ') . $conn->connect_error . "\n");

  // Create database if doesn't exist
  $sql = "CREATE DATABASE IF NOT EXISTS user_upload";
  if (!$conn->query($sql)) die("\nError creating database: " . $conn->error . "\n");

  // Connect to DB
  if (!$conn->select_db("user_upload")) die("\nError connecting to database: " . $conn->error . "\n"); 
  echo "Connected to Database 'user_upload'\n";
  return $conn;
}

function create_table($conn){
  // drop table if already exists
  $conn->query("DROP TABLE IF EXISTS users");
  // Create table
  $sql = "CREATE TABLE users (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
  name VARCHAR(30) NOT NULL,
  surname VARCHAR(30) NOT NULL,
  email VARCHAR(50) NOT NULL
  )";
  if (!$conn->query($sql)) die("\nError creating table: " . $conn->error . "\n");
  echo "Table users created successfully\n";
}

function insert($users, $conn){
  $count = 0;  
  foreach($users as $user) {
    // escape any ' in names or email for parsing in SQL
    $name = str_replace("'", "\'", $user['name']); 
    $surname = str_replace("'", "\'", $user['surname']);
    $email = str_replace("'", "\'", $user['email']);
    $sql = "INSERT INTO users (name, surname, email) VALUES ('$name', '$surname', '$email')";
    if (!$conn->query($sql)) echo "Error entering $name $surname into DB: " . $conn->error . "\n";
    else $count++;    
  }
  echo "$count users entered into DB successfully\n";
}
?>