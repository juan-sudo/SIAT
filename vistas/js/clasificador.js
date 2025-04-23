$(".form-inserta").submit(function (e) {
  e.preventDefault();
  let datos = $(this).serialize();
  let formd = new FormData($("form.form-inserta")[0]);
  $.ajax({
    type: "POST",
    url: "ajax/clasificador.ajax.php",
    data: (datos, formd),
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      $(".resultados").html(respuesta);
    },
  });
});
$(document).on("click", ".btnEditarClasificador", function () {
  var idUsuario = $(this).attr("idUsuario");
  var datos = new FormData();
  datos.append("idUsuario", idUsuario);
  $.ajax({
    url: "ajax/clasificador.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#idp").val(respuesta["Id_Presupuesto"]);
      $("#editarCodigoCla").val(respuesta["Codigo"]);
      $("#editarNombreCla").val(respuesta["Descripcion"]);
      $("#editarFinanciamiento").val(respuesta["Id_financiamiento"]); 
    },
  });
});
$(document).on("change", "#usuarioEstado", function () {
  let idUsuario = $(this).attr("idUsuario");
  if ($(this).is(":checked")) {
    estadoUsuario = 1;
  } else {
    estadoUsuario = 0;
  }
  let datos = { activarId: idUsuario, activarUsuario: estadoUsuario };
  $.ajax({
    url: "ajax/clasificador.ajax.php",
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
$(document).on("click", ".btnEliminarCladificador", function () {
  let idClasificador = $(this).attr("idUsuario");
  let usuario = $(this).attr("usuario");
  Swal.fire({
    title: "¿Estás seguro de eliminar este clasificador?",
    text: "¡Si no lo está puede  cancelar la acción!",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminarlo!",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location =
        "index.php?ruta=clasificadorMef&idClasificador=" +
        idClasificador +
        "&usuario=" +
        usuario;
    }
  });
});