<?php
  require_once __DIR__ . '/../db/connect.php';

  function fetchCourseReport($page = 1, $per = 20, $first_name = '', $surname = '', $course_description = '') {
    // 确保 page 和 per 的有效性
    $page = $page > 0 ? $page : 1;
    $per = $per > 0 ? $per : 20;

    // 计算 OFFSET
    $offset = ($page - 1) * $per;
    $dbConn = getDbConnection();
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
