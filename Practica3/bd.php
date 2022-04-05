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

  //Funcion para obtener todos los productos para la portada
  function getProductosPortada($numProductos){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("SELECT * FROM producto limit ?");
    $sentencia->bind_param('i', $numProductos);
    $sentencia->execute();
    $res= $sentencia->get_result();
    
    $productos= Array();

    if ($res->num_rows > 0){
      for($i = 0; $i <= $numProductos; $i++){
        $row = $res->fetch_assoc();

        array_push($productos, ['id' => $row['id'], 'nombre' => $row['nombre'], 'info' => $row['info'], 'foto' => $row['foto']]);
      }
    }

    return $productos;
  }

  function getProducto($idEv) {
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("SELECT id, nombre, info, contenido, foto FROM producto WHERE id=?");
    $sentencia->bind_param('i', $idEv);
    $sentencia->execute();
    $res= $sentencia->get_result();
    
    $producto = array('id' => 'HHH', 'nombre' => 'XXX', 'info' => 'YYY', 'contenido' => 'ZZZ', 'foto' => 'AAA');
    
    if ($res->num_rows > 0) {
      $row = $res->fetch_assoc();
      
      $producto = array('id' => $row['id'], 'nombre' => $row['nombre'], 'info' => $row['info'], 'contenido' => $row['contenido'], 'foto' => $row['foto']);
    }
    
    return $producto;
  }

  function getNumFotos($idEv){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("SELECT * FROM fotos WHERE id=?");
    $sentencia->bind_param('i', $idEv);
    $sentencia->execute();
    $res= $sentencia->get_result();

    return $res->num_rows;

  }

  function getFotos($idEv){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("SELECT foto1, foto2 FROM fotos WHERE id=?");
    $sentencia->bind_param('i', $idEv);
    $sentencia->execute();
    $res= $sentencia->get_result();
    

    $fotos = array('foto1' => 'XXX', 'foto2' => 'YYY');

    if($res->num_rows > 0) {
      $row = $res->fetch_assoc();
      
      $fotos = array('foto1' => $row['foto1'], 'foto2' => $row['foto2']);
    }
    
    return $fotos;
  }

  function getNumReseñas($idEv){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("SELECT * FROM reseñas WHERE id=?");
    $sentencia->bind_param('i', $idEv);
    $sentencia->execute();
    $res= $sentencia->get_result();

    return $res->num_rows;
  }

  function getReseñas($idEv){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    //Con date_format(fecha, 'El %d-%m-%Y a las %H:%m') AS fecha es para formatear la fecha y que aparezca en orden
    $sentencia= $mysqli->prepare("SELECT usuario, date_format(fecha, 'El %d-%m-%Y a las %H:%m') AS fecha, puntuación, reseña FROM reseñas WHERE idReseña=?");
    $sentencia->bind_param('i', $idEv);
    $sentencia->execute();
    $res= $sentencia->get_result();

    //Sentencia para formatear la fecha
    //select date_format(fecha, "El %d-%m-%Y a las %H:%m") AS fecha from reseñas

    $reseñas = array('usuario' => 'XXX', 'fecha' => 'YYY', 'puntuación' => 'ZZZ', 'reseña' => 'AAA');

    if($res->num_rows > 0) {
      $row = $res->fetch_assoc();
      
      $reseñas = array('usuario' => $row['usuario'], 'fecha' => $row['fecha'], 'puntuación' => $row['puntuación'], 'reseña' => $row['reseña']);
    }
    
    return $reseñas;
  }
?>
