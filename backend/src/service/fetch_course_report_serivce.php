<?php
  require_once __DIR__ . '/../db/connect.php';

  function fetchCourseReport($page = 1, $per = 20, $search = '', $course = '', $status = '') {
    // Ensure the validity of page and per
    $page = $page > 0 ? $page : 1;
    $per = $per > 0 ? $per : 20;
    $dbConn = getDbConnection();



    // calculate OFFSET
    $offset = ($page - 1) * $per;
    $sql = "
      SELECT 
          u.user_id, 
          u.first_name, 
          u.surname, 
          c.course_id, 
          c.description AS course_description, 
          e.completion_status
      FROM 
          Enrolments e
      JOIN 
          Users u ON e.user_id = u.user_id
      JOIN 
          Courses c ON e.course_id = c.course_id
      WHERE 
          1=1";

    $params = [];
    $types = '';
    
    if ($search) {
      $sql .= " AND (u.first_name LIKE ? OR u.surname LIKE ?)";
      $search = "%$search%"; // Add wildcard for partial match
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

    $sql .= " LIMIT ? OFFSET ?";

    $stmt = $dbConn->prepare($sql);

    $params[] = $per;
    $params[] = $offset;
    $types .= 'ii';
    
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $enrolments = array();

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          $enrolments[] = $row;
      }
    }
    return $enrolments;
  }
?>
