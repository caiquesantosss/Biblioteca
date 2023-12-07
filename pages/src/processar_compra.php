<?php
session_start();
include_once("../config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['comprar']) && isset($_POST['livro_id'])) {
    $user_id = $_SESSION['user_id'];
    $livro_id = $_POST['livro_id'];

    // Obter informações do livro
    $sqlPrecoLivro = "SELECT preco FROM livros WHERE id_livro = ?";
    $stmtPrecoLivro = $conn->prepare($sqlPrecoLivro);
    $stmtPrecoLivro->bind_param("i", $livro_id);
    $stmtPrecoLivro->execute();
    $resultPrecoLivro = $stmtPrecoLivro->get_result();

    if ($resultPrecoLivro->num_rows > 0) {
        $livro = $resultPrecoLivro->fetch_assoc();
        $preco_unitario = $livro['preco'];

        // Verificar se o usuário tem coins suficientes
        $sqlUsuarioCoins = "SELECT coins FROM usuario WHERE id_usuario = ?";
        $stmtUsuarioCoins = $conn->prepare($sqlUsuarioCoins);
        $stmtUsuarioCoins->bind_param("i", $user_id);
        $stmtUsuarioCoins->execute();
        $resultUsuarioCoins = $stmtUsuarioCoins->get_result();

        if ($resultUsuarioCoins->num_rows > 0) {
            $usuario = $resultUsuarioCoins->fetch_assoc();
            $coins_usuario = $usuario['coins'];

            // Verificar se o usuário tem coins suficientes para a compra
            if ($coins_usuario >= $preco_unitario) {
                // Deduzir as coins do usuário
                $novas_coins = $coins_usuario - $preco_unitario;
                $sqlAtualizarCoins = "UPDATE usuario SET coins = ? WHERE id_usuario = ?";
                $stmtAtualizarCoins = $conn->prepare($sqlAtualizarCoins);
                $stmtAtualizarCoins->bind_param("ii", $novas_coins, $user_id);
                $stmtAtualizarCoins->execute();
                $stmtAtualizarCoins->close();

                // Inserir na tabela de compras
                $sqlInserirCompra = "INSERT INTO compras (id_usuario, id_livro, quantidade, preco_total) VALUES (?, ?, 1, ?)";
                $stmtInserirCompra = $conn->prepare($sqlInserirCompra);
                $stmtInserirCompra->bind_param("iid", $user_id, $livro_id, $preco_unitario);
                $stmtInserirCompra->execute();
                $stmtInserirCompra->close();

                // Redirecionar para a página de sucesso ou home
                header("Location: ../compra_sucesso.php");
                exit();
            } else {
                // Usuário não tem coins suficientes
                header("Location: ../carrinho.php?coins_insuficientes=1");
                exit();
            }
        }
        $stmtUsuarioCoins->close();
    }
    $stmtPrecoLivro->close();
}

// Redirecionar para o carrinho se algo der errado
header("Location: ../carrinho.php?erro=1");
exit();
?>
