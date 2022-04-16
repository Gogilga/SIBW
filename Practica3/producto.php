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
  $numFotos= getNumFotos($idEv);
  $fotos= getFotos($idEv);

  $reseñas= getReseñas($idEv);
  $numReseñas= getNumReseñas($idEv);

  $palabras= getCensura();

  $censura= getCensura();
  
  echo $twig->render('producto.html', ['producto' => $producto, 'fotos' => $fotos, 'numReseñas' => $numReseñas, 'reseñas' => $reseñas, 'numFotos' => $numFotos, 'palabras' => $palabras, 'censura' => $censura]);
?>
