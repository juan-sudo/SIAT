class viascalleClass {
  constructor() {
    this.anio_registropredio = null;
    this.idDireccionC;
    this.numeroCuadraC;
    this.ladoCuadraC;
    this.zonaCatastroC;
    this.condicionCatastralC;
    this.situacionCuadraC;
    this.distanciaParqueC;
    this.manzanaC;
    this.nombreViaC;
    this.idViaC;
    this.idubicaViaC;
    this.idZonaViaC;
    this.codigo_nuevo=null;
    this.idvia=null;
  }
}
const vias = new viascalleClass();
/* Capturamos el Id del Año*/
$(document).on("change", "#anioFiscal", function () {
  vias.anio_registropredio = $("#anioFiscal").val();
  console.log(vias.anio_registropredio);
});

$(document).on("change", "#anioFiscal_e", function () {
  vias.anio_registropredio = $("#anioFiscal_e").val();
  console.log(vias.anio_registropredio);
});
/* Lista de Zonas de Rustico cuando se da Enter*/
function loadViacallePredioRustico(page) {
  let perfilOculto_predio = $("#perfilOculto_predio").val();
  if (event.key === "Enter") {
    let searchViacallePredio = $("#searchPredioRustico").val();
    let parametros = {
      action: "ajax",
      page: page,
      searchViacallePredio: searchViacallePredio,
      dpViacallePredioRustico: "dpViacallePredioRustico",
      perfilOculto_predio: perfilOculto_predio,
      anio: vias.anio_registropredio,
    };
    $.ajax({
      url: "vistas/tables/dataTables.php",
      data: parametros,
      beforeSend: function () {
        /* aqui se define datos o procesar antes de enviar al ajax*/
      },
      success: function (data) {
        $(".reloadp").hide();
        $(".body-prediosRusticos").html(data);
        /* Selccionar el rsutico y agregar al formaulario de registrar predio rustico*/
        $("#registro_rustico_modalPredio tbody").on("click", "tr", function () {
          const idClickeado = $(this).attr("id");
          // Verificar si el ID es igual al ID específico que deseas evitar
          if (idClickeado === "paginacion") {
            return; // No hacer nada si se hizo clic en el tr específico
          }
          // Restaurar el color de fondo de todas las filas del tbody
          $("#registro_rustico_modalPredio tbody tr").css(
            "background-color",
            ""
          );
          // Cambiar el color de fondo de la fila seleccionada
          $(this).css("background-color", "rgb(255, 248, 167);"); // Puedes cambiar 'yellow' al color que desees
          // Obtener el contenido de las celdas dentro de la fila clickeada
          const celdas = $(this).find("td");
          let contenidoCelda = "";
          for (let k = 0; k < celdas.length; k++) {
            contenidoCelda += $(celdas[k]).text() + "|";
          }
          $(".agregar_modal_rustico").on("click", function () {
            var partes = contenidoCelda.split("|");
            var id = partes[0];
            var nombre_zona = partes[1];
            var id_zona = partes[2];
            var grupo_tierra = partes[3];
            var categoria = partes[4];
            var calidad_agricola = partes[5];
            var valor = partes[6];
            var anio = partes[7];
            var id_rustico = partes[8];
            var html =
              "<tr><td>" +
              nombre_zona +
              "</td>" +
              '<td id="idZonaR">' +
              id_zona +
              "</td>" +
              "<td>" +
              grupo_tierra +
              "</td>" +
              "<td>" +
              categoria +
              "</td>" +
              "<td>" +
              calidad_agricola +
              "</td>" +
              "<td>" +
              valor +
              "</td>" +
              "<td>" +
              anio +
              "</td>" +
              '<td id="idzona_rustico">' +
              id_rustico +
              "</td></tr>";
            $("#itemsR").html(html);
            $("#valorArancelR").text(valor);
            $("#moda_PredioRustico").modal("hide");
          });
        });
      },
    });
  }
}
function loadViacallePredioRusticoe(page) {
  let aniosele = $("#selectnum").val();
  let perfilOculto_predio = $("#perfilOculto_predio").val();
  if (event.key === "Enter") {
    let searchViacallePredio = $("#searchPredioRustico").val();
    let parametros = {
      action: "ajax",
      page: page,
      searchViacallePredio: searchViacallePredio,
      dpViacallePredioRustico: "dpViacallePredioRustico",
      perfilOculto_predio: perfilOculto_predio,
      anio: aniosele,
    };
    $.ajax({
      url: "vistas/tables/dataTables.php",
      data: parametros,
      beforeSend: function () {
        /* aqui se define datos o procesar antes de enviar al ajax*/
      },
      success: function (data) {
        $(".reloadp").hide();
        $(".body-prediosRusticos").html(data);
        /* Selccionar el rsutico y agregar al formaulario de registrar predio rustico*/
        $("#registro_rustico_modalPredio tbody").on("click", "tr", function () {
          const idClickeado = $(this).attr("id");
          // Verificar si el ID es igual al ID específico que deseas evitar
          if (idClickeado === "paginacion") {
            return; // No hacer nada si se hizo clic en el tr específico
          }
          // Restaurar el color de fondo de todas las filas del tbody
          $("#registro_rustico_modalPredio tbody tr").css(
            "background-color",
            ""
          );
          // Cambiar el color de fondo de la fila seleccionada
          $(this).css("background-color", "rgb(255, 248, 167);"); // Puedes cambiar 'yellow' al color que desees
          // Obtener el contenido de las celdas dentro de la fila clickeada
          const celdas = $(this).find("td");
          let contenidoCelda = "";
          for (let k = 0; k < celdas.length; k++) {
            contenidoCelda += $(celdas[k]).text() + "|";
          }
          $(".agregar_modal_rustico").on("click", function () {
            var partes = contenidoCelda.split("|");
            var id = partes[0];
            var nombre_zona = partes[1];
            var id_zona = partes[2];
            var grupo_tierra = partes[3];
            var categoria = partes[4];
            var calidad_agricola = partes[5];
            var valor = partes[6];
            var anio = partes[7];
            var id_rustico = partes[8];
            var html =
              "<tr><td>" +
              nombre_zona +
              "</td>" +
              '<td id="idZonaR">' +
              id_zona +
              "</td>" +
              "<td>" +
              grupo_tierra +
              "</td>" +
              "<td>" +
              categoria +
              "</td>" +
              "<td>" +
              calidad_agricola +
              "</td>" +
              "<td>" +
              valor +
              "</td>" +
              "<td>" +
              anio +
              "</td>" +
              '<td id="idzona_rustico">' +
              id_rustico +
              "</td></tr>";
            $("#itemsR").html(html);
            $("#valorArancelR").text(valor);
            $("#moda_PredioRusticoe").modal("hide");
          });
        });
      },
    });
  }
}
function loadViacallePredioRusticop(page) {
  let perfilOculto_predio = $("#perfilOculto_predio").val();
  let searchViacallePredio = $("#searchPredioRustico").val();
  let parametros = {
    action: "ajax",
    page: page,
    searchViacallePredio: searchViacallePredio,
    dpViacallePredioRustico: "dpViacallePredioRustico",
    perfilOculto_predio: perfilOculto_predio,
    anio: vias.anio_registropredio,
  };
  $.ajax({
    url: "vistas/tables/dataTables.php",
    data: parametros,
    beforeSend: function () {
      //  $("body").append(loadp);
    },
    success: function (data) {
      $(".reloadp").hide();
      $(".body-prediosRusticos").html(data);
    },
  });
}
var elementosAgregados = new Set();
// Validar si un elemento ya ha sido agregado
function esElementoAgregado(codigo) {
  return elementosAgregados.has(codigo);
}
// LISTAR CONTRIBUYENTE- PROPIETARIO EN EL MODAL DE REGISTRO PREDIO - VALIDADO
function loadPropietario(page) {
  if (event.key === "Enter") {
    let perfilOculto_p = $("#perfilOculto_p").val();
    let searchPropietario = $("#searchPropietario").val();
    let parametros = {
      action: "ajax",
      page: page,
      searchPropietario: searchPropietario,
      dpPropietario: "dpPropietario",
      perfilOculto_p: perfilOculto_p,
    };
    $.ajax({
      url: "vistas/tables/dataTables.php",
      // method: 'GET',
      data: parametros,
      // cache: false,
      // contentType: false,
      // processData: false,
      beforeSend: function () {
        //  $("body").append(loadp);
      },
      success: function (data) {
        $(".reloadp").hide();
        $(".body-propietario").html(data);
        //RESALTA CON COLOR AL PROPIETARIO EN EL POPUP
        // Delegación de eventos para las filas de la tabla paginada
        $(document).on("click","#registro_propietario_modal tbody tr",
          function () {
            const idClickeado_pro = $(this).attr("id");

            // Verificar si el ID es igual al ID específico que deseas evitar
            if (idClickeado_pro === "paginacion_pro") {
              return; // No hacer nada si se hizo clic en el tr específico
            }
            // Restaurar el color de fondo de todas las filas del tbody
            $("#registro_propietario_modal tbody tr").css(
              "background-color",
              ""
            );

            // Cambiar el color de fondo de la fila seleccionada
            $(this).css("background-color", "rgb(255, 248, 167);");
            // Obtener el contenido de las celdas dentro de la fila clickeada
            const celdas = $(this).find("td");
            contenidoFilaSeleccionada = "";
            for (let k = 0; k < celdas.length - 1; k++) {
              contenidoFilaSeleccionada += $(celdas[k]).text() + "|";
            }
            console.log(
              "contenidoFilaSeleccionada:",contenidoFilaSeleccionada
            );
          }
        );
        //AGREGA EL VALOR DEL MODAL A LA PAGINA PRINCIPAL
        // Asigna el manejador de eventos para el botón plus
        $(".agregarvalor_modal_pro").on("click", function () {
          if (contenidoFilaSeleccionada) {
            var partes = contenidoFilaSeleccionada.split("|");
            var codigo = partes[1]; // Obtener el valor único desde el popup
             vias.codigo_nuevo=codigo;
             console.log("codigo nuevo seleccionado" + vias.codigo_nuevo);
            if (!esElementoAgregado(codigo)) {
              // Agregar el elemento al conjunto
              elementosAgregados.add(codigo);

              var documento = partes[2]; // 76936793
              var nombres = partes[3]; // HANCCO SUAREZ STALIN VICTOR

              var html =
                '<tr id="'+codigo+
                '">' +
                "<td><center>" +
                codigo +
                "</center></td>" +
                "<td><center>" +
                documento +
                "</center></td>" +
                "<td><center>" +
                nombres +
                "</center></td>" +
                '<td><center><button type="button" class="btn btn-danger btn-xs btnEliminarItemPropietario" data-itemeliminar="'+
                codigo+
                '"><i class="fas fa-trash-alt"></i></button></td>' +
                "</center></tr>";
              // Agrega el HTML al contenedor deseado
              $("#div_propietario").append(html);
              $("#div_propietario2").append(html);
            } else {
              // Muestra un mensaje si el valor ya ha sido agregado
              alert("Este elemento ya ha sido agregado.");
            }
          } else {
            // Muestra un mensaje si no se ha seleccionado ninguna fila
            alert("Debes seleccionar una fila primero.");
          }
          // Cierra el modal
          $("#modalPropietarios").modal("hide");
        });
        // Agrega un manejador de eventos clic para los botones de eliminación
        $(document).on("click", ".btnEliminarItemPropietario", function () {
          // Encuentra el elemento padre (el <tr> que contiene el botón)
          var fila = $(this).closest("tr");

          // Obtén el valor del atributo data-itemeliminar que contiene el código único
          var codigo = $(this).data("itemeliminar");

          // Elimina la fila completa
          fila.remove();

          // Elimina el elemento del conjunto elementosAgregados
          elementosAgregados.delete(codigo);
        });
        //finde insertar codigo
      },
    });
  }
}
// Agrega un manejador de eventos clic para los botones de eliminación
function loadPropietariop(page) {
  let perfilOculto_p = $("#perfilOculto_p").val();
  let searchPropietario = $("#searchPropietario").val();
  let parametros = {
    action: "ajax",
    page: page,
    searchPropietario: searchPropietario,
    dpPropietario: "dpPropietario",
    perfilOculto_p: perfilOculto_p,
  };

  $.ajax({
    url: "vistas/tables/dataTables.php",
    // method: 'GET',
    data: parametros,
    // cache: false,
    // contentType: false,
    // processData: false,
    beforeSend: function () {
      //  $("body").append(loadp);
    },
    success: function (data) {
      $(".reloadp").hide();
      $(".body-propietario").html(data);
    },
  });
}
// LISTAR VIAS CALLES EN REGISTRO CONTRIBUYENTE Y AGREGAR DEL MODAL A LA PAGINA -REGISTRO CONTRIBUYENTE
function loadViacalle(page,parametro) {
  let perfilOculto_v = $("#perfilOculto_v").val();
  if (event.key === "Enter") {
    let searchViacalle = $("#searchViacalle").val();
    let parametros = {
      action: "ajax",
      page: page,
      searchViacalle: searchViacalle,
      dpViacalle: "dpViacalle",
      perfilOculto_v: perfilOculto_v,
    };
    $.ajax({
      url: "vistas/tables/dataTables.php",
      data: parametros,
      beforeSend: function () {
      },
      success: function (data) {
        $(".body-viascalles").html(data);
        //SELECCIONAR LA DIRECCION UBICA VIAS URBANO Y RESALTAR VALOR
        $(".agregarvalor_modal_c").on("click", function () {
           vias.idvia = $(this).attr("idvia");
           let parametros2 = {
            action: "ajax",
            page: page,
            searchViacalle: vias.idvia,
            dpViacalle_idvia: "dpViacalle_idvia",
           }
           $.ajax({
            url: "vistas/tables/dataTables.php",
            data: parametros2,
            beforeSend: function () {
            },
            success: function (data) {
              console.log(data);
            
                $(parametro).html(data); // Puedes cambiar el selector según lo necesites
                $("#modalViascalles").modal("hide");
            
            },
          });
        });
      },
    });
  }
}

/* Es cuando le doy click en la paginacion*/
function loadViacallep(page) {
  let perfilOculto_v = $("#perfilOculto_v").val();
  let searchViacalle = $("#searchViacalle").val();
  let parametros = {
    action: "ajax",
    page: page,
    searchViacalle: searchViacalle,
    dpViacalle: "dpViacalle",
    perfilOculto_v: perfilOculto_v,
  };

  $.ajax({
    url: "vistas/tables/dataTables.php",
    // method: 'GET',
    data: parametros,
    // cache: false,
    // contentType: false,
    // processData: false,
    beforeSend: function () {
      //  $("body").append(loadp);
    },
    success: function (data) {
      $(".reloadp").hide();
      $(".body-viascalles").html(data);
    },
  });
}
// DESDE LA VISTA DE REGISTRO DE PREDIO
// LISTAR VIAS CALLES EN REGISTRO CONTRIBUYENTE Y AGREGAR DEL MODAL A LA PAGINA -REGISTRO PREDIO
function loadViacallePredio(page) {
  let perfilOculto_predio = $("#perfilOculto_predio").val();
  if (event.key === "Enter") {
    let searchViacallePredio = $("#searchViacallePredio").val();
    let parametros = {
      action: "ajax",
      page: page,
      searchViacallePredio: searchViacallePredio,
      dpViacallePredio: "dpViacallePredio",
      perfilOculto_predio: perfilOculto_predio,
      anio: vias.anio_registropredio,
    };
    $.ajax({
      url: "vistas/tables/dataTables.php",
      data: parametros,
      beforeSend: function () {
        //  $("body").append(loadp);
      },
      success: function (data) {
        $(".reloadp").hide();
        $(".body-viascallesPredio").html(data);
        //SELECCIONAR LA DIRECCION UBICA VIAS URBANO Y RESALTAR VALOR  - REGISTRO PREDIO
        $("#registro_vias_modalPredio tbody").on("click", "tr", function () {
          const idClickeado = $(this).attr("id");

          // Verificar si el ID es igual al ID específico que deseas evitar
          if (idClickeado === "paginacion") {
            return; // No hacer nada si se hizo clic en el tr específico
          }
          // Restaurar el color de fondo de todas las filas del tbody
          $("#registro_vias_modalPredio tbody tr").css("background-color", "");
          // Cambiar el color de fondo de la fila seleccionada
          $(this).css("background-color", "rgb(255, 248, 167);"); // Puedes cambiar 'yellow' al color que desees
          // Obtener el contenido de las celdas dentro de la fila clickeada
          const celdas = $(this).find("td");
          let contenidoCelda = "";
          for (let k = 0; k < celdas.length; k++) {
            contenidoCelda += $(celdas[k]).text() + "|";
          }
          $(".agregarvalor_modal_Predio_via").on("click", function () {
            var partes = contenidoCelda.split("|");
            var id = partes[0]; // "ID"
            var tipo = partes[1]; // "TIPO PREDIO"
            var direccion = partes[2]; // "DIRECCION PREDIO"
            var manzana = partes[3]; // "MANZANA"
            var cuadra = partes[4]; //CUADRA
          //  var lado = partes[5]; //LADO
            var zona = partes[5]; //ZONA
            var habilitacion_urbana = partes[6]; //HABILITACION
            var arancel = partes[7]; //ARANCEL
            var idvia = partes[8]; //IDVIA
            var condicion = partes[9]; //CONDICION
            var html =
              "<tr><td> " +
              tipo +
              "  " +
              direccion +
              "</td>" +
              "<td> " +
              manzana +
              "</td>" +
              "<td>" +
              cuadra +
              "</td>" +
              "<td>" +
              zona +
              "</td>" +
              "<td>" +
              habilitacion_urbana +
              "</td>" +
              "<td>" +
              arancel +
              "</td>" +
              '<td  id="idvia_Predio">' +
              idvia +
              "</td>" +
              "<td>" +
              condicion +
              "</td></tr>";
            $("#itemsRP").html(html);
              let valor;
              let valor2;
            $("#valorArancel").text(arancel);
            valor = parseInt(arancel);
            valor2 = $("#areaTerreno").val();
            $("#valorTerreno").text(arancel*valor2);
            $("#modalViacalle_Predio").modal("hide");
          });
        });
      },
    });
  }
}

function loadViacallePredioE(page) {
  let perfilOculto_predio = $("#perfilOculto_predio").val();

  let anioEdit = $("#anioFiscal_e").val();
  //console.log(anioEdit);
  if (event.key === "Enter") {
    let searchViacallePredio = $("#searchViacallePredio").val();
    let parametros = {
      action: "ajax",
      page: page,
      searchViacallePredio: searchViacallePredio,
      dpViacallePredio: "dpViacallePredio",
      perfilOculto_predio: perfilOculto_predio,
      anio: anioEdit,
    };
    $.ajax({
      url: "vistas/tables/dataTables.php",
      data: parametros,
      beforeSend: function () {
        //  $("body").append(loadp);
      },
      success: function (data) {
        $(".reloadp").hide();
        $(".body-viascallesPredio").html(data);
        //SELECCIONAR LA DIRECCION UBICA VIAS URBANO Y RESALTAR VALOR  - REGISTRO PREDIO
        $("#registro_vias_modalPredio tbody").on("click", "tr", function () {
          const idClickeado = $(this).attr("id");

          // Verificar si el ID es igual al ID específico que deseas evitar
          if (idClickeado === "paginacion") {
            return; // No hacer nada si se hizo clic en el tr específico
          }
          // Restaurar el color de fondo de todas las filas del tbody
          $("#registro_vias_modalPredio tbody tr").css("background-color", "");
          // Cambiar el color de fondo de la fila seleccionada
          $(this).css("background-color", "rgb(255, 248, 167);"); // Puedes cambiar 'yellow' al color que desees
          // Obtener el contenido de las celdas dentro de la fila clickeada
          const celdas = $(this).find("td");
          let contenidoCelda = "";
          for (let k = 0; k < celdas.length; k++) {
            contenidoCelda += $(celdas[k]).text() + "|";
          }
          $(".agregarvalor_modal_Predio_via").on("click", function () {
            var partes = contenidoCelda.split("|");
            var id = partes[0]; // "ID"
            var tipo = partes[1]; // "TIPO PREDIO"
            var direccion = partes[2]; // "DIRECCION PREDIO"
            var manzana = partes[3]; // "MANZANA"
            var cuadra = partes[4]; //CUADRA
           // var lado = partes[5]; //LADO
            var zona = partes[5]; //ZONA
            var habilitacion_urbana = partes[6]; //HABILITACION
            var arancel = partes[7]; //ARANCEL
            var idvia = partes[8]; //IDVIA
            var condicion = partes[9]; //CONDICION
            var html =
              "<tr><td> " +
              tipo +
              "  " +
              direccion +
              "</td>" +
              "<td> " +
              manzana +
              "</td>" +
              "<td>" +
              cuadra +
              "</td>" +
              
              "<td>" +
              zona +
              "</td>" +
              "<td>" +
              habilitacion_urbana +
              "</td>" +
              "<td>" +
              arancel +
              "</td>" +
              '<td  id="idvia_Predio">' +
              idvia +
              "</td>" +
              "<td>" +
              condicion +
              "</td></tr>";
            $("#itemsRP").html(html);
            $("#valorArancel_e").text(arancel);
            $("#modalViacalle_Predio").modal("hide");
          });
        });
      },
    });
  }
}

function loadViacallePrediop(page) {
  let perfilOculto_predio = $("#perfilOculto_predio").val();
  let searchViacallePredio = $("#searchViacallePredio").val();
  let parametros = {
    action: "ajax",
    page: page,
    searchViacallePredio: searchViacallePredio,
    dpViacallePredio: "dpViacallePredio",
    perfilOculto_predio: perfilOculto_predio,
  };
  $.ajax({
    url: "vistas/tables/dataTables.php",
    data: parametros,
    beforeSend: function () {
      //  $("body").append(loadp);
    },
    success: function (data) {
      $(".reloadp").hide();
      $(".body-viascallesPredio").html(data);
    },
  });
}

//==================  MOSTRAR LAS SUBVIAS DE LA VIAS ==================
let nuevaCuadra;
nuevaCuadra = new viascalleClass();
$(document).on("change", "#Id_NombreVia", function () {
  $("#divCamposCuadra").show();
  //$("#divCuadras").hide();
  nuevaCuadra.nombreViaC = $("#Id_NombreVia").val();
  nuevaCuadra.idDireccionC =$("#Id_NombreVia").val();
  traerCuadrasDireccion(nuevaCuadra.nombreViaC);
});

$(document).on("click", "#tablalistaDeSubVias tbody tr", function () {
  $("#divCuadras").show();
  traerCuadrasDireccion(nuevaCuadra.idDireccionC);
  //$("#divCamposCuadra").hide();
});

$(document).on("click", ".btnAgregarCuadra", function () {
  nuevaCuadra.idDireccionC = $(this).attr("idDireccion");
  $("#divCamposCuadra").show();
});

$(document).on("click", "#btnRegistrarCuadra", function () {
  nuevaCuadra.numeroCuadraC = $("#numeroCuadra").val();
  nuevaCuadra.ladoCuadraC = $("#idLadoCuadra").val();
  nuevaCuadra.zonaCatastroC = $("#idZonaCatastro").val();
  nuevaCuadra.condicionCatastralC = $("#idCondCatastral").val();
  nuevaCuadra.situacionCuadraC = $("#idSituacionCuadra").val();
  nuevaCuadra.distanciaParqueC = $("#idDistanciaParque").val();
  nuevaCuadra.manzanaC = $("#idManzana").val();
  nuevaCuadra.idZonaViaC= $("#zonaSel").val();
  let formd = new FormData();
  formd.append("idNumeroCuadra", nuevaCuadra.numeroCuadraC);
  formd.append("idLadoCuadra", nuevaCuadra.ladoCuadraC);
  formd.append("idDireccionesVia", nuevaCuadra.idDireccionC);
  formd.append("idCondCatastral", nuevaCuadra.condicionCatastralC);
  formd.append("idSituacionCuadra", nuevaCuadra.situacionCuadraC);
  formd.append("idDistanciaParque", nuevaCuadra.distanciaParqueC);
  formd.append("idManzana", nuevaCuadra.manzanaC);
  formd.append("registrarCuadra", "registrarCuadra");
  formd.append("nombreViaC", nuevaCuadra.nombreViaC);
  formd.append("idZonaCatastro", nuevaCuadra.zonaCatastroC);
  formd.append("idZona", nuevaCuadra.idZonaViaC);
  $.ajax({
    type: "POST",
    url: "ajax/viascalles.ajax.php",
    data: formd,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      if (respuesta == "no") {
        alert("Error!, La cuadra ya existe");
      } else {
        alert("Exito!!, Se registro la cuadra");
       traerCuadrasDireccion(nuevaCuadra.idDireccionC);
      }
    },
  });
});

$(document).on("click", ".btnEliminarViascalles", function () {
  let idDireccion = $(this).attr("idUsuario");
  let usuario = $(this).attr("idUsuario");
  Swal.fire({
    title: "¿Estás seguro de eliminar la Direccion?",
    text: "¡Si no lo está puede cancelar la acción!",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminarlo!",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = `index.php?ruta=viascalles&idDireccion=${idDireccion}&usuario=${usuario}`;
    }
  });
});

$(document).ready(function () {
  $("#divCamposCuadra").hide();
  $("#id_AnioArancel").change(function () {
    var selectedYear = $(this).val();
    $.ajax({
      type: "POST",
      url: "ajax/viascalles.ajax.php",
      data: {
        selectedYear: selectedYear,
      },
      success: function (respuesta) {
        respuesta = JSON.parse(respuesta);
        $("#idArancelVia").empty(); // Limpiar combobox
        respuesta.forEach((value) => {
          $("#idArancelVia").append(
            "<option value='" +
              value.Id_Arancel +
              "'>" +
              value.Importe +
              "</option>"
          );
        });
      },
    });
  });
});

// function TraerDirecciones(idNombreVia) {
//   const cuerpoTabla = document.getElementById("listaSubVias");
//   const filas = cuerpoTabla.getElementsByTagName("tr");
//   while (filas.length > 0) {
//     cuerpoTabla.deleteRow(0);
//   }
//   if (idNombreVia === "vacio") {
//     $("#listaSubVias").html("Click Fila");
//   } else {
//     $("#listaSubVias").html("");
//   }
//   $.ajax({
//     type: "POST",
//     url: "ajax/viascalles.ajax.php",
//     data: {
//       idNombreVia: idNombreVia,
//     },
//     success: function (respuesta) {
//       respuesta = JSON.parse(respuesta);
//       respuesta.forEach((value) => {
//         let fila = cuerpoTabla.insertRow();
//         fila.innerHTML = `<td class="text-center">${value.Codigo} ${value.Nombre_Via} </td><td>${value.Habilitacion_Urbana} - ${value.Nombre_Zona}</td><td>0</td><td><input type="button" class="btn btn-primary btnAgregarCuadra" idDireccion="${value.Id_Direccion}" value="Agregar Cuadra"></td>`;
//         $(fila).on("click", function () {
//           nuevaCuadra.idDireccionC = $(this)
//             .find(".btnAgregarCuadra")
//             .attr("idDireccion");
//           console.log(nuevaCuadra.idDireccionC);
//         });
//       });
//     },
//   });
// }

function traerCuadrasDireccion(idDireccionVia) {
  let bodyCuadras = document.getElementById("listaUbicaViaUrbano");
  let filaCuadra = bodyCuadras.getElementsByTagName("tr");
  while (filaCuadra.length > 0) {
    bodyCuadras.deleteRow(0);
  }
  if (idDireccionVia === "vacio") {
    $("#listaUbicaViaUrbano").html("Click Fila");
  } else {
    $("#listaUbicaViaUrbano").html("");
  }
  $.ajax({
    type: "POST",
    url: "ajax/viascalles.ajax.php",
    data: {
      idDireccionVia: idDireccionVia,
    },
    success: function (respuesta) {
      console.log(respuesta);
      respuesta = JSON.parse(respuesta);
      respuesta.forEach((value) => {
        let fila = bodyCuadras.insertRow();
        fila.innerHTML = `<td class="text-center">${value.Numero_Cuadra}</td><td>${value.Lado}</td><td>${value.Condicion_Catastral}</td><td>${value.Situacion_Cuadra}</td><td>${value.NumeroManzana}</td><td>${value.Nombre_Zona}</td>`;
      });
    },
  });
}
$(document).on("change", "#Id_NombreVia1", function () {
  vias.idViaC = document.getElementById("Id_NombreVia1").value;
  //alert(' id : ' + vias.idViaC);
  window.location = `index.php?ruta=arancel-vias&Viascalles=${vias.idViaC}`;
});
function listadeArancel(idAreaC) {
  const cuerpoTabla = document.getElementById("listaDetalleFilas");
  const filas = cuerpoTabla.getElementsByTagName("tr");
  while (filas.length > 0) {
    cuerpoTabla.deleteRow(0); // Elimina la primera fila de la tabla
  }
  $("#listaDetalleFilas").html("");
  $.ajax({
    type: "POST",
    url: "ajax/viascalles.ajax.php",
    data: {
      idDireccionVia: idAreaC,
    },
    success: function (respuesta) {
      if (respuesta === "pisovacio") {
        let fila = cuerpoTabla.insertRow();
        fila.innerHTML = `<td class="text-center" colspan='10' style='text-align:center;'>No registra vias </td>`;
      } else {
        let estado;
        let estadopago;
        console.log(respuesta);
        respuesta = JSON.parse(respuesta);
        respuesta.forEach((value) => {
          if (value.Estado_Caja === "1") {
            estado = "Pagado";
          } else {
            estado = "Pendiente";
          }
          if (value.Estado_Uso === "1") {
            estadopago = "Usado";
          } else {
            estadopago = "Usado";
          }
          let fila = cuerpoTabla.insertRow();
          fila.innerHTML =
            `
            <td class="text-center">${value.Numero_Proveido}</td>
            <td>${value.Nombres}</td>
            <td>${value.Valor_Total}</td>
            <td class="text-center">
              <span>` +
            estado +
            `</span>
            </td>
            <td>
            <span>` +
            estadopago +
            `</span>
            </td>
            <td class="text-center">
						<button class="btn btn-warning btnEditarProve" idProveido="${value.Id_Proveido}"><i class="fas fa-user-edit"></i></button>
						<span> </span>
						<button class="btn btn-warning btnImprimirProve" idProveido="${value.Id_Proveido}"><i class="fas fa-file"></i></button><span></span>
						<button class="btn btn-danger btnEliminarProve" idProveido="${value.Id_Proveido}"><i class="fas fa-trash-alt"></i></button>
				</td>`;
        });
      }
      $(".chkToggle2").bootstrapToggle();
    },
  });
}
/*$(document).on("click", "#listaDetalleFilas tbody tr", function () {
  $("#divCuadras").show();
  traerCuadrasDireccion(nuevaCuadra.idDireccionC);
});*/
$(document).on("click", "#listaViasCallesArancel tbody tr", function () {
  let idUsuario = $(this).find(".btnEditarViascalles1").attr("idUsuario");
  console.log("Valor de idUsuario:", idUsuario);
  $.ajax({
    type: "POST",
    url: "ajax/viascalles.ajax.php",
    data: {
      idubicaArancel: idUsuario,
    },
    success: function (respuesta) {
      respuesta = JSON.parse(respuesta);
      const cuerpoTabla = document.getElementById("listaAranceles");
      const filas = cuerpoTabla.getElementsByTagName("tr");
      while (filas.length > 0) {
        cuerpoTabla.deleteRow(0); // Elimina la primera fila de la tabla
      }
      let key = 0;
      respuesta.forEach((value) => {
        let fila = cuerpoTabla.insertRow();
        fila.innerHTML = `<td class="text-center">${(key = key + 1)}</td>
                          <td class="text-center">${value.NomAnio}</td>
                          <td class="text-center">${value.Importe}</td>
                          <td class="text-center">  
                            <img src='./vistas/img/iconos/editar1.png'  class="t-icon-tbl-p btnEditarArancelVia" title="Editar" idUsuario="${value.Id_Arancel_Vias}" data-toggle="modal" data-target="#modalEditarArancelVia">
                          </td>        
`;
      });
    },
  });
});

$(document).on("click", ".btnEditarViascalles1", function () {
  nuevaCuadra.idubicaViaC = $(this).attr("idUsuario");
});
$(document).on("click", "#btnRegistrarArancelVia", function () {
  let idviaArancel = $("#idArancelVia").val();
  let formd = new FormData();
  formd.append("idviaArancel", idviaArancel);
  formd.append("idubicaViaC", nuevaCuadra.idubicaViaC);
  formd.append("regiArancelVia", true);
  /*for (const pair of formd.entries()) {
    console.log(pair[0] + ", " + pair[1]);
  }*/
  $.ajax({
    type: "POST",
    url: "ajax/viascalles.ajax.php",
    data: formd, // Solo necesitas pasar 'formd' como datos
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      console.log(respuesta);
      if (respuesta == "no") {
        alert("Error!, el arancel ya existe");
      } else {
        alert("Exito!!, Se registro el arancel");
      }
    },
  });
});
$(document).on("click", ".btnEditarArancelVia", function () {
  var idUsuario = $(this).attr("idUsuario");
  var datos = new FormData();
  datos.append("idArancelVia", idUsuario);
  $.ajax({
    url: "ajax/viascalles.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#idarancelVia_e").val(respuesta[0].Id_Arancel_Vias);
      $("#id_AnioArancel_e").val(respuesta[0].Id_Anio);
      $("#idArancel_e").val(respuesta[0].Id_Arancel);
     },
  });
});

$(document).on("click", "#btnRegistrarArancelVia_e", function () {
    //DesCamposRegee();
    let formd = new FormData($("#formRegArancel_e")[0]);

    $.ajax({
      type: "POST",
      url: "ajax/viascalles.ajax.php",
      data: formd,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json", // Corrección aquí
      success: function (respuesta) {
        $("#respuestaAjax_srm").show();
        $("#respuestaAjax_srm").html(respuesta.mensaje);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 5000);
        //nuevoProvedio.MostrarProveidos(nuevoProvedio.idAreaC);
      },
    });
});