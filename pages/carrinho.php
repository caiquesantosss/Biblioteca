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
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            width: 80%;
            margin: 20px auto;
        }

        h2 {
            text-align: center;
            color: #474bff;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            background-color: #f9f9f9;
        }

        th {
            background-color: #474bff;
            color: white;
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

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #474bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-btn:hover {
            background-color: #333;
        }

        .checkout-btn {
            margin-top: 20px;
            background-color: #474bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .checkout-btn:hover {
            background-color: #333;
        }

        .message {
            margin-top: 20px;
            font-size: 16px;
            color: #4caf50;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="home.php" class="back-btn">Voltar</a>

        <?php
            if (isset($_GET['compra_sucesso'])) {
                echo '<p class="message">Compra realizada com sucesso!</p>';
            } elseif (isset($_GET['coins_insuficientes'])) {
                echo '<p class="message" style="color: red;">Você não possui coins suficientes para realizar a compra.</p>';
            } elseif (isset($_GET['erro'])) {
                echo '<p class="message" style="color: red;">Erro ao processar a compra. Tente novamente.</p>';
            }
        ?>

        <h2>Carrinho do Usuário</h2>

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

        <button class="checkout-btn" onclick="processarCompra()">Finalizar Compra</button>
    </div>

    <script>
        function removeItem(idCarrinho) {
            var confirmation = confirm("Tem certeza que deseja remover este item?");
            if (confirmation) {
                window.location.href = "./src/remover-carrinho.php?id_carrinho=" + idCarrinho;
            }
        }

        function processarCompra() {
            var confirmation = confirm("Tem certeza que deseja realizar a compra?");
            if (confirmation) {
                window.location.href = "./src/finalizar.php";
            }
        }
    </script>
</body>
</html>
