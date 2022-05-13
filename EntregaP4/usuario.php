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

  //Control de sesiones
  $variablesParaTwig = [];
  
  session_start();
  
  if(isset($_SESSION['nickUsuario'])) {
    $usuario = getUsuario($_SESSION['nickUsuario']);
    $variablesParaTwig['user'] = getUsuario($_SESSION['nickUsuario']);

    //Obtengo todos los usuarios menos el mío si soy superusuario
    if($usuario['super'] == 1){
      $usuarios= getUsuarios($usuario['id']);
    }
  }

  $numUsuarios= count($usuarios);

  
  if(isset($_SESSION['error'])){
    $variablesParaTwig['error'] = $_SESSION['error'];

    unset($_SESSION['error']);
  }

  //Si no hay sesión iniciada no se puede entrar en esta página
  if(isset($_SESSION['nickUsuario'])) {
    echo $twig->render('usuario.html', ['usuario' => $usuario, 'variablesParaTwig' => $variablesParaTwig, 'usuarios' => $usuarios, 'numUsuarios' => $numUsuarios]);
  }
  else{
    header("Location: index.php");
  }
?>
