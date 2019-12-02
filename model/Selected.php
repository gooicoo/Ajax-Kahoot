<?php
class Selected {
  public $selected_id;
  public $answer_name;
  public $answer_id;
  public $gamer_id;
  public $time;

  function __construct($selected_id, $answer_name, $answer_id, $time, $gamer_id) {
    $this -> selected_id = $selected_id;
    $this -> answer_name = $answer_name;
    $this -> answer_id = $answer_id;
    $this -> gamer_id = $gamer_id;
    $this -> time = $time;
  }
}
 ?>
