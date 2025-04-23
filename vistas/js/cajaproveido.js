class CajaProveido {
    constructor() {
     this.id_area="";
     this.id_proveido=0;
     this.numero_proveido=0;
     this.total_proveido=0;
     this.efectivo_proveido=0;
     this.vuelto_proveido=0;
     this.total_caja_proveido=0;
     this.fechafiltro=null;
    
    }
    reniciar_valores_proveido(){
        this.total_caja_proveido=0;
        this.efectivo_proveido=0;
        this.vuelto_proveido=0;
        this.total_caja_proveido=0;

    }
    listaproveidos(fecha) {
        let self = this;
        let datos = new FormData();
        datos.append("lista_proveidos","lista_proveidos");
        datos.append("fecha",fecha);
        console.log("fecha:"+fecha);
        
        $.ajax({
          url: "ajax/caja.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            $(".listaproveidoscaja").html(respuesta);
                var tabla = document.getElementById("tablaproveidos");
                var tbody = tabla.querySelector("tbody");
                var filas = tbody.getElementsByTagName("tr");
                // Agregar un evento onclick a cada fila del tbody
                for (let i = 0; i < filas.length; i++) {
                filas[i].addEventListener("click", function () {
                    // Restaurar el color de fondo de todas las filas del tbody
                    const filasTbody = tbody.getElementsByTagName("tr");
                    for (let j = 0; j < filasTbody.length; j++) {
                    filasTbody[j].style.backgroundColor = "";
                    }
                    this.style.backgroundColor = "rgb(255, 248, 167)";
                    // Obtener el valor del atributo n_proveido de la fila seleccionada
                    self.numero_proveido = this.getAttribute('n_proveido');
                    self.id_proveido = this.getAttribute('idproveido');
                    console.log("numero_proveido: " + self.id_proveido);
                    
                    this.total_proveido = this.getAttribute('total_proveido');
                    document.getElementById('total_proveido').innerHTML = this.total_proveido;
                    document.getElementById('total_caja_proveido').innerHTML = this.total_proveido;

                    document.getElementById('efectivo_proveido').value="";
                    document.getElementById('vuelto_proveido').value = "";
                    
                });
                }
          }
        })
      }
      lista_area() {
        let datos = new FormData();
        this.tipo_tributo=document.getElementById('select_area').value;
        datos.append("lista_area","lista_area");
        $.ajax({
          url: "ajax/caja.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            document.getElementById('nc').innerHTML = respuesta['Numero_Recibo']+1;
          }
        })
      }

      imprimirRecibo_pro(){
        let self = this;
        let datos = new FormData();
          datos.append("id_proveido",self.id_proveido);
          datos.append("id_usuario",usuario.idusuario_sesion);
          datos.append("cobrar_proveido","cobrar_proveido");
          console.log("ID PROVEIDO BAUCHER:" +self.id_proveido);
          //valores para caja 
          let datos_baucher = new FormData();
          self.reniciar_valores_proveido();
          caja.tipo_papel(function () {
            console.log("paper:" + caja.tipo_papel_valor);
          });
          datos_baucher.append("id_proveido",self.id_proveido);
          $.ajax({
            url: "ajax/caja.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
              cajaproveido.listaproveidos(cajaproveido.fechafiltro);
              $("#modalPagar_proveido_si_no").modal("hide");
              if (respuesta.tipo === "correcto") {
                caja.n_recibo();
                          if(caja.tipo_papel_valor===1){
                            $.ajax({
                              url: "./vistas/print/imprimirBoletaProveidoA4.php",
                              method: "POST",
                              data: datos_baucher,
                              cache: false,
                              contentType: false,
                              processData: false,
                              success: function (rutaArchivo) {
                                // Establecer el src del iframe con la ruta relativa del PDF
                                document.getElementById("iframe_proveido_A4").src = 'vistas/print/' + rutaArchivo;
                                $("#Modalimprimir_boleta_proveido").modal("show");
                              }
                            });
                          } 
                        else if(caja.tipo_papel_valor===2){
                            $.ajax({
                              url: "./vistas/print/imprimirBoletaProveidoA4_3.php",
                              method: "POST",
                              data: datos_baucher,
                              cache: false,
                              contentType: false,
                              processData: false,
                              success: function (rutaArchivo) {
                                // Establecer el src del iframe con la ruta relativa del PDF
                                document.getElementById("iframe_proveido_A4").src = 'vistas/print/' + rutaArchivo;
                                $("#Modalimprimir_boleta_proveido").modal("show");
                              }
                            });
                          }
                          else {
                            $.ajax({
                              url: "ajax/imprimirProveido.php",
                              method: "POST",
                              data: datos_baucher,
                              cache: false,
                              contentType: false,
                              processData: false,
                              success: function (rutaArchivo) {
                                // Establecer el src del iframe con la ruta relativa del PDF
                                //}  document.getElementById("iframe_proveido_A4").src = 'vistas/print/' + rutaArchivo;
                                //$("#Modalimprimir_boleta_proveido").modal("show");
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
                              }
                            });
                          }    
                 
              } else if (respuesta.tipo === "advertencia") {
                $("#modalPagar_si_no").modal("hide");
                $("#respuestaAjax_srm").html(respuesta.mensaje);
                $("#respuestaAjax_srm").show();
                self.listaproveidos(caja.idContribuyente_caja);
                caja.n_recibo();
                setTimeout(function () {
                  $("#respuestaAjax_correcto").hide();
                }, 5000);
              }
              
            }
          });     
    }

 fecha_caja_proveido(){
      // Obtener la fecha actual
      var fechaActual = new Date();
    
      // Formatear la fecha como YYYY-MM-DD
      var year = fechaActual.getFullYear();
      var month = String(fechaActual.getMonth() + 1).padStart(2, '0'); // Los meses comienzan desde 0
      var day = String(fechaActual.getDate()).padStart(2, '0');
      var fechaFormateada = year + '-' + month + '-' + day;
      this.fechafiltro=fechaFormateada
      // Asignar la fecha formateada al campo de entrada
      document.getElementById('fecha_caja_proveido').value = fechaFormateada;
      console.log(this.fechafiltro);
 }

}
//fin de la clase y constructor
const cajaproveido = new CajaProveido();

  //obteniendo el valor pasado por get deesde lista de contribuyente caja - a caja 
  document.addEventListener('DOMContentLoaded', function () {
   cajaproveido.id_proveido=0;
   cajaproveido.fecha_caja_proveido();
   cajaproveido.listaproveidos(cajaproveido.fechafiltro);
   caja.n_recibo();
  })
  $(document).on("change", "#fecha_caja_proveido", function () {
    cajaproveido.fechafiltro = $("#fecha_caja_proveido").val();
    cajaproveido.listaproveidos(cajaproveido.fechafiltro)
    console.log("nueva fecha:"+ cajaproveido.fechafiltro);
});

  function sumarValores_proveido() {
    cajaproveido.efectivo_proveido=document.getElementById('efectivo_proveido').value;
    cajaproveido.total_caja_proveido=document.getElementById('total_caja_proveido').innerHTML;
    console.log(cajaproveido.total_caja_proveido);
    cajaproveido.vuelto_proveido=cajaproveido.efectivo_proveido-cajaproveido.total_caja_proveido;
    document.getElementById('vuelto_proveido').value = cajaproveido.vuelto_proveido.toFixed(2);
  }
  //dar click en la impresora para generar el pdf
  $(document).on("click", ".generar_boleta_proveido", function () {
    console.log("numero_proveido_IMPRIMIR: " + cajaproveido.numero_proveido);
    if(cajaproveido.id_proveido!=0){ 
    $('#modalPagar_proveido_si_no').modal('show');
    //miInstanciaImprimir.imprimirDJ();
    }
    else{
      var html_respuesta=' <div class="col-sm-30">'+
      '<div class="alert alert-warning">'+
        '<button type="button" class="close font__size-18" data-dismiss="alert">'+
        '</button>'+
        '<i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>'+
        '<strong class="font__weight-semibold">Alerta!</strong> Seleccione el Proveido.'+
      '</div>'+
    '</div>';
    $("#respuestaAjax_srm").html(html_respuesta);
    $("#respuestaAjax_srm").show();
    setTimeout(function () {
    $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
    },5000);
    }
  
  })

  //Mostrar el Pop up para confirma si pagar o no
$(document).on("click", ".print_boleta_proveido", function () {
  //$('#modalPagar_si_no').modal('hide');
  cajaproveido.imprimirRecibo_pro();
 
  //$("#Modalimprimir_LA").modal("show");
})