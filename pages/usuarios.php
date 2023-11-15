<?php

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
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
   
<a href="src/adicionar_usuario.html">Adicionar</a>
</body>
<script>
        function atualizar(id) {
            window.location = 'src/atulizar_dados.php?id=' + id
        }

        function remover(id) {
        if (confirm('Tem certeza que deseja remover este registro?')) {
            window.location.href = 'src/remover_dados.php?id=' + id
        }

     
    }

    </script>
</html>