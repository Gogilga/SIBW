<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");
  
  header('Content-Type: application/json');

  $buscar= $_POST['key'];

  $res= getProductoBusqueda($buscar);

  echo(json_encode($res));

?>
