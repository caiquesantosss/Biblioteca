<?php 
include_once("config.php");

// Iniciar a sessão
session_start();

// Verificar se o usuário está logado e se o ID do usuário foi definido na sessão
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Consultar o banco de dados para obter o nível do usuário com base no ID
    $sqlNivel = "SELECT nivel FROM usuario WHERE id_usuario = ?";
    $stmtNivel = $conn->prepare($sqlNivel);
    $stmtNivel->bind_param("i", $userId);
    $stmtNivel->execute();
    $resultNivel = $stmtNivel->get_result();

    // Verificar se o nível foi encontrado
    if ($resultNivel->num_rows > 0) {
        $nivelUsuario = $resultNivel->fetch_assoc()['nivel'];
    } else {
        // Se o nível não for encontrado, defina um valor padrão ou manipule conforme necessário
        $nivelUsuario = 0;
    }

    // Fechar a consulta
    $stmtNivel->close();

    // Continuar com a consulta dos livros
    $sqlLivros = "SELECT * FROM livros";
    $result = $conn->query($sqlLivros);

    // Fechar a conexão
    $conn->close();
} else {
    // Se o usuário não estiver logado, redirecionar para a página de login ou fazer outra coisa
    header("Location: login.php");
    exit();
}
?>

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
            cursor: pointer; /* Adiciona a mãozinha quando o cursor está sobre a imagem */
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

    <?php
        // Adicione o botão "Editar Livros" se o usuário tiver o nível 1
        if ($nivelUsuario == 1) {
            echo '<a href="livros.php" class="livros">Editar Livros</a>';
        }
        ?>

    <div class="container-books">
    <?php 
    while ($row = $result->fetch_assoc()) {
        echo "<div class='livro' data-titulo='{$row['titulo']}' data-preco='{$row['preco']}'>";
        echo "<img src='" . $row['capa'] . "' alt='Capa do Livro'>";
        echo "<h3>" . $row['titulo'] . "</h3>";
        echo "<p>Preço: R$ " . number_format($row['preco'], 2, ',', '.') . "</p>";
        echo "</div>";
    }
    ?>
    </div>

    <script>
        // Adiciona um ouvinte de eventos para cada elemento com a classe 'livro'
        document.querySelectorAll('.livro').forEach(function(element) {
        element.addEventListener('click', function() {
            // Obtém os dados do livro do atributo data-
            var titulo = this.getAttribute('data-titulo')
            var preco = this.getAttribute('data-preco')

            // Codifica os parâmetros para passar pela URL
            var tituloEncoded = encodeURIComponent(titulo)
            var precoEncoded = encodeURIComponent(preco)

            // Constrói a URL de redirecionamento com os parâmetros
            var url = 'comprar-livro.php?titulo=' + tituloEncoded + '&preco=' + precoEncoded

            // Redireciona para a página de compra
            window.location.href = url
        });
    });
    </script>
</body>
</html>
