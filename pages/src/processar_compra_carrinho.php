<?php
include_once("../config.php");
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['nivel'] !== 1) {

    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION['user_id'];

if (isset($_SESSION['user_id']) && isset($_POST['livro_id'])) {
    $id_usuario = $_SESSION['user_id'];
    $id_livro = $_POST['livro_id'];

    // Obter informações do livro
    $sqlPrecoLivro = "SELECT preco FROM livros WHERE id_livro = ?";
    $stmtPrecoLivro = $conn->prepare($sqlPrecoLivro);
    $stmtPrecoLivro->bind_param("i", $id_livro);
    $stmtPrecoLivro->execute();
    $resultPrecoLivro = $stmtPrecoLivro->get_result();

    if ($resultPrecoLivro->num_rows > 0) {
        $livro = $resultPrecoLivro->fetch_assoc();
        $preco_unitario = $livro['preco'];

        // Adicionar ao carrinho
        $sqlInserirCarrinho = "INSERT INTO carrinho_compras (id_usuario, id_livro, quantidade, preco_unitario) VALUES (?, ?, 1, ?)";
        $stmtInserirCarrinho = $conn->prepare($sqlInserirCarrinho);
        $stmtInserirCarrinho->bind_param("iid", $id_usuario, $id_livro, $preco_unitario);
        $stmtInserirCarrinho->execute();
        $stmtInserirCarrinho->close();

        // Redireciona de volta para a página anterior
        $redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'home.php';
        header("Location: $redirect_url");
        exit();
    }
}


header("Location: home.php");
exit();
?>
