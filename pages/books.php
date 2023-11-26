<?php 
include_once("config.php");

$sql = "SELECT * FROM livros";
$result = $conn->query($sql);

// Fechar a conexão
$conn->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style-home.css">
    <link rel="stylesheet" href="../style.css">
    <style>
         img {
            max-width: 100px;
            max-height: 140px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<header class="logo">
        <h2>Livrosia</h2>
    </header>
    <header class="nav-header">
        <a href="./home.php">Início</a>
        <a href="#livros">Livros</a>
        <a href="#categorias">Categorias</a>
        <a href="#compre-coins">Compre Coins</a>
    </header>
    <div class="container-books">
    <?php 
    
    while ($row = $result->fetch_assoc()) {
        echo "<div class='livro'>";
        echo "<img src='" . $row['capa'] . "' alt='Capa do Livro'>";
        echo "<h3>" . $row['titulo'] . "</h3>";
        echo "<p>Preço: R$ " . number_format($row['preco'], 2, ',', '.') . "</p>";
        echo "</div>";
    }
    
    ?>
    </div>
</body>
</html>