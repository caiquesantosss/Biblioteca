<?php

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['nivel'] !== 1) {

    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

include_once("config.php");


// Consulta SQL para obter todos os dados da tabela
$sql = "SELECT * FROM usuario";
$resultado = $conn->query($sql);

// Verificar se a consulta foi bem-sucedida
if ($resultado->num_rows > 0) {
    // Exibir cabeçalho da tabela
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Senha</th>
                <th>Img</th>
                <th>Coins</th>
                <th>Nivel</th>
                <th>Ações</th>
            </tr>";

    // Exibir dados da tabela
    while ($row = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id_usuario']}</td>
                <td>{$row['nome_usuario']}</td>
                <td>{$row['email']}</td>
                <td>{$row['senha']}</td>
                <td>{$row['img_url']}</td>
                <td>{$row['coins']}</td>
                <td>{$row['nivel']}</td>
                <td>
                <button onclick='atualizar({$row['id_usuario']})'>Atualizar</button>
                <button onclick='remover({$row['id_usuario']})'>Remover</button>
            </td>
              </tr>";
    }

    // Fechar a tabela
    echo "</table>";
} else {
    echo "Nenhum resultado encontrado na tabela.";
}

// Fechar a conexão com o banco de dados
$conn->close();
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos os Registros</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;


        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 12px;
        }

        th {
            background-color: #474bff;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            margin: 20px 0;
            background-color: #474bff;

            padding: 5px;
            padding-inline: 10px;
            border-radius: 5px;
            color: white;

            transition: 0.5s all ease;
        }

        a:hover {
            color: #474bff;
            background-color: #f4f4f4;
        }

        button {
            padding: 8px 12px;
            background-color: #474bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-right: 4px;
        }

        button:hover {
            background-color: #333;
        }
    </style>
</head>

<body>
    <a href="src/adicionar_usuario.php">Adicionar</a>

</body>

<script>
    function atualizar(id) {
        window.location = 'src/atualizar_dados.php?id=' + id;
    }

    function remover(id) {
        if (confirm('Tem certeza que deseja remover este registro?')) {
            window.location.href = 'src/remover_dados.php?id=' + id;
        }
    }
</script>

</html>
