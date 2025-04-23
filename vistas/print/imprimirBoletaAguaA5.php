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
        // Set fontA
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->SetX(-5); // Ajusta el valor para mover el número de página a la derecha
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C');
        // Para agregar contenido en el centro
        $this->SetX(10); // Ajusta el valor para centrar tu contenido en el medio de la página
        $this->Cell(0, 10,$configuracion['Nombre_Empresa'] , 0, 0, 'C');
    }
}
$anchoCm = 14;
$altoCm = 14;

// Convertir centímetros a puntos (1 cm = 28.35 puntos)
$anchoPuntos = $anchoCm * 28.35;
$altoPuntos = $altoCm * 28.35;

// Crear una instancia de TCPDF
$pdf = new TCPDF('P', 'mm', [$anchoPuntos, $altoPuntos], true, 'UTF-8', false);

// Agregar contenido al PDF
$pdf->AddPage();
// Establecer la información del PDF
$pdf->SetX(12);
$idlicencia=$_POST['idlicencia'];
$id_cuenta=$_POST['id_cuenta']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$estado_cuenta = ModeloEstadoCuenta::mdlEstadoCuenta_agua_pdf($idlicencia,$id_cuenta);
//$predio_licencia=ModeloEstadoCuenta::mdlPredio_Licencia($idlicencia);
$fila = ModeloEstadoCuenta::mdlPropietario_licencia_pdf($idlicencia);
$configuracion = ControladorConfiguracion::ctrConfiguracion();
// Inicio de la tabla HTML
$pdf->SetCreator($configuracion['Nombre_Empresa']);
$pdf->SetAuthor('GRUPO HANCCO');
$pdf->SetTitle('HR');

$fechaActual = date("Y-m-d H:i:s");
$numeroPagina = $pdf->PageNo();
$pdf->SetFont('helvetica', '', 13);
//$pdf->Image('logo.jpg', 10, 4, 30, 35, 'JPG', 'https://perudigitales.com/', '', true, 150, '', false, false, 0, false, false, false);
$html_head='<br><table align="center">
                       <tr>
                       <th colspan="4" width="450"><h2>'.$configuracion['Nombre_Empresa'].'</h2></th>
                       <th width="166" style=" border-left: 0.1px solid black; border-right: 0.1px solid black; border-top: 0.1px solid black;" colspan="3" rowspan="2"><H2>RUC:'.$configuracion['RUC_empresa'].'</H2></th>
                    </tr>
                    <tr>
                       <th width="450" colspan="4">'.$configuracion['Direccion'].'</th>
                      
                    </tr>
                    <tr>
                    <th width="450" colspan="4">'.$configuracion['Telefono_uno'].'/'.$configuracion['Telefono_dos'].'</th>
                    <th width="166" colspan="3" rowspan="2" style="background-color: #a3e4d7; border-left: 0.1px solid black; border-right: 0.1px solid black;"><H3>BOLETA DE PAGO</H3></th>  
                    </tr>
                    <tr>
                    <th width="450" colspan="4">'.$configuracion['Correo'].'</th>
                    s
                    </tr>
                    <tr>
                    <th width="450" colspan="4">'.$configuracion['Pagina'].'</th>
                    <th width="166" colspan="3" rowspan="2" style=" border-left: 0.1px solid black; border-right: 0.1px solid black; border-bottom: 0.1px solid black;"><h2>N° - '.$configuracion['Numero_Recibo'].'</h2></th>    
                    </tr>
             </table>';
$pdf->writeHTML($html_head); 
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 14);
$pdf->SetX(12);
$html_propietario='<table align="center" style=" border-bottom: 0.1px solid black; border-left: 0.1px solid black;
                    border-right: 0.1px solid black; border-top: 0.1px solid black;" >
                     <tr style="background-color: #a3e4d7;">
                       <td width="55"><h4>Codigo</h4></td>
                       <td width="68"><h4>Dni</h4></td>
                       <td width="230"><h4>Titular Licencia</h4></td>
                     </tr>';
                   
$html_propietario .='<tr>';
$html_propietario .='<td width="55">'.$fila['id_contribuyente'].'</td>';
$html_propietario .='<th width="68">'.$fila['documento'].'</th>';
$html_propietario .='<th width="230">'.$fila['nombre'].' ' . $fila['a_paterno'] . ' ' . $fila['a_materno'] . '</th>';
$html_propietario .='</tr>';
                    
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');

$conx=$pdf->GetX()+2;
$cony=$pdf->GetY();
// Establecer las coordenadas x, y manualmente para 'Nivel'
$x=$pdf->GetX()+129;
$y=$pdf->GetY()-25;
//$x = 11; // ajusta según tus necesidades
//$y = 135; // ajusta según tus necesidades
$pdf->SetXY($x, $y);
             $html_propietario='<table align="center" style=" border-bottom: 0.1px solid black; border-top: 0.1px solid black;border-left: 0.1px solid black;border-right: 0.1px solid black;" >
                     <tr>
                       <td width="110" align="right">Fecha Emisión:</td>
                       <td width="140" align="left">'.$fechaActual.'</td>
                     </tr>
                     <tr>
                       <td width="110" align="right">Concepto:</td>
                       <td width="140" align="left">AGUA</td>
                     </tr>
                     <tr>
                       <td width="110" align="right">Usuario:</td>
                       <td width="140" align="left">CAJA-MPLP</td>
                     </tr>
                     </table>';
$pdf->writeHTML($html_propietario, true, false, false, false, '');

$pdf->SetXY($conx, $cony+1);
$html_propietario='<table style="border-bottom: 0.1px solid black;border-top: 0.1px solid black;border-left: 0.1px solid black;border-right: 0.1px solid black; height:100px"align="center">';
$html_propietario.='<tr><td width="608">'.'<width="160">'. $fila['tipo_via'] . ' ' . $fila['nombre_calle'] . ' N° ' . $fila['numero_ubicacion'] . ' Mz. ' . $fila['n_manzana'] . ' Lote. ' . $fila['lote'] . ' Blo. ' . $fila['bloque'] . ' Nd ' . $fila['n_departamento'] . ' Luz ' . $fila['luz'] . ' C. ' . $fila['cuadra']  .' - ' . $fila['habilitacion'] . ' - ' . $fila['zona'].'</td></tr>';
  
$html_propietario.='<tr style="background-color: #a3e4d7;">
                       <td width="88" style="border-bottom: 0.1px solid black;"><h4>Periodo</h4></td>
                       <td width="86" style="border-bottom: 0.1px solid black;"><h4>Tributo</h4></td>
                       <td width="86" style="border-bottom: 0.1px solid black;"><h4>Importe</h4></td>
                       <td width="86" style="border-bottom: 0.1px solid black;"><h4>Gastos</h4></td>
                       <td width="86" style="border-bottom: 0.1px solid black;"><h4>Subtotal</h4></td>
                       <td width="86" style="border-bottom: 0.1px solid black;"><h4>Descuento</h4></td>
                       <td width="90" style="border-bottom: 0.1px solid black;"><h4>Total</h4></td>
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
                      $html_propietario .='<th width="88" >'. $fila_p['Anio'].'- '.$fila_p['Periodo'].'</th>';
                      $html_propietario .='<th width="86" >Agua</th>';
                      $html_propietario .='<th width="86" >'. $fila_p['Importe'].'</th>';
                      $html_propietario .='<th width="86" >'. $fila_p['Gasto_Emision'].'</th>';
                      $html_propietario .='<th width="86" >'. $fila_p['Total'].'</th>';
                      $html_propietario .='<th width="86" >'. $fila_p['Descuento'].'</th>';
                      $html_propietario .='<th width="90" >'. $fila_p['Total_Pagar'].'</th>';
                      $html_propietario .='</tr>';                         
                                      }
                                      
                                      $hasta=25-$total_ingresos;
                                      for ($i = 1; $i <= $hasta; $i++) {
                                        $html_propietario .='<tr><th width="458"></th></tr>';
                                      } 
                       $html_propietario .='</table>';                  
$pdf->writeHTML($html_propietario, true, false, false, false, '');
$pdf->SetX(12);
$pdf->SetFont('helvetica', '', 14);
$html_propietario='<table style="border-bottom: 0.1px solid black;border-top: 0.1px solid black;border-left: 0.1px solid black;border-right: 0.1px solid black; height:100px"align="center">
                     <tr>
                       <td align="right" width="550"><b>Subtotal</b></td>
                       <td width="58">S/.'.number_format($subtotal,2).'</td>
                     </tr>
                     <tr>
                       <td align="right" width="550"><b>Descuento</b></td>
                       <td width="58">S/.'.number_format($descuento,2).'</td>
                     </tr>
                     <tr>
                       <td align="right" width="550"><b>Total</b></td>
                       <td width="58">S/.'.number_format($total,2).'</td>
                     </tr>';
                    
                       $html_propietario .='</table>';                  
$pdf->writeHTML($html_propietario, true, false, false, false, '');

// Generar el PDF en memoria
$pdfData = $pdf->Output('', 'S'); // 'S' para obtener los datos en una variable
$rutaPDF = 'HR_pdf/Hr_'.uniqid().'.pdf';
// Guardar el PDF en la ruta especificada
file_put_contents($rutaPDF, $pdfData);
// Devolver la ruta del PDF guardado
echo $rutaPDF;