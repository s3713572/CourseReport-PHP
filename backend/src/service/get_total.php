<?php
  require_once __DIR__ . '/../db/connect.php';
  function getTotalEnrolmentsCount($search = '', $course = '', $status = '') {
    $dbConn = getDbConnection();
    $search = $dbConn->real_escape_string($search);

    // Build conditions based on whether there are search keywords
    $searchCondition = $search ? "AND (u.first_name LIKE '%$search%' OR u.surname LIKE '%$search%')" : "";
    $courseCondition = $course && $course !== 'default_all' ? "AND c.description = '$course'" : "";
    $statusCondition = $status && $status !== 'default_all' ? "AND e.completion_status = '$status'" : "";



    $sql = "
      SELECT COUNT(*) AS total
      FROM 
          Enrolments e
      JOIN 
          Users u ON e.user_id = u.user_id
      JOIN 
          Courses c ON e.course_id = c.course_id
      WHERE 
          1=1 $searchCondition $courseCondition $statusCondition
    ";
    $result = $dbConn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
  }
?>