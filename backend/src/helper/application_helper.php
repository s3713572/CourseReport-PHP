<?php
  /**
   * Meta class to hold metadata for API responses.
   */

  class Meta {
    public $message = ''; // Message string, used for status or error messages
    public $page = null; // The current page number for paginated results
    public $per = null; // Number of items per page for paginated results
    public $total = null; // Total number of items, used for paginated results

    /**
     * Constructor for the Meta class.
     *
     * @param string $message A message describing the status or an error
     * @param int|null $page The current page number (optional)
     * @param int|null $per Number of items per page (optional)
     * @param int|null $total Total number of items (optional)
     * 
     */
    function __construct($message = '', $page = null, $per = null, $total = null) {
      $this->message = $message;
      $this->page = $page;
      $this->per = $per;
      $this->total = $total;
    }
  }

  /**
   * Outputs JSON response with appropriate headers.
   *
   * @param mixed $data The data to be sent in the response body
   * @param Meta $meta Metadata for the response
   * @param int $code HTTP response code
   */
  function echoJSON($data, $meta, $code) {
    // Set CORS headers to allow requests from any origin
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header("Access-Control-Allow-Headers: X-Requested-With");
    // Set the content type to JSON
    header('Content-Type: application/json');
    http_response_code($code);

    $res = new StdClass;
    $res->meta = $meta;
    $res->data = $data;

    // Set the HTTP response code
    echo json_encode($res);
  }


  /**
   * Outputs a successful JSON response.
   *
   * @param mixed $data The data to be sent in the response body
   * @param Meta $meta Metadata for the response, default is a new Meta object
   * @param int $code HTTP response code, default is 200 (OK)
   */
  function echoSuccess($data, $meta = new Meta(''), $code = 200) {
    echoJSON($data, $meta, $code);
  }

  /**
   * Outputs an error JSON response.
   *
   * @param string $message The error message to be included in the response
   * @param int $code HTTP response code, default is 500 (Internal Server Error)
   */
  function echoError($message, $code = 500) {
    // Create a Meta object with the error message
    $failedMeta = new Meta($message);
    echoJSON(new StdClass, $failedMeta, $code);
  }
?>
