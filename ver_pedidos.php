<?php

header('Content-Type: text/html; charset=UTF-8');

// Configurações do banco de dados (mesmas que em API.php)
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'Juliocesar22';
$dbName = 'entregas_db';

// Conexão com o banco de dados
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos de Entrega</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .no-records {
            text-align: center;
            padding: 20px;
            color: #555;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
        }
        .back-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Pedidos de Entrega</h1>

        <?php
        $sql = "SELECT id, nome, endereco, cidade, telefone, data_entrega, observacoes, data_cadastro FROM pedidos ORDER BY data_cadastro DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Nome</th>";
            echo "<th>Endereço</th>";
            echo "<th>Cidade</th>";
            echo "<th>Telefone</th>";
            echo "<th>Prazo de Entrega</th>";
            echo "<th>Observações</th>";
            echo "<th>Data Registro</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            // Saída de dados de cada linha
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["endereco"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["cidade"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["telefone"]) . "</td>";
                echo "<td>" . date('d/m/Y', strtotime($row["data_entrega"])) . "</td>";
                echo "<td>" . (empty($row["observacoes"]) ? "Nenhuma" : htmlspecialchars($row["observacoes"])) . "</td>";
                echo "<td>" . date('d/m/Y H:i:s', strtotime($row["data_cadastro"])) . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p class='no-records'>Nenhum pedido de entrega registrado ainda.</p>";
        }
        $conn->close();
        ?>

        <div class="back-link">
            <a href="index.html">Voltar ao Formulário de Pedidos</a>
        </div>
    </div>
</body>
</html>