<?php

use Controladores\ControladorContribuyente;
?>
<!-- INICIO CONTENIDO  -->
<div class="content-wrapper panel-medio-principal">
	<!------------- FORMULARIO ---------------->
	<form class="formRegContribuyente" id="formRegContribuyente">
		<section class="container-fluid panel-medio">
			<div class="box container-fluid">
				<!-- DATOS DEL CONTRIBUYENTE-->
				<div class="text-bordeada">
					Registrar Contribuyente
				</div>

				<div class="row">
					<div class="col-md-10">
						<div class="col-md-10">

							<div class="col-md-4">
								<div class="form-group">
									<label class="cajalabel12">Tipo Documento</label>
									<select class="form-control" name="tipoDoc" id="tipoDoc">
										<option value="" disabled="" selected="">Selecionar Tipo Documento</option>
										<?php
										$tabla_documento = 'tipo_documento_siat';
										$documento = ControladorContribuyente::ctrMostrarData($tabla_documento);
										foreach ($documento as $data_d) {
											echo "<option value='" . $data_d['Id_Tipo_Documento'] . "'>" . $data_d['descripcion'] . '</option>';
										}
										?>
									</select>
									<span id="errorTxt" class="error"></span>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label class="cajalabel12">N° Documento</label>
									<input class="form-control" id="docIdentidad" name="docIdentidad" title="Sólo se permiten números" placeholder="Número de documento..." required maxlength="11" minlength="8" disabled="">
									<span id="errorTxt" class="error"></span>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label class="cajalabel12">Cod.Antiguo</label>
									<input type="text" class="form-control" id="codigo_sa" name="codigo_sa" placeholder="Codigo antiguo" maxlength="6">
								</div>
							</div>

						</div>
					</div>
					<!-- Seccion de nombre-->
					<div class="col-md-10">
						<div class="col-md-5">

							<div class="col-md-10">
								<div class="form-group">
									<label for="" class="cajalabel12"> Nombre/Rz. Social</label>
									<input type="" class="form-control" id="razon_social" name=" razon_social" placeholder="Ingrese nombre o razón social...">
								</div>
							</div>

							<div class="col-md-10">
								<div class="form-group">
									<label for="" class="cajalabel12"> Apellido Paterno</label>
									<input type="text" class="form-control" id="apellPaterno" name="apellPaterno" placeholder="Ingrese Apellido Paterno ..." disabled>
								</div>
							</div>

							<div class="col-md-10">
								<div class="form-group">
									<label for="" class="cajalabel12"> Ape. Materno</label>
									<input type="text" class="form-control" id="apellMaterno" name="apellMaterno" placeholder="Ingrese Apellido Materno ..." disabled>
								</div>
							</div>

						</div>
						<!-- fin seccion de nombre-->

						<div class="col-md-5">
							<div class="col-md-8">
								<div class="form-group">
									<label class="cajalabel12">Condicion Contribuyente</label>
									<select class="form-control" name="condicionContri" id="condicionContri" value="">
										<option value="" disabled="" selected="">Condicion Especial Contribuyente</option>
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

							<div class="col-md-8">
								<div class="form-group">
									<label class="cajalabel12" for="">Clasificacion</label>
									<select class="form-control" name="clasificacion" id="clasificacion" value="">
										<option value="" disabled="" selected="">Selecionar Clasificacion</option>
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

							<div class="col-md-8">
								<div class="form-group">
									<label class="cajalabel12">Tipo Contribuyente</label>
									<select class="form-control" name="tipoContribuyente" id="tipoContribuyente" value="">
										<option value="" disabled="" selected="">Tipo Contribuyente</option>
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
            
					</div>

				</div>
		</section>
		<!-- Ubigeo del contribuyente-->
		<section class="container-fluid panel-medio">
			<div class="box container-fluid">
				<div class="text-bordeada">
					Ubigeo del Contribuyente
				</div>
				<div class="row nuevoVia col-md-5">

					<div class="items-c">
						<table class="table-container">
							<thead>
								<tr>
									<th class="text-center">Nombre Via</th>
									<th class="text-center">Manzana</th>
									<th class="text-center">Cuadra</th>
									<th class="text-center">Zona</th>
									<th class="text-center">Habilitacion</th>
									<th class="text-center">Arancel</th>
									<th class="text-center">Cod. Via </th>
								</tr>
							</thead>
							<tbody id="itemsRC">
							</tbody>
						</table>
						<div class="boton-propietario">
							<button type="button" class="btn btn-secundary btn-1" data-toggle="modal" data-target="#modalViascalles">Dirección Fiscal</button>
						</div>
					</div>
				</div>

				<div class="row col-md-7">
					<div class="row col-md-3">

						<div class="row">
							<div class="form-group">
								<label class="cajalabel12">N° Ubicación</label>
								<input type="text" class="form-control" id="nroUbicacion" name="nroUbicacion" placeholder="Nro. Ubicacion..." maxlength="5" required>
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label class="cajalabel12">N° Lote</label>
								<input type="text" class="form-control" id="nroLote" name="nroLote" placeholder="Nro. Lote ..." maxlength="5" >
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label class="cajalabel12">N°. Bloque</label>
								<input type="text" class="form-control" id="nrobloque" name="nrobloque" placeholder="Nro. Bloque..." maxlength="5" >
							</div>
						</div>

					</div>


					<div class="row col-md-3">
						<div class="row">
							<div class="form-group">
								<label class="cajalabel12">N° Departamento</label>
								<input type="text" class="form-control" id="nroDepartamento" name="nroDepartamento" placeholder="Nro. Departamento..." maxlength="5" >
							</div>

						</div>

						<div class="row">
							<div class="form-group">
								<label class="cajalabel12">N° Luz</label>
								<input type="text" class="form-control" id="nroLuz" name="nroLuz" placeholder="Nro. Recibo Luz..." maxlength="10" >
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label class="cajalabel12">Condicion Predio</label>
								<select class="form-control" name="condicionpredio" id="condicionpredio" value="" >
									<option value="" disabled="" selected="">Condicion Predio</option>
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


					<div class="col-md-8">
						<div class="row">
							<div class="form-group">
								<label class="cajalabel12">Referencia</label>
								<input type="text" class="form-control" id="referencia" name="referencia" placeholder="Referencia...">
							</div>
						</div>
					</div>

				</div>
			</div>
		</section>
		<!-- fin Ubigeo del contribuyente-->
		<!-- Datos de Contacto-->
		<section class="container-fluid panel-medio">
			<div class="box container-fluid">
				<div class="text-bordeada">
					Datos de Contacto
				</div>
				<div class="col-md-8">
					<div class="col-md-3">
						<div class="form-group">
							<label class="cajalabel12">Celular</label>
							<input type="text" class="form-control" id="telefono" name="telefono" placeholder="Nro  Celular/Telefono..." maxlength="10">
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label class="cajalabel12">Correo</label>
							<input type="text" class="form-control" id="correo" name="correo" placeholder="Correo Electronico...">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="cajalabel12">Observaciones</label>
							<input type="text" class="form-control" id="observacion" name="observacion" placeholder="Observacioenes...">
						</div>
					</div>

				</div>


				<div class="box-footer">
					<div class="col-md-4">
					</div>
					<div class="col-md-4 text-center">
						<button class="btn btn-primary btn-1" type="button" id="btnRegistrarContribuyente"></i>REGISTRAR</button>
					</div>
					<div class="col-md-4"></div>
				</div>

			</div>
		</section>
	</form>
</div>
<!-- FIN CONTENIDO  -->

<!-- Modal AGGREGAR DOMICILIO -->
<div class="modal fade bd-example-modal-lg" id="modalViascalles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body">

				<div class="row">
					<!-- BUSQUEDA NOMBRE DE CALLE-->
					<div class="contenedor-busqueda">
						<div class="input-group-search">
							<div class="input-search">
								<input type="search" class="search_direccion" id="searchViacalle" name="searchViacalle" placeholder="Ingrese Nombre de Via o Calle..." onkeyup="loadViacalle(1,'#itemsRC')">
								<input type="hidden" id="perfilOculto_v" value="<?php echo $_SESSION['perfil'] ?>">
							</div>
						</div>
					</div>
				</div>

				<div class="col-12 table-responsive divDetallePredio">
					<?php include_once "table-viacalle.php";  ?>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
					<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
				</div>
			</div>
		</div>
	</div>
</div>

<div class="resultados"></div>
<!-- FIN MODAL -->