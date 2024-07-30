<?php
  require_once __DIR__ . '/../../helper/application_helper.php';
  require_once __DIR__ . '/../../helper/exception_handle_helper.php';
  require_once __DIR__ . '/../../service/fetch_course_report_serivce.php';
  require_once __DIR__ . '/../../service/get_total.php';

  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $per = isset($_GET['per']) ? $_GET['per'] : 10;
  $search = isset($_GET['search']) ? $_GET['search'] : '';
  $course = isset($_GET['course']) ? $_GET['course'] : '';
  $status = isset($_GET['status']) ? $_GET['status'] : '';



  $enrolments = fetchCourseReport($page, $per, $search, $course, $status);

  $totalEnrolments = getTotalEnrolmentsCount($search, $course, $status); //get total number of records
  $totalPages = ceil($totalEnrolments / $per);
  $pageMeta = new Meta('', $page, $per, $totalPages);

  echoSuccess([
    'enrolments' => $enrolments
  ], $pageMeta); 
?>
