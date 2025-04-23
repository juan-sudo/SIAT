// Definir una clase
class ImprimirFormato {
    constructor() {
      // Constructor de la clase
      // Puedes inicializar propiedades aquí si es necesario
    }
     imprimirHR() {
      let datos = new FormData();
      var id = predio.id_propietario;
      const valorModificado = id.replace(/-/g, ',');
      var anio = impuestoCalculator.selectnum_arbitrio;
      
      datos.append("carpeta", predio.carpeta);
      datos.append("propietarios", valorModificado);
      datos.append("anio", anio);
      datos.append("predio_select", "no");
      console.log("imprimir id contribuyente hr:" + valorModificado);
      console.log("imprimir id contribuyente hr:" + anio);

      $.ajax({
          url: "./vistas/print/imprimirHR.php",
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
              document.getElementById("iframe_hr").src = 'vistas/print/' + rutaArchivo;
              $("#Modalimprimir_HR").modal("show");
          },
          error: function() {
              $("#modal_cargar").text("Error al cargar el archivo.");
          }
      });
  }
    imprimirDJ(){
      let datos = new FormData();
      var id=predio.id_propietario;
      var anio=impuestoCalculator.selectnum_arbitrio;
      var catastro=impuestoCalculator.catastro_dj;
      var tipopredio_=impuestoCalculator.tipopredio_dj;
      var id_predio=impuestoCalculator.id_predio_dj
      const valorModificado = id.replace(/-/g, ',');
      datos.append("carpeta", predio.carpeta);
      datos.append("propietarios",valorModificado);
      datos.append("anio",anio);
      datos.append("catastro",catastro);
      datos.append("tipopredio",tipopredio_);
      datos.append("id_predio",id_predio);
      console.log("imprimir id contrbuuenete hr:"+valorModificado);
      console.log("imprimir id contrbuuenete hr:"+anio);
      console.log("imprimir catastro:"+catastro);
      console.log("imprimir tipo:"+tipopredio_);
      $.ajax({
        url: "./vistas/print/imprimirDJ.php",
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
          document.getElementById("iframe_dj").src = 'vistas/print/' + rutaArchivo;
            $("#Modalimprimir_DJ").modal("show");
        },
        error: function() {
            $("#modal_cargar").text("Error al cargar el archivo.");
        }
      });   
  }
  imprimirLA(){
    let datos = new FormData();
      var id=predio.id_propietario;
      var anio=impuestoCalculator.selectnum_arbitrio;
      var catastro=impuestoCalculator.catastro_la;
      var tipopredio_=impuestoCalculator.tipopredio_la;
      var id_predio=impuestoCalculator.id_predio_la
      const valorModificado = id.replace(/-/g, ',');
      datos.append("carpeta", predio.carpeta);
      datos.append("propietarios",valorModificado);
      datos.append("anio",anio);
      datos.append("catastro",catastro);
      datos.append("tipopredio",tipopredio_);
      datos.append("id_predio",id_predio);
      console.log("imprimir id contrbuuenete hr:"+valorModificado);
      console.log("imprimir id contrbuuenete hr:"+anio);
      console.log("imprimir catastro:"+catastro);
      console.log("imprimir tipo:"+tipopredio_);
      $.ajax({
        url: "./vistas/print/imprimirLA.php",
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
          document.getElementById("iframe_la").src = 'vistas/print/' + rutaArchivo;
            $("#Modalimprimir_LA").modal("show");
        },
        error: function() {
            $("#modal_cargar").text("Error al cargar el archivo.");
        }
      });     
}
    inicializarPestanas() {
      // Agregar el código para inicializar las pestañas aquí
      $('#list-tab a:first').tab('show');
      // Manejar los clics en las pestañas
      $('#list-tab a').on('click', function (e) {
        e.preventDefault();
        // Elimina la clase "active" de todas las pestañas
        $('#list-tab a').removeClass('active');
        // Agrega la clase "active" solo a la pestaña seleccionada
        $(this).addClass('active');
        // Ocultar el contenido de la pestaña activa
        $('.tab-pane.active').removeClass('active show');
        // Mostrar el contenido de la pestaña seleccionada
        $($(this).attr('href')).addClass('active show');
        $(this).tab('show');
        impuestoCalculator.html='';
        var divContainer = document.getElementById("tablapisos");
        divContainer.innerHTML =impuestoCalculator.html;
        var divContainer_ = document.getElementById("tablacuotas");
        divContainer_.innerHTML =impuestoCalculator.html;
      });
    }

  }
  
  // Crear una instancia de la clase
  const miInstanciaImprimir = new ImprimirFormato();
  // Llamar al método para inicializar las pestañas
  miInstanciaImprimir.inicializarPestanas();
  //Generar el pdf despues de confirmar en el popup hr
  $(document).on("click", ".print_formato_hr", function () {
    $('#modalImprimirFormato_hr_si_no').modal('hide');
    miInstanciaImprimir.imprimirHR();
    //$("#Modalimprimir_HR").modal("show");
});
 //Generar el pdf despues de confirmar en el popup dj
$(document).on("click", ".print_formato_dj", function () {
  $('#modalImprimirFormato_dj_si_no').modal('hide');
  miInstanciaImprimir.imprimirDJ();
  //$("#Modalimprimir_DJ").modal("show");
});
 //Generar el pdf despues de confirmar en el popup dj
 $(document).on("click", ".print_formato_la", function () {
  $('#modalImprimirFormato_la_si_no').modal('hide');
  miInstanciaImprimir.imprimirLA();
 // $("#Modalimprimir_LA").modal("show");
});
