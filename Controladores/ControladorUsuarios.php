<?php

namespace Controladores;

use Modelos\ModeloUsuarios;
use Controladores\ControladorEmpresa;
use Modelos\ModeloEmpresa;

class ControladorUsuarios
{
    // METODO PARA INGRESO DE USUARIO
    public  static function ctrIngresoUsuario($user, $pass)

    {
            if (empty($user) || empty($pass)) {
                echo '<br><div class="alert alert-danger">Usuario o contraseña no pueden estar vacíos</div>';
                echo "<script>grecaptcha.reset();</script>";
                exit;
            }

            // Buscar el usuario en la base de datos
            $tabla = "usuarios";
            $item = "usuario";
            $valor = $user;
            $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

            if ($respuesta === false) {
                // Manejar error en la consulta a la base de datos
                echo '<br><div class="alert alert-danger">Error - No tiene Acceso</div>';
                echo "<script>grecaptcha.reset();</script>";
                exit;
            }

            // Verificar usuario y contraseña
            if ($respuesta['usuario'] == $user && password_verify($pass, $respuesta['password'])) {
                if ($respuesta['estado'] == 1) {
                    // Iniciar sesión
                    session_start();
                    $_SESSION['tiempo'] = time();
                    $_SESSION['iniciarSesion'] = 'ok';
                    $_SESSION['id'] = $respuesta['id'];
                    $_SESSION['id_sucursal'] = $respuesta['id_empresa'];
                    $_SESSION['nombre'] = $respuesta['nombre'];
                    $_SESSION['dni'] = $respuesta['dni'];
                    $_SESSION['usuario'] = $respuesta['usuario'];
                    $_SESSION['foto'] = $respuesta['foto'];
                    $_SESSION['perfil'] = $respuesta['perfil'];
                    $_SESSION['area'] = $respuesta['area'];

                    echo "<script>window.location.href = 'inicio';</script>";
                    exit; // Asegurarse de que el script se detenga después de la redirección
                } else {
                    echo '<br><div class="alert alert-danger">El usuario está inactivo, contacta al administrador</div>';
                    echo "<script>grecaptcha.reset();</script>";
                }
            } else {
                echo '<br><div class="alert alert-danger">Usuario o contraseña incorrectos</div>';
                echo "<script>grecaptcha.reset();</script>";
            }

                    
    }

    // Mostrar Paginas del Menu de acuerdo a la base de datos
    public static function CntrMostrar_menu($iduser)
    {
            $respuesta = ModeloUsuarios::mdlMostrar_menu($iduser);
            return $respuesta;
    }

    // Mostrar Paginas del subMenu de acuerdo a la base de datos
    public static function CntrMostrar_submenu($iduser)
    {
            $respuesta = ModeloUsuarios::mdlMostrar_submenu($iduser);
            return $respuesta;
    }

    // Mostrar Paginas del subMenu lista de acuerdo a la base de datos
    public static function CntrMostrar_submenu_lista($idmenu)
    {
            $respuesta = ModeloUsuarios::mdlMostrar_submenu_lista($idmenu);
            return $respuesta;
    }

    // REGISTRO DE USUARIO
    public static function ctrCrearUsuario($datos)
    {

        $tabla = 'usuarios';
        $respuesta = ModeloUsuarios::mdlNuevoUsuario($tabla, $datos);

        if ($respuesta == 'ok') {
            $respuesta = array(
                "tipo" => "correcto",
                "mensaje" => '<div class="col-sm-30">
                <div class="alert alert-success">
                  <button type="button" class="close font__size-18" data-dismiss="alert">
                  </button>
                  <i class="start-icon far fa-check-circle faa-tada animated"></i>
                  <strong class="font__weight-semibold">Alerta!</strong>Se Registro correctanmente los datos del Usuario.
                </div>
              </div>'
            );
            return $respuesta;
        } else {
            $respuesta = array(
                'tipo' => 'advertencia',
                'mensaje' =>'<div class="col-sm-30">
                <div class="alert alert-warning">
                  <button type="button" class="close font__size-18" data-dismiss="alert">
                  </button>
                  <i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
                  <strong class="font__weight-semibold">Alerta!</strong>No se registro el Usuario, Comunicarce con el Administrador.
                </div>
              </div>'
            );
            return $respuesta;
        }
    }

    // MOSTRAR USUARIOS|
    public static function ctrMostrarUsuarios($item, $valor)
    {
        $value = ModeloUsuarios::mdlPerfil_Usuario($valor);
        if($value['perfil']!=='Administrador'){
            $tabla = 'usuarios';
            $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla,$item,$valor);
            if($respuesta['estado'] == 0){ 
              $estado="";
            } 
            else{ 
                $estado='checked'; 
            }
            echo '<tr>
            <td>1</td>
            <td>' .$respuesta['nombre'].'</td>
            <td>'.$respuesta['usuario'].'</td>
            <td>  <button class="btn btn-danger btnEliminarUsuario" idUsuario="'.$respuesta['id'].'" fotoUsuario="'.$respuesta['foto'].'" usuario="'.$respuesta['usuario'].'"><i class="fas fa-trash-alt"></i></button></td>
            <td>'. $respuesta['Nombre_Area'].'</td>


            <td>
              
             <input type="checkbox" data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger" id="" name="usuarioEstado'.$respuesta['estado'].'"  value="'. $respuesta['estado'].'" data-size="mini" data-width="110" idUsuario="'.$respuesta['id'].'"' .$estado.'>
             
          </td>
            
            
            
            <td>'. date_format(date_create($respuesta['ultimo_login']), 'd/m/Y H:i:s').'</td>
            <td>
              <div class="btn-group">

            <button class="btn btn-warning btnEditarUsuario" idUsuario="'. $respuesta['id'].'" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fas fa-user-edit"></i></button>';
          
            if($_SESSION['perfil'] == 'Administrador'){
              
           echo '<button class="btn btn-danger btnEliminarUsuario" idUsuario="' .$respuesta['id'].'" fotoUsuario="'.$respuesta['foto'].'" usuario="'. $respuesta['usuario'].'"><i class="fas fa-trash-alt"></i></button>';
              }

            echo '</div></td></tr>';
        }
        else{
            $tabla = 'usuarios';
            $usuarios = ModeloUsuarios::mdlMostrarUsuarios($tabla,NULL,NULL);
       
            foreach($usuarios as $key => $value):
                if($value['estado'] == 0){ 
                    $estado="";
                  } 
                  else{ 
                     $estado="checked"; 
                  }
            echo '<tr>
              <td><?php echo ++$key; ?></td>
              <td>'.$value['nombre'].'</td>
              <td>'.$value['usuario'].'</td>
              <td>  <button class="btn btn-danger btnPermiso" idUsuario="'. $value['id'].'" usuario="'. $value['usuario'].'" data-toggle="modal" data-target="#modalPermiso"><i class="fas fa-user-edit"></i></button></td>
             
              <td>'. $value['area'].'</td>
              <td>
                
              
               <input type="checkbox" data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" id="usuarioEstado" data-size="mini" data-width="110" idUsuario="'.$value['id'].'" '.$estado.'>
             
            </td>
              
              
             
              <td>'. date_format(date_create($value['ultimo_login']), 'd/m/Y H:i:s').'</td>
              <td>
                <div class="btn-group">

              <button class="btn btn-warning btnEditarUsuario" idUsuario="'.$value['id'].'" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fas fa-user-edit"></i></button>';
              if($value['perfil'] == 'Administrador'){
            
            echo '<button class="btn btn-danger btnEliminarUsuario" idUsuario="'.$value['id'].'" fotoUsuario="'.$value['foto'].'" usuario="'.$value['usuario'].'"><i class="fas fa-trash-alt"></i></button>';
              }
               echo '</div></td></tr>';

            endforeach;
             
        }
       
        
    }

   //Mostrando la informacion del usuario seleccionado
    public static function ctrMostrarUsuarios_seleccionado($idusuario)
    {
            $respuesta = ModeloUsuarios::mdlMostrarUsuarios_seleccionado($idusuario);
            return $respuesta;
       
    }

    // EDITAR USUARIOS|
    public static function ctrEditarUsuario()
    {

        if (isset($_POST["editarUsuario"])) {

            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])) {

                /*=============================================
				VALIDAR IMAGEN
				=============================================*/
                
                $tabla = "usuarios";

                if ($_POST["editarPassword"] != "") {

                    if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])) {

                        $encriptar = crypt($_POST['editarPassword'], '$2a$07$usesomesillystringforsalt$');
                    } else {

                        echo "<script>
                    Swal.fire({
                        title: '¡La contraseña no puede ir vacío o llevar caracteres especiales!',
                        text: '...',
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Cerrar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location = 'usuarios';
                        }
                    })</script>";
                    }
                } else {

                    $encriptar = $_POST["passwordActual"];
                }
                //session_start();
                $datos = array(
                    "nombre" => $_POST["editarNombre"],
                    "usuario" => $_POST["editarUsuario"],
                    "password" => $encriptar,
                    "perfil" => "Administrador",
                    'dni' => $_POST["editarDni"],
                    'email' => $_POST["editarEmail"],
                    "foto" => '',
                    "id_sucursal" => $_SESSION['id_sucursal'],
                    "id_area_e" => $_POST['id_area_e']
                );

                $respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);
                if ($respuesta == 'ok') {
                    $respuesta = array(
                        "tipo" => "correcto",
                        "mensaje" => '<div class="col-sm-30">
                        <div class="alert alert-success">
                          <button type="button" class="close font__size-18" data-dismiss="alert">
                          </button>
                          <i class="start-icon far fa-check-circle faa-tada animated"></i>
                          <strong class="font__weight-semibold">Alerta!</strong>Se Actualizo de correctanmente los datos del Usuario.
                        </div>
                      </div>'
                    );
                    return $respuesta;
                } else {
                    $respuesta = array(
                        'tipo' => 'advertencia',
                        'mensaje' =>'<div class="col-sm-30">
                        <div class="alert alert-warning">
                          <button type="button" class="close font__size-18" data-dismiss="alert">
                          </button>
                          <i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
                          <strong class="font__weight-semibold">Alerta!</strong>El Usuario no puede ir vacio o llevar caracteres especiales.
                        </div>
                      </div>'
                    );
                    return $respuesta;
                }
            }
        }
    }

    // BORRAR USUARIO
    public static function ctrBorrarUsuario()
    {
        if (isset($_GET['idUsuario'])) {
            $tabla = 'usuarios';
            $datos = $_GET['idUsuario'];
            if (file_exists($_GET['fotoUsuario'])) {

                unlink($_GET['fotoUsuario']);
                rmdir("vistas/img/usuarios/" . $_GET['usuario']);
            }
            $respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);
            if ($respuesta == 'ok') {

                echo "<script>
                        Swal.fire({
                        title: '¡El usuario ha sido eliminado!',
                        text: '...',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Cerrar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location = 'usuarios';
                        }
                    })
                    </script>";
            }
        }
    }

  

    // Lista Pagina
    public static function ctrLista_Pagina($datos)
    {
        

        $respuesta = ModeloUsuarios::MdlMostrar_Pagina($datos);
        $paginas = [];
        
        foreach ($respuesta as $row) {
            $idPagina = $row['Id_Pagina'];
            $idSubPagina = $row['Id_SubPagina'];
        
            if (!isset($paginas[$idPagina])) {
                $paginas[$idPagina] = [
                    'id' => $idPagina,
                    'nombre' => $row['Nombre_Pagina'],
                    'ruta' => $row['Ruta_Pagina'],
                    'tienePermiso' => $row['TienePermiso'],
                    'subpaginas' => []
                ];
            }
        
            if ($idSubPagina !== null) {
                $paginas[$idPagina]['subpaginas'][$idSubPagina] = [
                    'id' => $idSubPagina,
                    'nombre' => $row['Nombre_SubPagina'],
                    'ruta' => $row['Ruta_SubPagina'],
                    'tienePermiso' => $row['TienePermiso']
                ];
            }
        }
        
        // Función recursiva para construir la estructura de lista
        function construirLista($pagina, $esSubpagina = false) {
            $atributoId = $esSubpagina ? 'id_subpagina' : 'id_pagina';
        
            echo '<li ' . $atributoId . '="' . $pagina['id'] . '">';
            echo '<input type="checkbox" id="'. $pagina['id'] .'" name="permisos[]" value="' . $pagina['nombre'] . '" ' . ($pagina['tienePermiso'] || tieneSubpaginasActivas($pagina) ? 'checked' : '') . '>';
            echo $pagina['nombre'];
            
            // Verificar si hay subpáginas antes de imprimir la lista
            if (isset($pagina['subpaginas']) && !empty($pagina['subpaginas'])) {
                echo '<ul>';
                foreach ($pagina['subpaginas'] as $subpagina) {
                    construirLista($subpagina, true);
                }
                echo '</ul>';
            }
            
            echo '</li>';
        }
        
        // Función para verificar si hay subpáginas activas
        function tieneSubpaginasActivas($pagina) {
            if (isset($pagina['subpaginas']) && !empty($pagina['subpaginas'])) {
                foreach ($pagina['subpaginas'] as $subpagina) {
                    if ($subpagina['tienePermiso']) {
                        return true;
                    }
                }
            }
            return false;
        }
        
        // Mostrar la estructura de lista
        echo '<ul>';
        foreach ($paginas as $pagina) {
            construirLista($pagina);
        }
        echo '</ul>';


    }

    // Permiso Pagina
    public static function ctrPermiso_Pagina($datos)
    {
        $respuesta = ModeloUsuarios::MdlPermiso_Pagina($datos);
        if ($respuesta == 'ok') {
            $respuesta = array(
                "tipo" => "correcto",
                "mensaje" => '<div class="col-sm-30">
                <div class="alert alert-success">
                  <button type="button" class="close font__size-18" data-dismiss="alert">
                  </button>
                  <i class="start-icon far fa-check-circle faa-tada animated"></i>
                  <strong class="font__weight-semibold">Alerta!</strong>Se registro con exito las paginas y subpaginas.
                </div>
              </div>'
            );
            return $respuesta;
        } else {
            $respuesta = array(
                'tipo' => 'advertencia',
                'mensaje' =>'<div class="col-sm-30">
                <div class="alert alert-warning">
                  <button type="button" class="close font__size-18" data-dismiss="alert">
                  </button>
                  <i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
                  <strong class="font__weight-semibold">Alerta!</strong>Algo salio mal comunicarce con el Administrador.
                </div>
              </div>'
            );
            return $respuesta;
        }
    }  
    
    // Permiso Pagina
    public static function ctrUsuario_Permiso($datos)
    {
        $respuesta = ModeloUsuarios::MdlUsuario_Permiso($datos);
        return $respuesta;
    }  

}
