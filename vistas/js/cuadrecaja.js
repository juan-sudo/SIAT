
class CuadreCajaClass {
    constructor() {
     this.fechafiltro=null;
  
    }
   fecha_cuadrecaja(){
        // Obtener la fecha actual
        var fechaActual = new Date();
      
        // Formatear la fecha como YYYY-MM-DD
        var year = fechaActual.getFullYear();
        var month = String(fechaActual.getMonth() + 1).padStart(2, '0'); // Los meses comienzan desde 0
        var day = String(fechaActual.getDate()).padStart(2, '0');
        var fechaFormateada = year + '-' + month + '-' + day;
        this.fechafiltro=fechaFormateada
        // Asignar la fecha formateada al campo de entrada
        document.getElementById('fecha').value = fechaFormateada;
        console.log(this.fechafiltro);
      }
    cuadre_tributos_agua(fecha){
        let datos = new FormData();
        datos.append("fecha",fecha);
        datos.append("cuadre_tributoagua", "cuadre_tributoagua");
        console.log(typeof this.fechafiltro);

        $.ajax({
            url: "ajax/reporte.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $("#reporte_tributosagua").html(respuesta); 
                console.log(respuesta);
            }
        });
      //reporte de total de ingresos de tributos y agua
      let datos_total = new FormData();
        datos_total.append("fecha",fecha);
        datos_total.append("cuadre_tributoagua_total", "cuadre_tributoagua_total");
        $.ajax({
          url: "ajax/reporte.ajax.php",
          method: "POST",
          data: datos_total,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta_total) {
            //  $("#reporte_tributosagua").html(respuesta); 
            $('#importe').text(respuesta_total['Suma_Importe']);
            $('#gasto').text(respuesta_total['Suma_Gasto_Emision']);
            $('#subtotal').text(respuesta_total['Suma_Total']);
            $('#desc').text(respuesta_total['Suma_Descuento']);
            $('#tim').text(respuesta_total['Suma_TIM']);
            $('#total').text(respuesta_total['Suma_Total_Pagar']);
          }
      });
      cuadre_caja.ajustarAnchoColumnas_cuadre();

      //reporte de total de ingresos de tributos y agua
      let datos_tributos = new FormData();
      datos_tributos.append("fecha",fecha);
      datos_tributos.append("cuadre_tributoagua_report", "cuadre_tributoagua_report");
        $.ajax({
          url: "ajax/reporte.ajax.php",
          method: "POST",
          data: datos_tributos,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta_report) {
             $("#reporte_ingresos_cuadre").html(respuesta_report);  
          }
      });

      //reporte de total de ingresos de tributos y agua presupuesta
      let datos_presupuesto = new FormData();
      datos_presupuesto.append("fecha",fecha);
      datos_presupuesto.append("cuadre_tributoagua_presu", "cuadre_tributoagua_presu");
        $.ajax({
          url: "ajax/reporte.ajax.php",
          method: "POST",
          data: datos_presupuesto,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta_presu) {
             $("#reporte_ingresos_presu").html(respuesta_presu);  
          }
      });

    }
    ajustarAnchoColumnas_cuadre() {
      // Obtén el ancho de las columnas de la primera tabla
      var primeraTabla_agua = document.getElementById('primeraTabla_cuadre');
      var columnasPrimeraTabla_agua = primeraTabla_agua.rows[0].cells; // Suponiendo que la primera fila tiene los encabezados
  
      // Aplica el ancho de las columnas de la primera tabla a la segunda tabla
      var segundaTabla_agua = document.getElementById('segundaTabla_cuadre');
      var columnasSegundaTabla_agua = segundaTabla_agua.rows[0].cells;
  
      for (var i = 0; i < columnasPrimeraTabla_agua.length; i++) {
        columnasSegundaTabla_agua[i].style.width = columnasPrimeraTabla_agua[i].offsetWidth + 'px';
      }
    }

}

  const cuadre_caja = new CuadreCajaClass();
  //caja.tipo_papel();
  document.addEventListener('DOMContentLoaded', function () {
    cuadre_caja.fecha_cuadrecaja();
    cuadre_caja.cuadre_tributos_agua(cuadre_caja.fechafiltro);  
    
  })
  $(document).on("change", "#fecha", function () {
    cuadre_caja.fechafiltro = $("#fecha").val();
    cuadre_caja.cuadre_tributos_agua(cuadre_caja.fechafiltro)
    console.log("nueva fecha:"+ cuadre_caja.fechafiltro);
});


