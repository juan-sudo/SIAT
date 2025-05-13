<?php
require_once("../../vendor/autoload.php");
require_once('./TCPDFmain/pdf/tcpdf_include.php');
use Conect\Conexion;
use Controladores\ControladorPredio;
use Controladores\ControladorEstadoCuenta;
use Controladores\ControladorConfiguracion;
use Modelos\ModeloContribuyente;
use Modelos\ModeloEstadoCuenta;
use Modelos\ModeloImprimirFormato;
use Modelos\ModeloCaja;


class MYPDF extends TCPDF {

    //Page header
    // Page footer
    public function Footer() {
        $configuracion = ControladorConfiguracion::ctrConfiguracion();
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->SetX(-5); // Ajusta el valor para mover el número de página a la derecha
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C');
        // Para agregar contenido en el centro
        $this->SetX(10); // Ajusta el valor para centrar tu contenido en el medio de la página
        $this->Cell(0, 10,$configuracion['Nombre_Empresa'] , 0, 0, 'C');
    }
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->AddPage('P','A4');
// Establecer la información del PDF

$idlicencia=$_POST['idlicencia'];
$id_cuenta=$_POST['id_cuenta']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$estado_cuenta = ModeloEstadoCuenta::mdlEstadoCuenta_agua_pdf($idlicencia,$id_cuenta);

echo json_encode($estado_cuenta);
exit;
//$predio_licencia=ModeloEstadoCuenta::mdlPredio_Licencia($idlicencia);
$fila = ModeloEstadoCuenta::mdlPropietario_licencia_pdf($idlicencia);
$configuracion = ControladorConfiguracion::ctrConfiguracion();

// Inicio de la tabla HTML
$pdf->SetCreator($configuracion['Nombre_Empresa']);
$pdf->SetAuthor('GRUPO HANCCO');
$pdf->SetTitle('HR');

$fechaActual = date("Y-m-d");
$hora_actual = date("H:i:s");
$numeroPagina = $pdf->PageNo();
$pdf->SetFont('helvetica', '', 8);
$pdf->Image('logo.jpg', 10, 4, 30, 35, 'JPG', 'https://perudigitales.com/', '', true, 150, '', false, false, 0, false, false, false);
$html_head='<br><table align="center" >
                       <tr>
                       <th colspan="2" rowspan="5"></th>
                       <th colspan="4"><h4>'.$configuracion['Nombre_Empresa'].'</h4></th>
                       <th style=" border-left: 0.1px solid black; border-right: 0.1px solid black; border-top: 0.1px solid black;" colspan="3" rowspan="2"><H2>RUC:'.$configuracion['RUC_empresa'].'</H2></th>
                    </tr>
                    <tr>
                       <th colspan="4">'.$configuracion['Direccion'].'</th>
                    </tr>
                    <tr>
                    <th colspan="4">'.$configuracion['Telefono_uno'].'/'.$configuracion['Telefono_dos'].'</th>
                    <th colspan="3" rowspan="2" style="background-color: #a3e4d7; border-left: 0.1px solid black; border-right: 0.1px solid black;"><H3>BOLETA DE PAGO</H3></th>  
                    </tr>
                    <tr>
                    <th colspan="4">'.$configuracion['Correo'].'</th>
                    </tr>
                    <tr>
                    <th colspan="4">'.$configuracion['Pagina'].'</th>
                    <th colspan="3" rowspan="2" style=" border-left: 0.1px solid black; border-right: 0.1px solid black; border-bottom: 0.1px solid black;"><h3>N° - '.$configuracion['Numero_Recibo'].'</h3></th>    
                    </tr>
             </table>';
$pdf->writeHTML($html_head); 
$pdf->Ln(8);
$pdf->SetFont('helvetica', '', 7);
$pdf->SetX(13);
$html_propietario='<table align="center" style=" border-bottom: 0.1px solid black; border-left: 0.1px solid black;
                    border-right: 0.1px solid black; border-top: 0.1px solid black;" >
                     <tr style="background-color: #a3e4d7;">
                       <td width="40"><h4>Codigo</h4></td>
                       <td width="37"><h4>Dni</h4></td>
                       <td width="160"><h4>Titular de la Licencia</h4></td>
                       <td width="160"><h4>Licencia Agua del Predio</h4></td>
                       <td width="40"><h4>N° Licencia</h4></td>
                     </tr>';

$html_propietario .='<tr>';
$html_propietario .='<td width="40">'.$fila['id_contribuyente'].'</td>';
$html_propietario .='<th width="37">'.$fila['documento'].'</th>';
$html_propietario .='<th width="160">'.$fila['nombre'].' ' . $fila['a_paterno'] . ' ' . $fila['a_materno'] . '</th>';
$html_propietario .='<td  width="160">'. $fila['tipo_via'] . ' ' . $fila['nombre_calle'] . ' N° ' . $fila['numero_ubicacion'] . ' Mz. ' . $fila['n_manzana'] . ' Lote. ' . $fila['lote'] . ' Blo. ' . $fila['bloque'] . ' Nd ' . $fila['n_departamento'] . ' Luz ' . $fila['luz'] . ' C. ' . $fila['cuadra']  .' - ' . $fila['habilitacion'] . ' - ' . $fila['zona'].'</td>';

$html_propietario .='<td  width="40">'.$fila['numero_licencia'].'</td>';

$html_propietario .='</tr>';
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');

$conx=$pdf->GetX()+15;
$cony=$pdf->GetY();
// Establecer las coordenadas x, y manualmente para 'Nivel'
$x=$pdf->GetX()+159.5;
$y=$pdf->GetY()-15.5;
//$x = 11; // ajusta según tus necesidades
//$y = 135; // ajusta según tus necesidades
$pdf->SetXY($x, $y);
             $html_propietario='<table align="center" style=" border-bottom: 0.1px solid black; border-top: 0.1px solid black;border-left: 0.1px solid black;border-right: 0.1px solid black;" >
                     <tr>
                       <td width="35" align="right">Fecha:</td>
                       <td width="50" align="left">'.$fechaActual.'</td>
                     </tr>
                     <tr>
                       <td width="35" align="right">Hora:</td>
                       <td width="40" align="left">'.$hora_actual.'</td>
                     </tr>
                     <tr>
                       <td width="35" align="right">Moneda:</td>
                       <td width="40" align="left">Soles</td>
                     </tr>
                     <tr>
                       <td width="35" align="right">User:</td>
                       <td width="52" align="left">CAJA</td>
                     </tr>
                     </table>';
$pdf->writeHTML($html_propietario, true, false, false, false, '');

$pdf->SetY($cony+3);
$pdf->SetX(13);
$html_propietario='<table style="border-bottom: 0.1px solid black;border-top: 0.1px solid black;border-left: 0.1px solid black;border-right: 0.1px solid black; height:100px"align="center">';

  $html_propietario.='<tr><td width="529"> Pago de Servicio de Agua</td></tr>';
  $html_propietario.='<tr style="background-color: #a3e4d7;">
                       <td width="66" style="border-bottom: 0.1px solid black;border-top: 0.1px solid black"><h4>Cod</h4></td>
                       <td width="66" style="border-bottom: 0.1px solid black;border-top: 0.1px solid black"><h4>Tributo</h4></td>
                       <td width="66" style="border-bottom: 0.1px solid black;border-top: 0.1px solid black"><h4>Periodo</h4></td>
                       <td width="66" style="border-bottom: 0.1px solid black;border-top: 0.1px solid black"><h4>Importe</h4></td>
                       <td width="66" style="border-bottom: 0.1px solid black;border-top: 0.1px solid black"><h4>Gasto</h4></td>
                       <td width="66" style="border-bottom: 0.1px solid black;border-top: 0.1px solid black"><h4>Subtotal</h4></td>
                       <td width="66" style="border-bottom: 0.1px solid black;border-top: 0.1px solid black"><h4>Desc.</h4></td>
                       <td width="67" style="border-bottom: 0.1px solid black;border-top: 0.1px solid black"><h4>Total</h4></td>
                     </tr>';
                     $html_propietario.='<tr>
                       <td width="529"></td>
                     </tr>';
                     $total_ingresos=0;
                     $subtotal=0;
                     $descuento=0;
                     $total=0;
                     foreach ($estado_cuenta as $fila_p) { 
                      $total_ingresos +=1;
                      $subtotal+=$fila_p['Total'];
                      $descuento+=$fila_p['Descuento'];
                      $total+=$fila_p['Total_Pagar'];
                      $html_propietario .='<tr>';
                      $html_propietario .='<th width="66" >'. $fila_p['Tipo_Tributo'].'</th>';
                      $html_propietario .='<th width="66" >Agua</th>';   
                      $html_propietario .='<th width="66" >'. $fila_p['Anio'].'- '.$fila_p['Periodo'].'</th>';
                      $html_propietario .='<th width="66" >'. $fila_p['Importe'].'</th>';
                      $html_propietario .='<th width="66" >'. $fila_p['Gasto_Emision'].'</th>';
                      $html_propietario .='<th width="66" >'. $fila_p['Total'].'</th>';
                      $html_propietario .='<th width="66" >'. $fila_p['Descuento'].'</th>';
                      $html_propietario .='<th width="67" >'. $fila_p['Total_Pagar'].'</th>';
                      $html_propietario .='</tr>';                         
                                      }
                                      
                                      $hasta=60-$total_ingresos;
                                      for ($i = 1; $i <= $hasta; $i++) {
                                        $html_propietario .='<tr><th width="529"></th></tr>';
                                      } 
                       $html_propietario .='</table>';                  
$pdf->writeHTML($html_propietario, true, false, false, false, '');
$pdf->SetX(13);
$pdf->SetFont('helvetica', '', 7);
$html_propietario='<table style="border-bottom: 0.1px solid black;border-top: 0.1px solid black;border-left: 0.1px solid black;border-right: 0.1px solid black; height:100px"align="center">
                     <tr>
                       <td align="right" width="471"><b>Subtotal</b></td>
                       <td width="58">S/.'.number_format($subtotal,2).'</td>
                     </tr>
                     <tr>
                       <td align="right" width="471"><b>Descuento</b></td>
                       <td width="58">S/.'.number_format($descuento,2).'</td>
                     </tr>
                     <tr>
                       <td align="right" width="471"><b>Total</b></td>
                       <td width="58">S/.'.number_format($total,2).'</td>
                     </tr>';
                    
                       $html_propietario .='</table>';                  
$pdf->writeHTML($html_propietario, true, false, false, false, '');

function montoALetras($monto) {
  // Definir arrays para las unidades, decenas y centenas
  $unidades = array('', 'un', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve');
  $decenas = array('', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa');
  $centenas = array('', 'cien', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos');

  // Dividir el monto en partes enteras y decimales
  $partes = explode('.', number_format($monto, 2, '.', ''));

  // Obtener las partes enteras y decimales
  $entero = (int)$partes[0];
  $decimal = isset($partes[1]) ? (int)$partes[1] : 0;

  // Convertir la parte entera a letras
  $letras = '';

  // Procesar centenas
  if ($entero >= 100) {
      $letras .= $centenas[floor($entero / 100)];
      $entero %= 100;

      if ($entero > 0) {
          $letras .= 'to';
      }
  }

  // Procesar decenas
  if ($entero >= 10) {
      if ($entero == 10 || $entero == 20) {
          $letras .= $decenas[$entero / 10];
      } else {
          $letras .= $decenas[floor($entero / 10)];
          $entero %= 10;

          if ($entero > 0) {
              $letras .= 'y';
          }
      }
  }

  // Procesar unidades
  if ($entero > 0) {
      $letras .= $unidades[$entero];
  }

  // Convertir la parte decimal a letras
  $letras .= ' con ' . ($decimal > 0 ? montoALetras($decimal) : ' cero') . ' centavos';

  return $letras;
}

// Ejemplo de us
$letras = montoALetras($total);


$pdf->SetX(13);
$pdf->SetFont('helvetica', '', 7);
$html_propietario='<table style="border-bottom: 0.1px solid black;border-top: 0.1px solid black;border-left: 0.1px solid black;border-right: 0.1px solid black; height:100px"align="center">
                     <tr>
                       <td align="right" width="243.5"><b><br>Distrito de Puquio </b><br></td>
                       <td width="285.5" align="left"><b><br>Fecha:'.$fechaActual.' '.$hora_actual.'</b><br></td>
                     </tr>
                    ';
                       $html_propietario .='</table>';   
                       $pdf->writeHTML($html_propietario, true, false, false, false, ''); 
// Generar el PDF en memoria
$pdfData = $pdf->Output('', 'S'); // 'S' para obtener los datos en una variable
$rutaPDF = 'HR_pdf/Hr_'.uniqid().'.pdf';
// Guardar el PDF en la ruta especificada
file_put_contents($rutaPDF, $pdfData);
// Devolver la ruta del PDF guardado
echo $rutaPDF;