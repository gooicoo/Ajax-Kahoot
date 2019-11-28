<?php
class User {
  public $user_id;
  public $user_name;
  public $password;
  public $email;
  public $user_type;

  function __construct($user_id, $user_name, $password, $email, $user_type) {
    $this -> $user_id = $user_id;
    $this -> user_name = $user_name;
    $this -> password = $password;
    $this -> email = $email;
    $this -> user_type = $user_type;
  }
}
 ?>
