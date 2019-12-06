<?php
class Answer {
  public $answer_id;
  public $answer_name;
  public $question_id;
  public $orden;
  public $correct;

  function __construct($answer_id, $answer_name, $question_id, $orden, $correct) {
    $this -> answer_id = $answer_id;
    $this -> answer_name = $answer_name;
    $this -> question_id = $question_id;
    $this -> orden = $orden;
    $this -> correct = $correct;
  }
}

 ?>
