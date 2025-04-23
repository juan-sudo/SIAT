// Agregar formula impuesto predial
$(document).on("click", "#btnRegFormula", function (e) {
  e.preventDefault();
  let datos = $("#frmRegFormula").serialize();
  let formd = new FormData($("#frmRegFormula")[0]);
  for (let pair of formd.entries()) {
    console.log(pair[0] + ", " + pair[1]);
  }
  /*$.ajax({
    type: "POST",
    url: "ajax/formulaimpuesto.ajax.php",
    data: (datos, formd),
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      $(".resultados").html(respuesta);
    },
  });*/
});
// EDITTAR FORMULA
$(document).on("click", ".btnEditarFormula", function () {
  var idUsuario = $(this).attr("idUsuario");
  ////(idUsuario);
  var datos = new FormData();
  datos.append("idUsuario", idUsuario);
  $.ajax({
    url: "ajax/formulaimpuesto.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#idf").val(respuesta["Id_Formula_Impuesto"]);
      $("#editar_anio").val(respuesta["Anio"]);
      $("#editar_uit").val(respuesta["UIT"]);
      $("#editar_codigo").val(respuesta["Codigo_Calculo"]);
      $("#editar_baseimponible").val(respuesta["Base_imponible"]);
      $("#editar_base").val(respuesta["Base"]);
      $("#editar_formulabase").val(respuesta["FormulaBase"]);
      $("#editar_porcentaje").val(respuesta["PorcBase"]);
      $("#editar_autovaluo").val(respuesta["Autovaluo"]);
    },
  });
});
// ACTIVAR CLASIFICADOR|
$(document).on("change", "#usuarioEstado", function () {
  let idUsuario = $(this).attr("idUsuario");
  if ($(this).is(":checked")) {
    estadoUsuario = 1;
  } else {
    estadoUsuario = 0;
  }

  let datos = {activarId: idUsuario, activarUsuario: estadoUsuario};

  $.ajax({
    url: "ajax/especievalorada.ajax.php",
    method: "POST",
    data: datos,
    success: function (respuesta) {
      if (window.matchMedia("(max-width:767px)").matches) {
      }
    },
  });
  if (estadoUsuario == 0) {
    $(this).removeClass("btn-success");
    $(this).addClass("btn-danger");
    $(this).html("desactivado");
    $(this).attr("estadoUsuario", 1);
  } else {
    $(this).removeClass("btn-danger");
    $(this).addClass("btn-success");
    $(this).html("Activado");
    $(this).attr("estadoUsuario", 0);
  }
});
// VALIDAR NO REPETIR USUARIO

$(document).on("change", "#nuevoUsuario", function () {
  $(".alert").remove();

  let usuario = $(this).val();
  let datos = new FormData();
  datos.append("validarUsuario", usuario);

  $.ajax({
    url: "ajax/usuarios.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      //    //("respuesta", respuesta);
      if (respuesta) {
        $("#nuevoUsuario").val("");
        $("#nuevoUsuario")
          .parent()
          .before(
            '<div class="alert alert-warning" style="display:none;">Este usuario ya existe!</div>'
          );
        $(".alert").show(500, function () {
          $(this).delay(3000).hide(500);
        });
      }
    },
  });
});
// ELIMINAR USUARIO
$(document).on("click", ".btnEliminarFormula", function () {
  let idUsuario = $(this).attr("idUsuario");
  let usuario = $(this).attr("usuario");

  Swal.fire({
    title: "¿Estás seguro de eliminar la formula de impuesto?",
    text: "¡Si no lo está puede  cancelar la acción!",
    //icono
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminarlo!",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = "index.php?ruta=formulaimpuesto&idUsuario=" + idUsuario;
      //   Swal.fire(
      //     'Deleted!',
      //     'Your file has been deleted.',
      //     'success'
      //   )
    }
  });
});
// BUSCAR DNI RENIEC

// SOLO INGRESAR NUMEROS CAMPO DNI
$("#nuevoDni").keyup(function () {
  var ruc = $(this).val();

  //this.value = (this.value + '').replace(/[^0-9]/g, '');
  if (!$.isNumeric(ruc)) {
    //dni = dni.substr(0,(dni.length -1));
    ruc = ruc.replace(/[^0-9]/g, "");
    $("#nuevoDni").val(ruc);
  }
});
