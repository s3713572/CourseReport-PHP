<?php
  require_once __DIR__ . '/application_helper.php';

  function exception_handler($exception) {
    echoError($exception->getMessage(), 400);
  }
  function error_handler($errno, $errstr, $errfile, $errline) {
    echoError('Internal Error.');
  }
  set_exception_handler("exception_handler");
  set_error_handler("error_handler");
?>
