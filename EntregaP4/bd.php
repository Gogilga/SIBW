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
    $sentencia= $mysqli->prepare("SELECT id, nombre, info, contenido, foto, precio, etiquetas FROM producto WHERE id=?");
    $sentencia->bind_param('i', $idEv);
    $sentencia->execute();
    $res= $sentencia->get_result();
    
    $producto = array('id' => 'HHH', 'nombre' => 'XXX', 'info' => 'YYY', 'contenido' => 'ZZZ', 'foto' => 'AAA', 'precio' => 'AAA', 'etiquetas' => 'AAA');
    
    if ($res->num_rows > 0) {
      $row = $res->fetch_assoc();
      
      $producto = array('id' => $row['id'], 'nombre' => $row['nombre'], 'info' => $row['info'], 'contenido' => $row['contenido'], 'foto' => $row['foto'], 'precio' => $row['precio'], 'etiquetas' => $row['etiquetas']);
    }
    
    return $producto;
  }

  function getProductoBusqueda($palabra){
    $mysqli= conexion();

    $pal= "%".$palabra."%";
    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("SELECT id, nombre, info, foto FROM producto WHERE contenido LIKE ? OR etiquetas LIKE ?");
    $sentencia->bind_param('ss', $pal, $pal);
    $sentencia->execute();
    $res= $sentencia->get_result();
    
    $productos= Array();

    if($res->num_rows > 0){
      for($i = 0; $i <= $res->num_rows; $i++){
        $row = $res->fetch_assoc();

        array_push($productos, ['id' => $row['id'], 'nombre' => $row['nombre'], 'info' => $row['info'], 'foto' => $row['foto']]);
      }
    }

    return $productos;
  }

  function incluirProducto($nombre,$info,$contenido,$foto,$precio,$etiquetas){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("INSERT INTO producto(nombre,info,contenido,foto,precio,etiquetas) values(?,?,?,?,?,?)");
    $sentencia->bind_param('ssssds', $nombre, $info, $contenido, $foto, $precio, $etiquetas);
    $sentencia->execute();
  }

  function añadirImagen($id,$foto){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("INSERT INTO fotos(idProducto,foto) values(?,?)");
    $sentencia->bind_param('is', $id, $foto);
    $sentencia->execute();
  }

  function editarProducto($id,$nombre,$info,$contenido,$precio,$etiquetas,$foto=false){
    $mysqli= conexion();

    if($foto){
      $sentencia= $mysqli->prepare("UPDATE producto SET nombre=?,info=?,contenido=?,precio=?,foto=?,etiquetas=? WHERE id=?");
      $sentencia->bind_param('sssdssi', $nombre, $info, $contenido, $precio, $foto, $etiquetas, $id);
    }
    else{
      $sentencia= $mysqli->prepare("UPDATE producto SET nombre=?,info=?,contenido=?,precio=?,etiquetas=? WHERE id=?");
      $sentencia->bind_param('sssssi', $nombre, $info, $contenido, $precio, $etiquetas, $id);
    }
    
    $sentencia->execute();

  }

  function eliminarProducto($id){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("DELETE FROM producto WHERE id=?");
    $sentencia->bind_param('i', $id);
    $sentencia->execute();
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
    $sentencia= $mysqli->prepare("SELECT id, usuario, date_format(fecha, 'El %d-%m-%Y a las %H:%i') AS fecha, puntuación, reseña FROM reseñas WHERE idProducto=?");
    $sentencia->bind_param('i', $idEv);
    $sentencia->execute();
    $res= $sentencia->get_result();

    $numReseñas= getNumReseñas($idEv);

    $reseñas= Array();

    if ($res->num_rows > 0){
      for($i = 0; $i <= $numReseñas; $i++){
        $row = $res->fetch_assoc();

        array_push($reseñas, ['id' => $row['id'], 'usuario' => $row['usuario'], 'fecha' => $row['fecha'], 'puntuación' => $row['puntuación'], 'reseña' => $row['reseña']]);
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
    $sentencia= $mysqli->prepare("SELECT id, nombre, pass, email, super, moderador, gestor FROM usuarios WHERE nombre=?");
    $sentencia->bind_param('s', $nick);
    $sentencia->execute();
    $res= $sentencia->get_result();
    
    if ($res->num_rows > 0) {
      $row = $res->fetch_assoc();
      
      $ususario = array('id' => $row['id'], 'nombre' => $row['nombre'], 'pass' => $row['pass'], 'email' => $row['email'], 'super' => $row['super'], 'moderador' => $row['moderador'], 'gestor' => $row['gestor']);
    }
    
    return $ususario;
  }

  function getNumUsuarios($id){
    $mysqli= conexion();

    $sentencia= $mysqli->prepare("SELECT * FROM usuarios WHERE id <> ?");
    $sentencia->bind_param('i', $id);
    $sentencia->execute();
    $res= $sentencia->get_result();

    return $res->num_rows;
  }

  function getUsuarios($id){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("SELECT id, nombre, super, moderador, gestor FROM usuarios WHERE id <> ?");
    $sentencia->bind_param('i', $id);
    $sentencia->execute();
    $res= $sentencia->get_result();
    
    $usuarios= Array();
    $numUsuarios= getNumUsuarios($id);

    if ($res->num_rows > 0){
      for($i = 0; $i <= $numUsuarios; $i++){
        $row = $res->fetch_assoc();

        array_push($usuarios, ['id' => $row['id'], 'nombre' => $row['nombre'], 'super' => $row['super'], 'moderador' => $row['moderador'], 'gestor' => $row['gestor']]);
      }
    }

    return $usuarios;
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

  // Con pass=false puedo llamar a la función sin ese argumento y no hará nada con él, solamente comprobar si está
  function editarUsuario($nombre,$email,$id,$pass=false){
    $mysqli= conexion();

    if($pass){
      $sentencia= $mysqli->prepare("UPDATE usuarios SET nombre=?,pass=?,email=? WHERE id=?");
      $sentencia->bind_param('sssi', $nombre, $pass, $email, $id);
    }
    else{
      $sentencia= $mysqli->prepare("UPDATE usuarios SET nombre=?,email=? WHERE id=?");
      $sentencia->bind_param('ssi', $nombre, $email, $id);
    }
    
    $sentencia->execute();
  }

  function cambiarRol($rol,$id,$valor){
    $mysqli= conexion();

    $sentencia= $mysqli->prepare("UPDATE usuarios SET $rol=? WHERE id=?");
    $sentencia->bind_param('ii', $valor, $id);
    $sentencia->execute();
  }

  function añadirReseña($idProducto,$usuario,$puntuacion,$reseña){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("INSERT INTO reseñas(idProducto,usuario,fecha,puntuación,reseña) values(?,?,NOW(),?,?)");
    $sentencia->bind_param('isis', $idProducto, $usuario, $puntuacion, $reseña);
    $sentencia->execute();
  }

  function eliminarReseña($idReseña){
    $mysqli= conexion();

    //Sentencia preparada usada para evitar posibles inyecciones de código
    $sentencia= $mysqli->prepare("DELETE FROM reseñas WHERE id=?");
    $sentencia->bind_param('i', $idReseña);
    $sentencia->execute();
  }

  function editarReseña($idReseña,$reseña){
    $mysqli= conexion();

    $sentencia= $mysqli->prepare("UPDATE reseñas SET reseña=? WHERE id=?");
    $sentencia->bind_param('si', $reseña, $idReseña);
    $sentencia->execute();
  }

  // se usa para sacar todos los elementos menos el que se le pasa por ?
  //SELECT * FROM usuarios WHERE is <> ?
?>
