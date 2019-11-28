<?php
class Respuesta {
  public $id;
  public $nombre;
  public $id_pregunta;
  public $orden;
  public $correcto;

  function __construct($id, $nombre, $id_pregunta, $orden, $correcto) {
    $this -> id = $id;
    $this -> nombre = $nombre;
    $this -> id_pregunta = $id_pregunta;
    $this -> orden = $orden;
    $this -> correcto = $correcto;
  }
}

 ?>
