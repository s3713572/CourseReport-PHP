<?php
  require_once __DIR__ . '/../../helper/application_helper.php';
  require_once __DIR__ . '/../../helper/exception_handle_helper.php';
  require_once __DIR__ . '/../../service/fetch_course_report_serivce.php';
  require_once __DIR__ . '/../../service/get_total.php';

  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $per = isset($_GET['per']) ? $_GET['per'] : 10;

  $enrolments = fetchCourseReport($page, $per);

  $totalEnrolments = getTotalEnrolmentsCount(); // 你需要实现这个函数
  $totalPages = ceil($totalEnrolments / $per);
  echoSuccess([
    'enrolments' => $enrolments,
    'totalPages' => $totalPages
  ]); 

?>
