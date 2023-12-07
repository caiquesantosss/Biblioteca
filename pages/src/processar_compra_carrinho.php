<?php
include_once("../config.php");
session_start();

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

        // Verificar se o usuário tem coins suficientes
        $sqlUsuarioCoins = "SELECT coins FROM usuario WHERE id_usuario = ?";
        $stmtUsuarioCoins = $conn->prepare($sqlUsuarioCoins);
        $stmtUsuarioCoins->bind_param("i", $id_usuario);
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
                $stmtAtualizarCoins->bind_param("ii", $novas_coins, $id_usuario);
                $stmtAtualizarCoins->execute();
                $stmtAtualizarCoins->close();

                // Atualizar a variável de sessão 'coins'
                $_SESSION['coins'] = $novas_coins;

                // Inserir na tabela de compras
                $sqlInserirCompra = "INSERT INTO compras (id_usuario, id_livro, quantidade, preco_total) VALUES (?, ?, 1, ?)";
                $stmtInserirCompra = $conn->prepare($sqlInserirCompra);
                $stmtInserirCompra->bind_param("iid", $id_usuario, $id_livro, $preco_unitario);
                $stmtInserirCompra->execute();
                $stmtInserirCompra->close();

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
            } else {
                // Usuário não tem coins suficientes
                echo "Você não tem coins suficientes para comprar este livro.";
            }
        }
        $stmtUsuarioCoins->close();
    }
    $stmtPrecoLivro->close();
}

// Redirecionar para a página inicial se algo der errado
header("Location: home.php");
exit();
?>
