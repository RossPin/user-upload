<?php
function connect($host, $username, $password){
  // Create connection
  error_reporting(E_ERROR);
  $conn = new mysqli($host, $username, $password);
  error_reporting(E_ERROR | E_WARNING | E_PARSE);

  // Check connection
  if ($conn->connect_error) {
    $message = stristr($conn->connect_error, "Access denied") ? 'Access denied check your credentials' : 'Could not connect to server';
    die("EXIT: Connection to MySQL server failed, $message\n");
  }
  // Create database if doesn't exist
  $sql = "CREATE DATABASE IF NOT EXISTS user_upload";
  if (!$conn->query($sql)) die("EXIT: Error creating database 'user_upload': check user permissions.\n");

  // Connect to DB
  if (!$conn->select_db("user_upload")) die("EXIT: Error connecting to database 'user_upload': check user permissions.\n"); 
  echo "• Connected to Database 'user_upload'\n";
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
  email VARCHAR(50) UNIQUE
  )";
  if (!$conn->query($sql)) die("EXIT: Error creating table 'users': check user permissions.\n");
  echo "• Table 'users' created successfully\n";
}

function insert($users, $conn){
  $count = 0;  
  foreach($users as $user) {
    // escape any ' in names or email for parsing in SQL
    $name = str_replace("'", "\'", $user['name']); 
    $surname = str_replace("'", "\'", $user['surname']);
    $email = str_replace("'", "\'", $user['email']);    
    $sql = "INSERT INTO users (name, surname, email) VALUES ('$name', '$surname', '$email')";
    if (!$conn->query($sql)){
      $message = stristr($conn->error, "Duplicate entry") ? "Email $email already in DB" : "check input data";
      echo "• Error entering {$user['name']} {$user['surname']} from CSV line {$user['line']} into DB: $message\n";
    } 
    else $count++;    
  }
  echo "• $count users entered into DB successfully\n";
}

function check_users_exists($conn){
  if (!$conn->query("DESCRIBE users")) {
    $input = readline("• Table 'users' does not exist, would you like to create it now? (Y/N):");
    if (trim(strtolower($input)) == 'y') create_table($conn);
    else die("EXIT: DB table users required to write to DB. this can be created with --create_table\n");
  }
}
?>