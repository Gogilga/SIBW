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