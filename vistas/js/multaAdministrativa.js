class MultaAdministrativa {
    constructor() {
      this.idProveidoC = null;
      this.idEspecieC = null;
      this.numProveidoC = null;
      this.nombreEspecieC = null;
      this.nomProveidoC = null;
      this.idAreaC = null;
      this.nombreAreaC = null;
      this.aPateProveidoC = null;
      this.aMateProveidoC = null;
      this.cantidadProveidoC = null;
      this.precioProveidoC = null;
      this.valorProveidoC = null;
      this.estUsoProveidoC = null;
      this.estCajaProveidoC = null;
      this.descProveidoC = null;
      this.calculable = null;
      this.elementosAgregados = [];
      this.Monto_=null;
      this.total=null;
      this.numero_proveido_e=null;
      this.isEditing=false;
      this.fechaPres=null;
  
    }
    MostrarProveidos(idAreaC, fechPres) {
      const cuerpoTabla = document.getElementById("listaProveidos");
      const filas = cuerpoTabla.getElementsByTagName("tr");
  
      while (filas.length > 0) {
        cuerpoTabla.deleteRow(0); // Elimina la primera fila de la tabla
      }
      $("#listaProveidos").html("");
      $.ajax({
        type: "POST",
        url: "ajax/proveidos.ajax.php",
        data: {
          mostrar_proveido:"mostrar_proveido",
          area: idAreaC,
          fechPres: fechPres,
        },
        success: function (respuesta) {
          console.log(respuesta);
          if (respuesta === "nulo") {
            let fila = cuerpoTabla.insertRow();
            fila.innerHTML = `<td class="text-center" colspan='10'>No registra Proveidos</td>`;
          } else {         
            let estado;
            let estadopago;
            //console.log(respuesta);
            respuesta = JSON.parse(respuesta);
            respuesta.forEach((value) => {
              if(value.Estado_Caja === "1"){estado='Pagado'}else{estado='Pendiente'}
              if(value.Estado_Uso === "1"){estadopago='Usado'}else{estadopago='Usado'}
              let fila = cuerpoTabla.insertRow();
              fila.innerHTML = `
              <td class="text-center">${value.Numero_Proveido}</td>
              <td>${value.Nombres}</td>
              <td>${value.Valor_Total}</td>
              <td class="text-center">
                <span><i class="bi bi-eye lis_ico_con" n_proveido='${value.Numero_Proveido}' ></i></span>
              </td>
              <td class="text-center">
              <i class="bi bi-pencil-fill lis_ico_con btnEditarProve" title="Editar" title="Editar" numero_proveido_e="${value.Numero_Proveido}"></i>
                          <i class="bi bi-file-earmark-pdf lis_ico_con btnImprimirProve" title="Imprimir Proveido" numero_proveido_pdf="${value.Numero_Proveido}"></i>
              <i class="bi bi-trash3-fill lis_ico_con btnEliminarProve" title="Eliminar" idProveido="${value.Id_Proveido}"></i>
                  </td>`;
            });
          }
          $(".chkToggle2").bootstrapToggle();
        },
      });
    }
    CalcularTotal() {
      this.valorProveidoC = this.precioProveidoC * this.cantidadProveidoC;
    }
    //generar el pdf del proveido
    generarpdfproveido(numero_proveido_pdf){
            let datos = new FormData();
            datos.append("numero_proveido_pdf",numero_proveido_pdf);
            datos.append("area",general.iso_area);
            console.log("numero_proveido:"+ numero_proveido_pdf);
            console.log("area:"+ general.iso_area);
            $.ajax({
              url: "./vistas/print/imprimirProveido.php",
              method: "POST",
              data: datos,
              cache: false,
              contentType: false,
              processData: false,
              success: function (rutaArchivo) {
                // Establecer el src del iframe con la ruta relativa del PDF
                document.getElementById("iframe_proveido").src = 'vistas/print/' + rutaArchivo;
              }
            });   
    }
  
    mostrar_detalle_proveido(numero_proveido){
      const cuerpoTabla = document.getElementById("especie_valorada_estado_caja");
      let datos = new FormData();
            datos.append("numero_proveido",numero_proveido);
            datos.append("area",general.iso_area);
            datos.append("mostrar_detalle_pago","mostrar_detalle_pago");
            $.ajax({
              url:"ajax/proveidos.ajax.php",
              method: "POST",
              data: datos,
              cache: false,
              contentType: false,
              processData: false,
              success: function (respuesta) {
                let estado;
                respuesta = JSON.parse(respuesta);
                respuesta.forEach((value) => {
                  if(value.Estado_Caja === "1"){estado='Pagado'}else{estado='Pendiente'}
              let fila = cuerpoTabla.insertRow();
              fila.innerHTML = `
              <td class="text-center">${value.Numero_Proveido}</td>
              <td>${value.Descripcion}</td>
              <td>${value.Nombre_Area}</td>
              <td>${value.Cantidad}</td>
              <td>${value.Valor_Total/value.Cantidad}</td>
              <td>${value.Valor_Total}</td>
              <td>`+estado+`</td>`;
            });
  
              }
            });   
    }
  }
  const multa = new MultaAdministrativa();
  const editarmulta = new MultaAdministrativa();
  $(document).ready(function () {
  
    /*Mostrando los proveidos*/
    multa.fechaPres = obtenerFechaActual();
    document.getElementById("fechaProveido").value = multa.fechaPres;
    multa.MostrarProveidos(general.iso_area, multa.fechaPres);
  
  
  
    $(document).on("change", "#precioProveido", function () {
  
        multa.precioProveidoC=$("#precioProveido").val();
        multa.CalcularTotal();
      $("#totalProveido").val(multa.valorProveidoC);
    });
    $(document).on("click", "#salirRegistroModal", function () {
      $("#formRegistrarProveido")[0].reset();
      $("#modalNuevoProveido").hide();
    });
    $(document).on("change", "#cantidaProveido", function () {
        multa.cantidadProveidoC = $("#cantidaProveido").val();
        multa.CalcularTotal();
      $("#totalProveido").val(multa.valorProveidoC);
    });
    $(document).on("change", "#fechaProveido", function () {
      fechaPres = $("#fechaProveido").val();
      multa.MostrarProveidos(general.iso_area, fechaPres);
      console.log(general.iso_area);
      console.log(fechaPres);
    });
  
    
    /* Registro de Proveido*/
    $(document).on("click", "#btnRegistrarProveido", function () {
      DesCamposReg();
      let arrayProveidos = [];
      $("#especie_valorada_a tr").each(function() {
          let idTr = $(this).attr('id');
          let id_areap = $(this).attr('id_area');
          let numero = $(this).find('td:nth-child(1)').text().trim();
          let nombreEspecie = $(this).find('td:nth-child(2)').text().trim();
          let cantidad = $(this).find('input[name="cantidad_especie"]').val().trim();
          let monto = $(this).find('.monto_cantidad_total').text().trim();
          let montoTotal = $(this).find('.monto_cantidad_total').text().trim();
          let objetoProveido = {
              id: idTr,
              numero: numero,
              nombreEspecie: nombreEspecie,
              id_areap: id_areap,
              cantidad: cantidad,
              monto: monto,
              montoTotal: montoTotal
          };
          arrayProveidos.push(objetoProveido);
      });
      console.log("valores del cuadro", arrayProveidos);
      let formd = new FormData($("#formRegistrarProveido")[0]);
      formd.append("registrarProveido", "true");
      formd.append("area_generar", general.iso_area);
      formd.append('items', JSON.stringify(arrayProveidos));
      console.log(formd);
      $.ajax({
        type: "POST",
        url: "ajax/proveidos.ajax.php",
        data: formd,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta.tipo === "advertencia") {
            $("#respuestaAjax_srm").show();
            $("#respuestaAjax_srm").html(respuesta.mensaje);
            setTimeout(function () {
              $("#respuestaAjax_srm").hide();
            }, 10000);
          }
          else{
            $("#especie_valorada_a").empty();
            $("#respuestaAjax_srm").show();
            $("#respuestaAjax_srm").html(respuesta.mensaje);
            setTimeout(function () {
              $("#respuestaAjax_srm").hide();
            }, 10000);
            multa.MostrarProveidos(general.iso_area, multa.fechaPres);
            $("#formRegistrarProveido")[0].reset();
            $("#modalNuevoProveido").hide();
          }
        },
      });
    });
  
  
    /* Registro editar  de Proveido*/
    $(document).on("click", "#btnRegistrar_editar_Proveido", function () {
      DesCamposReg();
      let arrayProveidos = [];
      $("#especie_valorada_a_e tr").each(function() {
          let idTr = $(this).attr('id');
          let id_areap = $(this).attr('id_area');
          let numero = $(this).find('td:nth-child(1)').text().trim();
          let nombreEspecie = $(this).find('td:nth-child(2)').text().trim();
          let cantidad = $(this).find('input[name="cantidad_especie"]').val().trim();
          let monto = $(this).find('.monto_cantidad_total').text().trim();
          let montoTotal = $(this).find('.monto_cantidad_total').text().trim();
          let objetoProveido = {
              id: idTr,
              numero: numero,
              nombreEspecie: nombreEspecie,
              id_areap: id_areap,
              cantidad: cantidad,
              monto: monto,
              montoTotal: montoTotal
          };
          arrayProveidos.push(objetoProveido);
      });
      console.log("valores del cuadro", arrayProveidos);
      let formd = new FormData($("#formRegistrarProveido_e")[0]);
      formd.append("registrarProveido_editar", "true");
      formd.append("area_generar_e", general.iso_area);
      formd.append('items_e', JSON.stringify(arrayProveidos));
      console.log(formd);
      $.ajax({
        type: "POST",
        url: "ajax/proveidos.ajax.php",
        data: formd,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta.tipo === "advertencia") {
            $("#respuestaAjax_srm").show();
            $("#respuestaAjax_srm").html(respuesta.mensaje);
            setTimeout(function () {
              $("#respuestaAjax_srm").hide();
            }, 10000);
          }
          else{
            $("#respuestaAjax_srm").show();
            $("#respuestaAjax_srm").html(respuesta.mensaje);
            setTimeout(function () {
              $("#respuestaAjax_srm").hide();
            }, 10000);
            multa.MostrarProveidos(general.iso_area, multa.fechaPres);
            $("#formRegistrarProveido_e")[0].reset();
            $("#modalEditarProveido").hide();
          }
        },
      });
    });
  
    
  
  
    $(document).on("click", ".btnEditarProve", function () {
        multa.isEditing = true;
      let datosp = new FormData();
      editarmulta.numero_proveido_e = $(this).attr("numero_proveido_e");
      datosp.append("numero_proveido", editarmulta.numero_proveido_e);
      datosp.append("area", general.iso_area);
      datosp.append("editarEprovedio", "true");
  
      $.ajax({
          url: "ajax/proveidos.ajax.php",
          method: "POST",
          data: datosp,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (respuesta) {
              let primerElemento = respuesta[0];
              $("#nroProveido_e").val(primerElemento.Numero_Proveido);
              $("#dniProveido_e").val(primerElemento.DNI);
              $("#nombreProveido_e").val(primerElemento.Nombres);
              $("#obserProveido_e").val(primerElemento.Observaciones);
  
              // Limpiar el contenido del tbody antes de agregar nuevas filas
              $("#especie_valorada_a_e").empty();
              var total_valor_e = 0; // Inicializar como 0, no null
  
              // Recorrer la respuesta y agregar las filas al tbody
              respuesta.forEach((value) => {
                  total_valor_e += parseFloat(value.Valor_Total); // Asegúrate de sumar correctamente como número
              
                  let fila = `
                  <tr id='${value.Id_Especie_Valorada}' id_area=${value.Id_Area}>
                      <td class="text-center">${value.Numero_Proveido}</td>
                      <td>${value.Descripcion}</td>
                      <td>${value.Nombre_Area}</td>
                      <td style='width:40px;'><input style='width:40px;' type='text' class='cantidad_especie text-center'  name='cantidad_especie' value='${value.Cantidad}' oninput='actualizarMonto(this)'></td> `;
                      if (value.Editable ==="0") {
                      fila +=  `<td style='width:60px;' class='monto_cantidad'><center>${(value.Valor_Total / value.Cantidad).toFixed(2)}</center></td>`;
                      } else {
                      fila += `<td style='width:60px;' class='text-center'><input style='width:60px;' type='text' class='monto_cantidad text-center' value='${(value.Valor_Total / value.Cantidad).toFixed(2)}' oninput='actualizarMonto(this)'></td>`;
                      }
                      fila +=`<td class='monto_cantidad_total text-center'">${value.Valor_Total}</td>
                      <td><center><button type="button" class="btn btn-danger btn-xs btnEliminarEspcie_val" idespecie_eli="${value.Id_Proveido}"><i class="fas fa-trash-alt"></i></button></center></td>
                  </tr>`;
                  $("#especie_valorada_a_e").append(fila);
              });
              
              // Asignar el total calculado al campo de entrada
              $("#totalProveido_e").val(total_valor_e.toFixed(2));
              // Mostrar el modal después de que los datos se hayan insertado en la tabla
              $("#modalEditarProveido").modal("show");
  
              // Bloquear campos (si es necesario)
              bloCamposRegee();
          },
      });
  });
  
  
    $(document).on("click", "#salirRegistroModalEdit", function () {
      $("#modalEditarProveido").hide();
    });
    $(document).on("change", "#cantidaProveidoEdit", function () {
        editarmulta.cantidadProveidoC = $("#cantidaProveidoEdit").val();
        editarmulta.CalcularTotal();
      $("#totalProveidoEdit").val(editarmulta.valorProveidoC);
    });
    $(document).on("click", "#btnRegistrarProveidoEdit", function () {
      DesCamposRegee();
      let formd = new FormData($("#formRegistrarProveEdit")[0]);
      for (const pair of formd.entries()) {
        console.log(pair[0] + ", " + pair[1]);
      }
      $.ajax({
        type: "POST",
        url: "ajax/proveidos.ajax.php",
        data: formd,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          $(".resultados").html(respuesta);
          multa.MostrarProveidos(multa.idAreaC);
        },
      });
    });
    
    $(document).on("click", ".btnEliminarProve", function () {
        editarmulta.idProveidoC = $(this).attr("idProveido");
      $.ajax({
        type: "POST",
        url: "ajax/proveidos.ajax.php",
        data: {
          idProveEli: editarmulta.idProveidoC,
          eliminarProve: "eliminarProve",
        },
        success: function (respuesta) {
          $(".resultados").html(respuesta);
          multa.MostrarProveidos(multa.idAreaC, fechaPres);
        },
      });
    });
    $(document).on("click", "#buscarProveidoFecha", function () {
      let fecha = $("#fechaProveido").val();
      alert(fecha);
    });
  
    
  });
  function bloCamposRegee() {
    $("#nroProveidoEdit").prop("disabled", true);
    $("#nombreProveidoEdit").prop("disabled", false);
    $("#dniProveidoEdit").prop("disabled", true);
    $("#precioProveidoEdit").prop("disabled", true);
    $("#totalProveidoEdit").prop("disabled", true);
  }
  function DesCamposRegee() {
    $("#nroProveidoEdit").prop("disabled", false);
    $("#nombreProveidoEdit").prop("disabled", false);
    $("#dniProveidoEdit").prop("disabled", false);
    $("#precioProveidoEdit").prop("disabled", false);
    $("#totalProveidoEdit").prop("disabled", false);
  }
  function bloCamposReg() {
    $("#nroProveido").prop("disabled", true);
    //$("#precioProveido").prop("disabled", true);
    $("#totalProveido").prop("disabled", true);
  }
  function DesCamposReg() {
    $("#nroProveido").prop("disabled", false);
    $("#precioProveido").prop("disabled", false);
    $("#totalProveido").prop("disabled", false);
  }
  function obtenerFechaActual() {
    const fecha = new Date();
    const anio = fecha.getFullYear();
    const mes = String(fecha.getMonth() + 1).padStart(2, "0");
    const dia = String(fecha.getDate()).padStart(2, "0");
    return `${anio}-${mes}-${dia}`;
  }
  
  $(document).on("click", ".btnImprimirProve", function () {
    var numero_proveido_pdf = this.getAttribute('numero_proveido_pdf');
    console.log("valor del id proveido:"+numero_proveido_pdf);
    multa.generarpdfproveido(numero_proveido_pdf);
    $("#GenerarProveido").modal("show");
  });
  
  $("#MostrarmodalNuevoProveido").click(function () {
    multa.isEditing = false;
    console.log("area", general.iso_area);
    $.ajax({
        type: "POST",
        url: "ajax/proveidos.ajax.php",
        dataType: "json",
        data: {
            idAreaPro: general.iso_area,
            traerinfoProve: "traerinfoProve",
        },
        success: function (respuesta) {
            console.log(respuesta); // Para verificar lo que estás recibiendo
            multa.numProveidoC = respuesta.Numero_Proveido; // Verifica el nombre de la clave
            $("#nroProveido").val(multa.numProveidoC);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición AJAX:", textStatus, errorThrown);
        }
    });
    $("#ModalNuevoProveido").modal("show");
  });
  
  $(".modalMostrar_EspecieValorada_b").click(function () {
    $("#modalAgregarEspecie_valorada").modal("show");
  });
  
  $(".btnModalNuevoProveido").on("click", function () {
    bloCamposReg();
   
    var fila = $(this).closest('tr');
    var idarea = $(this).attr('idAreap');
    var codigo = $(this).attr('idespecie');
    var editable_ = $(this).attr('editable');
    var Nombre_Especie = fila.find('td:nth-child(2)').text().trim();
    var Area = fila.find('td:nth-child(3)').text().trim();
    var Monto = parseFloat(fila.find('td:nth-child(4)').text().trim());
    multa.Monto_ = Monto;
    var Numero = fila.find('td:first-child').text().trim();
  
    if (!multa.elementosAgregados.includes(codigo)) {
        multa.elementosAgregados.push(codigo);
  
      var html =
        '<tr id="' + codigo + '" id_area="' + idarea + '">' +
        "<td><center>" + Numero + "</center></td>" +
        "<td><center>" + Nombre_Especie + "</center></td>" +
        "<td><center>" + Area + "</center></td>" +
        "<td style='width:40px;'><input style='width:40px;' type='text' class='cantidad_especie text-center'  name='cantidad_especie' value='1' oninput='actualizarMonto(this)'></td>";
  
      if (editable_ === "0") {
        html += "<td style='width:40px;' class='monto_cantidad text-center'><center>" + Monto + "</center></td>";
      } else {
        html += "<td style='width:40px;' class='text-center'><input style='width:60px;' type='text' class='monto_cantidad text-center' value='" + Monto + "' oninput='actualizarMonto(this)'></td>";
      }
      html += "<td><center class='monto_cantidad_total'>" + (1 * Monto).toFixed(2) + "</center></td>" +
        '<td><center><button type="button" class="btn btn-danger btn-xs btnEliminarEspcie_val" idespecie_eli="' + codigo + '"><i class="fas fa-trash-alt"></i></button></center></td>' +
        "</tr>";
  
        if (multa.isEditing) {
          // Si estás en modo de edición, agrega al tbody de edición
          $("#especie_valorada_a_e").append(html);
      } else {
          // Si estás en modo de nuevo registro, agrega al tbody de nuevo
          $("#especie_valorada_a").append(html);
      }
  
    calcularTotalProveido();
      console.log(multa.elementosAgregados);
    } else {
      alert("Este elemento ya ha sido agregado.");
    }
  
    $("#modalAgregarEspecie_valorada").modal("hide");
  });
  
  function actualizarMonto(elemento) {
    var fila = $(elemento).closest('tr');
    var cantidad = parseFloat(fila.find('.cantidad_especie').val()) || 0; // Leer la cantidad desde el campo de entrada
    var Monto = parseFloat(fila.find('.monto_cantidad').val()) || parseFloat(fila.find('.monto_cantidad').text()) || 0; // Leer el monto desde el campo de entrada o texto
    var nuevoMonto = cantidad * Monto;
    fila.find('.monto_cantidad_total').text(nuevoMonto.toFixed(2));
    calcularTotalProveido();
  }
  
  function calcularTotalProveido() {
    var total = 0;
  
    // Iterar sobre cada fila que contiene un total por cantidad
    if(multa.isEditing){
    $("#especie_valorada_a_e tr").each(function() {
      var montoTotal = parseFloat($(this).find('.monto_cantidad_total').text()) || 0;
      total += montoTotal;
    });
     // Actualizar el campo de total
     $("#totalProveido_e").val(total.toFixed(2));
   }
   else{
    $("#especie_valorada_a tr").each(function() {
      var montoTotal = parseFloat($(this).find('.monto_cantidad_total').text()) || 0;
      total += montoTotal;
    });
     // Actualizar el campo de total
     $("#totalProveido").val(total.toFixed(2));
   }
  }
  
  
  $(document).on("click", ".btnEliminarEspcie_val", function () {
    var fila = $(this).closest("tr");
    var codigo = $(this).attr('idespecie_eli');
    fila.remove();
  
    var index = multa.elementosAgregados.indexOf(codigo);
    if (index > -1) {
        multa.elementosAgregados.splice(index, 1);
    }
    calcularTotalProveido();
    console.log(multa.elementosAgregados);
  });
  
  
  $(document).on("click", ".bi-eye", function() {
    // Open the modal when the eye icon is clicked
    $('#especie_valorada_estado_caja').html('');
    var numero_proveido = $(this).attr('n_proveido');
    multa.mostrar_detalle_proveido(numero_proveido);
    $("#ModalEstadoPagoProveido").modal("show");
  });
  
  $(document).on("click", ".cerrar_proveido", function() {
    multa.elementosAgregados=[];
  });