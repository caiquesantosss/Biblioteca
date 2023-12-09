<?php 

include_once("../config.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['nivel'] !== 1) {

    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $img = $_POST['img'];
    $coins = $_POST['coins'];
    $nivel = $_POST['nivel'];

    // Certifique-se de que $nivel seja um número inteiro
    $nivel = intval($nivel);

    // Inserir dados no banco de dados
    $sql = "INSERT INTO usuario (nome_usuario, email, senha, img_url, coins, nivel) VALUES ('$nome', '$email', '$senha', '$img', '$coins', $nivel)";
    $resultado = $conn->query($sql);

    if ($resultado === TRUE) {
        if($img == null) {
            $sql = "INSERT INTO usuario (nome_usuario, email, senha, coins, nivel) VALUES ('$nome', '$email', '$senha', '$coins', $nivel)";
            $resultado = $conn->query($sql);
        } else {
            echo "foi";
        }
    } else {
        echo "Erro ao adicionar pessoa: " . $conn->error;
    }
}
?>


