<?php
  class Meta {
    public $message = '';

    function __construct($message = '') {
      $this->message = $message;
    }
  }

  function echoJSON($data, $meta, $code) {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header("Access-Control-Allow-Headers: X-Requested-With");
    header('Content-Type: application/json');
    http_response_code($code);

    $res = new StdClass;
    $res->meta = $meta;
    $res->data = $data;
    echo json_encode($res);
  }

  function echoSuccess($data, $meta = new Meta(''), $code = 200) {
    echoJSON($data, $meta, $code);
  }

  function echoFail($message, $code = 500) {
    $failedMeta = new Meta($message);
    echoJSON(new StdClass, $failedMeta, $code);
  }
?>
