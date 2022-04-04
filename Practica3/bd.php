<?php
  //Funcion para hacer la conexion con la base de datos y no repetir más código
  function conexion(){
    $mysqli = new mysqli("mysql", "coronavirus", "covid19", "SIBW");
    if ($mysqli->connect_errno) {
      echo ("Fallo al conectar: " . $mysqli->connect_error);
    }

    return $mysqli;
  }

  function getNumProductos(){
    $mysqli= conexion();

    $res = $mysqli->query("SELECT * FROM producto");

    return $res->num_rows;
  }

  function getProducto($idEv) {
    $mysqli= conexion();

    $res = $mysqli->query("SELECT nombre, info, contenido, foto FROM producto WHERE id=" . $idEv);
    
    $producto = array('nombre' => 'XXX', 'info' => 'YYY', 'contenido' => 'ZZZ', 'foto' => 'AAA');
    
    if ($res->num_rows > 0) {
      $row = $res->fetch_assoc();
      
      $producto = array('nombre' => $row['nombre'], 'info' => $row['info'], 'contenido' => $row['contenido'], 'foto' => $row['foto']);
    }
    
    return $producto;
  }

  function getFotos($idEv){
    $mysqli= conexion();

    $res = $mysqli->query("SELECT foto1, foto2 FROM fotos WHERE id=" . $idEv);

    $fotos = array('foto1' => 'XXX', 'foto2' => 'YYY');

    if($res->num_rows > 0) {
      $row = $res->fetch_assoc();
      
      $fotos = array('foto1' => $row['foto1'], 'foto2' => $row['foto2']);
    }
    
    return $fotos;
  }

  function getNumReseñas($idEv){
    $mysqli= conexion();

    $res = $mysqli->query("SELECT * FROM reseñas WHERE id=" . $idEv);

    return $res->num_rows;
  }

  function getReseñas($idEv){
    $mysqli= conexion();

    $res = $mysqli->query("SELECT usuario, fecha, puntuación, reseña FROM reseñas WHERE idReseña=" . $idEv);

    $reseñas = array('usuario' => 'XXX', 'fecha' => 'YYY', 'puntuación' => 'ZZZ', 'reseña' => 'AAA');

    if($res->num_rows > 0) {
      $row = $res->fetch_assoc();
      
      $reseñas = array('usuario' => $row['usuario'], 'fecha' => $row['fecha'], 'puntuación' => $row['puntuación'], 'reseña' => $row['reseña']);
    }
    
    return $reseñas;
  }
?>
