<?php
  function getDbConnection() {
      // load .env file
    //   $dotenv = Dotenv::createImmutable(__DIR__);
    //   $dotenv->load();
  
      // get env variables
      $host = $_ENV['DB_HOST'];
      $port = $_ENV['DB_PORT'];
      $database = $_ENV['DB_DATABASE'];
      $username = $_ENV['DB_USERNAME'];
      $password = $_ENV['DB_PASSWORD'];
  
      // create MySQL connection
      $conn = new mysqli($host, $username, $password, $database, $port);
  
      // check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
  
      return $conn;
  }
?>
