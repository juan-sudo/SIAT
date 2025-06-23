<?php
session_start();
require_once("../../vendor/autoload.php");

use Conect\Conexion;

class DataTables
{

       /* buscar contribuyente MODO MOBIL */
    public function dtaContribuyenteM()
{
    $action = ($_REQUEST['action'] ?? null) ? $_REQUEST['action'] : '';
    if ($action == 'ajax') {
        $area_usuario = $_REQUEST['area_usuario'];
        $perfilUsuario = $_REQUEST['perfilOculto_c'];
        $tipoBusqueda = strtolower($_REQUEST['tipo']);
        $searchProducto = $_GET['searchContribuyente'];

        // Definir el campo de búsqueda basado en el tipo de búsqueda
        switch ($tipoBusqueda) {
            case 'search_codigo_m':
                $campoBusqueda = 'Id_Contribuyente';
                break;
            case 'search_dni_m':
                $campoBusqueda = 'Documento';
                break;
            case 'search_codigo_sa_m':
                $campoBusqueda = 'Codigo_sa';
                break;
            case 'search_direccion_m':
                    $campoBusqueda = 'Direccion_completo';
                 break;    
            default:
                $campoBusqueda = 'Nombre_Completo';
                break;
        }

        $sWhere = "";
        $idContribuyentesString = ""; // Variable para almacenar IDs separados por guiones

        if (!empty($searchProducto)) {
            if ($tipoBusqueda == 'search_codigo_m' || $tipoBusqueda == 'search_dni_m') {
                $sWhere = "WHERE $campoBusqueda = :searchProducto";
            } else if ($tipoBusqueda == 'search_nombres_m') {
                $sWhere = "WHERE $campoBusqueda LIKE :searchProducto";
                $searchProducto = "%$searchProducto%";
            }
            else if ($tipoBusqueda == 'search_direccion_m') {
                $sWhere = "WHERE $campoBusqueda LIKE :searchProducto";
                $searchProducto = "%$searchProducto%";
            }

            $pdo = Conexion::conectar();

            if ($tipoBusqueda == 'search_codigo_sa_m') {
                $stmt = $pdo->prepare("SELECT Concatenado_id FROM carpeta WHERE Codigo_Carpeta = :carpeta");
                $stmt->bindParam(":carpeta", $searchProducto);
                $stmt->execute();
                $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($registros)) {
                    $codigoCarpeta = $registros[0]['Concatenado_id'];
                    $codigosArray = explode('-', $codigoCarpeta);
                    $placeholders = implode(',', array_fill(0, count($codigosArray), '?'));
                    $sWhere = "WHERE c.Id_Contribuyente IN ($placeholders)";
                } else {
                    echo "<td colspan='12' style='text-align:center;'>El código de carpeta no se encontró</td>";
                    $pdo = null;
                    return;
                }
            }

            // Preparar y ejecutar la consulta principal
            $stmt = $pdo->prepare("SELECT 
                                    c.Id_Ubica_Vias_Urbano as ubicacionvia,
                                    c.Estado as Estado,
                                    c.Id_Contribuyente as id_contribuyente,
                                    td.descripcion as tipo_documento,
                                    c.Documento as documento,
                                    c.Nombre_Completo as nombre_completo,
                                    c.Direccion_completo as direccion_completo,
                                    c.Coactivo as coactivo
                                    FROM contribuyente c 
                                    INNER JOIN tipo_documento_siat td ON td.Id_Tipo_Documento = c.Id_Tipo_Documento
                                    $sWhere");

            if ($tipoBusqueda == 'search_codigo_sa_m') {
                $stmt->execute($codigosArray);
            } else {
                $stmt->execute(['searchProducto' => $searchProducto]);
            }

            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Construir la cadena con id_contribuyente separados por guiones
            if (!empty($registros)) {
                $idContribuyentes = array();
                foreach ($registros as $registro) {
                    $idContribuyentes[] = $registro['id_contribuyente'];
                }
                $idContribuyentesString = implode('-', $idContribuyentes);
            }

            // Obtener el Código_Carpeta y agregarlo a cada contribuyente
            if ($tipoBusqueda == 'search_codigo_sa' && !empty($codigosArray)) {
                foreach ($registros as &$contribuyente) {
                    $stmtCarpeta = $pdo->prepare("SELECT Codigo_Carpeta FROM carpeta WHERE Concatenado_id = :concatenado_id");
                    $stmtCarpeta->bindParam(":concatenado_id", $codigoCarpeta);
                    $stmtCarpeta->execute();
                    $carpetaResult = $stmtCarpeta->fetch(PDO::FETCH_ASSOC);

                    if ($carpetaResult) {
                        $contribuyente['Codigo_Carpeta'] = $carpetaResult['Codigo_Carpeta'];
                    } else {
                        $contribuyente['Codigo_Carpeta'] = ''; // Si no encuentra el código de carpeta, asigna una cadena vacía
                    }
                }
            } else if (!empty($idContribuyentesString)) {
                foreach ($registros as &$contribuyente) {
                    $stmtCarpeta = $pdo->prepare("SELECT Codigo_Carpeta FROM carpeta WHERE Concatenado_id = :concatenado_id");
                    $stmtCarpeta->bindParam(":concatenado_id", $idContribuyentesString);
                    $stmtCarpeta->execute();
                    $carpetaResult = $stmtCarpeta->fetch(PDO::FETCH_ASSOC);

                    if ($carpetaResult) {
                        $contribuyente['Codigo_Carpeta'] = $carpetaResult['Codigo_Carpeta'];
                    } else {
                        $contribuyente['Codigo_Carpeta'] = ''; // Si no encuentra el código de carpeta, asigna una cadena vacía
                    }
                }
            }

            $pdo = null;

            if (!empty($registros)) {
                foreach ($registros as $key => $value) {
                    $activo = ($value['Estado'] == '1') ? 'checked' : '';
                    ?>
                    <tr class="<?= $value['coactivo'] === '1' ? 'color_coactivo': '' ?>" id="tr_id_contribuyente" idContribuyente_predio_propietario="<?= $value['id_contribuyente'] ?>" init_envio="" id="predio_propietario" parametro_b="c_b" data-target="#modal_predio_propietario" title="Predio">
                        <td class="text-center"><?= ++$key ?></td>
                        <td class="text-center"><?= $value['id_contribuyente'] ?></td>
                        <td class="text-center"><?= $value['tipo_documento'] ?></td>
                        <td class="text-center"><?= $value['documento'] ?></td>
                        <td><?= $value['nombre_completo'] ?></td>
                        <td><?= $value['direccion_completo'] ?></td>
                        <!-- si esta en coactivo se pintara de color la persona -->
                        <td class="text-center" id="coactivo_contribuyente"><?= $value['coactivo'] === '1' ? 'Si': 'No' ?></td> 

                        <td class="text-center">
                           
                                <i class="bi bi-house-gear-fill lis_ico_con" title="Predio" idContribuyente_predio_propietario="<?= $value['id_contribuyente'] ?>" init_envio="" id="predio_propietario" parametro_b="c_b" data-target="#modal_predio_propietario"></i>
                             
                        </td>


                        
                        <td class="text-center">
                            <div class="modo-contenedor-selva">
                                <input type="checkbox" data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger" id="usuarioEstado" name="usuarioEstado<?= $value['Estado'] ?>" value="<?= $value['Estado'] ?>" data-size="mini" data-width="110" idUsuario="<?= $value['id_contribuyente'] ?>" <?= $activo ?>>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <i class="bi bi-pencil-fill lis_ico_con btnEditarcontribuyente" title="Editar" idContribuyente="<?= $value['id_contribuyente'] ?>" idDireccionnu="<?= $value['ubicacionvia'] ?>" data-toggle="modal" data-target="#modalEditarcontribuyente"></i>
                                <?php if ($perfilUsuario == 'Administrador') : ?>
                                    <i class="bi bi-trash3-fill btnEliminarContribuyente ico_eli_contri" title="Eliminar" idContribuyente="<?= $value['id_contribuyente'] ?>"></i>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<td colspan='12' style='text-align:center;'>El contribuyente no está registrado</td>";
            }
        } else {
            echo "<td colspan='12' style='text-align:center;'>Digite en el filtro</td>";
        }
    }
}



    /* buscar contribuyente */
    public function dtaContribuyente()
{
    $action = ($_REQUEST['action'] ?? null) ? $_REQUEST['action'] : '';
    if ($action == 'ajax') {
        $area_usuario = $_REQUEST['area_usuario'];
        $perfilUsuario = $_REQUEST['perfilOculto_c'];
        $tipoBusqueda = strtolower($_REQUEST['tipo']);
        $searchProducto = $_GET['searchContribuyente'];

        // Definir el campo de búsqueda basado en el tipo de búsqueda
        switch ($tipoBusqueda) {
            case 'search_codigo':
                $campoBusqueda = 'Id_Contribuyente';
                break;
            case 'search_dni':
                $campoBusqueda = 'Documento';
                break;
            case 'search_codigo_sa':
                $campoBusqueda = 'Codigo_sa';
                break;
            case 'search_direccion':
                    $campoBusqueda = 'Direccion_completo';
                 break;    
            default:
                $campoBusqueda = 'Nombre_Completo';
                break;
        }

        $sWhere = "";
        $idContribuyentesString = ""; // Variable para almacenar IDs separados por guiones

        if (!empty($searchProducto)) {
            if ($tipoBusqueda == 'search_codigo' || $tipoBusqueda == 'search_dni') {
                $sWhere = "WHERE $campoBusqueda = :searchProducto";
            } else if ($tipoBusqueda == 'search_nombres') {
                $sWhere = "WHERE $campoBusqueda LIKE :searchProducto";
                $searchProducto = "%$searchProducto%";
            }
            else if ($tipoBusqueda == 'search_direccion') {
                $sWhere = "WHERE $campoBusqueda LIKE :searchProducto";
                $searchProducto = "%$searchProducto%";
            }

            $pdo = Conexion::conectar();

            if ($tipoBusqueda == 'search_codigo_sa') {
                $stmt = $pdo->prepare("SELECT Concatenado_id FROM carpeta WHERE Codigo_Carpeta = :carpeta");
                $stmt->bindParam(":carpeta", $searchProducto);
                $stmt->execute();
                $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($registros)) {
                    $codigoCarpeta = $registros[0]['Concatenado_id'];
                    $codigosArray = explode('-', $codigoCarpeta);
                    $placeholders = implode(',', array_fill(0, count($codigosArray), '?'));
                    $sWhere = "WHERE c.Id_Contribuyente IN ($placeholders)";
                } else {
                    echo "<td colspan='12' style='text-align:center;'>El código de carpeta no se encontró</td>";
                    $pdo = null;
                    return;
                }
            }

            // Preparar y ejecutar la consulta principal
            $stmt = $pdo->prepare("SELECT 
                                    c.Id_Ubica_Vias_Urbano as ubicacionvia,
                                    c.Estado as Estado,
                                    c.Id_Contribuyente as id_contribuyente,
                                    td.descripcion as tipo_documento,
                                    c.Documento as documento,
                                    c.Nombre_Completo as nombre_completo,
                                    c.Direccion_completo as direccion_completo,
                                    c.Coactivo as coactivo
                                    FROM contribuyente c 
                                    INNER JOIN tipo_documento_siat td ON td.Id_Tipo_Documento = c.Id_Tipo_Documento
                                    $sWhere");

            if ($tipoBusqueda == 'search_codigo_sa') {
                $stmt->execute($codigosArray);
            } else {
                $stmt->execute(['searchProducto' => $searchProducto]);
            }

            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Construir la cadena con id_contribuyente separados por guiones
            if (!empty($registros)) {
                $idContribuyentes = array();
                foreach ($registros as $registro) {
                    $idContribuyentes[] = $registro['id_contribuyente'];
                }
                $idContribuyentesString = implode('-', $idContribuyentes);
            }

            // Obtener el Código_Carpeta y agregarlo a cada contribuyente
            if ($tipoBusqueda == 'search_codigo_sa' && !empty($codigosArray)) {
                foreach ($registros as &$contribuyente) {
                    $stmtCarpeta = $pdo->prepare("SELECT Codigo_Carpeta FROM carpeta WHERE Concatenado_id = :concatenado_id");
                    $stmtCarpeta->bindParam(":concatenado_id", $codigoCarpeta);
                    $stmtCarpeta->execute();
                    $carpetaResult = $stmtCarpeta->fetch(PDO::FETCH_ASSOC);

                    if ($carpetaResult) {
                        $contribuyente['Codigo_Carpeta'] = $carpetaResult['Codigo_Carpeta'];
                    } else {
                        $contribuyente['Codigo_Carpeta'] = ''; // Si no encuentra el código de carpeta, asigna una cadena vacía
                    }
                }
            } else if (!empty($idContribuyentesString)) {
                foreach ($registros as &$contribuyente) {
                    $stmtCarpeta = $pdo->prepare("SELECT Codigo_Carpeta FROM carpeta WHERE Concatenado_id = :concatenado_id");
                    $stmtCarpeta->bindParam(":concatenado_id", $idContribuyentesString);
                    $stmtCarpeta->execute();
                    $carpetaResult = $stmtCarpeta->fetch(PDO::FETCH_ASSOC);

                    if ($carpetaResult) {
                        $contribuyente['Codigo_Carpeta'] = $carpetaResult['Codigo_Carpeta'];
                    } else {
                        $contribuyente['Codigo_Carpeta'] = ''; // Si no encuentra el código de carpeta, asigna una cadena vacía
                    }
                }
            }

            $pdo = null;

            if (!empty($registros)) {
                foreach ($registros as $key => $value) {
                    $activo = ($value['Estado'] == '1') ? 'checked' : '';
                    ?>
                    <tr class="<?= $value['coactivo'] === '1' ? 'color_coactivo': '' ?>" id="tr_id_contribuyente" idContribuyente_predio_propietario="<?= $value['id_contribuyente'] ?>" init_envio="" id="predio_propietario" parametro_b="c_b" data-target="#modal_predio_propietario" title="Predio">
                        <td class="text-center"><?= ++$key ?></td>
                        <td class="text-center"><?= $value['id_contribuyente'] ?></td>
                        <td class="text-center"><?= $value['tipo_documento'] ?></td>
                        <td class="text-center"><?= $value['documento'] ?></td>
                        <td><?= $value['nombre_completo'] ?></td>
                        <td><?= $value['direccion_completo'] ?></td>
                        <!-- si esta en coactivo se pintara de color la persona -->
                        <td class="text-center" id="coactivo_contribuyente"><?= $value['coactivo'] === '1' ? 'Si': 'No' ?></td> 

                        <td class="text-center">
                         
                                <i class="bi bi-house-gear-fill lis_ico_con" title="Predio" idContribuyente_predio_propietario="<?= $value['id_contribuyente'] ?>" init_envio="" id="predio_propietario" parametro_b="c_b" data-target="#modal_predio_propietario"></i>
                              
                        </td>


                        
                        <td class="text-center">
                            <div class="modo-contenedor-selva">
                                <input type="checkbox" data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger" id="usuarioEstado" name="usuarioEstado<?= $value['Estado'] ?>" value="<?= $value['Estado'] ?>" data-size="mini" data-width="110" idUsuario="<?= $value['id_contribuyente'] ?>" <?= $activo ?>>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <i class="bi bi-pencil-fill lis_ico_con btnEditarcontribuyente" title="Editar" idContribuyente="<?= $value['id_contribuyente'] ?>" idDireccionnu="<?= $value['ubicacionvia'] ?>" data-toggle="modal" data-target="#modalEditarcontribuyente"></i>
                                <?php if ($perfilUsuario == 'Administrador') : ?>
                                    <i class="bi bi-trash3-fill btnEliminarContribuyente ico_eli_contri" title="Eliminar" idContribuyente="<?= $value['id_contribuyente'] ?>"></i>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<td colspan='12' style='text-align:center;'>El contribuyente no está registrado</td>";
            }
        } else {
            echo "<td colspan='12' style='text-align:center;'>Digite en el filtro</td>";
        }
    }
}

    
    
    
    

    //Lista contribuyente caja 
    public function dtaContribuyente_caja()
    {
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
        if ($action == 'ajax') {
            $perfilUsuario = $_REQUEST['perfilOculto_c'];
            $tipoBusqueda = strtolower($_REQUEST['tipo']);
            $searchProducto = isset($_GET['searchContribuyente']) ? $_GET['searchContribuyente'] : '';

            // Definir el campo de búsqueda basado en el tipo de búsqueda
            switch ($tipoBusqueda) {
                case 'search_codigo':
                    $campoBusqueda = 'Id_Contribuyente';
                    break;
                case 'search_dni':
                    $campoBusqueda = 'Documento';
                    break;
                case 'search_codigo_sa':
                    $campoBusqueda = 'Codigo_sa';
                    break;
                default:
                    $campoBusqueda = 'Nombre_Completo';
                    break;
            }

            if (!empty($searchProducto)) {
                $sWhere = ($tipoBusqueda == 'search_codigo' || $tipoBusqueda == 'search_dni') ?
                    "WHERE $campoBusqueda = '$searchProducto'" :
                    "WHERE $campoBusqueda LIKE '%$searchProducto%'";

                $pdo = Conexion::conectar();
                $registros = $pdo->prepare("SELECT 
                                              c.Codigo_sa as codigo_sa,
                                              c.Estado as Estado,
                                              c.Id_Contribuyente as id_contribuyente,
                                              td.descripcion as tipo_documento,
                                              c.Documento as documento,
                                              c.Nombre_Completo as nombre_completo,
                                              c.Direccion_Completo as direccion_completo,
                                              c.Codigo_sa as codigo_sa
                                          FROM contribuyente c 
                                          INNER JOIN tipo_documento_siat td ON td.Id_Tipo_Documento=c.Id_Tipo_Documento 
                                          $sWhere");
                $registros->execute();
                $registros = $registros->fetchAll();
                $pdo = null;

                if (count($registros) > 0) {
                    foreach ($registros as $key => $value) {
                        $activo = ($value['Estado'] == '1') ? 'checked' : '';
                    ?>
                        <tr>
                            <td class="text-center"><?= ++$key ?></td>
                            <td class="text-center"><?= $value['id_contribuyente'] ?></td>
                            <td class="text-center"><?= $value['tipo_documento'] ?></td>
                            <td class="text-center"><?= $value['documento'] ?></td>
                            <td><?= $value['nombre_completo'] ?></td>
                            <td><?= $value['direccion_completo'] ?></td>
                            <td class="text-center">
                                <div class="modo-contenedor-selva">
                                    <input type="checkbox" data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger" id="usuarioEstado" name="usuarioEstado<?= $value['Estado'] ?>" value="<?= $value['Estado'] ?>" data-size="mini" data-width="110" idUsuario="<?= $value['id_contribuyente'] ?>" <?= $activo ?>>
                                </div>
                            </td>
                            <td class="text-center"><?= $value['codigo_sa'] ?></td>
                            <td class="text-center">
                                <img src="./vistas/img/iconos/cuenta_o1.png" class="t-icon-tbl-p" init_envio="" idContribuyente_predio_propietario="<?= $value['id_contribuyente'] ?>" id="predio_propietario" parametro_b="pago_tributo" data-target="#modal_predio_propietario" title="Licencia-Agua">
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    echo "<td colspan='10' style='text-align:center;'>El contribuyente no está registrado</td>";
                }
            } else {
                echo "<td colspan='10'>Digite en el buscador</td>";
            }
        }
    }

    //Lista contribuyentes de consulta deuda de Agua
    public function dtaContribuyente_agua_lista()
    {
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
        if ($action == 'ajax') {
            $perfilUsuario = $_REQUEST['perfilOculto_c'];
            $tipoBusqueda = strtolower($_REQUEST['tipo']);
            $searchProducto = isset($_GET['searchContribuyente']) ? $_GET['searchContribuyente'] : '';

            // Definir el campo de búsqueda basado en el tipo de búsqueda
            switch ($tipoBusqueda) {
                case 'search_codigo':
                    $campoBusqueda = 'Id_Contribuyente';
                    break;
                case 'search_dni':
                    $campoBusqueda = 'Documento';
                    break;
                default:
                    $campoBusqueda = 'Nombre_Completo';
                    break;
            }

            if (!empty($searchProducto)) {
                $sWhere = ($tipoBusqueda == 'search_codigo' || $tipoBusqueda == 'search_dni') ?
                    "WHERE $campoBusqueda = '$searchProducto'" :
                    "WHERE $campoBusqueda LIKE '%$searchProducto%'";

                $pdo = Conexion::conectar();
                $registros = $pdo->prepare("SELECT 
                                            c.Codigo_sa as codigo_sa,
                                            c.Estado as Estado,
                                            c.Id_Contribuyente as id_contribuyente,
                                            td.descripcion as tipo_documento,
                                            c.Documento as documento,
                                            c.Nombre_Completo as nombre_completo,
                                            c.Direccion_completo as direccion_completo
                                        FROM contribuyente c 
                                        INNER JOIN tipo_documento_siat td ON td.Id_Tipo_Documento=c.Id_Tipo_Documento 
                                        $sWhere");
                $registros->execute();
                $registros = $registros->fetchAll();
                $pdo = null;

                if (count($registros) > 0) {
                    foreach ($registros as $key => $value) {
                        $activo = ($value['Estado'] == '1') ? 'checked' : '';
                    ?>
                        <tr>
                            <td class="text-center"><?= ++$key ?></td>
                            <td class="text-center"><?= $value['id_contribuyente'] ?></td>
                            <td class="text-center"><?= $value['tipo_documento'] ?></td>
                            <td class="text-center"><?= $value['documento'] ?></td>
                            <td><?= $value['nombre_completo'] ?></td>
                            <td><?= $value['direccion_completo'] ?></td>
                            <td class="text-center">
                                <div class="modo-contenedor-selva">
                                    <input type="checkbox" data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger" id="usuarioEstado" name="usuarioEstado<?= $value['Estado'] ?>" value="<?= $value['Estado'] ?>" data-size="mini" data-width="110" idUsuario="<?= $value['id_contribuyente'] ?>" <?= $activo ?>>
                                </div>
                            </td>
                            <td class="text-center">
                                <img src="./vistas/img/iconos/cuenta_o1.png" class="t-icon-tbl-p" init_envio="" idContribuyente_predio_propietario="<?= $value['id_contribuyente'] ?>" id="predio_propietario" parametro_b="r_e" data-target="#modal_predio_propietario" title="Licencia-Agua">
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    echo "<td colspan='10' style='text-align:center;'>El contribuyente no está registrado</td>";
                }
            } else {
                echo "<spam>digitar en el buscardor</spam>";
            }
        }
    }

    public function dtaContribuyente_agua_lista_caja()
    {
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
        if ($action == 'ajax') {
            $perfilUsuario = $_REQUEST['perfilOculto_c'];
            $tipoBusqueda = strtolower($_REQUEST['tipo']);

            switch ($tipoBusqueda) {
                case 'search_codigo':
                    $aColumns = array('c.Id_Contribuyente');
                    break;
                case 'search_dni':
                    $aColumns = array('Documento');
                    break;
                default:
                    $aColumns = array('Nombre_completo');
                    break;
            }

            $searchProducto = isset($_GET['searchContribuyente']) ? $_GET['searchContribuyente'] : '';
            $sWhere = "";

            if (!empty($searchProducto)) {
                $sWhere = "WHERE (";
                foreach ($aColumns as $column) {
                    if ($tipoBusqueda == 'search_codigo') {
                        $sWhere .= "$column = '$searchProducto' OR ";
                    } else {
                        $sWhere .= "$column LIKE '%$searchProducto%' OR ";
                    }
                }
                $sWhere = substr($sWhere, 0, -4); // Eliminar el último "OR"
                $sWhere .= ')';

                $pdo = Conexion::conectar();
                $registros = $pdo->prepare("SELECT  
                                              c.Estado as Estado,
                                              c.Id_Contribuyente as id_contribuyente,
                                              td.descripcion as tipo_documento,
                                              c.Documento as documento,
                                              c.Nombre_Completo as nombre_completo
                                          FROM contribuyente c 
                                          INNER JOIN tipo_documento_siat td ON td.Id_Tipo_Documento=c.Id_Tipo_Documento 
                                          $sWhere");
                $registros->execute();
                $registros = $registros->fetchAll();
                $pdo = null;

                if (count($registros) > 0) {
                    foreach ($registros as $key => $value) {
                        $activo = ($value['Estado'] == '1') ? 'checked' : ''; ?>
                        <tr>
                            <td class="text-center"><?= ++$key ?></td>
                            <td class="text-center"><?= $value['id_contribuyente'] ?></td>
                            <td class="text-center"><?= $value['tipo_documento'] ?></td>
                            <td class="text-center"><?= $value['documento'] ?></td>
                            <td><?= $value['nombre_completo'] ?></td>
                            <td></td>
                            <td class="text-center">
                                <div class="modo-contenedor-selva">
                                    <input type="checkbox" data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger" id="usuarioEstado" name="usuarioEstado<?= $value['Estado'] ?>" value="<?= $value['Estado'] ?>" data-size="mini" data-width="110" idUsuario="<?= $value['id_contribuyente'] ?>" <?= $activo ?>>
                                </div>
                            </td>
                            <td class="text-center">
                                <img src="./vistas/img/iconos/cuenta_o1.png" class="t-icon-tbl-p btncaja_agua" id="p_i" idUsuario_agua="<?= $value['id_contribuyente'] ?>" data-toggle="modal" title="Estado de Cuenta">
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    echo "<td colspan='7' class='text-center'>El Usuario no está registrado</td>";
                }
            } else {
                echo "<td colspan='7' class='text-center'>Digitar en el buscador</td>";
            }
        }
    }

    // DATA_TABLE LISTAR CONTRIBUYENTE  - BUSCAR CONTRIBUYENTE - CALCULO IMPUESTO PREDIAL -optimizado
    public function dtaContribuyente_impuesto()
    {
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
        if ($action == 'ajax') {
            $perfilUsuario = $_REQUEST['perfilOculto_c'];
            $tipoBusqueda = strtolower($_REQUEST['tipo']);
            $searchProducto = isset($_GET['searchContribuyente']) ? $_GET['searchContribuyente'] : '';
            $sWhere = "";

            // Definir el campo de búsqueda basado en el tipo de búsqueda
            switch ($tipoBusqueda) {
                case 'search_codigo':
                    $campoBusqueda = 'Id_Contribuyente';
                    break;
                case 'search_dni':
                    $campoBusqueda = 'Documento';
                    break;
                case 'search_codigo_sa':
                    $campoBusqueda = 'Codigo_sa';
                    break;
                default:
                    $campoBusqueda = 'Nombre_Completo';
                    break;
            }

            if (!empty($searchProducto)) {
                if ($tipoBusqueda == 'search_codigo' || $tipoBusqueda == 'search_dni') {
                    $sWhere = "WHERE $campoBusqueda = '$searchProducto'";
                } else {
                    $sWhere = "WHERE $campoBusqueda LIKE '%$searchProducto%'";
                }

                $pdo = Conexion::conectar();
                $registros = $pdo->prepare("SELECT 
                                            c.Codigo_sa as codigo_sa,
                                            c.Estado as Estado,
                                            c.Id_Contribuyente as id_contribuyente,
                                            td.descripcion as tipo_documento,
                                            c.Documento as documento,
                                            c.Nombre_Completo as nombre_completo,
                                            c.Direccion_completo as direccion_completo,
                                            c.Codigo_sa as codigo_sa
                                        FROM contribuyente c 
                                        INNER JOIN tipo_documento_siat td ON td.Id_Tipo_Documento=c.Id_Tipo_Documento 
                                        $sWhere");
                $registros->execute();
                $registros = $registros->fetchAll();
                $pdo = null;

                if (!empty($registros)) {
                    foreach ($registros as $key => $value) {
                        $activo = ($value['Estado'] == '1') ? 'checked' : '';

                        echo '<tr>
                            <td class="text-center">' . ++$key . '</td>
                            <td class="text-center">' . $value['id_contribuyente'] . '</td>
                            <td class="text-center">' . $value['tipo_documento'] . '</td>      
                            <td class="text-center">' . $value['documento'] . '</td>
                            <td>' . $value['nombre_completo'] . '</td>
                            <td>' . $value['direccion_completo'] . '</td>
                            <td class="text-center">
                                <div class="modo-contenedor-selva">               
                                    <input type="checkbox" data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger" id="usuarioEstado" name="usuarioEstado' . $value['Estado'] . '"  value="' . $value['Estado'] . '" data-size="mini" data-width="110" idUsuario="' . $value['id_contribuyente'] . '" ' . $activo . '>
                                </div>
                            </td>
                            <td class="text-center">' . $value['codigo_sa'] . '</td>
                            <td class="text-center">
                                <img src="./vistas/img/iconos/cuenta_o1.png" class="t-icon-tbl-p" init_envio="" idContribuyente_predio_propietario="' . $value["id_contribuyente"] . '" id="predio_propietario" parametro_b="p_c" data-target="#modal_predio_propietario" title="Predio">
                            </td>
                        </tr>';
                    }
                } else {
                    echo "<td colspan='8' style='text-align:center;'>El contribuyente no está registrado</td>";
                }
            } else {
                echo "<span>digitar en el buscador</span>";
            }
        }
    }
    public function recaudacion_dtaContribuyente_impuesto()  //optimizado
    {
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
        if ($action == 'ajax') {
            $perfilUsuario = $_REQUEST['perfilOculto_c'];
            $tipoBusqueda = strtolower($_REQUEST['tipo']);
            $searchProducto = $_GET['searchContribuyente'] ?? '';
            $pagado = $_GET['pagado'] ?? '';
            $sWhere = "";

            // Definir el campo de búsqueda basado en el tipo de búsqueda
            switch ($tipoBusqueda) {
                case 'search_codigo':
                    $campoBusqueda = 'Id_Contribuyente';
                    break;
                case 'search_dni':
                    $campoBusqueda = 'Documento';
                    break;
                case 'search_codigo_sa':
                    $campoBusqueda = 'Codigo_sa';
                    break;
                default:
                    $campoBusqueda = 'Nombre_Completo';
                    break;
            }

            if (!empty($searchProducto)) {
                if ($tipoBusqueda == 'search_codigo' || $tipoBusqueda == 'search_dni') {
                    $sWhere = "WHERE $campoBusqueda = :searchProducto";
                } else {
                    $sWhere = "WHERE $campoBusqueda LIKE :searchProducto";
                }

                $pdo = Conexion::conectar();
                $query = "SELECT 
                        c.Codigo_sa as codigo_sa,
                        c.Estado as Estado,
                        c.Id_Contribuyente as id_contribuyente,
                        td.descripcion as tipo_documento,
                        c.Documento as documento,
                        c.Nombre_Completo as nombre_completo,
                        c.Direccion_completo as direccion_completo,
                        c.Codigo_sa as codigo_sa
                      FROM contribuyente c 
                      INNER JOIN tipo_documento_siat td ON td.Id_Tipo_Documento = c.Id_Tipo_Documento 
                      $sWhere";
                $registros = $pdo->prepare($query);

                if ($tipoBusqueda == 'search_codigo' || $tipoBusqueda == 'search_dni') {
                    $registros->bindParam(':searchProducto', $searchProducto);
                } else {
                    $searchProducto = "%$searchProducto%";
                    $registros->bindParam(':searchProducto', $searchProducto);
                }

                $registros->execute();
                $resultados = $registros->fetchAll();
                $pdo = null;

                if (count($resultados) > 0) {
                    foreach ($resultados as $key => $value) {
                        $activo = $value['Estado'] == '1' ? 'checked' : '';
                        $initEnvio = $pagado == 'pago' ? 'pagado_006_743' : 'deuda_006_742';

                        echo '<tr>
                            <td class="text-center">' . (++$key) . '</td>
                            <td class="text-center">' . $value['id_contribuyente'] . '</td>
                            <td class="text-center">' . $value['tipo_documento'] . '</td>      
                            <td class="text-center">' . $value['documento'] . '</td>
                            <td>' . $value['nombre_completo'] . '</td>
                            <td>' . $value['direccion_completo'] . '</td>
                            <td class="text-center">
                                <div class="modo-contenedor-selva">
                                    <input type="checkbox" data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger" id="usuarioEstado" name="usuarioEstado' . $value['Estado'] . '" value="' . $value['Estado'] . '" data-size="mini" data-width="110" idUsuario="' . $value['id_contribuyente'] . '" ' . $activo . '>
                                </div>
                            </td>
                             <td class="text-center">' . $value['codigo_sa'] . '</td>
                            <td class="text-center">
                                <img src="./vistas/img/iconos/predio5.png" class="t-icon-tbl-p" title="Predio" idContribuyente_predio_propietario="' . $value["id_contribuyente"] . '" init_envio="' . $initEnvio . '" parametro_b="r_c" id="predio_propietario" data-target="#modal_predio_propietario">
                            </td>
                          </tr>';
                    }
                } else {
                    echo "<td colspan='10' class='text-center'>El contribuyente no está registrado</td>";
                }
            } else {
                echo "<td colspan='10' class='text-center'>Digitar en el buscador</td>";
            }
        }
    }

    //HIATORIAL V2

    public function dtaPredioh() //optimizado
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        if ($action == 'ajax') {
            $propietario = $_POST['propietarios'];
            $perfilUsuario = $_POST['perfilOculto_p'];
            $ids = explode(",", $propietario);
            $selectnum = $_POST['selectnum']; // anio

            
        // Definir la variable $anio_seleccionado usando un switch
        switch ($selectnum) {
            case 1:
                $anio_seleccionado = 2004;
                break;
            case 2:
                $anio_seleccionado = 2005;
                break;
            case 3:
                $anio_seleccionado = 2006;
                break;
            case 4:
                $anio_seleccionado = 2007;
                break;
            case 5:
                $anio_seleccionado = 2008;
                break;
            case 6:
                $anio_seleccionado = 2009;
                break;
            case 7:
                $anio_seleccionado = 2010;
                break;
            case 8:
                $anio_seleccionado = 2011;
                break;
            case 9:
                $anio_seleccionado = 2012;
                break;
            case 10:
                $anio_seleccionado = 2013;
                break;
            case 11:
                $anio_seleccionado = 2014;
                break;
            case 12:
                $anio_seleccionado = 2015;
                break;
            case 13:
                $anio_seleccionado = 2016;
                break;
            case 14:
                $anio_seleccionado = 2017;
                break;
            case 15:
                $anio_seleccionado = 2018;
                break;
            case 16:
                $anio_seleccionado = 2019;
                break;
            case 17:
                $anio_seleccionado = 2020;
                break;
            case 18:
                $anio_seleccionado = 2021;
                break;
            case 19:
                $anio_seleccionado = 2022;
                break;
            case 20:
                $anio_seleccionado = 2023;
                break;
            case 21:
                $anio_seleccionado = 2024;
                break;
            case 22:
                $anio_seleccionado = 2025;
                break;
            default:
                $anio_seleccionado = 'Desconocido'; // En caso de que el valor de $selectnum no sea válido
        }
            $pdo = Conexion::conectar();

            if (count($ids) === 1) {
                //  $this->createTemporaryTable($pdo);
               // $registros = $this->fetchSingleOwnerData($pdo, $ids[0], $selectnum);
               // var_dump($registros);
                $registros_historial = $this->fetchSingleOwnerDataHistorial($pdo, $ids[0], $selectnum);
              //  var_dump($registros_historial);
           
              //  var_dump($registros_historial); // Muestra los registros del historial
            } else {
                // $this->createTemporaryTable($pdo);
               // $registros = $this->fetchMultipleOwnersData($pdo, $ids, $selectnum);
               $registros_historial = $this->fetchMultipleOwnersDataHistorial($pdo, $ids, $selectnum);

            }

            if ($registros_historial->rowCount() > 0) {
             //   $resultados = $registros->fetchAll(PDO::FETCH_ASSOC);
                $resultados_historial = $registros_historial->fetchAll(PDO::FETCH_ASSOC);

              
                foreach ($resultados_historial as $key => $value) {
                    $this->renderRowHistorial($value, ++$key);
                   
                }


            } else {
                $this->renderNoRecordsMessageHistorial($pdo, $selectnum);
            }

            $pdo = null;
        }
    }

    public function dtaPredio() //optimizado
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        if ($action == 'ajax') {
            $propietario = $_POST['propietarios'];
            $perfilUsuario = $_POST['perfilOculto_p'];
            $ids = explode(",", $propietario);
            $selectnum = $_POST['selectnum']; // anio
            $pdo = Conexion::conectar();

            if (count($ids) === 1) {
                //  $this->createTemporaryTable($pdo);
                $registros = $this->fetchSingleOwnerData($pdo, $ids[0], $selectnum);
              
            } else {
                // $this->createTemporaryTable($pdo);
                $registros = $this->fetchMultipleOwnersData($pdo, $ids, $selectnum);
             
            }

            //OBTENER AÑO

               $query = "SELECT * FROM anio WHERE Id_Anio = :selectnum";

            $resultado = $pdo->prepare($query);
            $resultado->bindParam(':selectnum', $selectnum, PDO::PARAM_INT);

            $resultado->execute();

            $anio_actual = $resultado->fetch(PDO::FETCH_ASSOC);


            var_dump( $anio_actual );



            if ($registros->rowCount() > 0) {
                $resultados = $registros->fetchAll(PDO::FETCH_ASSOC);
                // Inicializamos el contador
                $total_predios = 0;
              
                foreach ($resultados as $key => $value) {
                    $this->renderRow($value, ++$key, $anio_actual['NomAnio'] );
                   $total_predios++;
                }
               
                
            // Imprimir el total de predios después de recorrer todas las filas
            echo sprintf(
                '<tr>
              

                    <td colspan="6" style="background-color:#ffffff" class="text-start">
                   
                    <span class="caption_" style="padding-left:1rem;"><i class="bi bi-house-door-fill"></i> Total de Predios: %d</span>
                    
                    
                    </td>
                </tr>',
                $total_predios
            );


            } else {
                $this->renderNoRecordsMessage($pdo, $selectnum);
            }

            $pdo = null;
       
       
       
        }
    }

    //HITORIAL PREDIO

    private function fetchSingleOwnerDataHistorial($pdo, $id, $select)
{
  
    $query = (" SELECT 
    pr.id_predio as id_predio,
    pr.predio_UR as tipo_ru, 
    pr.Direccion_completo as direccion_completo,
    pr.Area_Terreno as a_terreno, 
    pr.Area_Construccion as a_construccion, 
    
    	pr.Valor_Predio_Aplicar as v_predio_aplicar,
   
    -- Agregar aquí la columna 'catastro' si es necesario
    ca.Codigo_Catastral as catastro
FROM 
    propietario p
JOIN  
    
    predio pr ON p.Id_Predio = pr.Id_Predio
    LEFT JOIN anio a ON a.Id_Anio=pr.Id_Anio
    LEFT JOIN  catastro ca ON pr.Id_Catastro = ca.Id_Catastro 
    
   WHERE 
        p.Id_Contribuyente = :id
        AND a.Id_Anio=:anio
        
        AND p.Estado_Transferencia = 'O'
       
    ");

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':anio', $select); // Usamos selectnum (1, 2, 3...) para determinar el año

    $stmt->execute();

   
    return $stmt;
}

    

    //HISTORIAL PREDIO
    private function fetchMultipleOwnersDataHistorial($pdo, $ids, $selectnum)

    {
        $id_cadena = implode(",", $ids);

        var_dump($id_cadena);
        var_dump($selectnum);
        $count_ids = count($ids);

        $query = "SELECT 
    pr.id_predio as id_predio,
    pr.predio_UR as tipo_ru, 
    pr.Direccion_completo as direccion_completo,
    pr.Area_Terreno as a_terreno, 
    pr.Area_Construccion as a_construccion, 
   
    	pr.Valor_Predio_Aplicar as v_predio_aplicar,
   
    -- Agregar aquí la columna 'catastro' si es necesario
    ca.Codigo_Catastral as catastro
FROM 
    propietario p
JOIN 
    
    predio pr ON p.Id_Predio = pr.Id_Predio
LEFT JOIN 
    catastro ca ON pr.Id_Catastro = ca.Id_Catastro 
    LEFT JOIN anio  a ON a.Id_Anio=pr.Id_Anio
   
        WHERE p.Id_Contribuyente IN ($id_cadena)
        AND a.Id_Anio=:selectnum
       
        AND p.Estado_Transferencia = 'O'
			GROUP BY pr.Id_Predio HAVING COUNT(DISTINCT p.Id_Contribuyente) = " . count($ids) . " ORDER BY pr.predio_UR
            ";



        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':selectnum', $selectnum);
        $stmt->execute();
        return $stmt;
    }




    private function fetchSingleOwnerData($pdo, $id, $selectnum)
    {
        $query = ("SELECT 
                p.predio_UR as tipo_ru, 
                p.Direccion_completo as direccion_completo,
                IF(p.predio_UR = 'U', ca.Codigo_Catastral, car.Codigo_Catastral) as catastro,
                p.Id_Predio as id_predio,
                p.Area_Terreno as a_terreno,
                p.Area_Construccion as a_construccion,
                p.Valor_Predio_Aplicar as v_predio_aplicar
            FROM 
                predio p 
                LEFT JOIN catastro ca ON p.predio_UR = 'U' AND ca.Id_Catastro = p.Id_Catastro 
                LEFT JOIN catastro_rural car ON p.predio_UR = 'R' AND car.Id_Catastro_Rural = p.Id_Catastro_Rural 
                INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
                INNER JOIN anio an ON an.Id_Anio = p.Id_Anio 
            WHERE 
                pro.Id_Contribuyente = :id AND an.Id_Anio = :selectnum 
                AND p.ID_Predio NOT IN (
                    SELECT ID_Predio 
                    FROM Propietario 
                    WHERE ID_Contribuyente <> :id AND Baja='1'
                )and pro.Baja='1';");

        $stmt = $pdo->prepare($query);
        
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':selectnum', $selectnum);
        $stmt->execute();

        
   
       
        return $stmt;
       
    }

    private function fetchMultipleOwnersData($pdo, $ids, $selectnum)
    {
        $id_cadena = implode(",", $ids);
        $count_ids = count($ids);

        $query = "SELECT
			p.predio_UR as tipo_ru, 
						p.Direccion_completo as direccion_completo,
						IF(p.predio_UR = 'U', ca.Codigo_Catastral, car.Codigo_Catastral) as catastro,
						p.Id_Predio as id_predio,
						p.Area_Terreno as a_terreno,
						p.Area_Construccion as a_construccion,
						p.Valor_Predio_Aplicar as v_predio_aplicar
		  FROM 
			predio p 
			LEFT JOIN catastro ca ON p.predio_UR = 'U' AND ca.Id_Catastro = p.Id_Catastro 
            LEFT JOIN catastro_rural car ON p.predio_UR = 'R' AND car.Id_Catastro_Rural = p.Id_Catastro_Rural 
			INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
			INNER JOIN anio an ON an.Id_Anio = p.Id_Anio
			WHERE pro.Id_Contribuyente IN ($id_cadena)
             and an.Id_Anio=:selectnum  
             AND pro.Baja='1' 
			GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($ids) . " ORDER BY p.predio_UR";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':selectnum', $selectnum);
        $stmt->execute();
        return $stmt;
    }


    //HISTORIAL PREDIO
    private function renderRowHistorial($value, $key)
    {
        // Verificar si los campos requeridos existen
        // if (!isset($value['id_predio']) || !isset($value['catastro'])) {
        //     echo "<tr><td colspan='8'>Error: Datos incompletos en historial</td></tr>";
        //     return;
        // }
    
        // Si el valor de 'catastro' es NULL, asignar un valor alternativo
        $catastro = isset($value['catastro']) ? $value['catastro'] : 'No disponible';
    
        // Si el tipo de predio es 'U', renderizamos una fila con los datos correspondientes
        if ($value['tipo_ru'] == 'U') {
            echo sprintf(
                '
                
                <tr id="fila" id_predio="%s"  id_catastro="%s" id_tipo="%s" style="background-color:rgb(235, 238, 241); !important" >
                    <td  class="text-center" >%d</td>
                    <td class="text-center">%s</td>
                    <td>%s</td>
                    <td class="text-center" style="display:none;">%s</td>
                    <td class="text-center">%s</td>
                    <td class="text-center">%s</td>
                    <td class="text-center">%s</td>
                    <td class="text-center"><i class="bi bi-three-dots" id="id_predio_foto" data-id_predio_foto="%s"></i></td>
                </tr>
                
                ',
                $value['id_predio'],
                $catastro,
                $value['tipo_ru'],
                $key,
                $value['tipo_ru'],
                $value['direccion_completo'],
                $catastro, // Aquí se muestra el valor de catastro (o 'No disponible')
                $value['a_terreno'],
                $value['a_construccion'],
                $value['v_predio_aplicar'],
                $value['id_predio']
            );
        } else {
            // Si el tipo de predio no es 'U', renderizamos otra fila con los datos
            echo sprintf(
                '<tr id="fila" id_predio="%s" id_catastro="%s" id_tipo="%s" style="background-color:rgb(235, 238, 241);  !important">
                    <td class="text-center" >%d</td>
                    <td class="text-center">%s</td>
                    <td>%s</td>
                    <td class="text-center" style="display:none;">%s</td>
                    <td class="text-center">%s</td>
                    <td class="text-center">%s</td>
                    <td class="text-center">%s</td>
                     <td class="text-center"><i class="bi bi-three-dots" id="id_predio_foto" data-id_predio_foto="%s"></i></td>
                </tr>',
                $value['id_predio'],
                $catastro,
                $value['tipo_ru'],
                $key,
                $value['tipo_ru'],
                $value['direccion_completo'],
                $catastro, // Aquí también se maneja el valor de catastro
                $value['a_terreno'],
                $value['a_construccion'],
                $value['v_predio_aplicar'],
                $value['id_predio']
            );
        }
    }
    

    private function renderRow($value, $key,$anio_actual )
    {
        

        if ($value['tipo_ru'] == 'U') {
           // $contador_if++;
            echo sprintf(
                '<tr id="fila"  id_predio="%s" id_catastro="%s" id_tipo="%s"  >
                <td class="text-center">
				    <input type="checkbox" class="checkbox-predio" data-id_predio="%s" data-onstyle="success" data-offstyle="danger" data-size="mini" data-width="110">
			    </td>
                <td class="text-center" style="display:none;" >%d</td>
                <td class="text-center">%s</td>
                <td>%s</td>
                <td class="text-center" style="display:none;">%s</td>
                <td class="text-center">%s</td>
                <td class="text-center">%s</td>
                <td class="text-center">%s</td>
                <td class="text-center"><i class="bi bi-three-dots" id="id_predio_foto" data-id_predio_foto="%s"></i></td>
                <td class="text-center"style="display:none;">%s</td>  
          
                </tr>',
                $value['id_predio'],
                $value['catastro'],
                $value['tipo_ru'],
                $value['id_predio'],
                $key,
                $value['tipo_ru'],
                $value['direccion_completo'],
                $value['catastro'],
                $value['a_terreno'],
                $value['a_construccion'],
                $value['v_predio_aplicar'],
                $value['id_predio'],
                $anio_actual
                
            );
        } else {
          //  $contador_else++;
            echo sprintf(
                '<tr id="fila" id_predio="%s" id_catastro="%s" id_tipo="%s">
                <td class="text-center">
				    <input type="checkbox" class="checkbox-predio" data-id_predio="%s" data-onstyle="success" data-offstyle="danger" data-size="mini" data-width="110">
			    </td>
                <td class="text-center"  style="display:none;" >%d</td>
                <td class="text-center">%s</td>
                <td>%s</td>
                <td class="text-center" style="display:none;">%s</td>
                <td class="text-center">%s</td>
                <td class="text-center">%s</td>
                <td class="text-center">%s</td>
                <td class="text-center"><i class="bi bi-three-dots" id="id_predio_foto" data-id_predio_foto="%s"></i></td>
                 <td class="text-center"style="display:none;">%s</td> 

                </tr>',
                $value['id_predio'],
                $value['catastro'],
                $value['tipo_ru'],
                 $value['id_predio'],
                $key,
                $value['tipo_ru'],
                $value['direccion_completo'],
                $value['catastro'],
                $value['a_terreno'],
                $value['a_construccion'],
                $value['v_predio_aplicar'],
                $value['id_predio'],
                $anio_actual
            );
        }

    
    }

    private function renderNoRecordsMessage($pdo, $selectnum)
    {
        $query = "SELECT NomAnio FROM anio WHERE Id_Anio = :selectnum";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':selectnum', $selectnum);
        $stmt->execute();
        $anio = $stmt->fetch(PDO::FETCH_ASSOC);

        echo sprintf(
            "
            <td colspan='10' style='text-align:center;'>No hay Registro de Predio(s) del año hola <b>%s</b></td>
            
            
            ",
            $anio['NomAnio']
        );
    }

    private function renderNoRecordsMessageHistorial($pdo, $selectnum)
    {
        $query = "SELECT NomAnio FROM anio WHERE Id_Anio = :selectnum";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':selectnum', $selectnum);
        $stmt->execute();
        $anio = $stmt->fetch(PDO::FETCH_ASSOC);

        echo sprintf(
            "
            <td colspan='10' style='text-align:center;background-color:rgb(235, 238, 241);  !important'  >No hay Registro de transferencia de predio en <b>%s</b></td>
            
            
            ",
            $anio['NomAnio']
        );
    }

    // DATA_TABLE LISTAR PROPIETARIOS POR PREDIO -FUE ELIMINADO ESTA FUNCION
    public  function dtaPredio_propietario() //optimizado
    {
        $action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
        if ($action == 'ajax') {
            $catastro = $_GET['catastro'];
            $anio = $_GET['selectnum'];

            $pdo =  Conexion::conectar();
            $registros = $pdo->prepare("SELECT c.Id_Contribuyente as codigo,
                                 c.Documento as documento,
                                 c.Nombres as nombres,
                                 c.Nombre_Completo as nombre_completo
                                 FROM contribuyente c 
                                 INNER JOIN propietario pro ON c.Id_Contribuyente = pro.Id_Contribuyente 
                                 INNER JOIN predio p ON pro.Id_Predio = p.Id_Predio 
                                 INNER JOIN catastro ca ON p.Id_Catastro = ca.Id_Catastro 
                                 inner join anio a on p.Id_Anio=a.Id_Anio 
                                 WHERE ca.Codigo_Catastral=:catastro and a.NomAnio=:anio");
            $registros->bindParam(":catastro", $catastro);
            $registros->bindParam(":anio", $anio);



            $registros->execute();
            $resultados = $registros->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($resultados)) {
                $table = '<table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Documento</th>
                    <th>Nombres</th>
                  </tr>
                </thead>
                <tbody>';

                foreach ($resultados as $value) {
                    $table .= sprintf(
                        '<tr id="fila">
                <td class="text-center">%s</td>
                <td class="text-center">%s</td>
                <td class="text-center">%s</td>
            </tr>',
                        htmlspecialchars($value['codigo'], ENT_QUOTES, 'UTF-8'),
                        htmlspecialchars($value['documento'], ENT_QUOTES, 'UTF-8'),
                        htmlspecialchars($value['nombre_completo'], ENT_QUOTES, 'UTF-8')
                    );
                }

                $table .= '</tbody></table>';
                echo $table;
            }
        } else {
            echo "<td colspan='10' style='text-align:center;'>No registra Propietario</td>";
        }
    }

    public function dtaViacalle() //optimizado
    {
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
        if ($action == 'ajax') {
            $anio_actual = date("Y");
            $searchProducto = isset($_GET['searchViacalle']) ? trim($_GET['searchViacalle']) : '';

            if (!empty($searchProducto)) {
                $sWhere = sprintf("WHERE nv.Nombre_Via LIKE '%%%s%%'", $searchProducto);

                $pdo = Conexion::conectar();
                $query = sprintf(
                    "SELECT 
                    t.Codigo as tipo_via,
                    nv.Nombre_Via as nombre_calle,
                    m.NumeroManzana as numManzana,
                    cu.Numero_Cuadra as cuadra,
                    z.Nombre_Zona as zona,
                    h.Habilitacion_Urbana as habilitacion,
                    a.Importe as arancel,
                    u.Id_Ubica_Vias_Urbano as id,
                    co.Condicion_Catastral as condicion
                FROM arancel_vias av
                INNER JOIN ubica_via_urbano u ON u.Id_Ubica_Vias_Urbano = av.Id_Ubica_Vias_Urbano  
                INNER JOIN direccion d ON u.Id_Direccion = d.Id_Direccion 
                INNER JOIN tipo_via t ON t.Id_Tipo_Via = d.Id_Tipo_Via 
                INNER JOIN zona z ON u.Id_Zona = z.Id_Zona
                INNER JOIN arancel a ON a.Id_Arancel = av.Id_arancel
                INNER JOIN manzana m ON u.Id_Manzana = m.Id_Manzana 
                INNER JOIN cuadra cu ON cu.Id_cuadra = u.Id_Cuadra 
                INNER JOIN habilitaciones_urbanas h ON h.Id_Habilitacion_Urbana = z.Id_Habilitacion_Urbana 
                INNER JOIN condicion_catastral co ON co.Id_Condicion_Catastral = u.Id_Condicion_Catastral 
                INNER JOIN nombre_via nv ON nv.Id_Nombre_Via = d.Id_Nombre_Via
                INNER JOIN anio an ON a.Id_Anio = an.Id_Anio 
                %s AND an.NomAnio = %d",
                    $sWhere,
                    $anio_actual
                );

                $registros = $pdo->prepare($query);
                $registros->execute();
                $resultados = $registros->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($resultados)) {
                    foreach ($resultados as $key => $value) {
                        echo sprintf(
                            '<tr>
                            <td class="text-center">%d</td>
                            <td class="text-center">%s</td>
                            <td class="text-center">%s</td>
                            <td class="text-center">%s</td>
                            
                            <td class="text-center">%s</td>
                            <td class="text-center">%s</td>
                            <td class="text-center">%s</td>
                            <td class="text-center">%s</td>
                            <td class="text-center">%s</td>
                            <td class="text-center">%s</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm agregarvalor_modal_c" id="agregarvalor_modal" idvia="%s">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>',
                            ++$key,
                            htmlspecialchars($value['tipo_via'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($value['nombre_calle'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($value['numManzana'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($value['cuadra'], ENT_QUOTES, 'UTF-8'),
                           
                            htmlspecialchars($value['zona'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($value['habilitacion'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($value['arancel'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($value['id'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($value['condicion'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($value['id'], ENT_QUOTES, 'UTF-8')
                        );
                    }
                } else {
                    echo "<td colspan='12' style='text-align:center;'>La dirección no está registrada</td>";
                }
            } else {
                echo "<span>Digite en el buscador</span>";
            }
        }
    }
    public function dtaViacalle_idvia() //optimizado
    {
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
        if ($action == 'ajax') {
            $anio_actual = date("Y");
            $searchProducto = isset($_GET['searchViacalle']) ? trim($_GET['searchViacalle']) : '';

            if (!empty($searchProducto)) {
                $sWhere = sprintf("WHERE u.Id_Ubica_Vias_Urbano = %d", $searchProducto);

                $pdo = Conexion::conectar();
                $query = sprintf(
                    "SELECT 
                    t.Codigo as tipo_via,
                    nv.Nombre_Via as nombre_calle,
                    m.NumeroManzana as numManzana,
                    cu.Numero_Cuadra as cuadra,
                    z.Nombre_Zona as zona,
                    h.Habilitacion_Urbana as habilitacion,
                    a.Importe as arancel,
                    u.Id_Ubica_Vias_Urbano as id,
                    co.Condicion_Catastral as condicion
                FROM arancel_vias av
                INNER JOIN ubica_via_urbano u ON u.Id_Ubica_Vias_Urbano = av.Id_Ubica_Vias_Urbano  
                INNER JOIN direccion d ON u.Id_Direccion = d.Id_Direccion 
                INNER JOIN tipo_via t ON t.Id_Tipo_Via = d.Id_Tipo_Via 
                INNER JOIN zona z ON u.Id_Zona = z.Id_Zona
                INNER JOIN arancel a ON a.Id_Arancel = av.Id_arancel
                INNER JOIN manzana m ON u.Id_Manzana = m.Id_Manzana 
                INNER JOIN cuadra cu ON cu.Id_cuadra = u.Id_Cuadra 
                INNER JOIN habilitaciones_urbanas h ON h.Id_Habilitacion_Urbana = z.Id_Habilitacion_Urbana 
                INNER JOIN condicion_catastral co ON co.Id_Condicion_Catastral = u.Id_Condicion_Catastral 
                INNER JOIN nombre_via nv ON nv.Id_Nombre_Via = d.Id_Nombre_Via
                INNER JOIN anio an ON a.Id_Anio = an.Id_Anio 
                %s AND an.NomAnio = %d",
                    $sWhere,
                    $anio_actual
                );

                $registros = $pdo->prepare($query);
                $registros->execute();
                $resultados = $registros->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($resultados)) {
                    foreach ($resultados as $key => $value) {
                        echo sprintf(
                            ' <input type="hidden" id="idvia" name="idvia" value="%s"> <tr>
                            <td class="text-center">%s %s</td>
                            <td class="text-center">%s</td>
                            <td class="text-center">%s</td>
                            <td class="text-center">%s</td>
                            <td class="text-center">%s</td>
                            <td class="text-center">%s</td>
                            <td class="text-center">%s</td>
                        </tr>',
                            
                            htmlspecialchars($value['id'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($value['tipo_via'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($value['nombre_calle'], ENT_QUOTES, 'UTF-8'),

                            htmlspecialchars($value['numManzana'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($value['cuadra'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($value['zona'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($value['habilitacion'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($value['arancel'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($value['id'], ENT_QUOTES, 'UTF-8'),
                        );
                    }
                } else {
                    echo "<td colspan='12' style='text-align:center;'>La dirección no está registrada</td>";
                }
            } else {
                echo "<span>Digite en el buscador</span>";
            }
        }
    }
    /* Lista de Catastro Rural en el Pop up de Agregar Predio*/
    public function dtaViacalle_Rustico()
    {
        $action = ($_REQUEST['action'] ?? '') === 'ajax' ? 'ajax' : '';
        if ($action === 'ajax') {
            $searchProducto = $_GET['searchViacallePredio'] ?? '';
            $anio = $_GET['anio'] ?? '';

            if (!empty($searchProducto)) {
                $pdo = Conexion::conectar();
                $sql = "SELECT 
                          z.Id_zona_rural as id_zona_rural,
                          h.Id_valores_categoria_x_hectarea as id,
                          a.NomAnio as anio, 
                          z.nombre_zona as nombre_zona,
                          g.Altura as altura,
                          ar.Arancel as arancel,
                          c.Categoria_Calidad_Agricola as categoria_calidad,
                          c.Nombre_Grupo_Tierra as grupo_tierra
                      FROM 
                          arancel_rustico_hectarea arh 
                          INNER JOIN valores_categoria_x_hectarea h ON h.Id_valores_categoria_x_hectarea=arh.Id_valores_categoria_x_hectarea
                          INNER JOIN arancel_rustico ar ON ar.Id_Arancel_Rustico=arh.Id_Arancel_Rustico 
                          INNER JOIN calidad_agricola c ON c.Id_Calidad_Agricola=h.Id_Calidad_Agricola 
                          INNER JOIN grupo_tierra g ON g.Id_Grupo_Tierra=h.Id_Grupo_Tierra 
                          INNER JOIN zona_rural z ON z.Id_Zona_Rural=h.Id_Zona_Rural 
                          INNER JOIN anio a ON a.Id_Anio=ar.Id_Anio 
                      WHERE 
                          ar.Id_Anio=:anio AND z.nombre_zona LIKE :searchProducto";

                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':anio', $anio, PDO::PARAM_INT);
                $stmt->bindValue(':searchProducto', "%$searchProducto%", PDO::PARAM_STR);
                $stmt->execute();
                $registros = $stmt->fetchAll();

                if (!empty($registros)) {
                    foreach ($registros as $key => $value) {
                        echo '<tr>
                              <td>' . ++$key . '</td>
                              <td>' . $value['nombre_zona'] . '</td>
                              <td>' . $value['id_zona_rural'] . '</td>
                              <td>' . $value['altura'] . '</td>
                              <td>' . $value['categoria_calidad'] . '</td>
                              <td>' . $value['grupo_tierra'] . '</td>
                              <td>' . $value['arancel'] . '</td>
                              <td>' . $value['anio'] . '</td>
                              <td>' . $value['id'] . '</td>
                              <td>
                                  <div class="btn-group">
                                      <button class="btn btn-primary btn-sm agregar_modal_rustico" id="agregar_modal_rustico"><i class="fa fa-plus"></i></button>
                                  </div>
                              </td>
                          </tr>';
                    }
                } else {
                    echo "<td colspan='10' style='text-align:center;'>La zona rural no está registrada</td>";
                }
            } else {
                echo "<span>Digitar en el buscador</span>";
            }
        }
    }
    //REGISTRO DE PREDIO -  AGREGAR VIA CALLE MODAL DESDE REGISTRO DE PREDIOS
    public function dtaViacallePredio() //optimizado
    {
        $action = isset($_REQUEST['action']) && $_REQUEST['action'] != NULL ? $_REQUEST['action'] : '';
        if ($action == 'ajax') {
            $perfilUsuario = $_REQUEST['perfilOculto_predio'];
            $searchProducto = $_GET['searchViacallePredio'];
            $anio = $_GET['anio'];
            $aColumns = 'Nombre_Via'; // Columnas de búsqueda
            $sWhere = "";

            if (!empty(trim($searchProducto))) {
                $sWhere = "WHERE $aColumns LIKE :searchProducto";
            }

            $pdo = Conexion::conectar();
            $query = "SELECT 
                      t.Codigo as tipo_via,
                      nv.Nombre_Via as nombre_calle,
                      m.NumeroManzana as numManzana,
                      cu.Numero_Cuadra as cuadra,
             
                      z.Nombre_Zona as zona,
                      h.Habilitacion_Urbana as habilitacion,
                      a.Importe as arancel,
                      u.Id_Ubica_Vias_Urbano as id,
                      co.Condicion_Catastral as condicion
                    FROM arancel_vias av
                    INNER JOIN ubica_via_urbano u ON u.Id_Ubica_Vias_Urbano = av.Id_Ubica_Vias_Urbano
                    INNER JOIN direccion d ON u.Id_Direccion = d.Id_Direccion
                    INNER JOIN tipo_via t ON t.Id_Tipo_Via = d.Id_Tipo_Via
                    INNER JOIN zona z ON u.Id_Zona = z.Id_Zona
                    INNER JOIN arancel a ON a.Id_Arancel = av.Id_arancel
                    INNER JOIN manzana m ON u.Id_Manzana = m.Id_Manzana
                    INNER JOIN cuadra cu ON cu.Id_cuadra = u.Id_Cuadra
                 
                    INNER JOIN habilitaciones_urbanas h ON h.Id_Habilitacion_Urbana = z.Id_Habilitacion_Urbana
                    INNER JOIN condicion_catastral co ON co.Id_Condicion_Catastral = u.Id_Condicion_Catastral
                    INNER JOIN nombre_via nv ON nv.Id_Nombre_Via = d.Id_Nombre_Via
                    $sWhere AND a.Id_Anio = :anio
                    ORDER BY nombre_calle, cuadra, zona";

            $registros = $pdo->prepare($query);

            if (!empty(trim($searchProducto))) {
                $searchParam = "%" . $searchProducto . "%";
                $registros->bindParam(':searchProducto', $searchParam, PDO::PARAM_STR);
            }

            $registros->bindParam(':anio', $anio, PDO::PARAM_INT);
            $registros->execute();
            $registros = $registros->fetchAll(PDO::FETCH_ASSOC);

            if (count($registros) > 0) {
                $this->generateTableRows($registros);
            } else {
                echo "<td colspan='12' class='text-center'>La direccion no está registrada</td>";
            }
        } else {
            echo "<td colspan='12' class='text-center'>Digitar en el buscador</td>";
        }
    }

    private function generateTableRows($registros)
    {
        foreach ($registros as $key => $value) {
            echo '<tr>
              <td>' . ++$key . '</td>
              <td>' . $value['tipo_via'] . '</td>
              <td>' . $value['nombre_calle'] . '</td>
              <td>' . $value['numManzana'] . '</td>
              <td>' . $value['cuadra'] . '</td>
              <td>' . $value['zona'] . '</td>
              <td>' . $value['habilitacion'] . '</td>
              <td>' . $value['arancel'] . '</td>
              <td>' . $value['id'] . '</td>
              <td>' . $value['condicion'] . '</td>
              <td><div class="btn-group">
                  <button class="btn btn-primary btn-sm agregarvalor_modal_Predio_via" id="agregarvalor_modal_Predio_via"><i class="fa fa-plus"></i></button>
              </div></td>
          </tr>';
        }
    }
    public function dtaPropietario() //optimizado
    {
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
        if ($action == 'ajax') {
            $searchProducto = isset($_GET['searchPropietario']) ? $_GET['searchPropietario'] : '';

            if ($searchProducto) {
                $pdo = Conexion::conectar();
                $aColumns = array('Id_Contribuyente', 'Documento', 'Nombre_Completo');
                $sWhere = "WHERE ";

                // Construir la condición de búsqueda
                foreach ($aColumns as $column) {
                    $sWhere .= "$column LIKE :search OR ";
                }
                $sWhere = rtrim($sWhere, "OR ");

                // Preparar y ejecutar la consulta
                $stmt = $pdo->prepare("SELECT * FROM contribuyente $sWhere");
                $stmt->execute([':search' => "%$searchProducto%"]);
                $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Mostrar los resultados
                if ($registros) {
                    foreach ($registros as $key => $value) {
                        echo '<tr>
                              <td class="text-center">' . ++$key . '</td>
                              <td class="text-center"> ' . $value['Id_Contribuyente'] . '</td>
                              <td class="text-center"> ' . $value['Documento'] . '</td>
                              <td class="text-center"> ' . $value['Nombre_Completo'] . '</td>
                              <td class="text-center">
                                  <div class="btn-group ">
                                      <button class="btn btn-primary btn-sm agregarvalor_modal_pro" id="agregarvalor_modal">
                                          <i class="fa fa-plus"></i>
                                      </button>
                                  </div>
                              </td>
                          </tr>';
                    }
                } else {
                    echo "<td colspan='10' style='text-align:center;'>No existe Contribuyente</td>";
                }
            } else {
                echo "<span>Ingrese un término de búsqueda</span>";
            }
        }
    }

    public function dtaContribuyentesAgua() //optimizado
    {
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
        if ($action == 'ajax') {
            $perfilUsuario = $_REQUEST['perfilOculto_c'];
            $tipoBusqueda = strtolower($_REQUEST['tipo']);
            $searchProducto = $_GET['searchContribuyente'];

            // Definir el campo de búsqueda basado en el tipo de búsqueda
            switch ($tipoBusqueda) {
                case 'search_codigo':
                    $campoBusqueda = 'Id_Contribuyente';
                    break;
                case 'search_dni':
                    $campoBusqueda = 'Documento';
                    break;
                default:
                    $campoBusqueda = 'Nombre_Completo';
                    break;
            }

            $sWhere = "";
            if (!empty($searchProducto)) {
                $sWhere = "WHERE $campoBusqueda LIKE '%$searchProducto%'";
                if ($tipoBusqueda == 'search_codigo' || $tipoBusqueda == 'search_dni') {
                    $sWhere = "WHERE $campoBusqueda = '$searchProducto'";
                }
            } else {
                echo "<td colspan='10'>Digite en el buscador</td>";
                return;
            }

            $pdo = Conexion::conectar();
            $registros = $pdo->prepare("SELECT 
                                    c.Codigo_sa as codigo_sa,
                                    c.Estado as Estado,
                                    c.Id_Contribuyente as id_contribuyente,
                                    td.descripcion as tipo_documento,
                                    c.Documento as documento,
                                    c.Nombre_Completo as nombre_completo,
                                    c.Direccion_completo as direccion_completo
                                    FROM contribuyente c 
                                    INNER JOIN tipo_documento_siat td ON td.Id_Tipo_Documento = c.Id_Tipo_Documento 
                                    $sWhere");
            $registros->execute();
            $registros = $registros->fetchAll();
            $pdo = null;

            if (count($registros) > 0) {
                foreach ($registros as $key => $value) {
                    $activo = ($value['Estado'] == '1') ? 'checked' : '';
                    ?>
                    <tr>
                        <td class="text-center"><?= ++$key ?></td>
                        <td class="text-center"><?= $value['id_contribuyente'] ?></td>
                        <td class="text-center"><?= $value['tipo_documento'] ?></td>
                        <td class="text-center"><?= $value['documento'] ?></td>
                        <td><?= $value['nombre_completo'] ?></td>
                        <td><?= $value['direccion_completo'] ?></td>
                        <td class="text-center">
                            <div class="modo-contenedor-selva">
                                <input type="checkbox" data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger" id="usuarioEstado" name="usuarioEstado<?= $value['Estado'] ?>" value="<?= $value['Estado'] ?>" data-size="mini" data-width="110" idUsuario="<?= $value['id_contribuyente'] ?>" <?= $activo ?>>
                            </div>
                        </td>
                        <td class="text-center">
                            <img src="./vistas/img/iconos/cuenta_o1.png" class="t-icon-tbl-p" init_envio="" idContribuyente_agua="<?= $value['id_contribuyente'] ?>" id="pagina_licencia_agua" parametro_b="licencia_agua" data-target="#modal_predio_propietario" title="Predio">
                        </td>
                    </tr>
        <?php
                }
            } else {
                echo "<td colspan='10' style='text-align:center;'>El contribuyente no está registrado</td>";
            }
        }
    }

        public function dtaPrescripcion()
    {
        $action = ($_REQUEST['action'] ?? null) ? $_REQUEST['action'] : '';
        if ($action == 'ajax') {
            $perfilUsuario = $_REQUEST['perfilOculto_c'];
            $tipoBusqueda = strtolower($_REQUEST['tipo']);
            $searchProducto = $_GET['searchContribuyente'];

            // Definir el campo de búsqueda basado en el tipo de búsqueda
            switch ($tipoBusqueda) {
                case 'search_codigo':
                    $campoBusqueda = 'Id_Contribuyente';
                    break;
                case 'search_dni':
                    $campoBusqueda = 'Documento';
                    break;
                case 'search_codigo_sa':
                    $campoBusqueda = 'Codigo_sa';
                    break;
                default:
                    $campoBusqueda = 'Nombre_Completo';
                    break;
            }

            $sWhere = "";
            $idContribuyentesString = ""; // Variable para almacenar IDs separados por guiones

            if (!empty($searchProducto)) {
                if ($tipoBusqueda == 'search_codigo' || $tipoBusqueda == 'search_dni') {
                    $sWhere = "WHERE $campoBusqueda = :searchProducto";
                } else if ($tipoBusqueda == 'search_nombres') {
                    $sWhere = "WHERE $campoBusqueda LIKE :searchProducto";
                    $searchProducto = "%$searchProducto%";
                }

                $pdo = Conexion::conectar();

                if ($tipoBusqueda == 'search_codigo_sa') {
                    $stmt = $pdo->prepare("SELECT Concatenado_id FROM carpeta WHERE Codigo_Carpeta = :carpeta");
                    $stmt->bindParam(":carpeta", $searchProducto);
                    $stmt->execute();
                    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($registros)) {
                        $codigoCarpeta = $registros[0]['Concatenado_id'];
                        $codigosArray = explode('-', $codigoCarpeta);
                        $placeholders = implode(',', array_fill(0, count($codigosArray), '?'));
                        $sWhere = "WHERE c.Id_Contribuyente IN ($placeholders)";
                    } else {
                        echo "<td colspan='12' style='text-align:center;'>El código de carpeta no se encontró</td>";
                        $pdo = null;
                        return;
                    }
                }

                // Preparar y ejecutar la consulta principal
                $stmt = $pdo->prepare("SELECT 
                                        c.Id_Ubica_Vias_Urbano as ubicacionvia,
                                        c.Estado as Estado,
                                        c.Id_Contribuyente as id_contribuyente,
                                        td.descripcion as tipo_documento,
                                        c.Documento as documento,
                                        c.Nombre_Completo as nombre_completo,
                                        c.Direccion_completo as direccion_completo
                                        FROM contribuyente c 
                                        INNER JOIN tipo_documento_siat td ON td.Id_Tipo_Documento = c.Id_Tipo_Documento
                                        $sWhere");

                if ($tipoBusqueda == 'search_codigo_sa') {
                    $stmt->execute($codigosArray);
                } else {
                    $stmt->execute(['searchProducto' => $searchProducto]);
                }

                $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Construir la cadena con id_contribuyente separados por guiones
                if (!empty($registros)) {
                    $idContribuyentes = array();
                    foreach ($registros as $registro) {
                        $idContribuyentes[] = $registro['id_contribuyente'];
                    }
                    $idContribuyentesString = implode('-', $idContribuyentes);
                }

                // Obtener el Código_Carpeta y agregarlo a cada contribuyente
                if ($tipoBusqueda == 'search_codigo_sa' && !empty($codigosArray)) {
                    foreach ($registros as &$contribuyente) {
                        $stmtCarpeta = $pdo->prepare("SELECT Codigo_Carpeta FROM carpeta WHERE Concatenado_id = :concatenado_id");
                        $stmtCarpeta->bindParam(":concatenado_id", $codigoCarpeta);
                        $stmtCarpeta->execute();
                        $carpetaResult = $stmtCarpeta->fetch(PDO::FETCH_ASSOC);

                        if ($carpetaResult) {
                            $contribuyente['Codigo_Carpeta'] = $carpetaResult['Codigo_Carpeta'];
                        } else {
                            $contribuyente['Codigo_Carpeta'] = ''; // Si no encuentra el código de carpeta, asigna una cadena vacía
                        }
                    }
                } else if (!empty($idContribuyentesString)) {
                    foreach ($registros as &$contribuyente) {
                        $stmtCarpeta = $pdo->prepare("SELECT Codigo_Carpeta FROM carpeta WHERE Concatenado_id = :concatenado_id");
                        $stmtCarpeta->bindParam(":concatenado_id", $idContribuyentesString);
                        $stmtCarpeta->execute();
                        $carpetaResult = $stmtCarpeta->fetch(PDO::FETCH_ASSOC);

                        if ($carpetaResult) {
                            $contribuyente['Codigo_Carpeta'] = $carpetaResult['Codigo_Carpeta'];
                        } else {
                            $contribuyente['Codigo_Carpeta'] = ''; // Si no encuentra el código de carpeta, asigna una cadena vacía
                        }
                    }
                }
                $pdo = null;
                if (!empty($registros)) {
                    foreach ($registros as $key => $value) {
                        $activo = ($value['Estado'] == '1') ? 'checked' : '';
                        ?>
                        <tr id="tr_id_contribuyente" idContribuyente_predio_propietario="<?= $value['id_contribuyente'] ?>" init_envio="" id="predio_propietario" parametro_b="prescripcion" data-target="#modal_predio_propietario" title="Predio">
                            <td class="text-center"><?= ++$key ?></td>
                            <td class="text-center"><?= $value['id_contribuyente'] ?></td>
                            <td class="text-center"><?= $value['tipo_documento'] ?></td>
                            <td class="text-center"><?= $value['documento'] ?></td>
                            <td id="nombre_contribuyente" name="<?= $value['nombre_completo'] ?>"><?= $value['nombre_completo'] ?></td>
                            <td><?= $value['direccion_completo'] ?></td>
                            <td class="text-center">
                                <i class="bi bi-house-gear-fill lis_ico_con" title="Predio" idContribuyente_predio_propietario="<?= $value['id_contribuyente'] ?>" init_envio="" id="predio_propietario" parametro_b="prescripcion" data-target="#modal_predio_propietario" title="Predio"></i>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<td colspan='12' style='text-align:center;'>El contribuyente no está registrado</td>";
                }
            } else {
                echo "<td colspan='12' style='text-align:center;'>Digite en el filtro</td>";
            }
        }
    }
}

$requestMap = [
    'dpLicenciaAgua' => 'dtaContribuyentesAgua',
    'dpcontribuyente' => 'dtaContribuyente',
     'dpcontribuyentem' => 'dtaContribuyenteM',
    'dpcontribuyente_caja' => 'dtaContribuyente_caja',
    'dpLicenciaAguaLista' => 'dtaContribuyente_agua_lista',
    'dpLicenciaAguaLista_caja' => 'dtaContribuyente_agua_lista_caja',
    'dpcontribuyente_impuesto' => 'dtaContribuyente_impuesto',
    'recaudacion_dpcontribuyente_impuesto' => 'recaudacion_dtaContribuyente_impuesto',
    'dppredio' => 'dtaPredio',
    'dppredioh' => 'dtaPredioh',
    'dppredio_propietario' => 'dtaPredio_propietario',
    'dpViacalle' => 'dtaViacalle',
    'dpViacalle_idvia' => 'dtaViacalle_idvia',
    'dpViacallePredioRustico' => 'dtaViacalle_Rustico',
    'dpViacallePredio' => 'dtaViacallePredio',
    'dpPropietario' => 'dtaPropietario',
    'dpPrescripcion' => 'dtaPrescripcion',
];

foreach ($requestMap as $requestKey => $method) {
    if (isset($_REQUEST[$requestKey]) && $_REQUEST[$requestKey] == $requestKey) {
        $dataTables = new DataTables();
        $dataTables->$method();
        break; // Assuming only one request key will be set at a time
    }
}
