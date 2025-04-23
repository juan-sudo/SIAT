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


$propietarios_=$_POST['propietarios']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$anio=$_POST['anio'];
$tipo_tributo=$_POST['tipo_tributo'];

$numero_orden=$_POST['numero_orden_seleccionado'];

$datosH = array(
  'id_propietarios' => $propietarios_,
  'numero_orden' => $numero_orden,
);


$datos = array(
   'id_propietarios' => $propietarios_,
   'anio' => $anio,
   'tipo_tributo' => $tipo_tributo
);

$propietarios = ModeloEstadoCuenta::mdlPropietarios_pdf($propietarios_);
$configuracion = ControladorConfiguracion::ctrConfiguracion();
//$resultado =ModeloEstadoCuenta::mdlEstadoCuenta_Orden_pdf($datos);

$resultadoOrden =ModeloEstadoCuenta::mdlEstadoCuenta_Orden_pdf_historial($datosH);

// Depurar con var_dump para ver los datos completos

// echo '<pre>';
// var_dump($resultadoOrden);
// echo '</pre>';


$estado_cuenta = $resultadoOrden['campos'];

// Acceder al nuevo número de orden
$nuevo_orden = $numero_orden;

//$estado__cuenta_total =ModeloEstadoCuenta::mdlEstadoCuenta_Total($propietarios_,$anio,'006');
// Inicio de la tabla HTML
$pdf->SetCreator($configuracion['Nombre_Empresa']);
$pdf->SetAuthor('GRUPO HANCCO');
$pdf->SetTitle('HR');

$fechaActual = date('d/m/Y');
$anio_impresion = date('Y');
$numeroPagina = $pdf->PageNo();
$pdf->SetFont('helvetica', '', 8);
$pdf->SetX(40); 
$pdf->Image('logo.jpg', 15, 6, 22, 28, 'JPG', 'https://perudigitales.com/', '', true, 150, '', false, false, 0, false, false, false);
$html_head='<table align="left" >
                    <tr >
                       <th width="430"><h3>'.$configuracion['Nombre_Empresa'].'</h3></th>
                    </tr>
                    <tr>
                       <th width="380"><H4>GERENCIA DE ADMINISTRACION TRIBUTARIA</H4></th>
                       <th style="font-size:7px;">FECHA DE EMISION</th> 
                    </tr>

                    <tr>
                    <th width="380">SISTEMA DE RECAUDACIÓN MUNICIPAL</th>
                     <th  align="center" border="0.1">'.substr($resultadoOrden['campos'][0]['Fecha_Registro'], 0, 10).'</th> 
                    </tr>
                   
                    
                    
             </table>';
$pdf->writeHTML($html_head);


$pdf->Ln(1);
$html_head='<table align="center" >
                    <tr>
                    <th width="560"><h2>ORDEN DE PAGO N° '.$nuevo_orden.'-'.$anio_impresion.' GAT - MPLP</h2></th>';
              
               
  $html_head.='</tr> </table>';
$pdf->writeHTML($html_head);

$pdf->SetX(8); 
$pdf->SetFont('helvetica', '', 6.5);  // Establecer el tamaño de letra a 8
$pdf->Cell(10, 2, '1. IDENTIFICACION DE DEUDOR TRIBUTARIO ', 0, 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 6.5);
$pdf->SetX(10); 
$html_propietario='<table align="center">
                     <tr style="background-color:#e3eff3;">
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

$pdf->SetFont('helvetica', '', 8);
$sector_1='<table align="left"><tr>
                       <th>Se requiere la concelacion de la deuda tributaria contenido en presente documento, en el plazo de 3 diaas habiles contados 
                       a partir del dia siguiente de su notificacion, bajo apercibimiento de iniciar el PROCEDIMIENTO DE EJECUCION COACTIVA.
                       </th> 
                    </tr><BR>
                    <tr>
                       <th>La presente se emite los tributos y periodos que se indican, cuyo monto se al calculado al '.$fechaActual.'. 
                       </th>
                    </tr><br>
                    <tr>
                       <th><b>Motivo Determinante: Se ha verificado la existencia de una deuda tributaria no cancelada dentro de los plazoz de ley</b>. 
                       </th>
                    </tr>
                    <tr>
                       <th><b>2. DETALLE DEUDA TRIBUTARIA:</b> TRAMOS DEL AUTOVALUO (TASA) hasta 15 UIT 0.2% - Mas de 60 UIT 0.6% - Mas de 60 UIT 1.0%. 
                       </th>
                    </tr>
             </table>';
$pdf->writeHTML($sector_1, true, false, false, false, '');

//IMPRIMIR ESTADO DE CUENTA 
$html_estado= '<table align="center">
            <thead>
            <tr>
                <th><b>Tributos</b></th>
                <th><b>Año</b></th>
                <th><b>Base Imponible</b></th>
                <th><b>Importe</b></th>
                <th><b>Gastos</b></th>
                <th><b>Monto Insoluto</b></th>
                <th><b>T.I.M</b></th>
                <th><b>TOTAL</b></th>
            </tr>
            </thead></table>';
            $pdf->writeHTML($html_estado, true, false, false, false, '');
            $pdf->Line(15, $pdf->getY()-3,200, $pdf->getY()-3);
            $html= '<table align="center">';            
            foreach ($estado_cuenta as $row) {
               
                $html .= "<tr>";
                if($row['Tipo_Tributo']=='006' ){
                $html .= "<th>Imp. Predial</th>";
                }
                else{
                $html .= "<th>Arb. Municipal</th>";    
                }  

                $html .= "<th>".$row['Anio']."</th>";
                $html .= "<th>".$row['Base_Imponible']."</th>";
                $html .= "<th>".$row['Importe']."</th>";
                $html .= "<th>".$row['Gastos']."</th>";
                $html .= "<th>".$row['Subtotal']."</th>";
                $html .= "<th>".$row['TIM']."</th>";
                $html .= "<th>".$row['Total']."</th>";
                $html .= "</tr>";
            }
            $html .= "<tr><td><hr></td><td><hr></td><td><hr></td><td><hr></td><td><hr></td><td><hr></td><td><hr></td><td><hr></td><td><hr></td></tr>";                    
            $html .= "<tr><th></th><th></th><th></th>";
            $html .= "<th><b>". $resultadoOrden['suma_importe'] ."</b></th>";
            $html .= "<th><b>".$resultadoOrden['suma_gastos']."</b></th>";
            $html .= "<th><b>".$resultadoOrden['suma_subtotal']."</b></th>";
            $html .= "<th><b>".$resultadoOrden['suma_tim'] ."</b></th>";
   
            $pdf->writeHTML($html, true, false, false, false, '');
            $pdf->Line(180, $pdf->getY(),80, $pdf->getY());
          
            $pdf->SetFont('helvetica', 'B', 9);  // Establecer el tamaño de letra a 8
            $pdf->MultiCell(0, 1, '', 0, 'L');
            $pdf->Cell(297, 0, 'T O T A L   D E U D A      S/.   =               '.$resultadoOrden['suma_total'], 0, 1, 'C', 0, '', 0);
           // $pdf->MultiCell(0, 0, '', 0, 'L');
            $pdf->Line(10, $pdf->getY(),200, $pdf->getY());
            $pdf->MultiCell(0, 10, '', 0, 'L');

            $pdf->SetFont('helvetica', '', 8);

$pdf->SetX(8); 
$pdf->SetY(185); 
$sector_2='<table align="left">
                     <tr>
                       <th colspan="2"><b>3. BASE LEGAL:</b>
                       </th> 
                     </tr>
                     <tr>
                       <th align="left">&nbsp;&nbsp;-Art. 70 de la ley órganica de la Municipalidad N° 27972<br>
                           -Art. 8° al 20° Ley de Tribatación Municipal. N° 776 <br>
                           -Art. 78° inc. 1 D.S. 133-2013-EF TUO del Código Tributario
                       </th> 
                       <th align="left">&nbsp;&nbsp;-TUO de la Ley 26979 de Procedimiento de Ejecución Coactiva<br>
                           -Plazo para presentar recursos de reclamación: 03 días hábiles <br>
                           (desde el día siguiente de notificación la presente)
                       </th>
                     </tr>
                   
             </table>';
$pdf->writeHTML($sector_2, true, false, false, false, '');

$sector_2='<table align="left">
                     <tr>
                       <th colspan="2" align="center"><b>CONSTANCIA DE NOTIFICACIÓN</b></th> 
                     </tr>
                     <tr>
                       <th width="100" align="left">Fecha de Recepción</th> 
                       <th width="440">: Puquio,....de..................................................del '.$anio_impresion.'</th> 
                     </tr> <br>
                     <tr>
                       <th width="100"  align="left">Domicilio</th>
                       <th>: ................................................................................................................................................  </th>
                     </tr><br>
                     <tr>
                       <th width="100"  align="left">Apellidos y Nombres</th>
                       <th>: ................................................................................................................................................  </th>
                     </tr><br>
                      <tr>
                       <th width="100"  align="left">Parentesco</th>
                       <th>: .................................................................................................. DNI:...................................... </th>
                     </tr><br>
                      <tr>
                       <th width="100"  align="left">Firma de Recepción</th>
                       <th>: ................................................................................................................................................  </th>
                     </tr><br>
                      <tr>
                       <th width="100"  align="left">Notificado Por</th>
                       <th>: .................................................................................................. DNI:.....................................  </th>
                     </tr><br>
                      <tr>
                       <th width="100"  align="left">Firma Notificador</th>
                       <th>: ................................................................................................................................................  </th>
                     </tr><br>
                      <tr>
                       <th width="100"  align="left">Referencia</th>
                       <th>: ................................................................................................................................................  </th>
                     </tr><br>
                     <tr>
                       <th width="100"  align="left">N° de suministro de Luz</th>
                       <th>: ................................................................................................................................................  </th>
                     </tr><br>
                      <tr>
                       <th width="100"  align="left">Correo Electronico</th>
                       <th>: .................................................................................................. Celular:.................................  </th>
                     </tr>
             </table>';
$pdf->writeHTML($sector_2, true, false, false, false, '');

//Generar el PDF en memoria
$pdfData = $pdf->Output('', 'S'); // 'S' para obtener los datos en una variable
//Ruta donde guardar el PDF (ajusta la ruta según tu proyecto)
$rutaPDF = 'HR_pdf/Hr_'.uniqid().'.pdf';
//Guardar el PDF en la ruta especificada
file_put_contents($rutaPDF, $pdfData);
//Devolver la ruta del PDF guardado
echo $rutaPDF;