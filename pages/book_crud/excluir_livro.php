<?php
include_once("../config.php");

// Verifica se o ID do livro foi passado pela URL
if (isset($_GET['id'])) {
    $livro_id = $_GET['id'];

    // Consulta SQL para verificar se o livro existe
    $verificar_livro_sql = "SELECT * FROM livros WHERE id_livro = ?";
    $stmt_verificar_livro = $conn->prepare($verificar_livro_sql);
    $stmt_verificar_livro->bind_param("i", $livro_id);
    $stmt_verificar_livro->execute();
    $result_verificar_livro = $stmt_verificar_livro->get_result();

    // Verifica se o livro existe
    if ($result_verificar_livro->num_rows > 0) {
        // Exclui o livro
        $excluir_livro_sql = "DELETE FROM livros WHERE id_livro = ?";
        $stmt_excluir_livro = $conn->prepare($excluir_livro_sql);
        $stmt_excluir_livro->bind_param("i", $livro_id);
        $stmt_excluir_livro->execute();

        // Redireciona para a página de listagem após a exclusão
        header("Location: ../livros.php");
        exit();
    } else {
        // Se o livro não existe, redireciona para a página de listagem
        header("Location: ../livros.php");
        exit();
    }
} else {
    // Se o ID do livro não foi fornecido, redireciona para a página de listagem
    header("Location: ../livros.php");
    exit();
}

$conn->close();
?>
