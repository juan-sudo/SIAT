class Prescripcion {
  constructor() {
    this.idContribuyente = null;
    this.impuesto_anual = null;
    this.base_imponible = null;
    this.impuesto_trimestral = null;
    this.gasto_emision = null;
    this.total_pagar = null;
    this.selectnum = null;

    this.totalImporte = 0;
    this.totalDescuento = 0;
    this.totalGasto = 0;
    this.totalSubtotal = 0;
    this.totalTIM = 0;
    this.totalTotal = 0;
    this.idsSeleccionados = [];
  }

    limpiar_campos(){
      $('#codigo_prescripcion').val("");
      $('#expediente_prescripcion').val("");
      $('#resolucion_prescripcion').val("");
      $('#asunto_prescripcion').val("");
    }

    limpiar_valores(){
      prescripcion.idsSeleccionados=[];
      this.totalImporte = 0;
      this.totalDescuento = 0;
      this.totalGasto = 0;
      this.totalSubtotal = 0;
      this.totalTIM = 0;
      this.totalTotal = 0;
    }
    loadContribuyente_prescripcion_filtro(page,searchClass,init_envio){
        let searchContribuyente = $("." + searchClass).val();
        let parametros = {
          action: "ajax",
          page: page,
          searchContribuyente: searchContribuyente,
          tipo: searchClass,
          init_envio:init_envio,
          dpPrescripcion: "dpPrescripcion",
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

    manejarClicS(thS) {
      const filas = $("#tablaPrescripcion tbody tr");
      const todasSeleccionadas = $("td:eq(10):contains('P')", filas).length === filas.length;
      if (todasSeleccionadas) {
        filas.each((index, fila) => {
          this.manejarClicFila($(fila));
        });
      } else {
        filas.each((index, fila) => {
          if ($("td:eq(10)", fila).text() !== "P") {
            this.manejarClicFila($(fila));
          }
        });
      }
      thS.text(todasSeleccionadas ? "S" : "S");
      
    }

    manejarClicFila(fila) {
      const importeText = fila.find("td:eq(4)").text();
      const gastoText = fila.find("td:eq(5)").text();
      const subtotalText = fila.find("td:eq(6)").text();
      const descuentoText = fila.find("td:eq(7)").text();
      const timText = fila.find("td:eq(8)").text();
      const totalText = fila.find("td:eq(9)").text();
      const estadoS = fila.find("td:eq(10)").text();
  
      const importe = parseFloat(importeText);
      const gasto = parseFloat(gastoText);
      const subtotal = parseFloat(subtotalText);
      const descuento = parseFloat(descuentoText);
      const tim = parseFloat(timText);
      const total = parseFloat(totalText);
  
      const filaId = fila.attr("id");
      
      if (estadoS === "P") {       
          this.totalGasto -= gasto;
          this.totalSubtotal -= subtotal;
          this.totalDescuento -= descuento;
          this.totalTIM -= tim;
          this.totalTotal -= total;
          this.totalImporte -= importe;
          fila.find("td:eq(10)").text("");
          fila.css("background-color", "");

          const index = this.idsSeleccionados.indexOf(filaId);
          if (index > -1) {
              this.idsSeleccionados.splice(index, 1);
          }
      } else {
          this.totalGasto += gasto;
          this.totalSubtotal += subtotal;
          this.totalDescuento += descuento;
          this.totalTIM += tim;
          this.totalTotal += total;
          this.totalImporte += importe;
          fila.find("td:eq(10)").text("P");
          fila.css("background-color", "rgb(252, 209, 229)");   

          if (!this.idsSeleccionados.includes(filaId)) {
              this.idsSeleccionados.push(filaId);
          }
      }
      console.log("Ids seleccionados:", this.idsSeleccionados);
    }

    registrarPrescripcion(datos){
    const campo1 = document.getElementById("codigo_prescripcion").value.trim();
    const campo2 = document.getElementById("expediente_prescripcion").value.trim();
    const campo3 = document.getElementById("resolucion_prescripcion").value.trim();
    const campo4 = document.getElementById("asunto_prescripcion").value.trim();
    if (!campo1 || !campo2 || !campo3 || !campo4) {
      const style = document.createElement("style");
            style.textContent = `
                .swal2-container {
                    z-index: 20000 !important;
                }
            `;
            document.head.appendChild(style);
            Swal.fire({
              icon: 'error',
              title: 'Advertencia',
              text: 'Es necesario llenar todos los campos',
              confirmButtonText: 'Entendido'
            })
  }else{
      $.ajax({
        type: 'POST',
        url: 'ajax/prescripcion.ajax.php',
        data: datos,
        success: function(respuesta) {
          if(respuesta){
            general.mostrarAlerta("success", "Operación Exitosa", "Se ha completado correctamente", { redireccion: "Prescripcion" });
            //mostrarAlerta("success", "Formulario Enviado", "Los datos se enviaron correctamente", { limpiarFormulario: "miFormulario" });
            //mostrarAlerta("info", "Atención", "Por favor verifica los datos ingresados", { callback: function() {
           //   console.log("Ejecutando función después del OK");
         // }});
          }else{
            general.mostrarAlerta("error", "Advertencia", "Hubo un problema al registrar la prescripción, inténtelo más tarde");
          }
        }
      });
    }
    }

    imprimirhere(id) {
      const Propietarios_ = id.split('-').map(Number);
      const Propietarios = Propietarios_.map(function(valor) {
        return parseInt(valor, 10); // El segundo argumento 10 especifica la base numérica (decimal).
      });
      const idsSeleccionados_ = this.idsSeleccionados.map(function(valor) {
        return parseInt(valor, 10); // El segundo argumento 10 especifica la base numérica (decimal).
      });
      let datos = new FormData();
     
      datos.append("id_usuario", general.iso_usuario);
      datos.append("id_area", general.iso_area);
      datos.append("id_cuenta",idsSeleccionados_);
      datos.append("propietarios",Propietarios);
      datos.append("totalImporte",this.totalImporte.toFixed(2));
      datos.append("totalGasto",this.totalGasto.toFixed(2));
      datos.append("totalSubtotal",this.totalSubtotal.toFixed(2));
      datos.append("totaldescuento",this.totalDescuento.toFixed(2));
      datos.append("totalTIM",this.totalTIM.toFixed(2));
      datos.append("totalTotal",this.totalTotal.toFixed(2));
      $.ajax({
        url: "./vistas/print/imprimirPrescripciones.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (rutaArchivo) {
          document.getElementById("iframePrescripcion").src = 'vistas/print/' + rutaArchivo;
  
        }
      });
    }    
}

const prescripcion = new Prescripcion()
// ----------------BUSCAR CONTRIBUYENTE---------------
function loadContribuyente_prescripcion(page, searchClass,init_envio) {
    if (event.keyCode === 13) {
        prescripcion.loadContribuyente_prescripcion_filtro(page,searchClass,init_envio);
      event.preventDefault();
    }
};
// ---------------------BUSCAR DEUDAS--------------
$(document).on('click','#btnPrescripcionDeuda', function(e){
  var formd = new FormData();
  let id = $(this).attr("idContribuyente_prescripcion")//OBTENEMOS EL VALOR DEL BOTON
  formd.append("estadoCuenta", "estadoCuenta");
  formd.append('idContribuyente',id)
  $.ajax({
    type: "POST",
    url: "ajax/estadoCuenta.ajax.php",
    data: formd,
    cache: false,
    contentType: false,
    processData: false,
    success: function(respuesta) {
      $('#estadoCuentaPrescripcion').html(respuesta)
    }
  });
  $("#modalEstadoCuentaPrescripcion").modal("show");
  $("#titulo_prescripcion").hide();
  $("#imprimirPrescripcion").hide();
  $("#titulo_Deuda").show();
  $("#prescribirDeuda").show();
  prescripcion.limpiar_valores()
  prescripcion.limpiar_campos();
  const style = document.createElement("style");
  //SUPERPONEMOS EL MODAL
  style.textContent = `
    #modalEstadoCuentaPrescripcion {
      z-index: 20000 !important;
    }
  `;
  document.head.appendChild(style);
})
// ---------------------BUSCAR PRESCRIPCIONES--------------
$(document).on('click','#btnPrescripcionReporte', function(e){
  var formd = new FormData();
  let id = $(this).attr("idContribuyente_prescripcion");
  formd.append("deudasPrescritas", "deudasPrescritas");
  formd.append('idContribuyente',id)
  $.ajax({
    type: "POST",
    url: "ajax/estadoCuenta.ajax.php",
    data: formd,
    cache: false,
    contentType: false,
    processData: false,
    success: function(respuesta) {
      $('#estadoCuentaPrescripcion').html(respuesta)
    }
  });
  $("#modalEstadoCuentaPrescripcion").modal("show");
  $("#titulo_prescripcion").show();
  $("#imprimirPrescripcion").show();
  $("#titulo_Deuda").hide();
  $("#prescribirDeuda").hide();
  $("#imprimirPrescripcion").val(id);
  prescripcion.limpiar_valores()
  const style = document.createElement("style");
  style.textContent = `
    #modalEstadoCuentaPrescripcion {
      z-index: 20000 !important;
    }
  `;
  document.head.appendChild(style);
})

$("#tablaPrescripcion tbody").on("click","tr", function () {
  prescripcion.manejarClicFila($(this));
});


$("#tablaPrescripcion").on("click","thead th:eq(10)",function () {
  prescripcion.manejarClicS($(this));
});

$("#prescribirDeuda").on("click",function () {
  //SI NO SELECCIONA O NO HAY DEUDA APARECE MENSAJE
  if(prescripcion.idsSeleccionados.length === 0 || prescripcion.idsSeleccionados[0] === 'noseleccionar'){
    if(prescripcion.idsSeleccionados.length === 0 ){    
      var text="seleccione la deuda que quiere prescribir";
    }else{
      var text="no cuenta con deuda";
    }
    const style = document.createElement("style");
      style.textContent = `
          .swal2-container {
              z-index: 20000 !important;
          }
      `;
      document.head.appendChild(style);
      Swal.fire({
        icon: 'warning',
        title: 'Advertencia',
        text: text,
        confirmButtonText: 'Entendido'
      })
  }else{
  $("#modalEstadoCuentaPrescripcion").modal("hide");
  $("#modalAgregarPrescripcion").modal("show");
  const style = document.createElement("style");
  style.textContent = `
    #modalAgregarPrescripcion {
      z-index: 20000 !important;
    }
  `;
  document.head.appendChild(style);}
});
$(".retroceder_prescripcion").on("click",function () {
  $("#modalEstadoCuentaPrescripcion").modal("show");
  $("#modalAgregarPrescripcion").modal("hide");
});
$("#btnRegistrarPrescripcion").on("click",function () {
  var form = $('#formPrescripcion').serialize();
  form += '&ids_deudas='+prescripcion.idsSeleccionados;
  form += '&registrar_prescripcion=registrar_prescripcion';
  prescripcion.registrarPrescripcion(form);
});

$(document).on("click", "#imprimirPrescripcion", function () {
  if(prescripcion.idsSeleccionados.length === 0 || prescripcion.idsSeleccionados[0] === 'noseleccionar'){
    if(prescripcion.idsSeleccionados.length === 0 ){    
      var text="seleccione la deuda";
    }else{
      var text="no cuenta con deuda";
    }
    const style = document.createElement("style");
      style.textContent = `
          .swal2-container {
              z-index: 20000 !important;
          }
      `;
      document.head.appendChild(style);
      Swal.fire({
        icon: 'warning',
        title: 'Advertencia',
        text: text,
        confirmButtonText: 'Entendido'
      })
  }else{
  let id = $(this).val();
  prescripcion.imprimirhere(id);
  $("#modalEstadoCuentaPrescripcion").modal("hide");
  const style = document.createElement("style");
  style.textContent = `
    #Modalimprimir_cuenta {
      z-index: 20000 !important;
    }
  `;
  document.head.appendChild(style);
  $("#Modalimprimir_cuenta").modal("show");
  }
});


