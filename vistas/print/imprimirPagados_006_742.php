<?php
require_once("../../vendor/autoload.php");
require_once('./TCPDFmain/pdf/tcpdf_include.php');
use Conect\Conexion;
use Controladores\ControladorPredio;
use Controladores\ControladorEstadoCuenta;
use Controladores\ControladorConfiguracion;
use Modelos\ModeloContribuyente;
use Modelos\ModeloEstadoCuenta;

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

// Establecer la información del PDF
$pdf->SetCreator('TuNombre');
$pdf->SetAuthor('TuNombre');
$pdf->SetTitle('Mi PDF');
// Agregar una página
$pdf->AddPage();

$carpeta=$_POST['carpeta'];
$id_usuario=$_POST['id_usuario'];
$id_area=$_POST['id_area']; 
$id_cuenta=$_POST['id_cuenta']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$propietarios=$_POST['propietarios']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$estado_cuenta = ModeloEstadoCuenta::mdlEstadoCuenta_pagados_pdf($propietarios,$id_cuenta);
$propietarios = ModeloEstadoCuenta::mdlPropietarios_pdf($propietarios);
$configuracion = ControladorConfiguracion::ctrConfiguracion();
// Inicio de la tabla HTML
$html="<style>
th {
    font-size: 9px;
    font-family: Arial, sans-serif;
    font-weight: bold;
}
.totales{
    font-family: Arial, sans-serif;
    font-weight: bold;
    font-size: 9px;
}


td {
    font-size: 8px;
}
.mi-tabla thead {
    border-bottom: 3px solid black; /* Agrega una línea sólida debajo de la fila thead */
}
.espacio{
    margin-top:-10px;
    margin-bottom: 50px;
}
div{
    justify-content: center; /* Centra horizontalmente */
        align-items: center;
}


</style>";
$fechaActual = date('d/m/Y');
$numeroPagina = $pdf->PageNo();
$pdf->SetFont('helvetica', '', 7);
$html_head ='<table><tr>
                       <th colspan="4">'.$configuracion['Nombre_Sistema'].'</th>
                       <th colspan="4">Versión '.$configuracion['Version'].'</th>
                        <th colspan="2">pagina: '.$numeroPagina.'</th>
                    </tr>
                    <tr>
                       <th colspan="8">'.$configuracion['Nombre_Empresa'].'</th>
                        <th colspan="2">Fecha: '.$fechaActual.'</th>
                    </tr>
                    <tr>
                       <th colspan="8"><h5>'.$id_area.'</h5></th>
                       <th colspan="2">Usuario:'.$id_usuario.'</th>
                    </tr>

                    <tr>
                      <th colspan="4"></th>
                       <th colspan="4"></th>
                        <th width="70" border="1" style="font-size: 8px;background-color: #ffd439;">&nbsp;Carpeta:'.$carpeta.'</th>
                    </tr>
                    
             </table>';
$pdf->writeHTML($html_head);
$pdf->MultiCell(0, 5, '', 0, 'L');
$pdf->SetX(45); 
$pdf->SetFont('helvetica', '', 9);  // Establecer el tamaño de letra a 8
$pdf->Cell(120, 0, 'CONSULTA DE PAGOS DE IMPUESTO Y ARBITRIOS AL '.$fechaActual, 0, 1, 'C', 0, '', 8);
$pdf->Ln(3);
$pdf->SetFont('helvetica', '', 8);
$html_propietario='<br>';

$width = $pdf->getPageWidth();
$tableWidth = 410; // Ancho de la tabla
$x = ($width - $tableWidth) / 2;
$pdf->setX($x);
$pdf->SetFont('helvetica', '', 7); 
$html_propietario .='<table align="center" >
                     <tr>
                       
                       <td border="0.1" width="40">Codigo</td>
                       <td border="0.1" width="50">Dni</td>
                       <td border="0.1" width="150">Propietario(s)</td>
                       <td border="0.1" width="300">Direccion Fiscal</td>
                     </tr>';
                     foreach ($propietarios as $valor => $filas) {
                        foreach ($filas as $fila) {
$html_propietario .='<tr>';
$html_propietario .='<td border="0.1" width="40">'.$fila['id_contribuyente'].'</td>';
$html_propietario .='<td border="0.1" width="50">'.$fila['documento'].'</td>';
$html_propietario .='<td border="0.1" width="150">'.$fila['nombre_completo'].'</td>';
$html_propietario .='<td border="0.1" width="300">'. $fila['direccion_completo'] . '</td>';
$html_propietario .='</tr>';
                    }
                }
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');
             $pdf->Line(10, $pdf->getY(),200, $pdf->getY());
             $pdf->SetFont('helvetica', '', 7.5);  
             $pdf->setX(6);
$html_estado= '<table align="center">
            <thead>
            <tr>
                <th><b>Cod.</b></th>
                <th width="50"><b>Tributo</b></th>
                <th><b>Año</b></th>
                <th><b>Periodo</b></th>
                <th><b>Fecha</b></th>
                <th><b>Hora</b></th>
                <th><b>Estado</b></th>
                <th><b>Importe</b></th>
                <th><b>Gasto</b></th>
                <th><b>Subtotal</b></th>
                <th><b>T.I.M</b></th>
                <th><b>Total</b></th>
            </tr>
            </thead></table>';
            $pdf->writeHTML($html_estado, true, false, false, false, '');
            $pdf->Line(10, $pdf->getY()-3,200, $pdf->getY()-3);
            $pdf->setX(6);
            $html= '<table align="center">';            
            foreach ($estado_cuenta as $row) {
                list($date, $time) = explode(' ', $row['fecha_pago']);
                $html .= "<tr>";
                $html .= "<th>" .  $row['tributo'] . "</th>";
                if($row['tributo']=='006' ){
                $html .= '<th width="50">Imp. Predial</th>';
                }
                else{
                $html .= '<th width="50">Arb. Municipal</th>';    
                }  
                $html .= "<th>".$row['anio']."</th>";
                $html .= "<th>".$row['periodo']."</th>";
                $html .= "<th>".$date."</th>";
                $html .= "<th>".$time."</th>";
                if($row['estado']=='P' ){
                    $html .= "<th>Pagado</th>";
                    }
                    else{
                        $html .= "<th>Prescrito</th>";  
                    }  
                $html .= "<th>".$row['importe']."</th>";
                $html .= "<th>".$row['gasto']."</th>";
                $html .= "<th>".$row['subtotal']."</th>";
                $html .= "<th>".$row['tim']."</th>";
                $html .= "<th>".$row['total']."</th>";
                $html .= "</tr>";
            }
            $html .= "<tr><td><hr></td><td><hr></td><td><hr></td><td><hr></td><td><hr></td><td><hr></td><td><hr></td><td><hr></td><td><hr></td><td><hr></td><td><hr></td><td><hr></td></tr>";                    
            $html .= "<tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th>";
            $html .= "<th><b>".$_POST['totalImporte']."</b></th>";
            $html .= "<th><b>".$_POST['totalGasto']."</b></th>";
            $html .= "<th><b>".$_POST['totalSubtotal']."</b></th>";
            $html .= "<th><b>".$_POST['totalTIM']."</b></th>";
            $pdf->writeHTML($html, true, false, false, false, '');
            $pdf->Line(185, $pdf->getY(),120, $pdf->getY());
          
            $pdf->SetFont('helvetica', 'B', 8);  // Establecer el tamaño de letra a 8
            $pdf->MultiCell(0, 1, '', 0, 'L');
            $pdf->Cell(310, 0, 'T O T A L   P A G A D O      S/.   =               '.$_POST['totalTotal'], 0, 1, 'C', 0, '', 0);
           // $pdf->MultiCell(0, 0, '', 0, 'L');
            $pdf->Line(10, $pdf->getY(),200, $pdf->getY());
            $pdf->MultiCell(0, 10, '', 0, 'L');
          
$pdf->SetX(45); 
$pdf->SetFont('helvetica', '', 8);  // Establecer el tamaño de letra a 8
$pdf->Cell(120, 0, 'INFORMACION VALIDA SOLO COMO CONSULTA', 0, 1, 'C', 0, '', 8);
// Generar el PDF en memoria
$pdfData = $pdf->Output('', 'S'); // 'S' para obtener los datos en una variable
//$ids = implode("-", $_POST['propietarios']);//CONVIERTE EN UN STRING
//$a=$propietarios;
// Ruta donde guardar el PDF (ajusta la ruta según tu proyecto)
$rutaPDF = 'pdfs/mi'.uniqid().'.pdf';

// Guardar el PDF en la ruta especificada
file_put_contents($rutaPDF, $pdfData);

// Devolver la ruta del PDF guardado
echo $rutaPDF;
