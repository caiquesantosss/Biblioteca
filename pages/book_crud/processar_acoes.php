<?php
include_once("../config.php");

// Inicializa as variáveis
$novo_titulo = $novos_autores = $novo_preco = $nova_categoria = $nova_foto = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os valores do formulário
    $novo_titulo = $_POST['novo_titulo'];
    $novos_autores = $_POST['novos_autores'];
    $novo_preco = $_POST['novo_preco'];
    $nova_foto = $_FILES['nova_foto']['name'];

    // Verifica se a categoria foi selecionada
    if (isset($_POST['nova_categoria'])) {
        $nova_categoria = $_POST['nova_categoria'];

        // Move o arquivo para o destino final
        if (!empty($nova_foto)) {
            $caminho_temporario = $_FILES['nova_foto']['tmp_name'];
            $caminho_destino = "../imgs/books/" . $nova_foto;

            // Verifica se o diretório de destino existe, se não, tenta criar
            if (!is_dir("../imgs/books/")) {
                mkdir("../imgs/books/", 0777, true);
            }

            // Move o arquivo para o destino final
            if (move_uploaded_file($caminho_temporario, $caminho_destino)) {
                // Insere os valores no banco de dados
                $sql = "INSERT INTO livros (titulo, autores, preco, categoria_id, capa) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssdss", $novo_titulo, $novos_autores, $novo_preco, $nova_categoria, $caminho_destino);

                if ($stmt->execute()) {
                    echo "Livro adicionado com sucesso!";
                } else {
                    echo "Erro ao adicionar livro: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Erro ao fazer o upload da foto. Verifique as permissões e a existência do diretório.";
            }
        } else {
            echo "Por favor, selecione uma foto.";
        }
    } else {
        echo "Por favor, selecione uma categoria.";
    }
}

// Buscar categorias do banco de dados
$categorias_result = $conn->query("SELECT id_categoria, nome_categoria FROM categoria");
$categorias = array();
while ($row = $categorias_result->fetch_assoc()) {
    $categorias[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Livro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            width: 60%;
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .heading {
            color: #333;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="file"],
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .submit-btn,
        .back-btn {
            background-color: #474bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }

        .submit-btn:hover,
        .back-btn:hover {
            background-color: #3d3fa5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="heading">Adicionar Livro</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="novo_titulo">Novo Título:</label>
                <input type="text" name="novo_titulo" value="<?php echo $novo_titulo; ?>" required>
            </div>

            <div class="form-group">
                <label for="novos_autores">Novos Autores:</label>
                <input type="text" name="novos_autores" value="<?php echo $novos_autores; ?>" required>
            </div>

            <div class="form-group">
                <label for="novo_preco">Novo Preço:</label>
                <input type="text" name="novo_preco" value="<?php echo $novo_preco; ?>" required>
            </div>

            <div class="form-group">
                <label for="nova_categoria">Nova Categoria:</label>
                <select name="nova_categoria" required>
                    <?php foreach ($categorias as $categoria) : ?>
                        <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['nome_categoria']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="nova_foto">Nova Foto:</label>
                <input type="file" name="nova_foto" accept="image/jpeg, image/jpg" required>
            </div>

            <input type="submit" class="submit-btn" value="Adicionar Livro">
            <a href="#" class="back-btn" onclick="history.back()">Voltar</a>
        </form>
    </div>
</body>
</html>
