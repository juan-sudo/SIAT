
class CoactivoClass {
    constructor() {

     this.fechafiltro=null;
     this.numero_caja=null;

     this.fechaFiltroInicio=null;
     this.fechaFiltroFin=null;

     this.fechaFiltroInicioA=null;
     this.fechaFiltroFinA=null;
    }


    //IMPUESTO PREDIAL
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


   //ARBITRIOS
   fecha_coactivo_a(){
        // Obtener la fecha actual
        var fechaActual = new Date();
      
        // Formatear la fecha INICIO
        var year = fechaActual.getFullYear();
        var month = String(fechaActual.getMonth() + 1).padStart(2, '0'); // Los meses comienzan desde 0
        var day = String(fechaActual.getDate()).padStart(2, '0');
        var fechaFormateada = year + '-' + month + '-' + day;
        this.fechaFiltroInicioA=fechaFormateada
        // Asignar la fecha formateada al campo de entrada
        document.getElementById('fecha_filtro_inicio_a').value = fechaFormateada;
        console.log(this.fechaFiltroInicio);


          // Formatear la fecha FIN
        var year = fechaActual.getFullYear();
        var month = String(fechaActual.getMonth() + 1).padStart(2, '0'); // Los meses comienzan desde 0
        var day = String(fechaActual.getDate()).padStart(2, '0');
        var fechaFormateada = year + '-' + month + '-' + day;
        this.fechaFiltroFinA=fechaFormateada
        // Asignar la fecha formateada al campo de entrada
        document.getElementById('fecha_filtro_fin_a').value = fechaFormateada;
        console.log(this.fechaFiltroFin);



  }


  //IMPUESTO PREDIAL
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



    //ARBITRIO MUNICIPAL

    
 lista_coactivo_a(fechaInicio, fechaFin) {
        let datos = new FormData();
        datos.append("fecha_inicio", fechaInicio);
        datos.append("fecha_fin", fechaFin);
        datos.append("lista_coactivo_a", "lista_coactivo_a");
        

        
      // Mostrar contenido de FormData con for...of
      for (let pair of datos.entries()) {
          console.log(pair[0] + ': ' + pair[1]);
      }
       
        $.ajax({
            url: "ajax/coactivo.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
              $("#total_ingreso_coactivo_a").html(loadingMessage);
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
                $('#reporte_ingreso_coactivo_a').html(rows);
                $('#total_ingreso_coactivo_a').text('0.00'); // Reiniciar total si no hay datos
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

                $('#reporte_ingreso_coactivo_a').html(rows);
                $('#total_ingreso_coactivo_a').text(total.toFixed(2)); // Mostrar total con 2 decimales
            }
          }

        });
    }



}

  const coactivo = new CoactivoClass();


document.addEventListener('DOMContentLoaded', function () {
    // Cargar fechas y datos para Impuesto Predial
    coactivo.fecha_coactivo();
    coactivo.lista_coactivo(coactivo.fechaFiltroInicio, coactivo.fechaFiltroFin);

    // Cargar fechas y datos para Arbitrio Municipal
    coactivo.fecha_coactivo_a();
    coactivo.lista_coactivo_a(coactivo.fechaFiltroInicioA, coactivo.fechaFiltroFinA);
});


//IMPUETO PRDIAL
$(document).on("change", "#fecha_filtro_inicio, #fecha_filtro_fin", function () {
    coactivo.fechaFiltroInicio = $("#fecha_filtro_inicio").val();
    coactivo.fechaFiltroFin = $("#fecha_filtro_fin").val();
    coactivo.lista_coactivo(coactivo.fechaFiltroInicio, coactivo.fechaFiltroFin);
});

//IMPUETO PRDIAL
$(document).on("change", "#fecha_filtro_inicio_a, #fecha_filtro_fin_a", function () {
    coactivo.fechaFiltroInicioA = $("#fecha_filtro_inicio_a").val();
    coactivo.fechaFiltroFinA = $("#fecha_filtro_fin_a").val();
    coactivo.lista_coactivo_a(coactivo.fechaFiltroInicioA, coactivo.fechaFiltroFinA);
});


