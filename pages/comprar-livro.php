<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    // Redirecionar para a página de login
    header("Location: login.php");
    exit();
}

if (isset($_GET['titulo'])) {
    $titulo = urldecode($_GET['titulo']);

    include_once("config.php");

    $sqlLivro = "SELECT * FROM livros WHERE titulo = ?";
    $stmtLivro = $conn->prepare($sqlLivro);
    $stmtLivro->bind_param("s", $titulo);
    $stmtLivro->execute();
    $resultLivro = $stmtLivro->get_result();

    // Verifica se o livro foi encontrado
    if ($resultLivro->num_rows > 0) {
        $livro = $resultLivro->fetch_assoc();

        $stmtLivro->close();

        $sqlCategoria = "SELECT * FROM categoria WHERE id_categoria = ?";
        $stmtCategoria = $conn->prepare($sqlCategoria);
        $stmtCategoria->bind_param("i", $livro['categoria_id']);
        $stmtCategoria->execute();
        $resultCategoria = $stmtCategoria->get_result();

        if ($resultCategoria->num_rows > 0) {
            $categoria = $resultCategoria->fetch_assoc();

            $stmtCategoria->close();
        } else {
            $categoria = array('nome_categoria' => 'Categoria Desconhecida');
        }

        $conn->close();
    } else {

        header("Location: home.php");
        exit();
    }
} else {

    header("Location: home.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra de Livro</title>
    <link rel="stylesheet" href="style-home.css">
    <style>
        * {
            font-family: "Raleway", sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            height: 20vh;
            background-color: #f5f5f5;
        }

        .back-button {
            position: absolute;
            top: 5%;
            left: 5%;
            transform: translate(-50%, -50%);

            padding: 5px;
            padding-inline: 20px;
            background-color: #474bff;
            color: white;
            border: none;

            border-radius: 5px;

            cursor: pointer;


        }
    </style>
</head>

<body>
    <div class="container-text-h2-details">
        <h2>Detalhes do Livro</h2>
    </div>
    <button class="back-button" onclick="goBack()">Voltar</button>

    <div class="container-info-book">
        <div class="container-info-main">
            <div class="container-info-img">
                <img src="<?php echo $livro['capa']; ?>" alt="Capa do Livro">
            </div>
            <div class="container-info-propiedades">
                <p>
                    <?php echo $livro['titulo']; ?>
                </p>
                <p>
                    <?php echo $livro['autores']; ?>
                </p>
                <p>C:
                    <?php echo $livro['preco']; ?>
                </p>
                <p>
                    <?php echo $categoria['nome_categoria']; ?>
                </p>

                <form action="./src/processar_compra.php" method="post">
                    <input type="hidden" name="livro_id" value="<?php echo $livro['id_livro']; ?>">
                    <button type="submit" class="buy-button" name="buy-the-books">Comprar Agora</button>
                </form>

                <form action="./src/processar_compra_carrinho.php" method="post">
                    <input type="hidden" name="livro_id" value="<?php echo $livro['id_livro']; ?>">
                    <button type="submit" class="buy-button-car" name="adicionar">Adicionar ao carrinho</button>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
     function goBack() {
            window.history.back();
        }
</script>
</html>
