<?php

use Controladores\ControladorContribuyente;
?>
<div class="content-wrapper panel-medio-principal">
	<section class="container-fluid panel-medio">
		<div class="box container-fluid" style="border:0px; margin:0px; padding:0px;">
			<div class="col-lg-12 col-xs-12">
				<div>
					<h6>Contribuyentes para cobro de Impuesto y Arbitrios -Caja</h6>
				</div>
			</div>
		</div>
	</section>
	<section class="container-fluid panel-medio">
		<div class="box rounded">
			<div class="box-body table-user">
				<div class="contenedor-busqueda">
					<div class="input-group-search">
						<div class="input-search">
							<input type="search" class="search_codigo" id="searchContribuyente_caja" name="searchContribuyente_caja" placeholder="Codigo" onkeyup="loadContribuyente_caja(1,'search_codigo','caja')">
							<input type="search" class="search_dni" id="searchContribuyente_caja" name="searchContribuyente_caja" placeholder="Documento DNI" onkeyup="loadContribuyente_caja(1,'search_dni','caja')">
							<input type="search" class="search_nombres" id="searchContribuyente_caja" name="searchContribuyente_caja" placeholder="Nombres y Apellidos" onkeyup="loadContribuyente_caja(1,'search_nombres','caja')">
							<input type="search" class="search_codigo_sa" id="searchContribuyente_caja" name="searchContribuyente_caja" placeholder="Codigo SIAT" onkeyup="loadContribuyente_caja(1,'search_codigo_sa','caja')">
							<input type="hidden" id="perfilOculto_c" value="<?php echo $_SESSION['perfil'] ?>">
						</div>
						<br>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table-container" width="100%">
					<thead>
						<tr>
							<th class="text-center" style="width:10px;">#</th>
							<th class="text-center">Codigo</th>
							<th class="text-center">Tipo</th>
							<th class="text-center">DNI</th>
							<th class="text-center">Nombres</th>
							<th class="text-center">Direccion Fiscal</th>
							<th class="text-center">Estado</th>
							<th class="text-center">SIAT</th>
							<th class="text-center" width="150px">Acciones</th>
						</tr>
					</thead>
					<tbody class='body-contribuyente-caja'>
						<!--contenido dinamico lista contribuyente caja -->
					</tbody>
				</table>
			</div>

	</section>
</div>
<!--=============== MODAL EDITAR CONTRIBUYENTE===============-->
<div id="modalEditarcontribuyente" class="modal fade modal-forms  fullscreen-modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<form role="form" id="formEmpresa" method="post" enctype="multipart/form-data">
				<input type="hidden" name="idc" id="idc">
				<div class="modal-header" style="background:#3c8dbc; color:white">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h6 class="modal-title">EDITAR CONTRIBUYENTE</h6>
				</div>
				<div class="modal-body">
					<!-- PRIMERA PARTE FORMULARIO-->
					<div class="box-body">
						<legend class="text-bold" style="margin-left:10px;margin-bottom:10px ; font-size:1.3em; letter-spacing: 1px;">DATOS DEl CONTRIBUYENTE:</legend>
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="lbl-text">Tipo Documento</label>
								<div class="input-group">
									<span class="input-group-addon iconos-fas"><i class="fa fa-address-card"></i></span>
									<select class="form-control" name="e_tipoDoc" id="e_tipoDoc">
										<?php
										$tabla_documento = 'tipo_documento_siat';
										$documento = ControladorContribuyente::ctrMostrarData($tabla_documento);
										foreach ($documento as $data_d) {
											echo "<option value='" . $data_d['Id_Tipo_Documento'] . "'>" . $data_d['descripcion'] . '</option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="" class="lbl-text">N° Documento</label>
								<div class="input-group">
									<span class="input-group-addon btn buscarRuc iconos-fas"><i class="fa fa-search "></i></span>
									<input type="text" class="form-control" id="e_docIdentidad" name="e_docIdentidad" placeholder="Número de documento...">
								</div>
							</div>
						</div>
						<div class="col-md-3 col-xs-6">
							<div class="form-group">
								<label for="" class="lbl-text">Tipo Contribuyente</label>
								<div class="input-group">
									<span class="input-group-addon iconos-fas"><i class="fa fa-key iconos-fas"></i></span>
									<select class="form-control" name="e_tipoContribuyente" id="e_tipoContribuyente" value="">
										<?php
										$tabla_tipo = 'tipo_contribuyente';
										$tipo = ControladorContribuyente::ctrMostrarData($tabla_tipo);
										foreach ($tipo as $data_tipo) {
											echo "<option value='" . $data_tipo['Id_Tipo_Contribuyente'] . "'>" . $data_tipo['Tipo'] . '</option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<!-- CODIGO ANTIGUEO SIAT-->
						<div class="col-md-2">
							<div class="form-group">
								<label for="" class="lbl-text">Codigo Antiguo</label>
								<div class="input-group">
									<input type="text" class="form-control" id="e_codigo_sa" name="e_codigo_sa" placeholder="Codigo antiguo">
								</div>
							</div>
						</div>
						<!-- ENTRADA RAZON SOCIAL O NOMBRE -->
						<div class="col-md-6">
							<div class="form-group">
								<label for="" class="lbl-text">Nombre o Razon social</label>
								<div class="input-group-adddon">
									<input type="text" class="form-control" id="e_razon_social" name="e_razon_social" placeholder="Ingrese nombre o razón social...">
								</div>
							</div>
						</div>
						<!-- ENTRADA CLASIFICACION CONTRIBUYENTE-->
						<div class="col-md-4">
							<div class="form-group">
								<label for="" class="lbl-text">Clasificacion</label>
								<div class="input-group">
									<span class="input-group-addon iconos-fas"><i class="fa fa-key"></i></span>
									<select class="form-control" name="e_clasificacion" id="e_clasificacion" value="">
										<?php
										$tabla_cla = 'clasificacion_contribuyente';
										$clasificacion = ControladorContribuyente::ctrMostrarData($tabla_cla);
										foreach ($clasificacion as $data_cla) {
											echo "<option value='" . $data_cla['Id_Clasificacion_Contribuyente'] . "'>" . $data_cla['Clasificacion'] . '</option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<!-- ENTRADA APE. PATERNO-->
						<div class="col-md-6">
							<div class="form-group">
								<label for="" class="lbl-text">Apellido Paterno</label>
								<div class="input-group-adddon">
									<input type="text" class="form-control" id="e_apellPaterno" name="e_apellPaterno" placeholder="Ingrese Apellido Paterno ...">
									<!-- <span class="input-group-addon"></span>  -->
								</div>
							</div>
						</div>
						<!-- ENTRADA APE. MATERNO-->
						<div class="col-md-6">
							<div class="form-group">
								<label for="" class="lbl-text">Apellido Materno</label>
								<div class="input-group-adddon">
									<input type="text" class="form-control" id="e_apellMaterno" name="e_apellMaterno" placeholder="Ingrese Apellido Materno ...">
								</div>
							</div>
						</div>
						<!-- ENTRADA CONDICION DEL CONTRIBUYENTE-->
						<div class="col-md-4">
							<div class="form-group">
								<label for="" class="lbl-text">Condicion Contribuyente</label>
								<div class="input-group">
									<span class="input-group-addon iconos-fas"><i class="fa fa-key"></i></span>
									<select class="form-control" name="e_condicionContri" id="e_condicionContri" value="">
										<?php
										$tabla_cla = 'condicion_contribuyente';
										$clasificacion = ControladorContribuyente::ctrMostrarData($tabla_cla);
										foreach ($clasificacion as $data_cla) {
											echo "<option value='" . $data_cla['Id_Condicion_Contribuyente'] . "'>" . $data_cla['Condicion_Contribuyente'] . '</option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<!-- SEGUNDA ENTRADA FORM -->
					<div class="box-body">
						<div class="row nuevoVia">
							<!-- BOTTON PARA AGREGAR DOMICILIO-->

							<div class="flex">
								<button type="button" class="btn btn-primary pull-right btn-agregar-carrito" data-toggle="modal" data-target="#modalViascalles"><i class="fas fa-home fa-lg"></i>Ver Vias y/o Calles</button>
							</div>
							<legend class="text-bold" style="margin-left:10px; font-size:1.0em; letter-spacing: 1px;">DOMICILIO FISCAL</legend>
						</div>
						<div class="row">
							<div class="">
								<table class="" style="box-sizing: border-box;">
									<thead>
										<tr>
											<th>Nombre Via</th>
											<th>Manzana</th>
											<th>Cuadra</th>
											<th>Lado</th>
											<th>Zona</th>
											<th>Habilitacion</th>
											<th>Arancel</th>
											<th>Id Via</th>
											<th>Condición</th>
										</tr>
									</thead>
									<tbody id="itemsRC">
									</tbody>
								</table>
							</div>
						</div>
						<!-- Ingreso Numero Ubicacion-->
						<div class="col-md-1">
							<label for="" class="lbl-text">Numeracion</label>
							<div class="form-group">
								<input type="text" class="form-control" id="e_nroUbicacion" name="e_nroUbicacion" placeholder="Nro. Ubicacion...">
							</div>
						</div>
						<!-- Ingreso Numero Lote-->
						<div class="col-md-1">
							<label for="" class="lbl-text">N° Lote</label>
							<div class="form-group">
								<input type="text" class="form-control" id="e_nroLote" name="e_nroLote" placeholder="Nro. Lote ...">
							</div>
						</div>
						<!-- Ingreso Numero Departamento-->
						<div class="col-md-1">
							<label for="" class="lbl-text">N° Dept.</label>
							<div class="form-group">
								<input type="text" class="form-control" id="e_nroDepartamento" name="e_nroDepartamento" placeholder="Nro. Departamento...">
							</div>
						</div>
						<!-- Ingreso Numero Bloque-->
						<div class="col-md-1">
							<label for="" class="lbl-text">N° Bloque</label>
							<div class="form-group">
								<input type="text" class="form-control" id="e_nrobloque" name="e_nrobloque" placeholder="Nro. Bloque...">
							</div>
						</div>
						<!-- Ingreso Numero Bloque-->
						<div class="col-md-1">
							<label for="" class="lbl-text">N° Luz</label>
							<div class="form-group">
								<input type="text" class="form-control" id="e_nroLuz" name="e_nroLuz" placeholder="Nro. Recibo Luz...">
							</div>
						</div>
						<div class="col-md-5">
							<label for="" class="lbl-text">Referencia</label>
							<div class="form-group">
								<input type="text" class="form-control" id="e_referencia" name="e_referencia" placeholder="Referencia...">
							</div>
						</div>
						<!-- ENTRADA TIPO CONDICION PREDIO-->
						<div class="col-md-2 col-xs-3">
							<div class="form-group">
								<label for="" class="lbl-text">Condicion Propietario</label>
								<div class="input-group">
									<span class="input-group-addon iconos-fas"><i class="fa fa-key"></i></span>
									<select class="form-control" name="e_condicionpredio" id="e_condicionpredio" value="">
										<?php
										$tabla = 'condicion_predio_fiscal';
										$condicion = ControladorContribuyente::ctrMostrarData($tabla);
										foreach ($condicion as $data_c) {
											echo "<option value='" . $data_c['Id_Condicon_Predio_Fiscal'] . "'>" . $data_c['Descripcion'] . '</option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>

					</div>
					<!-- TERCERA ENTRADA FORM -->
					<div class="box-body">
						<legend class="text-bold" style="margin-left:10px;margin-bottom:10px ; font-size:1.3em; letter-spacing: 1px;">DATOS DE CONTACTO:</legend>
						<!-- ENTRADA TELEFONO-->
						<div class="col-md-2">
							<div class="form-group">
								<label for="" class="lbl-text">N° Celular</label>
								<div class="input-group-adddon">
									<input type="text" class="form-control" id="e_telefono" name="e_telefono" placeholder="Nro  Celular/Telefono...">
								</div>
							</div>
						</div>
						<!-- ENTRADA CORREO ELECTRONICO-->
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="lbl-text">Correo</label>
								<div class="input-group-adddon">
									<input type="text" class="form-control" id="e_correo" name="e_correo" placeholder="Correo Electronico...">
								</div>
							</div>
						</div>
						<!-- ENTRADA OBSERVACIONES-->
						<div class="col-md-7">
							<div class="form-group">
								<label for="" class="lbl-text">Observaciones</label>
								<div class="input-group-adddon">
									<input type="text" class="form-control" id="e_observacion" name="e_observacion" placeholder="Observacioenes...">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<label class="btn btn-danger pull-left" data-dismiss="modal"><i class="far fa-times-circle fa-lg"></i> Salir</label>
					<button type="sudmit" class="btn btn-primary">Guardar cambios</button>
				</div>
				
			</form>
		</div>
	</div>
</div>
<!--==========   FIN DEL MODAL EDITAR CONTRIBUYENTE =======================-->
<!-- <div id="resultados"></div> -->
<?php
$eliminarProducto = new ControladorContribuyente();
$eliminarProducto->ctrEliminarContribuyente();
?>
<!-- Modal AGGREGAR DOMICILIO -->
<div class="modal fade bd-example-modal-lg" id="modalViascalles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			<div class="modal-body">
				<div class="col-12">
					<?php include_once "table-viacalle.php";  ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-times-circle fa-lg"></i> Cerrar</button>
					<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Seleccionar propietario -->
<?php include_once "modal_predio_propietario.php";  ?>
<!-- Modal Seleccionar propietario -->