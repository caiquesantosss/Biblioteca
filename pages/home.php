<?php
session_start();
include_once("config.php");



$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$img = $_SESSION['imgUrl'];
$coins = $_SESSION['coins'];


$imagemPath = '../imgs/' . $img;
$nivelUsuario = $_SESSION['nivel'];


// O código serve apenas para mostrar os cinco "melhores" livros



if (!isset($_SESSION['livros'])) {
    $numerosAleatorios = array_rand(range(1, 15), 5);

    $_SESSION['livros'] = $numerosAleatorios;
} else {

    $numerosAleatorios = $_SESSION['livros'];
}

$capasLivros = [];
foreach ($numerosAleatorios as $idLivro) {
    $sql = "SELECT capa FROM livros WHERE id_livro = $idLivro";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $capasLivros[] = $row['capa'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['user_id'];
    $texto = $_POST['texto'];

    $sql = "INSERT INTO mensagens (usuario_id, texto) VALUES ('$usuario_id', '$texto')";

    if ($conn->query($sql) === TRUE) {
        // Redirecionar para evitar o reenvio do formulário ao recarregar a página
        header("Location: home.php");
        exit();
    } else {
        echo "Erro ao postar: " . $conn->error;
    }
}


function getCurrentImageUrl($conn, $user_id) {
    $sql = "SELECT img_url FROM usuario WHERE id_usuario = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['img_url'];
      
    } else {
        return '';
    }
}

$currentImageUrl = getCurrentImageUrl($conn, $user_id);

// Verifique se a URL da imagem atual é diferente da que está na sessão
if ($currentImageUrl != $_SESSION['imgUrl']) {
    $_SESSION['imgUrl'] = $currentImageUrl;
}
?>




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
            <a href="./whoweare.php">Quem nós somos?</a>
            <a href="./books.php">Livros</a>
            <a href="#categorias">Categorias</a>
            <a href="./comprar.php">Compre Coins</a>
        </nav>
    </header>

    <?php echo "<img src='$imagemPath' alt='Imagem do Usuário' class='user_img' id='openModalBtn' onclick='openModal()'>"; ?>
    <p class="coins">Seus coins:
        <?php echo $coins ?>
    </p>

    <div id="myModal" class="modal-container">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <?php
            echo "<img src='$imagemPath' alt='Imagem do Usuário' class='user-img-modal'> <br>";
            ?>

            <form action="../imgs/upload.php" method="post" enctype="multipart/form-data" class="form-img-sender">
                <input type="file" name="imagem" id="imageInput" style="display: none;">
                <label for="imageInput" id="customInputLabel">Escolher Imagem</label>
                <input type="submit" value="Enviar Imagem">
            </form>
        </div>
    </div>


    <div class="container-bar-search">
        <form>
            <?php

            $sql = "SELECT titulo FROM livros LIMIT 5";
            $query = $conn->query($sql);

            if ($query->num_rows > 0) {
                echo "<input type='search' id='search' name='search' list='datalist-options' class='search'
                    placeholder='Pesquise aqui!'>";

                echo "<datalist id='datalist-options'>";

                // Loop através dos resultados da consulta
                while ($row = $query->fetch_assoc()) {
                    // Exibir opção para cada resultado
                    echo "<option value='" . $row['titulo'] . "'>";
                }
                echo "</datalist>";
            } else {
                echo "Nenhum livro encontrado.";
            }


            ?>
        </form>
    </div>


    <div class="container-text-books-best-seller">
        <h2>Livros mais vendidos: </h2>
    </div>

    <div class="container-books-best-seller">
        <?php

        foreach ($capasLivros as $idLivro => $capaLivro) {
            echo "<img class='livro-capa' src='$capaLivro' alt='Capa do Livro $numerosAleatorios[$idLivro]'><br>";
        }

        ?>

        <div class="container-comments">
            <div class="container-text">
                <h2>Compartilhe com nossa <span>comunidade</span></h2>
                <h3>O que você está pensando?</h3>
            </div>

            <div class="container-inp-text">
                <form action="home.php" method="POST">
                    <input type="text" name="texto" id="message" placeholder="Digite algo..." autocomplete="off"
                        required>
                    <button class="send-button"><img src="../imgs/icons/aviao-de-papel.png" alt=""></button>
                </form>
            </div>

            <div class="container-messagens-box">

                <?php

                $sql = "SELECT mensagens.*, usuario.nome_usuario, usuario.img_url 
                        FROM mensagens 
                        JOIN usuario ON mensagens.usuario_id = usuario.id_usuario
                        ORDER BY mensagens.data_publicacao DESC";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='container-messages'>";
                        echo "<img src='" . $row['img_url'] . "' alt='" . $row['nome_usuario'] . "'>";
                        echo "<h3>" . $row['nome_usuario'] . "</h3><br>";
                        echo "<p>" . $row['texto'] . "</p>";
                        echo "</div> <br>";
                    }
                } else {
                    echo "Nenhuma postagem encontrada.";
                }
                ?>
            </div>
        </div>



        <button class="logout"><a href="./src/logout.php">Sair</a></button>
        <script>
            var modal = document.getElementById('myModal')
            var imagemModalTrigger = document.getElementById("openModalBtn")

            imagemModalTrigger.addEventListener('click', function () {
                // Exibe o modal
                modal.style.display = 'flex'
            })

            function closeModal() {
                // Esconde o modal
                modal.style.display = 'none'
            }
            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    closeModal()
                }
            })
        
            

        </script>
</body>

</html>