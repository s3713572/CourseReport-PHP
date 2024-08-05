<?php
  require_once __DIR__ . '/application_helper.php';

  /**
   * Custom exception handler to handle uncaught exceptions.
   *
   * This function is invoked when an uncaught exception is thrown. It uses the 
   * echoError function to return an error response with a 400 HTTP status code.
   *
   * @param Exception $exception The exception that was thrown
   */
  function exception_handler($exception) {
    // Call the echoError function to send a JSON response with the exception message
    // and a 400 (Bad Request) HTTP status code
    echoError($exception->getMessage(), 400);
  }

  /**
   * Custom error handler to handle PHP runtime errors.
   *
   * This function is invoked when a runtime error occurs in the PHP script. It uses
   * the echoError function to return a generic error response with a 500 HTTP status code.
   *
   * @param int $errno The error number (level) of the error
   * @param string $errstr The error message
   * @param string $errfile The filename where the error occurred
   * @param int $errline The line number where the error occurred
   */
  function error_handler($errno, $errstr, $errfile, $errline) {
    // Call the echoError function to send a JSON response with a generic error message
    // and a 500 (Internal Server Error) HTTP status code
    echoError('Internal Error.');
  }
  set_exception_handler("exception_handler");
  set_error_handler("error_handler");
?>
