<?php
// Este fichero es para simular una supuesta base de datos en donde se almacenan datos de usuarios registrados en nuestra aplicación
// Cada usuario se supone que tiene 3 campos: nick, pass y super:
//  - nick: apodo del usuario
//  - pass: un hash del password (lo que se almacena en la base de datos)
//  - super: un boolean que indica si el usuario es superusuario (o no)

// Lo que aparece en el "hash" se ha obtenido de:
// password_hash('passwordSuperSeguro', PASSWORD_DEFAULT)  ---->  $2y$10$mGwJK76zo6rjkZL3j6YU6uKmjNtV51jmMy8zSUUFt/uuPmzfZeQ0O
// password_hash('otroPassword', PASSWORD_DEFAULT)  ---->  $2y$10$XfxLjcJB.54YreU8SOr1y.vEeRMnuu6izd0xAZwSeuQQZGyJ1TT.y 

// Más info sobre hashes para password en PHP: https://www.sitepoint.com/hashing-passwords-php-5-5-password-hashing-api/

  $usuarios = [ ['nick' => 'Zerjillo', 'pass' => '$2y$10$mGwJK76zo6rjkZL3j6YU6uKmjNtV51jmMy8zSUUFt/uuPmzfZeQ0O', 'super' => true],
                ['nick' => 'Pepe', 'pass' => '$2y$10$XfxLjcJB.54YreU8SOr1y.vEeRMnuu6izd0xAZwSeuQQZGyJ1TT.y', 'super' => false]
              ];

  $error= 'No coincide la contraseña con el usuario';
  
  // Devuelve true si existe un usuario con esa contraseña
  function checkLogin($nick, $pass) {
    global $usuarios;
    
    for ($i = 0 ; $i < sizeof($usuarios) ; $i++) {
      if ($usuarios[$i]['nick'] === $nick) {
       
        if (password_verify($pass, $usuarios[$i]['pass'] )) {
          return true;
        }
      }
    }
    
    return false;
  }
  
  // Devuelve la información de un usuario a partir de su nick 
  function getUser($nick) {
    global $usuarios;
    
    for ($i = 0 ; $i < sizeof($usuarios) ; $i++) {
      if ($usuarios[$i]['nick'] === $nick) {
        return $usuarios[$i];
      }
    }
    
    return 0;
  }

?>
