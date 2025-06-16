<?php
session_start();
//usando el nuevo disco
use Controladores\ControladorConfiguracion;

unset($_SESSION['carrito']);
unset($_SESSION['carritoC']);
unset($_SESSION['carritoG']);

if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {
	$configuracion = ControladorConfiguracion::ctrConfiguracion();
}
$configuracion = ControladorConfiguracion::ctrConfiguracion();
$tiem = time();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php
				$title = $configuracion['Nombre_Sistema'];
				echo $title;
				?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="icon" type="image/png" sizes="76x76" href="vistas/img/logo/<?php $logo = (isset($configuracion['logo'])) ? $configuracion['logo'] : 'logo.png';
																									echo $logo;
																									?>">
	<!-- Bootstrap 3.3.7  -->
	<link rel="stylesheet" href="vistas/pack/bower_components/bootstrap/dist/css2/bootstrap.min.css">
	<!-- Bootstrap 5.3.3
    <link rel="stylesheet" href="vistas/boss/style.css"> -->
	<!-- Font Awesome STYLO A ALGUNOS BOTONES -->
	<link href="vistas/pack/bower_components/toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
	<link href="vistas/pack/bower_components/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"> 
	<!-- Theme  PRINCIPAL style -->
	<link rel="stylesheet" href="vistas/pack/dist/css/AdminLTE.css">
	<!-- AQUI ES DONDE ESTA LOS ICONOS Y DEBO MODIFICAR-->
	<link rel="stylesheet" href="vistas/pack/bower_components/fontawesome-free/css/all.css">

	<link rel="stylesheet" href="vistas/css/form.css">

	<!-- BUSCADOR DE SELECT -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

	<!-- jQuery 3 -->
	<script src="vistas/pack/bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="vistas/pack/bower_components/bootstrap/dist/js2/bootstrap.min.js"></script>
	<!-- Bootstrap 5.3.3 
    <script src="vistas/boss/node_modules/bootstrap/dist/js/bootstrap.min.js"></script> -->
	<!-- AdminLTE App -->
	<script src="vistas/pack/dist/js/adminlte.js"></script>
	<script src="vistas/pack/plugins/sweetalert/sweetalert2.js"></script>

	<!-- InputMask -->

</head>

<body class="hold-transition skin-blue sidebar-mini">

	<?php
	if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {
		$tiempoSesion = 20 * 60000;
		echo '<div class="reload-all" id="reload-all"></div>';
		echo '<div class="flex super-contenedor">';
		/*=========   CABEZOTE   ====================*/
		include "modulos/header.php";
		/*=========   MENU       ================*/
		include "modulos/menu.php";
		/*=========   CONTENIDO  ==============*/
		if (isset($_GET["ruta"])) {

			$rutasValidas = array(
				"inicio" => "inicio.php",
				"usuarios" => "usuarios.php",
				"clasificadorMef" => "clasificadorMef.php",
				"viascalles" => "viascalles.php",
				"crear-guia" => "crear-guia.php",
				"reportes" => "reportes.php",
				"compensacion" => "compensacion.php",
				"empresa" => "empresa.php",
				"ver-guias" => "ver-guias.php",
				"especiesvaloradas" => "especiesvaloradas.php",
				"formulaimpuesto" => "formulaimpuesto.php",
				"girocomercial" => "girocomercial.php",
				"tasaInteresMoratorio" => "tasaInteresMoratorio.php",
				"registrar-contribuyente" => "registrar-contribuyente.php",
				"buscarcontribuyente" => "buscarcontribuyente.php",
				"registrar-prediourbano" => "registrar-prediourbano.php",
				"registrarprediourbano" => "registrarprediourbano.php",
				"listapredio" => "listapredio.php",
				"listapredioagua" => "listapredioagua.php",
				"reporte-coactivo" => "reporte-coactivo.php",
				"direccion" => "direccion.php",
				"proceso-calcular-impuesto" => "proceso-calcular-impuesto.php",
				"recaudacion-estadocuenta" => "recaudacion-estadocuenta.php",
				"recaudacion-lista-contribuyente" => "recaudacion-lista-contribuyente.php",
				"campana" => "campana.php",
				"buscarcontribuyente-caja" => "buscarcontribuyente-caja.php",
				"caja" => "caja.php",
				"licencia-agua" => "licencia-agua.php", 
				"reporte-general" => "reporte-general.php",
				"proveidos" => "proveidos.php",
				"proveidoslista" => "proveidoslista.php",
				"caja-proveido" => "caja-proveido.php",
				"arancel-vias" => "arancel-vias.php",
				"consulta-deuda-agua" => "consulta-deuda-agua.php",
				"lista-contribuyente-agua" => "lista-contribuyente-agua.php",
				"lista-agua-caja" => "lista-agua-caja.php",
				"caja-agua" => "caja-agua.php",
				"cuadre-tributos-agua" => "cuadre-tributos-agua.php",
				"cuadre-especievalorada" => "cuadre-especievalorada.php",
				"usuario-reporte-impuesto-arbitrios" => "usuario-reporte-impuesto-arbitrios.php",
				"Pagados-impuesto-arbitrios" => "Pagados-impuesto-arbitrios.php",
				"cierre-caja" => "cierre-caja.php",
				"reporte-ingreso-diario" => "reporte-ingreso-diario.php",
				"buscar-orden-pago" => "buscar-orden-pago.php",
				"extorno" => "extorno.php",
				"reimprimir" => "reimprimir.php",
				"multa-administrativa" => "multa-administrativa.php",
				"Prescripcion" => "prescripcion.php",
				"salir" => "salir.php"

			);

			$configuracion = null;
			$tiem = time();
			if (isset($_GET["ruta"]) && isset($rutasValidas[$_GET["ruta"]])) {
				$ruta = $_GET["ruta"];
				$configuracion = (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") ? ControladorConfiguracion::ctrConfiguracion() : null;
				// Incluye el archivo correspondiente a la ruta solicitada
				include "modulos/" . $rutasValidas[$ruta];
			} else {
				// Si la ruta no es válida, incluye el archivo de error 404
				include "modulos/404.php";
			}
		} else {
			include "modulos/inicio.php";
		}
		/*=============================================
    FOOTER   require_once('print/TCPDF-main/examples/tcpdf_include.php');
    =============================================*/
		include "modulos/footer.php";
		echo '</div>';
	} else {
		include "modulos/login.php";
	}
	$tiempo = time();
	?>
	<!--<div class="connection"></div> -->
	<!-- End custom js for this page-->

	<script src="vistas/js/general.js"></script>
	<script src="vistas/js/plantilla.js"></script>
	<script src="vistas/js/usuarios.js"></script>
	<script src="vistas/js/empresa.js?q=<?php echo $tiempo; ?>"></script>
	<script src="vistas/js/buscarcontribuyente.js"></script>
	<script src="vistas/js/clasificador.js"></script>
	<script src="vistas/js/especievalorada.js"></script>
	<script src="vistas/js/formulaimpuesto.js"></script>
	<script src="vistas/js/girocomercial.js"></script>
	<script src="vistas/js/tim.js"></script>
	<script src="vistas/js/viascalles.js"></script>
	<script src="vistas/js/registrarcontribuyente.js"></script>
	<script src="vistas/js/carpeta.js"></script> 
	<script src="vistas/js/predio.js"></script>
	<script src="vistas/js/pisos.js"></script>
	<script src="vistas/js/prediodetalle.js"></script>
	<script src="vistas/js/direccion.js"></script>
	<script src="vistas/js/recaudacion-estado-cuenta-timPOO.js"></script>
	<script src="vistas/js/controlPDF.js"></script>
	<script src="vistas/js/imprimirformato.js"></script>
	<script src="vistas/js/campana.js"></script>
	<script src="vistas/js/clasePredio.js"></script>
	<script src="vistas/js/caja.js"></script>
	<script src="vistas/js/proveido.js"></script>
	<script src="vistas/js/licenciaAgua.js"></script>
	<script src="vistas/js/permisopagina.js"></script>
	<script src="vistas/js/cajaproveido.js"></script>
	<script src="vistas/js/consultaDeudaAgua.js"></script>
	<script src="vistas/js/cajaagua.js"></script>
	<script src="vistas/js/cuadrecaja.js"></script>
	<script src="vistas/js/cuadreespeciecaja.js"></script>
	<script src="vistas/js/usuario_reporte_impuesto_arbitrios.js"></script>
	<script src="vistas/js/reportes.js"></script>
	<script src="vistas/js/coactivo.js"></script>
	<script src="vistas/js/cierrecaja.js"></script>
	<script src="vistas/js/extorno.js"></script>
	<script src="vistas/js/ordenpago.js"></script>
	<script src="vistas/js/reimprimir.js"></script>
	<script src="vistas/js/calcularimpuestoPOO.js"></script>
	<script src="vistas/js/foto.js"></script>
	<script src="vistas/js/prescripcion.js"></script>  
	<script src="vistas/js/reporteGeneral.js"></script> 

	<script>
  	$.fn.modal.Constructor.prototype.enforceFocus = function() {};
	</script>
	<!-- BUSCADOR DE SELECT -->
	 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	 
	<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> -->
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Invocamos cada 5 segundos ;)
			const milisegundos = 60 * 5000;
			setInterval(function() {
				// No esperamos la respuesta de la petición porque no nos importa
				fetch("vistas/modulos/sesion.php");
			}, milisegundos);
		});
		$(document).ready(function() {
			$(".reload-all").hide();
		})
		$(document).on('click', ".reload-all", function() {
			$(".reload-all").hide();
		})
	</script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>


    <div id="respuestaAjax_srm" ></div>


	<span  id="mySpan" iso='<?php echo $_SESSION['id']; ?>'></span>
	<span  id="mySpan_user" iso_usuario='<?php echo $_SESSION['usuario']; ?>'></span>
	<span  id="mySpan_area" iso_area='<?php echo $_SESSION['area']; ?>'></span>
</body>

</html>