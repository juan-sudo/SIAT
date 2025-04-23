class Caja {
  constructor() {
    this.idContribuyente_caja = 0;
    this.totalGasto_caja = 0;
    this.totalSubtotal_caja = 0;
    this.totalTIM_caja = 0;
    this.totalTotal_caja = 0;
    this.totalImporte_caja = 0;
    this.idsSeleccionados_caja = [];
    this.totalImpuesto = 0;
    this.totalArbitrios = 0;
    this.vuelto = 0;
    this.efectivo = 0;

    this.estadoS_tem = 0;
    this.gastoText_tem = 0;
    this.subtotalText_tem = 0;
    this.timText_tem = 0;
    this.totalText_tem = 0;
    this.importeText_tem = 0;
    this.tributoText_tem = 0;

    this.gasto_tem = 0;
    this.subtotal_tem = 0;
    this.tim_tem = 0;
    this.total_tem = 0;
    this.importe_tem = 0;

    this.tipo_papel_valor = "";
    this.tipo_tributo = "";
  }
  loadContribuyenteCaja(page, searchClass, donde) {
    let perfilOculto_c = $("#perfilOculto_c").val();
    let searchContribuyente = $("." + searchClass).val();
    console.log(searchClass);
    let parametros = {
      action: "ajax",
      page: page,
      searchContribuyente: searchContribuyente,
      tipo: searchClass,
      donde: donde,
      dpcontribuyente_caja: "dpcontribuyente_caja",
      perfilOculto_c: perfilOculto_c,
    };
    $.ajax({
      url: "vistas/tables/dataTables.php",
      data: parametros,
      beforeSend: function () {
        $(".body-contribuyente-caja").html(loadingMessage);
      },
      success: function (data) {
        $(".body-contribuyente-caja").html(data);
      },
      error: function () {
        $(".body-contribuyente-caja").html(errordata);
      },
    });
  }
  pasar_parametro_get_caja(id) {
    window.location = "index.php?ruta=caja&id=" + id;
  }
  manejarClicFila_caja(fila) {
    this.estadoS_tem = fila.find("td:eq(9)").text();
    this.gastoText_tem = fila.find("td:eq(5)").text();
    this.subtotalText_tem = fila.find("td:eq(6)").text();
    this.timText_tem = fila.find("td:eq(7)").text();
    this.totalText_tem = fila.find("td:eq(8)").text();
    this.importeText_tem = fila.find("td:eq(4)").text();
    this.tributoText_tem = fila.find("td:eq(0)").text();

    this.gasto_tem = parseFloat(this.gastoText_tem);
    this.subtotal_tem = parseFloat(this.subtotalText_tem);
    this.tim_tem = parseFloat(this.timText_tem);
    this.total_tem = parseFloat(this.totalText_tem);
    this.importe_tem = parseFloat(this.importeText_tem);
    // Capturar el valor del atributo "id" de la fila y agregarlo al array si está seleccionada
    const filaId = fila.attr("id");

    if (filaId === "noseleccionar") {
      return; // No realizar ninguna acción si el ID es "noseleccionar"
    }
    if (this.estadoS_tem === "1") {
      if (this.tributoText_tem === "006") {
        this.totalImpuesto -= this.total_tem;
      } else {
        this.totalArbitrios -= this.total_tem;
      }
      this.totalGasto_caja -= this.gasto_tem;
      this.totalSubtotal_caja -= this.subtotal_tem;
      this.totalTIM_caja -= this.tim_tem;
      this.totalTotal_caja -= this.total_tem;
      this.totalImporte_caja -= this.importe_tem;

      fila.find("td:eq(9)").text("");
      fila.css("background-color", "");

      // Eliminar el valor del id de la fila del array (si existe)
      const index = this.idsSeleccionados_caja.indexOf(filaId);
      if (index > -1) {
        this.idsSeleccionados_caja.splice(index, 1);
      }
    } else {
      if (this.idsSeleccionados_caja.length >= 12) {
        alert("Elementos seleccionados supera rango de impresión de boleta ");
        return; 
      }
      
      if (this.tributoText_tem === "006") {
        this.totalImpuesto += this.total_tem;
      } else {
        this.totalArbitrios += this.total_tem;
      }
      this.totalGasto_caja += this.gasto_tem;
      this.totalSubtotal_caja += this.subtotal_tem;
      this.totalTIM_caja += this.tim_tem;
      this.totalTotal_caja += this.total_tem;
      this.totalImporte_caja += this.importe_tem;
      fila.find("td:eq(9)").text("1");
      fila.css("background-color", "rgb(255, 248, 167)");
      
      if (!this.idsSeleccionados_caja.includes(filaId)) {
        this.idsSeleccionados_caja.push(filaId);
      }
    }
    
    $("#segundaTabla_caja tbody th:eq(1)").text(
      this.totalImporte_caja.toFixed(2)
    );
    $("#segundaTabla_caja tbody th:eq(2)").text(
      this.totalGasto_caja.toFixed(2)
    );
    $("#segundaTabla_caja tbody th:eq(3)").text(
      this.totalSubtotal_caja.toFixed(2)
    );
    $("#segundaTabla_caja tbody th:eq(4)").text(this.totalTIM_caja.toFixed(2));
    $("#segundaTabla_caja tbody th:eq(5)").text(
      this.totalTotal_caja.toFixed(2)
    );

    document.getElementById("total_impuesto").innerHTML =
      this.totalImpuesto == 0
        ? "0.00"
        : Math.max(this.totalImpuesto, 0).toFixed(2);
    document.getElementById("total_arbitrios").innerHTML =
      this.totalArbitrios.toFixed(2);
    document.getElementById("total_confirmar").innerHTML =
      "S/." + this.totalTotal_caja.toFixed(2);

    console.log("Ids seleccionados:", this.idsSeleccionados_caja);
    document.getElementById("efectivo").value = "";
    document.getElementById("vuelto").value = "";
}


manejarClicS_caja(thS) {
  const filas = $("#primeraTabla_caja tbody tr");
  const todasSeleccionadas = $("td:eq(9):contains('1')", filas).length === filas.length;
  
  if (todasSeleccionadas) {
      // Todas las filas están seleccionadas, deseleccionar todas
      filas.each((index, fila) => {
          this.manejarClicFila_caja($(fila));
      });
  } else {
      // Contar el número actual de filas seleccionadas
      const seleccionadas = $("td:eq(9):contains('1')", filas).length;

      if (seleccionadas >= 12) {
          alert("Elementos seleccionados supera rango de impresión de boleta ");
          return; // No permitir seleccionar más filas
      }

      let mensajeMostrado = false;

      // Al menos una fila ya está seleccionada, completar las faltantes
      filas.each((index, fila) => {
          if ($("td:eq(9)", fila).text() !== "1") {
              // Verificar si seleccionadas + 1 es menor o igual a 12
              if (seleccionadas + this.idsSeleccionados_caja.length < 12) {
                  this.manejarClicFila_caja($(fila));
              } else if (!mensajeMostrado) {
                  alert("Elementos seleccionados supera rango de impresión de boleta ");
                  mensajeMostrado = true; // Marcar que el mensaje ya fue mostrado
                  return; // Salir del loop cuando se alcance el límite
              }
          }
      });
  }s

  thS.text(todasSeleccionadas ? "S" : "S");

  // Actualizar los totales en la segunda tabla
  $("#segundaTabla_caja tbody th:eq(1)").text(
      this.totalImporte_caja.toFixed(2)
  );
  $("#segundaTabla_caja tbody th:eq(2)").text(
      this.totalGasto_caja.toFixed(2)
  );
  $("#segundaTabla_caja tbody th:eq(3)").text(
      this.totalSubtotal_caja.toFixed(2)
  );
  $("#segundaTabla_caja tbody th:eq(4)").text(this.totalTIM_caja.toFixed(2));
  $("#segundaTabla_caja tbody th:eq(5)").text(
      this.totalTotal_caja.toFixed(2)
  );
  document.getElementById("efectivo").value = "";
  document.getElementById("vuelto").value = "";
}


  estadoCuenta(Id) {
    let datos = new FormData();
    this.tipo_tributo = document.getElementById("select_tributo").value;
    datos.append("id_propietarios", Id);
    datos.append("estado_cuenta_caja", "estado_cuenta_caja");
    datos.append("tipo_tributo", this.tipo_tributo);
    $.ajax({
      url: "ajax/caja.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        $(".estadocuentacaja").html(respuesta);
        // Función para seleccionar la fila de estado de cuenta
        $("#primeraTabla_caja tbody tr").on("click", function () {
          caja.manejarClicFila_caja($(this));
          document.getElementById("total_caja").innerHTML =
            caja.totalTotal_caja.toFixed(2);
        });
      },
    });
  }
  n_recibo() {
    let datos = new FormData();
    datos.append("n_recibo", "n_recibo");
    $.ajax({
      url: "ajax/caja.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        document.getElementById("nc").innerHTML = Number(respuesta["Numero_Recibo"]) + 1;
      },
    });
  }
  reniciar_valor() {
    this.estadoS_tem = 0;
    this.gastoText_tem = 0;
    this.subtotalText_tem = 0;
    this.timText_tem = 0;
    this.totalText_tem = 0;
    this.importeText_tem = 0;
    this.tributoText_tem = 0;

    this.gasto_tem = 0;
    this.subtotal_tem = 0;
    this.tim_tem = 0;
    this.total_tem = 0;
    this.importe_tem = 0;

    this.totalImpuesto = 0;
    this.totalArbitrios = 0;
    this.totalGasto_caja = 0;
    this.totalSubtotal_caja = 0;
    this.totalTIM_caja = 0;
    this.totalTotal_caja = 0;
    this.totalImporte_caja = 0;

    this.idsSeleccionados_caja = [];
    $("#segundaTabla_caja tbody th:eq(1)").text(
      this.totalImporte_caja.toFixed(2)
    );
    $("#segundaTabla_caja tbody th:eq(2)").text(
      this.totalGasto_caja.toFixed(2)
    );
    $("#segundaTabla_caja tbody th:eq(3)").text(
      this.totalSubtotal_caja.toFixed(2)
    );
    $("#segundaTabla_caja tbody th:eq(4)").text(this.totalTIM_caja.toFixed(2));
    $("#segundaTabla_caja tbody th:eq(5)").text(
      this.totalTotal_caja.toFixed(2)
    );

    document.getElementById("total_impuesto").innerHTML =
      this.totalImpuesto == 0
        ? "0.00"
        : Math.max(this.totalImpuesto, 0).toFixed(2);
    document.getElementById("total_arbitrios").innerHTML =
      this.totalArbitrios.toFixed(2);
    document.getElementById("total_confirmar").innerHTML =
      "S/." + this.totalTotal_caja.toFixed(2);
    document.getElementById("total_caja").innerHTML =
      this.totalTotal_caja.toFixed(2);
  }
  tipo_papel(callback) {
    let self = this;
    let datos_papel = new FormData();
    datos_papel.append("tipo_papel", "tipo_papel");

    $.ajax({
      url: "ajax/caja.ajax.php",
      method: "POST",
      data: datos_papel,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        // Establecer el valor en la clase
        self.tipo_papel_valor = respuesta["Id_Tipo_Papel"];
        console.log("tipo de papel impresión:" + self.tipo_papel_valor);

        // Llamar a la función de devolución de llamada
        if (typeof callback === "function") {
          callback();
        }
      }.bind(this), // Asegura que "this" se refiera a la instancia de la clase
    });
  }



  imprimirRecibo_IA() {
    let self = this;
    let datos = new FormData();

    datos.append("propietarios", caja.idContribuyente_caja);
    datos.append("id_cuenta", caja.idsSeleccionados_caja);
    datos.append("cobrar_caja", "cobrar_caja");
    console.log("propietarios:" + caja.idContribuyente_caja);
    console.log("id_cuenta:" + caja.idsSeleccionados_caja);

    //valores para caja
    let datos_baucher = new FormData();
    //const valorModificado = id.replace('-', ',');
    datos_baucher.append("propietarios", caja.idContribuyente_caja);
    datos_baucher.append("id_cuenta", caja.idsSeleccionados_caja);
    datos_baucher.append("tipo_tributo", this.tipo_tributo);
    datos_baucher.append("fuente", "imprimir");


    
    console.log("propietario_baoucher:" + caja.idContribuyente_caja);
    console.log("id_cuenta boucher:" + caja.idsSeleccionados_caja);
    console.log (datos_baucher);
    caja.reniciar_valor();
    caja.tipo_papel();
    console.log("tipo_papel_generar_IMPRIMIR:" + self.tipo_papel_valor);

    $.ajax({
      url: "ajax/caja.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        if (respuesta.tipo === "correcto") {
          $("#modalPagar_si_no").modal("hide");
          // $("#respuestaAjax_srm").show();
          // $("#respuestaAjax_srm").html(respuesta.mensaje);

          console.log("papel mlm:" + self.tipo_papel_valor);

          caja.estadoCuenta(caja.idContribuyente_caja);
          caja.n_recibo();


          // setTimeout(function () {
          //   $("#respuestaAjax_srm").hide();
          // }, 4000);

          console.log("papel mlm:" + self.tipo_papel_valor);
          console.log(typeof self.tipo_papel_valor);



          if (self.tipo_papel_valor == "1") {
            $.ajax({
              url: "./vistas/print/imprimirBoletaA4.php",
              method: "POST",
              data: datos_baucher,
              cache: false,
              contentType: false,
              processData: false,
              success: function (rutaArchivo) {
                // Establecer el src del iframe con la ruta relativa del PDF
                document.getElementById("iframe_A4").src =
                  "vistas/print/" + rutaArchivo;
                $("#Modalimprimir_boleta").modal("show");
              },
            });
          } else if (self.tipo_papel_valor === "2") {
            $.ajax({
              url: "./vistas/print/imprimirBoletaA4_3.php",
              method: "POST",
              data: datos_baucher,
              cache: false,
              contentType: false,
              processData: false,
              success: function (rutaArchivo) {
                // Establecer el src del iframe con la ruta relativa del PDF
                document.getElementById("iframe_A4").src =
                  "vistas/print/" + rutaArchivo;
                $("#Modalimprimir_boleta").modal("show");
              },
            });
          } else {
            $.ajax({
              url: "ajax/imprimirImpuesto.php",
              method: "POST",
              data: datos_baucher,
              cache: false,
              contentType: false,
              processData: false,
              success: function (rutaArchivo) {
                // Establecer el src del iframe con la ruta relativa del PDF
                $("#respuestaAjax_srm").show();
                $("#respuestaAjax_srm").html(
                  '<div class="alert success">' +
                  '<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">' +
                  '<span aria-hidden="true" class="letra">×</span>' +
                  '</button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">Se genero el recibo correctamente!</span></p></div>'
                );
                setTimeout(function () {
                  $("#respuestaAjax_srm").hide();
                }, 5000);

              },
            });
          }
        } else if (respuesta.tipo === "advertencia") {
          $("#modalPagar_si_no").modal("hide");
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          $("#respuestaAjax_srm").show();
          caja.estadoCuenta(caja.idContribuyente_caja);
          caja.n_recibo();
          setTimeout(function () {
            $("#respuestaAjax_correcto").hide();
          }, 5000);
        }
      },
    });
  }
}
//fin de la clase y constructor
const caja = new Caja();

//obteniendo el valor pasado por get deesde lista de contribuyente caja - a caja
document.addEventListener("DOMContentLoaded", function () {
  var queryString = window.location.search;
  var urlParams = new URLSearchParams(queryString);
  var Id = urlParams.get("id");
  caja.idContribuyente_caja = Id;
  caja.estadoCuenta(Id);
  caja.n_recibo();
  //caja.tipo_papel();
  console.log("contribuyentes caja"+caja.idContribuyente_caja);
});
function loadContribuyente_caja(page, searchClass, donde) {
  console.log("searchClass");
  if (event.keyCode === 13) {
    caja.loadContribuyenteCaja(page, searchClass, donde);
    event.preventDefault();
  }
}
//PASAR EL VALOR DE CONTRIBUYENTE BUSCADO A PREDIOS POR GET - VALIDADO para caja
$(document).on("click", ".btnCaja", function () {
  let id = $(this).attr("idContribuyente_caja");
  caja.pasar_parametro_get_caja(id);
});
// Función para manejar el clic en el encabezado "S"
$("#primeraTabla_caja thead th:eq(9)").on("click", function () {
  caja.manejarClicS_caja($(this));
  document.getElementById("total_caja").innerHTML =
    caja.totalTotal_caja.toFixed(2);
});
function sumarValores() {
  caja.efectivo = document.getElementById("efectivo").value;
  caja.vuelto = caja.efectivo - caja.totalTotal_caja;
  document.getElementById("vuelto").value = caja.vuelto.toFixed(2);
}
//Mostrar el Pop up para confirma si pagar o no
$(document).on("click", ".generar_boleta", function () {
  if (caja.totalTotal_caja > 0) {
    $("#modalPagar_si_no").modal("show");
    //miInstanciaImprimir.imprimirDJ();
  } else {
    var html_respuesta =
      ' <div class="col-sm-30">' +
      '<div class="alert alert-warning">' +
      '<button type="button" class="close font__size-18" data-dismiss="alert">' +
      "</button>" +
      '<i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>' +
      '<strong class="font__weight-semibold">Alerta!</strong> Seleccione el estado de Cuenta.' +
      "</div>" +
      "</div>";
    $("#respuestaAjax_srm").html(html_respuesta);
    $("#respuestaAjax_srm").show();
    setTimeout(function () {
      $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
    }, 5000);
  }
});



//Mostrar el Pop up para confirma si pagar o no
$(document).on("click", ".print_boleta_impuestoarbitrios", function () {
  //$('#modalPagar_si_no').modal('hide');
  caja.imprimirRecibo_IA();
  //$("#Modalimprimir_LA").modal("show");
});
function load_tributo() {
  caja.estadoCuenta(caja.idContribuyente_caja);
  caja.reniciar_valor();
}
