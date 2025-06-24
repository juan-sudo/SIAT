class negocioClase {
 constructor() {
  this.idPRedioE=null;
    this.N_Licencia = null;  // Licencia del negocio
    this.N_Trabajadores = null;  // Número de trabajadores
    this.N_Mesas = null;  // Número de mesas
    this.Area_negocio = null;  // Área del negocio
    this.Tenencia_Negocio = null;  // Tenencia del negocio
    this.Personeria = null;  // Persona jurídica o natural del negocio
    this.Tipo_personeria = null;  // Tipo de personería
    this.N_Camas = null;  // Número de camas
    this.N_Cuartos = null;  // Número de cuartos
    this.Razon_Social = null;  // Razón social
    this.N_Ruc = null;  // Número de RUC
    this.N_Baño = null;  // Número de baños
    this.T_aguaN=null;
    this.Id_Giro_Establecimiento = null;  // ID de giro del establecimiento
    this.Id_Predio = null;  // ID de predio relacionado con el negocio
  }
  
}


const nuevoNegocio = new negocioClase();




// ABRIL EL MOODAL VER
$(document).on('click', '#btnAbrirModalverN', function() {

   var idNegocio = $(this).data('id');
    console.log("ID del negocio: ", idNegocio);  // Usar el id_negocio según sea necesario

    
        // Aquí puedes realizar la llamada AJAX o enviar los datos a tu servidor
        let formd = new FormData();

        formd.append("id_negocio", idNegocio);
       
        formd.append("ver_negocio", "ver_negocio");
        

        // Ver los datos antes de enviarlos
        for (let [key, value] of formd.entries()) {
            console.log(`${key}: ${value}`);
        }

          $.ajax({
            type: "POST",
            url: "ajax/negocio.ajax.php",
            data: formd,
            cache: false,
            contentType: false,
            processData: false,
             success: function (respuesta) {

                console.log(" modal ver negocio", respuesta);
             // console.log("respuesta desde ----", respuesta);  // Verifica si la respuesta es la esperada
              
              // Verifica si la respuesta es un objeto JSON
              if (typeof respuesta === "string") {
                  try {
                      respuesta = JSON.parse(respuesta);  // Intenta convertir la respuesta si es un string
                  } catch (e) {
                      console.error("Error al parsear la respuesta:", e);
                      return;
                  }
              }
              // Verificar si la respuesta es exitosa
             // Si la respuesta es exitosa, muestra el mensaje
          
             if (respuesta.status === "ok") {
    var negocio = respuesta.data[0];  // Obtener el primer negocio

    // Función para verificar y ocultar el div si el valor es 0
   function mostrarValor(valor, elementoId) {
        if (valor === 0 || valor === "" || valor === null) {
            // Si el valor es 0 o vacío, ocultamos el div.row que contiene el valor
            $('#' + elementoId).closest('.row').hide();
        } else {
            // Si el valor es válido, asignamos el valor al span
            $('#' + elementoId).text(valor);
            // Aseguramos que el div.row esté visible
            $('#' + elementoId).closest('.row').show();
        }
    }

    // Asignar los valores al modal y mostrar/ocultar según corresponda
    mostrarValor(negocio.Razon_Social, 'razonSocialModal');
    mostrarValor(negocio.N_Ruc, 'rucModal');
    mostrarValor(negocio.Area_negocio, 'areaNegocioModal');
    mostrarValor(negocio.N_Mesas, 'nMesasModal');
    mostrarValor(negocio.N_Trabajadores, 'nTrabajadoresModal');
    mostrarValor(negocio.Tenencia_Negocio, 'tenenciaNegocioModal');
    mostrarValor(negocio.Personeria, 'personeriaModal');
    mostrarValor(negocio.Tipo_personeria, 'tipoPersoneriaModal');
    mostrarValor(negocio.N_Camas, 'nCamasModal');
    mostrarValor(negocio.N_Cuartos, 'nCuartosModal');
    mostrarValor(negocio.Nombre, 'nombreNegocioModal');
    mostrarValor(negocio.T_Agua_Negocio, 'aguaNegocioModal');
    mostrarValor(negocio.T_Itse, 'itseModal');
    mostrarValor(negocio.Vencimiento_Itse, 'vencimientoItseModal');
    mostrarValor(negocio.Estado, 'estadoModal');

    // Mostrar el modal
    $('#modalVer_negocio').modal('show');
}

            
            
            else {
                alert(respuesta.message);  // Si hay un error, muestra el mensaje de error
            }
              },
            error: function (xhr, status, error) {
                console.log("Error en la solicitud AJAX: " + error);
                console.log("Estado de la respuesta HTTP: " + xhr.status);  // Código de estado HTTP
                console.log("Texto de respuesta: " + xhr.responseText);  // Respuesta completa del servidor
            }

        });




});

///ABRIRL MODAL EDITAR



$(document).on('click', '#btnAbrirModalEditar', function() {

   var idNegocio = $(this).data('id');
    console.log("ID del negocio: ", idNegocio);  // Usar el id_negocio según sea necesario


      
    //    $('#idPredioModal').val(valorInput);

                // Aquí puedes realizar la llamada AJAX o enviar los datos a tu servidor
        let formd = new FormData();

        formd.append("id_negocio", idNegocio);
       
        formd.append("editar_negocio", "editar_negocio");
        

        // Ver los datos antes de enviarlos
        for (let [key, value] of formd.entries()) {
            console.log(`${key}: ${value}`);
        }

          $.ajax({
            type: "POST",
            url: "ajax/negocio.ajax.php",
            data: formd,
            cache: false,
            contentType: false,
            processData: false,
             success: function (respuesta) {

                console.log(" modal editar negocio", respuesta);
             // console.log("respuesta desde ----", respuesta);  // Verifica si la respuesta es la esperada
              
              // Verifica si la respuesta es un objeto JSON
              if (typeof respuesta === "string") {
                  try {
                      respuesta = JSON.parse(respuesta);  // Intenta convertir la respuesta si es un string
                  } catch (e) {
                      console.error("Error al parsear la respuesta:", e);
                      return;
                  }
              }
              // Verificar si la respuesta es exitosa
             // Si la respuesta es exitosa, muestra el mensaje
          
             if (respuesta.status === "ok") {

              var negocio = respuesta.data[0];  // Obtener el primer negocio de la respuesta

         // Asignar los valores a los campos del modal
          $('#idPredioModal_e').val(negocio.Id_Predio);
            $('#idNegocioModal_e').val(negocio.Id_Negocio);
            $('#razon_social_d').val(negocio.Razon_Social);
            $('#nro_ruc_d').val(negocio.N_Ruc);
            $('#nro_licencia_d').val(negocio.N_Licencia);
            $('#giroNegocio_e_d').val(negocio.Id_Giro_Establecimiento);  // El valor de la opción para Giro de Establecimiento
            $('#tenencia_ne_d').val(negocio.Tenencia_Negocio);
            $('#personeria_ne_d').val(negocio.Personeria);
            $('#tipo_sociedad_d').val(negocio.Tipo_personeria);
            $('#n_trabajadores_d').val(negocio.N_Trabajadores);
            $('#nMesas_e_d').val(negocio.N_Mesas);
            $('#areaNegocio_e_d').val(negocio.Area_negocio);
            $('#ncuartos_d').val(negocio.N_Cuartos);
            $('#ncamas_d').val(negocio.N_Camas);
            $('#nBano_d').val(negocio.N_Bano);

            // Seleccionar el valor de los radios (agua)
            $('#agua_si_n').prop('checked', negocio.T_Agua_Negocio === 'si');  // Verificar si tiene agua
            $('#agua_no_n').prop('checked', negocio.T_Agua_Negocio === 'no');  // Verificar si no tiene agua


             // Seleccionar el valor de los radios (ITSE)
            $('#tiene_itse_si').prop('checked', negocio.T_Itse === 'si');  // Verificar si tiene agua
            $('#tiene_itse_no').prop('checked', negocio.T_Itse === 'no');  // Verificar si no tiene agua


               // Seleccionar el valor de los radios (ITSE)
            $('#tiene_licencia_si').prop('checked', negocio.T_Licencia === 'si');  // Verificar si tiene agua
            $('#tiene_licencia_no').prop('checked', negocio.T_Licencia === 'no');  // Verificar si no tiene agua



           

            $('#fecha_vencimiento_n_d').val(negocio.Vencimiento_Itse);  // Asignar la fecha de vencimiento

   


            // Mostrar el modal
            $('#modalRegistrar_negocio_editar').modal('show');
        }

            
            
            else {
                alert(respuesta.message);  // Si hay un error, muestra el mensaje de error
            }
              },
            error: function (xhr, status, error) {
                console.log("Error en la solicitud AJAX: " + error);
                console.log("Estado de la respuesta HTTP: " + xhr.status);  // Código de estado HTTP
                console.log("Texto de respuesta: " + xhr.responseText);  // Respuesta completa del servidor
            }

        });

           
       


   
});




 $(document).ready(function () {
    

  function toggleCamposRegimen(valor) {


    if (valor ===  "si") {
       $('#licencia_itse_row').show();

    } else {
      $('#licencia_itse_row').hide();
      $('#fecha_vencimiento').val(''); // <- corrección aquí


    }
  }


    $("input[name='licenciaitse']").on('change', function () {
       const valor =$(this).val();
    toggleCamposRegimen(valor);
  });
  

$('#modalRegistrar_negocio').on('shown.bs.modal', function () {
   // const valor = $('#personeria_e').val();
    const valor = $("input[name='licenciaitse']:checked").val();
    toggleCamposRegimen(valor);
  });


});



 $(document).ready(function () {
    

  function toggleCamposRegimen(valor) {


    if (valor ===  "si") {
       $('#licencia_itse_row_d').show();

    } else {
      $('#licencia_itse_row_d').hide();
      $('#fecha_vencimiento_n_d').val(''); // <- corrección aquí


    }
  }


    $("input[name='licenciaitse_n_d']").on('change', function () {
       const valor =$(this).val();
    toggleCamposRegimen(valor);
  });
  

$('#modalRegistrar_negocio_editar').on('shown.bs.modal', function () {
   // const valor = $('#personeria_e').val();
    const valor = $("input[name='licenciaitse_n_d']:checked").val();
    toggleCamposRegimen(valor);
  });


});




//TIENE LICENCIA EDITAR

 $(document).ready(function () {
  function toggleCamposRegimen(valor) {


    if (valor ===  "si") {
       $('#licencia_licencia_row_d').show();

    } else {
      $('#licencia_licencia_row_d').hide();
      $('#nro_licencia_d').val(''); // <- corrección aquí

  
    }
  }


    $("input[name='licenciN_n_d']").on('change', function () {
       const valor =$(this).val();
    toggleCamposRegimen(valor);
  });
  

$('#modalRegistrar_negocio_editar').on('shown.bs.modal', function () {
   // const valor = $('#personeria_e').val();
    const valor = $("input[name='licenciN_n_d']:checked").val();
    toggleCamposRegimen(valor);
  });


});


//TIENE LICENCIA NORMAL

 $(document).ready(function () {
  function toggleCamposRegimen(valor) {


    if (valor ===  "si") {
       $('#licencia_licencia_row').show();

    } else {
      $('#licencia_licencia_row').hide();
      $('#nro_licencia').val(''); // <- corrección aquí

  
    }
  }


    $("input[name='licenciN_n']").on('change', function () {
       const valor =$(this).val();
    toggleCamposRegimen(valor);
  });
  

$('#modalRegistrar_negocio').on('shown.bs.modal', function () {
   // const valor = $('#personeria_e').val();
    const valor = $("input[name='licenciN_n']:checked").val();
    toggleCamposRegimen(valor);
  });


});



// ABRIL EL MODAL DE AGREGAR NEGOCIO
$(document).ready(function() {

    // Abre el modal cuando se hace clic en el botón "Agregar negocio"
    $('#btnAbrirModal').click(function() {
       var valorInput = $('#idPredio').val();
        $('#idPredioModal').val(valorInput);
           
            $('#giroNegocio_e').val('');  // Vaciar input
            $('#razon_social').val('');  // Vaciar input
            $('#nro_ruc').val('');  // Vaciar input
            $('#nro_licencia').val('');  // Vaciar input
            $('#tenencia_ne').val('');  // Vaciar input
            $('#personeria_ne').val('');  // Vaciar input
            $('#tipo_sociedad').val('');  // Vaciar input
            $('#n_trabajadores').val('');  // Restablecer a 0
            $('#nMesas_e').val('');  // Restablecer a 0
            $('#areaNegocio_e').val('');  // Restablecer a 0
            $('#ncuartos').val('');  // Restablecer a 0
            $('#ncamas').val('');  // Restablecer a 0
            $('#nBano').val('');  // Restablecer a 0
            $("input[name='tieneAguan']").prop('checked', false);  // Desmarcar radio buttons
            $("input[name='licenciaitse']").prop('checked', false);  // Desmarcar radio buttons
            $('#fecha_vencimiento').val('');  // Vaciar
            

        $('#modalRegistrar_negocio').modal('show');
    });
});



//BUSCADOR DE SELECTORES
// Asegúrate de que el DOM esté cargado
 $(document).ready(function() {
    // Inicializamos Select2 en el select con id 'giroNegocio_e'
    $('#giroNegocio_e').select2({
      placeholder: 'Selecciona un giro de negocio', // Placeholder opcional
      allowClear: true // Permite borrar la selección
    });
  });


  //BUSCADOR DE SELECTORES
// Asegúrate de que el DOM esté cargado
 $(document).ready(function() {
    // Inicializamos Select2 en el select con id 'giroNegocio_e'
    $('#giroNegocio_e_d').select2({
      placeholder: 'Selecciona un giro de negocio', // Placeholder opcional
      allowClear: true // Permite borrar la selección
    });
  });






//EDITAR NEGOCIO
$(document).ready(function() {  
    // Capturar el clic en el botón Guardar
    $('#btnGuardarEditarNegocio_e').click(function(e) {
        e.preventDefault(); // Prevenir el comportamiento por defecto (por ejemplo, si el formulario tiene un submit)

        console.log("Botón Guardar clickeado"); // Para verificar que el evento se capturó correctamente
        
        // Captura de valores del formulario
       // Captura de valores del formulario   
    const nuevoNegocio = {
        idPredio: $("#idPredioModal_e").val(),
        idNegocio: $("#idNegocioModal_e").val(),
        Id_Giro_Establecimiento: $("#giroNegocio_e_d").val(),
        razon_social: $("#razon_social_d").val(),
        N_Ruc: $("#nro_ruc_d").val(),
        Nro_Licencia: $("#nro_licencia_d").val(),
        Tenencia_Negocio: $("#tenencia_ne_d").val(),
        Personeria: $("#personeria_ne_d").val(),
        T_personeria: $("#tipo_sociedad_d").val(),
        N_Trabajadores: $("#n_trabajadores_d").val(),
        N_Mesas: $("#nMesas_e_d").val(),
        Area_negocio: $("#areaNegocio_e_d").val(),
        N_Cuartos: $("#ncuartos_d").val(),
        N_Camas: $("#ncamas_d").val(),
        N_Bano: $("#nBano_d").val(),
        T_aguaN: $("input[name='tieneAguan_n']:checked").val(), // Capturamos el valor de los radio buttons
        T_Itse: $("input[name='licenciaitse_n_d']:checked").val(), // Capturamos el valor de los radio buttons
        T_Licencia: $("input[name='licenciN_n_d']:checked").val(), // Capturamos el valor de los radio buttons
       
       
       
        Vencimiento_Itse: $("#fecha_vencimiento_n_d").val(),




    };


       
        console.log("valores capturados de editar --",nuevoNegocio);

        // Aquí puedes realizar la llamada AJAX o enviar los datos a tu servidor
        let formd = new FormData();

        formd.append("id_negocio", nuevoNegocio.idNegocio);
        formd.append("id_giro_establecimiento", nuevoNegocio.Id_Giro_Establecimiento);
        formd.append("razon_social", nuevoNegocio.razon_social);
        formd.append("nro_licencia", nuevoNegocio.Nro_Licencia);
        formd.append("nro_ruc", nuevoNegocio.N_Ruc);
        
        
        formd.append("tenencia_negocio", nuevoNegocio.Tenencia_Negocio);
        formd.append("personeria", nuevoNegocio.Personeria);
        formd.append("t_personeria", nuevoNegocio.T_personeria);
        formd.append("nro_trabajadores", nuevoNegocio.N_Trabajadores);

        formd.append("nro_mesas", nuevoNegocio.N_Mesas);
        formd.append("area_negocio", nuevoNegocio.Area_negocio);
        formd.append("nro_cuartos", nuevoNegocio.N_Cuartos);
        formd.append("nro_camas", nuevoNegocio.N_Camas);

        formd.append("nro_bano", nuevoNegocio.N_Bano);
        formd.append("t_agua", nuevoNegocio.T_aguaN);
        formd.append("t_Itse", nuevoNegocio.T_Itse);
        formd.append("t_Licencia", nuevoNegocio.T_Licencia);

        formd.append("vencimiento_Itse", nuevoNegocio.Vencimiento_Itse);

      
        formd.append("editar_negocio_guardar", "editar_negocio_guardar");
        

        // Ver los datos antes de enviarlos
        for (let [key, value] of formd.entries()) {
            console.log(`${key}: ${value}`);
        }

          $.ajax({
            type: "POST",
            url: "ajax/negocio.ajax.php",
            data: formd,
            cache: false,
            contentType: false,
            processData: false,
             success: function (respuesta) {

                console.log("se registro negocio de manera exitosa", respuesta);
             // console.log("respuesta desde ----", respuesta);  // Verifica si la respuesta es la esperada
              
              // Verifica si la respuesta es un objeto JSON
              if (typeof respuesta === "string") {
                  try {
                      respuesta = JSON.parse(respuesta);  // Intenta convertir la respuesta si es un string
                  } catch (e) {
                      console.error("Error al parsear la respuesta:", e);
                      return;
                  }
              }
              // Verificar si la respuesta es exitosa
             // Si la respuesta es exitosa, muestra el mensaje
            if (respuesta.status === "ok") {
                //  alert(respuesta.message);  // Muestra el mensaje de éxito
                $('#modalRegistrar_negocio_editar').modal('hide');  // Cierra el modal

               

                 listarNegocioN(nuevoNegocio.idPredio);  // Aquí puedes pasar el idPredio adecuado para que actualice la tabla

                   $("#respuestaAjax_srm").html(respuesta.message);
                     $("#respuestaAjax_srm").show(); // Muestra el mensaje

                  // Obtener los parámetros actuales de la URL
                  setTimeout(function () {
              $("#respuestaAjax_srm").hide(); //
                   }, 5000); // 3 segundos

                // Restablecer los campos a cero o vacíos
         
            $('#giroNegocio_e').val('');  // Vaciar input
            $('#razon_social').val('');  // Vaciar input
            $('#nro_ruc').val('');  // Vaciar input
            $('#nro_licencia').val('');  // Vaciar input
            $('#tenencia_ne').val('');  // Vaciar input
            $('#personeria_ne').val('');  // Vaciar input
            $('#tipo_sociedad').val('');  // Vaciar input
            $('#n_trabajadores').val('');  // Restablecer a 0
            $('#nMesas_e').val('');  // Restablecer a 0
            $('#areaNegocio_e').val('');  // Restablecer a 0
            $('#ncuartos').val('');  // Restablecer a 0
            $('#ncamas').val('');  // Restablecer a 0
            $('#nBano').val('');  // Restablecer a 0
            $("input[name='tieneAguan']").prop('checked', false);  // Desmarcar radio buttons
            $("input[name='licenciaitse']").prop('checked', false);  // Desmarcar radio buttons
            $('#fecha_vencimiento').val('');  // Vaciar
            
               
            } else {
                 $("#respuestaAjax_srm").html(respuesta.message);
                     $("#respuestaAjax_srm").show(); // Muestra el mensaje

                  // Obtener los parámetros actuales de la URL
                            setTimeout(function () {
                        $("#respuestaAjax_srm").hide(); //
                            }, 5000); // 3 segundos
            }
              },
            error: function (xhr, status, error) {
                console.log("Error en la solicitud AJAX: " + error);
                console.log("Estado de la respuesta HTTP: " + xhr.status);  // Código de estado HTTP
                console.log("Texto de respuesta: " + xhr.responseText);  // Respuesta completa del servidor
            }

        });

        
    });
});




//REGISTRAR NEGOCIO
$(document).ready(function() {  
    // Capturar el clic en el botón Guardar
    $('#btnGuardarNegocio_e_a').click(function(e) {
        e.preventDefault(); // Prevenir el comportamiento por defecto (por ejemplo, si el formulario tiene un submit)

        console.log("Botón Guardar clickeado"); // Para verificar que el evento se capturó correctamente
        
        // Captura de valores del formulario
        const nuevoNegocio = {

            idPRedioE: $("#idPredioModal").val(),
            Id_Giro_Establecimiento: $("#giroNegocio_e").val(),
            razon_social: $("#razon_social").val(),
            N_Ruc: $("#nro_ruc").val(),
            Nro_Licencia: $("#nro_licencia").val(),

           
            Tenencia_Negocio: $("#tenencia_ne").val(),
            Personeria: $("#personeria_ne").val(),
            T_personeria: $("#tipo_sociedad").val(),
            N_Trabajadores: $("#n_trabajadores").val(),
            
            N_Mesas: $("#nMesas_e").val(),
            Area_negocio: $("#areaNegocio_e").val(),
            N_Cuartos: $("#ncuartos").val(),
            N_Camas: $("#ncamas").val(),

            N_Bano: $("#nBano").val(),
            T_aguaN: $("input[name='tieneAguan']:checked").val(), // Capturamos el valor de los radio buttons
             T_Itse: $("input[name='licenciaitse']:checked").val(), // Capturamos el valor de los radio buttons
             T_Licencia: $("input[name='licenciN_n']:checked").val(), // Capturamos el valor de los radio buttons
            
            
             Vencimiento_Itse: $("#fecha_vencimiento").val(),
            

          };

        // Validar que los campos no estén vacíos
        // if (Object.values(nuevoNegocio).includes('') || Object.values(nuevoNegocio).includes(null)) {
        //     alert("Por favor, complete todos los campos requeridos.");
        //     return;
        // }

        // Mostrar los datos capturados en la consola (para debug)
        console.log(nuevoNegocio);

        // Aquí puedes realizar la llamada AJAX o enviar los datos a tu servidor
        let formd = new FormData();

        formd.append("id_predio", nuevoNegocio.idPRedioE);
        formd.append("id_giro_establecimiento", nuevoNegocio.Id_Giro_Establecimiento);
        formd.append("razon_social", nuevoNegocio.razon_social);
        formd.append("nro_licencia", nuevoNegocio.Nro_Licencia);
        formd.append("nro_ruc", nuevoNegocio.N_Ruc);
        
        
        formd.append("tenencia_negocio", nuevoNegocio.Tenencia_Negocio);
        formd.append("personeria", nuevoNegocio.Personeria);
        formd.append("t_personeria", nuevoNegocio.T_personeria);
        formd.append("nro_trabajadores", nuevoNegocio.N_Trabajadores);

        formd.append("nro_mesas", nuevoNegocio.N_Mesas);
        formd.append("area_negocio", nuevoNegocio.Area_negocio);
        formd.append("nro_cuartos", nuevoNegocio.N_Cuartos);
        formd.append("nro_camas", nuevoNegocio.N_Camas);

        formd.append("nro_bano", nuevoNegocio.N_Bano);
        formd.append("t_agua", nuevoNegocio.T_aguaN);
        formd.append("t_Itse", nuevoNegocio.T_Itse);
         formd.append("t_Licencia", nuevoNegocio.T_Licencia);
        formd.append("vencimiento_Itse", nuevoNegocio.Vencimiento_Itse);

      
        formd.append("registrar_negocio", "registrar_negocio");
        

        // Ver los datos antes de enviarlos
        for (let [key, value] of formd.entries()) {
            console.log(`${key}: ${value}`);
        }

          $.ajax({
            type: "POST",
            url: "ajax/negocio.ajax.php",
            data: formd,
            cache: false,
            contentType: false,
            processData: false,
             success: function (respuesta) {

                console.log("se registro negocio de manera exitosa", respuesta);
             // console.log("respuesta desde ----", respuesta);  // Verifica si la respuesta es la esperada
              
              // Verifica si la respuesta es un objeto JSON
              if (typeof respuesta === "string") {
                  try {
                      respuesta = JSON.parse(respuesta);  // Intenta convertir la respuesta si es un string
                  } catch (e) {
                      console.error("Error al parsear la respuesta:", e);
                      return;
                  }
              }
              // Verificar si la respuesta es exitosa
             // Si la respuesta es exitosa, muestra el mensaje
            if (respuesta.status === "ok") {
                //  alert(respuesta.message);  // Muestra el mensaje de éxito
                $('#modalRegistrar_negocio').modal('hide');  // Cierra el modal

               

                 listarNegocioN(nuevoNegocio.idPRedioE);  // Aquí puedes pasar el idPredio adecuado para que actualice la tabla

                     $("#respuestaAjax_srm").html(respuesta.message);
                     $("#respuestaAjax_srm").show(); // Muestra el mensaje

                  // Obtener los parámetros actuales de la URL
                            setTimeout(function () {
                        $("#respuestaAjax_srm").hide(); //
                            }, 5000); // 3 segundos


                // Restablecer los campos a cero o vacíos
         
            $('#giroNegocio_e').val('');  // Vaciar input
            $('#razon_social').val('');  // Vaciar input
            $('#nro_ruc').val('');  // Vaciar input
            $('#nro_licencia').val('');  // Vaciar input
            $('#tenencia_ne').val('');  // Vaciar input
            $('#personeria_ne').val('');  // Vaciar input
            $('#tipo_sociedad').val('');  // Vaciar input
            $('#n_trabajadores').val('');  // Restablecer a 0
            $('#nMesas_e').val('');  // Restablecer a 0
            $('#areaNegocio_e').val('');  // Restablecer a 0
            $('#ncuartos').val('');  // Restablecer a 0
            $('#ncamas').val('');  // Restablecer a 0
            $('#nBano').val('');  // Restablecer a 0
            $("input[name='tieneAguan']").prop('checked', false);  // Desmarcar radio buttons
            $("input[name='licenciaitse']").prop('checked', false);  // Desmarcar radio buttons
            $('#fecha_vencimiento').val('');  // Vaciar
            
               
            } else {
                   $("#respuestaAjax_srm").html(respuesta.message);
                     $("#respuestaAjax_srm").show(); // Muestra el mensaje

                  // Obtener los parámetros actuales de la URL
                            setTimeout(function () {
                        $("#respuestaAjax_srm").hide(); //
                            }, 5000); // 3 segundos

            }
              },
            error: function (xhr, status, error) {
                console.log("Error en la solicitud AJAX: " + error);
                console.log("Estado de la respuesta HTTP: " + xhr.status);  // Código de estado HTTP
                console.log("Texto de respuesta: " + xhr.responseText);  // Respuesta completa del servidor
            }

        });

        
    });
});


$(document).ready(function () {

  // Función para mostrar u ocultar los campos de tipo sociedad
  function toggleCamposRegimen(valor) {
    if (valor === "PERSONA_JURIDICA") {
      $('#otroInputRowJuridica').show();  // Mostrar el campo de tipo sociedad
    } else {
      $('#otroInputRowJuridica').hide();  // Ocultar el campo de tipo sociedad
      $('#tipo_sociedad').val('');  // Limpiar la selección de tipo sociedad si es Persona Natural
    }
  }

  // Evento para cuando cambie el valor de 'personeria_ne'
  $('#personeria_ne').on('change', function () {
    const valor = $(this).val();  // Obtener el valor seleccionado
    console.log("Personería seleccionada:", valor);  // Para verificar el valor seleccionado
    toggleCamposRegimen(valor);  // Llamar a la función para mostrar/ocultar el campo de tipo sociedad
  });

  // Inicializar el modal y aplicar la función de acuerdo al valor actual de 'personeria_ne'
  $('#modalRegistrar_negocio').on('shown.bs.modal', function () {
    const valor = $('#personeria_ne').val();  // Obtener el valor actual de 'personeria_ne' cuando se muestra el modal
    toggleCamposRegimen(valor);  // Llamar a la función para mostrar/ocultar el campo de tipo sociedad
  });

});




  function listarNegocioN(idPredio) {
    // OPTENIENDO LA DIRECCION DEL CONTRIBUYENTE


    console.log("id para negocios ,", idPredio);

      let formd = new FormData();

       formd.append("id_predio", idPredio);
        formd.append("listar_negocio", "listar_negocio");
    $.ajax({
      type: "POST",
      url: "ajax/negocio.ajax.php",
      data: formd,
      cache: false,
     contentType: false,
      processData: false,
      success: function (respuesta) {
        console.log("lista negocios---", respuesta);

        // Asegurarse de que la respuesta sea un objeto JSON y contenga 'data'
        if (respuesta.status === "ok" && respuesta.data) {
            // Crear el contenido de la tabla HTML dinámicamente
            let tablaHTML = "";

            // Iterar sobre los datos de negocio
            respuesta.data.forEach(function(negocio) {
                tablaHTML += `
                    <tr>
                     <td style="text-align: center;">${negocio.Razon_Social}</td>
                       
                        <td style="text-align: center;">${negocio.N_Licencia}</td>
                        <td style="text-align: center;">${negocio.N_Ruc}</td>
                       
                        <td style="text-align: center;">${negocio.Area_negocio}</td>
                        <td style="text-align: center;">${negocio.T_Agua_Negocio}</td>
                         <td style="text-align: center;">${negocio.T_Itse}</td>
                      <td style="text-align: center;">
    <!-- Iconos con fondo gris -->
   
       <button type="button" class="btn btn-link" title="Ver" id="btnAbrirModalverN" data-id="${negocio.Id_Negocio }" style="margin: 0; padding: 0; border: none;">
        <i class="bi bi-eye-fill" style="font-size: 16px; color: #1d1c26;"></i>
    </button>
    <button type="button" class="btn btn-link" title="Ver" id="btnAbrirModalEditar" data-id="${negocio.Id_Negocio }" style="margin: 0; padding: 0; border: none;">
       <i class="bi bi-pencil-fill" style="font-size: 14px; color: #082b07;" ></i> <!-- Icono de editar -->
   
    </button>
 
    <button type="button" class="btn btn-link" title="Eliminar" id="btnEliminarNegocio" data-id="${negocio.Id_Negocio }" data-predio="${negocio.Id_Predio}"   style="margin: 0; padding: 0; border: none;">
       <i class="bi bi-trash" style="font-size: 14px; color: #570d0a;"></i> <!-- Icono de eliminar -->
    </button>
</td>



                    </tr>`;
            });

            // Insertar la tabla generada en el contenedor correspondiente
            $("#listaNegocio").html(tablaHTML);
        } 
        
        // else {
        //     alert("Error: No se encontraron negocios.");
        // }
    },
error: function (xhr, status, error) {
    console.log("Error en la solicitud AJAX: " + error);
    console.log("Estado de la respuesta HTTP: " + xhr.status);  // Código de estado HTTP
    console.log("Texto de respuesta: " + xhr.responseText);  // Respuesta completa del servidor
}

    });
  }



//SALIR MODAL
$(document).ready(function() {
    // Cerrar el modal cuando se hace clic en el botón "Salir"
    $('#cancelarModalVer').click(function() {
        $('#modalVer_negocio').modal('hide'); // Cierra el modal
    });
});







$(document).on('click', '#btnEliminarNegocio', function() {
//=============== ELIMINAR NEGOCIO ======================

  console.log("has hecho click aqui--");

    // Asignar los valores del botón al objeto 'negocio'
    var idNegocio = $(this).data('id');
     var idPredio = $(this).data('predio');

    
    // Verificar que los valores se han recibido correctamente
    console.log("ID del negocio: ", idNegocio);  // Usar el id_negocio según sea necesario

    console.log("ID del predio: ", idPredio);  // Usar el id_predio correctamente
      

     $('#inputNegocio').val(idNegocio);
  $('#inputPredio').val(idPredio);
  
    // Mostrar el modal de confirmación
    $('#modal_eliminar_negocio').modal('show');
 
});




// CONFIRMAR ELIMIANR NEGOCIO
$("#confirmarEliminarNegocio").on("click", function () {

   let idNegocio = $('#inputNegocio').val();
  let idPredio = $('#inputPredio').val();

  console.log("ID NEGOCIO A ELIMINAR:", idNegocio);
  console.log("ID PREDIO A ELIMINAR:", idPredio);

  let formd = new FormData();
formd.append("id_negocio", idNegocio);
formd.append("id_predio", idPredio);  // Agregar id_predio si lo necesitas
formd.append("eliminar_negocio", "eliminar_negocio");




  $.ajax({
     type: "POST",
      url: "ajax/negocio.ajax.php",
      data: formd,
      cache: false,
     contentType: false,
      processData: false,
    success: function (respuesta) {


      
                console.log("se eliminado manera exitosa", respuesta);
             // console.log("respuesta desde ----", respuesta);  // Verifica si la respuesta es la esperada
              
              // Verifica si la respuesta es un objeto JSON
              if (typeof respuesta === "string") {
                  try {
                      respuesta = JSON.parse(respuesta);  // Intenta convertir la respuesta si es un string
                  } catch (e) {
                      console.error("Error al parsear la respuesta:", e);
                      return;
                  }
              }
              // Verificar si la respuesta es exitosa
             // Si la respuesta es exitosa, muestra el mensaje
            if (respuesta.status === "ok") {
                //  alert(respuesta.message);  // Muestra el mensaje de éxito
                $('#modal_eliminar_negocio').modal('hide');  // Cierra el modal

               

                 listarNegocioN(idPredio);  // Aquí puedes pasar el idPredio adecuado para que actualice la tabla

                     $("#respuestaAjax_srm").html(respuesta.message);
                     $("#respuestaAjax_srm").show(); // Muestra el mensaje

                  // Obtener los parámetros actuales de la URL
                            setTimeout(function () {
                        $("#respuestaAjax_srm").hide(); //
                            }, 5000); // 3 segundos


               
            } else {
                   $("#respuestaAjax_srm").html(respuesta.message);
                     $("#respuestaAjax_srm").show(); // Muestra el mensaje

                  // Obtener los parámetros actuales de la URL
                            setTimeout(function () {
                        $("#respuestaAjax_srm").hide(); //
                            }, 5000); // 3 segundos

            }



    },
    error: function () {
      console.error("Error en la solicitud AJAX");
    },
  });



});
