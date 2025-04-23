class OrdenPagoClass {
    constructor() {
     this.fechafiltro=null;
     this.tipo_tributo_orden=null;
     this.anio_orden=null  
     this.totalDeuda_=null;
    }


    ordenes_pago(){

      let self=this;
      let datos = new FormData();
      var anoSeleccionado = $('#anio_orden option:selected').text();
      
      this.anio_orden=anoSeleccionado;
      this.tipo_tributo_orden = document.getElementById("select_tributo_orden").value;
      datos.append("id_propietarios", predio.Propietarios);
    //  datos.append("tipo_tributo", this.tipo_tributo_orden);
     // datos.append("anio", this.anio_orden);
      datos.append("estado_cuenta_ordenes", "estado_cuenta_ordenes");

      for (let pair of datos.entries()) {
          console.log(pair[0] + ': ' + pair[1]);
      }

      $.ajax({
        url: "ajax/caja.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            $(".estadocuentacaja").html(respuesta);
            console.log("llego aquio--------------", respuesta);
    
            // Verificar si 'respuesta.campos' existe y tiene datos
            if (respuesta.totales && respuesta.totales.length > 0) {
                var content = '';
                self.totalDeuda_ = respuesta.totales[0];
                console.log("total_total mlm " + self.totalDeuda_.Importe);
    
                 // Crear un conjunto para almacenar los números de orden ya agregados
                    let ordenesAgregados = new Set();
                    content += '<option>' + 'Historial de orden de pago' + '</option>';

                // Iterar sobre los elementos de 'respuesta.campos' si existen
                respuesta.totales.forEach(function(value) {
                  console.log("Agregando opción para Orden número:", value.Numero_Orden);
          
                  // Verificar si el número de orden ya fue agregado 
                  if (!ordenesAgregados.has(value.Numero_Orden)) {

                    let numeroOrdenFormateado = value.Numero_Orden.toString().padStart(3, '0');

                      //content += '<option value="' + value.Numero_Orden + value.anio_actual+'">' + 'Orden de pago ' + value.Numero_Orden + '</option>';
                      content += '<option value="' + numeroOrdenFormateado + '-' + value.anio_actual + '">' + 
            'Orden de pago ' + numeroOrdenFormateado + ' - ' + value.anio_actual + '</option>';
        
                      ordenesAgregados.add(value.Numero_Orden); // Agregar el número de orden al conjunto
                  }
              });
    
                // Verifica si se generaron opciones
                console.log("Contenido generado:", content);
    
                // Si 'content' tiene datos, se actualiza el HTML del select
                if (content) {
                    $(".historialOrdenPago").html(content);
                } else {
                    console.log("No se generaron opciones.");
                }
            } else {
                console.log("No se encontraron datos en 'respuesta.campos'. Verifica la respuesta del servidor.");
            }
    
            // Actualizar los totales (esto ya lo tienes bien)
            $("#importe_o").text(self.totalDeuda_.Importe);
            $("#gasto_o").text(self.totalDeuda_.Gasto_Emision);
            $("#subtotal_o").text(self.totalDeuda_.Saldo);
            $("#tim_o").text(self.totalDeuda_.TIM_Aplicar);
            $("#total_o").text(self.totalDeuda_.Total_Aplicar);
        },
        error: function(xhr, status, error) {
            console.log("Error en la solicitud AJAX:", status, error);
        }
    });
    



    }



    muestra_deuda(){
      let self=this;
            let datos = new FormData();
            var anoSeleccionado = $('#anio_orden option:selected').text();
            
            this.anio_orden=anoSeleccionado;
            this.tipo_tributo_orden = document.getElementById("select_tributo_orden").value;
            datos.append("id_propietarios", predio.Propietarios);
            datos.append("tipo_tributo", this.tipo_tributo_orden);
            datos.append("anio", this.anio_orden);
            datos.append("estado_cuenta_orden", "estado_cuenta_orden");

            for (let pair of datos.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            $.ajax({
              url: "ajax/caja.ajax.php",
              method: "POST",
              data: datos,
              cache: false,
              contentType: false,
              processData: false,
              success: function (respuesta) {
                $(".estadocuentacaja").html(respuesta);
                console.log(respuesta);
                
                var content = '';
                self.totalDeuda_ = respuesta.totales[0];
                console.log("total_total mlm"+self.totalDeuda_.Importe);
                respuesta.campos.forEach(function(value) {
                  var tributo = (value['Tipo_Tributo'] == '006') ? 'Imp. Predial' : 'Arb. Municipal';
                  content += '<tr id="' + value['Id_Estado_Cuenta_Impuesto'] + '">';
                  content += '<td class="text-center">' + value['Tipo_Tributo'] + '</td>';
                  content += '<td class="text-center">' + tributo + '</td>';
                  content += '<td class="text-center">' + value['Anio'] + '</td>';
                  content += '<td class="text-center">' + value['Periodo'] + '</td>';
                  content += '<td class="text-center">' + value['Importe'] + '</td>';
                  content += '<td class="text-center">' + value['Gasto_Emision'] + '</td>';
                  content += '<td class="text-center">' + value['Saldo'] + '</td>';
                  content += '<td class="text-center">' + value['TIM_Aplicar'] + '</td>';
                  content += '<td class="text-center">' + value['Total_Aplicar'] + '</td>';
                });
              
                $(".estadocuentaorden").html(content);
              
                // Actualizar los totales
            
                $("#importe_o").text(self.totalDeuda_.Importe);
                $("#gasto_o").text(self.totalDeuda_.Gasto_Emision);
                $("#subtotal_o").text(self.totalDeuda_.Saldo);
                $("#tim_o").text(self.totalDeuda_.TIM_Aplicar);
                $("#total_o").text(self.totalDeuda_.Total_Aplicar);
                
              }
              
            });
          
    }





    imprimir_orden() {
      let datos = new FormData();
      datos.append("propietarios",predio.Propietarios);
      datos.append("tipo_tributo", this.tipo_tributo_orden);
      datos.append("anio", this.anio_orden);

      datos.append("importe",this.totalDeuda_.Importe);
      datos.append("gasto", this.totalDeuda_.Gasto_Emision);
      datos.append("subtotal", this.totalDeuda_.Saldo);
      datos.append("tim", this.totalDeuda_.TIM_Aplicar);
      datos.append("total", this.totalDeuda_.Total_Aplicar);
      for (let pair of datos.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }
      if(this.tipo_tributo_orden==='006'){
      $.ajax({
          url: "./vistas/print/imprimirOrdenPago.php",
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
              document.getElementById("iframe_orden_pago").src = 'vistas/print/' + rutaArchivo;
              $("#Modal_Orden_Pago").modal("show");
          },
          error: function() {
              $("#modal_cargar").text("Error al cargar el archivo.");
          }
      });
    }
    else{
      $.ajax({
        url: "./vistas/print/imprimirDeterminacion.php",
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
            document.getElementById("iframe_orden_pago").src = 'vistas/print/' + rutaArchivo;
            $("#Modal_Orden_Pago").modal("show");
        },
        error: function() {
            $("#modal_cargar").text("Error al cargar el archivo.");
        }
    });
    }
  }


  //MOSTRAR ORDEN DE PAGO

  imprimir_orden_historial(selectedOption) {


    let datos = new FormData();
    datos.append("propietarios",predio.Propietarios);
    datos.append("tipo_tributo", this.tipo_tributo_orden);
    datos.append("anio", this.anio_orden);

    datos.append("importe",this.totalDeuda_.Importe);
    datos.append("gasto", this.totalDeuda_.Gasto_Emision);
    datos.append("subtotal", this.totalDeuda_.Saldo);
    datos.append("tim", this.totalDeuda_.TIM_Aplicar);
    datos.append("total", this.totalDeuda_.Total_Aplicar);
    datos.append("total", this.totalDeuda_.Total_Aplicar);

    datos.append("numero_orden_seleccionado", selectedOption);  // Pasar solo el número de la orden





    for (let pair of datos.entries()) {
      console.log(pair[0] + ': ' + pair[1]);
  }
    if(this.tipo_tributo_orden==='006'){
    $.ajax({
        url: "./vistas/print/imprimirOrdenPagoHistorial.php",
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
            document.getElementById("iframe_orden_pago").src = 'vistas/print/' + rutaArchivo;
            $("#Modal_Orden_Pago").modal("show");
        },
        error: function() {
            $("#modal_cargar").text("Error al cargar el archivo.");
        }
    });
  }
  else{
    $.ajax({
      url: "./vistas/print/imprimirDeterminacion.php",
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
          document.getElementById("iframe_orden_pago").src = 'vistas/print/' + rutaArchivo;
          $("#Modal_Orden_Pago").modal("show");
      },
      error: function() {
          $("#modal_cargar").text("Error al cargar el archivo.");
      }
  });
  }
}


//ELIMINAR ORDEN DE COMPRA



eliminar_orden_compra(numero_orden,anio) {
 
 
  let datos = new FormData();


  datos.append("numero_orden_seleccionado_e", numero_orden);  // Pasar solo el número de la orden
  datos.append("anio", anio);  // Pasar solo el número de la orden
  
  datos.append("eliminar_orden_pago", "eliminar_orden_pago");  // Pasar solo el número de la orden

  


  for (let pair of datos.entries()) {
    console.log(pair[0] + ': ' + pair[1]);
}
  if(this.tipo_tributo_orden==='006'){
  $.ajax({
      url: "ajax/predio.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
     
      success: function(response) {
        
     console.log("eliminado exitoxzamente un ordne de pago>>>>")
      },
      error: function() {
          $("#modal_cargar").text("Error al cargar el archivo.");
      }
  });
}

}




}

  const orden_pago = new OrdenPagoClass();
  
  //CARGA AUTOMATICA DE NUERO ORDEN
  $('#modalOrdenPago').on('show.bs.modal', function () {

    var area = document.getElementById('mySpan_area').getAttribute('iso_area');
//console.log("El área es: " + area);
    // Llama a la función que carga los datos al abrir el modal
    document.getElementById('area_oculta').value = area;

    orden_pago.ordenes_pago();
});

 
  $("#abrirOrdenPago").click(function () {
      orden_pago.muestra_deuda();
      $("#modalOrdenPago").modal("show");
  });


  // RESTABLECER CUANDO SE CIERRA ORDEN DE PAGO
$('#modalOrdenPago').on('hidden.bs.modal', function () {
  $('#select_tributo_orden_h').val('');
  $('#modificarBtn').hide();
  $('#borrarBtn').hide();
});


  $(document).on("change", "#anio_orden", function () {
    orden_pago.muestra_deuda();
  });


  $(document).on("change", "#select_tributo_orden", function () {
    orden_pago.muestra_deuda();
  });



$(document).on("click", ".btnOrdenPago", function () {
    $('#modalImprimir_ordenpago_si_no').modal('show');
});




$(document).on("click", ".print_orden_pago", function () {
  $('#modalImprimir_ordenpago_si_no').modal('hide');
  orden_pago.imprimir_orden();

});

//CERRAR EL JFRAME DE ORDEN DE PAGO
$(document).on("click", ".cerrar-modal", function () {
  // Cerrar el modal de orden de pago
  $('#Modal_Orden_Pago').modal('hide'); // Cierra el modal
  // Ejecutar la función de imprimir orden
  orden_pago.ordenes_pago();

});

//CERRAR EL MODAL ORDEN PAGO PDF CON BOTN SCAPE
$(document).on("keydown", function(event) {
  if (event.key === "Escape") {
    // Cerrar el modal de orden de pago
    $('#Modal_Orden_Pago').modal('hide'); // Cierra el modal
    // Ejecutar la función de imprimir orden
    orden_pago.ordenes_pago(); // Si deseas ejecutar esta función al cerrar el modal
  }
});



document.addEventListener("DOMContentLoaded", function () {
  // Obtener el <select> y los botones
  const selectElement = document.getElementById("select_tributo_orden_h");
  const modificarBtn = document.getElementById("modificarBtn");
  const borrarBtn = document.getElementById("borrarBtn");

  // Asegurarse de que los botones estén ocultos inicialmente
  modificarBtn.style.display = "none";
  borrarBtn.style.display = "none";

  // Evento change para el <select>
  selectElement.addEventListener("change", function () {
      const selectedValue = selectElement.value; // Obtener el valor seleccionado

      // Obtener el valor del área desde el campo oculto
      var area = document.getElementById('area_oculta').value;
      console.log("El área es ahora desde modal: " + area);  // Verificar el valor del área

      // Verificar si se seleccionó una opción diferente a 'Historial de orden de pago'
      if (selectedValue !== 'Historial de orden de pago' && selectedValue !== '') {
          // Si se selecciona una opción válida (diferente de 'Historial de orden de pago'), mostrar los botones
          modificarBtn.style.display = "inline-block";

          // Verificar si el área es "OFICINA DE EJECUCIÓN COACTIVA" y mostrar el botón de borrar
          if (area === "OFICINA DE EJECUCION COACTIVA") {
              borrarBtn.style.display = "inline-block";
          }
      } else {
          // Si no se selecciona ninguna opción válida (o 'Historial de orden de pago'), ocultar los botones
          modificarBtn.style.display = "none";
          borrarBtn.style.display = "none";
      }
  });
});



// // SELECATHISTORAL DE ORDEN DE PAGO
// document.addEventListener("DOMContentLoaded", function () {
//   // Obtener el <select> y los botones
//   const selectElement = document.getElementById("select_tributo_orden_h");
//   const modificarBtn = document.getElementById("modificarBtn");
//   const borrarBtn = document.getElementById("borrarBtn");

//   // Obtener el valor de 'iso_area' desde el <span> con id 'mySpan_area'

  
//     // Asegurarse de que los botones estén ocultos inicialmente
//     modificarBtn.style.display = "none";
//     borrarBtn.style.display = "none";
 
//   // Evento change para el <select>
//   selectElement.addEventListener("change", function () {
//       const selectedValue = selectElement.value; // Obtener el valor seleccionado
//       var area = document.getElementById('area_oculta').value;
//         console.log("El área es ahora: " + area);  // Verificar el valor del área

//       // Verificar si se seleccionó una opción diferente a 'Historial de orden de pago'
//       if (selectedValue !== 'Historial de orden de pago' && selectedValue !== '') {
//           // Si se selecciona una opción válida (diferente de 'Historial de orden de pago'), mostrar los botones
//           modificarBtn.style.display = "inline-block";
          
//           // Verificar si el área es "OFICINA DE EJECUCIÓN COACTIVA" y mostrar el botón de borrar
//           if (area === "OFICINA DE EJECUCIÓN COACTIVA") {
//               borrarBtn.style.display = "inline-block";
//           }
//       } else {
//           // Si no se selecciona ninguna opción válida (o 'Historial de orden de pago'), ocultar los botones
//            // Si no se selecciona ninguna opción válida, ocultar los botones
//            modificarBtn.style.display = "none";
//            borrarBtn.style.display = "none";
//       }
//   });
// });


// Función para el botón "Mostrar"
// function modificarOpcion() {
//   const select = document.getElementById("select_tributo_orden_h");
//   const selectedOption = select.options[select.selectedIndex];
//   if (selectedOption.value) {
//       alert("Mostrar opción: " + selectedOption.text);
//   } else {
//       alert("Por favor, selecciona una opción.");
//   }
// }

// Función para el botón "Borrar"
function borrarOpcion() {
  const select = document.getElementById("select_tributo_orden_h");
  const selectedOption = select.options[select.selectedIndex];
  if (selectedOption.value) {
      select.remove(select.selectedIndex);
      alert("Opción eliminada: " + selectedOption.text);
  } else {
      alert("Por favor, selecciona una opción para borrar.");
  }
}

//MOSATRAR ORDEN DE COMPRA
$(document).on("click", ".mostrar-btn", function () {
 // $('#modalImprimir_ordenpago_si_no').modal('hide');
 // Obtener el valor de la opción seleccionada
 let selectedOption = $('#select_tributo_orden_h').val();  // Aquí obtenemos el valor del select
    
 orden_pago.imprimir_orden_historial(selectedOption);

});


// MOSATRAR EL BOTON PARA ELIMINAR EL ORDEN DE PAGO
$(document).on("click", "#borrarBtn", function () {
  // Mostrar el modal de confirmación
  $('#modalEliminar_ordenpago_si_no').modal('show');

  
  
  // Obtener el valor de la opción seleccionada (por ejemplo, "3-2025")
  let selectedOption = $('#select_tributo_orden_h').val();  
  

  // Separar el valor de 'numero_orden' y 'año'
  let [numero_orden, anio] = selectedOption.split('-');
  
  // Guardar los datos en el modal para usarlo al confirmar
  $('#modalEliminar_ordenpago_si_no').data('numero_orden', numero_orden);
  $('#modalEliminar_ordenpago_si_no').data('anio', anio);
  
  // Actualizar el contenido dinámico del modal con el año
  $('#anio_formato').text(anio);
});

// CONFIRMAR EL BOTON ELIMINAR PARA ELIMINAR
$(document).on("click", ".eliminar_orden_pago_si", function () {
  // Recuperar los datos del modal
  let numero_orden = $('#modalEliminar_ordenpago_si_no').data('numero_orden');

  numero_orden = parseInt(numero_orden);  // Esto eliminará los ceros a la izquierda

  let anio = $('#modalEliminar_ordenpago_si_no').data('anio');

  console.log("Numero de orden quitado 0", numero_orden);

  // Llamar a la función para eliminar la orden de pago
  orden_pago.eliminar_orden_compra(numero_orden, anio);

  // Cerrar el modal
  $('#modalEliminar_ordenpago_si_no').modal('hide');
});


// $(document).on("click", ".eliminar_btn_o", function () {
  
//    $('#modalEliminar_ordenpago_si_no').modal('hide');
   
//   // Obtener el valor de la opción seleccionada
//   let selectedOption = $('#select_tributo_orden_h').val();  // Aquí obtenemos el valor del select
//   console.log("has hecho click aqui",selectedOption )
//     // Separar el valor de 'numero_orden' y 'año'
//     let [numero_orden, anio] = selectedOption.split('-');
    
//   //orden_pago.eliminar_orden_compra(selectedOption);
//   orden_pago.eliminar_orden_compra(numero_orden, anio);
 
//  });
 


  