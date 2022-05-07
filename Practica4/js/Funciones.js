var nombre= "", email= "", estrellas= "", descrip= "";

//Diccionario de palabras para censurar
var palabrasMal=[];


document.addEventListener('DOMContentLoaded', () => {

  //Selecctiono los elementos por sus atributos
  const entryElements= document.querySelectorAll('[data-entry-id]');

  //Añados todos los elementos a un array para trabar al final con ellos
  for(i=0; i < entryElements.length-1; i++){
    palabrasMal.push(entryElements[i].dataset.entryId);
  }

  //console.log(palabrasMal);
});

//document.addEventListener('error', errorLogin());

//Todo esto es para hacerlo síncorno, y hasta que no termina el swal.fire no sigue con el if
//Esto sirve para obtener valores del swal.fire
function miFuncion(){
  Swal.fire({
      title: "Reseñas",
      html: document.getElementById("ventanareseñas").innerHTML,
      confirmButtonText: 'Añadir reseña',
      confirmButtonColor: '#64c196',
      showCloseButton: true,
      footer: 'Aquí se pueden ver unas reseñas',
      allowOutsideClick: true,
      backdrop: true,
      allowEscapeKey: true,
  }).then((result) => {
    //Si se pulsa el botón de añadir reseña
    if (result.isConfirmed){
      añadirReseña();
    }
  })
}

//Funcion que usa la libreria sweetalert2 para mostrar la pantalla emergente con el formulario
function añadirReseña(){
  (async () => {
    const { value: formValues } = await Swal.fire({
      title: "Reseña",
      html:
        "<form id='formularioreseña' method='post' enctype='multipart/form-data' action='producto_imprimir.html'>"+
          "<label for='nombre' class='textformulario'>Nombre:</label>"+
          "<input type='text' id='nombre' class='swal2-input' placeholder='Nombre'>"+

          "<br><br>"+
          "<label for='email' class='textformulario'>E-mail:</label>"+
          "<input type='text' id='email' class='swal2-input' placeholder='ejemplo@correo.com'>"+

          "<br><br>"+

          "<label for='estrellas' class='textformulario'>Puntuación: </label> <br>"+
          '<input id="estrellas" type="range" min="1" max="5" value="1" onmousedown="actualizarValor()"> <span id="valor">1</span>'+

          "<br><br>"+
          "<label for='descrip' class='textformulario'>Reseña: </label>"+
          "<br>"+
          //El height:auto!important sirve para que de pueda poner el textarea del tamaño que quiero
          '<textarea id="descrip" style="height:auto!important;resize: none;" placeholder="Escribe tu reseña." class="swal2-input" rows="9" cols="32" oninput="censuraPalabras()"></textarea>'+
      "</form>",
        focusConfirm: false,
        heightAuto: false,
        confirmButtonText: 'Añadir reseña',
        confirmButtonColor: '#64c196',
        showCloseButton: true,
        footer: 'Añade una reseña',
        showDenyButton: true,
        denyButtonText: "Cancelar",
        allowOutsideClick: true,
        backdrop: true,
        allowEscapeKey: true,
        didRender: () => {
          console.log(document.getElementById('nombre').value);
        },
        
        preConfirm: () => {
          //Para enviar el formulario
          //document.getElementById("formularioreseña").submit();

          nombre= document.getElementById('nombre').value;
          email= document.getElementById('email').value;
          estrellas= document.getElementById('estrellas').value;
          descrip= document.getElementById('descrip').value;

          //Para comprobar que se han puesto los elementos
          if (!nombre && !email && !descrip){
            Swal.showValidationMessage('No has introducido ningún elemento');
          }else if(!nombre){
            Swal.showValidationMessage('Falta el nombre');
          }else if(!email){
            Swal.showValidationMessage('Falta el correo');
          }else if(!descrip){
            Swal.showValidationMessage('Falta la reseña');
          }

          //Para comprobar que el email intrducido es correcto
          if(email){
            emailRegex = /^(?:[^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*|"[^\n"]+")@(?:[^<>()[\].,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,63}$/i;
            //Se muestra un texto a modo de ejemplo, luego va a ser un icono
            if(!emailRegex.test(email)){
              Swal.showValidationMessage('Correo no válido');
            }
          }
          
          return [nombre, email, estrellas, descrip]
      }
    })
    
    if(formValues) {
      //Swal.fire(JSON.stringify(formValues));
      //Para enviar el formulario
      //document.getElementById("formularioreseña").submit();

      let es;

      //Para poner el sistema de puntuación
      if(formValues[2] == 1){
        es= '<i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i>';
      }
      else if(formValues[2] == 2){
        es= '<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i>';
      }
      else if(formValues[2] == 3){
        es= '<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i>';
      }
      else if(formValues[2] == 4){
        es= '<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>';
      }
      else if(formValues[2] == 5){
        es= '<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>';
      }

      //Para obtener la fecha y hora actuales
      var hoy = new Date();
      var fecha = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear();
      var hora = hoy.getHours() + ':' + (hoy.getMinutes()<10?'0':'') + hoy.getMinutes();
      var fechaYHora = 'El ' + fecha + ' a las ' + hora;
      //Obteniendo una variable con la máscara d-m-Y H:i

      //HTML para incluir una nueva reseña
      let s= '<hr><br>' + 
      '<p><strong>Usuario: </strong> ' + formValues[0] + '</p> <br>' +
      '<p><strong>Fecha y hora: </strong> ' + fechaYHora + ' </p> <br>' +
      '<p><strong>Puntuación: </strong>' + es +'<br/><br></p>' +
      '<strong>Reseña: </strong>' + formValues[3] + '<br/><br/>';
      
      let h= document.getElementById("ventanareseñas");

      //Funcion para añadir un elemento antes del final del nodo padre h, que es el section con id= ventanareseñas
      h.insertAdjacentHTML("beforeend", s);
    }
  })()
}

/* Función para la censura de palabras a la vez que se escribe */
function censuraPalabras(){

  const CENSURA = '*';
  var fraseNormal = document.getElementById("descrip").value;
  var frase = document.getElementById("descrip").value.match(/[a-z'\-]+/gi);
  var separadas = [];
  var frasefinal = fraseNormal;

  for(i = 0; i < frase.length; i++){
      separadas.push(String(frase[i]));
  }

  for(j = 0; j < palabrasMal.length; j++){
      var encontrada = separadas.indexOf(String(palabrasMal[j]));

      if(encontrada != -1){
          frasefinal = fraseNormal.replace(separadas[encontrada], CENSURA.repeat(separadas[encontrada].length));
      }
  }

  document.getElementById("descrip").value = frasefinal;
}

//Para que el número al lado del rango se actualice conforme se mueve
function actualizarValor(){
  let rango= document.getElementById("estrellas");

  rango.addEventListener('input', updateValue);

  function updateValue(){
      document.getElementById("valor").innerText= rango.value;
  }
}

//Para el formulario de iniciar sesión
function iniciarSesion(){
  (async () => {
    const { value: formValues } = await Swal.fire({
      title: "Iniciar sesión",
      html:
        "<form id='formulariosesion' method='post' enctype='multipart/form-data' action='login.php'>"+
          "<label for='nick' class='textformulario'>Nombre:</label>"+
          "<input type='text' id='nick' name='nick' class='swal2-input' placeholder='Nombre' autofocus>"+

          "<br><br>"+
          "<label for='contraseña' class='textformulario'>Contraseña:</label>"+
          "<input type='password' id='contraseña' name='contraseña' class='swal2-input' placeholder='Contraseña'>"+
      "</form>"+
      '<button id="registrar" onclick="registrar()" class="botonReg">Registrarse</button>',
        focusConfirm: false,
        heightAuto: false,
        confirmButtonText: 'Iniciar sesión',
        confirmButtonColor: '#64c196',
        showCloseButton: true,
        allowOutsideClick: true,
        backdrop: true,
        allowEscapeKey: true,
        preConfirm: () => {
          nick= document.getElementById('nick').value;
          contraseña= document.getElementById('contraseña').value;

          console.log(nick);

          //Para comprobar que se han puesto los elementos
          if (!nick && !contraseña){
            Swal.showValidationMessage('No has introducido ningún elemento');
          }else if(!nick){
            Swal.showValidationMessage('Falta el nombre');
          }else if(!contraseña){
            Swal.showValidationMessage('Falta la contraseña');
          }
          
          //Para enviar el formulario
          //document.getElementById("formulariosesion").submit();

          return [nick, contraseña]
      }
    })

    if(formValues) {
      //Para enviar el formulario
      document.getElementById("formulariosesion").submit();
      
      
      console.log(document.getElementById("nick").value);
    }
  })()
}

function registrar(){
  (async () => {
    const { value: formValues } = await Swal.fire({
      title: "Registro",
      html:
        "<form id='formulariosesion' method='post' enctype='multipart/form-data' action='registro.php'>"+
          "<label for='nick' class='textformulario'>Nombre:</label>"+
          "<input type='text' id='nick' name='nick' class='swal2-input' placeholder='Nombre' autofocus>"+

          "<br><br>"+
          "<label for='email' class='swal2'>email:</label>"+
          "<input type='mail' id='email' name='email' class='swal2-input' placeholder='email'>"+

          "<br><br>"+
          "<label for='contraseña' class='swal2'>Contraseña:</label>"+
          "<input type='password' id='contraseña' name='contraseña' class='swal2-input' placeholder='Contraseña'>"+
      "</form>",
      //html: document.getElementById("formulariosesion").innerHTML,
        focusConfirm: false,
        heightAuto: false,
        confirmButtonText: 'Registrate',
        confirmButtonColor: '#64c196',
        showCloseButton: true,
        allowOutsideClick: true,
        backdrop: true,
        allowEscapeKey: true,
        preConfirm: () => {
          nick= document.getElementById('nick').value;
          contraseña= document.getElementById('contraseña').value;

          console.log(nick);

          //Para comprobar que se han puesto los elementos
          if (!nick && !contraseña){
            Swal.showValidationMessage('No has introducido ningún elemento');
          }else if(!nick){
            Swal.showValidationMessage('Falta el nombre');
          }else if(!contraseña){
            Swal.showValidationMessage('Falta la contraseña');
          }
          
          //Para enviar el formulario
          //document.getElementById("formulariosesion").submit();

          return [nick, contraseña]
      }
    })
    
    if(formValues) {
      //Para enviar el formulario
      document.getElementById("formulariosesion").submit();
      
      
      console.log(document.getElementById("nick").value);
    }
  })()
}

function cerrarSesion(){
  Swal.fire({
      title: "Cerrar sesión",
      text: '¿Quieres cerrar sesión?',
      focusConfirm: false,
      heightAuto: false,
      confirmButtonText: 'Cerrar',
      confirmButtonColor: '#64c196',
      showCloseButton: true,
      allowOutsideClick: true,
      showDenyButton: true,
      denyButtonText: "Cancelar",
      backdrop: true,
      allowEscapeKey: true,
  }).then((result) => {
    //Si se pulsa el botón de cerrar
    if (result.isConfirmed){
      window.location.href = "logout.php";
    }
  })
}

function errores(){
  Swal.fire({
      icon: 'error',
      title: "Error",
      html: document.getElementById("error").innerHTML,
      focusConfirm: true,
      heightAuto: false,
      showConfirmButton: false,
      showCloseButton: false,
      allowOutsideClick: false,
      backdrop: true,
      allowEscapeKey: false,
      timer: 3500, 
  })
}

function editar(){
  var nombre= document.getElementById('nombre');
  var email= document.getElementById('email');
  var contraseña= document.getElementById('contraseñausu');
  var terminar= document.getElementById('terminar');
  var editar= document.getElementById('editar');

  nombre.removeAttribute("readonly" , false);
  email.removeAttribute("readonly" , false);
  contraseña.style.display="block";
  document.getElementById('labelusu').style.display="block";
  terminar.style.display="block";

  nombre.className= 'swal2-input';
  email.className= 'swal2-input';
  editar.style.display="none";
}

function editarOtrosUsuarios(){
  var form1= document.getElementById('formularioUsuario');
  var form2= document.getElementById('formularioOtrosUsuarios');
  var terminar= document.getElementById('Acabar');
  var editar= document.getElementById('editar');

  form1.style.display="none";
  form2.style.display="block";
  terminar.style.display="block";
  document.getElementById('editarUsu').style.display="none";

  editar.style.display="none";
}

//Funcion que usa la libreria sweetalert2 para mostrar la pantalla emergente con el formulario
function añadirProducto(){
  (async () => {
    const { value: formValues } = await Swal.fire({
      title: "Incluir un nuevo producto",
      html:
        "<form id='formularioProducto' method='post' enctype='multipart/form-data' action='incluirProducto.php' autocomplete='off'>"+
        "<label for='nombre' class='textformulario'>Nombre:</label>"+
        "<input type='text' id='nombre' name='nombre' class='swal2-input' placeholder='Nombre'>"+

        "<br><br>"+
        "<label for='info' class='textformulario'>Info de la portada:</label>"+
        '<textarea id="info" name="info" style="height:auto!important;resize: none;" placeholder="Escribe tu reseña." class="swal2-input" rows="6" cols="32" oninput="censuraPalabras()"></textarea>'+

        "<br><br>"+
        "<label for='contenido' class='textformulario'>Contenido:</label>"+
        '<textarea id="contenido" name="contenido" style="height:auto!important;resize: none;" placeholder="Escribe tu reseña." class="swal2-input" rows="8" cols="32" oninput="censuraPalabras()"></textarea>'+

        "<br><br>"+
        "<label for='foto' class='textformulario'>Foto portada:</label>"+
        "<input type='file' id='foto' name='foto'  class='swal2-input'>"+

        "</form>",
        focusConfirm: false,
        heightAuto: false,
        confirmButtonText: 'Añadir producto',
        confirmButtonColor: '#64c196',
        showCloseButton: true,
        showDenyButton: true,
        denyButtonText: "Cancelar",
        allowOutsideClick: true,
        backdrop: true,
        allowEscapeKey: true,
        
        preConfirm: () => {
          //Para enviar el formulario
          //document.getElementById("formularioreseña").submit();

          nombre= document.getElementById('nombre').value;
          info= document.getElementById('info').value;
          contenido= document.getElementById('contenido').value;

          //Para comprobar que se han puesto los elementos
          if (!nombre && !info && !contenido){
            Swal.showValidationMessage('No has introducido ningún elemento');
          }else if(!nombre){
            Swal.showValidationMessage('Falta el nombre');
          }else if(!info){
            Swal.showValidationMessage('Falta la información');
          }else if(!contenido){
            Swal.showValidationMessage('Falta el contenido');
          }
          
          return [nombre, email, estrellas, descrip]
      }
    })
    
    if(formValues) {
      //Swal.fire(JSON.stringify(formValues));
      //Para enviar el formulario
      document.getElementById("formularioProducto").submit();
    }
  })()
}