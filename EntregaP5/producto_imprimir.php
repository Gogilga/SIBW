<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");
  
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  if (isset($_GET['ev'])) {
    $idEv = $_GET['ev'];
  } else {
    $idEv = -1;
  }
   
  $producto = getProducto($idEv);
  $fotos= getFotos($idEv);

  $numFotos= getNumFotos($idEv);
  
  echo $twig->render('producto_imprimir.html', ['producto' => $producto, 'fotos' => $fotos, 'numReseñas' => $numReseñas, 'numFotos' => $numFotos]);
?>
