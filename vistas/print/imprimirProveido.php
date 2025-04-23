<?php
require_once("../../vendor/autoload.php");
require_once('./TCPDFmain/pdf/tcpdf_include.php');
use Controladores\ControladorConfiguracion;
use Modelos\ModeloProveido;

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
       //primera hoja 
       $this->SetY(135);
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

$numero_proveido=$_POST['numero_proveido_pdf'];
$area=$_POST['area'];
$anioActual = date("Y");
$proveido=ModeloProveido::mdlMostrar_Proveido($numero_proveido,$area);
$configuracion = ControladorConfiguracion::ctrConfiguracion();
// Inicio de la tabla HTML
$pdf->SetCreator($configuracion['Nombre_Empresa']);
$pdf->SetAuthor('GRUPO HANCCO');
$pdf->SetTitle('HR');

$fechaActual = date("Y-m-d H:i:s");
$numeroPagina = $pdf->PageNo();
$pdf->SetFont('helvetica', '', 8);
$pdf->Image('logo.jpg', 10, 4, 25, 30, 'JPG', 'https://perudigitales.com/', '', true, 150, '', false, false, 0, false, false, false);
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
                    <th colspan="3" rowspan="2" style="background-color: #D0E1F9; border-left: 0.1px solid black; border-right: 0.1px solid black;"><H3>PROVEÍDO</H3></th>  
                    </tr>
                    <tr>
                    <th colspan="4">'.$configuracion['Correo'].'</th>
                    
                    </tr>
                    <tr>
                    <th colspan="4">'.$configuracion['Pagina'].'</th>
                    <th colspan="3" rowspan="2" style=" border-left: 0.1px solid black; border-right: 0.1px solid black; border-bottom: 0.1px solid black;"><h3>N° '.$numero_proveido.'-'.$anioActual.'-'.$configuracion['Iniciales'].'-'.$proveido[0]['nombre_iniciales'].'</h3></th>    
                    </tr>
             </table>';
$pdf->writeHTML($html_head); 
$pdf->Ln(3);
$pdf->SetFont('helvetica', '', 6.5);
$pdf->SetX(10);
//informacion del proveido
$html_propietario='<table align="left">
                     <tr>
                     <td width="540">MEDIANTE EL PRESENTE, SIRVASE SEÑOR CAJERO A EFECTUAR EL COBRO RESPECTIVO AL SEÑOR: <b style="color:blue;">'.$proveido[0]['nombres'].'</b></td>
                     </tr>
                     <tr>
                     <td width="540">DE CONFORMIDAD AL TEXTO ÚNICO DE PROCEDIMIENTOS ADMINISTRATIVOS (TUPA) DE LA MUNICIPALIDAD Y CON 
                      LO PREVISTO POR LA LEY N° 27444 DEL PROCEDIMIENTO ADMINISTRATIVO GENERAL Y SU MODIFICATORIA D.LEG.1029.</td>
                     </tr>';
                     
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');
$pdf->SetX(9);
//tabla del proveido
$html_propietario='<table style="border-right: 0.1px solid black; border-top: 0.1px solid black;" >
                  
                     <tr style="background-color: #D0E1F9  ;">
                       <td align="center" style=" border-bottom: 0.1px solid black;font-size: 7px;border-left: 0.1px solid black;" width="90">Área</td>
                       <td align="center" style=" border-bottom: 0.1px solid black;font-size: 7px;" width="195">Especie Valorada</td>
                       <td align="center" style=" border-bottom: 0.1px solid black;font-size: 7px;" width="140">Observaciones</td>
                       <td align="center" style=" border-bottom: 0.1px solid black;font-size: 7px;" width="40">Costo Unit.</td>
                       <td align="center" style=" border-bottom: 0.1px solid black;font-size: 7px;" width="35">Cantidad</td>
                       <td align="center" style=" border-bottom: 0.1px solid black;font-size: 7px;" width="40">Valor Total</td>
                     </tr>';
                     $pdf->SetFont('helvetica', '', 6);
                     $valor_total=0;
                     foreach ($proveido as $row) {
                      $valor_total+=$row['valor_total'];
                      $html_propietario .= '<tr>
                          <td width="90" style="border-left: 0.1px solid black;"><br>'.$row['nombre_area'].'<br></td>
                          <td width="195" style="border-left: 0.1px solid black;">'.$row['nombre_especie'].'</td>
                          <td width="140" style="border-left: 0.1px solid black;">'.$row['observaciones'].'</td>
                          <td align="center" width="40" style="border-left: 0.1px solid black;">'.number_format($row['monto'],2).'</td>
                          <td align="center" width="35" style="border-left: 0.1px solid black;">'.$row['cantidad'].'</td>
                          <td align="center" width="40" style="border-left: 0.1px solid black;">'.$row['valor_total'].'</td>
                          </tr>';
                  }
                  $html_propietario .='<tr><td align="right" style=" border-top: 0.1px solid black;font-size: 7px;" width="500">Total S/</td>
                                       <td align="center" style="border-left: 0.1px solid black;border-top: 0.1px solid black; border-bottom: 0.1px solid black;font-size: 7px;" width="40">'.number_format($valor_total,2).'</td></tr>';
                  $html_propietario .= '</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');
//fin de la tabla tabla del proveido
function traducirMes($nombreMesIngles) {
  $meses = [
      'January' => 'enero',
      'February' => 'febrero',
      'March' => 'marzo',
      'April' => 'abril',
      'May' => 'mayo',
      'June' => 'junio',
      'July' => 'julio',
      'August' => 'agosto',
      'September' => 'septiembre',
      'October' => 'octubre',
      'November' => 'noviembre',
      'December' => 'diciembre',
  ];

  return $meses[$nombreMesIngles] ?? $nombreMesIngles;
}

// Establecer el idioma local en inglés
setlocale(LC_TIME, 'en_US.utf8');
// Capturar la fecha actual
$fechaActual = new DateTime();
// Obtener el nombre del mes en inglés
$nombreMesIngles = strftime('%B', $fechaActual->getTimestamp());
// Traducir el nombre del mes al español
$nombreMesEspanol = traducirMes($nombreMesIngles);
// Formatear la fecha con el nombre del mes en español
$fechaActual_formato = strftime('%d de ') . $nombreMesEspanol . strftime(' del %Y', $fechaActual->getTimestamp());
$pdf->SetFont('helvetica', '', 6.5);
$html_propietario='<table align="right">
                    <tr><td style="" width="540"></td>'.$configuracion['Lugar'].','.$fechaActual_formato.'</tr>';
$html_propietario .='</table>';
$pdf->writeHTML($html_propietario, true, false, false, false, '');
//========FIN DE DETERMINACION DE IMPUESTO ============
$pageWidth = $pdf->getPageWidth();
$pageHeight = $pdf->getPageHeight();
$middleY = $pageHeight / 2;
$pdf->SetLineWidth(0.1); 
$pdf->Line(0, $middleY, $pageWidth - 0, $middleY);

//segunda mitad de la hoja
$pdf->Image('logo.jpg', 10, 154, 25, 30, 'JPG', 'https://perudigitales.com/', '', true, 150, '', false, false, 0, false, false, false);
$pdf->SetY($middleY+10);
$pdf->SetFont('helvetica', '', 8);

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
                    <th colspan="3" rowspan="2" style="background-color: #D0E1F9; border-left: 0.1px solid black; border-right: 0.1px solid black;"><H3>PROVEÍDO</H3></th>  
                    </tr>
                    <tr>
                    <th colspan="4">'.$configuracion['Correo'].'</th>
                    
                    </tr>
                    <tr>
                    <th colspan="4">'.$configuracion['Pagina'].'</th>
                    <th colspan="3" rowspan="2" style=" border-left: 0.1px solid black; border-right: 0.1px solid black; border-bottom: 0.1px solid black;"><h3>N° '.$numero_proveido.'-'.$anioActual.'-'.$configuracion['Iniciales'].'-'.$proveido[0]['nombre_iniciales'].'</h3></th>    
                    </tr>
             </table>';
$pdf->writeHTML($html_head); 
$pdf->Ln(3);
$pdf->SetFont('helvetica', '', 6.5);
$pdf->SetX(10);
//informacion del proveido
$html_propietario='<table align="left">
                    <tr>
                     <td width="540">MEDIANTE EL PRESENTE, SIRVASE SEÑOR CAJERO A EFECTUAR EL COBRO RESPECTIVO AL SEÑOR: <b style="color:blue;">'.$proveido[0]['nombres'].'</b></td>
                     </tr>
                     <tr>
                     <td width="540">DE CONFORMIDAD AL TEXTO ÚNICO DE PROCEDIMIENTOS ADMINISTRATIVOS (TUPA) DE LA MUNICIPALIDAD Y CON 
                      LO PREVISTO POR LA LEY N° 27444 DEL PROCEDIMIENTO ADMINISTRATIVO GENERAL Y SU MODIFICATORIA D.LEG.1029.</td>
                     </tr>';
                     
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');
$pdf->SetX(9);
//tabla del proveido
$html_propietario='<table style="border-right: 0.1px solid black; border-top: 0.1px solid black;" >
                  
                     <tr style="background-color: #D0E1F9  ;">
                       <td align="center" style=" border-bottom: 0.1px solid black; font-size: 7px; border-left: 0.1px solid black;" width="40">Area<br></td>
                       <td align="center" style=" border-bottom: 0.1px solid black;font-size: 7px;" width="90">Área</td>
                       <td align="center" style=" border-bottom: 0.1px solid black;font-size: 7px;" width="175">Especie Valorada</td>
                       <td align="center" style=" border-bottom: 0.1px solid black;font-size: 7px;" width="120">Observaciones</td>
                       <td align="center" style=" border-bottom: 0.1px solid black;font-size: 7px;" width="40">Costo Unit.</td>
                       <td align="center" style=" border-bottom: 0.1px solid black;font-size: 7px;" width="35">Cantidad</td>
                       <td align="center" style=" border-bottom: 0.1px solid black;font-size: 7px;" width="40">Valor Total</td>
                     </tr>';
                     $pdf->SetFont('helvetica', '', 6);
                     $valor_total=0;
                     foreach ($proveido as $row) {
                      $valor_total+=$row['valor_total'];
                      $html_propietario .= '<tr>
                          <td width="90" style="border-left: 0.1px solid black;"><br>'.$row['nombre_area'].'<br></td>
                          <td width="195" style="border-left: 0.1px solid black;">'.$row['nombre_especie'].'</td>
                          <td width="140" style="border-left: 0.1px solid black;">'.$row['observaciones'].'</td>
                          <td align="center" width="40" style="border-left: 0.1px solid black;">'.number_format($row['monto'],2).'</td>
                          <td align="center" width="35" style="border-left: 0.1px solid black;">'.$row['cantidad'].'</td>
                          <td align="center" width="40" style="border-left: 0.1px solid black;">'.$row['valor_total'].'</td>
                          </tr>';
                  }
                  $html_propietario .='<tr><td align="right" style=" border-top: 0.1px solid black;font-size: 7px;" width="500">Total S/</td>
                                       <td align="center" style="border-left: 0.1px solid black;border-top: 0.1px solid black; border-bottom: 0.1px solid black;font-size: 7px;" width="40">'.number_format($valor_total,2).'</td></tr>';
                  $html_propietario .= '</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');
$pdf->SetX(10);
            
$pdf->SetFont('helvetica', '', 6.5);
             $html_propietario='<table align="right">
             <tr><td style="" width="540"></td>'.$configuracion['Lugar'].','.$fechaActual_formato.'</tr>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');
// Generar el PDF en memoria
$pdfData = $pdf->Output('', 'S'); // 'S' para obtener los datos en una variable
// Ruta donde guardar el PDF (ajusta la ruta según tu proyecto)
$rutaPDF = 'HR_pdf/Hr_'.uniqid().'.pdf';
// Guardar el PDF en la ruta especificada
file_put_contents($rutaPDF, $pdfData);
// Devolver la ruta del PDF guardado
echo $rutaPDF;