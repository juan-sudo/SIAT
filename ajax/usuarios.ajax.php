<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorUsuarios;
use Modelos\ModeloUsuarios;

class AjaxUsuarios
{
    //LOGIN USUARIOS
    public function ajaxLogin()
    {   
        $user =$_POST["ingUsuario"];
        $pass = $_POST["ingPassword"];
        $respuesta = ControladorUsuarios::ctrIngresoUsuario($user, $pass);
    }
    //AGREGAR USUARIOS
    public function ajaxAgregarUsuario()
    {
        if (isset($_POST["nuevoNombre"])) {
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"])) {
                $ruta = "";
                if (isset($_FILES["nuevaFoto"]["tmp_name"])) {
                    if (($_FILES["nuevaFoto"]["type"] == "image/jpeg") ||
                        ($_FILES["nuevaFoto"]["type"] == "image/jpg") ||
                        ($_FILES["nuevaFoto"]["type"] == "image/png")
                    ) {
                        //CARPETA DONDE SE GUARDARÁ LA IMAGEN
                        $directorio = "../vistas/img/usuarios/" . $_POST['nuevoUsuario'];
                        if (!file_exists($directorio)) {
                            mkdir($directorio, 0755, true);
                        }
                        $nombre_img = $_FILES['nuevaFoto']['name'];
                        $ruta = "vistas/img/usuarios/" . $_POST['nuevoUsuario'] . "/" . $nombre_img;
                        move_uploaded_file($_FILES['nuevaFoto']['tmp_name'], $directorio . "/" . $nombre_img);
                    }
                }
                $encriptar = crypt($_POST['nuevoPassword'], '$2a$07$usesomesillystringforsalt$');
                $datos = array(
                    'nombre' => $_POST["nuevoNombre"],
                    'usuario' => $_POST["nuevoUsuario"],
                    'password' => $encriptar,
                    'perfil' => 'Administrador',
                    'dni' => $_POST["Dni"],
                    'email' => $_POST["nuevoEmail"],
                    "foto" => '',
                    "id_sucursal" => $_SESSION['id_sucursal'],
                    "id_area" => $_POST['id_area']
                );
                $respuesta = ControladorUsuarios::ctrCrearUsuario($datos);
            } else {
                $respuesta = array(
                    'tipo' => 'advertencia',
                    'mensaje' =>'<div class="col-sm-30">
                    <div class="alert alert-warning">
                      <button type="button" class="close font__size-18" data-dismiss="alert">
                      </button>
                      <i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
                      <strong class="font__weight-semibold">Alerta!</strong>La contraseña no puede ir vacio.
                    </div>
                  </div>'
                );  
            }
            $respuesta_json = json_encode($respuesta);
			header('Content-Type: application/json');
			echo $respuesta_json;
        }
    }
    // EDITAR USARIO|
    public $idUsuario;

    public function ajaxEditarUsuario()
    {
        $item = 'id';
        $valor = $this->idUsuario;
        $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        echo json_encode($respuesta);
    }

    public function ajaxEditarUsuario_seleccionado()
    {
        $valor =$_POST['idUsuario_selet'];
        $respuesta = ControladorUsuarios::ctrMostrarUsuarios_seleccionado($valor);
        echo json_encode($respuesta);
    }
    // ACTIVAR USUARIO
    public $activarUsuario;
    public $activarId;

    public function ajaxActivarUsuario()
    {
        $tabla = 'usuarios';
        $item1 = 'estado';
        $valor1 = $this->activarUsuario;
        $item2 = 'id';
        $valor2 = $this->activarId;
        $respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
        echo $respuesta;
    }
    // VALIDAR NO REPETIR USUARIO
    public $validarUsuario;
    public function ajaxValidarUsuario()
    {
        $item = 'usuario';
        $valor = $this->validarUsuario;
        $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        echo json_encode($respuesta);
    }
   

    public function ajaxCerrarSesion()
    {
        $item = 'id';
        $valor = $_SESSION['id'];
        $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        if ($respuesta['estado'] != 1) {
            echo 'ok';
        }
    }

    //lista pagina
    public function ajaxLista_Pagina()
    {
        $datos = array(
            'idusuario' => $_POST["idusuario"]
        );
        $respuesta = ControladorUsuarios::ctrLista_Pagina($datos);
        echo $respuesta;
    }

    //permiso a paginas y subpaginas
    public function ajaxPermiso_Pagina()
    {
        $datos = array(
            'idpagina' => $_POST["idpagina"],
            'idsubpagina' => $_POST["idsubpagina"],
            'idusuario' => $_POST["idusuario"]
        );
        $respuesta = ControladorUsuarios::ctrPermiso_Pagina($datos);
			$respuesta_json = json_encode($respuesta);
			header('Content-Type: application/json');
			echo $respuesta_json;                                           
    }
    //mostrar informacion del usuario
    public function ajaxUsuario_Permiso()
    {
        $datos = array(
            'idusuario' => $_POST["idusuario"]
        );
        $respuesta = ControladorUsuarios::ctrUsuario_Permiso($datos);
        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;
    }
    //mostrar lista de usuarios
    public function ajaxLista_Usuarios()
    {   
        $item = 'id';
        $valor = $_POST["id_usuario"];
        $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
        echo $respuesta;
    }
    //mostrar lista de usuarios
    public function ajaxguardar_datos_editados()
    {   
        $respuesta = ControladorUsuarios::ctrEditarUsuario();
        $respuesta_json = json_encode($respuesta);
		header('Content-Type: application/json');
		echo $respuesta_json;   
    }
}
//OBJETO LOGIN USUARIOS
if (isset($_POST['ingUsuario'])) {
    $login = new AjaxUsuarios();
    $login->ajaxLogin();
}
// OBJETO AGREGAR USUARIO
if (isset($_POST['nuevoUsuario'])) {
    $nuevo = new AjaxUsuarios();
    $nuevo->ajaxAgregarUsuario();
}
// OBJETO EDITAR USUARIO
if (isset($_POST['idUsuario'])) {

    $editar = new AjaxUsuarios();
    $editar->idUsuario = $_POST['idUsuario'];
    $editar->ajaxEditarUsuario();
}
// Editar usuario seleccionado
if (isset($_POST['idUsuario_seleccionado'])) {

    $editar = new AjaxUsuarios();
    $editar->ajaxEditarUsuario_seleccionado();
}
// OBJETO ACTIVAR USUARIO
if (isset($_POST['activarUsuario'])) {

    $activarUsuario = new AjaxUsuarios();
    $activarUsuario->activarId = $_POST['activarId'];
    $activarUsuario->activarUsuario = $_POST['activarUsuario'];
    $activarUsuario->ajaxActivarUsuario();
}
// OBJETO VALIDAR NO REPETIR USUARIO
if (isset($_POST['validarUsuario'])) {
    $validarUsuario = new AjaxUsuarios();
    $validarUsuario->validarUsuario = $_POST['validarUsuario'];
    $validarUsuario->ajaxValidarUsuario();
}



if (isset($_POST['cerrarS'])) {
    $objCerras = new AjaxUsuarios();
    $objCerras->ajaxCerrarSesion();
}
//Lista de Pagina
if (isset($_POST['lista_pagina'])) {
    $objlistapagina = new AjaxUsuarios();
    $objlistapagina->ajaxLista_Pagina();
}
//Permiso de las  Paginas y subpaginas
if (isset($_POST['permiso_pagina'])) {
    $objlistapagina = new AjaxUsuarios();
    $objlistapagina->ajaxPermiso_Pagina();
}
//mostrar informacion del usuario para dar permiso
if (isset($_POST['usuario_permiso'])) {
    $objlistapagina = new AjaxUsuarios();
    $objlistapagina->ajaxUsuario_Permiso();
}
//mostrar lista de usuarios
if (isset($_POST['lista_usuarios'])) {
    $objlistapagina = new AjaxUsuarios();
    $objlistapagina->ajaxLista_Usuarios();
}
//guardar datos editar
if (isset($_POST['guardar_datos_editar'])) {
    $objlistapagina = new AjaxUsuarios();
    $objlistapagina->ajaxguardar_datos_editados();
}
