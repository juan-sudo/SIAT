
class ExtornoClass {
    constructor() {
     this.fechafiltro=null;
     this.numero_caja=null;
    }
   fecha_extorno(){
        // Obtener la fecha actual
        var fechaActual = new Date();
      
        // Formatear la fecha como YYYY-MM-DD
        var year = fechaActual.getFullYear();
        var month = String(fechaActual.getMonth() + 1).padStart(2, '0'); // Los meses comienzan desde 0
        var day = String(fechaActual.getDate()).padStart(2, '0');
        var fechaFormateada = year + '-' + month + '-' + day;
        this.fechafiltro=fechaFormateada
        // Asignar la fecha formateada al campo de entrada
        document.getElementById('fecha_extorno').value = fechaFormateada;
        console.log(this.fechafiltro);
  }
  lista_extorno(fecha){
        let datos = new FormData();
        datos.append("fecha",fecha);
        datos.append("lista_extorno", "lista_extorno");
        console.log(typeof this.fechafiltro);

        $.ajax({
            url: "ajax/reporte.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
              $("#reporte_extorno").html(loadingMessage);
            },
            success: function (respuesta) {
              $("#modal_cargar").modal("hide");
              if(respuesta.length === 0){
                    const rows = `
                    <tr>
                        <td class="text-center" colspan="6">No hay registro de Pagos de fecha<b>  `+ extorno.fechafiltro+`</b></td>
                    </tr>
                `;
                $('#reporte_extorno').html(rows);
              }
              else{
              const rows = respuesta.map(rowData => `
                <tr>
                    <td class="text-center" style="width: 50px;">${rowData[0]}</td>
                    <td class="text-center" style="width: 50px;">${rowData[1]}</td>
                    <td class="text-center" style="width: 50px;">${rowData[2]}</td>
                    <td class="text-center" style="width: 50px;">${rowData[3]}</td>
                    <td class="text-center" style="width: 50px;">${rowData[4] === null ? '-' : rowData[4]}</td>
                    <td class="text-center" style="width: 50px;">
                        ${rowData[3] === 'Extornado' ? '-' : `<a numero_caja='${rowData[1]}' class='link'>Extornar</a>`}
                    </td>
                </tr>
            `).join('');
            $('#reporte_extorno').html(rows);
                console.log(respuesta);
                
            }
          }
        });
    }
    extornar(numero_caja){
      let datos = new FormData();
        datos.append("numero_caja",numero_caja);
        datos.append("extornar", "extornar");
        let self = this;
        $.ajax({
            url: "ajax/caja.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
              $(".cargando").html(loadingMessage_s);
              $("#modal_cargar").modal("show");
            },
            success: function (respuesta) {
              $("#modal_cargar").modal("hide");
              self.lista_extorno(extorno.fechafiltro);
              if (respuesta.tipo === "correcto") {
               
                $("#respuestaAjax_srm").html(respuesta.mensaje);
                $("#respuestaAjax_srm").show();
                setTimeout(function () {
                  $("#respuestaAjax_srm").hide();
                }, 5000);
              }
              else{
                $("#respuestaAjax_srm").html(respuesta.mensaje);
                $("#respuestaAjax_srm").show();
                setTimeout(function () {
                  $("#respuestaAjax_srm").hide();
                }, 5000);
              }
            }
            });
      
    }

}

  const extorno = new ExtornoClass();
  //caja.tipo_papel();
document.addEventListener('DOMContentLoaded', function () {
    extorno.fecha_extorno();
    extorno.lista_extorno(extorno.fechafiltro);  
})
$(document).on("change", "#fecha_extorno", function () {
    extorno.fechafiltro = $("#fecha_extorno").val();
    extorno.lista_extorno(extorno.fechafiltro)
    console.log("nueva fecha:"+ extorno.fechafiltro);
});

$(document).on("click", ".link", function(e) {
  extorno.numero_caja = $(this).attr('numero_caja');
  $("#nr_extorno").text(extorno.numero_caja);
  $('#modalExtornar_si_no').modal('show');
});

$(document).on("click", ".extornar_si", function(e) {
  e.preventDefault();
  $('#modalExtornar_si_no').modal('hide');
  extorno.extornar(extorno.numero_caja);
  console.log(extorno.numero_caja);
});
