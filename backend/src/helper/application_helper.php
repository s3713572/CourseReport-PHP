<?php
  function echoSuccess($data, $meta = [], $code = 200) {
    header('Content-Type: application/json');
    http_response_code($code);

    $success->meta = $meta;
    $success->data = $data;
    echo json_encode($success);
  }
?>
