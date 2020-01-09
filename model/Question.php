<?php
class Question {
  public $question_id;
  public $question_name;
  public $question_type;
  public $kahoot_id;
  public $time;
  public $orden;
  public $question_points;
  public $image_path;
  public $next;

  function __construct($question_id, $question_name, $question_type, $kahoot_id, $time, $orden, $question_points, $image_path, $next) {
    $this -> question_id = $question_id;
    $this -> question_name = $question_name;
    $this -> question_type = $question_type;
    $this -> kahoot_id = $kahoot_id;
    $this -> orden = $orden;
    $this -> time = $time;
    $this -> question_points = $question_points;
    $this -> image_path = $image_path;
    $this -> next = $next;
  }
}
 ?>
