<?php 

include_once("../config.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['nivel'] !== 1) {

    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Remover o registro do banco de dados
    $sql = "DELETE FROM usuario WHERE id_usuario=$id";
    $resultado = $conn->query($sql);

    if ($resultado === TRUE) {
        echo "Registro removido com sucesso.";
    } else {
        echo "Erro ao remover registro: " . $conn->error;
    }
}
