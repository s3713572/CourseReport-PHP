<?php
  require_once __DIR__ . '/../db/connect.php';

   /**
   * Retrieves the total number of enrolments based on optional search criteria.
   *
   * @param string $search  Optional. A keyword to search for in user first names or surnames.
   * @param string $course  Optional. A specific course description to filter enrolments by.
   * @param string $status  Optional. A specific completion status to filter enrolments by.
   * @return int            The total count of enrolments matching the criteria.
   * 
   */
  
  function getTotalEnrolmentsCount($search = '', $course = '', $status = '') {
    // Establish a connection to the database
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

    // Add search condition if provided
    if ($search) {
      $sql .= " AND (u.first_name LIKE ? OR u.surname LIKE ?)";
      $search = "%$search%"; // Surround the search term with % for partial match
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

    // Prepare the SQL statement
    $stmt = $dbConn->prepare($sql);

    // Bind parameters if they exist
    if ($types) {
      $stmt->bind_param($types, ...$params);
    }

    // Execute the prepared statement
    $stmt->execute();

    // Get the result set from the executed statement
    $result = $stmt->get_result();

    // Fetch the total count of enrolments from the result set
    $row = $result->fetch_assoc();

    $total = $row['total'];

    // Close the prepared statement and the database connection
    $stmt->close();
    $dbConn->close();
    return $total;
  }
?>