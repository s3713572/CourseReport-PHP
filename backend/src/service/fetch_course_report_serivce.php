<?php
  require_once __DIR__ . '/../db/connect.php';

  function fetchCourseReport($page = 1, $per = 20, $search = '', $course = '', $status = '') {
    // Ensure the validity of page and per
    $page = $page > 0 ? $page : 1;
    $per = $per > 0 ? $per : 20;
    $dbConn = getDbConnection();
    $search = $dbConn->real_escape_string($search);
    $course = $dbConn->real_escape_string($course);
    $status = $dbConn->real_escape_string($status);


    $searchCondition = $search ? "AND u.first_name LIKE '%$search%'" : "";
    $courseCondition = $course && $course !== 'default_all' ? "AND c.description = '$course'" : "";
    $statusCondition = $status && $status !== 'default_all' ? "AND e.completion_status = '$status'" : "";


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
          1=1 $searchCondition $courseCondition $statusCondition
      LIMIT ? OFFSET ?
    ";
    $stmt = $dbConn->prepare($sql);
    $stmt->bind_param('ii', $per, $offset);
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
