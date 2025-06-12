
class ReporteGeneralClass {
    constructor() {

     this.fechafiltro=null;
     this.numero_caja=null;

     this.fechaFiltroInicio=null;
     this.fechaFiltroFin=null;

     this.fechaFiltroInicioA=null;
     this.fechaFiltroFinA=null;
    }





}

  const reporteGeneral = new ReporteGeneralClass();


  
  // TOTAL DE CARPETAS

  $(document).ready(function() {
    let datos = new FormData();
    datos.append("reporte_carpeta_total", "reporte_carpeta_total");

    // Realizar la solicitud AJAX
    $.ajax({
        url: "ajax/reporteGeneral.ajax.php", // Asegúrate de que este sea el archivo correcto
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            console.log("carpeta",respuesta); // Verifica si los datos están correctos
           
           
            // Asegúrate de que la respuesta es el array que contiene el total de carpetas
            var totalCarpetas = respuesta[0][0]; // Accedemos al valor dentro del array

            // Mostrar el valor en el HTML
            $('#totalCarpetas').text(totalCarpetas); // Actualiza el contenido del panel con el valor

        }
    });

});

// TOTAL DE CONTRIBUYENTES
  $(document).ready(function() {
    let datos = new FormData();
    datos.append("reporte_contribuyente_total", "reporte_contribuyente_total");

    // Realizar la solicitud AJAX
    $.ajax({
        url: "ajax/reporteGeneral.ajax.php", // Asegúrate de que este sea el archivo correcto
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
           
            // Asegúrate de que la respuesta es el array que contiene el total de carpetas
            var totalContribuyente = respuesta[0][0]; // Accedemos al valor dentro del array

            // Mostrar el valor en el HTML
            $('#totalContribuyentes').text(totalContribuyente); // Actualiza el contenido del panel con el valor

        }
    });

});



// TOTAL DE PREDIOS
  $(document).ready(function() {
    let datos = new FormData();
    datos.append("reporte_predios_total", "reporte_predios_total");

    // Realizar la solicitud AJAX
    $.ajax({
        url: "ajax/reporteGeneral.ajax.php", // Asegúrate de que este sea el archivo correcto
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
           
            // Asegúrate de que la respuesta es el array que contiene el total de carpetas
            var totalPredios = respuesta[0][0]; // Accedemos al valor dentro del array

            // Mostrar el valor en el HTML
            $('#totalPredios').text(totalPredios); // Actualiza el contenido del panel con el valor

        }
    });

});


// TOTAL DE PREDIOS URBANOS
  $(document).ready(function() {
    let datos = new FormData();
    datos.append("reporte_predios_total_u", "reporte_predios_total_u");

    // Realizar la solicitud AJAX
    $.ajax({
        url: "ajax/reporteGeneral.ajax.php", // Asegúrate de que este sea el archivo correcto
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
           
            // Asegúrate de que la respuesta es el array que contiene el total de carpetas
            var totalPrediosu = respuesta[0][0]; // Accedemos al valor dentro del array

            // Mostrar el valor en el HTML
            $('#totalPrediosu').text(totalPrediosu); // Actualiza el contenido del panel con el valor

        }
    });

});


// TOTAL DE PREDIOS RUTICOS
  $(document).ready(function() {
    let datos = new FormData();
    datos.append("reporte_predios_total_r", "reporte_predios_total_r");

    // Realizar la solicitud AJAX
    $.ajax({
        url: "ajax/reporteGeneral.ajax.php", // Asegúrate de que este sea el archivo correcto
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
           
            // Asegúrate de que la respuesta es el array que contiene el total de carpetas
            var totalPrediosr = respuesta[0][0]; // Accedemos al valor dentro del array

            // Mostrar el valor en el HTML
            $('#totalPrediosr').text(totalPrediosr); // Actualiza el contenido del panel con el valor

        }
    });

});


// TOTAL DE LICENCIAS
  $(document).ready(function() {
    let datos = new FormData();
    datos.append("reporte_licencias_total", "reporte_licencias_total");

    // Realizar la solicitud AJAX
    $.ajax({
        url: "ajax/reporteGeneral.ajax.php", // Asegúrate de que este sea el archivo correcto
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
           
            // Asegúrate de que la respuesta es el array que contiene el total de carpetas
            var totalLicencias = respuesta[0][0]; // Accedemos al valor dentro del array

            // Mostrar el valor en el HTML
            $('#totalLicencias').text(totalLicencias); // Actualiza el contenido del panel con el valor

        }
    });

});

//ULTIMA LICENCIA
  $(document).ready(function() {
    let datos = new FormData();
    datos.append("reporte_total_ultima_licencia", "reporte_total_ultima_licencia");

    // Realizar la solicitud AJAX
    $.ajax({
        url: "ajax/reporteGeneral.ajax.php", // Asegúrate de que este sea el archivo correcto
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
           
            // Asegúrate de que la respuesta es el array que contiene el total de carpetas
            var ultimaLicencias = respuesta[0][0]; // Accedemos al valor dentro del array

            // Mostrar el valor en el HTML
            $('#ultimaLicencia').text(ultimaLicencias); // Actualiza el contenido del panel con el valor

        }
    });

});



//ULTIMA CARPETA
 $(document).ready(function() {
    let datos = new FormData();
    datos.append("reporte_ultima_carpeta", "reporte_ultima_carpeta");

    // Realizar la solicitud AJAX
    $.ajax({
        url: "ajax/reporteGeneral.ajax.php", // Asegúrate de que este sea el archivo correcto
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            console.log("ultima carpeta",respuesta);

           
            // Asegúrate de que la respuesta es el array que contiene el total de carpetas
            var ultimaCarpeta = respuesta[0][0]; // Accedemos al valor dentro del array

            // Mostrar el valor en el HTML
            $('#ultimaCarpeta').text(ultimaCarpeta); // Actualiza el contenido del panel con el valor

        }
    });

});


//ULTIMA CONTRIBUYENTE
 $(document).ready(function() {
    let datos = new FormData();
    datos.append("reporte_ultima_contribuyente", "reporte_ultima_contribuyente");

    // Realizar la solicitud AJAX
    $.ajax({
        url: "ajax/reporteGeneral.ajax.php", // Asegúrate de que este sea el archivo correcto
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            console.log("ultima carpeta",respuesta);

           
            // Asegúrate de que la respuesta es el array que contiene el total de carpetas
            var ultimaContribuyente = respuesta[0][0]; // Accedemos al valor dentro del array

            // Mostrar el valor en el HTML
            $('#totalContribuyente').text(ultimaContribuyente); // Actualiza el contenido del panel con el valor

        }
    });

});

//TOTAL FALLECIDAS
 $(document).ready(function() {
    let datos = new FormData();
    datos.append("reporte_total_fallecidas", "reporte_total_fallecidas");

    // Realizar la solicitud AJAX
    $.ajax({
        url: "ajax/reporteGeneral.ajax.php", // Asegúrate de que este sea el archivo correcto
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            console.log("ultima carpeta",respuesta);

           
            // Asegúrate de que la respuesta es el array que contiene el total de carpetas
            var totalFallecidas = respuesta[0][0]; // Accedemos al valor dentro del array

            // Mostrar el valor en el HTML
            $('#totalFallecidas').text(totalFallecidas); // Actualiza el contenido del panel con el valor

        }
    });

});


  



  $(document).ready(function() {

    // Obtener el contexto del canvas
    let ctx = $('#myChart')[0].getContext('2d');

    let datos = new FormData();
    datos.append("reporte_general", "reporte_general");

    // Realizar la solicitud AJAX
    $.ajax({
        url: "ajax/reporteGeneral.ajax.php", // Asegúrate de que este sea el archivo correcto
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            console.log(respuesta); // Verifica si los datos están correctos
            $("#modal_cargar").modal("hide");

            // Asegúrate de que la respuesta es un array y que contiene los datos esperados
            let data = respuesta;

            // Inicializar los valores de las barras
            let etiquetas = [];
            let cantidades = [];
            let nullCount = 0; // Variable para contar los valores nulos

            // Recorrer la respuesta y organizar los datos para cada estado
            data.forEach(item => {
                // Verificar y contar los valores nulos
                if (item[0] === null || item[1] === null) {
                    nullCount++; // Si encontramos un null, lo contamos
                }

                // Filtrar los valores nulos antes de agregar los datos al gráfico
                if (item[0] !== null && item[1] !== null) {
                    if (item[0] === 'P') {
                        etiquetas.push('Pendiente');
                        cantidades.push(item[1]);
                    } else if (item[0] === 'E') {
                        etiquetas.push('En progreso');
                        cantidades.push(item[1]);
                    } else if (item[0] === 'C') {
                        etiquetas.push('Completado');
                        cantidades.push(item[1]);
                    }
                }
            });

            // Agregar la barra para los valores nulos
            if (nullCount > 0) {
                etiquetas.push('Ninguno');
                cantidades.push(nullCount);
            }

            // Si no hay datos válidos, mostrar un mensaje o manejar el caso en el gráfico
            if (etiquetas.length === 0 || cantidades.length === 0) {
                console.log("No se encontraron datos válidos.");
                return; // Detener la creación del gráfico si no hay datos válidos
            }

            // Crear el gráfico con los datos obtenidos
            var myChart = new Chart(ctx, {
                type: 'bar', // Tipo de gráfico: barra
                data: {
                    labels: etiquetas, // Etiquetas del eje X: P, E, C, Null
                    datasets: [{
                        label: 'Estado de completado', // Título del conjunto de datos
                        data: cantidades, // Datos del gráfico: la cantidad de cada estado
                        backgroundColor: [
                            
                            
                            'rgb(40, 167, 69)', // Color para C
                            'rgb(255, 193, 7)', // Color para P
                            'rgb(23, 162, 184)', // Color para E
                            'rgba(255, 99, 132, 0.2)'  // Color para Null
                        ],
                        borderColor: [
                            'rgb(40, 167, 69)', // Color para C
                            'rgb(255, 193, 7)', // Color para P
                            'rgb(23, 162, 184)', // Color para E
                            'rgba(255, 99, 132, 1)'  // Borde para Null
                        ],
                        borderWidth: 1 // Ancho del borde
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true // Empezar en 0 en el eje Y
                        }
                    }
                }
            });
        }
    });

});







  $(document).ready(function() {

    // Obtener el contexto del canvas
    let ctx = $('#myChartl')[0].getContext('2d');

    let datos = new FormData();
    datos.append("reporte_general_agua", "reporte_general_agua");

    // Realizar la solicitud AJAX
    $.ajax({
        url: "ajax/reporteGeneral.ajax.php", // Asegúrate de que este sea el archivo correcto
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            console.log(respuesta); // Verifica si los datos están correctos
            $("#modal_cargar").modal("hide");

            // Asegúrate de que la respuesta es un array y que contiene los datos esperados
            let data = respuesta;

            // Inicializar los valores de las barras
            let etiquetas = [];
            let cantidades = [];
            let nullCount = 0; // Variable para contar los valores nulos

            // Recorrer la respuesta y organizar los datos para cada estado
            data.forEach(item => {
                // Verificar y contar los valores nulos
                if (item[0] === null || item[1] === null) {
                    nullCount++; // Si encontramos un null, lo contamos
                }

                // Filtrar los valores nulos antes de agregar los datos al gráfico
                if (item[0] !== null && item[1] !== null) {
                    if (item[0] === 'P') {
                        etiquetas.push('Pendiente');
                        cantidades.push(item[1]);
                    } else if (item[0] === 'E') {
                        etiquetas.push('En progreso');
                        cantidades.push(item[1]);
                    } else if (item[0] === 'C') {
                        etiquetas.push('Completado');
                        cantidades.push(item[1]);
                    }
                }
            });

            // Agregar la barra para los valores nulos
            if (nullCount > 0) {
                etiquetas.push('Ninguno');
                cantidades.push(nullCount);
            }

            // Si no hay datos válidos, mostrar un mensaje o manejar el caso en el gráfico
            if (etiquetas.length === 0 || cantidades.length === 0) {
                console.log("No se encontraron datos válidos.");
                return; // Detener la creación del gráfico si no hay datos válidos
            }

            // Crear el gráfico con los datos obtenidos
            var myChartl = new Chart(ctx, {
                type: 'bar', // Tipo de gráfico: barra
                data: {
                    labels: etiquetas, // Etiquetas del eje X: P, E, C, Null
                    datasets: [{
                        label: 'Estado de completado', // Título del conjunto de datos
                        data: cantidades, // Datos del gráfico: la cantidad de cada estado
                        backgroundColor: [
                            
                            
                            'rgb(40, 167, 69)', // Color para C
                            'rgb(255, 193, 7)', // Color para P
                            'rgb(23, 162, 184)', // Color para E
                            'rgba(255, 99, 132, 0.2)'  // Color para Null
                        ],
                        borderColor: [
                            'rgb(40, 167, 69)', // Color para C
                            'rgb(255, 193, 7)', // Color para P
                            'rgb(23, 162, 184)', // Color para E
                            'rgba(255, 99, 132, 1)'  // Borde para Null
                        ],
                        borderWidth: 1 // Ancho del borde
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true // Empezar en 0 en el eje Y
                        }
                    }
                }
            });
        }
    });

});