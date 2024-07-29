<?php
  require_once __DIR__ . '/helper/exception_handle_helper.php';
  $request_uri = $_SERVER['REQUEST_URI'];
  $request_method = $_SERVER['REQUEST_METHOD'];
  $apiDir = '/api/';

  $trim_request_uri = rtrim($_SERVER['REQUEST_URI'], '/');
  # accept api routes
  switch ([$trim_request_uri, $request_method]) {
    case '':
    case ['/api/enrolments', 'GET']:
      require __DIR__ . $apiDir . 'enrolments/index.php';
      break;

    default:
      http_response_code(404);
      require __DIR__ . $apiDir . '404.php';
  }
?>
