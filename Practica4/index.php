<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once 'bdUsuarios.php';
  include("bd.php");
  

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  $numProductos= getNumProductos();

  $productos= getProductosPortada($numProductos);

  //Control de sesiones
  $variablesParaTwig = [];
  
  session_start();
  
  if(isset($_SESSION['nickUsuario'])) {
    $variablesParaTwig['user'] = getUser($_SESSION['nickUsuario']);
  }
  
  if($_SESSION['error']){
    $variablesParaTwig['error'] = $error;

    $_SESSION['error']= false;
  }

  echo $twig->render('portada.html', ['productos' => $productos, 'numProductos' => $numProductos, 'variablesParaTwig' => $variablesParaTwig]);
?>
