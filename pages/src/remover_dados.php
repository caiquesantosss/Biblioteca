<?php 

include_once("../config.php");

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
