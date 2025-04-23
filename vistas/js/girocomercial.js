// Agregar GIRO COMERCIAL 
$(".form-inserta").submit(function (e) {
  e.preventDefault();
  let datos = $(this).serialize();
  let formd = new FormData($("form.form-inserta")[0]);
  $.ajax({
    type: "POST",
    url: "ajax/girocomercial.ajax.php",
    data: (datos, formd),
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      $(".resultados").html(respuesta);
    },
  });
});

$(document).on("click", ".btnEditarGiroComercial", function () {
  var idGiro = $(this).attr("idGiro");
  ////(idUsuario);
  var datos = new FormData();
  datos.append("idGiro", idGiro);
  $.ajax({
    url: "ajax/girocomercial.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#ide").val(respuesta["Id_Giro_Comercial"]);
      $("#editar_nombreGiro").val(respuesta["Nombre"]);
    
    },
  });
});

// ACTIVAR DESACTIVAR ESTADO
$(document).on("change", "#usuarioEstado", function () {
  let idGiro = $(this).attr("idGiro");
  if ($(this).is(":checked")) {
    estadoUsuario = 1;
  } else {
    estadoUsuario = 0;
  }
  let datos = { activarId: idGiro, activarUsuario: estadoUsuario };
  $.ajax({
    url: "ajax/girocomercial.ajax.php",
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

// ELIMINAR GIRO COMERCIAL
$(document).on("click", ".btnEliminarGiroComercial", function () {
  let idGiro = $(this).attr("idGiro");
  let usuario = $(this).attr("usuario");
  Swal.fire({
    title: "¿Seguro seguro de eliminar el giro comercial?",
    text: "¡Si no lo está puede  cancelar la acción!",
    //icono
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminarlo!",
  }).then((result) => {
      if (result.isConfirmed) {    
       window.location = `index.php?ruta=girocomercial&idGiro=${idGiro}&usuario=${usuario}`;
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