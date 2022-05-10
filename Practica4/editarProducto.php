<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  

  
  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio= $_POST['precio'];
    $info= $_POST['info'];
    $contenido= $_POST['contenido'];
    $imagen= $_FILES['foto'];

    if(!empty($eliminar)){
      eliminarReseña($idReseña);
    }
    else if(!empty($editar)){
      $des= $descripcion."\nReseña editada.";
      editarReseña($idReseña,$des);
    }
    // Para volver a la página de la que es llamado anteriormente
    $pag= $_SERVER['HTTP_REFERER'];
    header("Location: $pag");
    
    exit();
  }
?>
