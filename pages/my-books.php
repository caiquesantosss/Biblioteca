<?php
include_once("config.php");
session_start();

// Verifica se o usuário está autenticado
if (isset($_SESSION['user_id'])) {
    $id_usuario = $_SESSION['user_id'];

    // Consulta os livros comprados pelo usuário
    $sqlLivrosComprados = "
        SELECT livros.titulo, livros.autores, livros.capa
        FROM compras
        JOIN livros ON compras.id_livro = livros.id_livro
        WHERE compras.id_usuario = ?
    ";

    $stmtLivrosComprados = $conn->prepare($sqlLivrosComprados);
    $stmtLivrosComprados->bind_param("i", $id_usuario);
    $stmtLivrosComprados->execute();
    $resultLivrosComprados = $stmtLivrosComprados->get_result();
    ?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Meus Livros Comprados</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }

            header {
                background-color: #474bff;
                color: white;
                text-align: center;
                padding: 10px;
            }

            main {
                max-width: 800px;
                margin: 20px auto;
                padding: 20px;
                background-color: white;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            p {
                margin: 10px 0;
            }

            img {
                max-width: 100%;
                height: auto;
                border: 1px solid #ddd;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .no-books {
                text-align: center;
                font-style: italic;
                color: #777;
            }

            .back-button {
                display: inline-block;
                background-color: #474bff;
                color: white;
                border: none;
                padding: 10px;
                margin-top: 20px;
                cursor: pointer;
                text-decoration: none;
                border-radius: 5px;
                font-size: 16px;
                transition: background-color 0.3s;
            }

            .back-button:hover {
                background-color: #333;
            }

            img {
                width: 147px;
                height: 200px;
            }

            .book-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .book {
                width: 30%;
                margin-bottom: 20px;
            }
        </style>
    </head>

    <body>
        <header>
            <h2>Meus Livros Comprados</h2>
        </header>

        <main>
            <div class="book-container">
                <?php
                $counter = 0;
                if ($resultLivrosComprados->num_rows > 0) {
                    while ($livroComprado = $resultLivrosComprados->fetch_assoc()) {
                        echo "<div class='book'>";
                        echo "<img src='" . $livroComprado['capa'] . "' alt='Capa do Livro'>";
                        echo "</div>";

                        $counter++;
                        if ($counter % 3 == 0) {
                            echo '<div style="width: 100%; clear: both;"></div>'; // Limpa a linha após cada conjunto de três livros
                        }
                    }
                } else {
                    echo "<p class='no-books'>Você ainda não comprou nenhum livro.</p>";
                }
                ?>
            </div>
            <a href="javascript:history.go(-1)" class="back-button">Voltar</a>
        </main>
    </body>

    </html>

    <?php
    $stmtLivrosComprados->close();
} else {
    echo "Usuário não está autenticado.";
}
?>
