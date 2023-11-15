<?php

include_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $img = $_POST['img'];
    $coins = $_POST['coins'];
    $nivel = $_POST['level']; // Certifique-se de que o nome do campo no formulário está correto

    // Certifique-se de que $nivel seja um número inteiro
    $nivel = intval($nivel);

    // Atualizar os dados no banco de dados
    $sql = "UPDATE usuario SET nome_usuario='$nome', email='$email', senha='$senha', img_url='$img', coins='$coins', nivel=$nivel WHERE id_usuario=$id";
    $resultado = $conn->query($sql);

    if ($resultado === TRUE) {
        echo "foi!";
    } else {
        echo "Erro ao atualizar dados: " . $conn->error;
    }
}
