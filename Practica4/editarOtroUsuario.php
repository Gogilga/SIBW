<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once 'bdUsuarios.php';
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  

  
  if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    foreach ($_POST as $key => $usuario){
        //$usuario= intval(substr($key, -1));

        if(!isset($_POST['super'.$usuario])){
          cambiarRol('super',$usuario,0);
        }else{
          cambiarRol('super',$usuario,1);
        }

        if(!isset($_POST['moderador'.$usuario])){
          cambiarRol('moderador',$usuario,0);
        }else{
          cambiarRol('moderador',$usuario,1);
        }

        if(!isset($_POST['gestor'.$usuario])){
          cambiarRol('gestor',$usuario,0);
        }else{
          cambiarRol('gestor',$usuario,1);
        }
    }
    
    header("Location: usuario.php");
    
    exit();
  }
  
  //echo $twig->render('login.html', []);
?>
