// Agregar USUARIO

$(document).on("click", "#btnRegistrarEspecie", function (e) {
  e.preventDefault();
  let datos = $(this).serialize();
  let formd = new FormData($("form.form-inserta2")[0]);
  $.ajax({
    type: "POST",
    url: "ajax/especievalorada.ajax.php",
    data: (datos, formd),
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      $(".resultados").html(respuesta);
    },
  });
});
// EDITTAR CLASIFICADOR
$(document).on("click", ".btnEditarEspecie", function () {
  let idEspecie = $(this).attr("idEspecie");
  let datos = new FormData();
  datos.append("idEspecie", idEspecie);
  $.ajax({
    url: "ajax/especievalorada.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta);
      $("#idEsp").val(respuesta[0][0]);
      $("#monto_especieEdit").val(respuesta[0][1]);
      $("#id_areaEdit").val(respuesta[0][3]);
      $("#id_presupuestoEdit").val(respuesta[0][4]);
      $("#nombre_especieEdit").val(respuesta[0][5]);
      $("#detalle_instrumentoEdit").val(respuesta[0][6]);
      $("#id_instrumentoEdit").val(respuesta[0][7]);
      $("#numPaginaEdit").val(respuesta[0][8]);
      $("#requisitosEdit").val(respuesta[0][9]);
    },
  });
});

// MOSTRAR REQUISITOS

$(document).on("click", ".btnRequisitos", function () {
  let idEspecie = $(this).attr("idEspecie");
  let datos = new FormData();
  datos.append("idEspecie", idEspecie);
  $.ajax({
    url: "ajax/especievalorada.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta);
      $("#idEsp").val(respuesta[0][0]);
      $("#requisitosV").val(respuesta[0][9]);
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
$(document).on("click", ".btnEliminarEspecie", function () {
  let idUsuario = $(this).attr("idUsuario");
  let usuario = $(this).attr("usuario");

  Swal.fire({
    title: "¿Estás seguro de eliminar la especie valorada?",
    text: "¡Si no lo está puede  cancelar la acción!",
    //icono
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminarlo!",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location =
        "index.php?ruta=especiesvaloradas&idUsuario=" +
        idUsuario +
        "&usuario=" +
        usuario;
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
