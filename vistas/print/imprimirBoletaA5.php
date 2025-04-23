<?php
//require_once("../../vendor/autoload.php");
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
    // Puedes personalizar el encabezado y pie de página aquí si lo necesitas.
}

// Crear una instancia de MYPDF con orientación vertical, unidades en mm y tamaño de página A4
$pdf = new MYPDF('P', 'mm', 'A5', true, 'UTF-8', false);
//$pdf->AddFont('CourierPrime-Regular', '', 'CourierPrime-Regular.php');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage('P', 'A5');
//$pdf->SetMargins(2,20, 20);

// Establecer la información del PDF
$tipo_tributo = $_POST['tipo_tributo'];
$propietario_convert = $_POST['propietarios'];
$propietario_convert_2 = explode('-', $propietario_convert);
$propietarios_ = implode(',', $propietario_convert_2);
$id_cuenta = $_POST['id_cuenta'];
$propietarios = ModeloEstadoCuenta::mdlPropietarios_pdf($propietarios_);
$configuracion = ControladorConfiguracion::ctrConfiguracion();
$cuenta = ModeloCaja::ctrCuenta_caja_pdf($id_cuenta);
$fechaActual = date("Y-m-d");
$horaActual = date('H:i:s');
// Establecer los márgenes
//$pdf->SetMargins(20, 20, 20);
//$pdf->SetX(6);
$pdf->Sety(0);
$pdf->Sety(0);
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetFont('helvetica', '', 9);

// Crear el contenido HTML
$html_head = '
<table align="">
    <tr>
        <th width="70%">'.$configuracion['Nombre_Empresa'].'</th>
        <th width="25%" style="border-left: 0.1px solid black; border-right: 0.1px solid black; border-top: 0.1px solid black;">RUC:'.$configuracion['RUC_empresa'].'
        </th>
    </tr>
    <tr>
        <th width="70%">'.$configuracion['Direccion'].'</th>
         <th style="border-bottom: 0.1px solid black; border-left: 0.1px solid black; border-right: 0.1px solid black; border-top: 0.1px solid black;"><b> N° - '.$configuracion['Numero_Recibo'].'</b>
        </th>
    </tr>
</table>';

$pdf->writeHTML($html_head);


$pdf->Ln(0);
$pdf->SetFont('helvetica', '', 9);

$html_propietario='<table  align="center" style=" border-bottom: 0.1px solid black; border-left: 0.1px solid black;
                    border-right: 0.1px solid black; border-top: 0.1px solid black;" >
                     <tr>
                       <td width="20%">Codigo</td>
                       <td width="20%">Dni</td>
                       <td width="55%">Propietario</td>
                     </tr>';
                     foreach ($propietarios as $valor => $filas) {
                        foreach ($filas as $fila) {
$html_propietario .='<tr>';
$html_propietario .='<td width="20%">'.$fila['id_contribuyente'].'</td>';
$html_propietario .='<th width="20%">'.$fila['documento'].'</th>';
$html_propietario .='<th width="55%">'.$fila['nombre_completo'].'</th>';
$html_propietario .='</tr>';
                    }
                }
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');

$conx=$pdf->GetX();
$cony=$pdf->GetY();


$pdf->SetXY($conx, $cony+1);
  if($tipo_tributo=='006'){
    $pdf->Cell(110, 0, 'PAGO DE IMPUESTO PREDIAL', 0, 1, 'C', 0, '', 8);
  }
  if($tipo_tributo=='742'){
    $pdf->Cell(110, 0, 'PAGO DE ARBITRIOS MUNICIPALES', 0, 1, 'C', 0, '', 8);
  }
  $pdf->Ln(0);

$html_propietario='<table align="center">';
$html_propietario.='<tr>
                       <td width="13%" style="border-bottom: 0.1px solid black;border-top: 0.1px solid black;">Periodo</td>
                       <td width="13%" style="border-bottom: 0.1px solid black;border-top: 0.1px solid black;" align="right">Importe</td>
                       <td width="13%" style="border-bottom: 0.1px solid black;border-top: 0.1px solid black;" align="right">Gastos</td>
                       <td width="13%" style="border-bottom: 0.1px solid black;border-top: 0.1px solid black;">TIM</td>
                       <td width="13%" style="border-bottom: 0.1px solid black;border-top: 0.1px solid black;" align="right">Subtotal</td>
                       <td width="13%" style="border-bottom: 0.1px solid black;border-top: 0.1px solid black;" align="right">Desc.</td>
                       <td width="14%" style="border-bottom: 0.1px solid black;border-top: 0.1px solid black;" align="right">Total</td>
                     </tr>';
                     $total_ingresos=0;
                     $subtotal=0;
                     $descuento=0;
                     $total=0;
                     foreach ($cuenta as $fila_p) { 
                      $total_ingresos +=1;
                      $subtotal+=$fila_p['Total'];
                      $descuento+=$fila_p['Descuento'];
                      $total+=$fila_p['Total_Pagar'];
                      $html_propietario .='<tr>';  
                      $html_propietario .='<th width="13%">'. $fila_p['Anio'].'- '.$fila_p['Periodo'].'</th>';
                      $html_propietario .='<th width="13%" align="right">'. $fila_p['Importe'].'</th>';
                      $html_propietario .='<th width="13%" align="right">'. $fila_p['Gasto_Emision'].'</th>';
                      $html_propietario .='<th width="13%">'. $fila_p['TIM'].'</th>';
                      $html_propietario .='<th width="13%" align="right">'. $fila_p['Total'].'</th>';
                      $html_propietario .='<th width="13%" align="right">'. $fila_p['Descuento'].'</th>';
                      $html_propietario .='<th width="14%" align="right">'. $fila_p['Total_Pagar'].'</th>';
                      $html_propietario .='</tr>';                         
                                      }
                                      $hasta=17-$total_ingresos;
                                      for ($i = 1; $i <= $hasta; $i++) {
                                        $html_propietario .='<tr><th width="90%"></th></tr>';
                                      } 
                       $html_propietario .='</table>';                  
$pdf->writeHTML($html_propietario, true, false, false, false, '');
$pdf->SetX(12);
$pdf->SetFont('Courier', '', 9);
$pdf->Line(0, $pdf->getY(),120, $pdf->getY()); 
$pdf->Ln(0);
$html_propietario='<table align="center">';
$html_propietario.='<tr>
                       <td align="right" width="60%">TOTAL CANCELADO S/.</td>
                       <td width="30%" align="right">'.number_format($total,2).'</td>
                     </tr></table>';
                     $pdf->writeHTML($html_propietario, true, false, false, false, '');
                     $pdf->Ln(5);
                     $pdf->SetFont('Courier', '', 7);
  $html_propietario='<table><tr>
                       <td align="right" width="30%">CAJA-MPLP</td>
                       <td align="right" width="30%">'.$fechaActual.'</td>
                       <td align="right" width="30%">'.$horaActual.'</td>
                     </tr></table>';
                    
$pdf->writeHTML($html_propietario, true, false, false, false, '');
// Guardar el archivo PDF temporalmente
$temp_file = tempnam(sys_get_temp_dir(), 'print') . '.pdf';
$pdf->Output($temp_file, 'F');
// Nombre del ejecutable de SumatraPDF (SumatraPDF.exe)
$sumatra_pdf_path = '"C:\\Users\\GRUPO HANCCO\\AppData\\Local\\SumatraPDF\\SumatraPDF.exe"'; // Ruta donde está instalado SumatraPDF

// Nombre de la impresora (verifica el nombre exacto en tu sistema)
$printer_name = "EPSON L5590 Series"; // Reemplaza con el nombre de tu impresora

// Comando para imprimir el PDF usando SumatraPDF.exe
$command = "$sumatra_pdf_path -print-to \"$printer_name\" " . escapeshellarg($temp_file);

// Ejecutar el comando
$output = shell_exec($command);

// Eliminar el archivo temporal
unlink($temp_file);

// Mostrar resultado
echo "Impresión enviada. Resultado del comando: $output";
?>
