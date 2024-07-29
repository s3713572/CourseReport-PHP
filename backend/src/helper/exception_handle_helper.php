<?php
  require_once __DIR__ . '/application_helper.php';

  function exception_handler($exception) {
    echoFail($exception->getMessage());
  }
  // function exception_error_handler($error) {
  //   echoFail($error->getMessage());
  // }
  set_exception_handler("exception_handler");
  // set_error_handler("exception_error_handler");
?>
