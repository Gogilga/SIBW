<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  

  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio= $_POST['precioañadir'];
    $info= $_POST['infoprod'];
    $contenido= $_POST['contenido'];
    $etiquetas= $_POST['etiquetas'];
    $imagen= $_FILES['foto'];

    $ruta_destino_imagenes= dirname(realpath(__FILE__)).'/imagenes/';

    //Solo admito estas extensiones
    $extensiones = array(0=>'image/jpg',1=>'image/jpeg',2=>'image/png');

    if(in_array($imagen['type'],$extensiones)){
        if(move_uploaded_file($imagen['tmp_name'],$ruta_destino_imagenes.$imagen['name'])){
            incluirProducto($nombre,$info,$contenido,$imagen['name'],$precio,$etiquetas);
        }
        else{
            session_start();
  
            $_SESSION['error']= 'La imagen no se ha podido guardar';
        }
    }
    else{
        session_start();
  
        $_SESSION['error']= 'La imagen no es compatible, tiene que ser png, jpeg o jpg';
    }
    
    header("Location: index.php");
    
    exit();
  }
?>
