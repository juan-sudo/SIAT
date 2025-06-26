
// function cerrarSession() {
//   let datos = { cerrarS: "cerrarS" };
//   $.ajax({
//     url: "ajax/usuarios.ajax.php",
//     method: "POST",
//     data: datos,
//     beforeSend: function () {},
//     success: function (respuesta) {
//       if (respuesta == "ok") {
//         window.location = "salir";
//       }
//     },
//   });
// }


// $("#logUser").click(function(e) {
//     e.preventDefault();
//     var ingUsuario = $("#ingUsuario").val();
//     var ingPassword = $("#ingPassword").val();
//     console.log(ingUsuario, ingPassword);

//     Validar que los campos no estén vacíos LADO CLIENTE
//     if (ingUsuario.trim() === "" || ingPassword.trim() === "") {
//         alert("Por favor ingrese usuario y contraseña.");
//         return;
//     }

//     Verificar si hay conexión a internet
//     if (navigator.onLine) {
//         Si hay conexión a internet, verificamos el reCAPTCHA
//         var recaptchaResponse = grecaptcha.getResponse(); // Obtener la respuesta de reCAPTCHA

//         Verificar si se completó el reCAPTCHA
//         if (recaptchaResponse.length == 0) {
//             alert("Por favor, verifica que no eres un robot.");
//             return;
//         }
//     } else {
//         Si no hay conexión a internet, omite el reCAPTCHA
//         alert("No hay conexión a Internet. Se omitirá la validación del reCAPTCHA.");
//     }

//     let datos = {
//         ingUsuario: ingUsuario,
//         ingPassword: ingPassword,
//         'g-recaptcha-response': (navigator.onLine) ? recaptchaResponse : '' // Si hay conexión, agregar la respuesta del reCAPTCHA
//     };

//     $.ajax({
//         url: "ajax/usuarios.ajax.php",
//         method: "POST",
//         data: datos,
//         beforeSend: function () {},
//         success: function (respuesta) {
//             $("#resultLogin")
//                 .html(respuesta)
//                 .show(500, function () {
//                     $(this).delay(3000).hide(500);
//                 });
//         },
//     });
// });




// $(document).ready(function() {
//     // Verifica si hay conexión a internet
//     if (!navigator.onLine) {
//         // Si no hay conexión, oculta el reCAPTCHA
//         $('#recaptcha-container').addClass('hidden');
//     }

//     // Manejo del inicio de sesión con AJAX
//     $("#logUser").click(function(e) {
//         e.preventDefault();
//         var ingUsuario = $("#ingUsuario").val();
//         var ingPassword = $("#ingPassword").val();
//         console.log(ingUsuario, ingPassword);

//         // Validar que los campos no estén vacíos LADO CLIENTE
//         if (ingUsuario.trim() === "" || ingPassword.trim() === "") {
//             alert("Por favor ingrese usuario y contraseña.");
//             return;
//         }

//         // Si el reCAPTCHA está visible y hay conexión, verifica la respuesta
//         if (!navigator.onLine || grecaptcha.getResponse().length == 0) {
//             alert("Por favor, verifica que no eres un robot.");
//             return;
//         }

//         var recaptchaResponse = grecaptcha.getResponse(); // Obtener la respuesta de reCAPTCHA

//         let datos = {
//             ingUsuario: ingUsuario,
//             ingPassword: ingPassword,
//             'g-recaptcha-response': recaptchaResponse // Agregar la respuesta de reCAPTCHA aquí
//         };

//         $.ajax({
//             url: "ajax/usuarios.ajax.php",
//             method: "POST",
//             data: datos,
//             beforeSend: function () {},
//             success: function (respuesta) {
//                 $("#resultLogin")
//                     .html(respuesta)
//                     .show(500, function () {
//                         $(this).delay(3000).hide(500);
//                     });
//             },
//         });
//     });
// });



// $("#logUser").click(function(e) {
//     e.preventDefault();
//     var ingUsuario = $("#ingUsuario").val();
//     var ingPassword = $("#ingPassword").val();
//     console.log(ingUsuario, ingPassword);

//     // Validar que los campos no estén vacíos LADO CLIENTE
//     if (ingUsuario.trim() === "" || ingPassword.trim() === "") {
//         alert("Por favor ingrese usuario y contraseña.");
//         return;
//     }

//     var recaptchaResponse = grecaptcha.getResponse(); // Obtener la respuesta de reCAPTCHA

//     // Verificar si se completó el reCAPTCHA
//     if (recaptchaResponse.length == 0) {
//         alert("Por favor, verifica que no eres un robot.");
//         return;
//     }

//     let datos = {
//         ingUsuario: ingUsuario,
//         ingPassword: ingPassword,
//         'g-recaptcha-response': recaptchaResponse // Agregar la respuesta de reCAPTCHA aquí
//     };

//     $.ajax({
//         url: "ajax/usuarios.ajax.php",
//         method: "POST",
//         data: datos,
//         beforeSend: function () {},
//         success: function (respuesta) {
//             $("#resultLogin")
//                 .html(respuesta)
//                 .show(500, function () {
//                     $(this).delay(3000).hide(500);
//                 });
//         },
//     });
// });






//LOGIN USUARIOS
$("#logUser").click(function(e) {
  e.preventDefault();
    var ingUsuario = $("#ingUsuario").val();
    var ingPassword = $("#ingPassword").val();
    console.log(ingUsuario,ingPassword);

    // Validar que los campos no estén vacíos LADO CLIENTE
    if(ingUsuario.trim() === "" || ingPassword.trim() === "") {
        alert("Por favor ingrese usuario y contraseña.");
        return;
    }

    let datos = {
      ingUsuario: ingUsuario,
      ingPassword: ingPassword,
    };

    $.ajax({
      url: "ajax/usuarios.ajax.php",
      method: "POST",
      data: datos,
      beforeSend: function () {},
      success: function (respuesta) {
        //(respuesta);
        $("#resultLogin")
          .html(respuesta)
          .show(500, function () {
            $(this).delay(3000).hide(500);
          });
      },
    });
  
});



// SUBIENDO LA FOTO DEL USUARIO
$(".nuevaFoto").change(function () {
  let imagen = this.files[0];

  if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
    $(".nuevaFoto").val("");
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "La imagen debe ser jpeg o png!",
      //footer: '<a href>Why do I have this issue?</a>'
    });
  } else if (imagen["size"] > 2000000) {
    $(".nuevaFoto").val("");
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "La imagen no debe pesar más de 2mb!",
      //footer: '<a href>Why do I have this issue?</a>'
    });
  } else {
    let datosImagen = new FileReader();
    datosImagen.readAsDataURL(imagen);
    $(datosImagen).on("load", function (event) {
      let rutaImagen = event.target.result;
      $(".previsualizar").attr("src", rutaImagen);
    });
  }
});


// EDITTAR USUARIO
$(document).on("click", ".btnEditarUsuario", function () {
  var idUsuario = $(this).attr("idUsuario");
  ////(idUsuario);
  var datos = new FormData();
  datos.append("idUsuario_selet", idUsuario);
  datos.append("idUsuario_seleccionado", "idUsuario_seleccionado");
  $.ajax({
    url: "ajax/usuarios.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#editarNombre").val(respuesta["nombre"]);
      $("#editarUsuario").val(respuesta["usuario"]);
      $("#editarPerfil").html(respuesta["perfil"]);
      $("#editarPerfil").val(respuesta["perfil"]);
      $("#editarDni").val(respuesta["dni"]);
      $("#editarEmail").val(respuesta["email"]);
      $("#passwordActual").val(respuesta["password"]);
      $("#id_area_e").val(respuesta["Id_Area"]);      
    },
  });
});



// ACTIVAR USUARIO|
$(document).on("change", "#usuarioEstado", function () {
  let idUsuario = $(this).attr("idUsuario");
  if ($(this).is(":checked")) {
    estadoUsuario = 1;
  } else {
    estadoUsuario = 0;
  }

  let datos = { activarId: idUsuario, activarUsuario: estadoUsuario };

  $.ajax({
    url: "ajax/usuarios.ajax.php",
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
$(document).on("click", ".btnEliminarUsuario", function () {
  let idUsuario = $(this).attr("idUsuario");
  let fotoUsuario = $(this).attr("fotoUsuario");
  let usuario = $(this).attr("usuario");

  Swal.fire({
    title: "¿Estás seguro de eliminar este usuario?",
    text: "¡Si no lo está puede  cancelar la acción!",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminarlo!",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location =
        "index.php?ruta=usuarios&idUsuario=" +
        idUsuario +
        "&usuario=" +
        usuario +
        "&fotoUsuario=" +
        fotoUsuario;
      //   Swal.fire(
      //     'Deleted!',
      //     'Your file has been deleted.',
      //     'success'
      //   )
    }
  });
});
// BUSCAR DNI RENIEC
$(".form-inserta").on("change", "#nuevoDni", function (e) {
  e.preventDefault();
  let dni = $(this).val();
  let datos = { dni: dni };
  $.ajax({
    method: "POST",
    url: "ajax/usuarios.ajax.php",
    data: datos,
    dataType: "json",
    success: function (respuesta) {
      $("#nuevoDni").val(respuesta["dni"]);
      $("#nuevoNombre").val(respuesta["nombre"]);
    },
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


class Usuario {
  constructor() {
    this.idusuario_sesion=0;
  }
  lista_usuarios(){
    let datos = new FormData();
    datos.append("id_usuario",usuario.idusuario_sesion);
    datos.append("lista_usuarios","lista_usuarios");
    $.ajax({
      url: "ajax/usuarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        document.getElementById('lista_de_usuarioss').innerHTML = respuesta;
      }
    })
  }
  guardar_usuario_editado(){
         
        let datos = $(this).serialize();
        let formd = new FormData($("form.form-inserta-editar")[0]);
        formd.append("guardar_datos_editar","guardar_datos_editar");
        for (let entry of formd.entries()) {
          console.log(entry[0] + ': ' + entry[1]);
      }
        $.ajax({
          type: "POST",
          url: "ajax/usuarios.ajax.php",
          data: (datos, formd),
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            if (respuesta.tipo === "correcto") {
              $("#modalEditarUsuario").modal("hide");
              $("#respuestaAjax_srm").show();
              $("#respuestaAjax_srm").html(respuesta.mensaje);
              usuario.lista_usuarios();
              setTimeout(function () {
                $("#respuestaAjax_srm").hide();
              }, 5000);
              
            }
            else{
              $("#respuestaAjax_srm").show();
              $("#respuestaAjax_srm").html(respuesta.mensaje);
              setTimeout(function () {
                $("#respuestaAjax_srm").hide();
              }, 4000);
            }
          },
        });
  }
  
  agregar_usuario(){
    let datos = $(this).serialize();
    let formd = new FormData($("form.form-inserta")[0]);
    $.ajax({
      type: "POST",
      url: "ajax/usuarios.ajax.php",
      data: (datos, formd),
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        if (respuesta.tipo === "correcto") {
          $("#modalAgregarUsuario").modal("hide");
          $("#respuestaAjax_srm").show();
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          usuario.lista_usuarios();
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 5000);
          
        }
        else{
          $("#respuestaAjax_srm").show();
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 4000);
        }
      },
    });
  }
}
const usuario= new Usuario();
document.addEventListener('DOMContentLoaded', function () {
  
  usuario.idusuario_sesion = document.querySelector('span[iso]').getAttribute('iso');
  usuario.lista_usuarios();
  console.log('Valor del atributo iso:', usuario.idusuario_sesion);

})
$(".form-inserta-editar").submit(function (e) {
    e.preventDefault();
    usuario.guardar_usuario_editado();
});

// Agregar USUARIO
$(".form-inserta").submit(function (e) {
    e.preventDefault();
    usuario.agregar_usuario();
});