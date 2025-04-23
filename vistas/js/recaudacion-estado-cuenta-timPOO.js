

class Recaudacion {

  debugger; 
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
    this.carpeta=null;

    //IMPUESTO PREDIAL
    this.totalImporteI = 0;
    this.totalDescuentoI = 0;
    this.totalGastoI = 0;
    this.totalSubtotalI = 0;
    this.totalTIMI = 0;
    this.totalTotalI = 0;

     //ARBITRIO MONICIPAL
     this.totalImporteA = 0;
     this.totalDescuentoA = 0;
     this.totalGastoA = 0;
     this.totalSubtotalA = 0;
     this.totalTIMA = 0;
     this.totalTotalA = 0;


     this.idenviadosbd=[];
  }



  ////////////////////////INICIO MODAL COACTIVO//////////////////////
  //PARA MODAL COACTIVO
  muestra_deuda(){

    

    this.totalImporteI = 0;
    this.totalGastoI = 0;
    this.totalSubtotalI = 0;
    this.totalDescuentoI = 0;
    this.totalTIMI = 0;
    this.totalTotalI = 0;

    this.totalImporteA = 0;
    this.totalGastoA = 0;
    this.totalSubtotalA = 0;
    this.totalDescuentoA = 0;
    this.totalTIMA = 0;
    this.totalTotalA = 0;

     // Reseteo de los totales a cero
     this.totalGasto = 0;
     this.totalSubtotal = 0;
     this.totalDescuento = 0;
     this.totalTIM = 0;
     this.totalTotal = 0;
     this.totalImporte = 0;


     this.idsSeleccionados = [];



    // this.totalImporte = 0;
    // this.totalDescuento = 0;
    // this.totalGasto = 0;
    // this.totalSubtotal = 0;
    // this.totalTIM = 0;
    // this.totalTotal = 0;


    
          let self=this;
          let datos = new FormData();
          let anoSeleccionado = $('#anio_orden_coactivo option:selected').val();
         

  // Asignar el valor a la propiedad de la clase
         // this.anoSeleccionado = anoSeleccionado; // Corrigiendo el nombre de la variable

          this.anio_orden_coactivo=anoSeleccionado;
          this.tipo_tributo_orden = document.getElementById("select_tributo_orden").value;

          datos.append("id_propietarios", predio.Propietarios);
          datos.append("tipo_tributo ", this.tipo_tributo_orden);
          datos.append("anio", this.anio_orden_coactivo);
          datos.append("anio_trimestre",this.anoSeleccionado);
          datos.append("estado_cuenta_orden_anio", "estado_cuenta_orden_anio");

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

               // Verifica si la respuesta es válida o si hay error
                if (respuesta.error) {
                  // Si hay un error, no se muestra nada
                  $(".estadocuentacaja").html('');
                  $(".estadocuentacoactivo").html('');
                  console.log("Ocurrió un error, no se mostró ningún contenido");
                  return;  // Detener ejecución
              }


            
              var content = '';
              self.totalDeuda_ = respuesta.totales[0];
              console.log("total_total mlm"+self.totalDeuda_.Importe);
              respuesta.campos.forEach(function(value) {
                var tributo = (value['Tipo_Tributo'] == '006') ? 'Imp. Predial' : 'Arb. Municipal';
                content += '<tr id="' + value['Id_Estado_Cuenta_Impuesto'] + '">';
                          
                
                content += '<td class="text-center">' +
                            '<input type="checkbox" class="fila-checkbox custom-checkbox" style="width:15px; height:15px; margin:0;" ' +
                            (value['Estado'] === '1' ? 'checked' : '') + ' disabled>' +
                            '</td>';

                content += '<td class="text-center">' + value['Tipo_Tributo'] + '</td>';
                content += '<td class="text-center">' + tributo + '</td>';
                content += '<td class="text-center">' + value['Anio'] + '</td>';
                content += '<td class="text-center">' + (value['Periodo'] === undefined ? '-' : value['Periodo']) + '</td>';
                content += '<td class="text-center">' + value['Total_Importe'] + '</td>';
                content += '<td class="text-center">' + value['Total_Gasto_Emision'] + '</td>';
                content += '<td class="text-center">' + value['Total_Saldo'] + '</td>';
                content += '<td class="text-center">' + value['Total_Descuento'] + '</td>';
                content += '<td class="text-center">' + value['Total_TIM_Aplicar'] + '</td>';
                content += '<td class="text-center">' + value['Total_Aplicar_Anual'] + '</td>';
                content += '</tr>';  // Asegúrate de cerrar el tr aquí
              });
            
              $(".estadocuentacoactivo").html(content);
              self.actualizarTotales();  // Aquí se hace la llamada a la función
              
              
            },
             error: function(xhr, status, error) {
              // Si ocurre un error en la petición AJAX, no mostrar nada
              $(".estadocuentacaja").html('');
              $(".estadocuentacoactivo").html('');
              console.log("Ocurrió un error al realizar la solicitud AJAX: " + error);
          }
            
          });
        
  }


// MODAL COACTIVO ACTUALIZAR 00 TOTAL
actualizarTotales() {
  // Mostrar los totales actualizados
  const formatearNumero = (numero) => {
      return numero.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  };

  $("#segundaTablac tbody td:eq(3)").text(formatearNumero(this.totalImporte));
  $("#segundaTablac tbody td:eq(4)").text(formatearNumero(this.totalGasto));
  $("#segundaTablac tbody td:eq(5)").text(formatearNumero(this.totalSubtotal));
  $("#segundaTablac tbody td:eq(6)").text(formatearNumero(this.totalDescuento));
  $("#segundaTablac tbody td:eq(7)").text(formatearNumero(this.totalTIM));
  $("#segundaTablac tbody td:eq(8)").text(formatearNumero(this.totalTotal));
}



manejarClicSC(thS) {
  const filas = $("#primeraTablac tbody tr");
  
  const todasSeleccionadas = filas.find(".fila-checkbox:not(:checked)").length === 0;


  filas.each((index, fila) => {
      const checkbox = $(fila).find(".fila-checkbox");

      if (todasSeleccionadas) {
          // Deseleccionar todas
          // if (checkbox.is(":checked")) {
          //     this.manejarClicFilaC($(fila));

          // }

          filas.each((index, fila) => {
            const checkbox = $(fila).find(".fila-checkbox");
            if (checkbox.is(":checked")) {
              this.manejarClicFilaC($(fila));
            }
          });

           // ✅ Reiniciar todos los totales después de desseleccionar
            this.totalImporte = 0;
            this.totalGasto = 0;
            this.totalSubtotal = 0;
            this.totalDescuento = 0;
            this.totalTIM = 0;
            this.totalTotal = 0;

            this.totalImporteI = 0;
            this.totalGastoI = 0;
            this.totalSubtotalI = 0;
            this.totalDescuentoI = 0;
            this.totalTIMI = 0;
            this.totalTotalI = 0;

            this.totalImporteA = 0;
            this.totalGastoA = 0;
            this.totalSubtotalA = 0;
            this.totalDescuentoA = 0;
            this.totalTIMA = 0;
            this.totalTotalA = 0;

            this.idsSeleccionados = [];
            this.idenviadosbd = [];

            this.actualizarTotales();





      } else {
          // Seleccionar todas
          if (!checkbox.is(":checked")) {
              this.manejarClicFilaC($(fila));
          }
      }
  });

  thS.text(todasSeleccionadas ? "S" : "S");
}






manejarClicFilaC(fila) {

 
  const tipoTText = fila.find("td:eq(1)").text().trim();
  const periodoFila = fila.find("td:eq(4)").text().trim();
  const importe = parseFloat(fila.find("td:eq(5)").text().trim()) || 0;
  const gasto = parseFloat(fila.find("td:eq(6)").text().trim()) || 0;
  const subtotal = parseFloat(fila.find("td:eq(7)").text().trim()) || 0;
  const descuento = parseFloat(fila.find("td:eq(8)").text().trim()) || 0;
  const tim = parseFloat(fila.find("td:eq(9)").text().trim()) || 0;
  const total = parseFloat(fila.find("td:eq(10)").text().trim()) || 0;
  
  const checkbox = fila.find(".fila-checkbox");
  const filaId = fila.attr("id");

  const esTipoI = tipoTText === '006';
  const esTipoA = tipoTText === '742';

  const IsPeriodo = periodoFila === '-';

  // const importe = parseFloat(importeText);
  // const gasto = parseFloat(gastoText);
  // const subtotal = parseFloat(subtotalText);
  // const descuento = parseFloat(descuentoText);
  // const tim = parseFloat(timText);
  // const total = parseFloat(totalText);

  if (checkbox.is(":checked")) {



         const index = this.idsSeleccionados.indexOf(filaId);
          if (index > -1) {
              this.idsSeleccionados.splice(index, 1);
          }

      // Si está marcado, deseleccionar
          this.totalGasto -= gasto;
          this.totalSubtotal -= subtotal;
          this.totalDescuento -= descuento;
          this.totalTIM -= tim;
          this.totalTotal -= total;
          this.totalImporte -= importe;

          
        // También restar del tipo correspondiente
        if (esTipoI) {
          this.totalImporteI -= importe;
          this.totalGastoI -= gasto;
          this.totalSubtotalI -= subtotal;
          this.totalDescuentoI -= descuento;
          this.totalTIMI -= tim;
          this.totalTotalI -= total;
        }

        if (esTipoA) {
          this.totalImporteA -= importe;
          this.totalGastoA -= gasto;
          this.totalSubtotalA -= subtotal;
          this.totalDescuentoA -= descuento;
          this.totalTIMA -= tim;
          this.totalTotalA -= total;
        }

          fila.css("background-color", "");
          checkbox.prop("checked", false);

          
          console.log("total PERIORDO quitado",this.totalTotalI);
          console.log("total ANIO quitado",this.totalTotalA);



          //AUMENTADO

          if(IsPeriodo){

      
  
            let datos = new FormData();
    
            //datos.append("id_selecionado",this.idsSeleccionados);
    
          //  datos.append("id_selecionado", this.idsSeleccionados.join(","));
            datos.append("id_selecionado", JSON.stringify(this.idsSeleccionados));
    
            // datos.append("id_selecionado", this.idsSeleccionados);
    
    
            datos.append("obtener_ids_de_id", "obtener_ids_de_id");
    
          // Definir los datos a enviar
    //const datos = new FormData(); // Usando FormData si necesitas enviar archivos, de lo contrario puedes usar un objeto normal
    // datos.append('key', 'value'); // Añadir tus datos aquí
    
    // Usar fetch en lugar de $.ajax
    
    
    
    // fetch("ajax/caja.ajax.php", {
    //   method: "POST",
    //   body: datos, // Si estás enviando un FormData, no es necesario 'contentType' ni 'processData'
    // })
    //   .then(response => response.json()) // Suponiendo que la respuesta del backend sea JSON
    //   .then(respuesta => {
    //     console.log("✅ Respuesta recibida del backend:", respuesta);
    
    //     // Asignar la respuesta a la propiedad idenviadosbd
    //     this.idenviadosbd = Array.isArray(respuesta) ? respuesta : []; // Asegurarse de que sea un array
    
    //   })
    //   .catch(error => {
    //     console.error("Hubo un problema con la solicitud Fetch:", error);
    //   });
    
    
    
           //console.log("los valores enviando: "+this.datos);
           // console.log("🧪 idsSeleccionados (tipo):", typeof this.idsSeleccionados);
    // Llenar el array 'idenviadosbd' con los valores que recibes desde la respuesta AJAX.
    
    
                  let self = this;  // Guarda una referencia al objeto de la clase
    
                  $.ajax({
                    url: "ajax/caja.ajax.php",
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                    
                        console.log("✅ Respuesta recibida del backend:", respuesta);
    
    
                        self.idenviadosbd=respuesta;
                        
    
              
                  console.log("aqui tiene valor", self.idenviadosbd);
    
                        // Asignar la respuesta a la propiedad idenviadosbd
                        // this.idenviadosbd = Array.isArray(respuesta) ? respuesta : []; // Asegurarse de que sea un array
    
    
                      //  Verifica si la respuesta es un array
                        if (Array.isArray(respuesta)) {
                            respuesta.forEach(id => {
                                console.log("📦 ID recibido:", id);
                                
                                // Asigna los IDs al array 'idenviadosbd'
                                this.idenviadosbd.push(id);
                            });
                            // Ver el contenido completo del array después de la actualización
                            console.log("ID enviados:", this.idenviadosbd);
                        } else {
                            console.warn("❌ No se recibió un array:", respuesta);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("❌ Error en AJAX:", error);
                    }
                  });
    
           
                  console.log("aqui esta vacio", this.idenviadosbd);
    
              }
          
    

      
  }else {
      // Si no está marcado, seleccionar
      this.totalGasto += gasto;
      this.totalSubtotal += subtotal;
      this.totalDescuento += descuento;
      this.totalTIM += tim;
      this.totalTotal += total;
      this.totalImporte += importe;

      
    if (esTipoI) {
      this.totalImporteI += importe;
      this.totalGastoI += gasto;
      this.totalSubtotalI += subtotal;
      this.totalDescuentoI += descuento;
      this.totalTIMI += tim;
      this.totalTotalI += total;
    }

    if (esTipoA) {
      this.totalImporteA += importe;
      this.totalGastoA += gasto;
      this.totalSubtotalA += subtotal;
      this.totalDescuentoA += descuento;
      this.totalTIMA += tim;
      this.totalTotalA += total;
    }

      fila.css("background-color", "rgb(252, 209, 229)");
      checkbox.prop("checked", true);


      if (!this.idsSeleccionados.includes(filaId)) {
          this.idsSeleccionados.push(filaId);
      }

     console.log("selecionado ahora --",this.idsSeleccionados)


     //console.log("total actual ",this.totalTotal)
      
      //(4) ['1889515', '1889516', '1889517', '1889518']-- 2004 en año selecionado ahora -- ['1889515']

      if(IsPeriodo){

      
  
        let datos = new FormData();

        //datos.append("id_selecionado",this.idsSeleccionados);

      //  datos.append("id_selecionado", this.idsSeleccionados.join(","));
        datos.append("id_selecionado", JSON.stringify(this.idsSeleccionados));

        // datos.append("id_selecionado", this.idsSeleccionados);


        datos.append("obtener_ids_de_id", "obtener_ids_de_id");

      // Definir los datos a enviar
//const datos = new FormData(); // Usando FormData si necesitas enviar archivos, de lo contrario puedes usar un objeto normal
// datos.append('key', 'value'); // Añadir tus datos aquí

// Usar fetch en lugar de $.ajax



// fetch("ajax/caja.ajax.php", {
//   method: "POST",
//   body: datos, // Si estás enviando un FormData, no es necesario 'contentType' ni 'processData'
// })
//   .then(response => response.json()) // Suponiendo que la respuesta del backend sea JSON
//   .then(respuesta => {
//     console.log("✅ Respuesta recibida del backend:", respuesta);

//     // Asignar la respuesta a la propiedad idenviadosbd
//     this.idenviadosbd = Array.isArray(respuesta) ? respuesta : []; // Asegurarse de que sea un array

//   })
//   .catch(error => {
//     console.error("Hubo un problema con la solicitud Fetch:", error);
//   });



       //console.log("los valores enviando: "+this.datos);
       // console.log("🧪 idsSeleccionados (tipo):", typeof this.idsSeleccionados);
// Llenar el array 'idenviadosbd' con los valores que recibes desde la respuesta AJAX.


              let self = this;  // Guarda una referencia al objeto de la clase

              $.ajax({
                url: "ajax/caja.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                
                    console.log("✅ Respuesta recibida del backend:", respuesta);


                    self.idenviadosbd=respuesta;
                    

          
              console.log("aqui tiene valor", self.idenviadosbd);

                    // Asignar la respuesta a la propiedad idenviadosbd
                    // this.idenviadosbd = Array.isArray(respuesta) ? respuesta : []; // Asegurarse de que sea un array


                  //  Verifica si la respuesta es un array
                    if (Array.isArray(respuesta)) {
                        respuesta.forEach(id => {
                            console.log("📦 ID recibido:", id);
                            
                            // Asigna los IDs al array 'idenviadosbd'
                            this.idenviadosbd.push(id);
                        });
                        // Ver el contenido completo del array después de la actualización
                        console.log("ID enviados:", this.idenviadosbd);
                    } else {
                        console.warn("❌ No se recibió un array:", respuesta);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("❌ Error en AJAX:", error);
                }
              });

       
              console.log("aqui esta vacio", this.idenviadosbd);

          }
      

      console.log("total PERIORDO sumado",this.totalTotalI);
      console.log("total ANIO suamdo",this.totalTotalA);
      

    }


  

  const formatearNumero = (numero) => {
    return numero.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
};

  // Actualizar totales
  $("#segundaTablac tbody td:eq(3)").text(formatearNumero(this.totalImporte));
  $("#segundaTablac tbody td:eq(4)").text(formatearNumero(this.totalGasto));
  $("#segundaTablac tbody td:eq(5)").text(formatearNumero(this.totalSubtotal));
  $("#segundaTablac tbody td:eq(6)").text(formatearNumero(this.totalDescuento));
  $("#segundaTablac tbody td:eq(7)").text(formatearNumero(this.totalTIM));
  $("#segundaTablac tbody td:eq(8)").text(formatearNumero(this.totalTotal));
 
  
 
}






  //IMPRIMIR COACTIVO
  
  imprimirherecoactivo() {

    
   
    const Propietarios_ = [];
    $("#id_propietarios tr").each(function (index) {
        var idFila = $(this).attr("id_contribuyente");
        Propietarios_[index] = idFila;
    });

    const Propietarios = Propietarios_.map(valor => parseInt(valor, 10));

  
    let idsSeleccionados_ = [];

    if (this.idenviadosbd && this.idenviadosbd.length > 0) {
        // Si this.idenviadosbd no está vacío, se asignan sus valores.
        idsSeleccionados_ = this.idenviadosbd.map(valor => parseInt(valor, 10));
    } else {
        // Si this.idenviadosbd está vacío, se asignan los valores de this.idsSeleccionados.
        idsSeleccionados_ = this.idsSeleccionados.map(valor => parseInt(valor, 10));
    }
    
  
 
  
    //const idbackend=this.idenviadosbd.map(valor => parseInt(valor, 10));
    // Verificar si los valores están vacíos
   
    // Verificar si los valores están vacíos


    console.log("esat es el valro de I",this.totalTotalI);
    console.log("esat es el valro de I",this.totalTotalA);

    if (
      (this.totalTotalI == null || this.totalTotalA == null) || 
      (this.totalTotalI === 0 && this.totalTotalA === 0)
  ) {
      // Mostrar el primer modal si ambos son 0 o si algún valor es null/undefined
      $('#modal_vacio_coactivo').modal('show');
      console.log("Ambos valores son 0 o alguno es nulo. Se muestra el primer modal.");
      return;
  } else {
      // Mostrar el segundo modal si al menos uno tiene valor distinto de 0
      console.log("Se encontró al menos un valor válido. Se muestra el modal de impresión.");
      $("#Modalimprimir_cuenta_coactivo").modal("show");
  }

//   if (!this.totalTotalA) {
   
//     // Mostrar el primer modal si algún valor está vacío
//     $('#modal_vacio_coactivo').modal('show');
//     console.log("Los valores están vacíos. Se muestra el segundo modal.");
//     return; // Detener ejecución para evitar mostrar el segundo modal
// } else {
//     // Mostrar el segundo modal si los valores no están vacíos
//     console.log("Los valores no están vacíos. Se muestra el segundo modal.");
//     $("#Modalimprimir_cuenta_coactivo").modal("show");
// }






    // Construir el objeto FormData
     let datos = new FormData();

   

    datos.append("id_usuario", general.iso_usuario);
     datos.append("id_area", general.iso_area);
     datos.append("id_cuenta", idsSeleccionados_);
    datos.append("propietarios", Propietarios);
     datos.append("carpeta", predio.carpeta);

     //TOTAL PARA IMPUESTO
     datos.append("totalImporteI", this.totalImporteI.toFixed(2));
    datos.append("totalGastoI", this.totalGastoI.toFixed(2));
    datos.append("totalSubtotalI", this.totalSubtotalI.toFixed(2));
    datos.append("totaldescuentoI", this.totalDescuentoI.toFixed(2));
    datos.append("totalTIMI", this.totalTIMI.toFixed(2));
    datos.append("totalTotalI", this.totalTotalI.toFixed(2));

    //TOTAL PARA ARBITRIOS 
    datos.append("totalImporteA", this.totalImporteA.toFixed(2));
    datos.append("totalGastoA", this.totalGastoA.toFixed(2));
    datos.append("totalSubtotalA", this.totalSubtotalA.toFixed(2));
    datos.append("totaldescuentoA", this.totalDescuentoA.toFixed(2));
    datos.append("totalTIMA", this.totalTIMA.toFixed(2));
    datos.append("totalTotalA", this.totalTotalA.toFixed(2));


    datos.append("totalTotal", this.totalTotal.toFixed(2));

    // Mostrar datos en consola
   console.log(this.totalTotal.toFixed(2))


   console.log("inpueto total",this.totalTotalI)

   console.log("arbitrio total",this.totalTotalA)


   console.log("lo que esta asigando de ajax  "+this.idbackend);


  

   //console.log(idsSeleccionados_)
    // Usar fetch en lugar de $.ajax
    fetch("./vistas/print/imprimirEstadoCuentacoactivo.php", {
        method: "POST",
        body: datos
    })
    .then(response => {
      console.log(response);
        if (!response.ok) {
            throw new Error("Error en la respuesta del servidor");
        }
        return response.text(); // O .json() si esperas un JSON
    })
    .then(rutaArchivo => {
        document.getElementById("iframec").src = 'vistas/print/' + rutaArchivo;

        

    console.log("Totales reseteados después de enviar correctamente.");
    })
    .catch(error => {
        console.error("Error en la solicitud fetch:", error);
    })
    .finally(() => {
        console.log("Solicitud fetch completada.");

        
    // ✅ Reseteamos los totales aquí SOLO si ya todo fue exitoso
    // this.totalImporteI = 0;
    // this.totalGastoI = 0;
    // this.totalSubtotalI = 0;
    // this.totalDescuentoI = 0;
    // this.totalTIMI = 0;
    // this.totalTotalI = 0;

    // this.totalImporteA = 0;
    // this.totalGastoA = 0;
    // this.totalSubtotalA = 0;
    // this.totalDescuentoA = 0;
    // this.totalTIMA = 0;
    // this.totalTotalA = 0;


    // this.totalImporte = 0;
    // this.totalDescuento = 0;
    // this.totalGasto = 0;
    // this.totalSubtotal = 0;
    // this.totalTIM = 0;
    // this.totalTotal = 0;


    // // También puedes limpiar `idsSeleccionados` si deseas
    // this.idsSeleccionados = [];



    });
}





    ////////////////////////FIN MODAL COACTIVO//////////////////////

  


  
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

  pasar_parametro_get(id) {
    window.location =
      "index.php?ruta=recaudacion-estadocuenta&id=" + id+ "&anio=" + general.anio_valor;
  }
  pasar_parametro_get_pagado(id) {
    window.location =
      "index.php?ruta=Pagados-impuesto-arbitrios&id=" + id+ "&anio=" + general.anio_valor;
  }
  imprimir_estado_cuenta(id) {
    window.location =
      "index.php?ruta=imprimirEstadoCuenta&id=" + id+ "&anio=" + general.anio_valor;
  }


  
  




  manejarClicS(thS) {  
    const filas = $("#primeraTabla tbody tr");
    const todasSeleccionadas = $("td:eq(10):contains('1')", filas).length === filas.length;
    if (todasSeleccionadas) {
      // Todas las filas están seleccionadas, deseleccionar todas
      filas.each((index, fila) => {
        this.manejarClicFila($(fila));
      });
    } else {
      // Al menos una fila ya está seleccionada, completar las faltantes
      filas.each((index, fila) => {
        if ($("td:eq(10)", fila).text() !== "1") {
          this.manejarClicFila($(fila));
        }
      });
    }
    thS.text(todasSeleccionadas ? "S" : "S");
    // Actualizar los totales en la segunda tabla
    $("#segundaTabla tbody th:eq(2)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla tbody th:eq(3)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla tbody th:eq(4)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla tbody th:eq(5)").text(this.totalDescuento.toFixed(2));
    $("#segundaTabla tbody th:eq(6)").text(this.totalTIM.toFixed(2));
    $("#segundaTabla tbody th:eq(7)").text(this.totalTotal.toFixed(2));
    
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
    
    // Capturar el valor del atributo "id" de la fila y agregarlo al array si está seleccionada
    const filaId = fila.attr("id");
    
    if (estadoS === "1") {
        this.totalGasto -= gasto;
        this.totalSubtotal -= subtotal;
        this.totalDescuento -= descuento;
        this.totalTIM -= tim;
        this.totalTotal -= total;
        this.totalImporte -= importe;
        
        fila.find("td:eq(10)").text("");
        fila.css("background-color", "");
        
        // Eliminar el valor del id de la fila del array (si existe)
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
        fila.find("td:eq(10)").text("1");
        fila.css("background-color", "rgb(252, 209, 229)");   
        // Agregar el valor del id de la fila al array (si no existe)
        if (!this.idsSeleccionados.includes(filaId)) {
            this.idsSeleccionados.push(filaId);
        }
    }
    $("#segundaTabla tbody th:eq(2)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla tbody th:eq(3)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla tbody th:eq(4)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla tbody th:eq(5)").text(this.totalDescuento.toFixed(2));
    $("#segundaTabla tbody th:eq(6)").text(this.totalTIM.toFixed(2));
    $("#segundaTabla tbody th:eq(7)").text(this.totalTotal.toFixed(2));
        
    // El array idsSeleccionados ahora contendrá los ids de las filas seleccionadas
    console.log("Ids seleccionados:", this.idsSeleccionados);
  }



//coactivo
// imprimirherec() {

//   const Propietarios_ = []; // Declarar un arreglo vacío
//   $("#id_propietarios tr").each(function (index) {
//     // Accede al valor del atributo 'id' de cada fila
//     var idFila = $(this).attr("id_contribuyente");
//     Propietarios_[index] = idFila; // Agregar el valor al arreglo
//   });
      
//   const Propietarios = Propietarios_.map(function(valor) {
//     return parseInt(valor, 10); // El segundo argumento 10 especifica la base numérica (decimal).
//   });
//   console.log(Propietarios);
//   const idsSeleccionados_ = this.idsSeleccionados.map(function(valor) {
//     return parseInt(valor, 10); // El segundo argumento 10 especifica la base numérica (decimal).
//   });
//   let datos = new FormData();
 
//   datos.append("id_usuario", general.iso_usuario);
//   datos.append("id_area", general.iso_area);
//   datos.append("id_cuenta",idsSeleccionados_);
//   datos.append("propietarios",Propietarios);

//   datos.append("carpeta",predio.carpeta);
  
//   datos.append("totalImporte",this.totalImporte.toFixed(2));
//   datos.append("totalGasto",this.totalGasto.toFixed(2));
//   datos.append("totalSubtotal",this.totalSubtotal.toFixed(2));
//   datos.append("totaldescuento",this.totalDescuento.toFixed(2));
//   datos.append("totalTIM",this.totalTIM.toFixed(2));
//   datos.append("totalTotal",this.totalTotal.toFixed(2));
//   $.ajax({
//     url: "./vistas/print/imprimirEstadoCuenta.php",
//     method: "POST",
//     data: datos,
//     cache: false,
//     contentType: false,
//     processData: false,
//     success: function (rutaArchivo) {
//       // Establecer el src del iframe con la ruta relativa del PDF
//       document.getElementById("iframe").src = 'vistas/print/' + rutaArchivo;

//     }
//   });
// }


  imprimirhere() {
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
    const idsSeleccionados_ = this.idsSeleccionados.map(function(valor) {
      return parseInt(valor, 10); // El segundo argumento 10 especifica la base numérica (decimal).
    });
    let datos = new FormData();
   
    datos.append("id_usuario", general.iso_usuario);
    datos.append("id_area", general.iso_area);
    datos.append("id_cuenta",idsSeleccionados_);
    datos.append("propietarios",Propietarios);

    datos.append("carpeta",predio.carpeta);
    
    datos.append("totalImporte",this.totalImporte.toFixed(2));
    datos.append("totalGasto",this.totalGasto.toFixed(2));
    datos.append("totalSubtotal",this.totalSubtotal.toFixed(2));
    datos.append("totaldescuento",this.totalDescuento.toFixed(2));
    datos.append("totalTIM",this.totalTIM.toFixed(2));
    datos.append("totalTotal",this.totalTotal.toFixed(2));
    $.ajax({
      url: "./vistas/print/imprimirEstadoCuenta.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (rutaArchivo) {
        // Establecer el src del iframe con la ruta relativa del PDF
        document.getElementById("iframe").src = 'vistas/print/' + rutaArchivo;

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
const recaudacion = new Recaudacion();


function recaudar_loadContribuyente_impuesto(page,searchClass,pagado) {
  if (event.keyCode === 13) {
  recaudacion.loadContribuyenteImpuesto(page,searchClass,pagado);
  }
}


/////////////////////////INICIO MOAL COACTIVO////////////////////

// Evitar clic directo en el checkbox
$(".fila-checkbox").on("click", function (event) {
  console.log("has hehco clik")
  event.stopPropagation(); // Evita el evento cuando se hace clic en el checkbox
});



// Reset MODAL COACTIVOS
$("#anio_orden_coactivo").change(function() {
  // Reset all totals
  this.totalGasto = 0;
  this.totalSubtotal = 0;
  this.totalDescuento = 0;
  this.totalTIM = 0;
  this.totalTotal = 0;
  this.totalImporte = 0;
  this.idsSeleccionados = [];

   //IMPUESTO PREDIAL
   this.totalImporteI = 0;
   this.totalDescuentoI = 0;
   this.totalGastoI = 0;
   this.totalSubtotalI = 0;
   this.totalTIMI = 0;
   this.totalTotalI = 0;

    //ARBITRIO MONICIPAL
    this.totalImporteA = 0;
    this.totalDescuentoA = 0;
    this.totalGastoA = 0;
    this.totalSubtotalA = 0;
    this.totalTIMA = 0;
    this.totalTotalA = 0;


    this.idenviadosbd=[];

  // Log the reset values to the console
  console.log("Valores reseteados a cero");
  console.log("Total Gasto:", this.totalGasto);
  console.log("Total Subtotal:", this.totalSubtotal);
  console.log("Total Descuento:", this.totalDescuento);
  console.log("Total TIM:", this.totalTIM);
  console.log("Total Total:", this.totalTotal);
  console.log("Total Importe:", this.totalImporte);

  // Optionally, you can update the UI or table with the new totals if needed
  const formatearNumero = (numero) => {
      return numero.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  };

  // Clear or reset the displayed totals
  $("#segundaTablac tbody td:eq(3)").text(formatearNumero(this.totalImporte));
  $("#segundaTablac tbody td:eq(4)").text(formatearNumero(this.totalGasto));
  $("#segundaTablac tbody td:eq(5)").text(formatearNumero(this.totalSubtotal));
  $("#segundaTablac tbody td:eq(6)").text(formatearNumero(this.totalDescuento));
  $("#segundaTablac tbody td:eq(7)").text(formatearNumero(this.totalTIM));
  $("#segundaTablac tbody td:eq(8)").text(formatearNumero(this.totalTotal));





});

//CLICK EN COLUMA PARA COACTIVO

// Delegación de eventos
$("#primeraTablac tbody").on("click", "tr", function () {

  recaudacion.manejarClicFilaC($(this));
});


// CLIK EN ENCABEZADO DE COACTIVO
$("#primeraTablac thead th:eq(0)").on("click", function () {
  //console.log("acabas de dar click aqui")
  recaudacion.manejarClicSC($(this));
});

//imprimir coactivo

$(document).on("click", "#popimprimircoactiva", function () {
  // Verificar si el primer modal está visible
  if ($('#modal_vacio_coactivo').hasClass('show')) {
      // Si el primer modal está visible, no mostrar el segundo modal
      console.log("El primer modal está visible, no se mostrará el segundo.");
      return; // Detener ejecución si el primer modal está visible
  }

  // Ejecutar la función que revisa si los valores están vacíos o no
  recaudacion.imprimirherecoactivo();
});


//CERRAR VENTANA DE COACTIVO CON OK.
$(document).on("click", ".print_orden_coactivo_aviso", function() {
  // Cerrar el modal
  $('#modal_vacio_coactivo').modal('hide');
});

//CLIK PARA MODAL DE ESTADO DE CUANTA COACTIVO
$("#abrirEstadoCoactivo").click(function () {
  $("#modalEstadoCuentaC").modal("show");
});


//PARA CAMBIO DE SEMESTRE Y AÑO DE COACTIVO
$(document).on("change", "#anio_orden_coactivo", function () {
  //console.log("estas aqui");
  recaudacion.muestra_deuda();


 });
 
 // AL ABRIR EL MODAL COACTIVO CARGA TRIMESTRE
 $('#modalEstadoCuentaC').on('show.bs.modal', function () {
   recaudacion.muestra_deuda();
 });
 


/////////////////////////FIN MOAL COACTIVO////////////////////

//PASAR EL VALOR DE CONTRIBUYENTE BUSCADO A PREDIOS POR GET - VALIDADO
$(document).on("click", ".btnCuenta", function () {
  let id = $(this).attr("idContribuyente_cuenta");
  recaudacion.pasar_parametro_get(id);
});


$(document).on("click", ".btnCuenta_pagado", function () {
  let id = $(this).attr("idContribuyente_cuenta");
  recaudacion.pasar_parametro_get_pagado(id);
});
//window.onload = recaudacion.ajustarAnchoColumnas();
// Función para manejar el clic en las filas de la tabla
$("#primeraTabla tbody tr").on("click", function () {
  recaudacion.manejarClicFila($(this));
});


$("#primeraTabla thead th:eq(10)").on("click", function () {
  recaudacion.manejarClicS($(this));
});



$(document).on("click", "#popimprimir", function () {
    recaudacion.imprimirhere();
    $("#Modalimprimir_cuenta").modal("show");
});



// $(document).on("click", "#popimprimircoactiva", function () {

//   recaudacion.imprimirherecoactivo();

//   $("#Modalimprimir_cuenta_coactivo").modal("show");
// });

//esatdi de cuenta para coactivo
// $(document).on("click", "#btnOrdenCoactivo", function () {
//   console.log("hola")
//   recaudacion.imprimirherec();
//   $("#Modalimprimir_cuenta_coactivo").modal("show");
// });



//CLICK ESTADOP DE CUENTA
$("#abrirEstadoCuenta").click(function () {
  $("#modalEstadoCuenta").modal("show");
});




// Cerrar modal manualmente


//Eliminar los pdf de los estados de cuenta 
setInterval(recaudacion.eliminarArchivosPDF, 60000);



//CLICK PARA SIGUEINTE

$("#siguiente_Predio").click(function (e) {
  e.preventDefault();
  console.log("Has hecho clic ahora ---");

  // Buscar el primer valor de 'id_carpeta' en la tabla
  const codigoCarpeta = $("#id_propietarios tr").first().find("td#carpeta_contribuyente").attr("id_carpeta");

  console.log("Código cargado:", codigoCarpeta);


 // Si no hay ningún valor de codigoCarpeta, devolver un valor predeterminado
 if (!codigoCarpeta) {
  console.warn("No se encontró ningún código de carpeta.");
} else {
  const siguienteId = parseInt(codigoCarpeta) + 1;
  console.log("ID para enviar al backend:", siguienteId);

  let datos = new FormData();
  datos.append("siguiente", siguienteId);
  datos.append("estado_siguiente", "estado_siguiente");

  $.ajax({
    url: "ajax/caja.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      console.log("Respuesta del backend:", respuesta);
      
      //const data = JSON.parse(respuesta);
      const data = respuesta; // ya es objeto

      console.log("entrando:", data)
      try {
       

        const anio = 2025;
        if (data.concatenado) {
          const siguienteConcatenadoId = data.concatenado;

          console.log("entrando:", siguienteConcatenadoId)

          const url = `http://localhost/SIAT/index.php?ruta=listapredio&id=${siguienteConcatenadoId}&anio=${anio}`;
         
         
          console.log("Redirigiendo a:", url);
          window.location.href = url;
        } 

      } catch (error) {
        console.error("Error al parsear la respuesta:", error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la llamada AJAX:", error);
    }
  });

}
});


//BOTON ANTERIOR

$("#anterior_Predio").click(function (e) {
  e.preventDefault();
  console.log("Has hecho clic ahora ---");

  // Buscar el primer valor de 'id_carpeta' en la tabla
  const codigoCarpeta = $("#id_propietarios tr").first().find("td#carpeta_contribuyente").attr("id_carpeta");

  console.log("Código cargado:", codigoCarpeta);


 // Si no hay ningún valor de codigoCarpeta, devolver un valor predeterminado
 if (!codigoCarpeta) {
  console.warn("No se encontró ningún código de carpeta.");
} else {
  const siguienteId = parseInt(codigoCarpeta) - 1;
  console.log("ID para enviar al backend:", siguienteId);

  let datos = new FormData();
  datos.append("anterior", siguienteId);
  datos.append("estado_anterior", "estado_anterior");

  $.ajax({
    url: "ajax/caja.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      console.log("Respuesta del backend:", respuesta);
      
      //const data = JSON.parse(respuesta);
      const data = respuesta; // ya es objeto

      console.log("entrando:", data)
      try {
       

        const anio = 2025;
        if (data.concatenado) {
          const siguienteConcatenadoId = data.concatenado;

          console.log("entrando:", siguienteConcatenadoId)

          const url = `http://localhost/SIAT/index.php?ruta=listapredio&id=${siguienteConcatenadoId}&anio=${anio}`;
         
         
          console.log("Redirigiendo a:", url);
          window.location.href = url;
        } 

      } catch (error) {
        console.error("Error al parsear la respuesta:", error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la llamada AJAX:", error);
    }
  });

}
});



