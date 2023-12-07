<?php
session_start();
include_once("../config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id_carrinho'])) {
    $id_carrinho = $_GET['id_carrinho'];

    $stmt = $conn->prepare("SELECT id_carrinho FROM carrinho_compras WHERE id_usuario = ? AND id_carrinho = ?");
    $stmt->bind_param("ii", $user_id, $id_carrinho);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $stmt = $conn->prepare("DELETE FROM carrinho_compras WHERE id_carrinho = ?");
        $stmt->bind_param("i", $id_carrinho);
        $stmt->execute();
        $stmt->close();

        // Redirecione de volta para a página do carrinho
        header("Location: ../carrinho.php");
        exit();
    } else {
        header("Location: ../carrinho.php?error=1");
        exit();
    }
} else {
    header("Location: ../carrinho.php?error=2");
    exit();
}
?>
