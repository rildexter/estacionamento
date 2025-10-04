<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório - Estacionamento do Sr. Nelson</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f6f6f6; }
        .container { width: 800px; margin: 40px auto; background: #fff; border-radius: 7px; box-shadow: 0 0 8px #bbb; padding: 20px; }
        h2 { margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 18px; }
        th, td { border: 1px solid #ccc; padding: 8px 5px; text-align: center; }
        th { background: #1b60a6; color: #fff; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .totais { text-align: right; font-weight: bold; color: #1b60a6;}
        .switch-btn { margin-top: 15px; padding: 8px 18px; border: none; border-radius: 4px; background: #1b60a6; color: #fff; font-weight: bold; cursor: pointer; }
        .switch-btn:hover { background: #144c80; }
        .nav-btn { float: right; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Relatório de Movimentação</h2> 
        <table>
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Modelo</th>
                    <th>Hora de Entrada</th>
                    <th>Hora de Saída</th>
                    <th>Valor Cobrado</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexão com o banco de dados
                $dsn = 'mysql:host=localhost;dbname=estacionamento;charset=utf8';
                $username = 'root'; // Substitua pelo seu usuário
                $password = ''; // Substitua pela sua senha

                try {
                    $pdo = new PDO($dsn, $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    // Consulta para obter dados de Registro e Modelo de Carro
                    $stmt = $pdo->query("
                        SELECT Registro.Placa, Carro.Modelo, Registro.hora_entrada, Registro.hora_saida, Registro.valor_cobrado, Registro.observacoes
                        FROM Registro
                        JOIN Carro ON Registro.Placa = Carro.Placa
                    ");
                    $total_arrecadado = 0;

                    // Exibe cada linha do resultado
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                            <td>{$row['Placa']}</td>
                            <td>{$row['Modelo']}</td>
                            <td>{$row['hora_entrada']}</td>
                            <td>{$row['hora_saida']}</td>
                            <td>R$ " . number_format($row['valor_cobrado'], 2, ',', '.') . "</td>
                            <td>{$row['observacoes']}</td>
                        </tr>";
                        $total_arrecadado += $row['valor_cobrado'];
                    }
                } catch (PDOException $e) {
                    echo "Erro na conexão: " . $e->getMessage();
                }
                ?>
            </tbody>
        </table>
        
        <p class="totais">Total arrecadado no dia: <b>R$ <?php echo number_format($total_arrecadado, 2, ',', '.'); ?></b></p>
        <a href="index.php" class="switch-btn nav-btn">Voltar para Registro</a>
    </div>
</body>
</html>
