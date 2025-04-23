class CierreCajaClass {
  constructor() {
    this.fechafiltro = null;
    this.sumaTotal=null;
  }
  fecha_cierrecaja() {
    // Obtener la fecha actual
    var fechaActual = new Date();
    // Formatear la fecha como YYYY-MM-DD
    var year = fechaActual.getFullYear();
    var month = String(fechaActual.getMonth() + 1).padStart(2, "0"); // Los meses comienzan desde 0
    var day = String(fechaActual.getDate()).padStart(2, "0");
    var fechaFormateada = year + "-" + month + "-" + day;
    this.fechafiltro = fechaFormateada;
    // Asignar la fecha formateada al campo de entrada
    document.getElementById("fecha_cierre").value = fechaFormateada;
    console.log(this.fechafiltro);
  }
  cierre_ingresos(fecha) {
    let datos = new FormData();
    datos.append("fecha", fecha);
    datos.append("cierre_ingresos", "cierre_ingresos");
    console.log(typeof this.fechafiltro);

    $.ajax({
      url: "ajax/reporte.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        if (respuesta.tipo === "correcto") {
          console.log(respuesta);
          $("#modalcierrecaja_si_no").modal("hide");
          var div = document.getElementById("midiv");
          div.style.display = "block";
          cierre_caja.barra(respuesta);
        } else if (respuesta.tipo === "advertencia") {
          $("#modalcierrecaja_si_no").modal("hide");
          $("#respuestaAjax_srm").show();
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 6000);
        }
      },
    });
  }
  ajustarAnchoColumnas_cierre() {
    // Obtén el ancho de las columnas de la primera tabla
    var primeraTabla_agua = document.getElementById("primeraTabla_cierre");
    var columnasPrimeraTabla_agua = primeraTabla_agua.rows[0].cells; // Suponiendo que la primera fila tiene los encabezados

    // Aplica el ancho de las columnas de la primera tabla a la segunda tabla
    var segundaTabla_agua = document.getElementById("segundaTabla_cierre");
    var columnasSegundaTabla_agua = segundaTabla_agua.rows[0].cells;

    for (var i = 0; i < columnasPrimeraTabla_agua.length; i++) {
      columnasSegundaTabla_agua[i].style.width =
        columnasPrimeraTabla_agua[i].offsetWidth + "px";
    }
  }
  barra(respuesta) {
    var $progress = $(".progress"),
      $bar = $(".progress__bar"),
      $text = $(".progress__text"),
      percent = 50, // Empieza desde el 50%
      update,
      resetColors,
      speed = 50, // Ajusta la velocidad del incremento del porcentaje
      colorChangeSpeed = 500, // Ajusta la velocidad del cambio de color
      orange = 30,
      yellow = 55,
      green = 85,
      timer;
    resetColors = function () {
      $bar
        .removeClass("progress__bar--green")
        .removeClass("progress__bar--yellow")
        .removeClass("progress__bar--orange")
        .removeClass("progress__bar--blue");
      $progress.removeClass("progress--complete");
    };
    update = function () {
      timer = setTimeout(function () {
        percent += Math.random() * 2; // Incremento más rápido del porcentaje
        percent = parseFloat(percent.toFixed(1));
        $text.find("em").text(percent + "%");
        if (percent >= 100) {
          percent = 100;
          $progress.addClass("proceso--completo");
          $bar.addClass("progress__bar--blue");
          $text.find("em").text("Completo");
          cierre_caja.reporte_financiamiento(cierre_caja.fechafiltro);
          cierre_caja.reporte_financiamiento_total(cierre_caja.fechafiltro);
          $("#respuestaAjax_srm").show();
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 6000);
        } else {
          if (percent >= green) {
            $bar.addClass("progress__bar--green");
          } else if (percent >= yellow) {
            $bar.addClass("progress__bar--yellow");
          } else if (percent >= orange) {
            $bar.addClass("progress__bar--orange");
          }
          update(); // Llama a la función update() sin retraso para una transición más rápida
        }
        $bar.css({width: percent + "%"});
      }, speed);
    };
    setTimeout(function () {
      $progress.addClass("progress--active");
      update();
    }, 500); // Inicia la animación después de 0.5 segundos
  }

  reporte_financiamiento(fecha) {
    let datos = new FormData();
    datos.append("fecha", fecha);
    datos.append("report_finan", "report_finan");

    $.ajax({
      url: "ajax/reporte.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        $("#reporte_financiamiento").html(respuesta);
        cierre_caja.ajustarAnchoColumnas_cierre();
        console.log(respuesta);
      },
    });
  }
  reporte_financiamiento_total(fecha) {
    let datos = new FormData();
    datos.append("fecha", fecha);
    datos.append("report_finan_total", "report_finan_total");

    $.ajax({
      url: "ajax/reporte.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        $("#total_reporte_cierre").text(respuesta["total"]);
        console.log(respuesta);
      },
    });
  }
  Reporte_Diario_PDF(){
    let datos = new FormData();
      datos.append("fecha",this.fechafiltro);
      datos.append("total",this.sumaTotal);
      datos.append("id_usuario", general.iso_usuario);
      datos.append("id_area", general.iso_area);
      console.log("fecha_:"+this.fechafiltro);
      console.log("total_:"+this.sumaTotal);
      $.ajax({
        url: "./vistas/print/imprimirReporteDiarioCaja.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $(".cargando").html(loadingMessage_s);
          $("#modal_cargar").modal("show");
        },
        success: function(rutaArchivo) {
          
          $("#modal_cargar").modal("hide");
          $("#Modalimprimir_ReporteDiario").modal("show");
          document.getElementById("iframe_reporte_diario").src = 'vistas/print/' + rutaArchivo;
        },
        error: function() {
            $("#modal_cargar").text("Error al cargar el archivo.");
        }
      });     
}
}

const cierre_caja = new CierreCajaClass();
//caja.tipo_papel();
document.addEventListener("DOMContentLoaded", function () {
  cierre_caja.fecha_cierrecaja();
  cierre_caja.reporte_financiamiento(cierre_caja.fechafiltro);
  cierre_caja.reporte_financiamiento_total(cierre_caja.fechafiltro);

  //cuadre_caja.cuadre_tributos_agua(cuadre_caja.fechafiltro);
});

$(document).ready(function () {
  $(document).on("change", "#fecha_cierre", function () {
    cierre_caja.fechafiltro = $("#fecha_cierre").val();
    var div = document.getElementById("midiv");
    div.style.display = "none";
    console.log("nueva fecha: " + cierre_caja.fechafiltro);
    cierre_caja.reporte_financiamiento(cierre_caja.fechafiltro);
    cierre_caja.reporte_financiamiento_total(cierre_caja.fechafiltro);
  });
});

$(document).on("click", "#cierre_caja", function () {
  $("#fecha_cierre_caja").text(cierre_caja.fechafiltro);
  $("#modalcierrecaja_si_no").modal("show");

  //caja.imprimirRecibo_IA();
  //$("#Modalimprimir_LA").modal("show");
});

$(document).on("click", ".print_cierre_caja", function () {
  cierre_caja.cierre_ingresos(cierre_caja.fechafiltro);
});

/*=========================================================*/
$(document).on("click", "#btnConsultarReporteIng", function () {
  cierre_caja.sumaTotal=null;
  cierre_caja.fechafiltro = $("#fechaIngresoDiario").val();
  const cuerpoTabla = document.getElementById("bodyReporteIngresosDiarios");
  const filas = cuerpoTabla.getElementsByTagName("tr");

  while (filas.length > 0) {
    cuerpoTabla.deleteRow(0); // Elimina la primera fila de la tabla
  }
  let datos = new FormData();
  datos.append("fechaReporte",cierre_caja.fechafiltro);
  datos.append("reporteIngresoDiario", "reporteIngresoDiario");
  $.ajax({
    url: "ajax/reporte.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      respuesta.forEach((value) => {
        let fila = cuerpoTabla.insertRow();
        fila.innerHTML = `<td class="text-center">${value.Codigo}</td><td>${value.Descripcion}</td><td class="text-center">${value.Subtotal}</td><td class="text-center">${value.Financia}</td>`;
        
        // Asegúrate de sumar como número flotante
        cierre_caja.sumaTotal += parseFloat(value.Subtotal) || 0; // Añade || 0 para manejar el caso en que parseFloat devuelva NaN
    });
    
    $("#totalIngresoDiario").text(cierre_caja.sumaTotal.toFixed(2));
    },
  });

  //caja.imprimirRecibo_IA();
  //$("#Modalimprimir_LA").modal("show");
});
$(document).on("click", "#popimprimir_reporte_diario", function () {
  cierre_caja.Reporte_Diario_PDF(cierre_caja.fechafiltro);
});
