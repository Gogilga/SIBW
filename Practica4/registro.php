<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once 'bdUsuarios.php';
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  

  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nick = $_POST['nick'];
    $contraseña= $_POST['contraseña'];
    $email= $_POST['email'];

    // Compruebo que no exista ningún usuario con ese nombre ya
    $existe= getUsuario($nick);

    if(isset($existe)){
      session_start();

      $_SESSION['error']= true;
    }
    else{
      session_start();

      $_SESSION['nickUsuario'] = $nick;  // guardo en la sesión el nick del usuario que se ha logueado
      $pass= password_hash($contraseña, PASSWORD_DEFAULT); // realizo un hash de la contraseña para más seguridad
      incluirUsuario($nick,$pass,$email);
    }
    
    header("Location: index.php");
    
    exit();
  }
  
  //echo $twig->render('login.html', []);
?>
