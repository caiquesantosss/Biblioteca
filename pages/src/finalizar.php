<?php
session_start();
include_once("../config.php");

if (isset($_SESSION['user_id'])) {
    $id_usuario = $_SESSION['user_id'];

    // Calcular o valor total do carrinho
    $sqlTotalCarrinho = "SELECT SUM(preco_unitario) AS total_carrinho FROM carrinho_compras WHERE id_usuario = ?";
    $stmtTotalCarrinho = $conn->prepare($sqlTotalCarrinho);
    $stmtTotalCarrinho->bind_param("i", $id_usuario);
    $stmtTotalCarrinho->execute();
    $resultTotalCarrinho = $stmtTotalCarrinho->get_result();

    if ($resultTotalCarrinho->num_rows > 0) {
        $total_carrinho = $resultTotalCarrinho->fetch_assoc()['total_carrinho'];

        // Obter o total de coins do usuário
        $sqlTotalCoins = "SELECT coins FROM usuario WHERE id_usuario = ?";
        $stmtTotalCoins = $conn->prepare($sqlTotalCoins);
        $stmtTotalCoins->bind_param("i", $id_usuario);
        $stmtTotalCoins->execute();
        $resultTotalCoins = $stmtTotalCoins->get_result();

        if ($resultTotalCoins->num_rows > 0) {
            $total_coins_usuario = $resultTotalCoins->fetch_assoc()['coins'];

            // Verificar se o usuário tem coins suficientes para realizar a compra
            if ($total_coins_usuario >= $total_carrinho) {
                // Deduzir o valor total do carrinho do total de coins do usuário
                $novas_coins = $total_coins_usuario - $total_carrinho;

                // Atualizar o total de coins do usuário no banco de dados
                $sqlAtualizarCoins = "UPDATE usuario SET coins = ? WHERE id_usuario = ?";
                $stmtAtualizarCoins = $conn->prepare($sqlAtualizarCoins);
                $stmtAtualizarCoins->bind_param("ii", $novas_coins, $id_usuario);
                $stmtAtualizarCoins->execute();
                $stmtAtualizarCoins->close();

                // Atualizar a variável de sessão 'coins'
                $_SESSION['coins'] = $novas_coins;

                // Inserir os itens do carrinho na tabela de compras
                $sqlInserirCompra = "INSERT INTO compras (id_usuario, id_livro, quantidade, preco_total)
                                     SELECT id_usuario, id_livro, quantidade, preco_unitario FROM carrinho_compras
                                     WHERE id_usuario = ?";
                $stmtInserirCompra = $conn->prepare($sqlInserirCompra);
                $stmtInserirCompra->bind_param("i", $id_usuario);
                $stmtInserirCompra->execute();
                $stmtInserirCompra->close();

                // Limpar o carrinho após a compra
                $sqlLimparCarrinho = "DELETE FROM carrinho_compras WHERE id_usuario = ?";
                $stmtLimparCarrinho = $conn->prepare($sqlLimparCarrinho);
                $stmtLimparCarrinho->bind_param("i", $id_usuario);
                $stmtLimparCarrinho->execute();
                $stmtLimparCarrinho->close();

                // Redirecionar para a página de compras ou para a página anterior
                header("Location: ../carrinho.php"); // Substitua "compras.php" pela página desejada após a compra
                exit();
            } else {
                // Usuário não tem coins suficientes
                $_SESSION['error_message'] = "Você não possui coins suficientes para finalizar a compra do carrinho.";
            }
        }
    }
}

// Redirecionar para a página anterior em caso de erro
$redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'carrinho.php';
header("Location: $redirect_url");
exit();
?>
