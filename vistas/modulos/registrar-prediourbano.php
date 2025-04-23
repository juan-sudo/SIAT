<?php

use Controladores\ControladorPredio;
?>
<div class="content-wrapper panel-medio-principal">
	<section class="container-fluid panel-medio">
		<div class="box container-fluid">
			<div class="col-lg-12 col-xs-12">

				<div>
					<h6>Registro de Predio Urbano - Rustico</h6>
				</div>
			</div>
		</div>
	</section>

	<form role="form" method="post" class="formRegisroPredio fondo_predio" id="formRegisroPredio">
		<!-- Anio y Tipo de Predio a Registrar-->
		<section class="container-fluid panel-medio">
			<div class="box container-fluid">
				<div class="col-lg-12 col-xs-12">

					<div class="col-md-6">
						<div class="form-group pull-right">
							<label for="" class="lbl-text">Tipo de Predio</label>
							<div class="input-group">
								<select class="form-control" name="tipoPredioUR" id="tipoPredioUR" required>
									<option value="" selected="" disabled="">Seleccione Tipo</option>
									<option value="U">Urbano </option>
									<option value="R">Rural</option>
								</select>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group pull-left">
							<label for="" class="lbl-text">Año Fiscal</label>
							<div class="input-group">
								<select class="form-control" name="anioFiscal" id="anioFiscal" required="">
									<option value="" selected="" disabled="">Seleccione Año</option>
									<?php
									$anioSiat = 'anio';
									$registros = ControladorPredio::ctrMostrarDataAnio($anioSiat);
									foreach ($registros as $data_d) {
										echo "<option value='" . $data_d['Id_Anio'] . "'>" . $data_d['NomAnio'] . '</option>';
									}
									?>
								</select>
							</div>
						</div>
					</div>

				</div>
			</div>
		</section>
		<!-- Anio y Tipo de Predio a Registrar-->

		<!-- Seccion unificado de documento y propietario -->
		<section class="container-fluid panel-medio">
			<!-- Tipo de documento de inscripcion-->
			<section class="container-fluid panel-medio col-xs-6">
				<div class="box container-fluid">
					<div class="col-lg-12 col-xs-12">
						<!-- FORMULARIO -->
						<div class="text-bordeada">
							Documentos de Inscripcion
						</div>
						<!-- ENTRADA DOC INSCRIPCION -->

						<div class="row">
							<div class="col-5 col-md-5">
								<label for="tipoPredio" class="cajalabel2">Doc. Inscripciòn</label>
							</div>
							<div class="col-6 col-md-6">
								<select class="form-control" name="tipodocInscripcion" required="" id="tipodocInscripcion" required="">
									<option value="" selected="" disabled="">Seleccione Documento</option>
									<?php
									$tabla = 'documento_inscripcion';
									$registros = ControladorPredio::ctrMostrarData($tabla);
									foreach ($registros as $data_d) {
										echo "<option value='" . $data_d['Id_Documento_Inscripcion'] . "'>" . $data_d['Documento_Inscripcion'] . '</option>';
									}
									?>
								</select>
							</div>
						</div>

						<!-- ENTRADA NRO DOC -->

						<div class="row">
							<div class="col-5 col-md-5">
								<label for="" class="cajalabel2">Nro. Documento</label>
							</div>
							<div class="col-6 col-md-6">
								<input type="text" placeholder="Número de Documento ..." pattern="[A-Za-z0-9\s:.\-]+" title="Solo se permiten letras" class="form-control" name="nroDocIns" id="nroDocIns" maxlength="50" required>
							</div>
						</div>

						<!-- ENTRADA TIPO DOC -->
						<div class="row">
							<div class="col-5 col-md-5">
								<label for="" class="cajalabel2">Tipo de Documento.</label>
							</div>
							<div class="col-6 col-md-6">
								<select class="form-control" name="tipoEscritura" required="" id="tipoEscritura">
									<option value="" selected="" disabled="">Seleccione Tipo Documento</option>
									<?php
									$tabla = 'tipo_escritura';
									$registros = ControladorPredio::ctrMostrarData($tabla);
									foreach ($registros as $data_d) {
										echo "<option value='" . $data_d['Id_Tipo_Escritura'] . "'>" . $data_d['Tipo_Escritura'] . '</option>';
									}
									?>
								</select>
							</div>
						</div>

						<!-- ENTRADA FECHA DOC -->
						<div class="row">
							<div class="col-5 col-md-5">
								<label for="" class="cajalabel2">Fecha Doc.</label>
							</div>
							<div class="col-6 col-md-6">
								<input type="date" class="form-control" name="fechaEscritura" id="fechaEscritura" required="">
							</div>
						</div>
					</div>
				</div>
			</section>
			<!--Fin Tipo de documento de inscripcion-->

			<!-- Informacion de propietarios-->
			<section class="container-fluid panel-medio col-xs-6" id="propietarios">
				<div class="box container-fluid">

					<div class="text-bordeada">
						Propietarios
					</div>
					<table id="tabla_propietario" class="table-container">
						<thead>
							<tr>
								<th class="text-center">Código</th>
								<th class="text-center">Documento</th>
								<th class="text-center">Nombres</th>
								<th class="text-center">Acciones</th>
							</tr>
						</thead>
						<tbody id="div_propietario">
							<!-- Aquí se agregarán los propietarios en filas -->
						</tbody>
					</table>
					<div class="boton-propietario">
						<button type="button" class="btn btn-secundary btn-1" data-toggle="modal" data-target="#modalPropietarios">Agregar Propietarios</button>
					</div>

				</div>
			</section>
			<!-- Fin Informacion de propietarios -->
		</section>
		<!-- Fin Seccion unificado de documento y propietario -->


		<!-- Informacion de Ubigeo Urbano-->
		<section class="container-fluid panel-medio" id="descripcionPredioU_ubigeo">

			<section class="container-fluid panel-medio col-xs-6">
				<div class="box container-fluid">
					<div class="text-bordeada">
						Informacion de Ubigeo Predio Urbano 1
					</div>
					<div class="col-xs-6">
						<div class="row">
							<div class="col-6 col-md-6">
								<label for="" class="cajalabel2">N° Ubicacion</label>
							</div>
							<div class="col-5 col-md-5">
								<input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form-control" name="nroUbicacion" id="nroUbicacion" maxlength="5" required="">
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-6">
								<label for="" class="cajalabel2">N° Lote</label>
							</div>
							<div class="col-5 col-md-5">
								<input type="text"   class="form-control" name="nroLote" id="nroLote" maxlength="5" required="">
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-6">
								<label for="reciboLuz" class="cajalabel2">N° Recibo Luz</label>
							</div>
							<div class="col-5 col-md-5">
								<input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form-control" name="reciboLuz" id="reciboLuz" required="" maxlength="15">
							</div>
						</div>
					</div>

					<div class="col-xs-6">
						<div class="row">
							<div class="col-6 col-md-6">
								<label for="codCofopri" class="cajalabel2">N° COFOPRI</label>
							</div>
							<div class="col-5 col-md-5">
								<input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form-control" name="codCofopri" id="codCofopri" required="" maxlength="10">
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-6">
								<label for="nroBloquee" class="cajalabel2">N° Bloque</label>
							</div>
							<div class="col-5 col-md-5">
								<input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form-control" name="nroBloque" id="nroBloque" maxlength="5">
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-6">
								<label for="nroDepa" class="cajalabel2">N° Depart.</label>
							</div>
							<div class="col-5 col-md-5">
								<input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form-control" name="nroDepa" id="nroDepa" maxlength="5">
							</div>
						</div>


					</div>
					<div class="col-xs-12">
						<div class="row">
							<div class="col-2 col-md-2">
								<label for="referenUbi" class="cajalabel2">Referencia</label>
							</div>
							<div class="col-10 col-md-10">
								<input type="text" pattern="[A-Za-z0-9\s:.\-]+" title="Solo se permiten letras" class="form-control" name="referenUbi" id="referenUbi" placeholder="Ingrese la referencia de la Ubicacion ...">
							</div>
						</div>
					</div>

				</div>
			</section>

			<section class="container-fluid panel-medio col-xs-6">
				<div class="box container-fluid">
					<div class="items-c">
						<div class="text-bordeada">
							Informacion de Ubigeo Predio Urbano 2
						</div>
						<table class="table-container">
							<thead>
								<tr>
									<th class="text-center">Nombre Via</th>
									<th class="text-center">Manzana</th>
									<th class="text-center">Cuadra</th>
									<th class="text-center">Zona</th>
									<th class="text-center">Habilitacion</th>
									<th class="text-center">Arancel</th>
									<th class="text-center">Id Via</th>
									<th class="text-center">Condición</th>
								</tr>
							</thead>
							<tbody id="itemsRP">
							</tbody>
						</table>
						<div class="boton-propietario">
							<button id="brnAbrirUbigeoPredio" type="button" class="btn btn-secundary btn-1 pull-left" data-toggle="modal" data-target="#modalViacalle_Predio">Ubigeo Predio Urbano</button>
						</div>
					</div>
				</div>
			</section>



		</section>
		<!-- Fin Informacion de Ubigeo Urbano-->

		<!-- Informacion de Ubigeo Ubigeo Rustico-->
		<section class="container-fluid panel-medio" id="descripcionPredioR_ubigeo">
			<div class="box container-fluid">
				<div class="col-lg-12 col-xs-12">

					<div class="items-c">
						<div class="text-bordeada">
							Informacion de Ubigeo Predio Rustico
							<button id="btnAbrirUbigeoRural" type="button" class="btn btn-secundary btn-1 pull-right" data-toggle="modal" data-target="#moda_PredioRustico">Ubigeo Predio Rustico</button>
						</div>
						<table class="table-container">
							<thead>
								<tr>
									<th class="text-center">Nombre Zona</th>
									<th class="text-center">Id Zona</th>
									<th class="text-center">Grupo Tierra</th>
									<th class="text-center">Categoria</th>
									<th class="text-center">Calidad Agricola</th>
									<th class="text-center">Valor x Hectarea</th>
									<th class="text-center">Año</th>
									<th class="text-center">Id</th>
								</tr>
							</thead>
							<tbody id="itemsR">
							</tbody>
						</table>
					</div>


					<div class="col-md-4"> <!-- LADO 1 DENOMINACION PREDIO RURAL-->
						<!-- ENTRADA DENOMINACION RURAL-->
						<div class="row">
							<div class="col-5 col-md-5">
								<label for="denoSectorR" class="cajalabel2">Denominacion Rural</label>
							</div>
							<div class="col-6 col-md-6">
								<input type="text" pattern="[A-Za-z0-9\s:.\-]+" title="" class="form-control" name="denoSectorR" id="denoSectorR" required="" placeholder="Denominación">
							</div>
						</div>
					</div>
					<div class="col-md-8"> <!-- LADO 2 COLINDANTES-->
						<div class="">
							<label for="" class="cajalabel2">Colindantes </label>
							<input for="" class="form5" value="Propietarios" disabled>
							<input for="" class="form5" value="Denominacion Rural" disabled>
						</div>
						<div class="">
							<label for="colSurNombre" class="cajalabel2">Colindante Sur</label>
							<input type="text" pattern="[0-9]+" title="" class="form5" name="colSurNombre" id="colSurNombre" maxlength="50" required="">
							<input type="text" pattern="[0-9]+" title="" class="form5" name="colSurSector" id="colSurSector" maxlength="50" required="">
						</div>
						<div class="">
							<label for="colNorteNombre" class="cajalabel2">Colindantes Norte</label>
							<input type="text" pattern="[0-9]+" title="" class="form5" name="colNorteNombre" id="colNorteNombre" maxlength="50" required="">
							<input type="text" pattern="[0-9]+" title="" class="form5" name="colNorteSector" id="colNorteSector" maxlength="50" required="">
						</div>
						<div class="">
							<label for="colEsteNombre" class="cajalabel2">Colindantes Este </label>
							<input type="text" pattern="[0-9]+" title="" class="form5" name="colEsteNombre" id="colEsteNombre" maxlength="50" required="">
							<input type="text" pattern="[0-9]+" title="" class="form5" name="colEsteSector" id="colEsteSector" maxlength="50" required="">
						</div>
						<div class="">
							<label for="colOesteNombre" class="cajalabel2">Colindantes Oeste</label>
							<input type="text" pattern="[0-9]+" title="" class="form5" name="colOesteNombre" id="colOesteNombre" maxlength="50" required="">
							<input type="text" pattern="[0-9]+" title="" class="form5" name="colOesteSector" id="colOesteSector" maxlength="50" required="">
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Informacion de Ubigeo Ubigeo Rustico-->

		<!-- Parametros de Predio Urbano-->
		<section class="container-fluid panel-medio col-lg-4 col-xs-12" id="descripcionPredioU_parametro">
			<div class="box container-fluid">
				<div class="text-bordeada">
					Parametros Predio Urbano
				</div>
				<!-- ENTRADA AREA TERRENO-->
				<div class="row">
					<div class="col-5 col-md-5">
						<label for="areaTerreno" class="cajalabel2">Area Terreno(m2)</label>
					</div>
					<div class="col-4 col-md-4 pull-left">
						<input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form-control" name="areaTerreno" id="areaTerreno" maxlength="10" required="">
					</div>
					<div class="col-3 col-md-3 pull-left">
					</div>
				</div>

				<!-- VALOR ARANCEL-->
				<div class="row">
					<div class="col-5 col-md-5">
						<label for="" class="cajalabel2 text-left">Valor Arancel</label>
					</div>
					<div class="col-3 col-md-3 text-center">
						<label id="valorArancel">-</label>
					</div>
					<div class="col-4 col-md-4 pull-left">
					</div>
				</div>
				<!-- VALOR TERRENO-->
				<div class="row">
					<div class="col-5 col-md-5">
						<label class="cajalabel2">Valor Terreno</label>
					</div>
					<div class="col-3 col-md-3 text-center">
						<label id="valorTerreno">-</label>
					</div>
					<div class="col-4 col-md-4 pull-left">
					</div>
				</div>

				<!-- VALOR CONSTRUCCION-->
				<div class="row">
					<div class="col-5 col-md-5 ">
						<label class="cajalabel2">Valor Construc.</label>
					</div>
					<div class="col-3 col-md-3 text-center">
						<label id="valorConstruc">-</label>
					</div>
					<div class="col-4 col-md-4 pull-left">
					</div>
				</div>
				<!-- VALOR OTRAS INSTALACIONES-->
				<div class="row">
					<div class="col-5 col-md-5">
						<label for="" class="cajalabel2">Valor Otras Inst.</label>
					</div>
					<div class="col-3 col-md-3 text-center">
						<label id="valorOtrasIns">-</label>
					</div>
					<div class="col-4 col-md-4 pull-left">
					</div>
				</div>
				<!-- AREA CONSTRUCCION-->
				<div class="row">
					<div class="col-5 col-md-5">
						<label for="" class="cajalabel2">Area Constru.(m2)</label>
					</div>
					<div class="col-3 col-md-3 text-center">
						<label id="areaConstruc">-</label>
					</div>
					<div class="col-4 col-md-4 pull-left">
					</div>
				</div>
				<!-- VALOR PREDIO POR AÑO-->
				<div class="row">
					<div class="col-5 col-md-5">
						<label for="" class="cajalabel2">Valor por Año</label>
					</div>
					<div class="col-3 col-md-3 text-center">
						<label id="valorPredioAnio">-</label>
					</div>
					<div class="col-4 col-md-4 pull-left">
					</div>
				</div>
			</div>
		</section>
		<!-- Fin Parametros de Predio Urbano-->

		<!-- SECCION DE PARAMETROS-->
		<section class="container-fluid panel-medio" id="section_params">
			<!-- Descripcion de Predio Urbano-->
			<section class="container-fluid panel-medio col-xs-4" id="descripcionPredioU_desc">
				<div class="box container-fluid">
					<div class="text-bordeada">
						Descripcion de Predio
					</div>
					<div class="row">
						<div class="col-5 col-md-5">
							<label for="tipoPredio" class="cajalabel2"> Tipo Predio</label>
						</div>
						<div class="col-6 col-md-6">
							<select class="form-control" name="tipoPredio" id="tipoPredio">
								<option value="" selected="" disabled="">Seleccione</option>
								<?php
								$tabla = 'tipo_predio';
								$registros = ControladorPredio::ctrMostrarData($tabla);
								foreach ($registros as $data_d) {
									echo "<option value='" . $data_d['Id_Tipo_Predio'] . "'>" . $data_d['Tipo'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<!-- USO PREDIO    -->
					<div class="row">
						<div class="col-5 col-md-5">
							<label for="usoPredio" class="cajalabel2"> Uso Predio</label>
						</div>
						<div class="col-6 col-md-6">
							<select class="form-control" name="usoPredio" id="usoPredio">
								<option value="" selected="" disabled="">Seleccione</option>
								<?php
								$tabla = 'uso_predio';
								$registros = ControladorPredio::ctrMostrarData($tabla);
								foreach ($registros as $data_d) {
									echo "<option value='" . $data_d['Id_Uso_Predio'] . "'>" . $data_d['Uso'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<!-- ESTADO PREDIO -->
					<div class="row">
						<div class="col-5 col-md-5">
							<label for="estadoPredio" class="cajalabel2"> Estado del Predio</label>
						</div>
						<div class="col-6 col-md-6">
							<select class="form-control" name="estadoPredio" required="" id="estadoPredio">
								<option value="" selected="" disabled="">Seleccione</option>
								<?php
								$tabla = 'estado_predio';
								$registros = ControladorPredio::ctrMostrarData($tabla);
								foreach ($registros as $data_d) {
									echo "<option value='" . $data_d['Id_Estado_Predio'] . "'>" . $data_d['Estado'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<!-- GIRO ESTABLECIMIENTO -->
					<div class="row">
						<div class="col-5 col-md-5">
							<label for="giroPredio" class="cajalabel2"> Giro Establec.</label>
						</div>
						<div class="col-6 col-md-6">
							<select class="form-control" name="giroPredio" id="giroPredio">
								<option value="" selected="" disabled="">Seleccione</option>
								<?php
								$tabla = 'giro_establecimiento';
								$registros = ControladorPredio::ctrMostrarData($tabla);
								foreach ($registros as $data_d) {
									echo "<option value='" . $data_d['Id_Giro_Establecimiento'] . "'>" . $data_d['Nombre'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<!-- CONDICION DEL PREDIO  -->
					<div class="row">
						<div class="col-5 col-md-5">
							<label for="condicionPredio" class="cajalabel2"> Cond. Predio</label>
						</div>
						<div class="col-6 col-md-6">
							<select class="form-control" name="condicionPredio" required="" id="condicionPredio">
								<option value="" selected="" disabled="">Seleccione</option>
								<?php
								$tabla = 'condicion_predio';
								$registros = ControladorPredio::ctrMostrarData($tabla);
								foreach ($registros as $data_d) {
									echo "<option value='" . $data_d['Id_Condicion_Predio'] . "'>" . $data_d['Condicion'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<!--FECHA DE ADQUICISION-->
					<div class="row">
						<div class="col-5 col-md-5">
							<label for="fechaAdqui" class="cajalabel2">Fecha Adquisicion</label>
						</div>
						<div class="col-6 col-md-6">
							<input type="date" class="form-control" name="fechaAdqui" id="fechaAdqui">
						</div>
					</div>

				</div>
			</section>
			<!-- Fin Parametros de Predio Urbano-->

			<!-- Regimen de Predio Urbano-->
			<section class="container-fluid panel-medio col-xs-4" id="descripcionPredioU_regimen">
				<div class="box container-fluid">
					<div class="text-bordeada">
						Regimen y Arbitrios
					</div>
					<div class="row">
						<div class="col-5 col-md-5">
							<label for="regInafecto" class="cajalabel2"> Reg. Inafecto</label>
						</div>
						<div class="col-6 col-md-6">
							<select class="form-control" name="regInafecto" id="regInafecto">
								<option value="" selected="" disabled="">Seleccione</option>
								<?php
								$tabla = 'regimen_afecto';
								$registros = ControladorPredio::ctrMostrarData($tabla);
								foreach ($registros as $data_d) {
									echo "<option value='" . $data_d['Id_Regimen_Afecto'] . "'>" . $data_d['Regimen'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<!-- ENTRADA REGIMEN AFECTACION POR COMPAÑIA -->
					<div class="row">
						<div class="col-5 col-md-5">
							<label for="afecto" class="cajalabel2"> Inafecto</label>
						</div>
						<div class="col-6 col-md-6">
							<select class="form-control" name="afecto" id="afecto">
								<option value="" selected="" disabled="">Seleccione</option>
								<?php
								$tabla = 'inafecto';
								$registros = ControladorPredio::ctrMostrarData($tabla);
								foreach ($registros as $data_d) {
									echo "<option value='" . $data_d['Id_inafecto'] . "'>" . $data_d['Inafectacion'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<!--AFECTACION ARBITRIOS-->
					<div class="row">
						<div class="col-5 col-md-5">
							<label for="afectacionArb" class="cajalabel2">Afectacion Arbitrios</label>
						</div>
						<div class="col-6 col-md-6">
							<select class="form-control" name="afectacionArb" required="" id="afectacionArb">
								<option value="" selected="" disabled="">Seleccione</option>
								<?php
								$tabla = 'arbitrios';
								$registros = ControladorPredio::ctrMostrarData($tabla);
								foreach ($registros as $data_d) {
									echo "<option value='" . $data_d['Id_Arbitrios'] . "'>" . $data_d['Categoria'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<!--EXPEDIENTE -->
					<div class="row">
						<div class="col-5 col-md-5">
							<label for="nroExpediente" class="cajalabel2">N° Expediente</label>
						</div>
						<div class="col-6 col-md-6">
							<input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form-control" name="nroExpediente" id="nroExpediente" maxlength="10" placeholder="N° Expediente">
						</div>
					</div>
					<!--FECHA DE INICIO-->
					<div class="row">
						<div class="col-5 col-md-5">
							<label class="cajalabel2">Fecha Inicio</label>
						</div>
						<div class="col-6 col-md-6">
							<label id="fechaIniU">-</label>
						</div>
					</div>
					<!--FECHA DE FINALIZA-->
					<div class="row">
						<div class="col-5 col-md-5">
							<label class="cajalabel2">Fecha Finaliza</label>
						</div>
						<div class="col-6 col-md-6">
							<label id="fechaFinU">-</label>
						</div>
					</div>
					<div class="row">
						<div class="col-3 col-md-3 obs">
							<label for="observacion" class="cajalabel2">Obervaciones</label>
						</div>
						<div class="col-9 col-md-9 obs">
							<input class="form-control" type="text" pattern="[A-Za-z0-9\s:.\-]+" title="Solo se permiten letras" name="observacion" id="observacion" maxlength="70">
						</div>
					</div>

				</div>
			</section>
			<!-- Fin Regimen de Predio Urbano-->

			<!-- Parametros de Predio Rustico-->
			<section class="container-fluid panel-medio  col-lg-4 col-xs-4" id="descripcionPredioR_parametro">
				<div class="box container-fluid">
					<caption>Parametros Rusticos</caption>

					<!-- ENTRADA AREA TERRENO-->
					<div class="row">
						<label for="areaTerrenoR" class="cajalabel2">Area (Hectareas)</label>
						<input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form2zws" name="areaTerrenoR" id="areaTerrenoR" maxlength="5" required="">
					</div>
					<!-- VALOR ARANCEL-->

					<div class="row">
						<label for="" class="cajalabel2">Valor Arancel</label>
						<label id="valorArancelR">-</label>
					</div>
					<!-- VALOR TERRENO-->

					<div class="row">
						<label class="cajalabel2">Valor Terreno</label>
						<label id="valorTerrenoR">-</label>
					</div>
					<!-- VALOR PREDIO POR AÑO-->

					<div class="row">
						<label for="" class="cajalabel2">Valor Año 2023</label>
						<label id="valorPredioRAnio">-</label>
					</div>
					<!--FECHA DE INICIO-->

					<div class="row">
						<label class="cajalabel2">Fecha Inicio</label>
						<label id="fechaInR">-</label>
					</div>
					<!--FECHA DE FINALIZA-->

					<div class="row">
						<label class="cajalabel2">Fecha Finaliza</label>
						<label id="fechaFinR">-</label>
					</div>
				</div>
			</section>
			<!-- Fin Parametros de Predio Rustico-->

			<!-- Descripcion de Predio Rustico-->
			<section class="container-fluid panel-medio col-lg-4 col-xs-4" id="descripcionPredioR_desc">
				<div class="box container-fluid">
					<cAPTIon>Descripcion del Predio</cAPTIon>
					<!-- TIPO PREDIO   -->
					<div class="row">
						<label for="tipoPredioR" class="cajalabel2"> Tipo Predio</label>
						<select class="form2" name="tipoPredioR" id="tipoPredioR">
							<option value="" selected="" disabled="">Seleccione</option>
							<?php
							$tabla = 'tipo_predio';
							$registros = ControladorPredio::ctrMostrarDataItems($tabla);
							foreach ($registros as $data_d) {
								echo "<option value='" . $data_d['Id_Tipo_Predio'] . "'>" . $data_d['Tipo'] . '</option>';
							}
							?>
						</select>
					</div>
					<!-- USO PREDIO    -->
					<div class="row">
						<label for="usoPredioR" class="cajalabel2"> Uso Predio</label>
						<select class="form2" name="usoPredioR" id="usoPredioR">
							<option value="" selected="" disabled="">Seleccione</option>
							<?php
							$tabla = 'uso_predio';
							$registros = ControladorPredio::ctrMostrarData($tabla);
							foreach ($registros as $data_d) {
								echo "<option value='" . $data_d['Id_Uso_Predio'] . "'>" . $data_d['Uso'] . '</option>';
							}
							?>
						</select>
					</div>
					<!-- ESTADO PREDIO -->
					<div class="row">
						<label for="estadoPredioR" class="cajalabel2"> Estado del Predio</label>
						<select class="form2" name="estadoPredioR" required="" id="estadoPredioR">
							<option value="" selected="" disabled="">Seleccione</option>
							<?php
							$tabla = 'estado_predio';
							$registros = ControladorPredio::ctrMostrarData($tabla);
							foreach ($registros as $data_d) {
								echo "<option value='" . $data_d['Id_Estado_Predio'] . "'>" . $data_d['Estado'] . '</option>';
							}
							?>
						</select>
					</div>
					<!-- CONDICION DEL PREDIO  -->
					<div class="row">
						<label for="condicionPredioR" class="cajalabel2"> Cond. Propietario
						</label>
						<select class="form2" name="condicionPredioR" required="" id="condicionPredioR">
							<option value="" selected="" disabled="">Seleccione</option>
							<?php
							$tabla = 'condicion_predio';
							$registros = ControladorPredio::ctrMostrarData($tabla);
							foreach ($registros as $data_d) {
								echo "<option value='" . $data_d['Id_Condicion_Predio'] . "'>" . $data_d['Condicion'] . '</option>';
							}
							?>
						</select>
					</div>
					<!--FECHA DE ADQUICISION-->
					<div class="row">
						<div class="form-group">
							<label for="fechaAdquiR" class="cajalabel2">Fecha Adquisicion</label>
							<input type="date" class="form2" name="fechaAdquiR" id="fechaAdquiR">
						</div>
					</div>
				</div>
			</section>
			<!-- Fin descripcion de Predio Rustico-->

			<!-- Regimen de Predio Rustico-->
			<section class="container-fluid panel-medio col-lg-4 col-xs-4" id="descripcionPredioR_regimen">
				<div class="box container-fluid">
					<div class="row">
						<label for="regInafectoR" class="cajalabel2"> Reg. Inafecto</label>
						<select class="form2" name="regInafectoR" id="regInafectoR">
							<option value="" selected="" disabled="">Seleccione</option>
							<?php
							$tabla = 'regimen_afecto';
							$registros = ControladorPredio::ctrMostrarData($tabla);
							foreach ($registros as $data_d) {
								echo "<option value='" . $data_d['Id_Regimen_Afecto'] . "'>" . $data_d['Regimen'] . '</option>';
							}
							?>
						</select>
					</div>
					<!-- ENTRADA REGIMEN AFECTACION POR COMPAÑIA -->
					<div class="row">
						<label for="inafectoRpor" class="cajalabel2"> Inafecto</label>
						<select class="form2" name="inafectoRpor" required="" id="inafectoRpor">
							<option value="" selected="" disabled="">Seleccione</option>
							<?php
							$tabla = 'inafecto';
							$registros = ControladorPredio::ctrMostrarData($tabla);
							foreach ($registros as $data_d) {
								echo "<option value='" . $data_d['Id_inafecto'] . "'>" . $data_d['Inafectacion'] . '</option>';
							}
							?>
						</select>
					</div>
					<div class="row">
						<label for="tipoTerrenoR" class="cajalabel2"> Tipo Terreno</label>
						<select class="form2" name="tipoTerrenoR" required="" id="tipoTerrenoR">
							<option value="" selected="" disabled="">Seleccione</option>
							<?php
							$tabla = 'tipo_terreno';
							$registros = ControladorPredio::ctrMostrarData($tabla);
							foreach ($registros as $data_d) {
								echo "<option value='" . $data_d['Id_Tipo_Terreno'] . "'>" . $data_d['Tipo_Terreno'] . '</option>';
							}
							?>
						</select>
					</div>
					<div class="row">
						<label for="usoTerrenoR" class="cajalabel2"> Uso Terreno</label>
						<select class="form2" name="usoTerrenoR" required="" id="usoTerrenoR">
							<option value="" selected="" disabled="">Seleccione</option>
							<?php
							$tabla = 'uso_terreno';
							$registros = ControladorPredio::ctrMostrarData($tabla);
							foreach ($registros as $data_d) {
								echo "<option value='" . $data_d['Id_Uso_Terreno'] . "'>" . $data_d['Uso_Terreno'] . '</option>';
							}
							?>
						</select>
					</div>
					<!--EXPEDIENTE -->
					<div class="row">
						<div class="form-group">
							<label for="nroExpedienteR" class="cajalabel2">#Expediente</label>
							<input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form2" name="nroExpedienteR" id="nroExpedienteR" maxlength="10">
						</div>
					</div>


					<div class="row">
						<label for="observacionR" class="cajalabel2">Obervaciones</label>
						<input style="width: 50%;" type="text" pattern="[A-Za-z0-9\s:.\-]+" title="Solo se permiten letras" name="observacionR" id="observacionR" maxlength="70">
					</div>

				</div>
			</section>
			<!-- Fin Regimen de Predio Rustico-->

		</section>
		<!-- FIN SECCION DE PARAMETROS-->

		<div class="text-center">
			<button type="button" class="btn btn-primary" id="btnGuardarPredio">Guardar Predio</button>
		</div>

	</form>
</div>


<!-- MODAL BUSCAR UBICACION PREDIO URBANO-->
<div class="modal" id="modalViacalle_Predio">
	<div class="modal-dialog modal-lg ">
		<div class="modal-content ">
			<div class="modal-header">
				<caption>UBICACION DE PREDIO URBANO</caption>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="contenedor-busqueda">
						<div class="input-group-search">
							<div class="input-search">
								<input type="search" class="search_direccion" id="searchViacallePredio" name="searchViacallePredio" placeholder="Ingrese Nombre de Via o Calle..." onkeyup="loadViacallePredio()">
								<input type="hidden" id="perfilOculto_predio" value="<?php echo $_SESSION['perfil'] ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 divvia_calle">
					<?php include_once "table-viacallePredio.php";  ?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="cancelarModal" class="btn btn-secondary btn-cancelar" data-dismiss="modal">Salir</button>
			</div>
		</div>
	</div>
</div>
<!-- Fin de Ubicacion de Predio Urbano-->

<!-- MODAL BUSCAR UBICACION PREDIO RUSTICO-->
<div class="modal" id="moda_PredioRustico">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<caption>UBICACION DE PREDIO RUSTICO</caption>
			</div>
			<div class="modal-body">
				<div class="col-12">
					<?php include_once "table-viaPredioRustico.php";  ?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="cancelarModal" class="btn btn-secondary btn-cancelar" data-dismiss="modal">Salir</button>
			</div>
		</div>
	</div>
</div>
<!-- fin MODAL BUSCAR UBICACION PREDIO RUSTICO-->

<!-- MODAL BUSCAR PROPIETARIO-->
<div class="modal" id="modalPropietarios">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<caption>BUSCAR PROPIETARIO</caption>
			</div>
			<div class="modal-body">
				<div class="col-12">
					<?php include_once "table-propietarios.php";  ?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="cancelarModal" class="btn btn-secondary btn-cancelar" data-dismiss="modal">Salir</button>
				<button type="button" class="btn btn-primary btn-guardar" data-dismiss="modal">Guardar</button>
			</div>
		</div>
	</div>
</div>
<!-- fin MODAL BUSCAR PROPIETARIO-->
<div id="respuestaAjax_correcto"></div>
<div class="resultados"></div>