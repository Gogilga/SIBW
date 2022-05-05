<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once 'bdUsuarios.php';
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  

  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email= $_POST['email'];
    $nombreAntiguo= $_POST['nombreAntiguo'];

    $usuario= getUsuario($nombreAntiguo);
    $id= $usuario['id'];

    if($nombreAntiguo == $nombre){
      editarUsuario($nombre,$email,$id);
    }
    else{
      // Compruebo que no exista ningún usuario con ese nombre ya
      $usuario2= getUsuario($nombre);

      if(isset($usuario2)){
        session_start();
  
        $_SESSION['error']= true;
      }
      else{
        editarUsuario($nombre,$email,$id);

        session_start();

        $_SESSION['nickUsuario'] = $nombre;
      }
    }
    
    header("Location: usuario.php");
    
    exit();
  }
  
  //echo $twig->render('login.html', []);
?>
