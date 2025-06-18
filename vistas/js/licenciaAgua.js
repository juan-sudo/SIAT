class LicenciaAgua {
  constructor() {
    this.idLicenciaAguaC = null;
    this.idContribuyenteC = localStorage.getItem("idContribuyenteC") || null;
    this.idCatastroC = null; //cod
    this.codCatastroC = null; //id
    this.ubiLicenciaC = null;
    this.nombresLicenciaC = null;
    this.dniLicenciaC = null;
    this.nroReciboPago = null;
    this.estadoPago = null;
    this.idproveidor = null;
    this.numproveidor = null;
    this.anioagua = null;
    //datos para calcular el estado de cuenta
    this.dni = null;
    this.nombres = null;
    this.monto = null;
    this.categoria = null;
    this.fecha_expedicion_c = null;
    this.descuento_servicio = null;
    this.descuento_sindicato = null;
    this.numero_resolucion_sindicato = null;
    this.numero_pago_servicio = null;

    //this.descuento = null;
  }

  //CARGAR PARA EDITAR BARRA DE PROGRESO DE AGUA
  editarCarpetaProgresAgua(idContribuyente){

    console.log("aqui ya vas -------------", idContribuyente)

    
    let datos = new FormData();
    datos.append("idContribuyente", idContribuyente);

    datos.append("barraProgreso", "barraProgreso");
    
    $.ajax({
      url: "ajax/licenciaagua.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {

        console.log("paar cargar en la vista ",respuesta);
        // //(respuesta)
        $("#estado_progreso").val(respuesta["Estado_progreso"]).change(); 

        //  $("#codigo_carpeta").val(respuesta["Codigo_Carpeta"]); 

          // Actualizar la barra de progreso en base al valor recibido
        actualizarBarraDeProgreso(respuesta["Estado_progreso"]);

        
      },
    });
  }

  loadContribuyenteAguaC(page,searchClass) {
    let perfilOculto_c = $("#perfilOculto_c").val();
    let searchContribuyente = $("." + searchClass).val();
        let parametros = {
          action: "ajax",
          page: page,
          searchContribuyente: searchContribuyente,
          tipo: searchClass,
          dpLicenciaAgua: "dpLicenciaAgua",
          perfilOculto_c: perfilOculto_c,
        };
        $.ajax({
          url: "vistas/tables/dataTables.php",
          data: parametros,
          beforeSend: function() {
            $(".body-contribuyente").html(loadingMessage);
          },
          success: function (data) {
            $(".body-contribuyente").html(data);
          },
          error: function() {
            $(".body-contribuyente").html(errordata);
          }
        });
      
    
  }

  pasar_parametro_getagua(id) {
    this.idContribuyenteC = id;
    localStorage.setItem("idContribuyenteC", id);
    window.location = "index.php?ruta=listapredioagua&id=" + id;
  }

  
  MostrarLicencia() {
    const cuerpoTabla = document.getElementById("listaLicenciasAgua");
    const filas = cuerpoTabla.getElementsByTagName("tr");
    console.log("id_del contribuyete agua" +this.idContribuyenteC)
    let id=this.idContribuyenteC
    while (filas.length > 0) {
      cuerpoTabla.deleteRow(0); // Elimina la primera fila de la tabla
    }
    $("#listaLicenciasAgua").html("");
    $.ajax({
      type: "POST",
      url: "ajax/licenciaagua.ajax.php",
      data: {
        id_contribuyente_agua: id,
      },
      success: function (respuesta) {
        //console.log(respuesta);
        console.log("valores de retorno"+respuesta);
        if (respuesta === "vacio") {
          let fila = cuerpoTabla.insertRow();
          fila.innerHTML = `<td class="text-center" colspan='10' style='text-align:center;'>No registra Licencia de agua</td>`;
        } else {
          //console.log(respuesta);
          let contador = 1;
          respuesta = JSON.parse(respuesta);
          respuesta.forEach((value) => {
            let fila = cuerpoTabla.insertRow();
            fila.innerHTML = `
        <td style="display: none;">${value.Id_Licencia_Agua}</td>
				<td class="text-center">${contador}</td>
				<td class="text-center">${value.tipo_via} ${value.nombre_calle} N° ${value.Numero_Ubicacion} Mz.${value.numManzana} Lt.${value.Lote} Luz.${value.Luz} Cdr.${value.cuadra} ${value.habilitacion}- ${value.zona}</td>
				<td class="text-center">${value.Numero_Licencia}</td>
        	<td class="text-center">${value. 	Fecha_Expedicion }</td>
        <td class="text-center">
						<img src="./vistas/img/iconos/deuda.png" class="t-icon-tbl-imprimir_agua btnEstadoCuentaAgua" idLicenciaAgua="${value.Id_Licencia_Agua}"  title="Estado Cuenta Agua">
            <img src="./vistas/img/iconos/pagos_.png" class="t-icon-tbl-imprimir_agua btnEstadoCuentaAgua_pagados" idLicenciaAgua="${value.Id_Licencia_Agua}"  title="Estado Cuenta Agua Pagados">
            <img src="./vistas/img/iconos/editar.png" class="t-icon-tbl-imprimir_agua btnEditarLic" idLicencia="${value.Id_Licencia_Agua}" title="Editar Licencia">
           
            <!-- <img src="./vistas/img/iconos/pdf.png" class="t-icon-tbl-imprimir_agua btnImprimirLic" idLicencia="${value.Id_Licencia_Agua}" title="Imprimir Licencia"> -->
            
             <img src="./vistas/img/iconos/pdf.png" class="t-icon-tbl-imprimir_agua btnEstadoCuentaAguaMeses" idLicencia="${value.Id_Licencia_Agua}" title="Imprimir Licencia">
            
            <img src="./vistas/img/iconos/delete.png" class="t-icon-tbl-imprimir_agua btnEliminarLic" idLicencia="${value.Id_Licencia_Agua}" title="Eliminar Licencia">
               
				</td>`;
        contador ++;
          });
        }
      },
    });
  }


//CALCUALR ESTADO DE CUANTA AGUA
  funcioncalcularestdocuentaagua(recalculo) {
    var selectElement = document.getElementById("selectnum_copiar");
    nuevalicenciaAgua.anioagua =
      selectElement.options[selectElement.selectedIndex].text;
    console.log("año seleccionado:" + nuevalicenciaAgua.anioagua);
    let datos = new FormData();
    datos.append("dni", nuevalicenciaAgua.dni);
    datos.append("nombres", nuevalicenciaAgua.nombres);
  
    datos.append("categoria", nuevalicenciaAgua.categoria);
    datos.append("fecha_expedicion", nuevalicenciaAgua.fecha_expedicion_c);
    datos.append("anio", nuevalicenciaAgua.anioagua);
    datos.append("id_contribuyente", nuevalicenciaAgua.idContribuyenteC);
    datos.append("id_licencia", editalicenciaAgua.idLicenciaAguaC);


    //datos.append("monto", nuevalicenciaAgua.monto);

     if(nuevalicenciaAgua.descuento_sindicato>0.00){
      datos.append("descuento", nuevalicenciaAgua.descuento_sindicato);

     }else if(nuevalicenciaAgua.descuento_servicio>0.00){
      datos.append("descuento", nuevalicenciaAgua.descuento_servicio);

     }else if((nuevalicenciaAgua.descuento_servicio == null || nuevalicenciaAgua.descuento_servicio == undefined || nuevalicenciaAgua.descuento_servicio == 0.00) && (nuevalicenciaAgua.descuento_sindicato == null || nuevalicenciaAgua.descuento_sindicato == undefined || nuevalicenciaAgua.descuento_sindicato == 0.00)){
      datos.append("descuento", 0.00);

     }
     

   



    //  datos.append("montoAplicarSindicato", montoAplicarSindicato);
      datos.append("monto", nuevalicenciaAgua.monto);


    //}
    

    datos.append("recalcular", recalculo);
    datos.append("calcular_agua", "calcular_agua");
    //imprimiendo los valores enviados
    for (const [clave, valor] of datos.entries()) {
      console.log(`${clave}: ${valor}`);
    }
    $.ajax({
      url: "ajax/licenciaagua.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        if (respuesta.tipo === "correcto") {
          $("#modalGenerarAgua_si_no").modal("hide");
          $("#modalGenerarRecalculoAgua_si_no").modal("hide");
          $("#respuestaAjax_srm").show();
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 5000);
        } else if (respuesta.tipo === "advertencia") {
          $("#modalGenerarAgua_si_no").modal("hide");
          $("#modalGenerarRecalculoAgua_si_no").modal("show");
          $("#respuestaAjax_srm").show();
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 5000);
        } else {
          $("#respuestaAjax_srm").show();
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
          }, 4000);
        }
      },
    });
  }

  
  guardar_editar_progreso_agua(datosFormulario){
   
  console.log(datosFormulario);

    $.ajax({
      type: 'POST',
      url: 'ajax/licenciaagua.ajax.php', // Cambia esto por la URL a la que envías los datos
      data: datosFormulario, // Serializa los datos del formulario
      success: function(respuesta) {
        if (respuesta.tipo === "correcto") {
          $("#modalEditarcontribuyente").modal("hide");
          $("#respuestaAjax_srm").show(); // Mostrar el elemento #error antes de establecer el mensaje
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          
          setTimeout(function () {
            $("#respuestaAjax_srm").hide();
            window.location.href = window.location.href; // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
            // Recargar la página manteniendo los parámetros actuales
          }, 1000); // 3000 milisegundos = 3 segundos (ajusta según tus preferencias)
        } else {
          $("#modalEditarcontribuyente").modal("hide");
          $("#respuestaAjax_srm").show(); // Mostrar el elemento #error antes de establecer el mensaje
          $("#respuestaAjax_srm").html(respuesta.mensaje);
          setTimeout(function () {
            $("#respuestaAjax_srm").hide(); // Oculta el mensaje después de un tiempo (por ejemplo, 3 segundos)
            // Recargar la página manteniendo los parámetros actuales
          }, 3000); // 3000 milisegundos = 3 segundos (ajusta según tus preferencias)
        }
      }
    });
   }
}

const nuevalicenciaAgua = new LicenciaAgua();
const editalicenciaAgua = new LicenciaAgua();
const editarBarraProgreso = new LicenciaAgua();
//const aguaLicencia = new LicenciaAgua();
//====================listapredioagua.php======================
$(document).ready(function () {
  
  nuevalicenciaAgua.MostrarLicencia();



  let filaSelect = false;
  let filaLicence = false;
  let tabla = document.getElementById("tablalistaprediosAgua");

  pintarFilaTabla(tabla);

  $(document).on("click", ".filaEspeciev", function () {
    $(this)
      .addClass("filaSeleccionada")
      .siblings()
      .removeClass("filaSeleccionada");
    filaSelect = true;
  });
 
    
 
  $(document).on("click", "#btnAbrirModalNuevaLicencia", function () {
   // if (filaSelect) {
    $('.editar_licencia').html('');
    let html = `
    <table class="table-container">
        <thead>
            <tr>
                <th class="text-center">Nombre Via</th>
                <th class="text-center">Manzana</th>
                <th class="text-center">Cuadra</th>
                <th class="text-center">Zona</th>
                <th class="text-center">Habilitacion</th>
                <th class="text-center">Arancel</th>
                <th class="text-center">Cod. Via</th>
            </tr>
        </thead>
        <tbody id="itemsRC_editar_agua">
        </tbody>
    </table><div class="boton-propietario">
                    <button type="button" class="btn btn-secundary btn-1" data-toggle="modal" data-target="#modalViascalles">Dirección Fiscal</button>
                  </div>`;
    
    $('.registrar_licencia').html(html); // Puedes cambiar el selector según lo necesites

      $("#modalAgregarLicencia").modal("show");
      $("#otrosPropietarios").hide();
      $("#datosLicencia").hide();
      $.ajax({
        method: "POST",
        url: "ajax/licenciaagua.ajax.php",
        dataType: "json",
        data: {
          datanl: true,
        },
        success: function (respuesta) {
          console.log(respuesta);
          let numLicencia;
          if (respuesta) {
            numLicencia = parseInt(respuesta.Numero_Licencia) + 1;
            $("#numLicenciaAd").val(numLicencia);
          } else {
            numLicencia = 1;
            $("#numLicenciaAd").val(numLicencia);
          }
        },
      });
      bloCamposRegAgu();
   // } else {
    //  alert("Debe Seleccionar un Predio");
   // }
  });

  $(document).on("click", "#salirRegistroLicenAguaModal", function () {
    $("#formRegistrarLicenciaAgua")[0].reset();
    $("#modalAgregarLicencia").modal("hide");
  });
  $(document).on("change", "#propietarioLic", function () {
    if ($("#propietarioLic").val() === "OTROS") {
      $("#otrosPropietarios").show(1000);
      nuevalicenciaAgua.nombresLicenciaC =
        $("#nombOtros").val() +
        $("#apePatOtros").val() +
        $("#apeMatOtros").val();
    } else {
      $("#otrosPropietarios").hide(500);
    }
  });
  $(document).on("change", "#licAguaDesague", function () {
    if (
      $("#licAguaDesague").val() === "1" ||
      $("#licAguaDesague").val() === "2"
    ) {
      $("#datosLicencia").show(1000);
    } else {
      $("#datosLicencia").hide();
    }
  });
  $(document).on("click", "#btnRegistrarLicenAgua", function () {
    DesbloCamposRegAgu();
    nuevalicenciaAgua.estadoPago="P"; /*Eliminar cuando termine de migrar las licencias de Agua*/
    if (nuevalicenciaAgua.estadoPago === "P") {
        nuevalicenciaAgua.nombresLicenciaC = $(
          "#propietarioLic option:selected"
        ).text();
        nuevalicenciaAgua.dniLicenciaC = $(
          "#propietarioLic option:selected"
        ).attr("dniatri");
      
      let formd = new FormData($("#formRegistrarLicenciaAgua")[0]);
      formd.append("registrarLicenciaAgua", "true");
      formd.append("nombresLicenia", nuevalicenciaAgua.nombresLicenciaC);
      formd.append("numDniLicencia", nuevalicenciaAgua.dniLicenciaC);
      for (const pair of formd.entries()) {
        console.log(pair[0] + ", " + pair[1]);
      }
     $.ajax({
        type: "POST",
        url: "ajax/licenciaagua.ajax.php",
        data: formd,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          $(".resultados").html(respuesta);
          $("#formRegistrarLicenciaAgua")[0].reset();
          nuevalicenciaAgua.MostrarLicencia();
        },
      });
      $("#modalAgregarLicencia").modal("hide");
    } else {
      alert("Recibo No Valido");
    }
  });
  $(document).on("click", ".btnEditarLic", function () {
    $('.registrar_licencia').html(''); 
    let html = `
    <table class="table-container">
        <thead>
            <tr>
                <th class="text-center">Nombre Via</th>
                <th class="text-center">Manzana</th>
                <th class="text-center">Cuadra</th>
                <th class="text-center">Zona</th>
                <th class="text-center">Habilitacion</th>
                <th class="text-center">Arancel</th>
                <th class="text-center">Cod. Via</th>
            </tr>
        </thead>
        <tbody id="itemsRC_editar_agua">
        </tbody>
    </table><div class="boton-propietario">
                    <button type="button" class="btn btn-secundary btn-1" data-toggle="modal" data-target="#modalViascalles">Dirección Fiscal</button>
                  </div>`;
    
    $('.editar_licencia').html(html); // Puedes cambiar el selector según lo necesites

    editalicenciaAgua.idLicenciaAguaC = $(this).attr("idLicencia");
    bloCamposEditLic();
    $("#modalEditarLicencia").modal("show");
    let datosLicencia = new FormData();
    datosLicencia.append("idLicencia", editalicenciaAgua.idLicenciaAguaC);
    datosLicencia.append("editarLicAgua", "true");
    $.ajax({
      url: "ajax/licenciaagua.ajax.php",
      method: "POST",
      data: datosLicencia,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {

        //console.log("para editar licencia", respuesta);
        // console.log(respuesta);
        let elemento = respuesta[0];
        $("#idLicenciEdit").val(elemento.Id_Licencia_Agua);
        $("#numLicenciaAdEdit").val(elemento.Numero_Licencia);
        $("#numDniOtrosEdit").val(elemento.DNI_Licencia);
        $("#numExpedienteLicEdit").val(elemento.Numero_Expediente);
        $("#fechaExpedienteEdit").val(elemento.Fecha_Expediente);
        $("#numReciboCajaEdit").val(elemento.Numero_Recibo);
        $("#numProvedioEdit").val(elemento.Numero_Proveido);
        $("#labelUbicacionLicEdit").text(nuevalicenciaAgua.ubiLicenciaC);
        $("#labelCatastroLicEdit").text(nuevalicenciaAgua.idCatastroC);
        $("#propietarioLicEdit").val(elemento.Nombres_Licencia);
        $("#tipoLicenciaAdEdit").val(elemento.Permanencia);
        $("#tuberiaAdEdit").val(elemento.PVC_Diametro);
        $("#categoriaLicAdEdit").val(elemento.Id_Categoria_Agua);
        $("#extSuministriAdEdit").val(elemento.Extension_Suministro);

        $("#edit_nroUbicacion").val(elemento.Numero_Ubicacion );
        $("#edit_nroLote").val(elemento.Lote);
        $("#edit_nroLuz").val(elemento.Luz);
        $("#edit_ref").val(elemento.Referencia);

      
       // Asignar valor y manejar el caso null
        $("#descuentoSindicatoEdit").val(elemento.Descuento_sindicato == null || elemento.Descuento_sindicato === "" ? "" : elemento.Descuento_sindicato);
        $("#descuendoServicioEdit").val(elemento.Descuento_pago_servicio == null || elemento.Descuento_pago_servicio === "" ? "" : elemento.Descuento_pago_servicio);



        $("#resoSinLicAdEdit").val(elemento.Numero_Resolucion_Sindicato);
        $("#resoPagoLicAdEdit").val(elemento.Numero_Pago_Servicio);

       



        let html = ` <input type="hidden" id="idvia" name="idvia" value="${elemento.Id_Ubica_Vias_Urbano}">
        <tr>
          <td class="text-center">${elemento.tipo_via} ${elemento.nombre_calle}</td>
          <td class="text-center">${elemento.numManzana}</td>
          <td class="text-center">${elemento.cuadra}</td>
          <td class="text-center">${elemento.zona}</td>
          <td class="text-center">${elemento.habilitacion}</td>
          <td class="text-center">${elemento.importe}</td>
          <td class="text-center">${elemento.Id_Ubica_Vias_Urbano}</td>
        </tr>
      `;

      $("#itemsRC_editar_agua").html(html);

        let prueba = elemento.Inspeccion;
        let rotura = elemento.Rotura_vereda;
        if (prueba === 1) {
          $("input[name='pruebaCheckboxEdit'][value='1']").prop(
            "checked",
            true
          );
        } else {
          $("input[name='pruebaCheckboxEdit'][value='0']").prop(
            "checked",
            true
          );
        }
        if (rotura === 1) {
          $("input[name='roturaCheckboxEdit'][value='1']").prop(
            "checked",
            true
          );
        } else {
          $("input[name='roturaCheckboxEdit'][value='0']").prop(
            "checked",
            true
          );
        }
        $("#fechaExpedLicEdit").val(elemento.Fecha_Expedicion);
        $("#obsLicAdEdit").val(elemento.Observacion);
      },
    });
  });
  $(document).on("click", "#salirRegistroLicenAguaEdit", function () {
    $("#modalEditarLicencia").modal("hide");
  });

  

  $(document).on("click", "#btnRegistrarLicenAguaEdit", function () {

    DesCamposRegee();

    let formd = new FormData($("#formRegistrarLicenciaAguaEdit")[0]);

    formd.append("idLicenciEdit", editalicenciaAgua.idLicenciaAguaC);

 

    for (const pair of formd.entries()) {

		   console.log("estas son los valores que van---", pair[0] + ", " + pair[1]);
		}
    $.ajax({
      type: "POST",
      url: "ajax/licenciaagua.ajax.php",
      data: formd,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        $(".resultados").html(respuesta);
        nuevalicenciaAgua.MostrarLicencia();
        $("#modalEditarLicencia").modal("hide");
      },
    });
  });


  
  $(document).on("click", ".btnEliminarLic", function () {
    // Preguntar al usuario si realmente quiere eliminar la licencia
    if (confirm("¿Estás seguro de que quieres eliminar Licencia?")) {
      nuevalicenciaAgua.idLicenciaAguaC = $(this).attr("idLicencia");
      $.ajax({
        type: "POST",
        url: "ajax/licenciaagua.ajax.php",
        data: {
          idLicenceAgua: nuevalicenciaAgua.idLicenciaAguaC,
          delete_liecence: "delete_liecence",
        },
        success: function (respuesta) {
          respuesta = JSON.parse(respuesta);
          console.log(respuesta);
          if (respuesta.tipo === "error") {
            $("#errorLicence").show();
            $("#errorLicence").html(respuesta.mensaje);
            setTimeout(function () {
              $("#errorLicence").hide();
            }, 4000);
          } else {
            $("#respuestaAjax_correcto").html(respuesta.mensaje);
            $("#respuestaAjax_correcto").show();
            setTimeout(function () {
              $("#respuestaAjax_correcto").hide();
            }, 3000);
            nuevalicenciaAgua.MostrarLicencia();
          }
        },
        error: function () {
          console.error("Error en la solicitud AJAX");
        },
      });
    }
  });
  $(document).on("click", "#listaLicenciasAgua tr", function () {
    var filas = $("#listaLicenciasAgua tr");
    filas.removeClass("filaSeleccionada");
    $(this).addClass("filaSeleccionada");
    editalicenciaAgua.idLicenciaAguaC = $(this).find("td:first").text();
    filaLicence = true;
  });

  $(document).on("click", "#btnCambioRazonZocial", function () {
    if (filaLicence) {
      $("#modalTranferirLicence").modal("show");
      $("#otrosPropietariost").hide();
      let datosLicenciat = new FormData();
      datosLicenciat.append("idLicencia", editalicenciaAgua.idLicenciaAguaC);
      datosLicenciat.append("transferirLicencia", "true");
      $.ajax({
        url: "ajax/licenciaagua.ajax.php",
        method: "POST",
        data: datosLicenciat,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
          console.log(respuesta);
          let elemento = respuesta[0];
          $("#numLicenciaAdEditt").val(elemento.Numero_Licencia);
          $("#idlicencet").val(elemento.Id_Licencia_Agua);
          $("#numDniOtrosEditt").val(elemento.DNI_Licencia);
          $("#propietarioLicEditt").val(elemento.Nombres_Licencia);
          $("#obsLicAdEditt").val(elemento.Observacion);
        },
      });
      bloCampost();
    } else {
      alert("Elija una Licencia");
    }
  });
  $(document).on("change", "#propietarioLictt", function () {
    if ($("#propietarioLictt").val() === "OTROS") {
      $("#otrosPropietariost").show(1000);
      editalicenciaAgua.nombresLicenciaC =
        $("#nombOtrost").val() +
        $("#apePatOtrost").val() +
        $("#apeMatOtrost").val();
    } else {
      $("#otrosPropietariost").hide(500);
    }
  });
  $(document).on("click", "#salirTransferenLicenAguaEdit", function () {
    $("#formTransferirLicenciaAguaEdit")[0].reset();
    $("#modalTranferirLicence").modal("hide");
  });

  $(document).on("click", "#btnTranferenLicenAguaEdit", function () {
    var formd = new FormData();
    var tipo_escritura = $("#obsLicAdEditt").val(); 
    formd.append("idlicencia", editalicenciaAgua.idLicenciaAguaC);
    formd.append("idcontribuyente_nuevo", vias.codigo_nuevo.trim());
    formd.append("transferir_licencia", "transferir_licencia");
    formd.append("obs",tipo_escritura);
    console.log(formd);
    // falta trabajar en el ajax controlador y en el modelo
    $.ajax({
      type: "POST",
      url: "ajax/licenciaagua.ajax.php",
      data: formd,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        if (respuesta ==="OK") {
          general.mostrarAlerta("success", "Transferencia de Licencia", "Los datos se enviaron correctamente", { limpiarFormulario: "" });
          nuevalicenciaAgua.MostrarLicencia();
          $('#modalTranferirLicence').modal('hide')

        } else {
          general.mostrarAlerta("error", "Error", "Hay un error,comunicate con el Administrador.");
      }
      },
    });
  });

  $(document).on("click", "#buscarReciboPago", function () {
    nuevalicenciaAgua.nroReciboPago = $("#numReciboCaja").val();
    $.ajax({
      type: "POST",
      url: "ajax/licenciaagua.ajax.php",
      dataType: "json",
      data: {
      datainput: nuevalicenciaAgua.nroReciboPago,
      },
      success: function (respuesta) {
        console.log(respuesta);
        if (respuesta[1] === "OK") {
          nuevalicenciaAgua.numproveidor = respuesta[0]["Numero_Proveido"];
          nuevalicenciaAgua.idproveidor = respuesta[0]["Id_Proveido"];
          nuevalicenciaAgua.estadoPago = respuesta[0]["Estado"];
          $("#idproveidor").val(nuevalicenciaAgua.idproveidor);
          $("#numProvedio").val(nuevalicenciaAgua.numproveidor);
          $("#respuestaRecibo").text("Recibo Valido");
        } else {
          $("#respuestaRecibo").text("No Valido!!");
        }
      },
    });
  });

  

  //mostrando datos para procesar el esto de cuenta agua
  $(document).on("click", "#btnProcesarDeuda", function () {
    if (filaLicence) {
      $("#modalEstadoCuentaAgua").modal("show");
      $("#otrosPropietariost").hide();
      let datosLicenciat = new FormData();
      datosLicenciat.append("idLicencia", editalicenciaAgua.idLicenciaAguaC);
      datosLicenciat.append("transferirLicencia", "transferirLicencia");
      console.log(datosLicenciat);
      $.ajax({
        url: "ajax/licenciaagua.ajax.php",
        method: "POST",
        data: datosLicenciat,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
          console.log(respuesta);
          let elemento = respuesta[0];
          $("#idLicenciEditCalcular").val(elemento.Id_Licencia_Agua);
          $("#numLicenciaAdEditCalcular").val(elemento.Numero_Licencia);
          $("#numDniOtrosEditCalcular").val(elemento.DNI_Licencia);
          $("#labelUbicacionLicEditCalcular").text(
            nuevalicenciaAgua.ubiLicenciaC
          );
          $("#labelCatastroLicEditCalcular").text(
            nuevalicenciaAgua.idCatastroC
          );
          $("#propietarioLicEditCalcular").val(elemento.Nombres_Licencia);
          $("#tipoLicenciaAdEditCalcular").val(elemento.Permanencia);
          $("#categoriaLicAdEditCalcular").val(elemento.Id_Categoria_Agua);
          $("#fechaExpedLicEditCalcular").html(elemento.Fecha_Expedicion);
          $("#MontoLicEditCalcular").html(elemento.Monto);

         
          // Asignar valor de 0.00 si es null
          $("#descuentoSindicatoCalcular").html(elemento.Descuento_sindicato == null ? 0.00 : elemento.Descuento_sindicato);
          $("#descuentoServicioEditCalcular").html(elemento.Descuento_pago_servicio == null ? 0.00 : elemento.Descuento_pago_servicio);

          

          $("#labelUbicacionLicEditCalcular").html(
            elemento.tipo_via + " " +
            elemento.nombre_calle + " " +
            elemento.Numero_Ubicacion + " " +
            "Mz. " + elemento.numManzana + " " +
            "Lt. " + elemento.Lote + " " +
            "Luz " + elemento.Luz + " " +
            "Cdr " + elemento.cuadra + "  " +
            "" + elemento.habilitacion + "-" +
            "" + elemento.zona
        );

          //capturando datos para calcular el estado de cuenta agua
          nuevalicenciaAgua.dni = elemento.DNI_Licencia;
          nuevalicenciaAgua.nombres = elemento.Nombres_Licencia;
          nuevalicenciaAgua.monto = elemento.Monto;
          nuevalicenciaAgua.categoria = elemento.Id_Categoria_Agua;
          nuevalicenciaAgua.fecha_expedicion_c = elemento.Fecha_Expedicion;

          //DESCUENTO PARA CALCULAR
          nuevalicenciaAgua.descuento_servicio = elemento.Descuento_pago_servicio;
          nuevalicenciaAgua.descuento_sindicato = elemento.Descuento_sindicato;
          nuevalicenciaAgua.numero_pago_servicio = elemento.Numero_Pago_Servicio;
          nuevalicenciaAgua.numero_resolucion_sindicato = elemento.Numero_Resolucion_Sindicato;
          


          //fecha_espedicion=elemento.Fecha_Expedicion;
          //capturando el año de donde se va calcular el estado de cuenta
          let datosLicAnio = new FormData();
          var fecha = new Date(elemento.Fecha_Expedicion);
          var anio = fecha.getFullYear();
          var mes = fecha.getMonth() + 1; // El método getMonth() devuelve un número de 0 a 11, por lo que sumamos 1 para obtener el mes actual
          var dia = fecha.getDate();
          console.log(anio + "--" + mes + "--" + dia);
          datosLicAnio.append("anio_agua", anio);
          datosLicAnio.append("mes_agua", mes);
          datosLicAnio.append("dia_agua", dia);
          datosLicAnio.append("ListaAnioCondicion", "ListaAnioCondicion");
          console.log("anio de expedicion:" + anio);
          $.ajax({
            url: "ajax/licenciaagua.ajax.php",
            method: "POST",
            data: datosLicAnio,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta_anio) {
              $("#anio_agua").html(respuesta_anio);
            },
          });
        },
      });

      bloCampost();
    } else {
      alert("Elija una Licencia");
    }
  });

  //enviando datos para el calculo de estado de cuenta agua
  $(document).on("click", ".generardeudaagua", function () {
    var recalculo = "no";
    nuevalicenciaAgua.funcioncalcularestdocuentaagua(recalculo);
  });


  $(document).on("click", ".generarRecalculodeudaagua", function () {
    var recalculo = "si";
    nuevalicenciaAgua.funcioncalcularestdocuentaagua(recalculo);
  });

  $(document).on("click", "#salirEstadoCuentaAgua", function () {
    $("#formTransferirLicenciaAguaEdit")[0].reset();
    $("#modalEstadoCuentaAgua").modal("hide");
  });

  //Registrar estado de cuenta agua
  $(document).on("click", "#btnRegistrarEstadoCuentAgua", function () {
    $("#modalGenerarAgua_si_no").modal("show");
  });
});
//====================licencia-agua.php======================
$(document).on("click", "#pagina_licencia_agua", function () {
  let arrayIds = $(this).attr("idContribuyente_agua");
  nuevalicenciaAgua.pasar_parametro_getagua(arrayIds);
});

function loadContribuyenteAgua(page, searchClass) {
  if (event.keyCode === 13) {
    nuevalicenciaAgua.loadContribuyenteAguaC(page,searchClass);
    event.preventDefault();
  }
}

function loadContribuyenteAgua_consulta_deuda(page) {
  nuevalicenciaAgua.loadContribuyenteAguaC_consulta(page, 1);
}
function pintarFilaTabla(tabla) {
  let tbody = tabla.querySelector("tbody");
  let filas = tbody.getElementsByTagName("tr");
  for (let i = 0; i < filas.length; i++) {
    filas[i].addEventListener("click", function () {
      let filasTbody = tbody.getElementsByTagName("tr");
      for (let j = 0; j < filasTbody.length; j++) {
        filasTbody[j].style.backgroundColor = "";
      }
      this.style.backgroundColor = "rgb(255, 248, 167)";
    });
  }
}
function bloCamposRegAgu() {
  $("#numLicenciaAd").prop("disabled", true);
  $("#numProvedio").prop("disabled", true); 
}
function DesbloCamposRegAgu() {
  $("#numLicenciaAd").prop("disabled", false);
  $("#numProvedio").prop("disabled", false);
}
function bloCamposEditLic() {
  $("#numLicenciaAdEdit").prop("disabled", true);
  $("#numDniOtrosEdit").prop("disabled", true);
  $("#propietarioLicEdit").prop("disabled", true);
  $("#numReciboCajaEdit").prop("disabled", true);
  $("#numProvedioEdit").prop("disabled", true);
  $("#licAguaDesagueEdit").prop("disabled", true);
}
function bloCampost() {
  $("#numLicenciaAdEditt").prop("disabled", true);
  $("#numDniOtrosEditt").prop("disabled", true);
  $("#propietarioLicEditt").prop("disabled", true);
}

//SELECIONAR PARA INPUT NUEVO
$(document).ready(function() {
  // Cuando se cambia la opción del select
  $("#descuendoServicio").change(function() {
    // Obtener el valor seleccionado
    var selectedValue = $(this).val();
    
    // Verificar si el valor seleccionado es 2.00
    if (selectedValue == "2.00") {
      // Mostrar el div con el id 'resoPagoLicAdEdit'
      $("#resoPagoLicAd").closest(".col-lg-5, .col-md-6").show();
      
      // Poner el foco en el campo de entrada
      $("#resoPagoLicAd").focus();
    } else {
      // Ocultar el div con el id 'resoPagoLicAdEdit' si no se selecciona 2.00
      $("#resoPagoLicAd").closest(".col-lg-5, .col-md-6").hide();
    }
  });
  
  // Ejecutar la función al cargar la página para verificar el estado inicial
  $("#descuendoServicio").change();
});


//SELECIONAR PARA INPUT NUEVO
$(document).ready(function() {
  // Cuando se cambia la opción del select
  $("#descuentoSindicato").change(function() {
    // Obtener el valor seleccionado
    var selectedValue = $(this).val();
    
    
    // Verificar si el valor seleccionado es 2.00
    if (selectedValue == "0.50") {
      // Mostrar el div con el id 'resoPagoLicAdEdit'
      $("#resoSinLicAd").closest(".col-lg-5, .col-md-6").show();
      
      // Poner el foco en el campo de entrada
      $("#resoSinLicAd").focus();
    } else {
      // Ocultar el div con el id 'resoPagoLicAdEdit' si no se selecciona 2.00
      $("#resoSinLicAd").closest(".col-lg-5, .col-md-6").hide();
    }
  });
  
  // Ejecutar la función al cargar la página para verificar el estado inicial
  $("#descuentoSindicato").change();
});




//SELECIONAR PARA INPUT EDIT
$(document).ready(function() {
  // Cuando se cambia la opción del select
  $("#descuendoServicioEdit").change(function() {
    // Obtener el valor seleccionado
    var selectedValue = $(this).val();
    
    // Verificar si el valor seleccionado es 2.00
    if (selectedValue == "2.00") {
      // Mostrar el div con el id 'resoPagoLicAdEdit'
      $("#resoPagoLicAdEdit").closest(".col-lg-5, .col-md-6").show();
      
      // Poner el foco en el campo de entrada
      $("#resoPagoLicAdEdit").focus();
    } else {
      // Ocultar el div con el id 'resoPagoLicAdEdit' si no se selecciona 2.00
      $("#resoPagoLicAdEdit").closest(".col-lg-5, .col-md-6").hide();
    }
  });
  
  // Ejecutar la función al cargar la página para verificar el estado inicial
  $("#descuendoServicioEdit").change();
});



//SELECIONAR PARA INPUT EDIT
$(document).ready(function() {
  // Cuando se cambia la opción del select
  $("#descuentoSindicatoEdit").change(function() {
    // Obtener el valor seleccionado
    var selectedValue = $(this).val();
    
    
    // Verificar si el valor seleccionado es 2.00
    if (selectedValue == "0.50") {
      // Mostrar el div con el id 'resoPagoLicAdEdit'
      $("#resoSinLicAdEdit").closest(".col-lg-5, .col-md-6").show();
      
      // Poner el foco en el campo de entrada
      $("#resoSinLicAdEdit").focus();
    } else {
      // Ocultar el div con el id 'resoPagoLicAdEdit' si no se selecciona 2.00
      $("#resoSinLicAdEdit").closest(".col-lg-5, .col-md-6").hide();
    }
  });
  
  // Ejecutar la función al cargar la página para verificar el estado inicial
  $("#descuentoSindicatoEdit").change();
});





// OCULTAR A OTROS(SERVICIO MUNICIAPL)
$(document).ready(function() {
  // Obtener el valor del campo 'area_oculta'
  var area = $('#mySpan_area').attr('iso_area');
  
  console.log("El área es ahora desde modal: " + area);  // Verificar el valor del área

  // Mostrar el div solo si el valor del área es "SUBGERENCIA DE SERVICIOS MUNICIPALES"
  if (area === "SUBGERENCIA DE SERVICIOS MUNICIPALES") {
    console.log("Mostrando el div");
    $("#divDescuentoPagoServicioNuevo").show();  // Mostrar el div
  } else {
    console.log("No se muestra el div");
    $("#divDescuentoPagoServicioNuevo").hide();  // Ocultar el div
  }
});



// VISUBLE EDITAR LICENIA A (SERVCIO MUNICIAPL) NUEVO
$(document).ready(function() {
  // Obtener el valor del campo 'area_oculta'
  var area = $('#mySpan_area').attr('iso_area');
  
  console.log("El área es ahora desde modal: " + area);  // Verificar el valor del área

  // Mostrar el div solo si el valor del área es "SUBGERENCIA DE SERVICIOS MUNICIPALES"
  if (area === "SUBGERENCIA DE SERVICIOS MUNICIPALES") {
    console.log("Mostrando el div");
    $("#divDescuentoSindicatoNuevo").show();  // Mostrar el div
  } else {
    console.log("No se muestra el div");
    $("#divDescuentoSindicatoNuevo").hide();  // Ocultar el div
  }
});







// OCULTAR A OTROS(SERVICIO MUNICIAPL) NUENO
$(document).ready(function() {
  // Obtener el valor del campo 'area_oculta'
  var area = $('#mySpan_area').attr('iso_area');
  
  console.log("El área es ahora desde modal: " + area);  // Verificar el valor del área

  // Mostrar el div solo si el valor del área es "SUBGERENCIA DE SERVICIOS MUNICIPALES"
  if (area === "SUBGERENCIA DE SERVICIOS MUNICIPALES") {
    console.log("Mostrando el div");
    $("#divDescuentoSindicato").show();  // Mostrar el div
  } else {
    console.log("No se muestra el div");
    $("#divDescuentoSindicato").hide();  // Ocultar el div
  }
});



// VISUBLE EDITAR LICENIA A (SERVCIO MUNICIAPL)
$(document).ready(function() {
  // Obtener el valor del campo 'area_oculta'
  var area = $('#mySpan_area').attr('iso_area');
  
  // Mostrar el div solo si el valor del área es "SUBGERENCIA DE SERVICIOS MUNICIPALES"
  if (area === "SUBGERENCIA DE SERVICIOS MUNICIPALES") {
    console.log("Mostrando el div");
    $("#divDescuentoPagoServicio").show();  // Mostrar el div
  } else {
    console.log("No se muestra el div");
    $("#divDescuentoPagoServicio").hide();  // Ocultar el div
  }
});






//TODO MAYUSCULA EDITAR
$(document).ready(function() {
  // Cuando el usuario escribe en el campo de texto
  $("#resoSinLicAdEdit").on('input', function() {
    // Convertir el valor a mayúsculas
    $(this).val($(this).val().toUpperCase());
  });
});


//TODO MAYUSCULA EDIAT
$(document).ready(function() {
  // Cuando el usuario escribe en el campo de texto
  $("#resoPagoLicAdEdit").on('input', function() {
    // Convertir el valor a mayúsculas
    $(this).val($(this).val().toUpperCase());
  });
});


//TODO MAYUSCULA NUEVO
$(document).ready(function() {
  // Cuando el usuario escribe en el campo de texto
  $("#resoPagoLicAd").on('input', function() {
    // Convertir el valor a mayúsculas
    $(this).val($(this).val().toUpperCase());
  });
});


//TODO MAYUSCULA NUEVO
$(document).ready(function() {
  // Cuando el usuario escribe en el campo de texto
  $("#resoSinLicAd").on('input', function() {
    // Convertir el valor a mayúsculas
    $(this).val($(this).val().toUpperCase());
  });
});



// MODAL ABRIL MODAL DE PROGRESO PARA ACTUALIZAR LICENCIAS DE AGUA
$(document).on("click", "#editar_progreso_agua", function () {
  const idContribuyente = document.querySelector('#id_contribuyente_pro').textContent.trim();

  console.log("valor actual del contribuyente",idContribuyente);
    // Asignarlo al input
    $('#codigo_carpeta_agua').val(idContribuyente);

   editarBarraProgreso.editarCarpetaProgresAgua(idContribuyente); // Llamar al método para cargar los datos del contribuyente y actualizar el modal

  // // Asignar el valor al input oculto dentro del modal
  // //$("#codigo_carpeta").val(codigoCarpeta);

  // // Mostrar el modal
  $("#modal_editar_barra_progreso_agua").show();
});



// Cerrar el modal de progreso
$(document).on("click", "#salir_modal_progreso_agua", function () {
  $("#modal_editar_barra_progreso_agua").hide();
});




// GUARDAR PROGRESSO EDITADO
$('#formCarpetaProgressAgua').on('submit', function(event) {
  event.preventDefault();
    // Serializa los datos del formulario
    var datosFormulario = $(this).serialize(); 

    console.log(datosFormulario); 
 
   datosFormulario += '&guardar_estado_progreso_agua=guardar_estado_progreso_agua'; 
    editarBarraProgreso.guardar_editar_progreso_agua(datosFormulario);

})
