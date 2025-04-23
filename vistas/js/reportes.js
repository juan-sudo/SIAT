class Reporte_Ingresos {
  constructor() {
    this.idContribuyente_r = null;
    this.impuesto_anual_r = null;
    this.base_imponible_r = null;
    this.impuesto_trimestral_r = null;
    this.gasto_emision_r = null;
    this.total_pagar_r = null;
    this.selectnum_r = null;
 

    this.totalImporte_r = 0;
    this.totalGasto_r = 0;
    this.totalSubtotal_r = 0;
    this.totalTIM_r = 0;
    this.totalTotal_r = 0;
    this.idsSeleccionados_r = [];
  }
  loadContribuyenteImpuesto(page,searchClass,pagado) {
    let perfilOculto_c = $("#perfilOculto_c").val();
        let searchContribuyente = $("." + searchClass).val();
        console.log(searchContribuyente);
        let parametros = {
          action: "ajax",
          page: page,
          searchContribuyente: searchContribuyente,
          tipo: searchClass,
          pagado:pagado,
          recaudacion_dpcontribuyente_impuesto: "recaudacion_dpcontribuyente_impuesto",
          perfilOculto_c: perfilOculto_c,
        };
        $.ajax({
          url: "vistas/tables/dataTables.php",
          data: parametros,
          beforeSend: function() {
            $(".body-contribuyente").html(loadingMessage);
          },
          success: function (data) {
            $(".body-contribuyente").html(data);
          },
          error: function() {
            $(".body-contribuyente").html(errordata);
          }
        });
  }

  pasar_parametro_get_pagado(id) {
    window.location =
      "index.php?ruta=Pagados-impuesto-arbitrios&id=" + id;
  }
  imprimir_estado_cuenta(id) {
    window.location =
      "index.php?ruta=imprimirEstadoCuenta&id=" + id;
  }
  manejarClicS_pagados(thS) {
    const filas = $("#primeraTabla_reporte_pagados_IA tbody tr");
    const todasSeleccionadas = $("td:eq(11):contains('1')", filas).length === filas.length;
    if (todasSeleccionadas) {
      // Todas las filas están seleccionadas, deseleccionar todas
      filas.each((index, fila) => {
        this.manejarClicFila_pagados($(fila));
      });
    } else {
      // Al menos una fila ya está seleccionada, completar las faltantes
      filas.each((index, fila) => {
        if ($("td:eq(11)", fila).text() !== "1") {
          this.manejarClicFila_pagados($(fila));
        }
      });
    }
    thS.text(todasSeleccionadas ? "S" : "S");
    // Actualizar los totales en la segunda tabla
    $("#segundaTabla_reporte_pagados_IA tbody th:eq(1)").text(this.totalImporter_.toFixed(2));
    $("#segundaTabla_reporte_pagados_IA tbody th:eq(2)").text(this.totalGasto_r.toFixed(2));
    $("#segundaTabla_reporte_pagados_IA tbody th:eq(3)").text(this.totalSubtotal_r.toFixed(2));
    $("#segundaTabla_reporte_pagados_IA tbody th:eq(4)").text(this.totalTIM_r.toFixed(2));
    $("#segundaTabla_reporte_pagados_IA tbody th:eq(5)").text(this.totalTotal_r.toFixed(2));
  }
  

 manejarClicFila_pagados(fila) {
    const estadoS = fila.find("td:eq(11)").text();
    const importeText = fila.find("td:eq(6)").text();
    const gastoText = fila.find("td:eq(7)").text();
    const subtotalText = fila.find("td:eq(8)").text();
    const timText = fila.find("td:eq(9)").text();
    const totalText = fila.find("td:eq(10)").text();
    
    
    const gasto = parseFloat(gastoText);
    const subtotal = parseFloat(subtotalText);
    const tim = parseFloat(timText);
    const total = parseFloat(totalText);
    const importe = parseFloat(importeText);
    
    // Capturar el valor del atributo "id" de la fila y agregarlo al array si está seleccionada
    const filaId = fila.attr("id");
    
    if (estadoS === "1") {
        this.totalGasto_r -= gasto;
        this.totalSubtotal_r -= subtotal;
        this.totalTIM_r -= tim;
        this.totalTotal_r -= total;
        this.totalImporte_r -= importe;
        
        fila.find("td:eq(11)").text("");
        fila.css("background-color", "");
        
        // Eliminar el valor del id de la fila del array (si existe)
        const index = this.idsSeleccionados_r.indexOf(filaId);
        if (index > -1) {
            this.idsSeleccionados_r.splice(index, 1);
        }
    } else {
        this.totalGasto_r += gasto;
        this.totalSubtotal_r += subtotal;
        this.totalTIM_r += tim;
        this.totalTotal_r += total;
        this.totalImporte_r += importe;
        fila.find("td:eq(11)").text("1");
        fila.css("background-color", "rgb(252, 209, 229)");   
        // Agregar el valor del id de la fila al array (si no existe)
        if (!this.idsSeleccionados_r.includes(filaId)) {
            this.idsSeleccionados_r.push(filaId);
        }
    }
    $("#segundaTabla_reporte_pagados_IA tbody th:eq(1)").text(this.totalImporte_r.toFixed(2));
    $("#segundaTabla_reporte_pagados_IA tbody th:eq(2)").text(this.totalGasto_r.toFixed(2));
    $("#segundaTabla_reporte_pagados_IA tbody th:eq(3)").text(this.totalSubtotal_r.toFixed(2));
    $("#segundaTabla_reporte_pagados_IA tbody th:eq(4)").text(this.totalTIM_r.toFixed(2));
    $("#segundaTabla_reporte_pagados_IA tbody th:eq(5)").text(this.totalTotal_r.toFixed(2));
        
    // El array idsSeleccionados ahora contendrá los ids de las filas seleccionadas
    console.log("Ids seleccionados:", this.idsSeleccionados_r);
  }

  

  imprimirhere(valor) {
    const Propietarios_ = []; // Declarar un arreglo vacío
    $("#id_propietarios tr").each(function (index) {
      // Accede al valor del atributo 'id' de cada fila
      var idFila = $(this).attr("id_contribuyente");
      Propietarios_[index] = idFila; // Agregar el valor al arreglo


    });
    const Propietarios = Propietarios_.map(function(valor) {
      return parseInt(valor, 10); // El segundo argumento 10 especifica la base numérica (decimal).
    });
    console.log(Propietarios);
    const idsSeleccionados_ = this.idsSeleccionados_r.map(function(valor) {
      return parseInt(valor, 10); // El segundo argumento 10 especifica la base numérica (decimal).
    });
    let datos = new FormData();
 /*   const carpetaContribuyente = document.querySelector('#carpeta_contribuyente');
    const idCarpeta = carpetaContribuyente.getAttribute('id_carpeta');
    this.carpeta_pago=idCarpeta; */
    console.log('codigo de carpeta del contribuyenete pagados  mlm:', predio.carpeta);  

    datos.append("carpeta",predio.carpeta);
    datos.append("id_usuario", general.iso_usuario);
    datos.append("id_area", general.iso_area);
    datos.append("id_cuenta",idsSeleccionados_);
    datos.append("propietarios",Propietarios);
    datos.append("totalImporte",this.totalImporte_r.toFixed(2));
    datos.append("totalGasto",this.totalGasto_r.toFixed(2));
    datos.append("totalSubtotal",this.totalSubtotal_r.toFixed(2));
    datos.append("totalTIM",this.totalTIM_r.toFixed(2));
    datos.append("totalTotal",this.totalTotal_r.toFixed(2));

    console.log(datos);
    $.ajax({
      url: "./vistas/print/imprimirPagados_006_742.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (rutaArchivo) {
        if(valor === 'reporte1'){
        // Establecer el src del iframe con la ruta relativa del PDF
        document.getElementById("iframe_pagados").src = 'vistas/print/' + rutaArchivo;
        }else if(valor === 'reporte2'){
          document.getElementById("iframe").src = 'vistas/print/' + rutaArchivo;
        }
      }
    });
  }
  eliminarArchivosPDF() {
    // Realiza una solicitud al servidor para eliminar archivos PDF
    fetch('ajax/controlPDF.ajax.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({}),
    })
      .then((response) => {
        if (response.status === 200) {
          console.log('Archivos PDF eliminados con éxito.');
        } else {
          console.error('Error al eliminar archivos PDF.');
        }
      })
      .catch((error) => {
        console.error('Error en la solicitud:', error);
      });
  }
}
// Crear una instancia de la clase ImpuestoCalculator
const reporte_ingresos = new Reporte_Ingresos();
// Función para manejar el clic en el encabezado "S"
$("#primeraTabla_reporte_pagados_IA thead th:eq(11)").on("click", function () {
  reporte_ingresos.manejarClicS_pagados($(this));
});

$(document).on("click", "#popimprimir_pagados", function () {
  const valor='reporte1';
  reporte_ingresos.imprimirhere(valor);
   $("#Modalimprimir_cuenta").modal("show");
});

$(document).on("click", "#popimprimir_estadoCuentapagados", function () {
  const valor='reporte2';
  reporte_ingresos.imprimirhere(valor);
 $("#Modalimprimir_cuenta").modal("show");
});
$("#primeraTabla_reporte_pagados_IA tbody tr").on("click", function () {
  reporte_ingresos.manejarClicFila_pagados($(this));
   console.log("hola");
 });
function recaudar_loadContribuyente_impuesto(page,searchClass,pagado) {
  if (event.keyCode === 13) {
  reporte_ingresos.loadContribuyenteImpuesto(page,searchClass,pagado);
  }
}


//PASAR EL VALOR DE CONTRIBUYENTE BUSCADO A PREDIOS POR GET - VALIDADO

$(document).on("click", ".btnCuenta_pagado", function () {
  let id = $(this).attr("idContribuyente_cuenta");
  reporte_ingresos.pasar_parametro_get_pagado(id);
});

$("#abrirPagosImpuestoArbitrios").click(function () {
  $("#modalPagosImpuestoArbitrios").modal("show");
});









