<?php
session_start();
include_once("../config.php");
if (!isset($_SESSION['user_id']) || $_SESSION['nivel'] !== 1) {

    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION['user_id'];

if (isset($_SESSION['user_id']) && isset($_POST['livro_id'])) {
    $id_usuario = $_SESSION['user_id'];
    $id_livro = $_POST['livro_id'];

    // Obter informações do livro
    $sqlLivro = "SELECT * FROM livros WHERE id_livro = ?";
    $stmtLivro = $conn->prepare($sqlLivro);
    $stmtLivro->bind_param("i", $id_livro);
    $stmtLivro->execute();
    $resultLivro = $stmtLivro->get_result();

    if ($resultLivro->num_rows > 0) {
        $livro = $resultLivro->fetch_assoc();
        $preco_livro = $livro['preco']; // Adiciona esta linha para obter o preço do livro

        // Verificar se o usuário tem coins suficientes
        $sqlUsuario = "SELECT coins FROM usuario WHERE id_usuario = ?";
        $stmtUsuario = $conn->prepare($sqlUsuario);
        $stmtUsuario->bind_param("i", $id_usuario);
        $stmtUsuario->execute();
        $resultUsuario = $stmtUsuario->get_result();

        if ($resultUsuario->num_rows > 0) {
            $usuario = $resultUsuario->fetch_assoc();
            $coins_usuario = $usuario['coins'];

            // Verificar se o usuário tem coins suficientes para comprar o livro
            if ($coins_usuario >= $preco_livro) {
                // Deduzir o preço do livro do total de coins do usuário
                $novas_coins = $coins_usuario - $preco_livro;

                // Atualizar o total de coins do usuário no banco de dados
                $sqlAtualizarCoins = "UPDATE usuario SET coins = ? WHERE id_usuario = ?";
                $stmtAtualizarCoins = $conn->prepare($sqlAtualizarCoins);
                $stmtAtualizarCoins->bind_param("ii", $novas_coins, $id_usuario);
                $stmtAtualizarCoins->execute();
                $stmtAtualizarCoins->close();

                // Atualizar a variável de sessão 'coins'
                $_SESSION['coins'] = $novas_coins; // Adicione esta linha para atualizar a variável de sessão 'coins'

                // Inserir o livro na tabela de compras
                $sqlInserirCompra = "INSERT INTO compras (id_usuario, id_livro, quantidade, preco_total) VALUES (?, ?, 1, ?)";
                $stmtInserirCompra = $conn->prepare($sqlInserirCompra);
                $stmtInserirCompra->bind_param("iid", $id_usuario, $id_livro, $preco_livro);
                $stmtInserirCompra->execute();
                $stmtInserirCompra->close();

                // Redirecionar para a página de compras ou para a página anterior
                header("Location: ../comprar-livro.php"); // Substitua "compras.php" pela página desejada após a compra
                exit();
            } else {
                // Usuário não tem coins suficientes
                $_SESSION['error_message'] = "Você não possui coins suficientes para comprar este livro.";
            }
        }
    }

    // Redirecionar para a página anterior em caso de erro
    $redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'home.php';
    header("Location: $redirect_url");
    exit();
}

// Redirecionar para a página inicial se algo der errado
header("Location: home.php");
exit();
?>
