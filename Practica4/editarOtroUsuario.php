<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once 'bdUsuarios.php';
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  

  
  if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    foreach ($_POST as $key => $value){
        $rol= substr($key, 0, -1);
        $usuario= intval(substr($key, -1));

        cambiarRol($rol,$usuario,1);
    }
    
    header("Location: usuario.php");
    
    exit();
  }
  
  //echo $twig->render('login.html', []);
?>
