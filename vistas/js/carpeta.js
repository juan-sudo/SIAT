//PASAR EL VALOR DE CONTRIBUYENTE BUSCADO A PREDIOS POR GET - VALIDADO
class carpetaEditar {




  constructor() {
     this.idContribuyente=null;
  }



//CARGAR PARA EDITAR CARPETA
  editarCarpetaProgreso(idCarpeta){
    console.log("aqui ya vas  vienes..-------------", idCarpeta)

    let idDireccion;
    let datos = new FormData();
    datos.append("idCarpeta", idCarpeta);
    $.ajax({
      url: "ajax/carpeta.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {

        console.log("paar cargar en la vista progreso",respuesta);
        // //(respuesta)
       // $("#estado_progreso").val(respuesta["Estado_progreso"]).change(); 
      if (respuesta["Estado_progreso"]) {
        $("#estado_progreso").val(respuesta["Estado_progreso"]).change();
      }

      // Asignar observaciones
      if (respuesta["observacion_progreso"]) {
        $("#observacion_progreso").val(respuesta["observacion_progreso"]);
      }
      if (respuesta["observacion_pendiente"]) {
        $("#observacion_pendiente").val(respuesta["observacion_pendiente"]);
      }


       // Asignar completado oficina y campo
      if (respuesta["completado_oficina"] === "on") {
        $("#completado_oficina").prop("checked", true);
      } else {
        $("#completado_oficina").prop("checked", false);
      }

      if (respuesta["completado_campo"] === "on") {
        $("#completado_campo").prop("checked", true);
      } else {
        $("#completado_campo").prop("checked", false);
      }



        //  $("#codigo_carpeta").val(respuesta["Codigo_Carpeta"]); 

          // Actualizar la barra de progreso en base al valor recibido
        actualizarBarraDeProgreso(respuesta["Estado_progreso"]);

      },
    });
  }

 

  guardar_editar_progreso(datosFormulario){

    //const isoValue = document.getElementById("mySpan").getAttribute("iso");

   // datosFormulario.id_usuario = isoValue;
    console.log("formulario de progreso..",datosFormulario);


    $.ajax({
      type: 'POST',
      url: 'ajax/carpeta.ajax.php', // Cambia esto por la URL a la que envías los datos
      data: datosFormulario, // Serializa los datos del formulario
      success: function(respuesta) {
        if (respuesta.tipo === "correcto") {
          $("#modalEditarcontribuyente").modal("hide");
          $("#respuestaAjax_srm").show(); // Mostrar el elemento #error antes de establecer el mensaje
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
            window.location.href = window.location.href; // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
            // Recargar la página manteniendo los parámetros actuales
          }, 1000); // 3000 milisegundos = 3 segundos (ajusta según tus preferencias)
        } else {
          $("#modalEditarcontribuyente").modal("hide");
          $("#respuestaAjax_srm").show(); // Mostrar el elemento #error antes de establecer el mensaje
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
            // Recargar la página manteniendo los parámetros actuales
          }, 3000); // 3000 milisegundos = 3 segundos (ajusta según tus preferencias)
        }
      }
    });



   }


   
}


const editarCarpeta_ = new carpetaEditar();



// MODAL ABRIL MODAL DE PROGRESO
$(document).on("click", "#editar_progreso_Predio", function () {

  const carpetaContribuyente = document.querySelector('#carpeta_contribuyente').textContent.trim();

  console.log("valor actual",carpetaContribuyente);


    // Asignarlo al input
    $('#codigo_carpeta').val(carpetaContribuyente);

  editarCarpeta_.editarCarpetaProgreso(carpetaContribuyente); // Llamar al método para cargar los datos del contribuyente y actualizar el modal


  // Mostrar el modal
  $("#modal_editar_barra_progreso").show();
});






// Cerrar el modal de progreso
$(document).on("click", "#salir_modal_progreso", function () {
  $("#modal_editar_barra_progreso").hide();
});

// Actualizar la barra de progreso dinámicamente
function actualizarBarraDeProgreso(estado_progreso) {
  var progreso = 0;
  var colorBarra = ""; // Inicializar la variable para el color de la barra

  // Cambiar el valor del progreso y el color de la barra según el estado recibido
  if (estado_progreso === 'P') {
    progreso = 30; // Pendiente
    colorBarra = "#ffc107"; // Amarillo para pendiente
    $("#campo_observacion").hide();
    $("#campletado_desde_Campo").hide();
    $("#campletado_desde_oficina").hide();
     $("#campo_observacion_p").show();

    
   


  } else if (estado_progreso === 'E') {
    progreso = 60; // En Progreso
    colorBarra = "#17a2b8"; // Naranja para en progreso
     $("#campo_observacion").show();
      $("#campletado_desde_Campo").hide();
      $("#campletado_desde_oficina").hide();
       $("#campo_observacion_p").hide();


  } else if (estado_progreso === 'C') {
    progreso = 100; // Completado
    colorBarra = "#28a745"; // Verde para completado
      $("#campo_observacion").hide();
     $("#campletado_desde_Campo").show();
     $("#campletado_desde_oficina").show();
      $("#campo_observacion_p").hide();

     

  }

  // Actualiza la barra de progreso con el porcentaje y el color
  $("#progress-bar").css("width", progreso + "%");
  $("#progress-bar").css("background-color", colorBarra); // Cambiar el color de fondo
  $("#progress-bar").attr("aria-valuenow", progreso); // Para accesibilidad
  $("#progress-bar").text(progreso + "%"); // Muestra el porcentaje dentro de la barra
}

// GUARDAR PROGRESSO EDITADO
$('#formCarpetaProgress').on('submit', function(event) {
  event.preventDefault();
    // Serializa los datos del formulario
    var datosFormulario = $(this).serialize(); 


    
  const isoValue = document.getElementById("mySpan").getAttribute("iso");
  datosFormulario += '&id_usuario=' + encodeURIComponent(isoValue);
    console.log(datosFormulario); 
 
    datosFormulario += '&guardar_estado_progreso=guardar_estado_progreso'; 
    editarCarpeta_.guardar_editar_progreso(datosFormulario);


})


// Cuando el usuario cambia el valor del select, se actualiza la barra
$('#estado_progreso').on('change', function () {
  const nuevoEstado = $(this).val(); // Obtener valor seleccionado
  actualizarBarraDeProgreso(nuevoEstado); // Actualizar barra
});

