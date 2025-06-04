<?php

namespace Controladores;

use Modelos\ModeloContribuyente;
use Conect\Conexion;
use PDO;

class ControladorContribuyente
{
  // REGISTRO DE CONTRIBUYENTE
  public static function ctrCrearContribuyente($datos)
  {
    $tabla = 'contribuyente';
    $datoscodigo = $datos['Documento'];
    if ($datoscodigo!="-") {
        $codigo = ModeloContribuyente::ejecutar_consulta_simple("SELECT Documento FROM $tabla  WHERE Documento='$datoscodigo'");
        if ($codigo->rowcount() > 0) {
          return "DNI";
        }
        else{
          $respuesta = ModeloContribuyente::mdlNuevoContribuyente($tabla, $datos);
          if ($respuesta == 'ok') {
            return "OK";
          }
        }
      }
    else{
      $respuesta = ModeloContribuyente::mdlNuevoContribuyente($tabla, $datos);
      if ($respuesta == 'ok') {
        return "OK";
      }
    }
  
  }


  public static function ctrMostrarData($tabla)
  {
    $respuesta = ModeloContribuyente::mdlMostrarData($tabla);
    return $respuesta;
  }

  // MOSTRAR USUARIOS|
  public static function ctrMostrarContribuyente($item, $valor)
  {
    $tabla = 'contribuyente';
    $respuesta = ModeloContribuyente::mdlMostrarContribuyente($tabla, $item, $valor);
    return $respuesta;
  }

  // MOSTRAR CONTRIBUYENTES CALCULAR IMPUESTO
  public static function ctrContribuyente_impuesto($datos)
  {
    $tabla = 'contribuyente';
    $respuesta = ModeloContribuyente::mdlMostrarValores_parametro_get_impuesto($tabla, $datos);
    foreach ($respuesta as $valor => $filas) {
      foreach ($filas as $fila) {
        echo '<tr>
                      <td id="#idc_i" class="text-center">' . $fila['Id_Contribuyente'] . '</td>
                      <td class="text-center">' . $fila['Documento'] . '</td>
                      <td class="text-center" colspan="4">' . $fila['Nombres'] . ' ' . $fila['Apellido_Paterno'] . ' ' . $fila['Apellido_Materno'] . '</td>
                      
                      </tr>';
      }
    }
  }

  // Mostrar Predio Propietario
  public static function ctrPredio_Propietario($idContribuyente, $parametro_b, $init_envio,$anio,$area_usuario,$coactivo )
  {
    // $respuesta = ModeloContribuyente::mdlPredio_Propietario($datos);
    $pdo = Conexion::conectar();
    switch ($parametro_b) {
      case "r_c":
        $query = "SELECT DISTINCT 
                    c.Documento as dni,
                    c.Nombre_Completo AS nombres,
                    GROUP_CONCAT(CONCAT('<b>', cp.Documento, '</b> ', cp.Nombre_Completo) SEPARATOR ' ---- ') AS co_propietarios,
                    COALESCE(CONCAT(c.Id_Contribuyente, '-', GROUP_CONCAT(cp.Id_Contribuyente SEPARATOR '-')), c.Id_Contribuyente) AS id_concatenado
                    FROM contribuyente c 
                    INNER JOIN (
                              SELECT DISTINCT t.Id_Contribuyente, t.Id_Predio
                              FROM propietario t
                              INNER JOIN predio p ON t.Id_Predio = p.Id_Predio
                              WHERE t.Baja='1' 
                               ORDER BY t.Id_Contribuyente
                    ) AS temp ON c.Id_Contribuyente = temp.Id_Contribuyente 
                    INNER JOIN predio p ON temp.Id_Predio = p.Id_Predio 
                    INNER JOIN anio a ON a.Id_Anio = p.Id_Anio 
                    LEFT JOIN (
                              SELECT DISTINCT t2.Id_Predio, t2.Id_Contribuyente
                              FROM propietario t2
                              WHERE t2.Baja='1'
                               ORDER BY t2.Id_Contribuyente
                    ) AS po2 ON temp.Id_Predio = po2.Id_Predio AND temp.Id_Contribuyente != po2.Id_Contribuyente 
                    LEFT JOIN contribuyente cp ON po2.Id_Contribuyente = cp.Id_Contribuyente 
                    WHERE c.Id_Contribuyente = :idContribuyente and a.NomAnio=$anio
                    GROUP BY c.Id_Contribuyente, p.Id_Predio 
                    ORDER BY co_propietarios;
            ";

        $segundaConsulta = $pdo->prepare($query);
        $segundaConsulta->bindParam(':idContribuyente', $idContribuyente, PDO::PARAM_INT);
        $segundaConsulta->execute();
        $coPropietarios = $segundaConsulta->fetchAll(PDO::FETCH_ASSOC);
        if (count($coPropietarios) > 0) {
          $correlativo = 1;
          foreach ($coPropietarios as $coPropietario) {

             /* carpeta*/
             $id_concatenado = $coPropietario["id_concatenado"];
             $array_ids = explode('-', $id_concatenado);
             sort($array_ids);
             $id_concatenado_ordenado = implode('-', $array_ids);
             $stmt = $pdo->prepare("SELECT Codigo_Carpeta FROM carpeta WHERE Concatenado_id=:concatenado_id");
             $stmt->bindParam(':concatenado_id', $id_concatenado_ordenado, PDO::PARAM_STR);
             $stmt->execute();
             if ($stmt->rowCount() > 0) {
               // Obtener el resultado como un array asociativo
               $result = $stmt->fetch(PDO::FETCH_ASSOC);
             $codigo_carpeta = $result['Codigo_Carpeta'];
             $carpeta=$codigo_carpeta;
             }
             else{
               $carpeta= '-';
             }
             //carpeta

            $nombres = htmlspecialchars($coPropietario['nombres'], ENT_QUOTES, 'UTF-8');
            $dni = htmlspecialchars($coPropietario['dni'], ENT_QUOTES, 'UTF-8');
            $coPropietariosList = $coPropietario['co_propietarios'] ? $coPropietario['co_propietarios'] : ''; // No escape here because it includes HTML
            $idConcatenado = htmlspecialchars($coPropietario['id_concatenado'], ENT_QUOTES, 'UTF-8');
            $coPropietariosText = $coPropietariosList ? '<b>' . $dni . '</b> ' .  $nombres . ' ---- ' . $coPropietariosList : $nombres;

            echo '<tr class="">
                    <td  class="text-center">' . $correlativo . '</td>
                    <td >' . $coPropietariosText . '</td>
                     <td class="text-center">' .$carpeta . '</td>';

            if ($init_envio != 'pagado_006_743') {

              if ($area_usuario !== 'OFICINA DE EJECUCION COACTIVA'&& $coactivo === 'Si') 
              {
                 echo '<td class="text-center">
                      
                        </td>';
              }
              elseif ($area_usuario === 'OFICINA DE EJECUCION COACTIVA' && ($coactivo  !== 'Si'|| $coactivo === 'No')){
                echo '<td class="text-center">
                        <img src="./vistas/img/iconos/cuenta_o1.png" id="p_i" class="t-icon-tbl-p btnCuenta" title="estado cuenta" idContribuyente_cuenta="' . $idConcatenado . '">
                     </td>';
              }
                 
              
            
            } else {
              echo '<td class="text-center">
                      <img src="./vistas/img/iconos/cuenta_o1.png" id="p_i" class="t-icon-tbl-p btnCuenta_pagado" title="estado cuenta" idContribuyente_cuenta="' . $idConcatenado . '">
                   </td>';
            }
            echo '</tr>';
            $correlativo++;
          }
        } else {
          echo "<td colspan='10' style='text-align:center;'>El contribuyente no tiene Predio(s)</td>";
        }

        $pdo = null;
        break;
        //contribuyente - agua-recuadacion
      case "c_b":
        $query = "SELECT DISTINCT 
                      c.Documento as dni,
                      c.Nombre_Completo AS nombres,
                      GROUP_CONCAT(CONCAT('<b>', cp.Documento, '</b> ', cp.Nombre_Completo) SEPARATOR ' ---- ') AS co_propietarios,
                      COALESCE(CONCAT(c.Id_Contribuyente, '-', GROUP_CONCAT(cp.Id_Contribuyente SEPARATOR '-')), c.Id_Contribuyente) AS id_concatenado,
                      c.Coactivo as coactivo
                  FROM contribuyente c 
                  INNER JOIN (
                      SELECT DISTINCT t.Id_Contribuyente, t.Id_Predio
                      FROM propietario t
                      INNER JOIN predio p ON t.Id_Predio = p.Id_Predio
                      WHERE  t.Baja='1' 
                       ORDER BY t.Id_Contribuyente
                  ) AS temp ON c.Id_Contribuyente = temp.Id_Contribuyente 
                  INNER JOIN predio p ON temp.Id_Predio = p.Id_Predio 
                  INNER JOIN anio a ON a.Id_Anio = p.Id_Anio 
                  LEFT JOIN (
                      SELECT DISTINCT t2.Id_Predio, t2.Id_Contribuyente
                      FROM propietario t2
                      WHERE  t2.Baja='1'
                       ORDER BY t2.Id_Contribuyente
                  ) AS po2 ON temp.Id_Predio = po2.Id_Predio AND temp.Id_Contribuyente != po2.Id_Contribuyente 
                  LEFT JOIN contribuyente cp ON po2.Id_Contribuyente = cp.Id_Contribuyente 
                  WHERE c.Id_Contribuyente = :idContribuyente  and a.NomAnio=$anio
                  GROUP BY c.Id_Contribuyente, p.Id_Predio 
                  ORDER BY co_propietarios;
              ";

        $segundaConsulta = $pdo->prepare($query);
        $segundaConsulta->bindParam(':idContribuyente', $idContribuyente, PDO::PARAM_INT);
        $segundaConsulta->execute();
        $coPropietarios = $segundaConsulta->fetchAll(PDO::FETCH_ASSOC);
        $correlativo = 1;

    
        if (count($coPropietarios) > 0) {
          foreach ($coPropietarios as $coPropietario) {


            /* carpeta*/
            $id_concatenado = $coPropietario["id_concatenado"];
            $array_ids = explode('-', $id_concatenado);
            sort($array_ids);
            $id_concatenado_ordenado = implode('-', $array_ids);
            $stmt = $pdo->prepare("SELECT Codigo_Carpeta FROM carpeta WHERE Concatenado_id=:concatenado_id");
            $stmt->bindParam(':concatenado_id', $id_concatenado_ordenado, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
              // Obtener el resultado como un array asociativo
              $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $codigo_carpeta = $result['Codigo_Carpeta'];
            $carpeta=$codigo_carpeta;
            }
            else{
              $carpeta= '-';
            }
            //carpeta


              $nombres = htmlspecialchars($coPropietario['nombres'], ENT_QUOTES, 'UTF-8');
              $dni = htmlspecialchars($coPropietario['dni'], ENT_QUOTES, 'UTF-8');
              $coPropietariosList = $coPropietario['co_propietarios'] ? $coPropietario['co_propietarios'] : '';
              $idConcatenado = htmlspecialchars($coPropietario['id_concatenado'], ENT_QUOTES, 'UTF-8');
              $coPropietariosText = $coPropietariosList ? '<b>' . $dni . '</b> ' . $nombres . ' ---- ' . $coPropietariosList : $nombres;
                
              echo '<tr class="">
                      <td  class="text-center">' . $correlativo . '</td>
                      <td>' . $coPropietariosText . '</td>
                      <td class="text-center">' .$carpeta . '</td>';


                     if($area_usuario !== 'OFICINA DE EJECUCION COACTIVA'&&$coactivo === 'Si'){
                        echo '<td class="text-center">
                              
                              </td>';
                     }
                      else {
                      
                       echo '<td class="text-center">
                                <i class="bi bi-house-fill btnPredios"  title="Predio" idContribuyente_predio="'. $coPropietario["id_concatenado"] .'" estado_Coactivo="'. $coPropietario["coactivo"] .'" nombre_contribuyente="'. $coPropietario["nombres"] .'"</i>
                              </td>';
                      }
                     
                  // Mostrar los años
                  if($area_usuario !== 'OFICINA DE EJECUCION COACTIVA'&&$coactivo === 'Si'){
                      echo '<td class="text-center">
                          
                          </td>';
                  }

                   else {
                    echo '<td class="text-center">
                            <i class="bi bi-wallet-fill btndeuda"  title="Deuda" idContribuyente_predio="'. $coPropietario["id_concatenado"] .'"</i>
                          </td>';
                   }
      // Mostrar los años
             
              echo '</tr>';
      
             
              $correlativo++;
          }
      } else {
          echo "<td colspan='10' style='text-align:center;'>El contribuyente no tiene Predio(s)</td>";
        }
        $pdo = null;
        break;

        // calculo de estado de cuenta
      case "p_c":
        $query = "SELECT DISTINCT 
                c.Documento as dni,
                c.Nombre_Completo AS nombres,
                GROUP_CONCAT(CONCAT('<b>', cp.Documento, '</b> ', cp.Nombre_Completo) SEPARATOR ' ---- ') AS co_propietarios,
                COALESCE(CONCAT(c.Id_Contribuyente, '-', GROUP_CONCAT(cp.Id_Contribuyente SEPARATOR '-')), c.Id_Contribuyente) AS id_concatenado
            FROM contribuyente c 
            INNER JOIN (
                SELECT DISTINCT t.Id_Contribuyente, t.Id_Predio
                FROM propietario t
                INNER JOIN predio p ON t.Id_Predio = p.Id_Predio
                WHERE  t.Baja='1'  ORDER BY t.Id_Contribuyente
            ) AS temp ON c.Id_Contribuyente = temp.Id_Contribuyente 
            INNER JOIN predio p ON temp.Id_Predio = p.Id_Predio 
            INNER JOIN anio a ON a.Id_Anio = p.Id_Anio 
            LEFT JOIN (
                SELECT DISTINCT t2.Id_Predio, t2.Id_Contribuyente
                FROM propietario t2
                WHERE  t2.Baja='1' ORDER BY t2.Id_Contribuyente 
            ) AS po2 ON temp.Id_Predio = po2.Id_Predio AND temp.Id_Contribuyente != po2.Id_Contribuyente 
            LEFT JOIN contribuyente cp ON po2.Id_Contribuyente = cp.Id_Contribuyente 
            WHERE c.Id_Contribuyente = :idContribuyente and a.NomAnio=$anio
            GROUP BY c.Id_Contribuyente, p.Id_Predio 
            ORDER BY co_propietarios;
        ";

        $segundaConsulta = $pdo->prepare($query);
        $segundaConsulta->bindParam(':idContribuyente', $idContribuyente, PDO::PARAM_INT);
        $segundaConsulta->execute();
        $coPropietarios = $segundaConsulta->fetchAll(PDO::FETCH_ASSOC);
        $correlativo = 1;
        
        if (count($coPropietarios) > 0) {
          foreach ($coPropietarios as $coPropietario) {

             /* carpeta*/
             $id_concatenado = $coPropietario["id_concatenado"];
             $array_ids = explode('-', $id_concatenado);
             sort($array_ids);
             $id_concatenado_ordenado = implode('-', $array_ids);
             $stmt = $pdo->prepare("SELECT Codigo_Carpeta FROM carpeta WHERE Concatenado_id=:concatenado_id");
             $stmt->bindParam(':concatenado_id', $id_concatenado_ordenado, PDO::PARAM_STR);
             $stmt->execute();
             if ($stmt->rowCount() > 0) {
               // Obtener el resultado como un array asociativo
               $result = $stmt->fetch(PDO::FETCH_ASSOC);
             $codigo_carpeta = $result['Codigo_Carpeta'];
             $carpeta=$codigo_carpeta;
             }
             else{
               $carpeta= '-';
             }
             //carpeta
            $nombres = htmlspecialchars($coPropietario['nombres'], ENT_QUOTES, 'UTF-8');
            $dni = htmlspecialchars($coPropietario['dni'], ENT_QUOTES, 'UTF-8');
            $coPropietariosList = $coPropietario['co_propietarios'] ? $coPropietario['co_propietarios'] : ''; // No escape here because it includes HTML
            $idConcatenado = htmlspecialchars($coPropietario['id_concatenado'], ENT_QUOTES, 'UTF-8');
            $coPropietariosText = $coPropietariosList ? '<b>' . $dni . '</b> ' .  $nombres . ' ---- ' . $coPropietariosList : $nombres;

             
            echo '<tr class="">';
              echo '<td class="text-center">' . $correlativo . '</td>';
              echo '<td>' . $coPropietariosText . '</td>';
              echo '<td class="text-center">' . $carpeta . '</td>';

              // Mostrar el primer campo solo si el área no es 'GERENCIA DE ADMINISTRACION TRIBUTARIA'
            
               if($area_usuario !== 'OFICINA DE EJECUCION COACTIVA'&&$coactivo === 'Si'){
                  echo '<td class="text-center">
                         
                        </td>';
              }
              else{
                     echo '<td class="text-center">
                          <img src="./vistas/img/iconos/calcular2.png" id="p_i" class="t-icon-tbl-p btnCalcular_impuesto" title="calcular" idContribuyente_predio="' . $coPropietario["id_concatenado"] . '" data-toggle="modal" data-target="#modalCalcularImpuesto">
                        </td>';

              }

              // Mostrar el segundo campo solo si el área no es 'GERENCIA DE ADMINISTRACION TRIBUTARIA'
              if($area_usuario !== 'OFICINA DE EJECUCION COACTIVA'&&$coactivo === 'Si'){
                  echo '<td class="text-center">
                        
                        </td>';
              }
              else{
                    echo '<td class="text-center">
                          <img src="./vistas/img/iconos/formato2.png" id="p_i" class="t-icon-tbl-p btnImprimir_cartilla" title="imprimir formatos" idContribuyente_formato="' . $coPropietario["id_concatenado"] . '" data-toggle="modal" data-target="#modalImprimirFormato">
                        </td>';

              }

              // Mostrar el tercer campo solo si el área no es 'GERENCIA DE ADMINISTRACION TRIBUTARIA'
             if($area_usuario !== 'OFICINA DE EJECUCION COACTIVA'&&$coactivo === 'Si'){
                  echo '<td class="text-center">
                          
                        </td>';
              }
              else{
                  echo '<td class="text-center">
                          <img src="./vistas/img/iconos/tim.png" id="p_img" class="t-icon-tbl-p btnCalcularTim_img" title="Calcular Tim" idContribuyente_tim="' . $coPropietario["id_concatenado"] . '" data-toggle="modal" data-target="#modalCalcularTim">
                        </td>';
              }

              echo '</tr>';



            // echo '<tr class="">
            //   <td class="text-center">' . $correlativo . '</td>
            //   <td>' . $coPropietariosText . '</td>
            //    <td class="text-center">' .$carpeta . '</td>

            //   <td class="text-center">
            //   <img src="./vistas/img/iconos/calcular2.png"  id="p_i" class="t-icon-tbl-p btnCalcular_impuesto" title="calcular" idContribuyente_predio="' . $coPropietario["id_concatenado"] . '"data-toggle="modal" data-target="#modalCalcularImpuesto">
            //   </td>
              
            //   <td class="text-center">
            //   <img src="./vistas/img/iconos/formato2.png"  id="p_i" class="t-icon-tbl-p btnImprimir_cartilla" title="imprimir formatos" idContribuyente_formato="' . $coPropietario["id_concatenado"] . '" data-toggle="modal" data-target="#modalImprimirFormato">
            //   </td>
            //   <td class="text-center">
            //   <img src="./vistas/img/iconos/tim.png"  id="p_img" class="t-icon-tbl-p btnCalcularTim_img" title="Calcular Tim" idContribuyente_tim="' . $coPropietario["id_concatenado"] . '" data-toggle="modal" data-target="#modalCalcularTim">
            //   </td>



            //   </tr>';
            $correlativo++;
          }
        } else {
          echo "<td colspan='10' style='text-align:center;'>El contribuyente no tiene Predio(s)</td>";
        }
        $pdo = null;
        break;

        //contribuyente - agua - recaudacion
      case "r_e":
        $query = "SELECT DISTINCT 
                c.Documento as dni,
                c.Nombre_Completo AS nombres,
                GROUP_CONCAT(CONCAT('<b>', cp.Documento, '</b> ', cp.Nombre_Completo) SEPARATOR ' ---- ') AS co_propietarios,
                COALESCE(CONCAT(c.Id_Contribuyente, '-', GROUP_CONCAT(cp.Id_Contribuyente SEPARATOR '-')), c.Id_Contribuyente) AS id_concatenado
            FROM contribuyente c 
            INNER JOIN (
                SELECT DISTINCT t.Id_Contribuyente, t.Id_Predio
                FROM propietario t
                INNER JOIN predio p ON t.Id_Predio = p.Id_Predio
                WHERE  t.Baja='1'  ORDER BY t.Id_Contribuyente
            ) AS temp ON c.Id_Contribuyente = temp.Id_Contribuyente 
            INNER JOIN predio p ON temp.Id_Predio = p.Id_Predio 
            INNER JOIN anio a ON a.Id_Anio = p.Id_Anio 
            LEFT JOIN (
                SELECT DISTINCT t2.Id_Predio, t2.Id_Contribuyente
                FROM propietario t2
                WHERE  t2.Baja='1'  ORDER BY t2.Id_Contribuyente
            ) AS po2 ON temp.Id_Predio = po2.Id_Predio AND temp.Id_Contribuyente != po2.Id_Contribuyente 
            LEFT JOIN contribuyente cp ON po2.Id_Contribuyente = cp.Id_Contribuyente 
            WHERE c.Id_Contribuyente = :idContribuyente and a.NomAnio=$anio
            GROUP BY c.Id_Contribuyente, p.Id_Predio 
            ORDER BY co_propietarios;
  ";

        $segundaConsulta = $pdo->prepare($query);
        $segundaConsulta->bindParam(':idContribuyente', $idContribuyente, PDO::PARAM_INT);
        $segundaConsulta->execute();
        $coPropietarios = $segundaConsulta->fetchAll(PDO::FETCH_ASSOC);
        $correlativo = 1;
        if (count($coPropietarios) > 0) {
          foreach ($coPropietarios as $coPropietario) {

             /* carpeta*/
             $id_concatenado = $coPropietario["id_concatenado"];
             $array_ids = explode('-', $id_concatenado);
             sort($array_ids);
             $id_concatenado_ordenado = implode('-', $array_ids);
             $stmt = $pdo->prepare("SELECT Codigo_Carpeta FROM carpeta WHERE Concatenado_id=:concatenado_id");
             $stmt->bindParam(':concatenado_id', $id_concatenado_ordenado, PDO::PARAM_STR);
             $stmt->execute();
             if ($stmt->rowCount() > 0) {
               // Obtener el resultado como un array asociativo
               $result = $stmt->fetch(PDO::FETCH_ASSOC);
             $codigo_carpeta = $result['Codigo_Carpeta'];
             $carpeta=$codigo_carpeta;
             }
             else{
               $carpeta= '-';
             }
             //carpeta


            $nombres = htmlspecialchars($coPropietario['nombres'], ENT_QUOTES, 'UTF-8');
            $dni = htmlspecialchars($coPropietario['dni'], ENT_QUOTES, 'UTF-8');
            $coPropietariosList = $coPropietario['co_propietarios'] ? $coPropietario['co_propietarios'] : ''; // No escape here because it includes HTML
            $idConcatenado = htmlspecialchars($coPropietario['id_concatenado'], ENT_QUOTES, 'UTF-8');
            $coPropietariosText = $coPropietariosList ? '<b>' . $dni . '</b> ' .  $nombres . ' ---- ' . $coPropietariosList : $nombres;

            echo '<tr class="">
        <td class="text-center">' . $correlativo . '</td>
        <td >' . $coPropietariosText . '</td>
         <td class="text-center">' .$carpeta . '</td>
        <td class="text-center">
        <img src="./vistas/img/iconos/cuenta_o1.png" class="t-icon-tbl-p btnCuentaAgua_lista" title="Licencia Agua"  idContribuyente_consulta_deuda="' . $coPropietario["id_concatenado"] . '">
       </td>
    </tr>';
            $correlativo++;
          }
        } else {
          echo "<td colspan='10' style='text-align:center;'>El contribuyente no tiene Predio(s)</td>";
        }
        $pdo = null;
        break;

        //contribuyente - agua - recaudacion
      case "pago_tributo":
        $query = "SELECT DISTINCT 
          c.Documento as dni,
          c.Nombre_Completo AS nombres,
          GROUP_CONCAT(CONCAT('<b>', cp.Documento, '</b> ', cp.Nombre_Completo) SEPARATOR ' ---- ') AS co_propietarios,
          COALESCE(CONCAT(c.Id_Contribuyente, '-', GROUP_CONCAT(cp.Id_Contribuyente SEPARATOR '-')), c.Id_Contribuyente) AS id_concatenado
      FROM contribuyente c 
      INNER JOIN (
          SELECT DISTINCT t.Id_Contribuyente, t.Id_Predio
          FROM propietario t
          INNER JOIN predio p ON t.Id_Predio = p.Id_Predio
          WHERE  t.Baja='1'  ORDER BY t.Id_Contribuyente
      ) AS temp ON c.Id_Contribuyente = temp.Id_Contribuyente 
      INNER JOIN predio p ON temp.Id_Predio = p.Id_Predio 
      INNER JOIN anio a ON a.Id_Anio = p.Id_Anio 
      LEFT JOIN (  
          SELECT DISTINCT t2.Id_Predio, t2.Id_Contribuyente
          FROM propietario t2
          WHERE  t2.Baja='1'  ORDER BY t2.Id_Contribuyente
      ) AS po2 ON temp.Id_Predio = po2.Id_Predio AND temp.Id_Contribuyente != po2.Id_Contribuyente 
      LEFT JOIN contribuyente cp ON po2.Id_Contribuyente = cp.Id_Contribuyente 
      WHERE c.Id_Contribuyente = :idContribuyente and a.NomAnio=$anio
      GROUP BY c.Id_Contribuyente, p.Id_Predio 
      ORDER BY co_propietarios;
      ";

        $segundaConsulta = $pdo->prepare($query);
        $segundaConsulta->bindParam(':idContribuyente', $idContribuyente, PDO::PARAM_INT);
        $segundaConsulta->execute();
        $coPropietarios = $segundaConsulta->fetchAll(PDO::FETCH_ASSOC);
        $correlativo = 1;
        if (count($coPropietarios) > 0) {

          
          foreach ($coPropietarios as $coPropietario) {

             /* carpeta*/
             $id_concatenado = $coPropietario["id_concatenado"];
             $array_ids = explode('-', $id_concatenado);
             sort($array_ids);
             $id_concatenado_ordenado = implode('-', $array_ids);
             $stmt = $pdo->prepare("SELECT Codigo_Carpeta FROM carpeta WHERE Concatenado_id=:concatenado_id");
             $stmt->bindParam(':concatenado_id', $id_concatenado_ordenado, PDO::PARAM_STR);
             $stmt->execute();
             if ($stmt->rowCount() > 0) {
               // Obtener el resultado como un array asociativo
               $result = $stmt->fetch(PDO::FETCH_ASSOC);
             $codigo_carpeta = $result['Codigo_Carpeta'];
             $carpeta=$codigo_carpeta;
             }
             else{
               $carpeta= '-';
             }
             //carpeta


            $nombres = htmlspecialchars($coPropietario['nombres'], ENT_QUOTES, 'UTF-8');
            $dni = htmlspecialchars($coPropietario['dni'], ENT_QUOTES, 'UTF-8');
            $coPropietariosList = $coPropietario['co_propietarios'] ? $coPropietario['co_propietarios'] : ''; // No escape here because it includes HTML
            $idConcatenado = htmlspecialchars($coPropietario['id_concatenado'], ENT_QUOTES, 'UTF-8');
            $coPropietariosText = $coPropietariosList ? '<b>' . $dni . '</b> ' .  $nombres . ' ---- ' . $coPropietariosList : $nombres;

            echo '<tr class="">
      <td class="text-center">' . $correlativo . '</td>
      <td>' . $coPropietariosText . '</td>
       <td class="text-center">' .$carpeta . '</td>
      <td class="text-center">
      <img src="./vistas/img/iconos/cuenta_o1.png" class="t-icon-tbl-p btnCaja" title="Estado Cuenta" idContribuyente_caja="' . $coPropietario["id_concatenado"] . '">
      </td>
      </tr>';
            $correlativo++;
          }
        } else {
          echo "<td colspan='10' style='text-align:center;'>El contribuyente no tiene Predio(s)</td>";
        }
        $pdo = null;
        break;


        //contribuyente - agua - recaudacion
      case "licencia_agua":
        $query = "SELECT DISTINCT 
              c.Documento as dni,
              c.Nombre_Completo AS nombres,
              GROUP_CONCAT(CONCAT('<b>', cp.Documento, '</b> ', cp.Nombre_Completo) SEPARATOR ' ---- ') AS co_propietarios,
              COALESCE(CONCAT(c.Id_Contribuyente, '-', GROUP_CONCAT(cp.Id_Contribuyente SEPARATOR '-')), c.Id_Contribuyente) AS id_concatenado
          FROM contribuyente c 
          INNER JOIN (
              SELECT DISTINCT t.Id_Contribuyente, t.Id_Predio
              FROM propietario t
              INNER JOIN predio p ON t.Id_Predio = p.Id_Predio
              WHERE  t.Baja='1'  ORDER BY t.Id_Contribuyente
          ) AS temp ON c.Id_Contribuyente = temp.Id_Contribuyente 
          INNER JOIN predio p ON temp.Id_Predio = p.Id_Predio 
          INNER JOIN anio a ON a.Id_Anio = p.Id_Anio 
          LEFT JOIN (
              SELECT DISTINCT t2.Id_Predio, t2.Id_Contribuyente
              FROM propietario t2
              WHERE  t2.Baja='1' ORDER BY t2.Id_Contribuyente
          ) AS po2 ON temp.Id_Predio = po2.Id_Predio AND temp.Id_Contribuyente != po2.Id_Contribuyente 
          LEFT JOIN contribuyente cp ON po2.Id_Contribuyente = cp.Id_Contribuyente 
          WHERE c.Id_Contribuyente = :idContribuyente and a.NomAnio=$anio
          GROUP BY c.Id_Contribuyente, p.Id_Predio 
          ORDER BY co_propietarios;
          ";

        $segundaConsulta = $pdo->prepare($query);
        $segundaConsulta->bindParam(':idContribuyente', $idContribuyente, PDO::PARAM_INT);
        $segundaConsulta->execute();
        $coPropietarios = $segundaConsulta->fetchAll(PDO::FETCH_ASSOC);
        $correlativo = 1;
        if (count($coPropietarios) > 0) {
          foreach ($coPropietarios as $coPropietario) {

             /* carpeta*/
             $id_concatenado = $coPropietario["id_concatenado"];
             $array_ids = explode('-', $id_concatenado);
             sort($array_ids);
             $id_concatenado_ordenado = implode('-', $array_ids);
             $stmt = $pdo->prepare("SELECT Codigo_Carpeta FROM carpeta WHERE Concatenado_id=:concatenado_id");
             $stmt->bindParam(':concatenado_id', $id_concatenado_ordenado, PDO::PARAM_STR);
             $stmt->execute();
             if ($stmt->rowCount() > 0) {
               // Obtener el resultado como un array asociativo
               $result = $stmt->fetch(PDO::FETCH_ASSOC);
             $codigo_carpeta = $result['Codigo_Carpeta'];
             $carpeta=$codigo_carpeta;
             }
             else{
               $carpeta= '-';
             }
             //carpeta


            $nombres = htmlspecialchars($coPropietario['nombres'], ENT_QUOTES, 'UTF-8');
            $dni = htmlspecialchars($coPropietario['dni'], ENT_QUOTES, 'UTF-8');
            $coPropietariosList = $coPropietario['co_propietarios'] ? $coPropietario['co_propietarios'] : ''; // No escape here because it includes HTML
            $idConcatenado = htmlspecialchars($coPropietario['id_concatenado'], ENT_QUOTES, 'UTF-8');
            $coPropietariosText = $coPropietariosList ? '<b>' . $dni . '</b> ' .  $nombres . ' ---- ' . $coPropietariosList : $nombres;

            echo '<tr class="">
          <td class="text-center">' . $correlativo . '</td>
          <td>' . $coPropietariosText . '</td>
           <td class="text-center">' .$carpeta . '</td>
          <td class="text-center">
          <img src="./vistas/img/iconos/cuenta_o1.png"  id="p_i" class="t-icon-tbl-p btnCuentaAgua" title="Licencia Agua" idContribuyente_agua="' . $coPropietario["id_concatenado"] . '">
        </td>
          </tr>';
            $correlativo++;
          }
        } else {
          echo "<td colspan='10' style='text-align:center;'>El contribuyente no tiene Predio(s)</td>";
        }
        $pdo = null;
        break;
        case "prescripcion":
          $query = "SELECT DISTINCT 
                c.Documento as dni,
                c.Nombre_Completo AS nombres,
                GROUP_CONCAT(CONCAT('<b>', cp.Documento, '</b> ', cp.Nombre_Completo) SEPARATOR ' ---- ') AS co_propietarios,
                COALESCE(CONCAT(c.Id_Contribuyente, '-', GROUP_CONCAT(cp.Id_Contribuyente SEPARATOR '-')), c.Id_Contribuyente) AS id_concatenado
            FROM contribuyente c 
            INNER JOIN (
                SELECT DISTINCT t.Id_Contribuyente, t.Id_Predio
                FROM propietario t
                INNER JOIN predio p ON t.Id_Predio = p.Id_Predio
                WHERE  t.Baja='1'  ORDER BY t.Id_Contribuyente
            ) AS temp ON c.Id_Contribuyente = temp.Id_Contribuyente 
            INNER JOIN predio p ON temp.Id_Predio = p.Id_Predio 
            INNER JOIN anio a ON a.Id_Anio = p.Id_Anio 
            LEFT JOIN (
                SELECT DISTINCT t2.Id_Predio, t2.Id_Contribuyente
                FROM propietario t2
                WHERE  t2.Baja='1' ORDER BY t2.Id_Contribuyente
            ) AS po2 ON temp.Id_Predio = po2.Id_Predio AND temp.Id_Contribuyente != po2.Id_Contribuyente 
            LEFT JOIN contribuyente cp ON po2.Id_Contribuyente = cp.Id_Contribuyente 
            WHERE c.Id_Contribuyente = :idContribuyente
            GROUP BY c.Id_Contribuyente, p.Id_Predio 
            ORDER BY co_propietarios;
            ";
  
          $segundaConsulta = $pdo->prepare($query);
          $segundaConsulta->bindParam(':idContribuyente', $idContribuyente, PDO::PARAM_INT);
          $segundaConsulta->execute();
          $coPropietarios = $segundaConsulta->fetchAll(PDO::FETCH_ASSOC);
          $correlativo = 1;
          if (count($coPropietarios) > 0) {
            foreach ($coPropietarios as $coPropietario) {
  
               /* carpeta*/
               $id_concatenado = $coPropietario["id_concatenado"];
               $array_ids = explode('-', $id_concatenado);
               sort($array_ids);
               $id_concatenado_ordenado = implode('-', $array_ids);
               $stmt = $pdo->prepare("SELECT Codigo_Carpeta FROM carpeta WHERE Concatenado_id=:concatenado_id");
               $stmt->bindParam(':concatenado_id', $id_concatenado_ordenado, PDO::PARAM_STR);
               $stmt->execute();
               if ($stmt->rowCount() > 0) {
                 // Obtener el resultado como un array asociativo
                 $result = $stmt->fetch(PDO::FETCH_ASSOC);
               $codigo_carpeta = $result['Codigo_Carpeta'];
               $carpeta=$codigo_carpeta;
               }
               else{
                 $carpeta= '-';
               }
               //carpeta
  
  
              $nombres = htmlspecialchars($coPropietario['nombres'], ENT_QUOTES, 'UTF-8');
              $dni = htmlspecialchars($coPropietario['dni'], ENT_QUOTES, 'UTF-8');
              $coPropietariosList = $coPropietario['co_propietarios'] ? $coPropietario['co_propietarios'] : ''; // No escape here because it includes HTML
              $idConcatenado = htmlspecialchars($coPropietario['id_concatenado'], ENT_QUOTES, 'UTF-8');
              $coPropietariosText = $coPropietariosList ? '<b>' . $dni . '</b> ' .  $nombres . ' ---- ' . $coPropietariosList : $nombres;
  
              echo '<tr class="">
                      <td class="text-center">' . $correlativo . '</td>
                      <td>' . $coPropietariosText . '</td>
                      <td class="text-center">' .$carpeta . '</td>
                      <td class="text-center">
                      <img src="./vistas/img/iconos/deuda.png"  id="btnPrescripcionDeuda" class="t-icon-tbl-p" title="Deuda del contribuyente" idContribuyente_prescripcion="' . $id_concatenado_ordenado . '">
                      </td>
                      <td class="text-center">
                      <img src="./vistas/img/iconos/pagos_.png"  id="btnPrescripcionReporte" class="t-icon-tbl-p" title="Prescripcion del contribuyente" idContribuyente_prescripcion="' . $id_concatenado_ordenado . '">
                      </td>
                    </tr>';
              $correlativo++;
            }
          } else {
            echo "<td colspan='10' style='text-align:center;'>El contribuyente no tiene Predio(s)</td>";
          }
          $pdo = null;
          break;
    }
  }




  public static function CntrVerificar_Parametro($valor)
  {
    
    $tabla = 'contribuyente';
    $respuesta = ModeloContribuyente::mdlMostrarValores_parametro_get($tabla, $valor);
  
    
    return $respuesta;
  }

   public static function CntrVerificar_Parametro_agua($valor)
  {
    
    $tabla = 'contribuyente';
    $respuesta = ModeloContribuyente::mdlMostrarValores_parametro_get_agua($tabla, $valor);
  
    
    return $respuesta;
  }


  //BARRA DE PROGRESO DE //CONTRIBUYENTES
  //   public static function CntrVerificar_Parametro_agua($valor)
  // {
    
  //   $respuesta = ModeloContribuyente::mdlMostrarValores_parametro_get_agua($valor);
   
  //   return $respuesta;

  // }


  
  // EDITAR USUARIOS|
  public static function ctrEditarContribuyente($tabla,$datos)
  {   
        $respuesta = ModeloContribuyente::mdlEditarContribuyente($tabla, $datos);
       
        if ($respuesta == "ok") {
          $respuesta = array(
             "tipo" => 'correcto',
             "mensaje" => '<div class="alert success">
             <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
             <span aria-hidden="true" class="letra">×</span>
             </button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">Se edito con exito al contribuyente</p></div>'
          );
       } else {
          $respuesta = array(
             "tipo" => 'error',
             "mensaje" => '<div class="alert error">
             <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
             <span aria-hidden="true" class="letra">×</span>
             </button><p class="inner"><strong class="letra">Error!</strong> <span class="letra">Ocurrio un error Comunicate con el Administrador</span></p></div>'
          );
       }
       return $respuesta;
    
  }

  public static function ctrEliminarContribuyente()
  {
    if (isset($_GET['idContribuyente'])) {
      $tabla = 'contribuyente';
      $datos = $_GET['idContribuyente'];
      $respuesta = ModeloContribuyente::mdlBorrarContribuyente($tabla, $datos);
      if ($respuesta == 'ok') {
        echo "<script>
                        Swal.fire({
                             position: 'top-end',
                        title: '¡El contribuyente ha sido eliminado!',
                        text: '...',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Cerrar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location = 'buscarcontribuyente';
                        }
                    })
                    </script>";
      }
    }
  }

  public static function ctrListarContribuyente_modal()
  {
    $respuesta = ModeloContribuyente::mdlListarContribuyente_modal();
    echo $respuesta;
  }
}
