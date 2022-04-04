<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  $numProductos= getNumProductos();

  if($numProductos > 0){
    $s= getProducto(1);

    $producto= [[
              'nombre' => $s['nombre'],
              'info' => $s['info'],
              'foto' => $s['foto'],
      ]];
  }

  for ($i = 2; $i <= $numProductos; $i++) {
    $s= getProducto($i);

    array_push($producto, ['nombre' => $s['nombre'],
                           'info' => $s['info'],
                           'foto' => $s['foto'],
      ]);
  }

  echo $twig->render('portada.html', ['producto' => $producto, 'numProductos' => $numProductos]);
?>
