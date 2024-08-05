<?php
  require_once __DIR__ . '/../../helper/application_helper.php';
  require_once __DIR__ . '/../../helper/exception_handle_helper.php';
  require_once __DIR__ . '/../../service/fetch_course_report_serivce.php';
  require_once __DIR__ . '/../../service/get_total.php';

  // Retrieve query parameters from the URL or set default values
  $page = isset($_GET['page']) ? $_GET['page'] : 1; // Page number for pagination, default to 1
  $per = isset($_GET['per']) ? $_GET['per'] : 10; // Number of records per page, default to 10
  $search = isset($_GET['search']) ? $_GET['search'] : ''; // Search term for filtering results
  $course = isset($_GET['course']) ? $_GET['course'] : ''; // Course filter for the report
  $status = isset($_GET['status']) ? $_GET['status'] : ''; // Completion status filter for the report


  // Fetch the course report based on the parameters
  $enrolments = fetchCourseReport($page, $per, $search, $course, $status);

  //get total number of records
  $totalEnrolments = getTotalEnrolmentsCount($search, $course, $status); 

  // Calculate the total number of pages based on the number of enrolments and records per page
  $totalPages = ceil($totalEnrolments / $per);

  // Create a Meta object to include pagination information in the response
  $pageMeta = new Meta('', $page, $per, $totalPages);

  // Return a JSON response with the enrolments data and pagination meta information
  echoSuccess([
    'enrolments' => $enrolments
  ], $pageMeta); 
?>
