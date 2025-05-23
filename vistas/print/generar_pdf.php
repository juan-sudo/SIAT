<?php
require_once("../../vendor/autoload.php");
require_once('./TCPDFmain/pdf/tcpdf_include.php');

// Crear nuevo PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configuración básica del documento
$pdf->SetCreator('Sistema Municipal');
$pdf->SetAuthor('Municipalidad');
$pdf->SetTitle('Prueba PDF');
$pdf->SetSubject('Prueba simple');

// Agregar página
$pdf->AddPage();

// Configurar fuente y añadir texto
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Hola', 0, 1, 'C');

// Salida del PDF (D para descarga directa)
$pdf->Output('prueba.pdf', 'D');
?>