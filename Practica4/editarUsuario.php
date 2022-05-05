<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once 'bdUsuarios.php';
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  

  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email= $_POST['email'];

    // Compruebo que no exista ningún usuario con ese nombre ya
    $usuario= getUsuario($nombre);

    if(isset($usuario)){
      session_start();

      $_SESSION['error']= true;
    }
    else{
      $id= $usuario['id'];

      editarUsuario($nombre,$email,$id);
    }
    
    header("Location: usuario.php");
    
    exit();
  }
  
  //echo $twig->render('login.html', []);
?>
