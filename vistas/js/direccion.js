
  $("#btnGuardarDireccion").on("click", function (e) {
      let formd = new FormData($("form.formRegistroDireccion")[0]);
      /*for (const pair of formd.entries()) {
        console.log(pair[0] + ", " + pair[1]);
      }*/
     $.ajax({
        type: "POST",
        url: "ajax/direccion.ajax.php",
        data: (formd),
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          $(".resultados").html(respuesta);
        },
      })
  });

$(document).on("click", ".btnEliminarDireccion", function () {
  let idDireccion = $(this).attr("idDireccion");
  let usuario = $(this).attr("usuario");
  Swal.fire({
    title: "¿Estás seguro de eliminar la Direccion?",
    text: "¡Si no lo está puede cancelar la acción!",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminarlo!",
  }).then((result) => {
    if (result.isConfirmed) {    
       window.location = `index.php?ruta=direccion&idDireccion=${idDireccion}&usuario=${usuario}`;
    }
  });
});

$(document).on("click", ".btnEditarDireccion", function () {
  let idDireccion = $(this).attr("idDireccion");
  let editar_direc =$("idDireccion").val();
  let datos = new FormData();
  datos.append("idDireccion", idDireccion);
  datos.append("editar_direc", editar_direc);
  $.ajax({
    url: "ajax/direccion.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#ide").val(respuesta["Id_Direccion"]);
      $("#nombreVia_edit").val(respuesta["Id_Nombre_Via"]);
      $("#tipoVia_edit").val(respuesta["Id_Tipo_Via"]);
      $("#zonaSel_edit").val(respuesta["Id_Zona"]);
    },
  });
});