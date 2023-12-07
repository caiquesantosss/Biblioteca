<?php 
include_once("config.php");

$sql = "SELECT livros.id_livro, livros.titulo, livros.autores, livros.preco, livros.capa, categoria.nome_categoria 
        FROM livros
        JOIN categoria ON livros.categoria_id = categoria.id_categoria";
$result = $conn->query($sql);

// Exibir a tabela HTML
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Título</th>
                <th>Autores</th>
                <th>Preço</th>
                <th>Capa</th>
                <th>Categoria</th>
                <th>Ações</th> <!-- Nova coluna para botões -->
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['titulo']}</td>
                <td>{$row['autores']}</td>
                <td>{$row['preco']}</td>
                <td><img src='{$row['capa']}' alt='Capa do Livro' style='width: 50px; height: 70px;'></td>
                <td>{$row['nome_categoria']}</td>
                <td>
                    <a href='./book_crud/editar_livro.php?id={$row['id_livro']}'>Editar</a>
                    <a href='excluir_livro.php?id={$row['id_livro']}'>Excluir</a>
                </td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "Nenhum resultado encontrado.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            max-height: 140px;
            border-radius: 5px;
        }

        .btn-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-add {
            margin: 10px;
            padding: 10px;

            background-color: #474bff;
            color: white;
            border: none;
            border-radius: 10px;

            cursor: pointer;
        }
  
    </style>
</head>
<body>
    <div class="btn-container">
    <button class="btn-add" onclick="location.href='./book_crud/processar_acoes.php?acao=1'">Adicionar Livro</button>

    </div>
</body>
</html>
