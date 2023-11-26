<?php 

session_start();
$coins = $_SESSION['coins'];



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coins</title>
</head>
<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="style-home.css">

<body id="user">
    <header class="logo">
        <h2>Livrosia</h2>
    </header>
    <header class="nav-header">
        <nav>
            <a href="./whoweare.php">Quem nós somos?</a>
            <a href="#livros">Livros</a>
            <a href="#categorias">Categorias</a>
            <a href="./comprar.php">Compre Coins</a>
        </nav>
    </header>

    <p class="coins">Seus coins:
        <?php echo $coins ?>
    </p>

    <h1>Compra de Coins</h1>
    <form action="./src/processar.php" method="post">
        <button type="submit" name="comprar_coins" value="10">Comprar 10 coins</button>
        <button type="submit" name="comprar_coins" value="20">Comprar 20 coins</button>
        <button type="submit" name="comprar_coins" value="1000">Comprar 1000 coins</button> 
        <!-- Adicione mais botões conforme necessário -->
    </form>
</body>
</html>