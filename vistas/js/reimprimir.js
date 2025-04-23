class Reimprimir {
    constructor() {
      this.numero_recibo = 0;
      this.tipo=null;
      this.total_reimrpimir=0;

      this.id_propopitarios=null;
      this.id_cuenta=[];
      this.tipo_tributo=null;

      this.valorSeleccionado=null;
      this.id_proveido=null;
      this.idlicencia=null;
    }
   
    reimprimir_pago(numero_recibo, tipo) {
      let self = this;
      let datos = new FormData();
      datos.append("numero_recibo", numero_recibo);
      datos.append("tipo", tipo);
      datos.append("reimprimir", "reimprimir");
      console.log(datos);
      $.ajax({
          url: "ajax/caja.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            console.log(respuesta);
              var content = '';
              self.total_reimrpimir = 0; // Reinicia el total en cada nueva solicitud
              if (tipo === '006') {
                if (Array.isArray(respuesta.impuesto) && respuesta.impuesto.length > 0 && respuesta.impuesto[0]['Concatenado_idc'] !== null) {
                  // Procesar los datos si se encuentran registros
                  var propietario = '';
                  var impuestoData = respuesta.impuesto;
                  
                  self.id_propopitarios = respuesta.impuesto[0]['Concatenado_idc'];
                  self.tipo_tributo = respuesta.impuesto[0]['Tipo_Tributo'];

                  console.log(self.id_propopitarios);
                  console.log(self.tipo_tributo);
                  console.log(respuesta);
                  impuestoData.forEach(function (value) {
                      self.id_cuenta.push(value['Id_Estado_Cuenta_Impuesto']);
                      self.total_reimrpimir += parseFloat(value['Total_Pagar']);
                      
                      var tributo = (value['Tipo_Tributo'] == '006') ? 'Imp. Predial' : 'Arb. Municipal';
                      content += '<tr id="' + value['Id_Estado_Cuenta_Impuesto'] + '" tipo_tributo="' + value['Tipo_Tributo'] + '" id_propietarios="' + value['Concatenado_idc'] + '">';
                      content += '<td class="text-center">' + value['Numeracion_caja'] + '</td>';
                      content += '<td class="text-center">' + tributo + '</td>';
                      content += '<td class="text-center">' + value['Anio'] + '</td>';
                      content += '<td class="text-center">' + value['Periodo'] + '</td>';
                      content += '<td class="text-center" style="width:200px;">' + value['Fecha_Pago'] + '</td>';
                      content += '<td class="text-center">' + value['Importe'] + '</td>';
                      content += '<td class="text-center">' + value['Gasto_Emision'] + '</td>';
                      content += '<td class="text-center">' + value['Saldo'] + '</td>';
                      content += '<td class="text-center">' + value['TIM'] + '</td>';
                      content += '<td class="text-center">' + value['Total_Pagar'] + '</td>';
                      content += '</tr>';
                  });
                  
                  $(".reimprimir_tributo").html(content);
              
                  // Procesar datos del array 'resultados'
                  var resultadosData = respuesta.resultados;
                  for (var contribuyenteId in resultadosData) {
                      var contribuyenteArray = resultadosData[contribuyenteId];
                      contribuyenteArray.forEach(function (contribuyente) {
                          propietario += '<tr>';
                          propietario += '<td class="text-center">' + contribuyente['Id_Contribuyente'] + '</td>';
                          propietario += '<td class="text-center">' + contribuyente['Nombre_Completo'] + '</td>';
                          propietario += '<td class="text-center">' + contribuyente['Codigo_Carpeta'] + '</td>';
                          propietario += '</tr>';
                      });
                  }
                  $("#propietarios_reimprimir").html(propietario);
              } else {
                  // Mostrar mensaje de error si no se encuentran registros
                  $(".reimprimir_tributo").html('<tr><td colspan="10" class="text-center">No se encontraron registros</td></tr>');
                  $("#propietarios_reimprimir").html('<tr><td colspan="3" class="text-center">No se encontraron propietarios</td></tr>');
              }
              } else if (tipo === '009') {
                  if (respuesta.length > 0) {
                      respuesta.forEach(function (value) {

                          self.id_proveido = value['Id_Proveido'];
                          self.total_reimrpimir += value['Valor_Total'];
                          content += '<tr idproveido="' + value['Id_Proveido'] + '">';
                          content += '<td class="text-center">' + value['Numero_Caja'] + '</td>';
                          content += '<td class="text-center">' + value['Numero_Proveido'] + '</td>';
                          content += '<td class="text-center">' + value['Descripcion'] + '</td>';
                          content += '<td class="text-center">' + value['Nombres'] + '</td>';
                          content += '<td class="text-center" style="width:200px;">' + value['Fecha_pago'] + '</td>';
                          content += '<td class="text-center">' + value['Cantidad'] + '</td>';
                          content += '<td class="text-center">' + value['Valor_Total'] + '</td></tr>';
                      });
                      $(".reimprimir_especie").html(content);
                  } else {
                      // Mostrar mensaje de error si no se encuentran registros
                      $(".reimprimir_especie").html('<tr><td colspan="7" class="text-center">No se encontraron registros</td></tr>');
                  }
              } else {
                if (Array.isArray(respuesta.agua)) { // Verifica que sea un array y tenga datos
                    
                    let content = ""; // Inicializar variable
                    let propietario = ""; // Inicializar variable
                    self.total_reimrpimir = 0; // Asegurar reinicio de la suma
               
                    var aguaData = respuesta.agua;


                    self.id_propopitarios = respuesta.contribuyente['Id_Contribuyente'];
                    self.tipo_tributo = respuesta.agua[0]['Tipo_Tributo'];
                    self.idlicencia = respuesta.agua[0]['Id_Licencia_Agua'];
                    aguaData.forEach(function (value) {

                        self.id_cuenta.push(value['Id_Ingresos_Tributos']);
                        self.total_reimrpimir += parseFloat(value['Total_Pagar']); // Convertir a número por seguridad

                        content += '<tr>'; // Abrir fila
                        content += '<td class="text-center">' + value['Numeracion_caja'] + '</td>';
                        content += '<td class="text-center">Agua</td>';
                        content += '<td class="text-center">' + value['Anio'] + '</td>';
                        content += '<td class="text-center">' + value['Periodo'] + '</td>';
                        content += '<td class="text-center" style="width:200px;">' + value['Fecha_Pago'] + '</td>';
                        content += '<td class="text-center">' + value['Saldo'] + '</td>';
                        content += '<td class="text-center">' + value['Total_Pagar'] + '</td>';
                        content += '</tr>'; // Cerrar fila
                    });
                    $(".reimprimir_agua").html(content); // Insertar datos en la tabla
            
                    // Procesar datos del array 'resultados'
                    var contribuyenteData = respuesta.contribuyente;
                   // Verificar si es un array antes de iterar
                            propietario += '<tr>';
                            propietario += '<td class="text-center">' + contribuyenteData['Id_Contribuyente'] + '</td>';
                            propietario += '<td class="text-center">' + contribuyenteData['Nombre_Completo'] + '</td>';
                            propietario += '</tr>';
                       
                   
                    $("#propietarios_reimprimir").html(propietario);
                } else {
                    $(".reimprimir_agua").html('<tr><td colspan="7" class="text-center">No hay datos disponibles</td></tr>'); // Mensaje si no hay datos
                }
            }
              // Actualizar el total
              $("#total_reimprimir").text(parseFloat(self.total_reimrpimir).toFixed(2));
              $("#total_confirmar").text(parseFloat(self.total_reimrpimir).toFixed(2));
              $("#nc").text(numero_recibo);
          }
      });
  }
  

  ReimprimirRecibo_IA() {
        let self = this;
        caja.tipo_papel();
        let datos_baucher = new FormData();
        if(self.valorSeleccionado==='006'){
          datos_baucher.append("propietarios", self.id_propopitarios);
          datos_baucher.append("id_cuenta", self.id_cuenta);
          datos_baucher.append("tipo_tributo", self.tipo_tributo);
          datos_baucher.append("recibo_reimprimir", self.numero_recibo);
          datos_baucher.append("fuente","reimprimir");
          console.log (datos_baucher);
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
                      '</button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">Se Reimprimio el recibo correctamente!</span></p></div>'
                    );
                    setTimeout(function () {
                      $("#respuestaAjax_srm").hide();
                    }, 5000);
                  },
                });
          }
          else if(self.valorSeleccionado==='009'){
            datos_baucher.append("id_proveido",self.id_proveido);
            console.log("numero de proveido"+ self.id_proveido);
            $.ajax({
              url: "ajax/imprimirProveido.php",
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
                  '</button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">Se Reimprimio el recibo correctamente!</span></p></div>'
                );
                setTimeout(function () {
                  $("#respuestaAjax_srm").hide();
                }, 5000);

              },
            });
          }

          else{
            datos_baucher.append("propietarios", self.id_propopitarios);
            datos_baucher.append("id_cuenta", self.id_cuenta);
            datos_baucher.append("tipo_tributo", self.tipo_tributo);
            datos_baucher.append("idlicencia", self.idlicencia);
            datos_baucher.append("fuente","reimprimir_agua");
            console.log (datos_baucher);
                  $.ajax({
                    url: "ajax/imprimirAgua.php",
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
                        '</button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">Se Reimprimio el recibo correctamente!</span></p></div>'
                      );
                      setTimeout(function () {
                        $("#respuestaAjax_srm").hide();
                      }, 5000);
                    },
                  });
            }
      }
  }
  //fin de la clase y constructor
  const reimrpimir = new Reimprimir();
  
$(document).on("keypress", ".n_recibo_reimprimir", function(event) {
    if (event.key === "Enter") {
        reimrpimir.numero_recibo = $(this).val().trim(); // Captura y elimina espacios en blanco al inicio y al final
        reimrpimir.tipo = $("#select_reimprimir").val();
        reimrpimir.id_cuenta=[];
        if (reimrpimir.numero_recibo !== "") {
            console.log("Valor recibo: " + reimrpimir.numero_recibo);
            console.log("Valor tipo: " + reimrpimir.tipo);
            // Aquí puedes llamar a la función que necesites, por ejemplo:
            reimrpimir.reimprimir_pago(reimrpimir.numero_recibo,reimrpimir.tipo);
            reimrpimir.total_reimrpimir=0;
            
        }
    }
});

$("#select_reimprimir").on("change", function() {
    reimrpimir.valorSeleccionado = $(this).val();
    $("#total_reimprimir").text('0.00');
    // Ocultar todas las tablas
    $("#reimrprimir_tabla_tributo").hide();
    $("#reimrprimir_tabla_especie").hide();
    $("#reimrprimir_tabla_agua").hide();

    // Mostrar la tabla correspondiente al valor seleccionado
    if (reimrpimir.valorSeleccionado === '006') {
        $("#reimrprimir_tabla_tributo").show();
        $(".miTabla_propietarios").show();
    } else if (reimrpimir.valorSeleccionado === '009') {
        $("#reimrprimir_tabla_especie").show();
        $(".miTabla_propietarios").hide();
    } else if (reimrpimir.valorSeleccionado === '005') {
        $("#reimrprimir_tabla_agua").show();
        $(".miTabla_propietarios").show();
    }
});

$(document).on("click", ".reimprimir_boleta", function () {
  //$('#modalPagar_si_no').modal('hide');
  reimrpimir.ReimprimirRecibo_IA();
  $("#modalReimprimir_si_no").modal("hide");
});

$(document).on("click", ".print_impresora", function () {
  if (reimrpimir.total_reimrpimir > 0 || reimrpimir.id_proveido!=null) {
    $("#modalReimprimir_si_no").modal("show");
    //miInstanciaImprimir.imprimirDJ();
  } else {
    var html_respuesta =
      ' <div class="col-sm-30">' +
      '<div class="alert alert-warning">' +
      '<button type="button" class="close font__size-18" data-dismiss="alert">' +
      "</button>" +
      '<i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>' +
      '<strong class="font__weight-semibold">Alerta!</strong> No hay recibo a reimprimir.' +
      "</div>" +
      "</div>";
    $("#respuestaAjax_srm").html(html_respuesta);
    $("#respuestaAjax_srm").show();
    setTimeout(function () {
      $("#respuestaAjax_srm").hide();
    }, 5000);
  }
});

