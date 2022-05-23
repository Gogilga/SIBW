<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");
  

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  $numProductos= getNumProductos(0);

  $productos= getProductosSinPublicar($numProductos);

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

  echo $twig->render('portadaSinPublicar.html', ['productos' => $productos, 'numProductos' => $numProductos, 'variablesParaTwig' => $variablesParaTwig]);
?>
