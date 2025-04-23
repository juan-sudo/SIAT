
class Campaña {
  constructor() {
   this.iddescuento=null;
  }
  confirmar_campaña(){
    
    let estadoUsuario;   
          estadoUsuario = 1;
    let datos = {activarId: this.iddescuento,
                activarUsuario: estadoUsuario,
                activar_descuento:"activar_descuento"};
   console.log(datos);                
          $.ajax({
            url: "ajax/campana.ajax.php",
            method: "POST",
            data: datos,
            beforeSend: function() {
              $(".cargando").html(loadingMessage_s);
              $("#modal_cargar").modal("show");
            },
            success: function (respuesta) {
              $("#modal_cargar").modal("hide");
             
                $("#respuestaAjax_srm").show();
                $("#respuestaAjax_srm").html(respuesta.mensaje);
                setTimeout(function () {
                  $("#respuestaAjax_srm").hide();
                }, 10000);
                $("#modal_confirmar_descuento").modal("hide");
            },
            error: function() {
              $("#modal_cargar").text("Error al cargar el archivo.");
          }
          });
  }
}

const campaña = new Campaña();


$(document).ready(function () {
  $("#campaniaGeneral").hide();
  $("#camapiaPorUso").hide();
  $("#edit_campaniaGeneral").hide();
  $("#edit_camapiaPorUso").hide();
  $(document).on("change", "#tipoCampana", function () {
    if ($(this).val() === "1") {
      $("#campaniaGeneral").show();
      //  $("#campaniaTim").hide();
      $("#camapiaPorUso").hide();
    } else if ($(this).val() === "2") {
      $("#campaniaGeneral").show();
      //$("#campaniaTim").show();
      $("#camapiaPorUso").hide();
    } else {
      $("#campaniaGeneral").show();
      //  $("#campaniaTim").hide();
      $("#camapiaPorUso").show();
    }
  });
  $(document).on("change", "#edit_tipoCampana", function () {
    if ($("#edit_tipoCampana").val() === "1") {
      $("#edit_campaniaGeneral").show();
      $("#edit_camapiaPorUso").hide();
    } else if ($("#edit_tipoCampana").val() === "2") {
      $("#edit_campaniaGeneral").show();
      $("#edit_camapiaPorUso").hide();
    } else {
      $("#edit_camapiaPorUso").show();
      //  $("#campaniaTim").hide();
      $("#edit_campaniaGeneral").show();
    }
  });
  $(document).on("click", "#btnRegistrarCampana", function (e) {
    e.preventDefault();
    let formd = new FormData($("#formCampana")[0]);
    formd.append("registrarCampana", "true");

    $.ajax({
      type: "POST",
      url: "ajax/campana.ajax.php",
      data: formd,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        $(".resultados").html(respuesta);
      },
    });
  });
  $(document).on("click", ".btnEliminarCampana", function () {
    let idUsuario = $(this).attr("idUsuario");
    let usuario = $(this).attr("usuario");
    Swal.fire({
      title: "¿Estás seguro de eliminar la campaña tributaria?",
      text: "¡Si no lo está puede  cancelar la acción!",
      //icono
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminarlo!",
    }).then((result) => {
      if (result.isConfirmed) {
        window.location =
          "index.php?ruta=campana&idUsuario=" +
          idUsuario +
          "&usuario=" +
          usuario;
      }
    });
  });
  $(document).on("click", ".btnEditarCampana", function () {
    let idEspecie = $(this).attr("idEspecie");
    let datos = new FormData();
    datos.append("idDescuento", idEspecie);
    $.ajax({
      url: "ajax/campana.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        $("#idEsp").val(respuesta["Id_Descuento"]);
        $("#edit_nombreCampana").val(respuesta["descripcion_descuento"]);
        $("#edit_anioCampana").val(respuesta["Id_Anio"]);
        $("#edit_fechaIniCampana").val(respuesta["Fecha_Inicio"]);
        $("#edit_fechaFinCampana").val(respuesta["Fecha_Fin"]);
        $("#edit_tipoCampana").val(respuesta["tipo_descuento"]);
        $("#edit_numInstrumentoCampana").val(respuesta["Documento"]);
        $("#edit_porcentajeDescuentoG").val(respuesta["Porcentaje"]);
        $("#edit_usoPredioCampana").val(respuesta["Id_Uso_Predio"]);
        MostrarTipoCampana();
      },
    });
  });

  function MostrarTipoCampana() {
    if ($("#edit_tipoCampana").val() === "1") {
      $("#edit_campaniaGeneral").show();
      $("#edit_camapiaPorUso").hide();
    } else if ($("#edit_tipoCampana").val() === "2") {
      $("#edit_campaniaGeneral").show();
      $("#edit_camapiaPorUso").hide();
    } else {
      $("#edit_camapiaPorUso").show();
      //  $("#campaniaTim").hide();
      $("#edit_campaniaGeneral").show();
    }
  }
});

$(document).on("change", "#descuentoEstado", function () {
  if ($(this).is(':checked')) {
    $("#modal_confirmar_descuento").modal("show");
    campaña.iddescuento = $(this).attr("iddescuento");
    }
});
$(document).on("click", ".no_aplicar_descuento", function () {
  $('#descuentoEstado').prop('checked', false).change();
});
$(document).on("click", ".aplicar_descuento", function () {
  campaña.confirmar_campaña();
});