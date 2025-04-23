// Agregar TIM
$(".form-inserta").submit(function (e) {
  e.preventDefault();
  let datos = $(this).serialize();
  let formd = new FormData($("form.form-inserta")[0]);
  /*for (let pair of formd.entries()) {
    console.log(pair[0] + ", " + pair[1]);
  }*/
  $.ajax({
    type: "POST",
    url: "ajax/tim.ajax.php",
    data: (datos, formd),
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      $(".resultados").html(respuesta);
    },
  });
});
// EDITTAR TIM
$(document).on("click", ".btnEditarTim", function () {
  var idUsuario = $(this).attr("idUsuario");
  var datos = new FormData();
  datos.append("idUsuario", idUsuario);
  $.ajax({
    url: "ajax/tim.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#ide").val(respuesta["Id_TIM"]);
      $("#editar_anio").val(respuesta["Anio"]);
      $("#editar_tim").val(respuesta["Porcentaje"]);
    },
  });
});
// ACTIVAR DESACTIVAR ESTADO
$(document).on("change", "#usuarioEstado", function () {
  let idUsuario = $(this).attr("idUsuario");
  if ($(this).is(":checked")) {
    estadoUsuario = 1;
  } else {
    estadoUsuario = 0;
  }

  let datos = {activarId: idUsuario, activarUsuario: estadoUsuario};

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
// ELIMINAR
$(document).on("click", ".btnEliminarTim", function () {
  let idUsuario = $(this).attr("idUsuario");
  let usuario = $(this).attr("usuario");

  Swal.fire({
    title: "¿Estás seguro de eliminar la Tasa",
    text: "¡Si no lo está puede  cancelar la acción!",
    //icono
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminarlo!",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location =
        "index.php?ruta=tasaInteresMoratorio&idUsuario=" +
        idUsuario +
        "&usuario=" +
        usuario;
    }
  });
});

$(document).on("click", ".btnEditarTim", function () {
  var idUsuario = $(this).attr("idUsuario");
  var datos = new FormData();
  datos.append("idUsuario", idUsuario);
  $.ajax({
    url: "ajax/tim.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#ide").val(respuesta["Id_TIM"]);
      $("#editar_anio").val(respuesta["Anio"]);
      $("#editar_tim").val(respuesta["Porcentaje"]);
    },
  });
});

// $(document).on("change", "#anioFiscalTim", function () {
//   let elemento = document.getElementById("p_img");
//   let idcontribuyente_tim = elemento.getAttribute("idcontribuyente_tim");
//   // console.log("El valor de idcontribuyente_tim es:", idcontribuyente_tim);
//   let datos = new FormData();
//   datos.append("idContribuyente_idc",idcontribuyente_tim);
//   datos.append("estadoCuentaTim", "estadoCuentaTim");

//   const cuerpoTabla = document.getElementById("tbEstadoCuentaContribuyente");
//   const filas = cuerpoTabla.getElementsByTagName("tr");
//   while (filas.length > 0) {
//     cuerpoTabla.deleteRow(0); // Elimina la primera fila de la tabla
//   }

//   console.log(idcontribuyente_tim);
//  $.ajax({
//     url: "ajax/tim.ajax.php",
//     method: "POST",
//     data: datos,
//     cache: false,
//     contentType: false,
//     processData: false,
//     success: function (respuesta) {
//       console.log(respuesta);
//     },
//   });

// });
