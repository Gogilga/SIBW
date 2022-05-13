<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  

  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario= $_POST['nombre'];
    $idProducto= $_POST['idprod'];
    $puntuacion = $_POST['estrellas'];
    $reseña= $_POST['descrip'];

    añadirReseña($idProducto,$usuario,$puntuacion,$reseña);
    
    // Para volver a la página de la que es llamado anteriormente
    $pag= $_SERVER['HTTP_REFERER'];
    header("Location: $pag");
    
    exit();
  }
?>
