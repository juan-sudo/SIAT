<?php
require_once("../../vendor/autoload.php");
require_once('./TCPDFmain/pdf/tcpdf_include.php');
use Conect\Conexion;

use Controladores\ControladorConfiguracion;
use Modelos\ModeloReporte;


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

$fecha=$_POST['fecha'];
$total=$_POST['total'];
$id_usuario=$_POST['id_usuario'];
$id_area=$_POST['id_area'];
$registros = ModeloReporte::mdlMostrar_Ingreso_Diarios($fecha);
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
             </table>';
$pdf->writeHTML($html_head);
$pdf->MultiCell(0, 5, '', 0, 'L');

$pdf->SetFont('helvetica', '', 9);  // Establecer el tamaño de letra a 8
$pageWidth = $pdf->GetPageWidth();
$cellWidth = 150;
$cellWidthSmall = 60;

// Calcular la posición x para centrar el texto
$xPos = ($pageWidth - $cellWidth) / 2;
$xPosSmall = ($pageWidth - $cellWidthSmall) / 2;
$pdf->SetX($xPos);
$pdf->Cell($cellWidth, 0, 'REPORTE CONSOLIDADO INGRESOS CAJA POR CLASIFICADOR SIAF-FUENTE ', 0, 1, 'C', 0, '', 8);
$pdf->SetX($xPosSmall);
$pdf->Cell($cellWidthSmall, 0, 'DESDE  '.$fecha.' HASTA ' .$fecha, 0, 1, 'C', 0, '', 8);
$pdf->Ln(6);
$pdf->SetFont('helvetica', '', 8);
$pdf->SetX(15);
$html_estado= '<table>
           
            <tr>
                <th style="border-top:0.1px solid black;border-bottom: 0.1px solid black" align="center" width="100"><b>Presupuesto</b></th>
                <th style="border-top:0.1px solid black;border-bottom: 0.1px solid black" align="center" width="200"><b>Clasificador de Ingreso - SIAF</b></th>
                <th style="border-top:0.1px solid black;border-bottom: 0.1px solid black" align="center" width="100"><b>Subtotal</b></th>
                <th style="border-top:0.1px solid black;border-bottom: 0.1px solid black" align="center" width="100"><b>F.Financiamiento</b></th>
            </tr>
            </table>';
            $pdf->writeHTML($html_estado, true, false, false, false, '');
            $pdf->SetX(15);
            $html= '<table>';            
            foreach ($registros as $row) {
                $html .= '<tr>';
                $html .= '<th align="center" width="100">'.$row['Codigo'].'</th>';
                $html .= '<th width="200">'.$row['Descripcion'].'</th>';
                $html .= '<th align="center" width="100">'.$row['Subtotal'].'</th>';
                $html .= '<th align="center" width="100">'.$row['Financia'].'</th>';
                $html .= '</tr>';
            }
            $pdf->writeHTML($html, true, false, false, false, '');
            $pdf->Line(70, $pdf->getY(),150, $pdf->getY());
            $pdf->SetFont('helvetica', 'B', 8);  // Establecer el tamaño de letra a 8
            $totalFormatted = number_format($total, 2, '.', '');
            $pdf->Cell(202, 0, 'T O T A L   P A G A D O      S/.   =               '.$totalFormatted, 0, 1, 'C', 0, '', 0);
            $pdf->Line(70, $pdf->getY(),150, $pdf->getY());
            $pdf->Ln(5);
            $pdf->Line(15, $pdf->getY(),192, $pdf->getY());
          
          
            $pdf->Ln(2);         
$pdf->SetX(15); 
$pdf->SetFont('helvetica', '', 6);  // Establecer el tamaño de letra a 8
$pdf->Cell(70, 0, 'CAJERO MPLP:'.$id_usuario.'-'.$id_area, 0, 1, 'L', 0, '', 2);
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
