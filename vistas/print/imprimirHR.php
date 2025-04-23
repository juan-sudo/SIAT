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
use Modelos\ModeloCalcular;

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

$carpeta=$_POST['carpeta'];
$propietarios_=$_POST['propietarios']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$anio=$_POST['anio'];
$predio_select="si";
$propietarios = ModeloEstadoCuenta::mdlPropietarios_pdf($propietarios_);
$configuracion = ControladorConfiguracion::ctrConfiguracion();
$predio =ModeloImprimirFormato::mdlListarPredio_HR($propietarios_,$anio);
$determinacion =ModeloCalcular::mdlMostrar_calculo_impuesto($propietarios_,"condicion",$anio,$predio_select);
$estado_cuenta =ModeloEstadoCuenta::mdlEstadoCuenta_pdf($propietarios_,'null',"pdf",$anio,'006');
$estado__cuenta_total =ModeloEstadoCuenta::mdlEstadoCuenta_Total($propietarios_,$anio,'006');
// Inicio de la tabla HTML
$pdf->SetCreator($configuracion['Nombre_Empresa']);
$pdf->SetAuthor('GRUPO HANCCO');
$pdf->SetTitle('HR');

$fechaActual = date('d/m/Y');
$numeroPagina = $pdf->PageNo();
$pdf->SetFont('helvetica', '', 8);
$pdf->Image('logo.jpg', 15, 6, 32, 40, 'JPG', 'https://perudigitales.com/', '', true, 150, '', false, false, 0, false, false, false);
$html_head='<table align="center"><tr>
                       <th colspan="2" rowspan="4"></th>
                       <th colspan="6"><h2>'.$configuracion['Nombre_Empresa'].'</h2></th>
                       <th colspan="2" style="font-size: 40px;background-color: #ffffee;" rowspan="3" border="0.1;" >HR</th>
                    </tr>
                    <tr>
                       <th colspan="6"><H2>IMPUESTO PREDIAL</H2></th>
                    </tr>
                    <tr>
                    <th colspan="6">T.U.O LEY DE TRIBUTACION MUNICIPAL</th>
                    </tr>
                    <tr>
                    <th colspan="6">D.S 158-2004-EF</th>
                    <th colspan="2">HOJA DE RESUMEN</th>  
                    </tr>
                    <tr>
                    <th colspan="2"></th>
                    <th colspan="6"><h2>AÑO '.$anio.'</h2></th>
                    <th colspan="2" style="font-size:7px;">FECHA DE EMISION</th>  
                    </tr>
                    <tr>
                    <th colspan="8"></th>
                    <th colspan="2" border="0.1">'.$fechaActual.'</th>  
                    </tr>
                     <tr>
                    <th colspan="8"></th>
                    <th style="background-color: #ffd439; " colspan="2" border="0.1">&nbsp;Carpeta : '.$carpeta.'</th>  
                    </tr>
             </table>';
$pdf->writeHTML($html_head);

$pdf->SetX(5); 
$pdf->SetFont('helvetica', '', 6.5);  // Establecer el tamaño de letra a 8
$pdf->Cell(0, 2, 'I. PROPIETARIO(S)', 0, 1, 'L');
$pdf->Ln(0);
$pdf->SetFont('helvetica', '', 6.5);
$html_propietario='<table align="center" >
                     <tr style="background-color: #ffffee;">
                       <td border="0.1" width="40"><h4>Codigo</h4></td>
                       <td border="0.1" width="50"><h4>Dni</h4></td>
                       <td border="0.1" width="150"><h4>Propietario(s)</h4></td>
                       <td border="0.1" width="300"><h4>Direccion Fiscal</h4></td>
                     </tr>';
                     foreach ($propietarios as $valor => $filas) {
                        foreach ($filas as $fila) {
$html_propietario .='<tr>';
$html_propietario .='<td style=" border-left: 0.1px solid black; border-bottom: 0.1px solid black;" width="40">'.$fila['id_contribuyente'].'</td>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" width="50">'.$fila['documento'].'</th>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" width="150">'.$fila['nombre_completo'].'</th>';
$html_propietario .='<th style=" border-right: 0.1px solid black; border-bottom: 0.1px solid black;" width="300">'. $fila['direccion_completo'] . '</th>';
$html_propietario .='</tr>';
                    }
                }
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');


//=========SECTOR DE LISTADO DE PREDIOS=========  
$pdf->SetFont('helvetica', '', 6.5); 
$pdf->Ln(1);
$pdf->SetX(5);          
$pdf->Cell(0, 2, 'II. RELACION DE PREDIO(S)', 0, 1, 'L');
$pdf->Ln(1);

$html_propietario='<table style="border-bottom: 1px solid black; height:100px"align="center">
                     <tr style="background-color: #ffffee;">
                       <td border="0.1" width="24"><h4>Tipo</h4></td>
                       <td border="0.1" width="70"><h4>Catastro</h4></td>
                       <td border="0.1" width="252"><h4>Ubicación</h4></td>
                       <td border="0.1" width="45"><h4>Valor Predio</h4></td>
                       <td border="0.1" width="55"><h4>% Condominio</h4></td>
                       <td border="0.1" width="45"><h4>Inaf. o Exo.</h4></td>
                       <td border="0.1" width="50"><h4>Valor Afecto</h4></td>
                     </tr>';
                        foreach ($predio as $fila_p) {
$html_propietario .='<tr valign="center" height="120">';
$html_propietario .='<td style=" border-left: 0.1px solid black; vertical-align: middle;" width="24" height="14">'.$fila_p['tipo_ru'].'</td>';
$html_propietario .='<th  width="70">'.$fila_p['catastro'].'</th>';
$html_propietario .='<th  width="252" align="left">' . $fila_p['direccion_completo'] . '</th>';
$html_propietario .='<th  width="45">'.number_format($fila_p['v_predio'],2).'</th>';
$html_propietario .='<th  width="55">100</th>';
$html_propietario .='<th  width="45">'.number_format($fila_p['inafecto'],2).'</th>';
$html_propietario .='<th style=" border-right: 0.1px solid black;" width="50" >'. number_format($fila_p['v_predio_aplicar'],2).'</th>';
$html_propietario .='</tr>'; 
                          
                    
                }
                $total=$determinacion['total_predio'];
                $hasta=25-$total;
                for ($i = 1; $i <= $hasta; $i++) {
                  $html_propietario .='<tr><th  style="  border-left: 0.1px solid black; border-right: 0.1px solid black;" width="541"></th></tr>';
                }
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');

//========FIN DEL SECTOR DE PREDIO ============

//=========SECTOR DETERMINACION DE IMPUESTO=========  
$pdf->SetFont('helvetica', '', 6.5); 
$pdf->Ln(1);
$pdf->SetX(5);          
$pdf->Cell(0, 2, 'III. DETERMINACION DEL IMPUESTO', 0, 1, 'L');
$pdf->Ln(1);
$html_propietario='
                     <table style="border-bottom: 1px solid black;" align="center">
                     <tr style="background-color: #ffffee;">
                       <td border="0.1" width="70"><h4>Total Predios</h4></td>
                       <td border="0.1" width="70"><h4>Predios Afectos</h4></td>
                       <td border="0.1" width="70"><h4>Total Valor Afectos</h4></td>
                       <td border="0.1" width="70"><h4>Impuesto Anual</h4></td>
                       <td border="0.1" width="70"><h4>Cuota Trimestral</h4></td>
                     </tr>';
                       
$html_propietario .='<tr valign="center">';
$html_propietario .='<td style=" border-left: 0.1px solid black; vertical-align: middle;" width="70" height="10">'.$determinacion['total_predio'].'</td>';
$html_propietario .='<th  width="70">'.$determinacion['total_predio_afecto'].'</th>';
$html_propietario .='<th  width="70">'.$determinacion['base_imponible'].'</th>';
$html_propietario .='<th  width="70">'.$determinacion['impuesto_anual'].'</th>';
$html_propietario .='<th  style=" border-right: 0.1px solid black;" width="70">'.$determinacion['impuesto_trimestral'].'</th>';
$html_propietario .='</tr>';
                    
                
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');

//========FIN DE DETERMINACION DE IMPUESTO ============

//=========SECTOR MONTOS A PAGAR FRACIONADO=========  
$pdf->SetFont('helvetica', '', 6.5); 
$pdf->Ln(1);
$pdf->SetX(5);          
$pdf->Cell(0, 2, 'IV. MONTOS A PAGAR FRACCIONADO', 0, 1, 'L');
$pdf->Ln(1);
$html_propietario='
                     <table style="border-bottom: 1px solid black;" align="center">
                     <tr style="background-color: #ffffee;">
                       <td border="0.1" width="85"><h4>Cuotas</h4></td>
                       <td border="0.1" width="85"><h4>Monto Absoluto</h4></td>
                       <td border="0.1" width="85"><h4>Derecho de Emision</h4></td>
                       <td border="0.1" width="85"><h4>Reajuste</h4></td>
                       <td border="0.1" width="90"><h4>Total a Pagar</h4></td>
                       <td border="0.1" width="110"><h4>Vencimiento</h4></td>
                     </tr>';
                     foreach ($estado_cuenta as $fila_e) {
                      $fecha_vencimiento=$fila_e['Fecha_Vence'];
$html_propietario .='<tr valign="center">';
$html_propietario .='<td style=" border-left: 0.1px solid black; vertical-align: middle;" width="85" height="10">'.$fila_e['Periodo'].'</td>';
$html_propietario .='<th  width="85">'.$fila_e['Importe'].'</th>';
$html_propietario .='<th  width="85">'.$fila_e['Gasto_Emision'].'</th>';
$html_propietario .='<th  width="85">0</th>';
$html_propietario .='<th  width="90">'.$fila_e['Total'].'</th>';
$html_propietario .='<th  style=" border-right: 0.1px solid black;" width="110">'.$fila_e['Fecha_Vence'].'</th>';
$html_propietario .='</tr>';
                     }                
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');

//========FIN DE MONTOS A PAGAR FRACIONADO ============

//=========SECTOR A PAGAR AL CONTADO=========  
$pdf->SetFont('helvetica', '', 6.5); 
$pdf->Ln(1);
$pdf->SetX(5);          
$pdf->Cell(0, 2, 'V. MONTO A PAGAR AL CONTADO', 0, 1, 'L');
$pdf->Ln(1);
$html_propietario='
                     <table style="border-bottom: 1px solid black;" align="center">
                     <tr style="background-color: #ffffee;">
                       <td border="0.1" width="85"><h4>Cuotas</h4></td>
                       <td border="0.1" width="85"><h4>Monto Absoluto</h4></td>
                       <td border="0.1" width="85"><h4>Derecho de Emision</h4></td>
                       <td border="0.1" width="85"><h4>Reajuste</h4></td>
                       <td border="0.1" width="90"><h4>Total a Pagar</h4></td>
                       <td border="0.1" width="110"><h4>Vencimiento</h4></td>
                     </tr>';
                     foreach ($estado__cuenta_total as $fila_t) {
$html_propietario .='<tr valign="center">';
$html_propietario .='<td style=" border-left: 0.1px solid black; vertical-align: middle;" width="85" height="10">4</td>';
$html_propietario .='<th  width="85">'.$fila_t['importe'].'</th>';
$html_propietario .='<th  width="85">'.$fila_t['gasto_emision'].'</th>';
$html_propietario .='<th  width="85">0</th>';
$html_propietario .='<th  width="90">'.$fila_t['saldo'].'</th>';
$html_propietario .='<th  style=" border-right: 0.1px solid black;" width="110">'.$fecha_vencimiento.'</th>';
$html_propietario .='</tr>';
                     }                
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');
//========FIN DE MONTO A PAGAR AL CONTADO ============

//=========SECTOR FIRMA=========  
$pdf->SetFont('helvetica', '', 6.5); 
$pdf->Ln(1);
$pdf->SetX(5);          
$pdf->Cell(0, 2, '', 0, 1, 'L');
$pdf->Ln(1);
$html_firma='<table align="center"><tr>
                       <th  colspan="4">BASE IMPONIBLE:(Art.11° D.S N° 156-2004-EF)<br><br>
                       La base imponible para la determinacion del impuesto predial, esta constituido por el valor total de los predios del contribuyente ubicados en cada jurisdiccion</th>
                       <th border="0.1" colspan="4"><br>DECLARO QUE LOS DATOS CONSIGNADOS EN LA PRESENTE DECLARACION SON VERDADERO<br><br><br><br><br>
                       ....................................................................................<br>
                       Firma del Contribuyente o Representante Legal<br>
                       N° Dni:<br><br>
                       Fecha:'.$fechaActual.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Distrito:'.$configuracion['Lugar'].'</th>
                    </tr>
             </table>';
$pdf->writeHTML($html_firma, true, false, false, false, '');
//========FIN DEL SECTOR FIRMA ============

// Generar el PDF en memoria
$pdfData = $pdf->Output('', 'S'); // 'S' para obtener los datos en una variable
// Ruta donde guardar el PDF (ajusta la ruta según tu proyecto)
$rutaPDF = 'HR_pdf/Hr_'.uniqid().'.pdf';
// Guardar el PDF en la ruta especificada
file_put_contents($rutaPDF, $pdfData);
// Devolver la ruta del PDF guardado
echo $rutaPDF;