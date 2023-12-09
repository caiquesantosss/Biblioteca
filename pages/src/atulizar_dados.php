<?php
include_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM usuario WHERE id_usuario = $id";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();

        $nome = $row['nome_usuario'];
        $email = $row['email'];
        $senha = $row['senha'];
        $img = $row['img_url'];
        $coins = $row['coins'];
        $level = $row['nivel'];
    } else {
        echo "Registro não encontrado.";
        exit();
    }
} else {
    echo "ID não fornecido.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <style>
    </style>
</head>
<body>
    <form method="post" action="processar.dados.php">
        <input type="hidden" name="id" value="<?= $id ?>">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?= $nome ?>" required>
        <label for="email">Email:</label>
        <input type="text" name="email" value="<?= $email ?>" required>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" value="<?= $senha ?>" required>
        <label for="img">Img:</label>
        <input type="text" name="img" value="<?= $img ?>" required>
        <label for="coins">Coins:</label>
        <input type="text" name="coins" value="<?= $coins ?>" required>
        <label for="level">Nível:</label>
        <input type="Number" name="level" value="<?= $level ?>" max="1" required>
        <input type="submit" value="Atualizar">
    </form>
    <a href="javascript:history.back()">Voltar</a>
</body>
</html>
