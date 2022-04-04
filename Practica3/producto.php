<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");
  
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  if (isset($_GET['ev'])) {
    $idEv = $_GET['ev'];
  } else {
    $idEv = -1;
  }
   
  $producto = getProducto($idEv);
  $fotos= getFotos($idEv);

  $numReseñas= getNumReseñas($idEv);
  if($numReseñas > 0){
    $s= getReseñas(1);

    $reseñas= [[
              'usuario' => $s['usuario'],
              'fecha' => $s['fecha'],
              'puntuación' => $s['puntuación'],
              'reseña' => $s['reseña'],
      ]];
  }

  for ($i = 2; $i <= $numReseñas; $i++) {
    $s= getReseñas($i);

    array_push($reseñas, ['usuario' => $s['usuario'],
                          'fecha' => $s['fecha'],
                          'puntuación' => $s['puntuación'],
                          'reseña' => $s['reseña'],
      ]);
  }

  $numFotos= getNumFotos($idEv);
  
  echo $twig->render('producto.html', ['producto' => $producto, 'fotos' => $fotos, 'numReseñas' => $numReseñas, 'reseñas' => $reseñas, 'numFotos' => $numFotos]);
?>
