<?php
  class Meta {
    public $message = '';
    public $page = null;
    public $per = null;
    public $total = null;

    function __construct($message = '', $page = null, $per = null, $total = null) {
      $this->message = $message;
      $this->page = $page;
      $this->per = $per;
      $this->total = $total;
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

  function echoError($message, $code = 500) {
    $failedMeta = new Meta($message);
    echoJSON(new StdClass, $failedMeta, $code);
  }
?>
