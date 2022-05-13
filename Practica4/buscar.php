<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");
  

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  //Control de sesiones
  $variablesParaTwig = [];
  
  session_start();
  
  if(isset($_SESSION['nickUsuario'])) {
    $variablesParaTwig['user'] = getUsuario($_SESSION['nickUsuario']);
  }
  
  if(isset($_SESSION['error'])){
    $variablesParaTwig['error'] = $_SESSION['error'];

    unset($_SESSION['error']);
  }

  if($_SESSION['buscar']){
    $productos = $_SESSION['resultadoBusqueda'];
    $palabra= $_SESSION['palabraBusqueda'];

    $numProductos= count($productos)-1;
  }

  echo $twig->render('buscar.html', ['variablesParaTwig' => $variablesParaTwig, 'productos' => $productos, 'numProductos' => $numProductos, 'palabra' => $palabra]);
?>
