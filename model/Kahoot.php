<?php
class Kahoot {
  public $kahoot_id;
  public $user_id;
  public $kahoot_name;
  public $pin;
  public $active;
  public $limit_users;

  function __construct($kahoot_id, $user_id, $kahoot_name, $pin, $active, $limit_users) {
    $this -> kahoot_id = $kahoot_id;
    $this -> user_id = $user_id;
    $this -> kahoot_name = $kahoot_name;
    $this -> pin = $pin;
    $this -> active = $active;
    $this -> limit_users = $limit_users;
  }
}
 ?>
