<?php
  require_once __DIR__ . '/../db/connect.php';
  function getTotalEnrolmentsCount($search = '', $course = '', $status = '') {
    $dbConn = getDbConnection();
    // Check if the connection is successful
    if ($dbConn->connect_error) {
      die("Connection failed: " . $dbConn->connect_error);
    }

    $sql = "
      SELECT COUNT(*) AS total
      FROM 
          Enrolments e
      JOIN 
          Users u ON e.user_id = u.user_id
      JOIN 
          Courses c ON e.course_id = c.course_id
      WHERE 
          1=1
    ";

    // Initialize parameters and types
    $params = [];
    $types = '';

    if ($search) {
      $sql .= " AND (u.first_name LIKE ? OR u.surname LIKE ?)";
      $search = "%$search%"; // Surround the search term with % for partial match
      $params[] = $search;
      $params[] = $search;
      $types .= 'ss';
    }

    if ($course && $course !== 'default_all') {
      $sql .= " AND c.description = ?";
      $params[] = $course;
      $types .= 's';
    }

    if ($status && $status !== 'default_all') {
      $sql .= " AND e.completion_status = ?";
      $params[] = $status;
      $types .= 's';
    }

    $stmt = $dbConn->prepare($sql);

    if ($types) {
      $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    $total = $row['total'];

    $stmt->close();
    $dbConn->close();
    return $total;
  }
?>