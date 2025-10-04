<?php
date_default_timezone_set('America/Sao_Paulo');

// Conexão com o banco de dados
$dsn = 'mysql:host=localhost;dbname=estacionamento;charset=utf8';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $placa = $_POST['placa'];

    $stmt = $pdo->prepare("SELECT * FROM Registro WHERE Placa = :placa AND hora_saida IS NULL LIMIT 1");
    $stmt->execute(['placa' => $placa]);
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($registro) {
        $hora_saida = date('Y-m-d H:i:s'); // Captura a hora de saída correta
        $hora_entrada = new DateTime($registro['hora_entrada']);
        $hora_saida_obj = new DateTime($hora_saida);

        // Logar dados
        file_put_contents('debug.log', "Hora de Entrada: " . $hora_entrada->format('Y-m-d H:i:s') . "\n", FILE_APPEND);
        file_put_contents('debug.log', "Hora de Saída: " . $hora_saida . "\n", FILE_APPEND);

        // Cálculo da diferença
        $tempo = $hora_entrada->diff($hora_saida_obj);
        file_put_contents('debug.log', "Diferença: " . $tempo->h . " horas e " . $tempo->i . " minutos\n", FILE_APPEND);

        // Calcular o valor cobrado
        $valor_cobrado = $tempo->h * 5; // R$ 5,00 por hora

        // Atualiza a saída e valor no banco
        $stmt2 = $pdo->prepare("
            UPDATE Registro 
            SET hora_saida = :hora_saida, valor_cobrado = :valor_cobrado 
            WHERE Placa = :placa AND hora_saida IS NULL
        ");
        $stmt2->execute(['hora_saida' => $hora_saida, 'valor_cobrado' => $valor_cobrado, 'placa' => $placa]);

        echo "Saída registrada com sucesso! Valor cobrado: R$ " . number_format($valor_cobrado, 2, ',', '.') . "<br>";
        echo "<a href='index.php'>Voltar</a>";
    } else {
        echo "Nenhum registro encontrado para a placa informada ou veículo já saiu.";
    }
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>
