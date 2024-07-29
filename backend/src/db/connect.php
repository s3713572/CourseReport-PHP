<?php
    function getDbConnection() {
      // 加载 .env 文件
    //   $dotenv = Dotenv::createImmutable(__DIR__);
    //   $dotenv->load();
  
      // 获取环境变量
      $host = $_ENV['DB_HOST'];
      $port = $_ENV['DB_PORT'];
      $database = $_ENV['DB_DATABASE'];
      $username = $_ENV['DB_USERNAME'];
      $password = $_ENV['DB_PASSWORD'];
  
      // 创建 MySQL 连接
      $conn = new mysqli($host, $username, $password, $database, $port);
  
      // 检查连接是否成功
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
  
      return $conn;
  }
?>
