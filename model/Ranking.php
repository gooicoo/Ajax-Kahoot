<?php
class Ranking {
  public $id;
  public $id_jugador;
  public $puntuacion;
  public $id_kahoot;

  function __construct($id, $id_jugador, $puntuacion, $id_kahoot) {
    $this -> id = $id;
    $this -> id_jugador = $id_jugador;
    $this -> puntuacion = $puntuacion;
    $this -> id_kahoot = $id_kahoot;
  }
}
 ?>
