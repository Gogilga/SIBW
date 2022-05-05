<?php
   $error= ['No coincide la contraseña con el usuario','Ya existe un usuario con ese nombre'];

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
    $sentencia= $mysqli->prepare("SELECT * FROM fotos WHERE idProducto=?");
    $sentencia->bind_param('i', $idEv);
    $sentencia->execute();
    $res= $sentencia->get_result();

    return $res->num_rows;

  }

  function getFotos($idEv){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("SELECT foto FROM fotos WHERE idProducto=?");
    $sentencia->bind_param('i', $idEv);
    $sentencia->execute();
    $res= $sentencia->get_result();

    $numFotos= getNumFotos($idEv);

    $fotos= Array();

    if ($res->num_rows > 0){
      for($i = 0; $i <= $numFotos; $i++){
        $row = $res->fetch_assoc();

        array_push($fotos, ['foto' => $row['foto']]);
      }
    }

    return $fotos;
  }

  function getNumReseñas($idEv){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("SELECT * FROM reseñas WHERE idProducto=?");
    $sentencia->bind_param('i', $idEv);
    $sentencia->execute();
    $res= $sentencia->get_result();

    return $res->num_rows;
  }

  function getReseñas($idEv){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    //Con date_format(fecha, 'El %d-%m-%Y a las %H:%i') AS fecha es para formatear la fecha y que aparezca en orden
    $sentencia= $mysqli->prepare("SELECT usuario, date_format(fecha, 'El %d-%m-%Y a las %H:%i') AS fecha, puntuación, reseña FROM reseñas WHERE idProducto=?");
    $sentencia->bind_param('i', $idEv);
    $sentencia->execute();
    $res= $sentencia->get_result();

    $numReseñas= getNumReseñas($idEv);

    $reseñas= Array();

    if ($res->num_rows > 0){
      for($i = 0; $i <= $numReseñas; $i++){
        $row = $res->fetch_assoc();

        array_push($reseñas, ['usuario' => $row['usuario'], 'fecha' => $row['fecha'], 'puntuación' => $row['puntuación'], 'reseña' => $row['reseña']]);
      }
    }

    return $reseñas;
  }

  function getCensura(){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("SELECT palabra FROM censuras");
    $sentencia->execute();
    $res= $sentencia->get_result();

    $numPalabras= $res->num_rows;

    $palabras= Array();

    if ($res->num_rows > 0){
      for($i = 0; $i <= $numPalabras; $i++){
        $row = $res->fetch_assoc();

        array_push($palabras, ['palabra' => $row['palabra']]);
      }
    }

    return $palabras;
  }

  function getUsuario($nick){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("SELECT id, nombre, pass, email, super FROM usuarios WHERE nombre=?");
    $sentencia->bind_param('s', $nick);
    $sentencia->execute();
    $res= $sentencia->get_result();
    
    //$ususario = array('id' => 'HHH', 'nombre' => 'XXX', 'pass' => 'YYY', 'email' => 'SSS', 'super' => 'ZZZ');
    
    if ($res->num_rows > 0) {
      $row = $res->fetch_assoc();
      
      $ususario = array('id' => $row['id'], 'nombre' => $row['nombre'], 'pass' => $row['pass'], 'email' => $row['email'], 'super' => $row['super']);
    }
    
    return $ususario;
  }

  function checkLogin2($nick, $pass){
    $ususario= getUsuario($nick);
    
    $passBase = $ususario['pass'];
    
    if(password_verify($pass, $passBase)) {
      return true;
    }else{
      return false;
    }
  }

  function incluirUsuario($nombre,$pass,$email){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("INSERT INTO usuarios(nombre,pass,email,super) values(?,?,?,0)");
    $sentencia->bind_param('sss', $nombre, $pass, $email);
    $sentencia->execute();
  }

  function editarUsuario($nombre,$email,$id){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("UPDATE usuarios SET nombre=?,email=? WHERE id=?");
    $sentencia->bind_param('ssi', $nombre, $email, $id);
    $sentencia->execute();
  }

  // se usa para sacar todos los elementos menos el que se le pasa por ?
  //SELECT * FROM usuarios WHERE is <> ?
?>
