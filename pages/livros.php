<?php 
include_once("config.php");

$sql = "SELECT livros.titulo, livros.autores, livros.preco, livros.capa, categoria.nome_categoria 
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
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['titulo']}</td>
                <td>{$row['autores']}</td>
                <td>{$row['preco']}</td>
                <td><img src='{$row['capa']}' alt='Capa do Livro' style='width: 50px; height: 70px;'></td>
                <td>{$row['nome_categoria']}</td>
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
    </style>
</head>
<body>
    
</body>
</html>