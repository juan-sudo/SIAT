<?php
use Controladores\ControladorTim;
?>
<div class="content-wrapper panel-medio-principal">
	<?php
	if ($_SESSION['perfil'] == 'Vendedor' || $_SESSION['perfil'] == 'Especial') {
		echo '
      <section class="container-fluid panel-medio">
        <div class="box alert-dangers text-center">
          <div>
          <h3> Área restringida, solo el administrador puede tener acceso</h3>
          </div>
          <div class="img-restringido">
          </div>
        </div>
      </div>';
	} else {
	?>
	
		<!----------- <section class="content"> ----->
		<section class="container-fluid panel-medio">
			<div class="box rounded">
				<div class="box-body table-responsive">
					<input type="hidden" id="perfilOculto" value="<?php echo $_SESSION['perfil'] ?>">
					<div class="col-mod-12">
					    <span class="caption_">Administración Tasa de Interes Moratorio</span>
						<?php
						if ($_SESSION['perfil'] == 'Administrador') {
						?>
							<button class="btn btn-secundary btn-1 pull-right" data-toggle="modal" data-target="#modalAgregarTasaInteresMoratorio">Nuevo T.I.M</button>
						<?php } ?>
					</div>
					<br>
					<div class="box div_1">
						<table class="table-container" width="100%">
							<thead>
								<tr>
									<th class="text-center" style="width:10px;">#</th>
									<th class="text-center">Año</th>
									<th class="text-center">Tasa</th>
									<th class="text-center">Acciones</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$item = null;
								$valor = null;
								$tasaTim = ControladorTim::ctrMostrarTim($item, $valor);
								foreach ($tasaTim as $key => $value) :
								?>
									<tr>
										<td class="text-center"><?php echo ++$key; ?></td>
										<td class="text-center"><?php echo $value['Anio']; ?></td>
										<td class="text-center"><?php echo $value['Porcentaje']; ?></td>
										<td class="text-center">
											<div class="btn-group">
												<img src='./vistas/img/iconos/edit2.png'  class="t-icon-tbl btnEditarTim" title='Editar' idUsuario="<?php echo $value['Id_TIM'] ?>" data-toggle="modal" data-target="#modalEditarTIM">
												<?php
												if ($_SESSION['perfil'] == 'Administrador') {
												?>
													<img src='./vistas/img/iconos/eli1.png' class="t-icon-tbl btnEliminarTim" title='Eliminar' idUsuario="<?php echo $value['Id_TIM'] ?>" usuario="<?php echo $value['Anio'] ?>">
												<?php } ?>
											</div>
										</td>
									</tr>
							<?php
								endforeach;
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>
</div>
<!--======== MODAL AGREGAR TIM ==============-->
<div id="modalAgregarTasaInteresMoratorio" class="modal fade modal-forms fullscreen-modal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<form role="form" id="formUser" class="form-inserta" enctype="multipart/form-data">
				<!--============== CABEZA DEL MODAL ===================-->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<caption>NUEVA TASA DE INTERES MORATORIO</caption>
				</div>
				<!--============== CUERPO DEL MODAL ==================-->
				<div class="modal-body">
					<div class="box-body">
						<div class="row">
							<div class="row">
								<!--INGRESO AÑO-->
								<div class="col-md-4">
									<div id="respuestaAjax"></div>
									<div class="form-group">
										<select class="form-control " name="anio" id="anio">
											<option value="" disabled="" selected="">Selecionar Año</option>
											<option value="2020">2020</option>
											<option value="2021">2021</option>
											<option value="2022">2022</option>
											<option value="2023">2023</option>
										</select>
									</div>
								</div>
								<!--INGRESO TASA-->
								<div class="col-md-4">
									<div class="form-group">
										<input type="number" class="form-control nuevoUser" name="tim" id="tim" placeholder=" % Tasa Interes Moratorio" required maxlength="5">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--============= PIE DEL MODAL =======================-->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">salir</button>
					<button type="submit" class="btn btn-primary btnusuario">Guardar</button>
				</div>
				<?php
				// $crearUsuario = ControladorUsuarios::ctrCrearUsuario();
				?>
			</form>
		</div>
	</div>
</div>
<!--======== MODAL EDITAR TIM ===============-->
<div id="modalEditarTIM" class="modal fade modal-forms fullscreen-modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<form role="form" method="post" enctype="multipart/form-data">
				<!--=========== CABEZA DEL MODAL ==========-->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<caption>EDITAR TASA DE INTERES MORATORIO</caption>
				</div>
				<!--=========== CUERPO DEL MODAL ===========-->
				<div class="modal-body">
					<div class="box-body">
						<div class="row">
							<!-- ENTRADA PARA EL NOMBRE -->
							<div class="col-md-4">
								<div id="respuestaAjax"></div>
								<div class="row">
									<div class="form-group">
										<select class="form-control " name="editar_anio" id="editar_anio">
											<option value="" disabled="" selected="">Selecionar Año</option>
											<option value="2020">2020</option>
											<option value="2021">2021</option>
											<option value="2022">2022</option>
											<option value="2023">2023</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<input type="hidden" class="form-control " id="ide" name="ide" value="">
								<div class="form-group">
									<input type="number" class="form-control nuevoUser" id="editar_tim" name="editar_tim" placeholder="Tasa Interes Moratorio" required>
								</div>
							</div>
							<!-- ENTRADA PARA SELECCIONAR SU PERFIL -->
						</div>
					</div>
				</div>
				<!--=======   PIE DEL MODAL =======-->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
$borrarUsuarios =  ControladorTim::ctrBorrarTim();
?>
<div class="resultados"></div>
<?php
$editarTim = new ControladorTim();
$editarTim->ctrEditarTim();
?>