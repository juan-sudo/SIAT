//PASAR EL VALOR DE CONTRIBUYENTE BUSCADO A PREDIOS POR GET - VALIDADO
class carpetaEditar {
  
  constructor() {
     this.idContribuyente=null;
  }
 
//CARGAR PARA EDITAR CARPETA
  editarCarpetaProgreso(idCarpeta){

    console.log("aqui ya vas -------------", idCarpeta)

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

        console.log("paar cargar en la vista ",respuesta);
        // //(respuesta)
        $("#estado_progreso").val(respuesta["Estado_progreso"]).change(); 

        //  $("#codigo_carpeta").val(respuesta["Codigo_Carpeta"]); 

          // Actualizar la barra de progreso en base al valor recibido
        actualizarBarraDeProgreso(respuesta["Estado_progreso"]);

        // $("#iduc").val(respuesta["Id_Ubica_Vias_Urbano"]);
        // $("#e_tipoDoc").val(respuesta["Id_Tipo_Documento"]);
        // $("#e_docIdentidad").val(respuesta["Documento"]);
        // $("#e_tipoContribuyente").val(respuesta["Id_Tipo_Contribuyente"]);
        // $("#e_codigo_sa").val(respuesta["Codigo_sa"]);
        // $("#e_razon_social").val(respuesta["Nombres"]);
        // $("#e_clasificacion").val(respuesta["Id_Clasificacion_Contribuyente"]);
        // $("#e_apellPaterno").val(respuesta["Apellido_Paterno"]);
        // $("#e_apellMaterno").val(respuesta["Apellido_Materno"]);
        // $("#e_condicionContri").val(respuesta["Id_Condicion_Contribuyente"]);
        // $("#e_nroUbicacion").val(respuesta["Numero_Ubicacion"]);
        // $("#e_nroLote").val(respuesta["Lote"]);
        // $("#e_nroDepartamento").val(respuesta["Numero_Departamento"]);
        // $("#e_nrobloque").val(respuesta["Bloque"]);
        // $("#e_nroLuz").val(respuesta["Numero_Luz"]);
        // $("#e_condicionpredio").val(respuesta["Id_Condicion_Predio_Fiscal"]);
        // $("#e_referencia").val(respuesta["Referencia"]);
        // $("#e_telefono").val(respuesta["Telefono"]);
        // $("#e_correo").val(respuesta["Correo"]);
        // $("#e_observacion").val(respuesta["Observaciones"]);
        // $("#usuarioCoactivo").prop('checked',respuesta["Coactivo"]==='1');
        // $("#usuarioFallecida").prop('checked',respuesta["Fallecida"]==='1');
        // let idDireccion = respuesta["Id_Ubica_Vias_Urbano"];
      },
    });
  }

 

  guardar_editar_progreso(datosFormulario){
   
  console.log(datosFormulario);

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

  // Asignar el valor al input oculto dentro del modal
  //$("#codigo_carpeta").val(codigoCarpeta);

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
  } else if (estado_progreso === 'E') {
    progreso = 60; // En Progreso
    colorBarra = "#17a2b8"; // Naranja para en progreso
  } else if (estado_progreso === 'C') {
    progreso = 100; // Completado
    colorBarra = "#28a745"; // Verde para completado
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

    console.log(datosFormulario); 
 
    datosFormulario += '&guardar_estado_progreso=guardar_estado_progreso'; 
    editarCarpeta_.guardar_editar_progreso(datosFormulario);

//   event.preventDefault();
//     var datosFormulario = $(this).serialize(); // Serializa los datos del formulario

//     let isChecked = $('#usuarioCoactivo').prop('checked');
//     let value= isChecked ? $('#usuarioCoactivo').attr('check') : $('#usuarioCoactivo').attr('uncheck');//extraemoes el valor del estado del check coactivo
//     datosFormulario += '&usuariocoactivo='+value;
//  //USUARIO FALLECIDO
//     let isCheckedf = $('#usuarioFallecida').prop('checked');
//     let valuef= isCheckedf ? $('#usuarioFallecida').attr('check') : $('#usuarioFallecida').attr('uncheck');//extraemoes el valor del estado del check coactivo
//     datosFormulario += '&usuariofallecida='+valuef;

//     datosFormulario += '&guardar_editar_contribuyente=guardar_editar_contribuyente'; 
   
  
//     console.log(datosFormulario); 
//   buscarcontribuyente_.guardar_editar_contribuyente(datosFormulario);
})


// Cuando el usuario cambia el valor del select, se actualiza la barra
$('#estado_progreso').on('change', function () {
  const nuevoEstado = $(this).val(); // Obtener valor seleccionado
  actualizarBarraDeProgreso(nuevoEstado); // Actualizar barra
});

