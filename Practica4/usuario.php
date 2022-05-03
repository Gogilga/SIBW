<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once 'bdUsuarios.php';
  include("bd.php");
  
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  if (isset($_GET['ev'])) {
    $idEv = $_GET['ev'];
  } else {
    $idEv = -1;
  }

  //Control de sesiones
  $variablesParaTwig = [];
  
  session_start();
  
  if (isset($_SESSION['nickUsuario'])) {
    $usuario = getUsuario($_SESSION['nickUsuario']);
  }

  echo $twig->render('usuario.html', ['usuario' => $usuario]);
?>
