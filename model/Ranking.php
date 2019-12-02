<?php
class Ranking {
  public $ranking_id;
  public $points;
  public $kahoot_id;
  public $gamer_id;

  function __construct($ranking_id, $gamer_id, $points, $kahoot_id) {
    $this -> ranking_id = $ranking_id;
    $this -> points = $points;
    $this -> kahoot_id = $kahoot_id;
    $this -> gamer_id = $gamer_id;
  }
}
 ?>
