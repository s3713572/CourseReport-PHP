<?php
  require_once __DIR__ . '/../../helper/application_helper.php';
  require_once __DIR__ . '/../../helper/exception_handle_helper.php';
  require_once __DIR__ . '/../../service/fetch_course_report_serivce.php';

  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $per = isset($_GET['per']) ? $_GET['per'] : 20;

  $enrolments = fetchCourseReport($page, $per);
  echoSuccess($enrolments);  
?>
