<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Estacionamento do Sr. Nelson</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f6f6f6; }
        .container { width: 350px; margin: 40px auto; background: #fff; border-radius: 7px; box-shadow: 0 0 8px #bbb; padding: 20px; }
        label { font-weight: bold; margin-top: 12px; display: block; }
        input, textarea { width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 4px; }
        button, .switch-btn { margin-top: 15px; padding: 8px 18px; border: none; border-radius: 4px; background: #1b60a6; color: #fff; font-weight: bold; cursor: pointer; }
        button:hover, .switch-btn:hover { background: #144c80; }
        .nav-btn { margin-top: 10px; float: right; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registrar Entrada</h2>
        <form action="registra_entrada.php" method="POST">
            <label for="placa">Placa:</label>
            <input type="text" id="placa" name="placa" required>
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" required>
            <label for="observacoes">Observações:</label>
            <textarea id="observacoes" name="observacoes" rows="2"></textarea>
            <button type="submit">Registrar Entrada</button>
        </form>

        <h2>Registrar Saída</h2>
        <form action="registra_saida.php" method="POST">
            <label for="placa_saida">Placa:</label>
            <select id="placa_saida" name="placa" required>
                <option value="">Selecione uma placa</option>
                <?php
                // Conexão com o banco de dados
                $dsn = 'mysql:host=localhost;dbname=estacionamento;charset=utf8';
                $username = 'root'; // Substitua pelo seu usuário
                $password = 'Lastofus2022SGF'; // Substitua pela sua senha

                try {
                    $pdo = new PDO($dsn, $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Selecionar placas que estão atualmente registradas e sem saída
                    $stmt = $pdo->query("SELECT Placa FROM Registro WHERE hora_saida IS NULL");

                    // Verifica se há placas disponíveis
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row['Placa']}'>{$row['Placa']}</option>";
                        }
                    } else {
                        echo "<option value=''>Nenhuma placa disponível</option>";
                    }

                } catch (PDOException $e) {
                    echo "Erro na conexão: " . $e->getMessage();
                }
                ?>
            </select>
            <button type="submit">Registrar Saída</button>
        </form>

        <a href="relatorio.php" class="switch-btn nav-btn">Ir para Relatório</a>
    </div>
</body>
</html>
