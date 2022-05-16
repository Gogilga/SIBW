<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  

  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $buscar= $_POST['busqueda'];

    $res= getProductoBusqueda($buscar);

    if(empty($res)){
      session_start();
    
      $_SESSION['error']= 'No hay resultado para '.$buscar;
    }else{
      session_start();

      $_SESSION['buscar']= true;
      $_SESSION['resultadoBusqueda']= $res;
      $_SESSION['palabraBusqueda']= $buscar;
    }

    header("Location: buscar.php");
    
    exit();
  }
?>
