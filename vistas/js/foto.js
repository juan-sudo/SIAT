class Foto {
  constructor() {
      this.imagesArray = [];
      this.modal_mostrar_foto = null;
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
  MostrarFotosPredio(id_predio) {
      const formData = new FormData();
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
              } else {
                  alert('No hay fotos para este predio.');
              }
          },
          error: function () {
              alert('Error al cargar las fotos.');
          }
      });
  }
}
const foto = new Foto();


$("#abrirFoto").on("click", function (e) {
   
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
 
 $("#id_predio_foto").on("click", function (e) {
    var id_predio_foto = $(this).data('id_predio_foto');
    foto.modal_mostrar_foto=true;
    console.log(foto.modal_mostrar_foto);
    foto.MostrarFotosPredio(id_predio_foto);
 });

 reader.onload = function (e) {
  if (foto.imagesArray.length < maxImages) {
      const imageUrl = e.target.result; // Esto es base64
      addImage(imageUrl); // No necesitas pasar true
  }
};