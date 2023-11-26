<?php

session_start();
include_once("../pages/config.php");

$user_id = $_SESSION['user_id'];

// Define o diretório de destino
$uploadDir = "../imgs/imgs_users/";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o arquivo foi enviado sem erros
    if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {
        // Move o arquivo temporário para o diretório de destino
        $uploadFile = $uploadDir . basename($_FILES["imagem"]["name"]);

        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $uploadFile)) {
            // Atualiza a URL da imagem no banco de dados para o usuário logado
            $urlImagem = $uploadFile;

            // Substitua "sua_tabela_usuarios" pelo nome real da sua tabela de usuários
            $sql = "UPDATE usuario SET img_url = '$urlImagem' WHERE id_usuario = $user_id";

            // Execute a query de atualização
            if ($conn->query($sql) === TRUE) {
                // Redireciona para evitar o reenvio do formulário
                header("Location: ../pages/home.php");
                exit();
            } else {
                echo "Erro ao atualizar o banco de dados: " . $conn->error;
            }
        } else {
            echo "Erro ao enviar a imagem.";
        }
    } else {
        echo "Erro: " . $_FILES["imagem"]["error"];
    }
}
?>
