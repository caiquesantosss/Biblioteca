<?php 

session_start();
    if(!isset($_SESSION["user_id"])) {
        header("Location: login.php");
            exit();
    } 

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$img = $_SESSION['imgUrl'];
$coins = $_SESSION['coins'];

echo "<h3 id='coins'>" . $coins . "</h3>";
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
    img {
        height: 100px;
        width: 100px;
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
       <img src="<?php echo $img; ?>" alt="oi">
       
    <a href="./src/logout.php">Sair</a>
    <script src="../script.js"></script>
</body>
<script>
</script>
</html>