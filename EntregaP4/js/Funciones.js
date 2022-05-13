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

  console.log(palabrasMal);
});

//document.addEventListener('error', errorLogin());

//Todo esto es para hacerlo síncorno, y hasta que no termina el swal.fire no sigue con el if
//Esto sirve para obtener valores del swal.fire
function verReseñasUsuario(){
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

// Este es para los usuarios no logeados
function verReseñas(){
  Swal.fire({
      title: "Reseñas",
      html: document.getElementById("ventanareseñas").innerHTML,
      showConfirmButton: false,
      showCloseButton: true,
      footer: 'Aquí se pueden ver unas reseñas',
      allowOutsideClick: true,
      backdrop: true,
      allowEscapeKey: true,
  })
}

//Funcion que usa la libreria sweetalert2 para mostrar la pantalla emergente con el formulario
function añadirReseña(){
  (async () => {
    const { value: formValues } = await Swal.fire({
      title: "Reseña",
      html: 
        "<form id='formularioreseña' method='post' enctype='multipart/form-data' action='añadirReseña.php'>"+
          "<input type='text' id='nombre' name='nombre' class='oculto' value="+document.getElementById('nombreUsuario').innerText+" readonly>"+

          "<input type='text' id='idprod' name='idprod' class='oculto' value="+document.getElementById('idProducto').innerText+" readonly>"+

          "<br><br>"+

          "<label for='estrellas' class='textformulario'>Puntuación: </label> <br>"+
          '<input id="estrellas" name="estrellas" type="range" min="1" max="5" value="1" onmousedown="actualizarValor()"> <span id="valor">1</span>'+

          "<br><br>"+
          "<label for='descrip' class='textformulario'>Reseña: </label>"+
          "<br>"+
          //El height:auto!important sirve para que de pueda poner el textarea del tamaño que quiero
          '<textarea id="descrip" name="descrip" style="height:auto!important;resize: none;" placeholder="Escribe tu reseña." class="swal2-input" rows="9" cols="32" oninput="censuraPalabras()"></textarea>'+
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
        preConfirm: () => {
          nombre= document.getElementById('nombre').value;
          idprod= document.getElementById('idprod').value;
          estrellas= document.getElementById('estrellas').value;
          descrip= document.getElementById('descrip').value;

          //Para comprobar que se han puesto los elementos
          if(!descrip){
            Swal.showValidationMessage('Falta la reseña');
          }
          
          return [nombre, idprod, estrellas, descrip]
      }
    })
    
    if(formValues) {
      //Para enviar el formulario
      document.getElementById("formularioreseña").submit();
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

          return [nick, contraseña]
      }
    })

    if(formValues) {
      //Para enviar el formulario
      document.getElementById("formulariosesion").submit();
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

          return [nick, contraseña]
      }
    })
    
    if(formValues) {
      //Para enviar el formulario
      document.getElementById("formulariosesion").submit();
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

// Para añadirle funcionalidades al formulario de editar usuario
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

//Para la confirmación de eliminar un producto
function eliminarProducto(){
  Swal.fire({
    title: "Eliminar producto",
    //text: '¿Quieres eliminar este producto?',
    text: document.getElementById('nombreProducto').innerText.toLocaleLowerCase(),
    focusConfirm: false,
    heightAuto: false,
    confirmButtonText: 'Eliminar',
    confirmButtonColor: '#64c196',
    showCloseButton: true,
    allowOutsideClick: true,
    showDenyButton: true,
    denyButtonText: "Cancelar",
    backdrop: true,
    allowEscapeKey: true,
  }).then((result) => {
    //Si se pulsa el botón de eliminar
    if(result.isConfirmed){
      document.getElementById('formularioEliminarProducto').submit();
    }
  })
}

//Funcion que usa la libreria sweetalert2 para mostrar la pantalla emergente con el formulario
function añadirProducto(){
  (async () => {
    const { value: formValues } = await Swal.fire({
      title: "Añadir producto",
      html: 
        "<form id='formañadir' method='post' enctype='multipart/form-data' action='incluirProducto.php' autocomplete='off'>"+
          "<label for='nombre' class='textformulario'>Nombre: </label> <br>"+
          "<input type='text' id='nombre' name='nombre' class='swal2-input'>"+

          "<label for='precio' class='textformulario'>Precio: </label> <br>"+
          "<input type='number' id='precioañadir' name='precioañadir' class='swal2-input'>"+

          "<br><br>"+
          "<label for='infoprod' class='textformulario'>Info: </label> <br>"+
          '<textarea id="infoprod" name="infoprod" onKeyDown="valida_longitud()" style="height:auto!important;resize: none;" placeholder="Escribe tu info." class="swal2-input" rows="9" cols="32" oninput="censuraPalabras()"></textarea>'+

          "<br><br>"+
          "<label for='contenido' class='textformulario'>Contenido: </label>"+
          "<br>"+
          '<textarea id="descrip" name="contenido" style="height:auto!important;resize: none;" placeholder="Escribe tu contenido." class="swal2-input" rows="9" cols="32" oninput="censuraPalabras()"></textarea>'+
      
          "<label for='etiquetas' class='textformulario'>Etiquetas: </label> <br>"+
          "<input type='text' id='etiquetas' name='etiquetas' class='swal2-input'>"+

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
          nombre= document.getElementById('nombre').value;
          precio= document.getElementById('precioañadir').value;
          info= document.getElementById('infoprod').value;
          contenido= document.getElementById('descrip').value;

          //Para comprobar que se han puesto los elementos
          if(!info && !nombre && !contenido && !precio){
            Swal.showValidationMessage('Falta la reseña');
          }else if(!precio){
            Swal.showValidationMessage('Falta el precio');
          }else if(!info){
            Swal.showValidationMessage('Falta la info');
          }else if(!contenido){
            Swal.showValidationMessage('Falta el contenido');
          }
          
          return [nombre, precio, info, contenido]
      }
    })
    
    if(formValues) {
      //Para enviar el formulario
      document.getElementById("formañadir").submit();
    }
  })()
}

//Funcion que usa la libreria sweetalert2 para mostrar la pantalla emergente con el formulario
function editarProducto(){
  (async () => {
    const { value: formValues } = await Swal.fire({
      title: "Editar producto",
      html: 
        "<form id='foredit' method='post' enctype='multipart/form-data' action='editarProducto.php'>"+
          "<input type='text' id='idProc' name='idProc' class='oculto' value="+document.getElementById('idProc').innerText+">"+

          "<label for='nombre' class='textformulario'>Nombre: </label> <br>"+
          "<input type='text' id='nombre' name='nombre' class='swal2-input' value="+document.getElementById('tit').innerText+">"+

          "<label for='precioed' class='textformulario'>Precio: </label> <br>"+
          "<input type='number' id='precioed' name='precioed' class='swal2-input' value="+document.getElementById('precio').innerText+">"+

          "<br><br>"+
          "<label for='infoed' class='textformulario'>Info: </label> <br>"+
          '<textarea id="infoprod" name="infoprod" onKeyDown="valida_longitud()" style="height:auto!important;resize: none;" placeholder="Escribe tu info." class="swal2-input" rows="9" cols="32" oninput="censuraPalabras()">'+ document.getElementById('info').innerText +'</textarea>'+

          "<br><br>"+
          "<label for='contenidoed' class='textformulario'>Contenido: </label>"+
          "<br>"+
          '<textarea id="contenidoed" name="contenidoed" style="height:auto!important;resize: none;" placeholder="Escribe tu contenido." class="swal2-input" rows="9" cols="32" oninput="censuraPalabras()">'+ document.getElementById('contenido').innerText +'</textarea>'+
      
          "<label for='etiquetas' class='textformulario'>Etiquetas: </label> <br>"+
          "<input type='text' id='etiquetas' name='etiquetas' class='swal2-input' value='"+ document.getElementById('etiq').innerText +"'>"+

          "<br><br>"+
          "<label for='foto' class='textformulario'>Foto portada:</label>"+
          "<input type='file' id='foto' name='foto'  class='swal2-input'>"+
        "</form>",
        focusConfirm: false,
        heightAuto: false,
        confirmButtonText: 'Editar producto',
        confirmButtonColor: '#64c196',
        showCloseButton: true,
        showDenyButton: true,
        denyButtonText: "Cancelar",
        allowOutsideClick: true,
        backdrop: true,
        allowEscapeKey: true,
        preConfirm: () => {
          id= document.getElementById('idProc').value;
          nombre= document.getElementById('nombre').value;
          precio= document.getElementById('precioed').value;
          info= document.getElementById('infoprod').value;
          contenido= document.getElementById('contenidoed').value;

          console.log(precio);

          //Para comprobar que se han puesto los elementos
          if(!info && !nombre && !contenido && !precio){
            Swal.showValidationMessage('Falta la reseña');
          }else if(!precio){
            Swal.showValidationMessage('Falta el precio');
          }else if(!info){
            Swal.showValidationMessage('Falta la info');
          }else if(!contenido){
            Swal.showValidationMessage('Falta el contenido');
          }
          
          return [id, nombre, precio, info, contenido]
      }
    })
    
    if(formValues) {
      //Para enviar el formulario
      document.getElementById("foredit").submit();
    }
  })()
}

contenido_textarea = ""
num_caracteres_permitidos = 80

function valida_longitud(){
  num_caracteres = document.getElementById('infoprod').value.length

  if (num_caracteres > num_caracteres_permitidos){
     document.getElementById('infoprod').value = contenido_textarea
  }else{
     contenido_textarea = document.getElementById('infoprod').value
  }

  return num_caracteres;
}


function añadirFoto(){
  (async () => {
    const { value: formValues } = await Swal.fire({
      title: "Añadir foto",
      html: 
        "<form id='formulariofoto' method='post' enctype='multipart/form-data' action='añadirFoto.php'>"+
          "<input type='text' id='idProc' name='idProc' class='oculto' value="+document.getElementById('idProc').innerText+">"+

          "<br><br>"+
          "<label for='foto' class='textformulario'>Foto:</label>"+
          "<input type='file' id='foto' name='foto'  class='swal2-input'>"+
        "</form>",
        focusConfirm: false,
        heightAuto: false,
        confirmButtonText: 'Añadir',
        confirmButtonColor: '#64c196',
        showCloseButton: true,
        showDenyButton: true,
        denyButtonText: "Cancelar",
        allowOutsideClick: true,
        backdrop: true,
        allowEscapeKey: true,
        preConfirm: () => {
          id= document.getElementById('idProc').value;
          foto= document.getElementById('foto').value;

          console.log(precio);

          //Para comprobar que se han puesto los elementos
          if(!foto){
            Swal.showValidationMessage('Falta la foto');
          }
          
          return [id, foto]
      }
    })
    
    if(formValues) {
      //Para enviar el formulario
      document.getElementById("formulariofoto").submit();
    }
  })()
}
