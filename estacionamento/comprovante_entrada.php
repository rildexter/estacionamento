<?php
session_start();
$placa = $_SESSION['placa'];
$modelo = $_SESSION['modelo'];
$observacoes = $_SESSION['observacoes'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Comprovante de Entrada</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 350px; margin: 40px auto; background: #fff; border-radius: 7px; box-shadow: 0 0 8px #bbb; padding: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Comprovante de Entrada</h2>
        <p>Veículo: <?php echo $placa; ?></p>
        <p>Modelo: <?php echo $modelo; ?></p>
        <p>Hora de Entrada: <?php echo date('Y-m-d H:i:s'); ?></p>
        <p>Observações: <?php echo $observacoes; ?></p>
        <p>Código do Comprovante: <?php echo uniqid(); ?></p>

        <button onclick="window.print()">Imprimir</button>
      

        <a href="index.php">Voltar</a>
    </div>
</body>
</html>

<?php
session_destroy();
?>

<?php
if (isset($_GET['download'])) {
    $arquivo = 'comprovante_' . uniqid() . '.pdf';

    // criar o arquivo pdf
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Comprovante de Entrada', 0, 1, 'C');
    $pdf->Ln();
    $pdf->Cell(0, 10, 'Veículo: ' . $placa, 0, 1, 'L');
    $pdf->Cell(0, 10, 'Modelo: ' . $modelo, 0, 1, 'L');
    $pdf->Cell(0, 10, 'Hora de Entrada: ' . date('Y-m-d H:i:s'), 0, 1, 'L');
    $pdf->Cell(0, 10, 'Observações: ' . $observacoes, 0, 1, 'L');
    $pdf->Cell(0, 10, 'Código do Comprovante: ' . uniqid(), 0, 1, 'L');

    // salvar o arquivo
    $pdf->Output($arquivo, 'F');

    // fazer o download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $arquivo . '"');
    readfile($arquivo);

    // remover o arquivo
    unlink($arquivo);

    exit;
}
?>
