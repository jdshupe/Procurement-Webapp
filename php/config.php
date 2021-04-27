<?php
  session_start();

  // sql query to handle user login
  define('USER', 'root');
  define('PASSWORD', '');
  define('HOST', 'localhost');
  define('DATABASE', 'procurement-web-app');
  
  try {
      $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
  } catch (PDOException $e) {
      exit("Error: " . $e->getMessage());
  }

  // variable to change the theme style
  $_SESSION['theme'] = "dark";

  // mysqli connection for data collection
  $con = mysqli_connect("localhost", "root", "", "procurement-web-app");
  
?>