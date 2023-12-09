<?php 
session_start();

// Verificar se o usuário não está autenticado
if (!isset($_SESSION['user_id'])) {
    // Redirecionar para a página de login
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Livros</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Raleway", sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #f8f9fa;
        }

        th, td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #343a40;
            color: white;
        }

        img {
            max-width: 80px;
            max-height: 120px;
            border-radius: 5px;
        }

        .btn-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }

        .btn-add, .btn-edit, .btn-delete {
            margin: 10px;
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 14px;
        }

        .btn-add {
            background-color: #28a745;
        }

        .btn-add:hover {
            background-color: #218838;
        }

        .btn-edit {
            background-color: #007bff;
        }

        .btn-edit:hover {
            background-color: #0056b3;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        h1 {
            color: #343a40;
            margin-bottom: 20px;
            text-align: center;
        }

        .last-td {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Lista de Livros</h1>
        <?php
            include_once("config.php");

            $sql = "SELECT livros.id_livro, livros.titulo, livros.autores, livros.preco, livros.capa, categoria.nome_categoria 
                    FROM livros
                    JOIN categoria ON livros.categoria_id = categoria.id_categoria";
            $result = $conn->query($sql);

            // Exibir a tabela HTML
            if ($result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>Título</th>
                            <th>Autores</th>
                            <th>Preço</th>
                            <th>Capa</th>
                            <th>Categoria</th>
                            <th>Ações</th>
                        </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['titulo']}</td>
                            <td>{$row['autores']}</td>
                            <td>R$ {$row['preco']}</td>
                            <td><img src='{$row['capa']}' alt='Capa do Livro'></td>
                            <td>{$row['nome_categoria']}</td>
                            <td class='last-td'>
                                <a href='./book_crud/editar_livro.php?id={$row['id_livro']}' class='btn-edit'>Editar</a>
                                <a href='excluir_livro.php?id={$row['id_livro']}' class='btn-delete'>Excluir</a>
                            </td>
                        </tr>";
                }

                echo "</table>";
            } else {
                echo "<p style='text-align: center; margin-top: 20px;'>Nenhum resultado encontrado.</p>";
            }

            $conn->close();
        ?>

        <div class="btn-container">
            <button class="btn-add" onclick="location.href='./book_crud/processar_acoes.php?acao=1'">Adicionar Livro</button>
        </div>
    </div>
</body>

</html>
