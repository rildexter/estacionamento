<?php
// Definindo o fuso horário corretamente
date_default_timezone_set('America/Sao_Paulo');

// Conexão com o banco de dados
$dsn = 'mysql:host=localhost;dbname=estacionamento;charset=utf8';
$username = 'root'; // Altere para seu usuário
$password = ''; // Altere para sua senha

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Receber dados do formulário
    $placa = $_POST['placa'];
    $modelo = $_POST['modelo']; // Adicionado
    $observacoes = $_POST['observacoes'];

    // Insira nas tabelas
    $stmt1 = $pdo->prepare("INSERT INTO Carro (Placa, Modelo) VALUES (:placa, :modelo)");
    $stmt1->execute(['placa' => $placa, 'modelo' => $modelo]); // Adicionando modelo

    // Registra a entrada
    $hora_entrada = date('Y-m-d H:i:s'); // Hora atual
    $valor_cobrado = 0; // Lógica para calcular o valor
    $stmt2 = $pdo->prepare("INSERT INTO Registro (Placa, hora_entrada, valor_cobrado, observacoes) VALUES (:placa, :hora_entrada, :valor_cobrado, :observacoes)");
    
    // Loga a hora de entrada
    file_put_contents('debug.log', "Hora de Entrada: " . $hora_entrada . "\n", FILE_APPEND);
    
    $stmt2->execute(['placa' => $placa, 'hora_entrada' => $hora_entrada, 'valor_cobrado' => $valor_cobrado, 'observacoes' => $observacoes]);

    echo "Entrada registrada com sucesso!";
    echo "<br><a href='index.php'>Voltar</a>";
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>
