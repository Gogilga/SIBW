<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  

  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email= $_POST['email'];
    $contraseña= $_POST['contraseñausu'];
    $nombreAntiguo= $_POST['nombreAntiguo'];

    //echo $_POST[0];

    $usuario= getUsuario($nombreAntiguo);
    $id= $usuario['id'];

    // Si no ha modificado el nombre
    if($nombreAntiguo == $nombre){
      // Si hay valor en contraseña es que la quiere cambiar
      if(!empty($contraseña)){
        $pass= password_hash($contraseña, PASSWORD_DEFAULT); // realizo un hash de la contraseña para más seguridad
        editarUsuario($nombre,$email,$id,$pass);
      }
      else{
        editarUsuario($nombre,$email,$id);
      }
    }
    // Pero si cambia su nombre
    else{
      // Compruebo que no exista ningún usuario con ese nombre ya
      $usuario2= getUsuario($nombre);

      if(isset($usuario2)){
        session_start();
  
        $_SESSION['error']= 'Ya hay un usuario con ese nombre';
      }
      else{
        if(!empty($contraseña)){
          $pass= password_hash($contraseña, PASSWORD_DEFAULT); // realizo un hash de la contraseña para más seguridad
          editarUsuario($nombre,$email,$id,$pass);
        }
        else{
          editarUsuario($nombre,$email,$id);
        }

        session_start();

        $_SESSION['nickUsuario'] = $nombre;
      }
    }
    
    header("Location: usuario.php");
    
    exit();
  }
  
  //echo $twig->render('login.html', []);
?>
