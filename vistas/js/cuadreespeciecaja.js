
class CuadreCajaEspecieClass {
    constructor() {
     this.fechafiltro=null;
  
    }
   fecha_cuadrecaja_especie(){
        // Obtener la fecha actual
        var fechaActual = new Date();
      
        // Formatear la fecha como YYYY-MM-DD
        var year = fechaActual.getFullYear();
        var month = String(fechaActual.getMonth() + 1).padStart(2, '0'); // Los meses comienzan desde 0
        var day = String(fechaActual.getDate()).padStart(2, '0');
        var fechaFormateada = year + '-' + month + '-' + day;
        this.fechafiltro=fechaFormateada
        // Asignar la fecha formateada al campo de entrada
        document.getElementById('fecha_especie').value = fechaFormateada;
        console.log(this.fechafiltro);
      }
    cuadre_especie(fecha){
        let datos = new FormData();
        datos.append("fecha_especie",fecha);
        datos.append("cuadre_especie", "cuadre_especie");
        console.log(typeof this.fechafiltro);

        $.ajax({
            url: "ajax/reporte.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $("#reporte_especie").html(respuesta); 
                console.log(respuesta);
            }
        });
      //reporte de total de ingresos de especie
      let datos_total = new FormData();
        datos_total.append("fecha",fecha);
        datos_total.append("cuadre_especie_total", "cuadre_especie_total");
        $.ajax({
          url: "ajax/reporte.ajax.php",
          method: "POST",
          data: datos_total,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta_total) {
            //  $("#reporte_tributosagua").html(respuesta); 
            $('#especie_total').text(respuesta_total['Total']);
          }
      });
      cuadre_caja_especie.ajustarAnchoColumnas_cuadre();

      //reporte de consolidado presupuesta especie presupuestal
      let datos_especie = new FormData();
      datos_especie.append("fecha",fecha);
      datos_especie.append("cuadre_especie_report", "cuadre_especie_report");
        $.ajax({
          url: "ajax/reporte.ajax.php",
          method: "POST",
          data: datos_especie,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta_report) {
             $("#reporte_especie_cuadre").html(respuesta_report);  
          }
      });

      //reporte de total de ingresos de especies-valoradas - oficina
      let datos_area = new FormData();
      datos_area.append("fecha",fecha);
      datos_area.append("cuadre_especie_area", "cuadre_especie_area");
        $.ajax({
          url: "ajax/reporte.ajax.php",
          method: "POST",
          data: datos_area,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta_presu) {
             $("#reporte_especie_area").html(respuesta_presu);  
          }
      });
    }
    ajustarAnchoColumnas_cuadre() {
      // Obtén el ancho de las columnas de la primera tabla
      var primeraTabla_agua = document.getElementById('primeraTabla_cuadre_especie');
      var columnasPrimeraTabla_agua = primeraTabla_agua.rows[0].cells; // Suponiendo que la primera fila tiene los encabezados
      // Aplica el ancho de las columnas de la primera tabla a la segunda tabla
      var segundaTabla_agua = document.getElementById('segundaTabla_cuadre_especie');
      var columnasSegundaTabla_agua = segundaTabla_agua.rows[0].cells;
  
      for (var i = 0; i < columnasPrimeraTabla_agua.length; i++) {
        columnasSegundaTabla_agua[i].style.width = columnasPrimeraTabla_agua[i].offsetWidth + 'px';
      }
    }

}

  const cuadre_caja_especie = new CuadreCajaEspecieClass();
  //caja.tipo_papel();
  document.addEventListener('DOMContentLoaded', function () {
    cuadre_caja_especie.fecha_cuadrecaja_especie();
    cuadre_caja_especie.cuadre_especie(cuadre_caja_especie.fechafiltro);  
    
  })
  $(document).on("change", "#fecha_especie", function () {
    cuadre_caja_especie.fechafiltro = $("#fecha_especie").val();
    cuadre_caja_especie.cuadre_especie(cuadre_caja_especie.fechafiltro)
    console.log("nueva fecha:"+ cuadre_caja_especie.fechafiltro);
});


