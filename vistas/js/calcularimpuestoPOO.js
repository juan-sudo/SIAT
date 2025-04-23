class ImpuestoCalculator {
  constructor() {
    this.idContribuyente = null;
    this.impuesto_anual = null;
    this.base_imponible = null;
    this.impuesto_trimestral = null;
    this.gasto_emision = null;
    this.total_pagar = null;
    this.selectnum = null;
    this.selectnum_arbitrio = null;
    this.filaSeleccionada_dj = null;
    this.tbody_dj = null;
    this.html = "";
    this.html_cuota = "";
    this.anio_id_dj = null;
    this.id_predio_dj = null;
    this.id_predio_la = null;
    this.catastro_dj = null;
    this.catastro_la = null;
    this.tipopredio_dj = null;
    this.tipopredio_la = null;
    this.idcontribuyente_tim = null;
    this.predios_seleccionados=[];
    const tabla_dj = document
      .getElementById("predio_dj_table")
      .getElementsByTagName("tbody")[0];
    tabla_dj.addEventListener("click", this.dobleClicFila_.bind(this));

    const tabla_la = document
      .getElementById("predio_la_table")
      .getElementsByTagName("tbody")[0];
    tabla_la.addEventListener("click", this.dobleClicFila_la.bind(this));
    //capturando el id del anio
    const selectElement = document.getElementById("selectnum_formato");
    this.anio_id_dj = selectElement.value;
    this.anioFiscaltim = null;
  }
  loadContribuyenteImpuesto(page, searchClass) {
    let perfilOculto_c = $("#perfilOculto_c").val();
    let searchContribuyente = $("." + searchClass).val();
    let parametros = {
      action: "ajax",
      searchContribuyente: searchContribuyente,
      page: page,
      tipo: searchClass,
      dpcontribuyente_impuesto: "dpcontribuyente_impuesto",
      perfilOculto_c: perfilOculto_c,
    };
    $.ajax({
      url: "vistas/tables/dataTables.php",
      data: parametros,
      beforeSend: function () {
        $(".body-contribuyente").html(loadingMessage);
      },
      success: function (data) {
        $(".body-contribuyente").html(data);
      },
      error: function () {
        $(".body-contribuyente").html(errordata);
      },
    });
  }
  calcularImpuesto() {
    const self = this;
    let datos = new FormData();
    datos.append("idContribuyente_impuesto", predio.id_propietario);
    datos.append("selectnum", this.selectnum);
    datos.append("mostrar_valor_calculado", "mostrar_valor_calculado");
    datos.append("predios_s","no");
    datos.append("predios_seleccionados","null");
    if ($("#calculo_predio_select").is(':checked')) {
      datos.append("predios_seleccionados",this.predios_seleccionados);
      datos.append("predios_s","si");
    }
    for (const pair of datos.entries()) {
      console.log(pair[0] + ", " + pair[1]);
    }

    return new Promise((resolve, reject) => {
      $.ajax({
        url: "ajax/calcular.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          self.impuesto_anual = respuesta["impuesto_anual"];
          self.base_imponible = respuesta["base_imponible"];
          self.impuesto_trimestral = respuesta["impuesto_trimestral"];
          self.gasto_emision = respuesta["gasto_emision"];
          self.total_pagar = respuesta["total_pagar"];

          $("#total_predio").text(respuesta["total_predio"]);
          $("#impuesto_anual").text(self.impuesto_anual);
          $("#predio_afecto").text(respuesta["total_predio_afecto"]);
          $("#base_imponible").text(self.base_imponible);
          $("#impuesto_trimestral").text(self.impuesto_trimestral);
          $("#gasto_emision").text(self.gasto_emision);
          $("#total_pagar").text(self.total_pagar);

          console.log(respuesta["total_predio_afecto"]);
          console.log(respuesta["total_predio"]);
          console.log(respuesta["base_imponible"]);
          console.log(respuesta["impuesto_anual"]);
          console.log(respuesta["impuesto_trimestral"]);
          console.log(respuesta["gasto_emision"]);
          console.log(respuesta["total_pagar"]);

          resolve();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error(
            "Error en el cálculo de impuesto:",
            textStatus,
            errorThrown
          );
          reject(errorThrown);
        },
      });
    }).then(() => {
      $("#anio_calcular").text(this.selectnum);
      $("#anio_recalcular").text(this.selectnum);
    });
  }

  registrarImpuesto(recalculo) {
    //const self = this;
    let datos = new FormData();
    datos.append("idContribuyente_impuesto", predio.id_propietario);
    datos.append("selectnum", this.selectnum);
    datos.append("impuesto_anual", this.impuesto_anual);
    datos.append("base_imponible", this.base_imponible);
    datos.append("impuesto_trimestral", this.impuesto_trimestral);
    datos.append("gasto_emision", this.gasto_emision);
    datos.append("total_pagar", this.total_pagar);
    datos.append("registrar_impuesto", "registrar_impuesto");
    datos.append("recalcular", recalculo);
   
    if ($("#calculo_predio_select").is(':checked')&& this.predios_seleccionados.length > 0) {
      datos.append("predio_select", "si");
      datos.append("predios_seleccionados",this.predios_seleccionados);
    }
    else{
      datos.append("predios_seleccionados","null");
      datos.append("predio_select", "no");
    }
  
    for (const pair of datos.entries()) {
      console.log(pair[0] + ", " + pair[1]);
    }
    $.ajax({
      url: "ajax/calcular.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function() {
        $(".cargando").html(loadingMessage_s);
        $("#modal_cargar").modal("show");
      },
      success: function (respuesta) {
        if (respuesta.tipo === "correcto") {
          $("#modal_cargar").modal("hide");
          $("#respuestaAjax").show(); // Mostrar el elemento #error antes de establecer el mensaje
          $("#respuestaAjax").html(respuesta.mensaje);
          $("#modalCalcularImpuesto_si_no").modal("hide");
          $("#modalRecalcularImpuesto_si_no").modal("hide");
          setTimeout(function () {
            $("#respuestaAjax").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
            // Recargar la página manteniendo los parámetros actuales
          }, 10000); // 3000 milisegundos = 3 segundos (ajusta según tus preferencias)
        } else {
          $("#modal_cargar").modal("hide");
          $("#respuestaAjax").show(); // Mostrar el elemento #error antes de establecer el mensaje
          $("#respuestaAjax").html(respuesta.mensaje);
          $("#modalCalcularImpuesto_si_no").modal("hide");
          $("#modalRecalcularImpuesto_si_no").modal("show");
          setTimeout(function () {
            $("#respuestaAjax").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
            // Recargar la página manteniendo los parámetros actuales
          }, 10000); // 3000 milisegundos = 3 segundos (ajusta según tus preferencias)
        }
      },
      error: function() {
        $("#modal_cargar").text("Error al cargar el archivo.");
    }
    });
  }

  reiniciarValores() {
    // Reiniciar los valores en la interfaz
    $("#total_predio").text("");
    $("#impuesto_anual").text("");
    $("#predio_afecto").text("");
    $("#base_imponible").text("");
    $("#impuesto_trimestral").text("");
    $("#gasto_emision").text("");
    $("#total_pagar").text("");
  }

  mostrarPredios(llamadaDesde) {
    let datos = new FormData();
    datos.append("idContribuyente_impuesto", predio.id_propietario);
    if (llamadaDesde === "impuesto") {
      datos.append("selectnum", this.selectnum);
    } else {
      datos.append("selectnum", this.selectnum_arbitrio);
    }

    datos.append("lista_predio_arbitrios", "null");
    for (const pair of datos.entries()) {
      console.log(pair[0] + ", " + pair[1]);
    }
    // MOSTRAR PREDIOS DEL CALCULO
    $.ajax({
      url: "ajax/predio.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $("#predios_impuesto").html(loadingMessage);
        $("#predios_hr").html(loadingMessage);
        $("#predios_dj").html(loadingMessage);
      },
      success: function (respuesta) {
        var divContainer = document.getElementById("tablapisos");
        this.html = "";
        divContainer.innerHTML = this.html;
        $("#predios_impuesto").html(respuesta);
        $("#predios_hr").html(respuesta);
        $("#predios_dj").html(respuesta);
      },
      error: function () {
        $("#predios_impuesto").html(errordata);
        $("#predios_hr").html(errordata);
        $("#predios_dj").html(errordata);
      },
    });
  }

  mostrarPredios_LA() {
    let datos = new FormData();
    datos.append("idContribuyente_impuesto", predio.id_propietario);
    datos.append("selectnum", this.selectnum_arbitrio);
    datos.append("lista_predio_arbitrios", "lista_predio_arbitrios");
    for (const pair of datos.entries()) {
      console.log(pair[0] + ", " + pair[1]);
    }
    // MOSTRAR PREDIOS DEL CALCULO
    $.ajax({
      url: "ajax/predio.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $("#predios_la").html(loadingMessage);
      },
      success: function (respuesta) {
        var divContainer_ = document.getElementById("tablacuotas");
        this.html_cuota = "";
        divContainer_.innerHTML = this.html_cuota;
        $("#predios_la").html(respuesta);
      },
      error: function () {
        $("#predios_la").html(loadingMessage);
      },
    });
  }

  cargarContribuyenteImpuesto(llamadaDesde) {
    let datos = new FormData();
    datos.append("idContribuyente_impuesto", predio.id_propietario);
    if (llamadaDesde === "impuesto") {
      datos.append("selectnum", this.selectnum);
    } else {
      datos.append("selectnum", this.selectnum_arbitrio);
    }
    datos.append("recaudacion_lista_contri", "recaudacion_lista_contri");
    datos.append("lista_predio_arbitrios", "null");
    for (const pair of datos.entries()) {
      console.log(pair[0] + ", " + pair[1]);
    }
    $.ajax({
      url: "ajax/contribuyente.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        if (llamadaDesde == "impuesto") {
          $("#contribuyentes-calcular").html(respuesta);
        } else if (llamadaDesde == "impuestotim") {
          $("#contribuyentes-calcularTim").html(respuesta);
        } else {
          $("#contribuyentes-calcular-formato").html(respuesta);
        }
      },
    });
    // MOSTRAR PREDIOS DEL CALCULO
    $.ajax({
      url: "ajax/predio.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $("#predios_impuesto").html(loadingMessage);
        $("#predios_hr").html(loadingMessage);
        $("#predios_dj").html(loadingMessage);
      },
      success: function (respuesta) {
        $("#predios_impuesto").html(respuesta);
        $("#predios_hr").html(respuesta);
        $("#predios_dj").html(respuesta);
      },
      error: function () {
        $("#predios_impuesto").html(errordata);
        $("#predios_hr").html(errordata);
        $("#predios_dj").html(errordata);
      },
    });
  }
  tablapisos() {
    var divContainer = document.getElementById("tablapisos");
    this.html =
      '<table class="table table-bordered miTbody_formatos"><caption>Lista de Pisos</caption>' +
      "<thead>" +
      "<tr>" +
      "<th>Catastro</th>" +
      "<th># Piso</th>" +
      "<th>A.Const.</th>" +
      "<th>Val.Const.</th>" +
      "<th>Val.Edifica</th>" +
      "</tr>" +
      "</thead>" +
      '<tbody id="listaPisos">' +
      "</tbody>" +
      // Aqui Aparecen los Pisos del Predio
      "</table>";
    divContainer.innerHTML = this.html;
  }
  tablacuotas() {
    var divContainer = document.getElementById("tablacuotas");
    this.html_cuota =
      '<table class="table-container" id="predio_cuotas_la">' +
      "<caption>Cuotas de Vencimiento de LA (Liquidacion Arbitrios)</caption>" +
      "<thead>" +
      "<th>Cuota</th>" +
      "<th>Vencimiento</th>" +
      "<th>Monto Absoluto</th>" +
      "<th>Gastos de Emision</th>" +
      "<th>Ttotal a Pagar</th>" +
      "</thead>" +
      '<tbody id="cuotas">' +
      // Aqui Aparecen los Pisos del Predio
      "</tbody>" +
      "</table>";
    divContainer.innerHTML = this.html_cuota;
  }

  dobleClicFila_(event) {
    const fila = event.target.closest("tr");
    if (fila === null) return;

    this.catastro_dj = fila.getAttribute("id_catastro");
    this.tipopredio_dj = fila.getAttribute("id_tipo");
    this.id_predio_dj = fila.getAttribute("id_predio");
    if (this.catastro_dj === "nulo") {
      return; // Si el atributo "id_catastro" es nulo, no hace nada
    }
    if (this.filaSeleccionada_dj !== null) {
      this.filaSeleccionada_dj.style.backgroundColor = "";
    }
    this.filaSeleccionada_dj = fila;
    console.log('Valor del atributo "id_catastro":', this.catastro_dj);
    console.log('Valor del atributo "id_predio":', this.id_predio_dj);
    this.filaSeleccionada_dj.style.backgroundColor = "rgb(255, 248, 167)";
    const pisos = new Pisoclass(); // Crea una instancia de la clase
    this.tablapisos();
    $("#anio_formato").text(this.selectnum_arbitrio);
    pisos.MostrarPisos(this.catastro_dj, this.anio_id_dj);
    $("#modalImprimirFormato_dj_si_no").modal("show");
  }
  dobleClicFila_la(event) {
    const fila = event.target.closest("tr");
    if (fila === null) return;
    let datos = new FormData();
    this.catastro_la = fila.getAttribute("id_catastro");
    this.tipopredio_la = fila.getAttribute("id_tipo");
    this.id_predio_la = fila.getAttribute("id_predio");
    if (this.catastro_dj === "nulo") {
      return; // Si el atributo "id_catastro" es nulo, no hace nada
    }
    if (this.filaSeleccionada_dj !== null) {
      this.filaSeleccionada_dj.style.backgroundColor = "";
    }
    datos.append("id_predio", this.id_predio_la);
    datos.append("idContribuyente_impuesto", predio.id_propietario);
    datos.append("selectnum", this.selectnum_arbitrio);
    datos.append("cuotas_vencimiento_la", "cuotas_vencimiento_la");
    this.catastro_la = fila.getAttribute("id_catastro");
    this.filaSeleccionada_dj = fila;
    this.filaSeleccionada_dj.style.backgroundColor = "rgb(255, 248, 167)";
    console.log(datos);
    $("#anio_formato_la").text(this.selectnum_arbitrio);
    $("#modalImprimirFormato_la_si_no").modal("show");
    this.tablacuotas();
    // CUOTAS DE VECNIMIENTO
    $.ajax({
      url: "ajax/calcular.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        var divContainer = document.getElementById("cuotas");
        divContainer.innerHTML = respuesta;
      },
    });
  }
  mostrarEstadoCuentaTim(anioFiscalTim, idcontribuyente_tim) {
    let datos = new FormData();
    datos.append("anioFiscalTim", anioFiscalTim);
    datos.append("idContribuyente_idc", idcontribuyente_tim);
    datos.append("estadoCuentaTim", "estadoCuentaTim");

    const cuerpoTabla = document.getElementById("tbEstadoCuentaContribuyente");
    const filas = cuerpoTabla.getElementsByTagName("tr");
    while (filas.length > 0) {
      cuerpoTabla.deleteRow(0); // Elimina la primera fila de la tabla
    }
    // for (const pair of datos.entries()) {
    //   console.log(pair[0] + ", " + pair[1]);
    // }
    $.ajax({
      url: "ajax/tim.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        let porcentajeTim;
        if (respuesta === "") {
          let fila = cuerpoTabla.insertRow();
          fila.innerHTML = `<td class="text-center" colspan='10' style='text-align:center;'>No registra Deuda</td>`;
        } else {
          //console.log(respuesta);
          respuesta = JSON.parse(respuesta);
          respuesta.forEach((value, index) => {
            console.log(respuesta);
            if (index>0) {
              // Ignora el primer elemento (índice 0)
              let fila = cuerpoTabla.insertRow();
              fila.innerHTML = `<td class="text-center">${value.Tipo_Tributo}</td>
                                <td class="text-center">IMP.PREDIAL</td>
                                <td class="text-center">${value.Anio}</td>
                                <td class="text-center">${value.Periodo}</td>                
                                <td class="text-center">${value.Importe}</td>
                                <td class="text-center">${value.Gasto_Emision}</td>
                                <td class="text-center">${value.TIM_Aplicar}</td>
                                <td class="text-center">${value.Total}</td>
                                <td class="text-center">${value.Descuento}</td>
                                <td class="text-center">${value.Total_Aplicar}</td>`;
            }
            if (index===0) {
              porcentajeTim = value.Porcentaje;
            }
          });
          $("#tasaTim").val(porcentajeTim);
        }
      },
    });
  }
  calcularTim(anioFiscalTim, idcontribuyente_tim) {
    let datos = new FormData();
    datos.append("anioFiscalTim", anioFiscalTim);
    datos.append("idContribuyente_idc", idcontribuyente_tim);
    datos.append("calculartim", "calculartim");

    $.ajax({
      url: "ajax/tim.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        console.log(respuesta);
        if (respuesta.tipo === "correcto") {
          $("#respuestaAjax_srm").show();
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 3000);
        } else {
          $("#respuestaAjax_srm").show();
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 5000);
        }
      },
    });
  }
}
// Crear una instancia de la clase ImpuestoCalculator
const impuestoCalculator = new ImpuestoCalculator();

function loadContribuyente_impuesto_(page, searchClass) {
  
  //carga los contribuyente al seleccionar al contribuyente
  if (event.keyCode === 13) {
    impuestoCalculator.loadContribuyenteImpuesto(page, searchClass);
    event.preventDefault();
  }
}
function loadPredio_impuesto() {
  var selectElement = document.getElementById("selectnum_impuesto");
  impuestoCalculator.selectnum =selectElement.options[selectElement.selectedIndex].text;
  //muestra datos para calcular impuesto
  impuestoCalculator.mostrarPredios("impuesto");
  impuestoCalculator.reiniciarValores();
  impuestoCalculator.predios_seleccionados=[];
  $('#calculo_predio_select').prop('checked', false).change();
  $('.action-column').hide();

}
function loadPredio_formato() {
  var selectElement = document.getElementById("selectnum_formato");
  impuestoCalculator.selectnum_arbitrio =
    selectElement.options[selectElement.selectedIndex].text;
  impuestoCalculator.anio_id_dj =
    selectElement.options[selectElement.selectedIndex].value;
  //muestra predios para imprimir los formatos
  impuestoCalculator.mostrarPredios("formato");
  impuestoCalculator.mostrarPredios_LA();
}
// Eventos
//carga los datos del popup calcular

$(document).ready(function () {

  var selectElement = document.getElementById("selectnum_impuesto");
  impuestoCalculator.selectnum =selectElement.options[selectElement.selectedIndex].text;
  var selectElement_a = document.getElementById("selectnum_formato");
  impuestoCalculator.selectnum_arbitrio =selectElement_a.options[selectElement_a.selectedIndex].text;


//carga los datos de dj,hr,la
$(document).on("click", ".btnImprimir_cartilla", function () {
  impuestoCalculator.idContribuyente = $(this).attr("idContribuyente_formato");
  impuestoCalculator.cargarContribuyenteImpuesto("formato");
  impuestoCalculator.mostrarPredios_LA();
});

//muestra el valor del impuesto calculado pero no lo guarda
$(document).on("click", ".boton_calcular", function () {
  impuestoCalculator.calcularImpuesto()
    .then(() => {
      $("#modalCalcularImpuesto_si_no").modal("show");
    })
    .catch((error) => {
      console.error("Error al calcular impuesto:", error);
      // Manejo de errores si es necesario
    });
});
//registra el impuesto calculado
$(document).on("click", ".registrar_impuesto_arbitrios", function () {
  var recalculo = "no";
  impuestoCalculator.registrarImpuesto(recalculo);
});
//registra el impuesto recalculado
$(document).on("click", ".recalcular_impuesto_arbitrios", function () {
  var recalculo = "si";
  impuestoCalculator.registrarImpuesto(recalculo);
});
//confirmar la impresion del hr
document
  .getElementById("list-home-list")
  .addEventListener("click", function () {
    $("#modalImprimirFormato_hr_si_no").modal("show");
  });

let elemento;
//let anioFiscalTim;
$(document).on("click", ".btnCalcularTim_img", function () {
  impuestoCalculator.idContribuyente = $(this).attr("idContribuyente_tim");
  impuestoCalculator.cargarContribuyenteImpuesto("impuestotim");
  $("#modal_predio_propietario").modal("hide");
  elemento = document.getElementById("p_img");
  impuestoCalculator.idcontribuyente_tim = predio.id_propietario;
  console.log(impuestoCalculator.idcontribuyente_tim);
});
// $(document).ready(function () {
$(document).on("change", "#anioFiscalTim", function () {
  impuestoCalculator.anioFiscaltim = $("#anioFiscalTim option:selected").text();
  impuestoCalculator.mostrarEstadoCuentaTim(impuestoCalculator.anioFiscaltim,predio.id_propietario);
});

$(document).on("click", "#btnCalcularTim", function () {
  impuestoCalculator.calcularTim(impuestoCalculator.anioFiscaltim,predio.id_propietario);
  impuestoCalculator.mostrarEstadoCuentaTim(impuestoCalculator.anioFiscaltim,predio.id_propietario);
});

$(document).on("click", "#salirModalTim", function () {
  $("#modalCalcularTim").modal("hide");
});

$(document).on("click", "#calculo_predio_select", function () {
  if ($(this).is(':checked')) {
  $("#modal_seleccion_predio_select").modal("show");
  }
  else{
    $('.action-column').hide();
  }
  
});
$(document).on("click", ".mostrar_predios_seleccionados_no", function () {
  $('#calculo_predio_select').prop('checked', false).change();
  $("#modal_seleccion_predio_select").modal("hide");
  $('.action-column').hide();
});


$(document).on("click", ".mostrar_predios_seleccionados", function () {
  //$('#calculo_predio_select').prop('checked', false).change();
  $("#modal_seleccion_predio_select").modal("hide");
  if ($("#calculo_predio_select").is(':checked')) {
    $('.action-column').show();
} else {
    $('.action-column').hide();
}
});

$(document).on("click", ".boton_calcular_no", function () {

  if ($("#calculo_predio_select").is(':checked')) {
    $('#calculo_predio_select').prop('checked', false).change();
    $('.action-column').hide();
} else {
   
}
});

$(document).on('change', '#select_predio_calcular', function() {
  const idPredio = $(this).data('id');
  if ($(this).is(':checked')) {
    // Si el checkbox se selecciona, agrega el id al array
    if (!impuestoCalculator.predios_seleccionados.includes(idPredio)) {
      impuestoCalculator.predios_seleccionados.push(idPredio);
    }
  } else {
    // Si el checkbox se deselecciona, remueve el id del array
    impuestoCalculator.predios_seleccionados = impuestoCalculator.predios_seleccionados.filter(item => item !== idPredio);
  }
  console.log(impuestoCalculator.predios_seleccionados);
});


$(".btnCalcular_impuesto").on("click", function (e) {
  // impuestoCalculator.idContribuyente = $(this).attr("idContribuyente_predio");
  console.log("ejcuto PARA VERIFICAR LOL");
  impuestoCalculator.cargarContribuyenteImpuesto("impuesto");
  $("#modalCalcularImpuesto").modal("show");
 });

});