class Predio {
  constructor() {
    this.predioSeleccionado = null;
    this.id_predio = null;
    this.Propietarios = [];
    this.fecha_predio = null;
    this.anio_predio = null;
    this.nom_anio_predio = null;
    this.respuesta_anio = null;
    this.anio_copear = null;
    this.id_catastro_p = null;
    this.id_tipo = null;
    this.id_propietario=null;
    this.carpeta=null;
  }
  click_predio() {
    var self = this;
    var tabla = document.getElementById("tablalistapredios");
    var tbody = tabla.querySelector("tbody");
    var filas = tbody.getElementsByTagName("tr");
    for (let i = 0; i < filas.length; i++) {
      filas[i].addEventListener("click", function () {
        self.anio_predio = $("#selectnum").val();
        
        console.log("id del anio:" + self.anio_predio);
     


        const filasTbody = tbody.getElementsByTagName("tr");
        self.id_predio = $(this).attr("id_predio");
        self.id_catastro_p = $(this).attr("id_catastro");
        self.id_tipo = $(this).attr("id_tipo");
        console.log("id del predio:" + self.id_predio);
        var selectElement = document.getElementById("selectnum");
        self.nom_anio_predio =selectElement.options[selectElement.selectedIndex].text;
        console.log("año seleccionado sin chambiar año:" + self.nom_anio_predio);
        self.anio_copear=parseInt(self.nom_anio_predio)+1;
        console.log("id del copear:" + self.anio_copear);
        for (let j = 0; j < filasTbody.length; j++) {
          filasTbody[j].style.backgroundColor = "";
        }
        this.style.backgroundColor = "rgb(255, 248, 167)";

        const celdas = this.getElementsByTagName("td");
        let contenidoCelda = "";

        for (let k = 0; k < celdas.length; k++) {
          contenidoCelda += celdas[k].textContent + "|";
        }
        var partes = contenidoCelda.split("|");
        var id = partes[0]; // "ID"
        var tipo = partes[1]; // "TIPO PREDIO"
        var direccion = partes[2]; // "DIRECCION PREDIO"
        var codigo_catastral = partes[3]; // "TIPO PREDIO"

        let parametros = {
          anio: self.nom_anio_predio,
          condicion_anio: "condicion_anio",
        };
        $.ajax({
          url: "ajax/predio.ajax.php",
          data: parametros,
          success: function (respuesta_anio) {
            this.respuesta_anio = respuesta_anio;

            var html_catastro =
              '<table class="table-container">' +
              "<thead><tr>" +
              '<th class="text-center">N°</th>' +
              '<th class="text-center">Tipo</th>' +
              '<th class="text-center">Catastro</th>' +
              '<th class="text-center">Dirección</th>' +
              '<th class="text-center">Año Predio</th>' +
              '<th class="text-center">Año a copear</th>' +
              "</tr><thead>" +
              "<tbody><tr>" +
              '<td class="text-center">' +
              id +
              "</td>" +
              '<td class="text-center">' +
              tipo +
              "</td>" +
              '<td class="text-center" id="codigo_catastral_t">' +
              codigo_catastral +
              "</td>" +
              '<td class="text-center">' +
              direccion +
              "</td>" +
              '<td class="text-center">' +
              self.nom_anio_predio +
              "</td>" +
              '<td class="text-center">' +
              this.respuesta_anio +
              "</td>" +
              "</tr></tbody></table>";
            $(".predio_catastro").html(html_catastro);

            var html_catastro_eliminar =
              '<table class="table-container">' +
              "<thead><tr>" +
              '<th class="text-center">N°</th>' +
              '<th class="text-center">Tipo</th>' +
              '<th class="text-center">Catastro</th>' +
              '<th class="text-center">Dirección</th>' +
              "</tr><thead>" +
              "<tbody><tr>" +
              '<td class="text-center">' +
              id +
              "</td>" +
              '<td class="text-center">' +
              tipo +
              "</td>" +
              '<td class="text-center" id="codigo_catastral_t">' +
              codigo_catastral +
              "</td>" +
              '<td class="text-center">' +
              direccion +
              "</td>" +
              "</tr></tbody></table>";
            $(".predio_catastro_eliminar").html(html_catastro_eliminar);

            var html_catastro_transferir =
              '<table class="table-container">' +
              "<thead><tr>" +
              '<th class="text-center">N°</th>' +
              '<th class="text-center">Tipo</th>' +
              '<th class="text-center">Catastro</th>' +
              '<th class="text-center">Dirección</th>' +
              '<th class="text-center">Año Predio</th>' +
              '<th class="text-center">Año a Transferir</th>' +
              "</tr><thead>" +
              "<tbody><tr>" +
              '<td class="text-center">' +
              id +
              "</td>" +
              '<td class="text-center">' +
              tipo +
              "</td>" +
              '<td class="text-center" id="codigo_catastral_t">' +
              codigo_catastral +
              "</td>" +
              '<td class="text-center">' +
              direccion +
              "</td>" +
              '<td class="text-center">' +
              self.nom_anio_predio +
              "</td>" +
              '<td class="text-center">' +
              self.nom_anio_predio +
              "</td>" +
              "</tr></tbody></table>";
            $(".predio_catastro_transferir").html(html_catastro_transferir);
            $("#anio_pasado").text(self.nom_anio_predio);
            this.predioSeleccionado = true;
          },
        });
      });
    }
  }
  lista_predio(fecha) {
    var self = this;
    let perfilOculto_p = $("#perfilOculto_p").val();
    var formd = new FormData();
    formd.append("propietarios", this.Propietarios);
    console.log(formd.get("propietarios"));
    console.log("id del año" + fecha);
    formd.append("selectnum", fecha);
    formd.append("action", "ajax");
    formd.append("dppredio", "dppredio");
    formd.append("perfilOculto_p", perfilOculto_p);
    for (const pair of formd.entries()) {
      console.log(pair[0] + ", " + pair[1]);
    }
    $.ajax({
      url: "vistas/tables/dataTables.php",
      method: "POST",
      data: formd,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $(".body-predio").html(loadingMessage);
      },
      success: function (data) {
        $(".body-predio").html(data);

        $("#id_predio_foto").on("click", function (e) {
          foto.modal_mostrar_foto=true;
          var id_predio_foto = $(this).data('id_predio_foto');
          foto.MostrarFotosPredio(id_predio_foto);
       });
       
        var tabla = document.getElementById("tablalistapredios");
        var tbody = tabla.querySelector("tbody");
        var filas = tbody.getElementsByTagName("tr");
        for (let i = 0; i < filas.length; i++) {
          filas[i].addEventListener("click", function () {
            self.anio_predio = $("#selectnum").val();
           
            console.log("id del anio:" + self.anio_predio);
          
            const filasTbody = tbody.getElementsByTagName("tr");
            self.id_predio = $(this).attr("id_predio");
            self.id_catastro_p = $(this).attr("id_catastro");
            self.id_tipo = $(this).attr("id_tipo");
            console.log("id del predio:" + self.id_predio);
            var selectElement = document.getElementById("selectnum");
            self.nom_anio_predio =selectElement.options[selectElement.selectedIndex].text;
            self.anio_copear=parseInt(self.nom_anio_predio)+1;
            console.log("id del copear:" + self.anio_copear);
            for (let j = 0; j < filasTbody.length; j++) {
              filasTbody[j].style.backgroundColor = "";
            }
            this.style.backgroundColor = "rgb(255, 248, 167)";

            const celdas = this.getElementsByTagName("td");
            let contenidoCelda = "";

            for (let k = 0; k < celdas.length; k++) {
              contenidoCelda += celdas[k].textContent + "|";
            }
            var partes = contenidoCelda.split("|");
            var id = partes[0]; // "ID"
            var tipo = partes[1]; // "TIPO PREDIO"
            var direccion = partes[2]; // "DIRECCION PREDIO"
            var codigo_catastral = partes[3]; // "TIPO PREDIO"

            let parametros = {
              anio: self.nom_anio_predio,
              condicion_anio: "condicion_anio",
            };
            $.ajax({
              url: "ajax/predio.ajax.php",
              data: parametros,
              success: function (respuesta_anio) {
                this.respuesta_anio = respuesta_anio;
                console.log("Año seleccionado - cambiado___:", predio.anio_copear);
                var html_catastro =
                  '<table class="table-container">' +
                  "<thead><tr>" +
                  '<th class="text-center">N°</th>' +
                  '<th class="text-center">Tipo</th>' +
                  '<th class="text-center">Catastro</th>' +
                  '<th class="text-center">Dirección</th>' +
                  '<th class="text-center">Año Predio</th>' +
                  '<th class="text-center">Año a copear</th>' +
                  "</tr><thead>" +
                  "<tbody><tr>" +
                  '<td class="text-center">' +
                  id +
                  "</td>" +
                  '<td class="text-center">' +
                  tipo +
                  "</td>" +
                  '<td class="text-center" id="codigo_catastral_t">' +
                  codigo_catastral +
                  "</td>" +
                  '<td class="text-center">' +
                  direccion +
                  "</td>" +
                  '<td class="text-center">' +
                  self.nom_anio_predio +
                  "</td>" +
                  '<td class="text-center">' +
                  this.respuesta_anio +
                  "</td>" +
                  "</tr></tbody></table>";
                $(".predio_catastro").html(html_catastro);
               
                var html_catastro_eliminar =
              '<table class="table-container">' +
              "<thead><tr>" +
              '<th class="text-center">N°</th>' +
              '<th class="text-center">Tipo</th>' +
              '<th class="text-center">Catastro</th>' +
              '<th class="text-center">Dirección</th>' +
              "</tr><thead>" +
              "<tbody><tr>" +
              '<td class="text-center">' +
              id +
              "</td>" +
              '<td class="text-center">' +
              tipo +
              "</td>" +
              '<td class="text-center" id="codigo_catastral_t">' +
              codigo_catastral +
              "</td>" +
              '<td class="text-center">' +
              direccion +
              "</td>" +
              "</tr></tbody></table>";
            $(".predio_catastro_eliminar").html(html_catastro_eliminar);

                var html_catastro_transferir =
                  '<table class="table-container">' +
                  "<thead><tr>" +
                  '<th class="text-center">N°</th>' +
                  '<th class="text-center">Tipo</th>' +
                  '<th class="text-center">Catastro</th>' +
                  '<th class="text-center">Dirección</th>' +
                  '<th class="text-center">Año Predio</th>' +
                  '<th class="text-center">Año a Transferir</th>' +
                  "</tr><thead>" +
                  "<tbody><tr>" +
                  '<td class="text-center">' +
                  id +
                  "</td>" +
                  '<td class="text-center">' +
                  tipo +
                  "</td>" +
                  '<td class="text-center" id="codigo_catastral_t">' +
                  codigo_catastral +
                  "</td>" +
                  '<td class="text-center">' +
                  direccion +
                  "</td>" +
                  '<td class="text-center">' +
                  self.nom_anio_predio +
                  "</td>" +
                  '<td class="text-center"><b>' +
                  self.nom_anio_predio +
                  "</b></td>" +
                  "</tr></tbody></table>";
                $(".predio_catastro_transferir").html(html_catastro_transferir);
                $("#anio_pasado").text(self.nom_anio_predio);
                this.predioSeleccionado = true;
               // predio.anio_copear = $("#selectnum_copiar option:selected").text();
                console.log("Año seleccionado - cambiado:", predio.anio_copear);
              },
            });
          });
        }
      },
    });
  }

  transferir_predio(confirmar) {
    let self = this;
    var formd = new FormData();
    var tipo_documento = $("#tipodocInscripcion").val();
    var n_documento = $("#n_documento").val();
    var tipo_escritura = $("#tipoEscritura").val();
    var fecha_escritura = $("#fechaEscritura").val();
    var propietario_nuevo = [];
    $("#div_propietario tr").each(function (index) {
      var idFila = $(this).attr("id");
      propietario_nuevo[index] = idFila;
    });
    formd.append("propietarios_antiguos", self.Propietarios);
    formd.append("catastro", self.id_catastro_p);
    formd.append("anio", self.nom_anio_predio);
    formd.append("propietarios_nuevos", propietario_nuevo);
    formd.append("tipo_documento", tipo_documento);
    formd.append("n_documento", n_documento);
    formd.append("tipo_escritura", tipo_escritura);
    formd.append("fecha_escritura", fecha_escritura);
    formd.append("tipo", self.id_tipo);
    formd.append("transferir_predio", "transferir_predio");
    formd.append("confirmar", confirmar);
    for (const pair of formd.entries()) {
      console.log(pair[0] + ", " + pair[1]);
    }
    $.ajax({
      type: "POST",
      url: "ajax/predio.ajax.php",
      data: formd,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function() {
        $(".cargando").html(loadingMessage_s);
        $("#modal_cargar").modal("show");
      },
      success: function (respuesta) {
        $("#modal_cargar").modal("hide");
        if (respuesta.tipo === "error") {
          $("#respuestaAjax_srm").show();
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 10000);
        } else if (respuesta.tipo === "advertencia_deuda") {
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          $("#modalTransferirPredio").modal("hide");
          $("#respuestaAjax_srm").show();
          $("#modal_transferir_si_no").modal("show");
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 10000);
        } else {
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          $("#modalTransferenciaPredio").modal("hide");
          $("#respuestaAjax_srm").show();
          $("#modal_transferir_si_no").modal("hide");
          predio.lista_predio(self.anio_predio);
          //var parametrosActuales = window.location.search;
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
         //   window.location.href =
           //   window.location.pathname + parametrosActuales;
          }, 10000);
        }
      },
      
          error: function() {
              $("#modal_cargar").text("Error al cargar el archivo.");
          }
    });
  }

  eliminar_predio(){
    var formd = new FormData();
    let self=this;
    var n_documento = $("#documento_eliminar").val();
    formd.append("id_predio", this.id_predio);
    formd.append("eliminar_predio", "eliminar_predio");
    formd.append("documento", n_documento);
    for (const pair of formd.entries()) {
      console.log(pair[0] + ", " + pair[1]);
    }
    $.ajax({
      type: "POST",
      url: "ajax/predio.ajax.php",
      data: formd,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function() {
        $(".cargando").html(loadingMessage_s);
        $("#modal_cargar").modal("show");
      },
      success: function (respuesta) {
        $("#modal_cargar").modal("hide");
        if (respuesta.tipo === "error") {
          $("#respuestaAjax_srm").show();
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 10000);
        }

        else {
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          $("#modalEliminarPredio").modal("hide");
          $("#respuestaAjax_srm").show();
          predio.lista_predio(self.anio_predio);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 10000);
        }

      },
      error: function() {
        $("#modal_cargar").text("Error al cargar el archivo.");
    }
    });
  }

  copear_predio(forzar){
    var formd = new FormData();
  console.log(predio.Propietarios);
  formd.append("id_predio", predio.id_predio);
  formd.append("anio_actual", predio.nom_anio_predio);
  formd.append("anio_copiar", predio.anio_copear);
  formd.append("propietarios", predio.Propietarios);
  formd.append("id_catastro", predio.id_catastro_p);
  formd.append("tipo", predio.id_tipo);
  formd.append("forzar", forzar);

  for (const pair of formd.entries()) {
    console.log(pair[0] + ", " + pair[1]);
  }
  $.ajax({
    type: "POST",
    url: "ajax/predio.ajax.php",
    data: formd,
    cache: false,
    contentType: false,
    processData: false,
    beforeSend: function() {
      $(".cargando").html(loadingMessage_s);
      $("#modal_cargar").modal("show");
    },
    success: function (respuesta) {
      $("#modal_cargar").modal("hide");
      if (respuesta.tipo === "error") {
        //$("#modalCopiarPredio").modal("show");
        $("#respuestaAjax_srm").html(respuesta.mensaje);
        $("#respuestaAjax_srm").show();
        setTimeout(function () {
          $("#respuestaAjax_srm").hide();
        }, 10000);
      }
      if (respuesta.tipo === "advertencia") {
        $("#respuestaAjax_srm").html(respuesta.mensaje);
        $("#modal_forzosamente_si_no").modal("show");
        $("#respuestaAjax_srm").show();
        setTimeout(function () {
          $("#respuestaAjax_srm").hide();
        }, 10000);
      } else {
        $("#respuestaAjax_srm").html(respuesta.mensaje);
        //$("#modalCopiarPredio").modal("hide");
        $("#modal_forzosamente_si_no").modal("hide");
        $("#respuestaAjax_srm").show();
        setTimeout(function () {
          $("#respuestaAjax_srm").hide();
        }, 10000);
      }
    },
    error: function() {
      $("#modal_cargar").text("Error al cargar el archivo.");
  }
  });
  }
}
const predio = new Predio();


$(document).ready(function () {
  $("#id_propietarios tr").each(function (index) {
    var idFila = $(this).attr("id_contribuyente");
    predio.Propietarios.push(idFila);

    const carpetaContribuyente = document.querySelector('#carpeta_contribuyente');
    const idCarpeta = carpetaContribuyente.getAttribute('id_carpeta');
    predio.carpeta=idCarpeta;
    console.log('codigo de carpeta ultimo lml  :', predio.carpeta);
  });
  

 predio.id_propietario= predio.Propietarios.join("-");
console.log("id de propietarios para impuesto "+predio.id_propietario);

  predio.click_predio();
  $(document).on("change", "#selectnum", function () {
    predio.fecha_predio = $("#selectnum").val();
    predio.id_predio=null;
    console.log("fecha predio_ joder: " + predio.fecha_predio);
    predio.lista_predio(predio.fecha_predio);
    $("#listaPisos").html("");
  });

  //MOSTRAR EL POPUP TRANSFERENCIA PREDIO
  $("#abrirPopupButton").click(function () {
    if (predio.id_predio > 0) {
      $("#modalTransferenciaPredio").modal("show");
    } else {
      $("#respuestaAjax_srm").html(
        '<div class="alert warning">' +
          '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
          '<span aria-hidden="true" class="letra">×</span>' +
          '</button><p class="inner"><strong class="letra">Alerta!</strong> <span class="letra">Seleccione un Predio para poder Transferir!</span></p></div>'
      );
      $("#respuestaAjax_srm").show();
      setTimeout(function () {
        $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 10000);
    }
  });
  //MOSTRAR EL POPUP COPIAR EL PREDIO
  $("#abrirPopupButton_copiar").click(function () {
    console.log("id predio a copear _ " + predio.id_predio);
    if (predio.id_predio > 0) {
      $("#modalCopiarPredio").modal("show");
    } else {
      $("#respuestaAjax_srm").html(
        '<div class="alert warning">' +
          '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
          '<span aria-hidden="true" class="letra">×</span>' +
          '</button><p class="inner"><strong class="letra">Alerta!</strong> <span class="letra">Seleccione un Predio para poder copear!</span></p></div>'
      );

      $("#respuestaAjax_srm").show();
      setTimeout(function () {
        $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 7000);
    }
  });

  //MOSTRAR EL POPUP ELIMINAR PREDIO
  $("#abrirEliminar_Predio").click(function () {
    if (predio.id_predio > 0) {
      $("#modalEliminarPredio").modal("show");
    } else {
      $("#respuestaAjax_srm").html(
        '<div class="alert warning">' +
          '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
          '<span aria-hidden="true" class="letra">×</span>' +
          '</button><p class="inner"><strong class="letra">Alerta!</strong> <span class="letra">Seleccione un Predio para poder Eliminar</span></p></div>'
      );
      $("#respuestaAjax_srm").show();
      setTimeout(function () {
        $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
      }, 10000);
    }
  });

  
  // TRANSFERIR PREDIO VALIDADO
  $(".btnTransferirPredio").on("click", function (e) {
    e.preventDefault();
    predio.transferir_predio('no');
  });


  // CONFIRMAR TRANSFERIR PREDIO VALIDADO
  $(".confirmar_transferencia_si").on("click", function (e) {
    e.preventDefault();
    predio.transferir_predio('si');
  });


  let idPredioc;
  // COPIAR PREDIO A OTROA AÑOS
  $(document).on("click", "#tablalistapredios tbody tr", function () {
    idPredioc = $(this).attr("id_predio");
  });

  // ELIMINAR PREDIO
  $(".btnEliminarPredio").on("click", function (e) {
    e.preventDefault();
    predio.eliminar_predio();
  });
});

$(document).on("change", "#selectnum_copiar", function () {
  predio.anio_copear = $(this).find("option:selected").text();
  console.log("Año seleccionado - cambiado___:", predio.anio_copear);
});

$(".btnCopiarPredio").on("click", function (e) {
  e.preventDefault();
  predio.copear_predio("noforzar");
});
//copear predio forzosamente 
$(".confirmar_copear_forzosamente_si").on("click", function (e) {
  e.preventDefault();
  predio.copear_predio("forzar");
});

$("#obciones_calcular").on("click", function (e) {
  $("#modal_predio_propietario").modal("show");
});


