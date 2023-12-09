<?php
session_start();
include_once("../config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['nivel'] !== 1) {

    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comprar_coins'])) {
    // Obter a quantidade a comprar
    $quantidade_comprada = intval($_POST['comprar_coins']); // Certifique-se de converter para um número inteiro

    // Verificar se a quantidade é válida (você pode adicionar mais validações)
    if ($quantidade_comprada > 0) {
        // Supondo que você tenha uma variável de usuário (substitua pelo método que você usa para obter o usuário autenticado)
        $id_usuario = $_SESSION['user_id'];; // Substitua pelo método de obtenção do usuário autenticado

        // Obter o saldo atual do usuário
        $query_saldo = "SELECT coins FROM usuario WHERE id_usuario = $id_usuario";
        $resultado_saldo = $conn->query($query_saldo);

        if ($resultado_saldo->num_rows > 0) {
            $dados_usuario = $resultado_saldo->fetch_assoc();
            $saldo_atual = $dados_usuario['coins'];

            // Atualizar o saldo do usuário
            $novo_saldo = $saldo_atual + $quantidade_comprada;
            $query_atualizar_saldo = "UPDATE usuario SET coins = $novo_saldo WHERE id_usuario = $id_usuario";

            if ($conn->query($query_atualizar_saldo) === TRUE) {
                // Atualizar a variável de sessão
                $_SESSION['coins'] = $novo_saldo;

                // Redirecionar para a página de sucesso
                header("Location: ../comprar.php");
                exit();
            } else {
                echo "Erro ao atualizar o saldo: " . $conn->error;
            }
        } else {
            echo "Usuário não encontrado.";
        }
    } else {
        echo "Quantidade inválida.";
    }
}

// Fechar a conexão
$conn->close();
?>
