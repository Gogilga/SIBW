<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  

  
  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $puntuacion= $_POST['punt'];
    $idReseña= $_POST['idReseña'];
    $descripcion= $_POST['descrip'];

    //echo $descripcion;

    eliminarReseña($idReseña);
    
    // Para volver a la página de la que es llamado anteriormente
    $pag= $_SERVER['HTTP_REFERER'];
    header("Location: $pag");
    
    exit();
  }
?>
