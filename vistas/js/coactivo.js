
class CoactivoClass {
    constructor() {

     this.fechafiltro=null;
     this.numero_caja=null;

     this.fechaFiltroInicio=null;
     this.fechaFiltroFin=null;
    }


   fecha_coactivo(){
        // Obtener la fecha actual
        var fechaActual = new Date();
      
        // Formatear la fecha INICIO
        var year = fechaActual.getFullYear();
        var month = String(fechaActual.getMonth() + 1).padStart(2, '0'); // Los meses comienzan desde 0
        var day = String(fechaActual.getDate()).padStart(2, '0');
        var fechaFormateada = year + '-' + month + '-' + day;
        this.fechaFiltroInicio=fechaFormateada
        // Asignar la fecha formateada al campo de entrada
        document.getElementById('fecha_filtro_inicio').value = fechaFormateada;
        console.log(this.fechaFiltroInicio);


          // Formatear la fecha FIN
        var year = fechaActual.getFullYear();
        var month = String(fechaActual.getMonth() + 1).padStart(2, '0'); // Los meses comienzan desde 0
        var day = String(fechaActual.getDate()).padStart(2, '0');
        var fechaFormateada = year + '-' + month + '-' + day;
        this.fechaFiltroFin=fechaFormateada
        // Asignar la fecha formateada al campo de entrada
        document.getElementById('fecha_filtro_fin').value = fechaFormateada;
        console.log(this.fechaFiltroFin);



  }



 lista_coactivo(fechaInicio, fechaFin) {
        let datos = new FormData();
        datos.append("fecha_inicio", fechaInicio);
        datos.append("fecha_fin", fechaFin);
        datos.append("lista_coactivo", "lista_coactivo");
        

        
      // Mostrar contenido de FormData con for...of
      for (let pair of datos.entries()) {
          console.log(pair[0] + ': ' + pair[1]);
      }
        // datos.append("fecha",fecha);
        // datos.append("lista_coactivo", "lista_coactivo");
        // console.log(typeof this.fechafiltro);

        $.ajax({
            url: "ajax/coactivo.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
              $("#reporte_ingreso_coactivo").html(loadingMessage);
            },
            success: function (respuesta) {
            console.log(respuesta);
            $("#modal_cargar").modal("hide");

            if(respuesta.length === 0){
                const rows = `
                    <tr>
                        <td class="text-center" colspan="6">No hay registro de Pagos de fecha<b>  `+ extorno.fechafiltro+`</b></td>
                    </tr>
                `;
                $('#reporte_ingreso_coactivo').html(rows);
                $('#total_ingreso_coactivo').text('0.00'); // Reiniciar total si no hay datos
            } else {
                let total = 0;

                const rows = respuesta.map(rowData => {
                    let valor = parseFloat(rowData[2]) || 0; // Asegúrate de convertir a número
                    total += valor;

                    return `
                        <tr>
                            <td class="text-center" style="width: 50px;">${rowData[0]}</td>
                            <td class="text-center" style="width: 50px;">${rowData[1]}</td>
                            <td class="text-center" style="width: 50px;">${valor.toFixed(2)}</td>
                        </tr>
                    `;
                }).join('');

                $('#reporte_ingreso_coactivo').html(rows);
                $('#total_ingreso_coactivo').text(total.toFixed(2)); // Mostrar total con 2 decimales
            }
          }

        });
    }





    // extornar(numero_caja){
    //   let datos = new FormData();
    //     datos.append("numero_caja",numero_caja);
    //     datos.append("extornar", "extornar");
    //     let self = this;
    //     $.ajax({
    //         url: "ajax/caja.ajax.php",
    //         method: "POST",
    //         data: datos,
    //         cache: false,
    //         contentType: false,
    //         processData: false,
    //         beforeSend: function() {
    //           $(".cargando").html(loadingMessage_s);
    //           $("#modal_cargar").modal("show");
    //         },
    //         success: function (respuesta) {
    //           $("#modal_cargar").modal("hide");
    //           self.lista_extorno(extorno.fechafiltro);
    //           if (respuesta.tipo === "correcto") {
               
    //             $("#respuestaAjax_srm").html(respuesta.mensaje);
    //             $("#respuestaAjax_srm").show();
    //             setTimeout(function () {
    //               $("#respuestaAjax_srm").hide();
    //             }, 5000);
    //           }
    //           else{
    //             $("#respuestaAjax_srm").html(respuesta.mensaje);
    //             $("#respuestaAjax_srm").show();
    //             setTimeout(function () {
    //               $("#respuestaAjax_srm").hide();
    //             }, 5000);
    //           }
    //         }
    //         });
      
    // }

}

  const coactivo = new CoactivoClass();

  //caja.tipo_papel();
// document.addEventListener('DOMContentLoaded', function () {
//     coactivo.fecha_coactivo();

//     coactivo.lista_coactivo(coactivo.fechafiltroInicio);  

// })

document.addEventListener('DOMContentLoaded', function () {
    coactivo.fecha_coactivo();

   // coactivo.fechaFiltroInicio = document.getElementById("fecha_filtro_inicio").value;
   // coactivo.fechaFiltroFin = document.getElementById("fecha_filtro_fin").value;

    coactivo.lista_coactivo(coactivo.fechaFiltroInicio, coactivo.fechaFiltroFin);
});



// $(document).on("change", "#fecha_filtro_inicio", function () {

//     coactivo.fechafiltroInicio = $("#fecha_filtro_inicio").val();

//     coactivo.lista_coactivo(coactivo.fechafiltroInicio)
   
//     console.log("nueva fecha:"+ coactivo.fechafiltro);
// });


$(document).on("change", "#fecha_filtro_inicio, #fecha_filtro_fin", function () {
    coactivo.fechaFiltroInicio = $("#fecha_filtro_inicio").val();
    coactivo.fechaFiltroFin = $("#fecha_filtro_fin").val();
    coactivo.lista_coactivo(coactivo.fechaFiltroInicio, coactivo.fechaFiltroFin);
});



$(document).on("click", ".link", function(e) {
  coactivo.numero_caja = $(this).attr('numero_caja');
  $("#nr_extorno").text(coactivo.numero_caja);
  $('#modalExtornar_si_no').modal('show');
});

$(document).on("click", ".extornar_si", function(e) {
  e.preventDefault();
  $('#modalExtornar_si_no').modal('hide');
  coactivo.extornar(coactivo.numero_caja);
  console.log(coactivo.numero_caja);
});
