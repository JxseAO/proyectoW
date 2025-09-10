<?php
session_start();
include("../includes/conexion.php");
require("../includes/fpdf/fpdf.php");

if(!isset($_SESSION["id"])){
    header("Location: ../auth/login.php");
    exit;
}

$usuario_id = $_SESSION["id"];

// Consulta de tareas del usuario
$stmt = $conn->prepare("SELECT titulo, descripcion, estado, prioridad, fecha_vencimiento 
                        FROM tareas WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

// Crear PDF
$pdf = new FPDF('L','mm','A4'); // L = horizontal
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

// Título
$pdf->Cell(0,10,utf8_decode("Listado de Tareas"),0,1,'C');
$pdf->Ln(5);

// Encabezados
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,10,"Titulo",1,0,'C');
$pdf->Cell(80,10,"Descripcion",1,0,'C');
$pdf->Cell(30,10,"Estado",1,0,'C');
$pdf->Cell(30,10,"Prioridad",1,0,'C');
$pdf->Cell(40,10,"Vencimiento",1,1,'C');

// Datos
$pdf->SetFont('Arial','',10);
while($row = $result->fetch_assoc()){
    $pdf->Cell(50,10,utf8_decode($row['titulo']),1);
    $pdf->Cell(80,10,utf8_decode(substr($row['descripcion'],0,40)),1);
    $pdf->Cell(30,10,utf8_decode($row['estado']),1);
    $pdf->Cell(30,10,utf8_decode($row['prioridad']),1);
    $pdf->Cell(40,10,$row['fecha_vencimiento'],1,1);
}

// Salida (descargar)
$pdf->Output("D","mis_tareas.pdf");
?>
