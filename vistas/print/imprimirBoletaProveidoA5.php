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

   
}


// Crear una instancia de TCPDF
$pdf = new MYPDF('P', 'mm', 'A5', true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage('P', 'A5');
$pdf->SetMargins(2,20, 20);
$id_proveido=$_POST['id_proveido'];
$configuracion = ControladorConfiguracion::ctrConfiguracion();
$proveido = ModeloCaja::ctrProveido_caja_pdf($id_proveido);
$fechaActual = date("Y-m-d");
$horaActual = date('H:i:s');
// Establecer los márgenes
//$pdf->SetMargins(20, 20, 20);
//$pdf->SetX(6);
$pdf->Sety(10);
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetFont('Courier', '', 9);

// Crear el contenido HTML
$html_head = '
<table>
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
$pdf->Ln(1);
$pdf->SetFont('Courier', '', 9);
$pdf->SetX(10);
$html_propietario='<table align="center" style=" border-bottom: 0.1px solid black; border-left: 0.1px solid black;border-right: 0.1px solid black; border-top: 0.1px solid black;" >
                    <tr>
                      <td width="20%"><h4>Dni</h4></td>
                      <td width="75%"><h4>Solicitante</h4></td>
                    </tr>';
$html_propietario .='<tr>';
$html_propietario .='<th width="20%">'.$proveido['dni'].'</th>';
$html_propietario .='<th width="75%">'.$proveido['nombres'].'</th>';
$html_propietario .='</tr>';
                    
                
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');

$pdf->SetFont('Courier', '', 9);
$pdf->Cell(130, 0, 'PAGO DE PROVEIDO-'.$proveido['nombre_area'], 0, 'C', 0, '', 8);
$pdf->Ln(1);
//tabla del proveido
$pdf->SetFont('Courier', '', 8);
$html_propietario='<table>
                     <tr>
                      <td align="center" style="border-bottom: 0.1px solid black; border-top: 0.1px solid black;" width="49%">Concepto</td>
                      <td align="center" style="border-bottom: 0.1px solid black; border-top: 0.1px solid black;" width="20%">Obs.</td>
                      <td align="center" style="border-bottom: 0.1px solid black; border-top: 0.1px solid black;" width="10%">P.Unit</td>
                      <td align="center" style="border-bottom: 0.1px solid black; border-top: 0.1px solid black;" width="5%">Cant</td>
                      <td align="center" style="border-bottom: 0.1px solid black; border-top: 0.1px solid black;" width="12%">Total</td>
                      </tr>
                     <tr>
        
                     <td style="border-right: 0.1px solid black; border-left: 0.1px solid black;" width="49%">'.$proveido['nombre_especie'].'</td>
                     <td style="border-right: 0.1px solid black;" width="20%">'.$proveido['observaciones'].'</td>
                     <td style="border-right: 0.1px solid black;" align="center" width="10%">'.$proveido['monto'].'</td>
                     <td style="border-right: 0.1px solid black;" align="center" width="5%">'.$proveido['cantidad'].'</td>
                     <td style="border-right: 0.1px solid black;" align="center" width="12%">'.$proveido['valor_total'].'</td>
                     </tr>
                     </table>
                     ';
                     
             $pdf->writeHTML($html_propietario, true, false, false, false, '');

             $pdf->Ln(15);
             $pdf->SetFont('Courier', '', 10);
 $html_propietario='<table><tr>
                     <td width="80%" align="right" style="border-bottom: 0.1px solid black;">TOTAL CANCELADO S/.</td>
                     <td align="center" width="20%" style="border-bottom: 0.1px solid black;">'.number_format($proveido['valor_total'],2).'</td>
                     </tr></table>';            
             $pdf->Ln(5);
             $pdf->writeHTML($html_propietario, true, false, false, false, '');

             $pdf->SetFont('Courier', '', 7);
$html_propietario='<table><tr>
               <td align="right" width="30%">CAJA-MPLP</td>
               <td align="right" width="30%">'.$fechaActual.'</td>
               <td align="right" width="30%">'.$horaActual.'</td>
             </tr></table>';
            
                            
$pdf->writeHTML($html_propietario, true, false, false, false, '');

// Generar el PDF en memoria
$pdfData = $pdf->Output('', 'S'); // 'S' para obtener los datos en una variable
$rutaPDF = 'HR_pdf/Hr_'.uniqid().'.pdf';
// Guardar el PDF en la ruta especificada
file_put_contents($rutaPDF, $pdfData);
// Devolver la ruta del PDF guardado
echo $rutaPDF;
// <td width="100" align="left">'.$id_proveido.'</td>