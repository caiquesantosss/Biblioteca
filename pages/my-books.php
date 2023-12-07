<?php
include_once ("config.php");
session_start();

if (isset($_SESSION['user_id'])) {
    $id_usuario = $_SESSION['user_id'];

    // Consultar os livros que o usuário comprou (evitando repetições)
    $sqlLivrosComprados = "
        SELECT DISTINCT livros.titulo, livros.capa
        FROM compras
        JOIN livros ON compras.id_livro = livros.id_livro
        WHERE compras.id_usuario = ?
    ";

    $stmtLivrosComprados = $conn->prepare($sqlLivrosComprados);
    $stmtLivrosComprados->bind_param("i", $id_usuario);
    $stmtLivrosComprados->execute();
    $resultLivrosComprados = $stmtLivrosComprados->get_result();

    if ($resultLivrosComprados->num_rows > 0) {
        while ($livroComprado = $resultLivrosComprados->fetch_assoc()) {
            echo "<p>Nome do Livro: " . $livroComprado['titulo'] . "</p>";
            echo "<img src='" . $livroComprado['capa'] . "' alt='Capa do Livro'><br><br>";
        }
    } else {
        echo "O usuário não comprou nenhum livro ainda.";
    }

    $stmtLivrosComprados->close();
} else {
    echo "Usuário não está autenticado.";
}
?>
