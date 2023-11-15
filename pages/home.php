<?php

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$img = $_SESSION['imgUrl'];
$coins = $_SESSION['coins'];

$imagemPath = '../imgs/' . $img;

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="style-home.css">
</head>
<style>
    .user_img {
        height: 50px;
        width: 50px;

        position: absolute;
        top: 25%;
        left: 5%;
        transform: translate(-50%, -50%);

        cursor: pointer;
    }
</style>

<body id="user">
    <header class="logo">
        <h2>Livrosia</h2>
    </header>
    <header class="nav-header">
        <nav>
            <a href="#quem-somos">Quem nós somos?</a>
            <a href="#livros">Livros</a>
            <a href="#categorias">Categorias</a>
            <a href="#compre-coins">Compre Coins</a>
        </nav>
    </header>

    <?php echo "<img src='$imagemPath' alt='Imagem do Usuário' class='user_img' id='openModalBtn'>"; ?>
    <p class="coins">Seus coins: <?php echo $coins?></p>

    <div class="container-bar-search">
        <form>
            <input type="search" id="search" name="search" list="datalist-options" class="search"
                placeholder="Pesquise aqui!">
            <datalist id="datalist-options"></datalist>
        </form>
    </div>
    <a href="./src/logout.php">Sair</a>


        <form action="./src/atualizar_img.php" method="POST" enctype="multipart/form-data">
        Selecione um arquivo para fazer o upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload" name="submit">
        </form>

   
    <script src="./script.js"></script>
</body>
<script>
    
</script>

</html>