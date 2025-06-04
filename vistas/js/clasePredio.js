class PredioClass {
  constructor() {
    this.idPredioC = null; 
    this.fechaAdquisicionC = null; 
    this.numeroLuzC = null; 
    this.areaTerrenoC = 0; 
    this.valorTerrenoC = 0; 
    this.valorConstruccionC = 0; 
    this.valorOtrasInstalaC = 0; 
    this.valorPredioC = 0; 
    this.expedienteTramiteC = null; 
    this.obsercacionesC = null; 
    this.predioURC = null; 
    this.areaConstruccionC = 0; 
    this.idTipoPredioC = null; 
    this.giroEstablecimientoC = null;
    this.idUsoPredioC = 0; 
    this.idEstadoPredioC = 5; 
    this.idRegimenAfectoC = 2;
    this.idInafectoC = 7; 
    this.idArbitriosC = null;
    this.idCondicionPredioC = null; 
    this.fechaDocInscripC = null;
    this.idCatastroC = null; 
    this.idAnioFiscalC = null; 
    this.idSesionC = null; 
    this.idUsoTerrenoC = null; 
    this.idTipoTerrenoC = null; 
    this.idValCarHectarea = null; 
    this.idColindDenominacion = null; 
    this.idColindPropietario = null; 
    this.valExoneradoC = 0; 
    this.valPredioAplicaC=0;

    this.Denominacion_RuralC=null;
    this.Colindante_Sur_NombreC=null;
    this.Colindante_Sur_DenominacionC=null;

    this.Colindante_Oeste_DenominacionC=null;
    this.Colindante_Oeste_NombreC=null;

    this.Colindante_Norte_NombreC=null;
    this.Colindante_Norte_DenominacionC=null;

    this.Colindante_Este_DenominacionC=null;
    this.Colindante_Este_NombreC=null;

    //AGREGADOS PARA URBANO
    this.nLicenciaC=null;
    this.nTrabajadoresC=null;
    this.nMesasC=null;
    this.areaNegocioC=null;
    this.tenencia_negocioC=null;



    this.idCatasroR=null;
    this.idDenominacionR=null; 

    this.idDetalleTrans=null;
    this.idDocInscripcionC = null;

    this.arancelTerrenoC = null;
    this.idViaC = null; // urb y ru
    this.codigoOtorganreC = null; 
    this.propietarioPredioC = [];

    this.numDocInscripC = null;
    this.idTipoEscrituraC = null;
    this.numUbicacionC = null;
    this.numLoteC = null;
    this.codCofopriC = null;
    this.nroBloqueC = null;
    this.nroDepartaC = null;
    this.refenciaC = null;
    this.tipoTerrenoR = null;
    this.usoTerrenoR = null;
    this.idValviC = null;
    this.usoTerrenoR = null;
    this.usoTerrenoR = null;
    this.colSurSectorR = null;
    this.colNorteNombreR = null;
    this.colNorteSectorR = null;
    this.colEsteNombreR = null;
    this.colEsteSectorR = null;
    this.colOesteNombreR = null;
    this.colOesteSectorR = null;
    this.idZonaR = null;
    this.valorTerrenoR=null;
    this.arancel=null;
  }

  calcularValorTerreno() {
    this.valorTerrenoC = (parseFloat(this.areaTerrenoC) * parseFloat(this.arancelTerrenoC)).toFixed(3);
  }

  calcularValorPredio() {
    this.valorPredioC = parseFloat(this.valorTerrenoC) + parseFloat(this.valorConstruccionC) + parseFloat(this.valorOtrasInstalaC);
    this.valExoneradoC = this.valorPredioC / 2;
    this.valPredioAplicaC = this.valorPredioC - this.valExoneradoC;
    this.valPredioAplicaC = this.valPredioAplicaC.toFixed(3);
  }
}
class CuadraClas {
  constructor() {
  this.idDireccionC;
  this.numeroCuadraC;
  this.ladoCuadraC;
  this.zonaCatastroC;
  this.condicionCatastralC; 
  this.situacionCuadra;
  this.distanciaParque;
  this.manzana;
 }
}
//export default PredioClass;
