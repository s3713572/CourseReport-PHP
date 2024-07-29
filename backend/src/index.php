<?php
  define('SITE_ROOT', __DIR__);
  $request_uri = $_SERVER['REQUEST_URI'];
  $request_method = $_SERVER['REQUEST_METHOD'];
  $apiDir = '/api/';

  # accept api routes
  switch ($request_uri, $request_method) {
    case ['/api/enrolments', 'GET']:
      require __DIR__ . $apiDir . 'enrolments/index.php';
      break;

    default:
      http_response_code(404);
      require __DIR__ . $apiDir . '404.php';
  }
?>
