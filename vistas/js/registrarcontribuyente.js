// AGREGADO CONTRIBUYENTE VALIDADO

const frmRegContribuyente = document.getElementById("formRegContribuyente");
$(document).ready(function () {
  let tipoDoc;
  document.getElementById("tipoDoc").addEventListener("change", function () {
    tipoDoc = this.value;
    let apellPaterno = document.getElementById("apellPaterno");
    let apellMaterno = document.getElementById("apellMaterno");
    let numDocumento = document.getElementById("docIdentidad");
    numDocumento.disabled = true;

    if (tipoDoc === "4") {
      apellPaterno.disabled = true;
      apellMaterno.disabled = true;
      numDocumento.disabled = false;
      apellPaterno.style.backgroundColor = "lightgray";
      apellMaterno.style.backgroundColor = "lightgray";
      numDocumento.style.backgroundColor = "#FFF";
      numDocumento.maxLength = 11;
      numDocumento.value = "";
    } else if (tipoDoc === "2") {
      apellPaterno.disabled = false;
      apellMaterno.disabled = false;
      numDocumento.disabled = false;
      numDocumento.value = "";
      apellPaterno.style.backgroundColor = "#FFF";
      apellMaterno.style.backgroundColor = "#FFF";
      numDocumento.style.backgroundColor = "#FFF";
      numDocumento.maxLength = 8;
    } else if (tipoDoc === "1") {
      apellPaterno.disabled = false;
      apellMaterno.disabled = false;
      apellPaterno.style.backgroundColor = "#FFF";
      apellMaterno.style.backgroundColor = "#FFF";
      numDocumento.style.backgroundColor = "lightgray";
      numDocumento.value = "-";
    } else {
      numDocumento.disabled = false;
      numDocumento.value = "";
      apellPaterno.disabled = false;
      apellMaterno.disabled = false;
    }
  });
  $(document).on("click", "#btnRegistrarContribuyente", function () {
    const datos = {
      Tipo_Documento: frmRegContribuyente.tipoDoc.value.trim().toUpperCase(),
      Documento_Identidad: frmRegContribuyente.docIdentidad.value.trim().toUpperCase(),
      Razon_social: frmRegContribuyente.razon_social.value.trim().toUpperCase(),
      Apellido_Paterno: frmRegContribuyente.apellPaterno.value.trim().toUpperCase(),
      Apellido_Materno: frmRegContribuyente.apellMaterno.value.trim().toUpperCase(),
      Condicion_Contri: frmRegContribuyente.condicionContri.value.trim().toUpperCase(),
    
      Tipo_Contribuyente: frmRegContribuyente.tipoContribuyente.value.trim().toUpperCase(),
      Condicion_Predio: frmRegContribuyente.condicionpredio.value.trim().toUpperCase(),
      Clasificacion: frmRegContribuyente.clasificacion.value.trim().toUpperCase(),
     
    };
    const datos2 = {
      Tipo_Documento: frmRegContribuyente.tipoDoc.value.trim().toUpperCase(),
      Documento_Identidad: frmRegContribuyente.docIdentidad.value.trim().toUpperCase(),
      Razon_social: frmRegContribuyente.razon_social.value.trim().toUpperCase(),
      Condicion_Contri: frmRegContribuyente.condicionContri.value.trim().toUpperCase(),
      Tipo_Contribuyente: frmRegContribuyente.tipoContribuyente.value.trim().toUpperCase(),
      Condicion_Predio: frmRegContribuyente.condicionpredio.value.trim().toUpperCase(),
      Clasificacion: frmRegContribuyente.clasificacion.value.trim().toUpperCase(),
    };

    let campoFaltante = null;
    if (tipoDoc === "2") {
      for (const campo in datos) {
        if (datos[campo] === "") {
          campoFaltante = campo;
          break;
        }
      }
      const mensaje = "Por favor, complete el campo: " + campoFaltante;
      var html_respuesta = `<div class="col-sm-12">
                      <div class="alert alert-warning">
                      <button type="button" class="close font__size-18" data-dismiss="alert">
                      </button>
                      <i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
                      <strong class="font__weight-semibold">¡Alerta!</strong> ${mensaje}
                      </div>
                    </div>`;
    } else if (tipoDoc === "4") {
      for (const campo in datos2) {
        if (datos[campo] === "") {
          campoFaltante = campo;
          break;
        }
      }
      const mensaje = "Por favor, complete el campo: " + campoFaltante;
      var html_respuesta = `<div class="col-sm-12">
                      <div class="alert alert-warning">
                      <button type="button" class="close font__size-18" data-dismiss="alert">
                      </button>
                      <i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
                      <strong class="font__weight-semibold">¡Alerta!</strong> ${mensaje}
                      </div>
                    </div>`;
    } else {
      for (const campo in datos) {
        if (datos[campo] === "") {
          campoFaltante = campo;
          break;
        }
      }
      const mensaje = "Por favor, complete el campo: " + campoFaltante;
      var html_respuesta = `<div class="col-sm-12">
                      <div class="alert alert-warning">
                      <button type="button" class="close font__size-18" data-dismiss="alert">
                      </button>
                      <i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
                      <strong class="font__weight-semibold">¡Alerta!</strong> ${mensaje}
                      </div>
                    </div>`;
    }

    if (campoFaltante !== null) {
      $("#respuestaAjax_srm").show();
      $("#respuestaAjax_srm").html(html_respuesta);
      setTimeout(function () {
        $("#respuestaAjax_srm").hide();
      }, 5000);
    } else {
       
        let formd = new FormData();
       // $("#idViaurbano").prop("disabled", false);
        formd.append("docIdentidad", $("#docIdentidad").val());
        formd.append("razon_social", $("#razon_social").val().toUpperCase());
        formd.append("apellPaterno", $("#apellPaterno").val().toUpperCase());
        formd.append("apellMaterno", $("#apellMaterno").val().toUpperCase());
        formd.append("condicionContri", $("#condicionContri").val());
        formd.append("idvia",$("#idvia").val());
        formd.append("nroUbicacion", $("#nroUbicacion").val());
        formd.append("nrobloque", $("#nrobloque").val());
        formd.append("nroDepartamento", $("#nroDepartamento").val());
        formd.append("referencia", $("#referencia").val().toUpperCase());
        formd.append("telefono", $("#telefono").val());
        formd.append("correo", $("#correo").val().toUpperCase());
        formd.append("observacion", $("#observacion").val().toUpperCase());
        formd.append("codigo_sa", $("#codigo_sa").val());
        formd.append("tipoContribuyente", $("#tipoContribuyente").val());
        formd.append("condicionpredio", $("#condicionpredio").val());
        formd.append("clasificacion", $("#clasificacion").val());
        formd.append("nroLuz", $("#nroLuz").val());
        formd.append("nroLote", $("#nroLote").val());
        formd.append("tipoDoc", $("#tipoDoc").val());
        formd.append("registrarContri", "true");

        console.log(formd);

        $.ajax({
          type: "POST",
          url: "ajax/contribuyente.ajax.php",
          data: formd,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            console.log("Respuesta del servidor:", respuesta,typeof respuesta);
            // Si respuesta ya es un booleano, lo usamos directamente
            if (respuesta ==="OK") {
                general.mostrarAlerta("success", "Registro de contribuyente", "Los datos se enviaron correctamente", { limpiarFormulario: "formRegContribuyente" });
                $("#itemsRC").empty(); 
              } else {
                general.mostrarAlerta("error", "Error", "El DNI ya se encuentra registrado.");
            }
        },
        });
    
    }
  });
});

// EDITTAR GIRO COMERCIAL
$(document).on("click", ".btnEditarGiroComercial", function () {
  var idUsuario = $(this).attr("idUsuario");
  ////(idUsuario);
  var datos = new FormData();
  datos.append("idUsuario", idUsuario);
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
$(document).on("click", ".btnEliminarGiroComercialfff", function () {
  let idUsuario = $(this).attr("idUsuario");
  let usuario = $(this).attr("usuario");
  Swal.fire({
    title: "¿Estás seguro de eliminar el giro comercial?",
    text: "¡Si no lo está puede  cancelar la acción!",
    //icono
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminarlo!",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location =
        "index.php?ruta=girocomercial&idUsuario=" +
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

$("#docIdentidad").keyup(function () {
  var ruc = $(this).val();
  //this.value = (this.value + '').replace(/[^0-9]/g, '');
  if (!$.isNumeric(ruc)) {
    //dni = dni.substr(0,(dni.length -1));
    ruc = ruc.replace(/[^0-9]/g, "");
    $("#docIdentidad").val(ruc);
  }
});
$("#telefono").keyup(function () {
  var ruc = $(this).val();
  //this.value = (this.value + '').replace(/[^0-9]/g, '');
  if (!$.isNumeric(ruc)) {
    //dni = dni.substr(0,(dni.length -1));
    ruc = ruc.replace(/[^0-9]/g, "");
    $("#telefono").val(ruc);
  }
});
/*$("#nroLote").keyup(function () {
  var ruc = $(this).val();
  //this.value = (this.value + '').replace(/[^0-9]/g, '');
  if (!$.isNumeric(ruc)) {
    //dni = dni.substr(0,(dni.length -1));
    ruc = ruc.replace(/[^0-9]/g, "");
    $("#nroLote").val(ruc);
  }
});*/
$("#nrobloque").keyup(function () {
  var ruc = $(this).val();
  //this.value = (this.value + '').replace(/[^0-9]/g, '');
  if (!$.isNumeric(ruc)) {
    //dni = dni.substr(0,(dni.length -1));
    ruc = ruc.replace(/[^0-9]/g, "");
    $("#nrobloque").val(ruc);
  }
});
$("#nroDepartamento").keyup(function () {
  var ruc = $(this).val();
  //this.value = (this.value + '').replace(/[^0-9]/g, '');
  if (!$.isNumeric(ruc)) {
    //dni = dni.substr(0,(dni.length -1));
    ruc = ruc.replace(/[^0-9]/g, "");
    $("#nroDepartamento").val(ruc);
  }
});

//AutoCompletado
document.getElementById("codigo_sa").addEventListener("change", function() {
    let valor = this.value.trim();
    if(/^\d+$/.test(valor)) {
        let ceros = 6 - valor.length;
        if (ceros > 0) {
            this.value = "0".repeat(ceros) + valor;
        } else {
            this.value = valor.slice(0, 6);
        }
    } else {
        this.value = valor.slice(0, -1);
    }
});