
class ConsultaDeudaAguaCajaClass {
    constructor() {
        this.idCatastroC_consulta_agua = null;
        this.ubiLicenciaC_consulta_agua = null;
        this.codCatastroC_consulta_agua=null;
        this.idlicenciaagua_caja=null; 
       
        this.tipo_papel_valor = null; // Valor predeterminado
        this.inicializarTipoPapel(); // Llama a la función tipo de papel
     
        this.totalImporte = 0;
        this.totalGasto = 0;
        this.totalSubtotal = 0;
        this.totalTIM = 0;
        this.totalTotal = 0;
        this.idsSeleccionados = [];

        this.vuelto=0;
        this.efectivo=0;
    }
    
    contribibuyente_aguacaja_lista_func(page,searchClass) {
        let perfilOculto_c = $("#perfilOculto_c").val();
        let searchContribuyente = $("." + searchClass).val();
            let parametros = {
              action: "ajax",
              page: page,
              searchContribuyente: searchContribuyente,
              tipo: searchClass,
              dpLicenciaAguaLista_caja: "dpLicenciaAguaLista_caja",
              perfilOculto_c: perfilOculto_c,
            };
            $.ajax({
              url: "vistas/tables/dataTables.php",
              data: parametros,
              beforeSend: function() {
                $(".body-contribuyente_agua_lista_caja").html(loadingMessage);
              },
              success: function (data) {
                $(".body-contribuyente_agua_lista_caja").html(data);
              },
              error: function() {
                $(".body-contribuyente_agua_lista_caja").html(errordata);
              }
            }); 
      }
  pasar_parametro_get_consulta_agua_caja(id) {
        window.location =
          "index.php?ruta=caja-agua&id=" + id;
  }

 
  MostrarLicencia_deuda(idCatastroAgua_deuda) {
    $.ajax({
      type: "POST",
      url: "ajax/licenciaagua.ajax.php",
      data: {
        idCatastroAgua_deuda: idCatastroAgua_deuda,
      },
      success: function (respuesta) {
        //console.log(respuesta);
        $("#listaLicenciasAgua_deuda").html(respuesta);
        //Seleccionando la licencia para mostrar su estado de cuenta
      },
    });
  }

  MostrarEstadoCuentaAgua_caja(idlicencia){
    let self=this;
    $.ajax({
      type: "POST",
      url: "ajax/licenciaagua.ajax.php",
      data: {
        idlicenciaagua_estadocuenta: idlicencia,
      },
      success: function (respuesta) {
        $("#listaLicenciasAgua_estadocuenta_caja").html(respuesta);
       
            // Función para manejar el clic en las filas de la tabla y sumar los valores
            $("#primeraTabla_agua_caja tbody tr").on("click", function () {
              self.manejarClicFila_agua($(this));
            });
            // Función para manejar el clic en el encabezado "S"
            $("#primeraTabla_agua_caja thead th:eq(9)").on("click", function () {
              self.manejarClicS($(this));
            });
      },
    });

  }
  manejarClicS(thS) {
    const filas = $("#primeraTabla_agua_caja tbody tr");
    let filasSeleccionadas = $("td:eq(9):contains('1')", filas).length;

    if (filasSeleccionadas === filas.length) {
        // Todas están seleccionadas, deseleccionarlas todas
        filas.each((index, fila) => {
            this.manejarClicFila_agua($(fila));
        });
    } else {
        // Solo seleccionar hasta 12 filas
        let contador = filasSeleccionadas;
        filas.each((index, fila) => {
            if ($(fila).find("td:eq(9)").text() !== "1" && contador < 12) {
                this.manejarClicFila_agua($(fila));
                contador++;
            }
        });

        // Mostrar mensaje si intenta seleccionar más de 12
        if (contador >= 12) {
            alert("Solo puedes seleccionar un máximo de 12 filas.");
        }
    }

    thS.text(filasSeleccionadas === filas.length ? "S" : "S");

    // Actualizar totales en la segunda tabla
    $("#segundaTabla_agua_caja tbody th:eq(4)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla_agua_caja tbody th:eq(5)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla_agua_caja tbody th:eq(6)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla_agua_caja tbody th:eq(7)").text(this.totalTIM.toFixed(2));
    $("#segundaTabla_agua_caja tbody th:eq(8)").text(this.totalTotal.toFixed(2));
}
 
  

  manejarClicFila_agua(fila) {
    const estadoS = fila.find("td:eq(9)").text();
    const filaId = fila.attr("id");

    // Verifica si ya se han seleccionado 12 filas
    if (estadoS !== "1" && this.idsSeleccionados.length >= 12) {
        alert("Solo puedes seleccionar un máximo de 12 filas.");
        return;
    }

    const gasto = parseFloat(fila.find("td:eq(5)").text());
    const subtotal = parseFloat(fila.find("td:eq(6)").text());
    const tim = parseFloat(fila.find("td:eq(7)").text());
    const total = parseFloat(fila.find("td:eq(8)").text());
    const importe = parseFloat(fila.find("td:eq(4)").text());

    if (estadoS === "1") {
        // Deseleccionar fila
        this.totalGasto -= gasto;
        this.totalSubtotal -= subtotal;
        this.totalTIM -= tim;
        this.totalTotal -= total;
        this.totalImporte -= importe;

        fila.find("td:eq(9)").text("");
        fila.css("background-color", "");

        // Eliminar la fila del array de seleccionados
        const index = this.idsSeleccionados.indexOf(filaId);
        if (index > -1) {
            this.idsSeleccionados.splice(index, 1);
        }
    } else {
        // Seleccionar fila
        this.totalGasto += gasto;
        this.totalSubtotal += subtotal;
        this.totalTIM += tim;
        this.totalTotal += total;
        this.totalImporte += importe;
        fila.find("td:eq(9)").text("1");
        fila.css("background-color", "rgb(255, 248, 167)");

        // Agregar la fila al array de seleccionados
        this.idsSeleccionados.push(filaId);
    }

    // Actualización de las celdas de la segunda tabla
    $("#segundaTabla_agua_caja tbody th:eq(4)").text(this.totalImporte.toFixed(2));
    $("#segundaTabla_agua_caja tbody th:eq(5)").text(this.totalGasto.toFixed(2));
    $("#segundaTabla_agua_caja tbody th:eq(6)").text(this.totalSubtotal.toFixed(2));
    $("#segundaTabla_agua_caja tbody th:eq(7)").text(this.totalTIM.toFixed(2));
    $("#segundaTabla_agua_caja tbody th:eq(8)").text(this.totalTotal.toFixed(2));

    document.getElementById('total_agua').innerHTML = this.totalImporte === 0 ? '0.00' : this.totalImporte.toFixed(2);
    document.getElementById('total_caja').innerHTML = this.totalTotal.toFixed(2);
    document.getElementById('total_confirmar_agua').innerHTML = 'S/.' + this.totalTotal.toFixed(2);

    console.log("Ids seleccionados:", this.idsSeleccionados);
    document.getElementById('efectivo').value = "";
    document.getElementById('vuelto').value = "";
}


  ajustarAnchoColumnas_agua_caja() {
    // Obtén el ancho de las columnas de la primera tabla
    var primeraTabla_agua = document.getElementById('primeraTabla_agua_caja');
    var columnasPrimeraTabla_agua = primeraTabla_agua.rows[0].cells; // Suponiendo que la primera fila tiene los encabezados

    // Aplica el ancho de las columnas de la primera tabla a la segunda tabla
    var segundaTabla_agua = document.getElementById('segundaTabla_agua_caja');
    var columnasSegundaTabla_agua = segundaTabla_agua.rows[0].cells;

    for (var i = 0; i < columnasPrimeraTabla_agua.length; i++) {
      columnasSegundaTabla_agua[i].style.width = columnasPrimeraTabla_agua[i].offsetWidth + 'px';
    }
  }
  
  //funcion para llamar el tipo de papel
  inicializarTipoPapel() {
    caja.tipo_papel(function() {
    }.bind(this));
}

  imprimirhere_agua() {

    let papel=null;
    const Propietarios_ = []; // Declarar un arreglo vacío
    $("#id_propietarios tr").each(function (index){
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

    //datos enviando para cambiar de deuda a cancelado
    let datos = new FormData();
    datos.append("idlicencia",this.idlicenciaagua_caja);
    datos.append("id_cuenta",idsSeleccionados_);
    datos.append("cobrar_caja_agua","cobrar_caja_agua");

    

    let datos_baucher = new FormData();
    datos_baucher.append("idlicencia",this.idlicenciaagua_caja);
    datos_baucher.append("id_cuenta",idsSeleccionados_);
    datos_baucher.append("propietarios",Propietarios);
    datos_baucher.append("totalImporte",this.totalImporte.toFixed(2));
    datos_baucher.append("totalGasto",this.totalGasto.toFixed(2));
    datos_baucher.append("totalSubtotal",this.totalSubtotal.toFixed(2));
    datos_baucher.append("totalTIM",this.totalTIM.toFixed(2));
    datos_baucher.append("totalTotal",this.totalTotal.toFixed(2));

  for (const pair of datos.entries()) {
    
      console.log(pair[0] + ", " + pair[1]);
    }


    for (const pair of datos_baucher.entries()) {
      
      console.log(pair[0] + ", " + pair[1]);
    }


    $.ajax({
      url: "ajax/caja.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
      
        if (respuesta.tipo === "correcto") {
          $("#modalPagar_si_no_agua").modal("hide");
          $("#respuestaAjax_srm").show();
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          
          agua_caja.MostrarEstadoCuentaAgua_caja(agua_caja.idlicenciaagua_caja);

          caja.n_recibo();//se mantiene
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 4000);
        let self=this; 
         //se asigna el tipo de papel en la funcion 
         agua_caja.inicializarTipoPapel()            
                  // if(caja.tipo_papel_valor=='1'){
                  //   $.ajax({
                  //     url: "./vistas/print/imprimirBoletaAguaA4.php",
                  //     method: "POST",
                  //     data: datos_baucher,
                  //     cache: false,
                  //     contentType: false,
                  //     processData: false,
                  //     success: function (rutaArchivo) {
                  //       // Establecer el src del iframe con la ruta relativa del PDF
                  //       document.getElementById("iframe_agua_caja").src = 'vistas/print/' + rutaArchivo;
                  //       $("#Modalimprimir_cuentaagua_caja").modal("show");
                  //     }
                  //   });
                  // } 
                // else if(self.tipo_papel_valor=='2'){
                //     $.ajax({
                //       url: "./vistas/print/imprimirBoletaA4_3.php",
                //       method: "POST",
                //       data: datos_baucher,
                //       cache: false,
                //       contentType: false,
                //       processData: false,
                //       success: function (rutaArchivo) {
                //         // Establecer el src del iframe con la ruta relativa del PDF
                //         document.getElementById("iframe_agua_caja").src = 'vistas/print/' + rutaArchivo;
                //         $("#Modalimprimir_cuentaagua_caja").modal("show");
                //       }
                //     });
                //   }
                 // else {
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
                          '</button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">Se genero el recibo correctamente nn!</span></p></div>'
                      );
                      setTimeout(function () {
                      $("#respuestaAjax_srm").hide();
                       }, 5000);
                      }
                       });
                //  }    
            
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
        
      }
    }); 
    
    



  }

  reniciar_valor_caja(){
    this.totalImporte = 0;
    this.totalGasto = 0;
    this.totalSubtotal = 0;
    this.totalTIM = 0;
    this.totalTotal = 0;
    this.idsSeleccionados = [];

    this.vuelto=0;
   this.efectivo=0;

            this.idsSeleccionados_caja=[];
            $("#segundaTabla_agua_caja tbody td:eq(4)").text(this.totalImporte.toFixed(2));
            $("#segundaTabla_agua_caja tbody td:eq(5)").text(this.totalGasto.toFixed(2));
            $("#segundaTabla_agua_caja tbody td:eq(6)").text(this.totalSubtotal.toFixed(2));
            $("#segundaTabla_agua_caja tbody td:eq(7)").text(this.totalTIM.toFixed(2));
            $("#segundaTabla_agua_caja tbody td:eq(8)").text(this.totalTotal.toFixed(2));
            
            document.getElementById('total_agua').innerHTML = (this.totalTotal ==0) ? '0.00' : Math.max(this.totalTotal, 0).toFixed(2);;
            document.getElementById('total_confirmar_agua').innerHTML = 'S/.' +this.totalTotal.toFixed(2);
            document.getElementById('total_caja').innerHTML = this.totalTotal.toFixed(2);
  }

}

  const agua_caja = new ConsultaDeudaAguaCajaClass();
  //caja.tipo_papel();
  document.addEventListener('DOMContentLoaded', function () {
    caja.n_recibo();
 
    
  })
  function sumarValores_agua() {
    agua_caja.efectivo=document.getElementById('efectivo').value;
    agua_caja.vuelto=agua_caja.efectivo-agua_caja.totalTotal;
    document.getElementById('vuelto').value =agua_caja.vuelto.toFixed(2);
  }
  function lista_contribuyente_agua_caja(page, searchClass) {
    if (event.keyCode === 13) {
      agua_caja.contribibuyente_aguacaja_lista_func(page,searchClass);
      event.preventDefault();
    }
}

  //PASAR EL VALOR DE CONTRIBUYENTE BUSCADO A PREDIOS POR GET - VALIDADO para caja
$(document).on("click", ".btncaja_agua", function () {
    let id = $(this).attr("idUsuario_agua");
    agua_caja.pasar_parametro_get_consulta_agua_caja(id);
  });
 
$(document).on("click", "#tablalistaprediosAgua_consulta_caja tbody tr", function() {
    //consulta_deuda_agua_lista.idCatastroC_consulta_agua = $(this).find("td:nth-child(4)").text();
    //consulta_deuda_agua_lista.ubiLicenciaC_consulta_agua = $(this).find("td:nth-child(3)").text();
     
    $("#tablalistaprediosAgua_consulta_caja tbody tr").not(this).css("background-color", "");
    $(this).css("background-color", "rgb(255, 248, 167)");
    // Aquí puedes continuar con el resto de tu lógica si es necesario
   // agua_caja.codCatastroC_consulta_agua = $(this).attr("idcatastro");
    //consulta_deuda_agua_lista.seleccionar_predio();   
    agua_caja.idlicenciaagua_caja = $(this).attr("idlicenciaagua_caja");
    console.log("iDlicencia agua:"+agua_caja.idlicenciaagua_caja)
    agua_caja.MostrarEstadoCuentaAgua_caja(agua_caja.idlicenciaagua_caja);
  
    agua_caja.ajustarAnchoColumnas_agua_caja();
});

$(document).on("click", "#tablalistaLicences tbody tr", function() {
    //consulta_deuda_agua_lista.idCatastroC_consulta_agua = $(this).find("td:nth-child(4)").text();
    //consulta_deuda_agua_lista.ubiLicenciaC_consulta_agua = $(this).find("td:nth-child(3)").text();
    $("#tablalistaLicences tbody tr").not(this).css("background-color", "");
    $(this).css("background-color", "rgb(255, 248, 167)");
    console.log("fuck papel:"+agua_caja.tipo_papel_agua);
});


//Mostrar el Pop up para confirma si pagar o no
$(document).on("click", ".generar_boleta_agua", function () {
 
  
  if(agua_caja.totalTotal>0){ 
  $('#modalPagar_si_no_agua').modal('show');
  //miInstanciaImprimir.imprimirDJ();
  }
  else{
    var html_respuesta=' <div class="col-sm-30">'+
    '<div class="alert alert-warning">'+
      '<button type="button" class="close font__size-18" data-dismiss="alert">'+
      '</button>'+
      '<i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>'+
      '<strong class="font__weight-semibold">Alerta!</strong> Seleccione el estado de Cuenta.'+
    '</div>'+
  '</div>';
  $("#respuestaAjax_srm").html(html_respuesta);
  $("#respuestaAjax_srm").show();
  setTimeout(function () {
  $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
  },5000);
  }

})

//Generar la boleta de pago de agua 
$(document).on("click", ".print_boleta_agua", function () {
  //$('#modalPagar_si_no').modal('hide');
  agua_caja.imprimirhere_agua();
  agua_caja.reniciar_valor_caja();
  //$("#Modalimprimir_LA").modal("show");
})












  