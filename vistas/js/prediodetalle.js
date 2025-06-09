$(document).ready(function () {

  $("#anioFiscal").prop("disabled", true);
  $("#btnAbrirPropietarios").prop("disabled", true);
  $("#brnAbrirUbigeoPredio").prop("disabled", true);
  $("#btnGuardarPredio").prop("disabled", true);
  $("#btnAbrirUbigeoRural").prop("disabled", true);

  $("#descripcionPredioU_ubigeo").hide();
  $("#descripcionPredioR_ubigeo").hide();

  $("#descripcionPredioU_parametro").hide();
  $("#descripcionPredioR_parametro").hide();

  $("#descripcionPredioU_desc").hide();
  $("#descripcionPredioR_desc").hide();

  $("#descripcionPredioU_regimen").hide();
  $("#descripcionPredioR_regimen").hide();

  let nuevoPredioU;
  let nuevoPredioR;
  let tipopredio;
  let predioSelect = false;

  $(document).on("change", "#tipoPredioUR", function () {
    nuevoPredioU = new PredioClass();
    tipopredio = $("#tipoPredioUR").val();
    $("#anioFiscal").prop("disabled", false);
    if (tipopredio === "U") {

      $("#descripcionPredioU_ubigeo").show();
      $("#descripcionPredioR_ubigeo").hide();

      $("#descripcionPredioU_parametro").show();
      $("#descripcionPredioR_parametro").hide();

      $("#descripcionPredioU_desc").show();
      $("#descripcionPredioR_desc").hide();

      $("#descripcionPredioU_regimen").show();
      $("#descripcionPredioR_regimen").hide();

    } else if (tipopredio === "R") {

      $("#descripcionPredioU_ubigeo").hide();
      $("#descripcionPredioR_ubigeo").show();

      $("#descripcionPredioU_parametro").hide();
      $("#descripcionPredioR_parametro").show();

      $("#descripcionPredioU_desc").hide();
      $("#descripcionPredioR_desc").show();

      $("#descripcionPredioU_regimen").hide();
      $("#descripcionPredioR_regimen").show();

      nuevoPredioR = new PredioClass();
      $("#usoPredioR").val(nuevoPredioR.idUsoPredioC);
      $("#estadoPredioR").val(nuevoPredioR.idEstadoPredioC);
      $("#regInafectoR").val(nuevoPredioR.idRegimenAfectoC);
      $("#inafectoRpor").val(nuevoPredioR.idInafectoC);
    }
  });

  $(document).on("change", "#areaTerreno", function () {
    nuevoPredioU.areaTerrenoC = parseFloat($("#areaTerreno").val());
    if ($("#valorArancel").text() === "-") {
      nuevoPredioU.arancelTerrenoC = 0;
    } else {
      nuevoPredioU.arancelTerrenoC = parseFloat($("#valorArancel").text());
    }
    if ($("#valorConstruc").text() === "-") {
      nuevoPredioU.valorConstruccionC = 0;
    } else {
      nuevoPredioU.valorConstruccionC = parseFloat($("#valorConstruc").text());
    }
    nuevoPredioU.calcularValorTerreno();
    $("#valorTerreno").text(nuevoPredioU.valorTerrenoC);
    nuevoPredioU.calcularValorPredio();
    $("#valorPredioAnio").text(nuevoPredioU.valorPredioC);
  });

  $(document).on("change", "#areaTerrenoR", function () {
    nuevoPredioR.areaTerrenoC = parseFloat($("#areaTerrenoR").val()).toFixed(4);
    nuevoPredioR.arancelTerrenoC = parseFloat($("#valorArancelR").text()).toFixed(4);
    nuevoPredioR.calcularValorTerreno();
    $("#valorTerrenoR").text(nuevoPredioR.valorTerrenoC);
    nuevoPredioR.calcularValorPredio();
    $("#valorPredioRAnio").text(nuevoPredioR.valorPredioC);
  });

  $(document).on("change", "#regInafecto", function () {
    nuevoPredioU.idRegimenAfectoC = $(this).val();
    if (nuevoPredioU.idRegimenAfectoC === "4") {
      $("#afecto").val("7");
      $("#afecto").prop("disabled", true); // desabilita el segundo select
    } else {
      $("#afecto").val("1");
      $("#afecto").prop("disabled", false); // habilita el segundo select
    }
  });

  $(document).on("change", "#estadoPredio", function () {
    nuevoPredioU.idEstadoPredioC = $(this).val();
    if (nuevoPredioU.idEstadoPredioC === "1") {
      $("#giroPredio").val("1");
      $("#giroPredio").prop("disabled", true); // desabilita el segundo select
    } else {
      $("#giroPredio").prop("disabled", false); // habilita el segundo select
    }
  });

  $(document).on("change", "#regInafectoR", function () {
    nuevoPredioR.idRegimenAfectoC = $(this).val();
    if (nuevoPredioR.idRegimenAfectoC === "4") {
      $("#inafectoRpor").val("7");
      $("#inafectoRpor").prop("disabled", true); // desabilita el segundo select
    } else {
      $("#inafectoRpor").val("1");
      $("#inafectoRpor").prop("disabled", false); // habilita el segundo select
    }
  });

  $(document).on("change", "#anioFiscal", function () {
    nuevoPredioU.idAnioFiscalC = $("#anioFiscal").val();
    if (nuevoPredioU.idAnioFiscalC === null) {
      $("#btnAbrirPropietarios").prop("disabled", true);
      $("#brnAbrirUbigeoPredio").prop("disabled", true);
      $("#btnGuardarPredio").prop("disabled", true);
      $("#btnAbrirUbigeoRural").prop("disabled", true);
    } else {
      $("#btnAbrirPropietarios").prop("disabled", false);
      $("#brnAbrirUbigeoPredio").prop("disabled", false);
      $("#btnGuardarPredio").prop("disabled", false);
      $("#btnAbrirUbigeoRural").prop("disabled", false);
      $("#fechaIniU").text('01-'+'01-'+$("#anioFiscal option:selected").text());
      $("#fechaFinU").text('31-'+'12-'+$("#anioFiscal option:selected").text());
      $("#fechaIniR").text('01-'+'01-'+$("#anioFiscal option:selected").text());
      $("#fechaIniR").text('31-'+'12-'+$("#anioFiscal option:selected").text());
    }
  });

  function capturarValoresUrbanos() {
    nuevoPredioU.idAnioFiscalC = $("#anioFiscal").val();
    nuevoPredioU.idDocInscripcionC = $("#tipodocInscripcion").val();
    nuevoPredioU.idTipoEscrituraC = $("#tipoEscritura").val();
    nuevoPredioU.numDocInscripC = $("#nroDocIns").val();
    nuevoPredioU.numUbicacionC = $("#nroUbicacion").val();
    nuevoPredioU.fechaDocInscripC = $("#fechaEscritura").val();
    nuevoPredioU.idTipoPredioC = $("#tipoPredio").val();
    nuevoPredioU.idUsoPredioC = $("#usoPredio").val();
    nuevoPredioU.idEstadoPredioC = $("#estadoPredio").val();
    nuevoPredioU.giroEstablecimientoC = $("#giroPredio").val();
    nuevoPredioU.idCondicionPredioC = $("#condicionPredio").val();
    nuevoPredioU.nroBloqueC = $("#nroBloque").val();
    nuevoPredioU.nroDepartaC = $("#nroDepa").val();
    nuevoPredioU.refenciaC = $("#referenUbi").val();
    nuevoPredioU.expedienteTramiteC = $("#nroExpediente").val();
    nuevoPredioU.fechaAdquisicionC = $("#fechaAdqui").val();
    nuevoPredioU.idArbitriosC = $("#afectacionArb").val();
    nuevoPredioU.numLoteC = $("#nroLote").val();
    nuevoPredioU.codCofopriC = $("#codCofopri").val();
    nuevoPredioU.predioURC = $("#tipoPredioUR").val();
    nuevoPredioU.numeroLuzC = $("#reciboLuz").val();
    nuevoPredioU.idInafectoC = $("#afecto").val();
  }

  function captuaraValoresRusticos() {
    nuevoPredioR.predioURC = $("#tipoPredioUR").val();
    nuevoPredioR.idAnioFiscalC = $("#anioFiscal").val();
    nuevoPredioR.idDocInscripcionC = $("#tipodocInscripcion").val();
    nuevoPredioR.numDocInscripC = $("#nroDocIns").val();
    nuevoPredioR.idTipoEscrituraC = $("#tipoEscritura").val();
    nuevoPredioR.fechaDocInscripC = $("#fechaEscritura").val();
    //id via Rustico
    nuevoPredioR.denomiSectorR = $("#denoSectorR").val();
    nuevoPredioR.colSurNombreR = $("#colSurNombre").val();
    nuevoPredioR.colSurSectorR = $("#colSurSector").val();
    nuevoPredioR.colNorteNombreR = $("#colNorteNombre").val();
    nuevoPredioR.colNorteSectorR = $("#colNorteSector").val();
    nuevoPredioR.colEsteNombreR = $("#colEsteNombre").val();
    nuevoPredioR.colEsteSectorR = $("#colEsteSector").val();
    nuevoPredioR.colOesteNombreR = $("#colOesteNombre").val();
    nuevoPredioR.colOesteSectorR = $("#colOesteSector").val();
    //areaTerreno valorArancel valorTerreno valorPredio
    nuevoPredioR.idTipoPredioC = $("#tipoPredioR").val();
    nuevoPredioR.idUsoPredioC = $("#usoPredioR").val();
    nuevoPredioR.idEstadoPredioC = $("#estadoPredioR").val();
    nuevoPredioR.idCondicionPredioC = $("#condicionPredioR").val();
    nuevoPredioR.fechaAdquisicionC = $("#fechaAdquiR").val();
    //regimen
    nuevoPredioR.idInafectoC = $("#inafectoRpor").val();
    nuevoPredioR.tipoTerrenoR = $("#tipoTerrenoR").val();
    nuevoPredioR.usoTerrenoR = $("#usoTerrenoR").val();
    nuevoPredioR.expedienteTramiteC = $("#nroExpedienteR").val();
    nuevoPredioR.obsercacionesC = $("#observacionR").val();

    nuevoPredioR.denomiSectorR = $("#denoSectorR").val();
    nuevoPredioR.colSurNombreR = $("#colSurNombre").val();
    nuevoPredioR.colSurSectorR = $("#colSurSector").val();
    nuevoPredioR.colNorteNombreR = $("#colNorteNombre").val();
    nuevoPredioR.colNorteSectorR = $("#colNorteSector").val();
    nuevoPredioR.colEsteNombreR = $("#colEsteNombre").val();
    nuevoPredioR.colEsteSectorR = $("#colEsteSector").val();
    nuevoPredioR.colOesteNombreR = $("#colOesteNombre").val();
    nuevoPredioR.colOesteSectorR = $("#colOesteSector").val();
  }

  $(document).on("click", "#btnGuardarPredio", function () {
    if (tipopredio === "U") {
      $("#div_propietario tr").each(function (index) {
        let idFila = $(this).attr("id");
        nuevoPredioU.propietarioPredioC[index] = idFila; // Agregar el valor al arreglo
      });
      capturarValoresUrbanos();
      // =========== REGISTRO PREDIO =============================
      nuevoPredioU.idViaC = $("#idvia_Predio").text();
      let formd = new FormData();
      formd.append("tipoPredioUR", nuevoPredioU.predioURC);
      formd.append("idAnioFiscal", nuevoPredioU.idAnioFiscalC);
      formd.append("tipoDocInscripcion", nuevoPredioU.idDocInscripcionC);
      formd.append("nroDocIns", nuevoPredioU.numDocInscripC);
      formd.append("tipoEscritura", nuevoPredioU.idTipoEscrituraC);
      formd.append("fechaEscritura", nuevoPredioU.fechaDocInscripC);
      formd.append("IdContribuyente", nuevoPredioU.propietarioPredioC);
      formd.append("idViaurbano", nuevoPredioU.idViaC);
      formd.append("nroUbicacion", nuevoPredioU.numUbicacionC);
      formd.append("nroLote", nuevoPredioU.numLoteC);
      formd.append("reciboLuz", nuevoPredioU.numeroLuzC);
      formd.append("codCofopri", nuevoPredioU.codCofopriC);
      formd.append("nroBloque", nuevoPredioU.nroBloqueC);
      formd.append("nroDepa", nuevoPredioU.nroDepartaC);
      formd.append("referenUbi", nuevoPredioU.refenciaC);
      formd.append("areaTerreno", nuevoPredioU.areaTerrenoC);
      formd.append("valorTerreno", nuevoPredioU.valorTerrenoC);
      formd.append("valorConstruc", nuevoPredioU.valorConstruccionC);
      formd.append("valorOtrasIns", nuevoPredioU.valorOtrasInstalaC);
      formd.append("areaConstruc", nuevoPredioU.areaConstruccionC);
      formd.append("valorPredioAnio", nuevoPredioU.valorPredioC);
      formd.append("tipoPredio", nuevoPredioU.idTipoPredioC);
      formd.append("usoPredio", nuevoPredioU.idUsoPredioC);
      formd.append("valInafeExonerado", nuevoPredioU.valExoneradoC);// agregue
      formd.append("estadoPredio", nuevoPredioU.idEstadoPredioC);
      formd.append("giroPredio", nuevoPredioU.giroEstablecimientoC);
      formd.append("condicionDuenio", nuevoPredioU.idCondicionPredioC);
      formd.append("fechaAdqui", nuevoPredioU.fechaAdquisicionC);
      formd.append("regInafecto", nuevoPredioU.idRegimenAfectoC);
      formd.append("inafectoPor", nuevoPredioU.idInafectoC);
      formd.append("afectacionArb", nuevoPredioU.idArbitriosC);
      formd.append("nroExpediente", nuevoPredioU.expedienteTramiteC);
      formd.append("observacion", $("#observacion").val());
      formd.append("predioUrbano", "predioUrbano");


      $.ajax({
        type: "POST",
        url: "ajax/predio.ajax.php",
        data: formd,
        cache: false,
        contentType: false,
        processData: false, //Cuarto R
        success: function (respuesta) {
        console.log("la respuesta del envio es  " + respuesta);
         if(respuesta === "OK")  {
        //  window.location.reload();
        general.mostrarAlerta("success", "Registro de Predio Urbano", "Se ha registrado el Predio de forma correcta", { limpiarFormulario: "formRegisroPredio" });
        $("#itemsRC").empty();

        //$('#formRegisroPredio')[0].reset();
        $("#descripcionPredioU_ubigeo").hide();
        $("#descripcionPredioR_ubigeo").hide();
        $("#descripcionPredioU_parametro").hide();
        $("#descripcionPredioR_parametro").hide();
        $("#descripcionPredioU_desc").hide();
        $("#descripcionPredioR_desc").hide();
        $("#descripcionPredioU_regimen").hide();
        $("#descripcionPredioR_regimen").hide();
        $("#itemsRP").html("");
        $("#div_propietario").html("");
        $("#valorArancel").html("-");
        $("#valorTerreno").html("-");
        $("#valorPredioAnio").html("-");
        }
        else {
          general.mostrarAlerta("error", "Error", respuesta);
        }
        },
      });
    } else if (tipopredio === "R") {
      $("#div_propietario tr").each(function (index) {
        let idFila = $(this).attr("id");
        nuevoPredioR.propietarioPredioC[index] = idFila; // Agregar el valor al arreglo
      });
      captuaraValoresRusticos();
      // =========== REGISTRO PREDIO =============================
      nuevoPredioR.idViaC = $("#idzona_rustico").text();
      nuevoPredioR.idZonaR = $("#idZonaR").text();
      let formd = new FormData();
      formd.append("fechaAdqui", nuevoPredioR.fechaAdquisicionC);
      formd.append("areaTerreno", nuevoPredioR.areaTerrenoC);
      formd.append("valorTerreno", nuevoPredioR.valorTerrenoC);
      formd.append("valorPredioAnio", nuevoPredioR.valorPredioC);
      formd.append("nroExpediente", nuevoPredioR.expedienteTramiteC);
      formd.append("observacion", $("#observacionR").val());
      formd.append("tipoPredioUR", nuevoPredioR.predioURC);
      formd.append("tipoPredio", nuevoPredioR.idTipoPredioC);
      formd.append("usoPredio", nuevoPredioR.idUsoPredioC);
      formd.append("estadoPredio", nuevoPredioR.idEstadoPredioC);
      formd.append("regInafecto", nuevoPredioR.idRegimenAfectoC);
      formd.append("inafectoPor", nuevoPredioR.idInafectoC);
      formd.append("condicionDuenio", nuevoPredioR.idCondicionPredioC);
      formd.append("idAnioFiscal", nuevoPredioR.idAnioFiscalC);
      formd.append("usoTerreno", nuevoPredioR.usoTerrenoR);
      formd.append("tipoTerreno", nuevoPredioR.tipoTerrenoR);
      formd.append("idCategoriaHectarea", nuevoPredioR.idViaC); //
      //formd.append("idColindanteDenomin",3); se calcula
      formd.append("idColinPropietario", 1);
      formd.append("valInafeExonerado", nuevoPredioR.valExoneradoC);
      //------------------------------------
      formd.append("nroDocIns", nuevoPredioR.numDocInscripC);
      formd.append("tipoDocInscripcion", nuevoPredioR.idDocInscripcionC);
      formd.append("tipoEscritura", nuevoPredioR.idTipoEscrituraC);
      formd.append("fechaEscritura", nuevoPredioR.fechaDocInscripC);
      formd.append("IdContribuyente", nuevoPredioR.propietarioPredioC);
      formd.append("idViaurbano", nuevoPredioR.idViaC);
      //------------------------------------
      formd.append("denoSectorR", nuevoPredioR.denomiSectorR);
      formd.append("colSurNombre", nuevoPredioR.colSurNombreR);
      formd.append("colSurSector", nuevoPredioR.colSurSectorR);
      formd.append("colNorteNombre", nuevoPredioR.colNorteNombreR);
      formd.append("colNorteSector", nuevoPredioR.colNorteSectorR);
      formd.append("colEsteNombre", nuevoPredioR.colEsteNombreR);
      formd.append("colEsteSector", nuevoPredioR.colEsteSectorR);
      formd.append("colOesteNombre", nuevoPredioR.colOesteNombreR);
      formd.append("colOesteSector", nuevoPredioR.colOesteSectorR);
      formd.append("idZonaRural", nuevoPredioR.idZonaR); //
      formd.append("predioRural", "predioRural");

      $.ajax({
        type: "POST",
        url: "ajax/predio.ajax.php",
        data: formd,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta === "OK") {
            $("#descripcionPredioU_ubigeo").hide();
            $("#descripcionPredioR_ubigeo").hide();
            $("#descripcionPredioU_parametro").hide();
            $("#descripcionPredioR_parametro").hide();
            $("#descripcionPredioU_desc").hide();
            $("#descripcionPredioR_desc").hide();
            $("#descripcionPredioU_regimen").hide();
            $("#descripcionPredioR_regimen").hide();
            $("#itemsRP").html("");
            $("#div_propietario").html("");
            $("#valorArancel").html("-");
            $("#valorTerreno").html("-");
            $("#valorPredioAnio").html("-");
            general.mostrarAlerta("success", "Registro de Predio Rustico", "Se ha registrado el Predio de forma correcta", { limpiarFormulario: "formRegisroPredio" });



          } else {
            general.mostrarAlerta("error", "Error", respuesta);
          }
        },
      });
    } else {
      alert("Seleccione Tipo de Predio Rustico / Urbano");
    }
  });

  const predioEdit = new PredioClass();

  //SELEICON DE PREDIOS
  $(document).on("click", "#tablalistapredios tbody tr", function () {

    console.log("diste click en predio");
    predioSelect = true;
    predioEdit.idPredioC = $(this).attr("id_predio");
    predioEdit.idAnioFiscalC= $("#selectnum").val();
  });



  $("#btnEditarPredioU").click(function () {

    if (predioSelect) {
      let datos = new FormData();
      datos.append("idPredio", predioEdit.idPredioC);
      datos.append("editarPredio", "true");
      //traer informaion del predio
      $.ajax({
        url: "ajax/predio.ajax.php",
        type: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {

          console.log("para editar predio--",respuesta);


          predioEdit.idPredioC = respuesta.Id_Predio;
          predioEdit.fechaAdquisicionC = respuesta.Fecha_Adquisicion;
          predioEdit.numeroLuzC = respuesta.Numero_Luz;
          predioEdit.areaTerrenoC = respuesta.Area_Terreno;
          predioEdit.valorTerrenoC = respuesta.Valor_Terreno;
          predioEdit.valorConstruccionC = respuesta.Valor_Construccion;
          predioEdit.valorOtrasInstalaC = respuesta.Valor_Otras_Instalacions;
          predioEdit.valorPredioC = respuesta.Valor_predio;
          predioEdit.expedienteTramiteC = respuesta.Expediente_Tramite;
          predioEdit.obsercacionesC = respuesta.Observaciones;
          predioEdit.predioURC = respuesta.predio_UR;
          predioEdit.areaConstruccionC = respuesta.Area_Construccion;
          predioEdit.idTipoPredioC = respuesta.Id_Tipo_Predio;
          predioEdit.giroEstablecimientoC = respuesta.Id_Giro_Establecimiento;
          predioEdit.idUsoPredioC = respuesta.Id_Uso_Predio;
          predioEdit.idEstadoPredioC = respuesta.Id_Estado_Predio;
          predioEdit.idRegimenAfectoC = respuesta.Id_Regimen_Afecto;
          predioEdit.idInafectoC = respuesta.Id_inafecto;
          predioEdit.idArbitriosC = respuesta.Id_Arbitrios;
          predioEdit.idCondicionPredioC = respuesta.Id_Condicion_Predio;
          predioEdit.fechaDocInscripC = respuesta.Fecha_Registro;
          predioEdit.idCatastroC = respuesta.Id_Catastro;
          predioEdit.idAnioFiscalC = respuesta.Id_Anio;
          predioEdit.idSesionC = respuesta.Id_Sesion;
          predioEdit.idUsoTerrenoC = respuesta.Id_Uso_Terreno;
          predioEdit.idTipoTerrenoC = respuesta.Id_Tipo_Terreno;
          predioEdit.idColindDenominacion = respuesta.Id_Colindante_Denominacion;
          predioEdit.idColindPropietario = respuesta.Id_Colindante_Propietario;
          predioEdit.valExoneradoC = respuesta.Valor_Inaf_Exo;
          predioEdit.valPredioAplicaC = respuesta.Valor_Predio_Aplicar;
          predioEdit.idCatasroR = respuesta.Id_Catastro_Rural;
          predioEdit.idDenominacionR = respuesta.Id_Denominacion_Rural;
          predioEdit.idDetalleTrans = respuesta.Id_Detalle_Transferencia;
          predioEdit.idDocInscripcionC = respuesta.Id_Documento_Inscripcion;
          predioEdit.numDocInscripC = respuesta.Numero_Documento_Inscripcion;
          predioEdit.idTipoEscrituraC = respuesta.Id_Tipo_Escritura;
          predioEdit.fechaDocInscripC = respuesta.Fecha_Escritura;



          predioEdit.numUbicacionC = respuesta.Numero_Ubicacion;
          predioEdit.numLoteC = respuesta.Numero_Lote;
          predioEdit.codCofopriC = respuesta.Codigo_COFOPRI;
          predioEdit.nroBloqueC = respuesta.Numero_Bloque;
          predioEdit.nroDepartaC = respuesta.Numero_Departamento;
          predioEdit.refenciaC = respuesta.Referencia;
          predioEdit.tipoTerrenoR = respuesta.Id_Tipo_Terreno;
          predioEdit.usoTerrenoR = respuesta.Id_Uso_Terreno;
          predioEdit.idValviC = respuesta.Id_valores_categoria_x_hectarea
          predioEdit.idViaC = respuesta.Id_Ubica_Vias_Urbano;
          predioEdit.Denominacion_RuralC = respuesta.Denominacion_Rural;
          predioEdit.Colindante_Sur_NombreC = respuesta.Colindante_Sur_Nombre;
          predioEdit.Colindante_Sur_DenominacionC = respuesta.Colindante_Sur_Denominacion;
          predioEdit.Colindante_Oeste_DenominacionC = respuesta.Colindante_Oeste_Denominacion;
          predioEdit.Colindante_Oeste_NombreC = respuesta.Colindante_Oeste_Nombre;
          predioEdit.Colindante_Norte_NombreC = respuesta.Colindante_Norte_Nombre;
          predioEdit.Colindante_Norte_DenominacionC = respuesta.Colindante_Norte_Denominacion;
          predioEdit.Colindante_Este_DenominacionC = respuesta.Colindante_Este_Denominacion;
          predioEdit.Colindante_Este_NombreC = respuesta.Colindante_Este_Nombre;

          //EXONERACION
           predioEdit.Fecha_Inicio_exoC = respuesta.Fecha_Inicio_exo;
           predioEdit.Fecha_fin_exoC = respuesta.Fecha_fin_exo;
           predioEdit.Numero_ExpedienteC = respuesta.Numero_Expediente;

         //LEVANTAMIENTO DATOS
          predioEdit.nLicenciaC = respuesta.N_Licencia;
          predioEdit.nTrabajadoresC = respuesta.N_Trabajadores;
          predioEdit.nMesasC = respuesta.N_Mesas;
          predioEdit.areaNegocioC = respuesta.Area_negocio;
          predioEdit.tenencia_negocioC = respuesta.Tenencia_Negocio;
          predioEdit.personeriaC = respuesta.Personeria;
          predioEdit.tipoPersonaC = respuesta.Tipo_personeria;

          predioEdit.nPersonasC = respuesta.N_Personas;

         predioEdit.tAguaC=respuesta.T_Agua ;


           predioEdit.otroNombreC = respuesta.Otro_Nombre;

          let DirecccioncompletoC = respuesta.Direccion_completo;


          if (predioEdit.Denominacion_RuralC === undefined || predioEdit.Denominacion_RuralC === null || predioEdit.Denominacion_RuralC === '') {
            let posicionGuion = DirecccioncompletoC.indexOf('-');
            if (posicionGuion !== -1) {
                let parteDespuesGuion = DirecccioncompletoC.substring(posicionGuion + 1).trim();
                predioEdit.Denominacion_RuralC = parteDespuesGuion;
            } else {
                predioEdit.Denominacion_RuralC = DirecccioncompletoC;
            }
        } else {
            predioEdit.Denominacion_RuralC = respuesta.Denominacion_Rural;
        }
          if (predioEdit.predioURC == "U") {
            $("#divUbigeoPreu").show();
            $("#divDescripPreu").show();

            $("#divUbigeoPreR").hide();
            $("#divDescriPreR").hide();
            asignarvaloreurbanos();
            informacionUbigeo(predioEdit.idViaC, predioEdit.idAnioFiscalC);
          } else {
            $("#divUbigeoPreR").show();
            $("#divDescriPreR").show();
            $("#divUbigeoPreu").hide();
            $("#divDescripPreu").hide();

            asignarValoresRusticos();
            informacionUbigeor(predioEdit.idValviC, predioEdit.idAnioFiscalC);
          }
        },
      });
      //traer informacion de ubigeo
      $("#modalEditarPredio").modal("show");




    } else {
      alert("Debe Seleccionar un Predio a Modificar");
    }
  });

  function asignarvaloreurbanos() {

 console.log("valor de agua",predioEdit.tAguaC);

    $("#nroUbicacion_e").val(predioEdit.numUbicacionC);
    $("#nroLote_e").val(predioEdit.numLoteC);
    $("#reciboLuz_e").val(predioEdit.numeroLuzC);
    $("#codCofopri_e").val(predioEdit.codCofopriC);
    $("#nroBloque_e").val(predioEdit.nroBloqueC);
    $("#nroDepa_e").val(predioEdit.nroDepartaC);
    $("#referenUbi_e").val(predioEdit.refenciaC);
    $("#areaTerreno_e").val(predioEdit.areaTerrenoC);
    $("#valorConstruc_e").text(predioEdit.valorConstruccionC);
    $("#valorTerreno_e").text(predioEdit.valorTerrenoC);
    $("#areaConstruc_e").text(predioEdit.areaConstruccionC);
    $("#valorPredioAnio_e").text(predioEdit.valorPredioC);
    $("#valorOtrasIns_e").text(predioEdit.valorOtrasInstalaC);

    $("#giroPredio_e").val(predioEdit.giroEstablecimientoC).trigger('change');

    $("#condicionPredio_e").val(predioEdit.idCondicionPredioC);
    $("#estadoPredio_e").val(predioEdit.idEstadoPredioC);
    $("#tipoPredioUR_e").val(predioEdit.predioURC);
    $("#tipoPredioUR_e").prop("disabled", true);
    $("#anioFiscal_e").val(predioEdit.idAnioFiscalC);
    $("#anioFiscal_e").prop("disabled", true);
    $("#tipoPredio_e").val(predioEdit.idTipoPredioC);
    $("#usoPredio_e").val(predioEdit.idUsoPredioC);
    $("#tipodocInscripcion_e").val(predioEdit.idDocInscripcionC);
    $("#nroDocIns_e").val(predioEdit.numDocInscripC);
    $("#tipoEscritura_e").val(predioEdit.idTipoEscrituraC);
    $("#fechaEscritura_e").val(predioEdit.fechaDocInscripC);

    $("#fechaAdqui_e").val(predioEdit.fechaAdquisicionC);

    $("#regInafecto_e").val(predioEdit.idRegimenAfectoC);
    $("#afecto_e").val(predioEdit.idInafectoC);
    $("#afectacionArb_e").val(predioEdit.idArbitriosC);
    $("#nroExpediente_e").val(predioEdit.expedienteTramiteC);
    $("#observacion_e").val(predioEdit.obsercacionesC);

  //   //EXONERACION
      $("#fechaInicio_e").val(predioEdit.Fecha_Inicio_exoC);
      $("#fechaFin_e").val(predioEdit.Fecha_fin_exoC);
      $("#numeroExpediente_e").val(predioEdit.Numero_ExpedienteC);

  //    //LEVANTAMIENTO DATOS
     $("#nLicencia_e").val(predioEdit.nLicenciaC);
     $("#nTrabajadores_e").val(predioEdit.nTrabajadoresC);
     $("#nMesas_e").val(predioEdit.nMesasC);
     $("#areaNegocio_e").val(predioEdit.areaNegocioC);
     $("#tenencia_e").val(predioEdit.tenencia_negocioC);
     $("#personeria_e").val(predioEdit.personeriaC);
     $("#tipoPersona_e").val(predioEdit.tipoPersonaC);

     $("#npersonas_e").val(predioEdit.nPersonasC);


     $("input[name='tieneAgua'][value='" + predioEdit.tAguaC + "']").prop("checked", true);
     $("#paga_otro_nombre_e").val(predioEdit.otroNombreC);

  //     if (valorAgua === "si" || valorAgua === "no") {
  //   $("input[name='tieneAgua'][value='" + valorAgua + "']").prop("checked", true);
  // }

  //     $("#paga_otro_nombre_e").val(predioEdit.Otro_Nombre);



     





  }

  function asignarValoresRusticos() {
    $("#tipoPredioUR_e").val(predioEdit.predioURC);
    $("#anioFiscal_e").val(predioEdit.idAnioFiscalC);
    $("#tipodocInscripcion_e").val(predioEdit.idDocInscripcionC);
    $("#nroDocIns_e").val(predioEdit.numDocInscripC);
    $("#tipoEscritura_e").val(predioEdit.idTipoEscrituraC);
    $("#fechaEscritura_e").val(predioEdit.fechaDocInscripC);
    //id via Rustico
    $("#denoSectorR_e").val(predioEdit.Denominacion_RuralC);
    $("#colSurNombre_e").val(predioEdit.Colindante_Sur_NombreC);
    $("#colSurSector_e").val(predioEdit.Colindante_Sur_DenominacionC);
    $("#colNorteNombre_e").val(predioEdit.Colindante_Norte_NombreC);
    $("#colNorteSector_e").val(predioEdit.Colindante_Norte_DenominacionC);
    $("#colOesteNombre_e").val(predioEdit.Colindante_Oeste_NombreC);
    $("#colOesteSector_e").val(predioEdit.Colindante_Oeste_DenominacionC);
    $("#colEsteNombre_e").val(predioEdit.Colindante_Este_NombreC);
    $("#colEsteSector_e").val(predioEdit.Colindante_Este_DenominacionC);

    //areaTerreno valorArancel valorTerreno valorPredio
    $("#areaTerrenoR_e").val(predioEdit.areaTerrenoC);
    $("#tipoPredioR_e").val(predioEdit.idTipoPredioC);
    $("#usoPredioR_e").val(predioEdit.idUsoPredioC);
    $("#estadoPredioR_e").val(predioEdit.idEstadoPredioC);
    $("#condicionPredioR_e").val(predioEdit.idCondicionPredioC);

    $("#fechaAdquiR_e").val(predioEdit.fechaAdquisicionC);

    //regimen
    $("#regInafectoR_e").val(predioEdit.idRegimenAfectoC);
    $("#inafectoRpor_e").val(predioEdit.idInafectoC);
    $("#tipoTerrenoR_e").val(predioEdit.tipoTerrenoR);
    $("#usoTerrenoR_e").val(predioEdit.usoTerrenoR);
    $("#nroExpedienteR_e").val(predioEdit.expedienteTramiteC);
    $("#observacionR_e").val(predioEdit.obsercacionesC);

    $("#valorTerrenoR_e").text(predioEdit.valorTerrenoC);
    $("#valorPredioRAnio_e").text(predioEdit.valorTerrenoC);

  }

  function informacionUbigeo(idubicavia, idanioedit) {
    // OPTENIENDO LA DIRECCION DEL CONTRIBUYENTE
    $.ajax({
      type: "POST",
      url: "ajax/viascalles.ajax.php",
      data: { idubicaviaedit: idubicavia, idanioedit: idanioedit },
      dataType: "json",
      success: function (respuesta) {
        const tablaHTML = `
        <input type="hidden" id="idViaurbano_e" name="idViaurbano_e" value="${respuesta.id}">
        <tr>
          <td style="text-align: center;">${respuesta.tipo_via} ${respuesta.nombre_calle}</td>
          <td style="text-align: center;">${respuesta.numManzana}</td>
          <td style="text-align: center;">${respuesta.cuadra}</td>
          <td style="text-align: center;">${respuesta.lado}</td>
         <td style="text-align: center;">${respuesta.zona}</td>
          <td style="text-align: center;">${respuesta.habilitacion}</td>
          <td style="text-align: center;">${respuesta.arancel}</td>
          <td style="text-align: center;" id="idvia_Predio">${respuesta.id}</td>
          <td style="text-align: center;">${respuesta.condicion}</td>
        </tr>`;
        $("#itemsRP").html(tablaHTML);
        $("#valorArancel_e").text(respuesta.arancel);
      },
    });
  }

  function informacionUbigeor(idubicavia, idanioedit) {
    // OPTENIENDO LA DIRECCION DEL CONTRIBUYENTE
    $.ajax({
      type: "POST",
      url: "ajax/viascalles.ajax.php",
      data: { idubicaviaeditr: idubicavia, idanioedit: idanioedit },
      dataType: "json",
      success: function (respuesta) {
        predioEdit.arancel=respuesta.arancel;
        $("#valorArancelR").text(predioEdit.arancel);
        const tablaHTML = `
        <input type="hidden" id="idViaurbano_e" name="idViaurbano_e" value="${respuesta.id}">
        <tr>
          <td style="text-align: center;">${respuesta.nombre_zona}</td>
          <td style="text-align: center;">${respuesta.id_zona_rural}</td>
          <td style="text-align: center;">${respuesta.altura}</td>
          <td style="text-align: center;">${respuesta.categoria_calidad}</td>
         <td style="text-align: center;">${respuesta.grupo_tierra}</td>
          <td style="text-align: center;">${respuesta.arancel}</td>
          <td style="text-align: center;">${respuesta.anio}</td>
          <td id="idzona_rustico" style="text-align: center;">${respuesta.id}</td>
        </tr>`;
        $("#itemsR").html(tablaHTML);
        $("#valorArancelR").text(respuesta.arancel);
      },
    });
  }

  function capturarValoresUrbanosE() {
    //predioEdit.idAnioFiscalC = $("#anioFiscal").val();
    predioEdit.idDocInscripcionC = $("#tipodocInscripcion_e").val();
    predioEdit.idTipoEscrituraC = $("#tipoEscritura_e").val();
    predioEdit.numDocInscripC = $("#nroDocIns_e").val();
    predioEdit.fechaDocInscripC = $("#fechaEscritura_e").val();

    predioEdit.idViaC = $("#idvia_Predio").text();
    predioEdit.numUbicacionC = $("#nroUbicacion_e").val();
    predioEdit.numLoteC = $("#nroLote_e").val();
    predioEdit.numeroLuzC = $("#reciboLuz_e").val();
    predioEdit.codCofopriC = $("#codCofopri_e").val();
    predioEdit.nroBloqueC = $("#nroBloque_e").val();
    predioEdit.nroDepartaC = $("#nroDepa_e").val();
    predioEdit.refenciaC = $("#referenUbi_e").val();
    predioEdit.areaTerrenoC = $("#areaTerreno_e").val();
    predioEdit.idTipoPredioC = $("#tipoPredio_e").val();
    predioEdit.idUsoPredioC = $("#usoPredio_e").val();
    predioEdit.idEstadoPredioC = $("#estadoPredio_e").val();
    predioEdit.giroEstablecimientoC = $("#giroPredio_e").val();
    predioEdit.idCondicionPredioC = $("#condicionPredio_e").val();

    predioEdit.fechaAdquisicionC = $("#fechaAdqui_e").val();

    predioEdit.idRegimenAfectoC = $("#regInafecto_e").val();
    predioEdit.idInafectoC = $("#afecto_e").val();
    predioEdit.idArbitriosC = $("#afectacionArb_e").val();
    predioEdit.expedienteTramiteC = $("#nroExpediente_e").val();
    predioEdit.obsercacionesC = $("#observacion_e").val();
    predioEdit.valorPredioC = $("#valorPredioAnio_e").text();

    // //EXONERACION
     predioEdit.Fecha_Inicio_exoC = $("#fechaInicio_e").val();
     predioEdit.Fecha_fin_exoC = $("#fechaFin_e").val();
     predioEdit.Numero_ExpedienteC = $("#numeroExpediente_e").val();

    // //LEVANTAMIENTO DATOS
    predioEdit.nLicenciaC = $("#nLicencia_e").val();
    predioEdit.nTrabajadoresC = $("#nTrabajadores_e").val();
    predioEdit.nMesasC = $("#nMesas_e").val();
    predioEdit.areaNegocioC = $("#areaNegocio_e").val();
    predioEdit.tenencia_negocioC = $("#tenencia_e").val();
    predioEdit.personeriaC = $("#personeria_e").val();
    predioEdit.tipoPersonaC = $("#tipoPersona_e").val();

    predioEdit.nPersonasC = $("#npersonas_e").val();

    //predioEdit.tAguaC = $("input[name='tieneAgua']:checked").val();

    let valorAgua = $("input[name='tieneAgua']:checked").val();
    // if (!valorAgua) {
    //   alert("Debe seleccionar si tiene agua.");
    //   return;
    // }
    predioEdit.tAguaC = valorAgua;

    predioEdit.otroNombreC = $("#paga_otro_nombre_e").val();





  }




  //GUARDAR EDIATR PREDIO
   $(document).on("click", "#btnGuardarPredio_e", function () {
    if (predioEdit.predioURC === "U") {
          capturarValoresUrbanosE();
          // =========== REGISTRO PREDIO =============================
          predioEdit.idViaC = $("#idvia_Predio").text();
          let formd = new FormData();
          formd.append("predio_UR", predioEdit.predioURC); //16
          formd.append("tipoDocInscripcion", predioEdit.idDocInscripcionC); //16
          formd.append("nroDocIns", predioEdit.numDocInscripC); //13
          formd.append("tipoEscritura", predioEdit.idTipoEscrituraC); //21
          formd.append("fechaEscritura", predioEdit.fechaDocInscripC); //14
          formd.append("idViaurbano", predioEdit.idViaC); //30

          formd.append("nroUbicacion", predioEdit.numUbicacionC); //4
          formd.append("nroLote", predioEdit.numLoteC); //5
          formd.append("reciboLuz", predioEdit.numeroLuzC); //3
          formd.append("codCofopri", predioEdit.codCofopriC); //7
          formd.append("nroBloque", predioEdit.nroBloqueC); //3

          formd.append("nroDepa", predioEdit.nroDepartaC); //33
          formd.append("referenUbi", predioEdit.refenciaC); //8
          formd.append("areaTerreno", predioEdit.areaTerrenoC); //4
          formd.append("valorTerreno", predioEdit.valorTerrenoC); //5
          formd.append("valorConstruc", predioEdit.valorConstruccionC); //6

          formd.append("valorOtrasIns", predioEdit.valorOtrasInstalaC); //7
          formd.append("areaConstruc", predioEdit.areaConstruccionC); //
          formd.append("valorPredioAnio", predioEdit.valorPredioC); //8
          formd.append("tipoPredio", predioEdit.idTipoPredioC); //17
          formd.append("usoPredio", predioEdit.idUsoPredioC); //19

          formd.append("estadoPredio", predioEdit.idEstadoPredioC); //20
          formd.append("giroPredio", predioEdit.giroEstablecimientoC); //18
          formd.append("condicionDuenio", predioEdit.idCondicionPredioC); //25
          formd.append("fechaAdqui", predioEdit.fechaAdquisicionC); //2
          formd.append("regInafecto", predioEdit.idRegimenAfectoC); //22

          formd.append("inafectoPor", predioEdit.idInafectoC); //23
          formd.append("afectacionArb", predioEdit.idArbitriosC); //24
          formd.append("nroExpediente", predioEdit.expedienteTramiteC); //9
          formd.append("observacion", predioEdit.obsercacionesC); //10
          formd.append("idPredioE", predioEdit.idPredioC); //

          //EXONERACION
          formd.append("fechaInicio", predioEdit.Fecha_Inicio_exoC); //11
          formd.append("fechaFin", predioEdit.Fecha_fin_exoC); //12
          formd.append("numeroExpediente", predioEdit.Numero_ExpedienteC); //15


          //LEVANTAMIENTO DATOS
          formd.append("nLicencia", predioEdit.nLicenciaC); //26
          formd.append("nTrabajadores", predioEdit.nTrabajadoresC); //27
          formd.append("nMesas", predioEdit.nMesasC); //28
          formd.append("areaNegocio", predioEdit.areaNegocioC); //29
          formd.append("tenenciaNegocio", predioEdit.tenencia_negocioC); //31
          formd.append("personeria", predioEdit.personeriaC); //32
          formd.append("tipoPersona", predioEdit.tipoPersonaC); //33
          formd.append("nPersonas", predioEdit.nPersonasC); //34
          formd.append("tAgua", predioEdit.tAguaC); //34
          formd.append("otroNombre", predioEdit.otroNombreC); //34

          



          for (let [key, value] of formd.entries()) {
              console.log(`${key}: ${value}`);
          }



          formd.append("predioUrbanoE", "predioUrbanoE");
            $.ajax({
              type: "POST",
              url: "ajax/predio.ajax.php",
              data: formd,
              cache: false,
              contentType: false,
              processData: false,
              success: function (respuesta) {
                if (respuesta.tipo === "advertencia") {
                  $("#respuestaAjax_srm").html(respuesta.mensaje);
                  $("#respuestaAjax_srm").show(); // Mostrar el elemento
                  setTimeout(function () {
                    $("#respuestaAjax_srm").hide();
                  }, 5000); // 3000 milisegundos = 3 segundos
          } else {
            predio.lista_predio(predio.anio_predio);
            $("#modalEditarPredio").modal("hide");
            $("#respuestaAjax_srm").html(respuesta.mensaje);
            $("#respuestaAjax_srm").show(); // Muestra el mensaje

            // Obtener los parámetros actuales de la URL
            setTimeout(function () {
              $("#respuestaAjax_srm").hide(); //
            }, 5000); // 3 segundos
          }
        },
      });
    } else {

    // =========== REGISTRO PREDIO =============================
    predioEdit.idViaC = parseInt($("#idzona_rustico").text().trim(),10);
    predioEdit.idZonaR = parseInt($("#idZonaR").text().trim(),10);
    let formd = new FormData();
      
    //formd.append("tipo_predio", $("#tipoPredioUR_e").val());
    //predioEdit.idAnioFiscalC = $("#anioFiscal").val();
    formd.append("tipo_predio_UR",$("#tipoPredioUR_e").val());
    formd.append("anio_fiscal",$("#anioFiscal_e").val());
    formd.append("tipo_doc_inscripcion",$("#tipodocInscripcion_e").val());
    formd.append("Numero_doc_inscripcion",$("#nroDocIns_e").val());
    formd.append("tipo_escritura",$("#tipoEscritura_e").val());
    formd.append("fecha_escritura",$("#fechaEscritura_e").val());
    //id via Rustico
    formd.append("denominacion",$("#denoSectorR_e").val());
    formd.append("col_sur_nombre",$("#colSurNombre_e").val());
    formd.append("col_sur_sector",$("#colSurSector_e").val());
    formd.append("col_norte_nombre",$("#colNorteNombre_e").val());
    formd.append("col_norte_sector",$("#colNorteSector_e").val());
    formd.append("col_oeste_nombre",$("#colOesteNombre_e").val());
    formd.append("col_oeste_sector",$("#colOesteSector_e").val());
    formd.append("col_este_nombre",$("#colEsteNombre_e").val());
    formd.append("col_este_sector",$("#colEsteSector_e").val());
    formd.append("idDenominacionR",predioEdit.idDenominacionR);
    formd.append("idColindenominacion",predioEdit.idColindDenominacion);
    //areaTerreno valorArancel valorTerreno valorPredio
    formd.append("area_terreno",$("#areaTerrenoR_e").val());
    formd.append("valor_terreno",$("#valorTerrenoR_e").text());
    formd.append("valor_predio",$("#valorPredioRAnio_e").text());
    //areaTerreno
    formd.append("tipo_predio",$("#tipoPredioR_e").val());
    formd.append("uso_predio",$("#usoPredioR_e").val());
    formd.append("estado_predio",$("#estadoPredioR_e").val());
    formd.append("condicion_predio",$("#condicionPredioR_e").val());
    formd.append("fecha_adquisicion",$("#fechaAdquiR_e").val());
    //regimen
    formd.append("regimen_inafecto",$("#regInafectoR_e").val());
    formd.append("inafecto",$("#inafectoRpor_e").val());
    formd.append("tipo_terreno",$("#tipoTerrenoR_e").val());
    formd.append("uso_terreno",$("#usoTerrenoR_e").val());
    formd.append("expediente",$("#nroExpedienteR_e").val());
    formd.append("observacion",$("#observacionR_e").val());
    formd.append("idvalcat", $("#idzona_rustico").text()); // idviar
    formd.append("id_predio", predioEdit.idPredioC); //
    formd.append("predio_rural_E", "predio_rural_E");

    $.ajax({
      type: "POST",
      url: "ajax/predio.ajax.php",
      data: formd,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        if (respuesta.tipo === "error") {
          $("#errorPredioR").html(respuesta.mensaje);
          $("#errorPredioR").show(); // Mostrar el elemento
          setTimeout(function () {
            $("#errorPredioR").hide();
          }, 4000); // 3000 milisegundos = 3 segundos
        } else {
          predio.lista_predio(predio.anio_predio);
            $("#modalEditarPredio").modal("hide");
            $("#respuestaAjax_srm").html(respuesta.mensaje);
            $("#respuestaAjax_srm").show(); // Muestra el mensaje
            setTimeout(function () {
              $("#respuestaAjax_srm").hide(); //
            }, 5000); // 3 segundos 
        }
      },
    });
    }
  });

  $(document).on("input", "#areaTerreno_e", function () {
    predioEdit.areaTerrenoC = parseFloat($("#areaTerreno_e").val()).toFixed(4);
    predioEdit.arancelTerrenoC = parseFloat($("#valorArancel_e").text()).toFixed(4);
    if ($("#valorConstruc_e").text() === "-") {
      predioEdit.valorConstruccionC = 0;
    } else {
      predioEdit.valorConstruccionC = parseFloat($("#valorConstruc_e").text()).toFixed(4);
    }
    predioEdit.calcularValorTerreno();
    $("#valorTerreno_e").text(parseFloat(predioEdit.valorTerrenoC).toFixed(4));
    predioEdit.calcularValorPredio();
    $("#valorPredioAnio_e").text(parseFloat(predioEdit.valorPredioC).toFixed(4));
  });
  //nuevo valor del terreno rustico al cambiar el area
  $(document).on("input", "#areaTerrenoR_e", function () {
    let arancel;
    predioEdit.areaTerrenoC = parseFloat($("#areaTerrenoR_e").val()); // Maneja el caso de entradas no numéricas
    arancel=$("#valorArancelR").text();
    predioEdit.arancelTerrenoC = parseFloat(arancel);
    predioEdit.calcularValorTerreno();
    console.log(predioEdit.valorTerrenoC);
    $("#valorTerrenoR_e").text(predioEdit.valorTerrenoC);
    $("#valorPredioRAnio_e").text(predioEdit.valorTerrenoC);
  });
  //nuevo valor del terreno rustico al cambiar el area
  $(document).on("change", "#regInafecto_e", function () {
    predioEdit.idRegimenAfectoC = $(this).val();
    if (predioEdit.idRegimenAfectoC === "4") {
      $("#afecto_e").val("7");
      $("#afecto_e").prop("disabled", true); // desabilita el segundo select
    } else {
      $("#afecto_e").val("1");
      $("#afecto_e").prop("disabled", false); // habilita el segundo select
    }
  });

  $(document).on("click", "#agregarContribuyente_Predio", function () {
    $("#modalAgregarContribuyente_Predio").show();
  });



  $(document).on("click", ".btnAgregarContribuyente_predio", function () {
    var contribuyentes = [];
    var predios= [];
    var tabla_predio = document.getElementById('tablalistapredios2');
    var tabla_contribuyente = document.getElementById('tabla_contribuyente_predio');

    console.log("predio selecionado",tabla_predio);


    const style = document.createElement("style");
    style.textContent = `
        .swal2-container {
        z-index: 20000 !important;
        }
        `;
    document.head.appendChild(style);

    // for(var i=1, row;row =tabla_predio.rows[i];i++){
    //   var id_predio = row.getAttribute('id_predio');
    //   predios.push(id_predio);

    // }

  //   for(var i = 1, row; row = tabla_predio.rows[i]; i++) {
  //   // Verificar que no sea la última fila (que es el total)
  //   if(!row.querySelector('td.caption_')) {
  //       var id_predio = row.getAttribute('id_predio');
  //       predios.push(id_predio);
  //   }
  // }
  for (var i = 1, row; row = tabla_predio.rows[i]; i++) {
    // Verifica que la fila no sea el total (ejemplo: si tiene un colspan)
    if (!row.querySelector('td[colspan]')) {
        var id_predio = row.getAttribute('id_predio');
        if (id_predio) { // Asegúrate de que no sea undefined o vacío
            predios.push(id_predio);
        }
    }
}

    for(var i=1, row;row =tabla_contribuyente.rows[i];i++){
      var id_contribuyente = row.getAttribute('id').trim();
      contribuyentes.push( id_contribuyente);
      }


    var id_propietario = predio.id_propietario;
    var carpeta = $('#carpeta_contribuyente').attr('id_carpeta');
    var select = document.getElementById('selectnum');
    var anio = select.options[select.selectedIndex].text;
    let numerosArray = id_propietario.split('-');
    let coincidencia = contribuyentes.filter(numero => numerosArray.includes(numero));
    if (coincidencia.length>0) {
      Swal.fire({
                icon: 'error',
                title: 'Advertencia',
                text: "Este contribuyente ya existe en esta carpeta con codigo"+ coincidencia,
                confirmButtonText: 'Entendido'
              })

  }else{
    if(contribuyentes.length===0){
      Swal.fire({
        icon: 'error',
        title: 'Advertencia',
        text: "seleccione un contribuyente",
        confirmButtonText: 'Entendido'
      })
    }else{
      if(predios.length===0){
        Swal.fire({
          icon: 'error',
          title: 'Advertencia',
          text: "no registra predio",
          confirmButtonText: 'Entendido'
        })
      }else{
    let formd = new FormData();
    formd.append('contribuyentes',contribuyentes);
   // formd.append('predios',predios);
    formd.append('predios', predios.join(','));
    formd.append('id_propietario',id_propietario);
    formd.append('carpeta',carpeta);
    formd.append('agregar_ContribuyentePredio','agregar_ContribuyentePredio');

        // Para imprimir el contenido de formd
    for (let pair of formd.entries()) {
      console.log(pair[0]+ ': '+ pair[1]);
    }

    $.ajax({
      type: "POST",
      url: "ajax/predio.ajax.php",
      data: formd,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success: function (respuesta) {
        if(respuesta[0]){
          Swal.fire({
            title: "Contribuyente Agregado",
            text: "se agrego correctamente al contribuyente",
            icon: "success",
            timer: 3000
          }).then(() => {
            window.location.href = "index.php?ruta=listapredio&id="+respuesta[1]+"&anio="+anio;
          });
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Advertencia',
            text: respuesta[1],
            confirmButtonText: 'Entendido'
          })
        }
      }
    });
  }}}
  });

  $(document).on("click", "#salir_AgregarContribuyente", function () {
    $("#modalAgregarContribuyente_Predio").hide();
  });



});

//BUSCADOR DE SELECTORES
 // Asegúrate de que el DOM esté cargado
// $(document).ready(function () {
//   $('#giroPredio_e').select2({
//     placeholder: "Seleccione", // Este placeholder se muestra solo si hay una opción vacía
//     allowClear: true,
//     width: 'resolve'
//   });


// });





  //  $(document).ready(function () {
  //   $('#persononeria_jur_e').on('change', function () {
  //     if ($(this).val() === 'PERSONA_JURIDICA') {
  //       $('#otroInputRowJuridica').show();
  //     } else {
  //       $('#otroInputRowJuridica').hide();
  //     }
  //   });
  // });



  //REGIMEN AFECTO

  $(document).ready(function () {

  function toggleCamposRegimen(valor) {
    if (valor === 5 || valor===6) {
      $('#fecha_ini_div').show();
      $('#fecha_fin_div').show();
      $('#expediente_div').show();
    } else {
      $('#fecha_ini_div').hide();
      $('#fecha_fin_div').hide();
      $('#expediente_div').hide();
    }
  }

  $('#regInafecto_e').on('change', function () {
    const valor = parseInt($(this).val());
    toggleCamposRegimen(valor);
  });

  $('#modalEditarPredio').on('shown.bs.modal', function () {
    const valor = parseInt($('#regInafecto_e').val());
    toggleCamposRegimen(valor);
  });
});

// PEROSNORIA JURIDICA

 $(document).ready(function () {

  function toggleCamposRegimen(valor) {
    if (valor === "PERSONA_JURIDICA" ) {
      $('#otroInputRowJuridica').show();

    } else {
      $('#otroInputRowJuridica').hide();
       // Limpiar la selección en el dropdown de tipo sociedad si es Persona Natural
      $('#tipoPersona_e').val('');


    }
  }

  $('#personeria_e').on('change', function () {
    const valor =$(this).val();
    console.log("personeria...", valor );
    toggleCamposRegimen(valor);
  });

  

$('#modalEditarPredio').on('shown.bs.modal', function () {
    const valor = $('#personeria_e').val();
    toggleCamposRegimen(valor);
  });


});

//  $(document).ready(function () {});





//TIENE AGUA
// $(document).ready(function () {
//   // Función para mostrar u ocultar el input y su label según el valor del radio button
//   function toggleCamposRegimen() {
//     // Obtener el valor de los radio buttons seleccionados
//     const valor = $("input[name='tieneAgua']:checked").val();

//     // Mostrar el input y el label si el valor es "si", ocultarlos si es "no" o está vacío
//     if (valor === "si") {
//       $('#paga_otro_nombre_row').show();  // Muestra tanto el label como el input
//     } else {
//       $('#paga_otro_nombre_row').hide();  // Oculta tanto el label como el input
//         // Si el valor seleccionado es "No", vaciar el input
//       $('#paga_otro_nombre').val('');
//     }
//   }

//   // Evento cuando cambia el valor del radio button
//   $("input[name='tieneAgua']").on('change', function () {
//     toggleCamposRegimen();  // Actualizar la visibilidad del input y label
//   });

//   // Ejecutar cuando el modal se abre o al cargar la página para verificar el estado inicial
//   // $('#modalEditarPredio').on('shown.bs.modal', function () {
//   //   toggleCamposRegimen();  // Verificar si el input y el label deben mostrarse o no
//   // });

//   $('#modalEditarPredio').on('shown.bs.modal', function () {
//   $("input[name='tieneAgua'][value='" + predioEdit.tAguaC + "']").prop("checked", true);
//   toggleCamposRegimen();
// });


//   // Inicializar el estado del input y label al cargar la página
//   toggleCamposRegimen();
// });



//AGUA NUEVO

// $(document).ready(function () {
//   // Función para mostrar u ocultar el input y su label según el valor del radio button
//   function toggleCamposRegimen() {
//     const valor = $("input[name='tieneAgua']:checked").val();

//     if (valor === "si") {
//       $('#paga_otro_nombre_row').show();
//     } else {
//       $('#paga_otro_nombre_row').hide();
//       $('#paga_otro_nombre_e').val(''); // <- corrección aquí
//     }
//   }

//   // Evento al cambiar la selección de radio
//   $("input[name='tieneAgua']").on('change', function () {
//     toggleCamposRegimen();
//   });

//   // Al abrir el modal, marcar el valor guardado y aplicar la lógica
//   $('#modalEditarPredio').on('shown.bs.modal', function () {
//     $("input[name='tieneAgua'][value='" + predioEdit.tAguaC + "']").prop("checked", true);
//   const valor = $('#personeria_e').val();


//     toggleCamposRegimen();
//   });

//   // Estado inicial
//   toggleCamposRegimen();
// });


//PRUEBA ----------------------------------

 $(document).ready(function () {

  function toggleCamposRegimen(valor) {


    if (valor ===  "si") {
       $('#paga_otro_nombre_row').show();

    } else {
      $('#paga_otro_nombre_row').hide();
      $('#paga_otro_nombre_e').val(''); // <- corrección aquí


    }
  }


    $("input[name='tieneAgua']").on('change', function () {
       const valor =$(this).val();
    toggleCamposRegimen(valor);
  });
  

$('#modalEditarPredio').on('shown.bs.modal', function () {
   // const valor = $('#personeria_e').val();
    const valor = $("input[name='tieneAgua']:checked").val();
    toggleCamposRegimen(valor);
  });


});




//   $(document).ready(function() {

//     console.log("cundo incia la carga ",predioEdit.idRegimenAfectoC)
//   // Cuando se selecciona una opción del select
//   $('#regInafecto_e').on('change', function() {
//     // Verifica si hay una opción seleccionada
//     var selectedValue = $(this).val();

//     // Si se selecciona una opción, mostrar las divs
//     if (selectedValue === "5" ||predioEdit.idRegimenAfectoC===5 ) {
//       $('#fecha_ini_div').show(); // Muestra la primera div
//       $('#fecha_fin_div').show(); // Muestra la segunda div
//       $('#expediente_div').show(); // Muestra la tercera div
//     } else {
//       // Si no hay opción seleccionada, las ocultas
//       $('#fecha_ini_div').hide();
//       $('#fecha_fin_div').hide();
//       $('#expediente_div').hide();
//     }
//   });
// });

