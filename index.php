<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-form-center">
        <h2>Login</h2>
        <form action="index.php" method="post">
            <label for="nome_usuario">Nome de usuário: </label>
            <input type="text" name="nome_usuario" id="nome_usuario" required><br>
            <label for="password_user">Senha: </label>
            <input type="password" name="password_user" id="password_user" required><br>
            <button type="submit">Entrar</button><br>
            <span>Você não possui uma conta?<a href="#"> Clique aqui!</a></span>
        </form>
    </div>
</body>
</html>