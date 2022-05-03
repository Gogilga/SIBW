<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once 'bdUsuarios.php';

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  

  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nick = $_POST['nick'];

    $existe= getUser($nick);

    if(isset($existe)){
      session_start();

      $_SESSION['error']= true;
    }
    else{
      session_start();

      $_SESSION['nickUsuario'] = $nick;  // guardo en la sesión el nick del usuario que se ha logueado
    }
    
    header("Location: index.php");
    
    exit();
  }
  
  //echo $twig->render('login.html', []);
?>
