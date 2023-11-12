<?php 

include_once("../config/config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $senha = isset($_POST['senha']) ? $_POST['senha'] : null;

    $sql_verificar_email = "SELECT id_usuario FROM usuario WHERE email = '$email'";
    $resultado = $conn->query($sql_verificar_email);

    if ($resultado === false) {
        echo "Erro ao executar a consulta: " . $conn->error;
    } elseif ($resultado->num_rows > 0) {
        // O e-mail já está cadastrado, você pode lidar com isso aqui, se necessário
        echo "E-mail já cadastrado. Por favor, escolha outro e-mail.";
    } else {
        // Inserir dados no banco de dados (sem password_hash)
        $sql = "INSERT INTO usuario (nome_usuario, email, senha) VALUES ('$nome', '$email', '$senha')";

        if ($conn->query($sql) === TRUE) {
            header("location: login.php");
        } else {
            echo "Erro ao cadastrar: " . $conn->error;
        }
    }

    $conn->close();
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <header class="logo">
        <h2>Livrosia</h2>
    </header>
    <header class="button">
        <a href="../index.php"><button class="Login">Voltar</button></a>
    </header>
    <div class="container-register-background"></div>
    <div class="container-form">
        <div class="container-img">
            <img src="../imgs/svg/phone.svg" alt="">
        </div>
        <div class="container-form-content">
            <h2>Cadastro</h2>
            <form action="#" method="post">
                <label for="nome">Nome de Usuário</label>
                <input type="text" id="nome" name="nome" required placeholder="Nome de usuário" autocomplete="off">
            
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required placeholder="E-mail" autocomplete="off">

                <label for="senha">Senha</label>
                <div class="eye" onclick="VisiblePassword();">
                    <img src="../imgs/icons/eye.png" alt="" id="eyeicon">
                </div>
                <input type="password" id="senha" name="senha" required placeholder="Senha" autocomplete="off"
                    oninput="CountLetters()">

                <button type="submit" class="button-registro" onclick="">Enviar</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>