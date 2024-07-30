<?php
  require_once __DIR__ . '/../db/connect.php';
  function getTotalEnrolmentsCount() { // 确保你有数据库连接对象 $conn
    $dbConn = getDbConnection();
    $sql = "SELECT COUNT(*) as total FROM Enrolments";
    $result = $dbConn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        return (int)$row['total'];
    } else {
        return 0; // 或者根据需要处理错误
    }
  }
?>