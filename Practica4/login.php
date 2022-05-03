<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once 'bdUsuarios.php';
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  

  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nick = $_POST['nick'];
    $pass = $_POST['contraseña'];

    if(checkLogin2($nick, $pass)) {
      session_start();

      $_SESSION['nickUsuario'] = $nick;  // guardo en la sesión el nick del usuario que se ha logueado
    }
    else{
      session_start();

      $_SESSION['error']= true;
    }
    
    //header("Location: index.php");
    $pag= $_SERVER['HTTP_REFERER'];
    header("Location: $pag");
    
    exit();
  }
  
  //echo $twig->render('login.html', []);
?>
