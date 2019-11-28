<?php
class Seleccion {
  public $id;
  public $id_respuesta;
  public $tiempo;
  public $jugador_id;

  function __construct($id, $id_respuesta, $tiempo, $jugador_id) {
    $this -> id = $id;
    $this -> id_respuesta = $id_respuesta;
    $this -> tiempo = $tiempo;
    $this -> jugador_id = $jugador_id;
  }
}
 ?>
