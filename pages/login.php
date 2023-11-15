<?php

include_once("config.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['nome'];
  $password = $_POST['senha'];


  // Consulta SQL para verificar as credenciais usando instruções preparadas
  $stmt = $conn->prepare("SELECT id_usuario, nome_usuario, email, img_url, coins FROM usuario WHERE nome_usuario = ? AND senha = ?");
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  // Verificar se há resultados
  if ($result->num_rows == 1) {
      // Login bem-sucedido, armazenar informações do usuário na sessão
      $row = $result->fetch_assoc();
      $_SESSION['user_id'] = $row['id_usuario'];
      $_SESSION['username'] = $row['nome_usuario'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['imgUrl'] = $row['img_url'];
      $_SESSION['coins'] = $row['coins'];

      // Redirecionar para a página principal ou outra página após o login
      header("Location: home.php");
      exit();
  } else {
      $erroLogin = "Credenciais inválidas. Tente novamente.";
  }

  $stmt->close();
  $conn->close();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../style.css">
 
</head>

<body>
  <header class="logo">
    <h2>Livrosia</h2>
  </header>
  <header class="button">
    <a href="../index.php"><button class="Login">Voltar</button></a>
  </header>

  <div class="container-background-login"></div>

    <div class="container-form-login">
      <form action="#" class="form-login" method="POST">
      <label for="nome">Nome de usuário</label>
      <input type="text" id="nome" name="nome" required placeholder="Nome de usuário" autocomplete="off">

      <label for="senha" class="label-senha">Senha</label>
      <div class="eye" onclick="VisiblePassword();">
        <img src="../imgs/icons/eye.png" alt="" id="eyeicon">
      </div>
      <input type="password" id="senha" name="senha" required placeholder="Senha" autocomplete="off"
        oninput="CountLetters()">

      <button type="submit" class="button-registro" onclick="">Entrar</button>
      </form>
    </div>

  <div class="container-img-login">
    <img src="../imgs/svg/login.svg" alt="">
  </div>

  <script src="script.js"></script>
</body>

</html>