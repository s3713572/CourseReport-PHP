<?php
  require_once __DIR__ . '/../db/connect.php';

  /**
   * Fetches a paginated report of course enrolments based on optional filters.
   *
   * @param int $page   The page number to fetch, defaults to 1.
   * @param int $per    The number of records per page, defaults to 20.
   * @param string $search Optional. A keyword to search for in user first names or surnames.
   * @param string $course Optional. A specific course description to filter enrolments by.
   * @param string $status Optional. A specific completion status to filter enrolments by.
   * @return array       An array of enrolment records matching the criteria.
   * 
   */

  function fetchCourseReport($page = 1, $per = 20, $search = '', $course = '', $status = '') {
    // Ensure the validity of page and per
    $page = $page > 0 ? $page : 1;
    $per = $per > 0 ? $per : 20;

    // Establish a connection to the database
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
    
    // Add search condition if provided
    if ($search) {
      $sql .= " AND (u.first_name LIKE ? OR u.surname LIKE ?)";
      $search = "%$search%"; // Add wildcard for partial match
      $params[] = $search;
      $params[] = $search;
      $types .= 'ss';
    }

    // Add course condition if provided
    if ($course && $course !== 'default_all') {
      $sql .= " AND c.description = ?";
      $params[] = $course;
      $types .= 's';
    }

    // Add status condition if provided
    if ($status && $status !== 'default_all') {
      $sql .= " AND e.completion_status = ?";
      $params[] = $status;
      $types .= 's';
    }

    // Add pagination limits to the query
    $sql .= " LIMIT ? OFFSET ?";

    // Prepare the SQL statement
    $stmt = $dbConn->prepare($sql);

    // Append the pagination parameters to the params array and types
    $params[] = $per;
    $params[] = $offset;
    $types .= 'ii';
    
    // Bind parameters if they exist
    $stmt->bind_param($types, ...$params);
    $stmt->execute();

    // Get the result set from the executed statement
    $result = $stmt->get_result();
    $enrolments = array();

    // Fetch all matching records into the $enrolments array
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          $enrolments[] = $row;
      }
    }
    
    // Return the array of enrolment record
    return $enrolments;
  }
?>
