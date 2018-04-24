<?php

class ServerResponse{
  public $msg;
  public $val;
  public $data;

  function __construct($v, $m = "", $d = null){
      $this->val = is_bool($v) ? $v : (bool)$v;
      $this->msg = is_string($m) ?  $m : (string)$m;
      $this->data = $d;
  }
}
 ?>
