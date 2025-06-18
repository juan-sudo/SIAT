class Foto {
  constructor() {
      this.imagesArray = [];
      this.modal_mostrar_foto = null;
      this.modal_mostral_foto_modal=null;
  }

  // Método para cargar imágenes
  async cargar_foto() {
      const formData = new FormData();

      // Procesar todas las imágenes (nuevas y existentes)
      for (let index = 0; index < this.imagesArray.length; index++) {
          const imageUrl = this.imagesArray[index];

          if (imageUrl.startsWith('data:image')) {
              // Si es una nueva imagen en formato DataURL, convertirla a Blob
              const blob = dataURLtoBlob(imageUrl);
              if (blob) {
                  formData.append('images[]', blob, `image${index}.jpg`);
              } else {
                  console.error(`Error al convertir la imagen ${index} a Blob.`);
              }
          } else {
              // Si es una imagen existente (URL), convertirla a Blob mediante fetch
              try {
                  const blob = await urlToBlob(imageUrl);
                  if (blob) {
                      formData.append('images[]', blob, `existing_image${index}.jpg`);
                  } else {
                      console.error(`Error al descargar la imagen existente: ${imageUrl}`);
                  }
              } catch (error) {
                  console.error(`Error al procesar la imagen existente: ${imageUrl}`, error);
              }
          }
      }

      // Añadir otros datos al FormData
      formData.append("foto_guardar", "foto_guardar");
      formData.append("id_predio", predio.id_predio);

      // Verificar el contenido del formData para depuración
      for (let pair of formData.entries()) {
          console.log(pair[0] + ', ' + pair[1]);
      }

      // Enviar el FormData mediante AJAX
      $.ajax({
          type: "POST",
          url: "ajax/predio.ajax.php",
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          beforeSend: function () {
              $(".cargando").html(loadingMessage_s);
              $("#modal_cargar").modal("show");
          },
          success: function (respuesta) {
              $("#modal_cargar").modal("hide");

              if (respuesta.tipo === "error") {
                  $("#respuestaAjax_srm").show();
                  $("#respuestaAjax_srm").html(respuesta.mensaje);
                  setTimeout(function () {
                      $("#respuestaAjax_srm").hide();
                  }, 10000);
              } else {
                  $("#modal_foto").modal("hide");
                  $("#respuestaAjax_srm").html(respuesta.mensaje);
                  $("#modalEliminarPredio").modal("hide");
                  $("#respuestaAjax_srm").show();
                  predio.lista_predio(predio.anio_predio);

                  setTimeout(function () {
                      $("#respuestaAjax_srm").hide();
                  }, 10000);
              }
          },
          error: function () {
              $("#modal_cargar").modal("hide");
              $("#respuestaAjax_srm").show();
              $("#respuestaAjax_srm").html("Error al guardar foto.");
              setTimeout(function () {
                  $("#respuestaAjax_srm").hide();
              }, 10000);
          }
      });
  }


  // Mostrar fotos del predio en el carrusel


// Mostrar fotos del predio en el carrusel
MostrarFotosPredioModal(id_predio) {
    const formData = new FormData();
    formData.append("mostrar_foto_carrusel_modal", "mostrar_foto_carrusel_modal");
    formData.append("id_predio", id_predio);

    $.ajax({
        type: 'POST',
        url: "ajax/predio.ajax.php",  // Asegúrate de que esta URL sea la correcta
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log("respuesta de las imágenes", response);

            // Limpiar el carrusel y los indicadores
           $('#carousel-example-generic .carousel-indicators').empty();
            $('#carousel-example-generic .carousel-inner').empty();
            $('#modalFotosPredio .show-historial-predio').empty(); // Limpiar el historial
            $('#mensaje-no-fotos').hide(); // Ocultar el mensaje de no fotos

            let estado_t=response[0].Direccion_completo;
            let usuario_Actual = response[response.length - 1].usuario;

           
               // Crear el botón y agregarlo al div '.aqui'
               $('.aqui').html(`
                <div style="padding: 5px;  display: flex; align-items: center;" class="text-muted" >
                    <h5 style=" font-weight: bold; margin-right: 10px;">Dirección del Predio:</h5>
                    <p style="font-size: 16px; line-height: 1.5; margin: 0;">
                        ${estado_t}
                    </p>
                </div>
            `);


            // Verificar si hay fotos
            
            // Verificar si hay fotos
            // Verificar si hay fotos
            // Verificar si hay fotos

            // Verificar si hay fotos
          // Verificar si hay fotos
          // Verificar si hay fotos

            // Verificar si hay fotos
           // Verificar si hay fotos
  // Verificar si hay fotos

  if (response.length > 0) {
    let timeline = '';
    let lastDetalleTransferencia = null; // Para comparar y agrupar fotos con el mismo Id_Detalle_Transferencia
    let panelBodyContent = ''; // Para agrupar las fotos y detalles
    let separatorTime = ''; // Para guardar el tiempo del separator
    let separatorTimeR = ''; // Para guardar el tiempo del separator
    let separatorTime1 = ''; // Para guardar el tiempo del separator
    let separatorTimeR1 = ''; // Para guardar el tiempo del separator

    // Crear el encabezado de la tabla una sola vez
    let tableHeader = `
        <thead>
            <tr>
               
                <th style="width: 10%;"><strong>Codigo</strong></th>
                <th style="width: 20%;"><strong>Documento</strong></th>

                <th style="width: 70%;"><strong>Contribuyentes</strong></th>
                
            </tr>
        </thead>
    `;

    
    // Iterar sobre todas las fotos y mostrarlas en la línea de tiempo
    response.forEach(function (foto, index) {

       
       
        // Verificar cuál fecha usar para el separator (Fecha_Transferencia o Fecha_Registro)
     

        // Si el Id_Detalle_Transferencia es el mismo, agregar la foto al mismo bloque
        if (foto.Id_Detalle_Transferencia === lastDetalleTransferencia) {

          
            
            // Si ya hemos agregado una fila, solo agregamos el detalle sin el encabezado
            panelBodyContent += `
                <div class="row">
                    <div class="col-md-12" style='padding:0'>
                        <table>
                           <tr>
                              
                             
                               
                                <td style="width: 10%;">${foto.Id_Contribuyente}</td>
                                <td style="width: 20%;">${foto.Documento}</td>
                                
                                 <td style="width: 70%;">${foto.Nombre_Completo}</td>
                               
                              
                                </tr>

                        </table>
                    </div>
                </div>
            `;
        } else {
            
            // Si es un nuevo Id_Detalle_Transferencia, agregar el bloque anterior y luego el nuevo con el encabezado
            if (panelBodyContent) {
                timeline += `
                    <div class="timeline" style='padding-bottom:0px'>
                    
                        <div class="line text-muted"></div>
                    

                           <article class="panel panel-default panel-outline" style='border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>
                   
                            <div class="panel-heading icon" >
                                 <i class="glyphicon glyphicon-remove-circle" style="color: #c77b5f;"> </i>
                            </div>
                            <div class="panel-body"  style="padding: 20px;">
                                ${panelBodyContent}
                            </div>
                               <div style="width: 100%;text-align: right; padding-right: 15px;">
                           
                             <div class="text-muted" > <strong> Usuario: </strong>  ${foto.usuario === null ? 'No registra' : foto.usuario}</div>
                       
                        </div>
                        </article>
                    </div>
                `;
            }

            // Reiniciar el contenido del panel para la nueva foto
            panelBodyContent = `

                <div class="row">
                    <div class="col-md-12" style='padding:0'>

                        <div style="width: 100%;">
                           
                             <div class="text-muted" > <strong> Estado: </strong>  <span  style="background-color: #f0f0f0; padding: 4px; border-radius: 5px;"> ${foto.Estado_Transferencia === 'R' ? 'Registrado' : 'Transferido'}</span>
                            </div>
                       
                        </div>

                       

                         <div style="width: 100%;">
                          
                              <div class="text-muted" > <strong> Fecha registro: </strong>  ${foto.Fecha_Registro === null ? 'No registra' : foto.Fecha_Registro}</div>
                       
                         
                              </div>
                             

                              <div style="width: 100%; display: ${foto.carpeta_origen === null ? 'none' : 'block'};">
                                <div class="text-muted">
                                    <strong> Carpeta origen: </strong>  
                                    ${foto.carpeta_origen === null ? 'No registra' : foto.carpeta_origen }
                                </div>
                                </div>


                              <div style="width: 100%; display: ${foto.carpeta_destino === null ? 'none' : 'block'};">
                            <div class="text-muted">
                                <strong> Carpeta actual: </strong> 
                                <span style="background-color: ${foto.carpeta_destino === null ? 'transparent' : '#dff0e0'}; padding: 2px; border-radius: 2px;">
                                ${foto.carpeta_destino === null ? 'No registra' : foto.carpeta_destino }
                                </span>
                            </div>
                            </div>

                    
                <div class="text-muted" > <strong>Propietarios </strong></div>


                        <table style="width: 100%; table-layout: fixed;" >
                            ${tableHeader} <!-- Agregar solo una vez el encabezado -->
                         <tr>
                           
                           
                       
                          
                            <td style="width: 10%;">${foto.Id_Contribuyente}</td>
                             <td style="width: 20%;">${foto.Documento}</td>
                               <td style="width: 70%;">${foto.Nombre_Completo}</td>
                              
                            
                        </tr>

                        </table>
                    </div>

                    
                </div>
              
            `;
        }

        // Actualizar el valor del Id_Detalle_Transferencia para la siguiente iteración
        lastDetalleTransferencia = foto.Id_Detalle_Transferencia;
    });

    // Asegurarse de agregar el último bloque si quedó pendiente
    if (panelBodyContent) {
        timeline += `
       
     
            <div class="timeline">
            
                <div class="line text-muted"></div>
             

                 <article class="panel panel-default panel-outline" style='border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>
                   
                    <div class="panel-heading icon">
                          <i class="glyphicon glyphicon-check"  style="color: green;"> </i>
                    </div>
                    <div class="panel-body"  style="padding: 20px;">
                        ${panelBodyContent}
                    </div>
                       <div style="width: 100%;text-align: right; padding-right: 15px;">
                           
                             <div class="text-muted" > <strong> Usuario: </strong>  ${usuario_Actual}</div>
                       
                        </div>
                </article>
                
            </div>
        `;
    }

    // Añadir la línea de tiempo al modal
    $('#modalFotosPredio .show-historial-predio').html(timeline);



    // Mostrar el modal
    $('#modalFotosPredio').modal('show');
} else {
    // Si no hay fotos, mostrar el mensaje de no fotos
   // $('#mensaje-no-fotos').show();
  //  $('#modalFotosPredio').modal('show');
}




        },
        error: function () {
            alert('Error al cargar las fotos.');
        }
    });
}



// // Mostrar fotos del predio en el carrusel
// MostrarFotosPredioModalHistorial(id_predio) {
  
    

//     const formData = new FormData();
//     formData.append("mostrar_foto_carrusel", "mostrar_foto_carrusel");
//     formData.append("id_predio", id_predio);

//     $.ajax({
//         type: 'POST',
//         url: "ajax/predio.ajax.php",  // Asegúrate de que esta URL sea la correcta
//         data: formData,
//         cache: false,
//         contentType: false,
//         processData: false,
//         success: function (response) {
//             console.log("respuesta de las imágenes", response);

//             // Limpiar el carrusel y los indicadores
//             $('#carousel-example-generic .carousel-indicators').empty();
//             $('#carousel-example-generic .carousel-inner').empty();

//             // Verificar si hay fotos
//             if (response.length > 0) {
//                 // Limpiar el mensaje de "No hay fotos"
//                 $('#mensaje-no-fotos').hide(); // Ocultar el mensaje de no fotos

//                 // Añadir fotos al carrusel
//                 response.forEach(function (foto, index) {
//                     $('#carousel-example-generic').carousel('pause');
//                     $('#carousel-example-generic .carousel-indicators').append(`
//                         <li data-target="#carousel-example-generic" data-slide-to="${index}" class="${index === 0 ? 'active' : ''}"></li>
//                     `);
//                     $('#carousel-example-generic .carousel-inner').append(`
//                         <div class="item ${index === 0 ? 'active' : ''}">
//                             <img src="${foto.ruta_foto}?v=${new Date().getTime()}" alt="Slide ${index + 1}">
//                         </div>
//                     `);
//                 });

//                 // Mostrar el modal
//                 $('#modalFotosPredio').modal('show');
//             } else {
//                 // Si no hay fotos, mostrar el mensaje de no fotos
//                 $('#mensaje-no-fotos').show();
//                 $('#modalFotosPredio').modal('show');
//             }
//         },
//         error: function () {
//             alert('Error al cargar las fotos.');
//         }
//     });
// }


  MostrarFotosPredio(id_predio) {
      const formData = new FormData();

      console.log("id del predio----que va---",id_predio );
      formData.append("mostrar_foto_carrusel", "mostrar_foto_carrusel");
      formData.append("id_predio", id_predio);

      $.ajax({
          type: 'POST',
          url: "ajax/predio.ajax.php",
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          success: function (response) {

           
            console.log("respusta del imagen",response);
              $('#carousel-example-generic .carousel-indicators').empty();
              $('#carousel-example-generic .carousel-inner').empty();

              if (response.length > 0) {
                  // Limpiar las imágenes actuales
                  foto.imagesArray = [];
                  imageContainer.innerHTML = '';

                  response.forEach(function (foto, index) {
                      $('#carousel-example-generic').carousel('pause');
                      $('#carousel-example-generic .carousel-indicators').append(`
                          <li data-target="#carousel-example-generic" data-slide-to="${index}" class="${index === 0 ? 'active' : ''}"></li>
                      `);
                      $('#carousel-example-generic .carousel-inner').append(`
                          <div class="item ${index === 0 ? 'active' : ''}">
                              <img src="${foto.ruta_foto}?v=${new Date().getTime()}" alt="Slide ${index + 1}">
                          </div>
                      `);
                      // Añadir la imagen al contenedor de edición
                      addImage(foto.ruta_foto, true);
                  });

                  // Mostrar el modal si corresponde
                  if (foto.modal_mostrar_foto === true) {
                    $('#modal_foto_ver').modal('show');
                }
               } 
            // else {
            //       alert('No hay fotos para este predio aqui.');
            //   }
          },
          error: function () {
              alert('Error al cargar las fotos.');
          }
      });
  }



  


}



const foto = new Foto();



// Función para abrir el modal y cargar las fotos cuando se hace clic en el botón correspondiente

// Evento de clic para el icono de imagen
// Evento de clic para el icono de imagen


$(document).on("click", "#id_predio_foto", function () {
    console.log("has hecho clikckkkk")

    // Obtener el id_predio de la propiedad data-id_predio_foto del icono
    var id_predio = $(this).data("id_predio_foto"); // Usamos .data() para obtener el atributo data-id_predio_foto
    console.log("id predio para iamgen ",id_predio );
    foto.modal_mostrar_foto=null;

    foto.imagesArray = [];
    // Verificar que se haya obtenido el id_predio
    if (id_predio) {
        

        // Llamar a la función que carga las fotos del predio en el carrusel
        foto.MostrarFotosPredioModal(id_predio);
       // foto.MostrarFotosPredioModalHistorial(id_predio);

        
        

        // Mostrar el modal con las fotos
       // $("#modal_foto").modal("show");
    } else {
        alert("ID del predio no encontrado.");
    }
});




$("#abrirFoto").on("click", function (e) {
    console.log("aqui ams se hace clcik-------");
   
    if (predio.id_predio > 0) {
      foto.modal_mostrar_foto=false;
        imageContainer.innerHTML = '';

        // Limpiar el array de imágenes
        foto.imagesArray = [];
       foto.MostrarFotosPredio(predio.id_predio,)
        $("#modal_foto").modal("show");
      } else {
        $("#respuestaAjax_srm").html(
          '<div class="alert warning">' +
            '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
            '<span aria-hidden="true" class="letra">×</span>' +
            '</button><p class="inner"><strong class="letra">Alerta!</strong> <span class="letra">Seleccione un Predio para poder Gestionar Fotos</span></p></div>'
        );
        $("#respuestaAjax_srm").show();
        setTimeout(function () {
          $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
        }, 10000);
      }
});
  

const maxImages = 3;
const imageInput = document.getElementById('imageInput');
const imageContainer = document.getElementById('imageContainer');

imageInput.addEventListener('change', function (event) {
    const files = event.target.files;

    // Verificar si el número total de imágenes no supera el límite
    if (foto.imagesArray.length + files.length > maxImages) {
        alert(`Solo puedes subir un máximo de ${maxImages} imágenes`);
        return;
    }

    // Procesar las nuevas imágenes seleccionadas
    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function (e) {
            if (foto.imagesArray.length < maxImages) {
                const imageUrl = e.target.result;
                addImage(imageUrl); // Agregar la imagen
            }
        };
        reader.readAsDataURL(file);
    });
});

function addImage(imageUrl, isFromServer = false) {
  const imageIndex = foto.imagesArray.length;
  foto.imagesArray.push(imageUrl);

  // Crear el contenedor para cada imagen
  const imageBox = document.createElement('div');
  imageBox.classList.add('image-box');

  const img = document.createElement('img');
  
  // Si la imagen proviene del servidor, agrega el timestamp para evitar caché
  if (isFromServer) {
      const timestamp = new Date().getTime();
      img.src = `${imageUrl}?v=${timestamp}`;
  } else {
      img.src = imageUrl; // Base64 URL no necesita timestamp
  }

  img.addEventListener('click', () => previewImage(imageIndex));

  const deleteBtn = document.createElement('button');
  deleteBtn.innerHTML = 'X';
  deleteBtn.classList.add('delete-btn');
  deleteBtn.addEventListener('click', () => deleteImage(imageIndex));

  imageBox.appendChild(img);
  imageBox.appendChild(deleteBtn);
  imageContainer.appendChild(imageBox);
}

function deleteImage(index) {
    foto.imagesArray.splice(index, 1); // Eliminar la imagen de la lista
    renderImages(); // Re-renderizar las imágenes
}

function renderImages() {
    imageContainer.innerHTML = ''; // Limpiar el contenedor de imágenes
    foto.imagesArray.forEach((imageUrl, index) => {
        const imageBox = document.createElement('div');
        imageBox.classList.add('image-box');

        const img = document.createElement('img');
        img.src = imageUrl;
        img.addEventListener('click', () => previewImage(index));

        const deleteBtn = document.createElement('button');
        deleteBtn.innerHTML = 'X';
        deleteBtn.classList.add('delete-btn');
        deleteBtn.addEventListener('click', () => deleteImage(index));

        imageBox.appendChild(img);
        imageBox.appendChild(deleteBtn);
        imageContainer.appendChild(imageBox);
    });
}

function previewImage(index) {
    const imageUrl = foto.imagesArray[index];
    window.open(imageUrl, '_blank');
}

// Función para convertir DataURL a Blob
function dataURLtoBlob(dataURL) {
  const [header, data] = dataURL.split(',');
  if (!header || !data) {
      console.error('Formato DataURL incorrecto');
      return null;
  }
  const mime = header.match(/:(.*?);/)[1];
  const binary = atob(data);
  const array = [];
  for (let i = 0; i < binary.length; i++) {
      array.push(binary.charCodeAt(i));
  }
  return new Blob([new Uint8Array(array)], { type: mime });
}
async function urlToBlob(imageUrl) {
  const response = await fetch(imageUrl);
  if (!response.ok) {
      throw new Error(`Error al obtener la imagen: ${response.statusText}`);
  }
  return await response.blob();
}
// Evento para el botón "Guardar"
$("#popiguardarfoto").on("click", function (e) {
  foto.cargar_foto();
});

//tomar foto

 

//  $("#id_predio_foto").on("click", function (e) {
//     var id_predio_foto = $(this).data('id_predio_foto');
//     foto.modal_mostrar_foto=true;
//     console.log(foto.modal_mostrar_foto);
//     foto.MostrarFotosPredio(id_predio_foto);
//  });


 reader.onload = function (e) {
  if (foto.imagesArray.length < maxImages) {
      const imageUrl = e.target.result; // Esto es base64
      addImage(imageUrl); // No necesitas pasar true
  }
};