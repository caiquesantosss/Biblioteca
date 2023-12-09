<!-- O arquivo foi mudado para a extensão PHTML para conseguirmos rodar o javascript juntamente com o PHP -->



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="style-home.css">
</head>
<style>
    * {
        font-family: "Raleway", sans-serif;
        list-style: none;
    }

    .nav-header>a {
        padding-right: 10px;
    }
</style>

<body id="user">

    <header class="logo">
        <h2>Livrosia</h2>
    </header>
    <header class="nav-header">
        <a href="./home.php">Início</a>
        <a href="books.php">Livros</a>
        <a href="comprar.php">Compre Coins</a>
        <a href="my-books.php">Meu livros</a>
    </header>

    <div class="container-text-teste">
        <h2>Veja abaixo</h2>
        <h3>Informações sobre a gente!</h3>
    </div>

    <div style="position: relative; width: 80%; height: 0; padding-top: 56.2500%;
 padding-bottom: 0; box-shadow: 0 2px 8px 0 rgba(63,69,81,0.16); margin-top: 1.6em; margin-bottom: 0.9em; overflow: hidden;
 border-radius: 8px; will-change: transform;" class="power-apresentation">
        <iframe loading="lazy"
            style="position: absolute; width: 100%; height: 90%; top: 0; left: 0; border: none; padding: 0;margin: 0;"
            src="https:&#x2F;&#x2F;www.canva.com&#x2F;design&#x2F;DAF1kRq0haw&#x2F;view?embed"
            allowfullscreen="allowfullscreen" allow="fullscreen">
        </iframe>
    </div>

    <script src="./JS/slider.js"></script>
</body>

</html>