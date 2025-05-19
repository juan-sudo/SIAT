//PASAR EL VALOR DE CONTRIBUYENTE BUSCADO A PREDIOS POR GET - VALIDADO
class buscarcontribuyente {
  constructor() {
     this.idContribuyente=null;
  }
  eliminarcontribuyente(){
      let idContribuyente = $(this).attr("idContribuyente");
      let datos = new FormData();
      datos.append("idContribuyente", idContribuyente);
      Swal.fire({
        title: "¿Estás seguro de eliminar este al contribuyente?",
        text: "¡Si no lo está puede  cancelar la acción!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminarlo!",
      }).then((result) => {
        if (result.isConfirmed) {
          window.location =
            "index.php?ruta=buscarcontribuyente&idContribuyente=" + idContribuyente;
        }
      });
  }

  editarContribuyente(idContribuyente){

    let idDireccion;
    let datos = new FormData();
    datos.append("idContribuyente", idContribuyente);
    $.ajax({
      url: "ajax/contribuyente.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        // //(respuesta)
        $("#idc").val(respuesta["Id_Contribuyente"]);
        $("#iduc").val(respuesta["Id_Ubica_Vias_Urbano"]);
        $("#e_tipoDoc").val(respuesta["Id_Tipo_Documento"]);
        $("#e_docIdentidad").val(respuesta["Documento"]);
        $("#e_tipoContribuyente").val(respuesta["Id_Tipo_Contribuyente"]);
        $("#e_codigo_sa").val(respuesta["Codigo_sa"]);
        $("#e_razon_social").val(respuesta["Nombres"]);
        $("#e_clasificacion").val(respuesta["Id_Clasificacion_Contribuyente"]);
        $("#e_apellPaterno").val(respuesta["Apellido_Paterno"]);
        $("#e_apellMaterno").val(respuesta["Apellido_Materno"]);
        $("#e_condicionContri").val(respuesta["Id_Condicion_Contribuyente"]);
        $("#e_nroUbicacion").val(respuesta["Numero_Ubicacion"]);
        $("#e_nroLote").val(respuesta["Lote"]);
        $("#e_nroDepartamento").val(respuesta["Numero_Departamento"]);
        $("#e_nrobloque").val(respuesta["Bloque"]);
        $("#e_nroLuz").val(respuesta["Numero_Luz"]);
        $("#e_condicionpredio").val(respuesta["Id_Condicion_Predio_Fiscal"]);
        $("#e_referencia").val(respuesta["Referencia"]);
        $("#e_telefono").val(respuesta["Telefono"]);
        $("#e_correo").val(respuesta["Correo"]);
        $("#e_observacion").val(respuesta["Observaciones"]);
        $("#usuarioCoactivo").prop('checked',respuesta["Coactivo"]==='1');
        $("#usuarioFallecida").prop('checked',respuesta["Fallecida"]==='1');
        let idDireccion = respuesta["Id_Ubica_Vias_Urbano"];
      },
    });
  }



  loadcontribuyente_filtro_m(page,searchClass,init_envio){


    let area_usuario = $('#mySpan_area').attr('iso_area');
    
      let searchContribuyente = $("." + searchClass).val();

      console.log("valor estas aqui mobil---:"+searchContribuyente);
      console.log("valor estas aqui mobil--mm-:"+area_usuario);

      let parametros = {
        action: "ajax",
        page: page,
        searchContribuyente: searchContribuyente,
        tipo: searchClass,
        init_envio:init_envio,
        dpcontribuyentem: "dpcontribuyentem",
        perfilOculto_c: perfilOculto_c,
        area_usuario: area_usuario

      };

      Object.entries(parametros).forEach(([key, value]) => {
        console.log(key + " : " + value);
      });
     

      $.ajax({
        url: "vistas/tables/dataTables.php",
        data: parametros,
        beforeSend: function() {
          $(".body-contribuyente").html(loadingMessage);
        },
        success: function (data) {
          $(".body-contribuyente").html(data);
        },
        error: function() {
          $(".body-contribuyente").html(errordata);
        }
      });
  }


  loadcontribuyente_filtro(page,searchClass,init_envio){


    let area_usuario = $('#mySpan_area').attr('iso_area');
    
      let searchContribuyente = $("." + searchClass).val();

      console.log("valor estas aqui---:"+searchContribuyente);
      console.log("valor estas aqui--mm-:"+area_usuario);

      let parametros = {
        action: "ajax",
        page: page,
        searchContribuyente: searchContribuyente,
        tipo: searchClass,
        init_envio:init_envio,
        dpcontribuyente: "dpcontribuyente",
        perfilOculto_c: perfilOculto_c,
        area_usuario: area_usuario

      };

      $.ajax({
        url: "vistas/tables/dataTables.php",
        data: parametros,
        beforeSend: function() {
          $(".body-contribuyente").html(loadingMessage);
        },
        success: function (data) {
          $(".body-contribuyente").html(data);
        },
        error: function() {
          $(".body-contribuyente").html(errordata);
        }
      });
  }



  traerDireccion(idContribuyente) {
    // OPTENIENDO LA DIRECCION DEL CONTRIBUYENTE
    $.ajax({
      type: "POST",
      url: "ajax/viascalles.ajax.php",
      data: {idcoDireccion: idContribuyente},
      dataType: "json",
      success: function (respuesta) {
        console.log(respuesta);
        const tablaHTML = `
          <input type="hidden" id="idvia" name="idvia" value="${respuesta.Id_Ubica_Vias_Urbano}">
          <tr>
            <td style="text-align: center;">${respuesta.Codigo} ${respuesta.Nombre_Via}</td>
            <td style="text-align: center;">${respuesta.NumeroManzana}</td>
            <td style="text-align: center;">${respuesta.Numero_Cuadra}</td>
            <td style="text-align: center;">${respuesta.Lado}</td>
            <td style="text-align: center;">${respuesta.Nombre_Zona}</td>
            <td style="text-align: center;">${respuesta.Habilitacion_Urbana}</td>
           <td style="text-align: center;">${respuesta.Id_Ubica_Vias_Urbano}</td>
          </tr>`;
        $("#itemsRC").html(tablaHTML);
      },
    });
  }

  guardar_editar_contribuyente(datosFormulario){
    $.ajax({
      type: 'POST',
      url: 'ajax/contribuyente.ajax.php', // Cambia esto por la URL a la que envías los datos
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
const buscarcontribuyente_ = new buscarcontribuyente();
$(document).on("click", ".btnPredios", function () {
  let id = $(this).attr("idContribuyente_predio");
  var Coactivo= $(this).attr('estado_Coactivo'); //extraemos el valor del nombre de coactivo
  var nombrecompleto= $(this).attr('nombre_contribuyente'); //extraemos el valor del nombre de nombre_completo
  if (Coactivo === '1'){ //si esta en coativo manda un mensaje de avertencia
    const style = document.createElement("style");
    style.textContent = `.swal2-container{
                          z-index: 20000 !important;}`;
  document.head.appendChild(style);
  Swal.fire({
    icon:'warning',
    title:'Advertencia',
    text: 'Esta persona '+nombrecompleto+' esta en coactivo, comunicarce con el area responsable',
    confirmButtonText: 'Entendido'
  }).then((result) =>{ 
    if(result.isConfirmed){
      window.location = "index.php?ruta=listapredio&id=" + id+ "&anio=" + general.anio_valor;
    }
  });
  } else {
  window.location = "index.php?ruta=listapredio&id=" + id+ "&anio=" + general.anio_valor;
  }
});


$(document).on("click", ".btndeuda", function () {
  console.log("estado de duda")
  let datos = new FormData();
  buscarcontribuyente.idContribuyente = $(this).attr("idContribuyente_predio");
  var Coactivo= $(this).attr('estado_Coactivo'); //extraemos el valor del nombre de coactivo
  var nombrecompleto= $(this).attr('nombre_contribuyente'); //extraemos el valor del nombre de nombre_completo

  datos.append("id_contribuyente", buscarcontribuyente.idContribuyente);


  if (Coactivo === '1'){ //si esta en coativo manda un mensaje de avertencia
    const style = document.createElement("style");
    style.textContent = `.swal2-container{
                          z-index: 20000 !important;}`;
    document.head.appendChild(style);
    Swal.fire({
    icon:'warning',
    title:'Advertencia',
    text: 'Esta persona '+nombrecompleto+' esta en coactivo, comunicarce con el area responsable',
    confirmButtonText: 'Entendido'
    }).then((result) =>{ 
    if(result.isConfirmed){
      $("#modal_predio_propietario").modal("hide");
      $("#modalEstadoCuenta_notificacion").modal("show");
      
      
      datos.append("idContribuyente", idContribuyente);

    }
    });
  } else {
    $("#modal_predio_propietario").modal("hide");
    $("#modalEstadoCuenta_notificacion").modal("show");
    
  

  }
});



$(document).on("click", ".btnEditarcontribuyente", function () {

  buscarcontribuyente_.idContribuyente = $(this).attr("idContribuyente");
  buscarcontribuyente_.editarContribuyente(buscarcontribuyente_.idContribuyente);
  buscarcontribuyente_.traerDireccion(buscarcontribuyente_.idContribuyente);
});


$(document).on("click", ".btnEliminarContribuyente", function () {
  buscarcontribuyente_.eliminarcontribuyente();
});
$(document).on("click", "btnModalRegistrarCambios", function () {
  alert("REGISTRO CAMBIOS");
});

let perfilOculto_c = $("#perfilOculto_c").val();



function loadContribuyente(page, searchClass,init_envio) {
  console.log("loadContribuyente----------------");

    if (event.keyCode === 13) {
      



      buscarcontribuyente_.loadcontribuyente_filtro(page,searchClass,init_envio);
     
      event.preventDefault();
    }
}

//MODO MOBIL BUSQUEDA

function loadContribuyenteM(page, searchClass,init_envio) {
 // console.log("loadContribuyente-------MOBIL");


    if (event.keyCode === 13) {
      
      console.log("sehecr",searchClass);
      buscarcontribuyente_.loadcontribuyente_filtro_m(page,searchClass,init_envio);
      event.preventDefault();
    }
}

$('#formEmpresa').on('submit', function(event) {
  event.preventDefault();
    var datosFormulario = $(this).serialize(); // Serializa los datos del formulario

    let isChecked = $('#usuarioCoactivo').prop('checked');
    let value= isChecked ? $('#usuarioCoactivo').attr('check') : $('#usuarioCoactivo').attr('uncheck');//extraemoes el valor del estado del check coactivo
    datosFormulario += '&usuariocoactivo='+value;
 //USUARIO FALLECIDO
    let isCheckedf = $('#usuarioFallecida').prop('checked');
    let valuef= isCheckedf ? $('#usuarioFallecida').attr('check') : $('#usuarioFallecida').attr('uncheck');//extraemoes el valor del estado del check coactivo
    datosFormulario += '&usuariofallecida='+valuef;

    datosFormulario += '&guardar_editar_contribuyente=guardar_editar_contribuyente'; 
   
  
    console.log(datosFormulario); 
  buscarcontribuyente_.guardar_editar_contribuyente(datosFormulario);
})



// $(document).ready(function() {
//   // Obtener el valor del campo 'area_oculta'
//   var area = $('#mySpan_area').attr('iso_area');
  
//   console.log("El área es ahora desde modal: " + area);  // Verificar el valor del área

//   // Mostrar el div solo si el valor del área es "SUBGERENCIA DE SERVICIOS MUNICIPALES"
//   if (area === "SUBGERENCIA DE SERVICIOS MUNICIPALES") {
//     console.log("Mostrando el div");
//     $(".ocultar_predio").show();  // Mostrar el div
//   } else {
//     console.log("No se muestra el div");
//     $(".ocultar_predio").hide();  // Ocultar el div
//   }
// });


$('#btnTakePhoto').on('click', function() {
  $('#imageInput').click();
});
