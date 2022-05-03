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
   
  $producto = getProducto($idEv);
  $numFotos= getNumFotos($idEv);
  $fotos= getFotos($idEv);

  $reseñas= getReseñas($idEv);
  $numReseñas= getNumReseñas($idEv);

  //Para obtener las palabras censuradas
  $censura= getCensura();

  //Control de sesiones
  $variablesParaTwig = [];
  
  session_start();
  
  if (isset($_SESSION['nickUsuario'])) {
    $variablesParaTwig['user'] = getUser($_SESSION['nickUsuario']);
  }
  
  if($_SESSION['error']){
    $variablesParaTwig['error'] = $error;

    $_SESSION['error']= false;
  }
  
  echo $twig->render('producto.html', ['producto' => $producto, 'fotos' => $fotos, 'numReseñas' => $numReseñas, 'reseñas' => $reseñas, 'numFotos' => $numFotos, 'censura' => $censura, 'variablesParaTwig' => $variablesParaTwig]);
?>