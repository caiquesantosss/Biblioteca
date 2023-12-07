<?php
        session_start();
        include_once("config.php");

        // Verifique se o usuário está logado
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }

        $user_id = $_SESSION['user_id'];

        // Consulta para obter os itens do carrinho do usuário
        $sql = "SELECT livros.id_livro, livros.titulo, livros.preco, carrinho_compras.id_carrinho
                FROM carrinho_compras
                JOIN livros ON carrinho_compras.id_livro = livros.id_livro
                WHERE carrinho_compras.id_usuario = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se há itens no carrinho
        if ($result && $result->num_rows > 0) {
            $itensCarrinho = $result->fetch_all(MYSQLI_ASSOC);

            // Calcula a soma total
            $somaTotal = array_sum(array_column($itensCarrinho, 'preco'));
        } else {
            $itensCarrinho = [];
            $somaTotal = 0;
        }

        $stmt->close();
        $conn->close();
    ?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho do Usuário</title>
    <style>
        body {
            font-family: "Raleway", sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .total {
            font-weight: bold;
        }

        .remove-btn {
            cursor: pointer;
            color: #e74c3c;
            background-color: transparent;
            border: none;
            padding: 5px;
            font-size: 14px;
            transition: color 0.3s;
        }

        .remove-btn:hover {
            color: #c0392b;
        }

        .title-table {
            text-align: center;
            color: #474bff;
        }

        a {
            position: absolute;
            top: 5%;
            left: 5%;
            transform: translate(-50%, -50%);

            background-color: #474bff;
            color: white;
            padding: 5px;
            border-radius: 5px;
            width: 100px;
            text-align: center;
        }

    </style>
</head>
<body>
    <h2 class="title-table">Carrinho do Usuário</h2>
    <a href="home.php">Voltar</a>

    <?php
        if (isset($_GET['compra_sucesso'])) {
            echo '<p style="color: green;">Compra realizada com sucesso!</p>';
        } elseif (isset($_GET['coins_insuficientes'])) {
            echo '<p style="color: red;">Você não possui coins suficientes para realizar a compra.</p>';
        } elseif (isset($_GET['erro'])) {
            echo '<p style="color: red;">Erro ao processar a compra. Tente novamente.</p>';
        }
    ?>
    
    <table>
        <tr>
            <th>Título</th>
            <th>Preço</th>
            <th>Remover</th>
        </tr>

        <?php foreach ($itensCarrinho as $item): ?>
            <tr>
                <td><?php echo $item['titulo']; ?></td>
                <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                <td>
                    <button class="remove-btn" onclick="removeItem(<?php echo $item['id_carrinho']; ?>, '<?php echo $item['titulo']; ?>')">
                        &#128465; Remover
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>

        <tr class="total">
            <td>Total</td>
            <td>R$ <?php echo number_format($somaTotal, 2, ',', '.'); ?></td>
            <td></td>
        </tr>
    </table>
    <button onclick="processarCompra()">Finalizar Compra</button>



    <script>
       function removeItem(idCarrinho) {
        var confirmation = confirm("Tem certeza que deseja remover este item?");
        if (confirmation) {
            // Redirecione para a página de remoção com o ID do carrinho
            window.location.href = "./src/remover-carrinho.php?id_carrinho=" + idCarrinho;
        }
    }

    function processarCompra() {
        var confirmation = confirm("Tem certeza que deseja realizar a compra?");
        if (confirmation) {
            window.location.href = "./src/processar_compra.php";
        }
    }

    
    </script>
</body>
</html>
