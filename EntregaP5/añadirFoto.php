<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  

  
  if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id= $_POST['idProc'];
    $imagen= $_FILES['foto'];

    $ruta_destino_imagenes= dirname(realpath(__FILE__)).'/imagenes/';

    //Solo admito estas extensiones
    $extensiones = array(0=>'image/jpg',1=>'image/jpeg',2=>'image/png');

    if(in_array($imagen['type'],$extensiones)){
        if(move_uploaded_file($imagen['tmp_name'],$ruta_destino_imagenes.$imagen['name'])){
            añadirImagen($id,$imagen['name']);
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
    
    // Para volver a la página de la que es llamado anteriormente
    $pag= $_SERVER['HTTP_REFERER'];
    header("Location: $pag");
    
    exit();
  }
?>
