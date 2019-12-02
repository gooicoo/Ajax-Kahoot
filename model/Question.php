<?php
class Question {
  public $question_id;
  public $question_name;
  public $kahoot_id;
  public $time;
  public $orden;
  public $question_points;

  function __construct($question_id, $question_name, $kahoot_id, $time, $orden, $question_points) {
    $this -> question_id = $question_id;
    $this -> question_name = $question_name;
    $this -> kahoot_id = $kahoot_id;
    $this -> orden = $orden;
    $this -> time = $time;
    $this -> question_points = $question_points;
  }
}
 ?>
