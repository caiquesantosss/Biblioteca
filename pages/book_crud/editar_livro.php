<?php
include_once("../config.php");

// Verifica se o ID do livro foi passado pela URL
if (isset($_GET['id'])) {
    $livro_id = $_GET['id'];

    // Consulta SQL para obter as informações do livro pelo ID
    $sql = "SELECT livros.id_livro, livros.titulo, livros.autores, livros.preco, livros.capa, categoria.nome_categoria 
            FROM livros
            JOIN categoria ON livros.categoria_id = categoria.id_categoria
            WHERE livros.id_livro = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $livro_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o livro foi encontrado
    if ($result->num_rows > 0) {
        $livro = $result->fetch_assoc();
    } else {
        // Se o livro não foi encontrado, redireciona para a página de listagem
        header("Location: ../livros.php");
        exit();
    }

    $stmt->close();
} else {
    // Se o ID do livro não foi fornecido, redireciona para a página de listagem
    header("Location: ../livros.php");
    exit();
}

// Processar os dados do formulário quando o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aqui você deve realizar as atualizações no banco de dados com os dados do formulário

    // Exemplo de atualização do título do livro
    $novo_titulo = $_POST['novo_titulo'];
    if ($novo_titulo !== $livro['titulo']) {
        $atualizar_titulo_sql = "UPDATE livros SET titulo = ? WHERE id_livro = ?";
        $stmt_atualizar_titulo = $conn->prepare($atualizar_titulo_sql);
        $stmt_atualizar_titulo->bind_param("si", $novo_titulo, $livro_id);
        $stmt_atualizar_titulo->execute();
    }

    // Exemplo de atualização dos autores
    $novos_autores = $_POST['novos_autores'];
    if ($novos_autores !== $livro['autores']) {
        $atualizar_autores_sql = "UPDATE livros SET autores = ? WHERE id_livro = ?";
        $stmt_atualizar_autores = $conn->prepare($atualizar_autores_sql);
        $stmt_atualizar_autores->bind_param("si", $novos_autores, $livro_id);
        $stmt_atualizar_autores->execute();
    }

    // Exemplo de atualização do preço
    $novo_preco = $_POST['novo_preco'];
    if ($novo_preco !== $livro['preco']) {
        $atualizar_preco_sql = "UPDATE livros SET preco = ? WHERE id_livro = ?";
        $stmt_atualizar_preco = $conn->prepare($atualizar_preco_sql);
        $stmt_atualizar_preco->bind_param("di", $novo_preco, $livro_id);
        $stmt_atualizar_preco->execute();
    }

    // Exemplo de atualização da categoria
    $nova_categoria = $_POST['nova_categoria'];
    if ($nova_categoria !== $livro['nome_categoria']) {
        $atualizar_categoria_sql = "UPDATE livros SET categoria_id = (SELECT id_categoria FROM categoria WHERE nome_categoria = ?) WHERE id_livro = ?";
        $stmt_atualizar_categoria = $conn->prepare($atualizar_categoria_sql);
        $stmt_atualizar_categoria->bind_param("si", $nova_categoria, $livro_id);
        $stmt_atualizar_categoria->execute();
    }

    // Exemplo de atualização da foto
    if (!empty($_FILES['nova_foto']['name'])) {
        $nova_foto = $_FILES['nova_foto']['name'];
        $caminho_temporario = $_FILES['nova_foto']['tmp_name'];
        $caminho_destino = "../imgs/books/" . $nova_foto; // Ajuste o caminho conforme necessário

        move_uploaded_file($caminho_temporario, $caminho_destino);

        $atualizar_foto_sql = "UPDATE livros SET capa = ? WHERE id_livro = ?";
        $stmt_atualizar_foto = $conn->prepare($atualizar_foto_sql);
        $stmt_atualizar_foto->bind_param("si", $caminho_destino, $livro_id);
        $stmt_atualizar_foto->execute();
    }

    // Redireciona para a página de listagem após a atualização
    header("Location: ../livros.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro</title>
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
        .form-group input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .submit-btn {
            background-color: #474bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;

            align-items: center;
            justify-content: center;
        }

        .submit-btn:hover {
            background-color: #3d3fa5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="heading">Editar Livro</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="novo_titulo">Novo Título:</label>
                <input type="text" name="novo_titulo" value="<?php echo $livro['titulo']; ?>" required>
            </div>

            <div class="form-group">
                <label for="novos_autores">Novos Autores:</label>
                <input type="text" name="novos_autores" value="<?php echo $livro['autores']; ?>" required>
            </div>

            <div class="form-group">
                <label for="novo_preco">Novo Preço:</label>
                <input type="text" name="novo_preco" value="<?php echo $livro['preco']; ?>" required>
            </div>

            <div class="form-group">
                <label for="nova_categoria">Nova Categoria:</label>
                <input type="text" name="nova_categoria" value="<?php echo $livro['nome_categoria']; ?>" required>
            </div>

            <div class="form-group">
                <label for="nova_foto">Nova Foto:</label>
                <input type="file" name="nova_foto">
            </div>

            <input type="submit" class="submit-btn" value="Salvar Alterações">
        </form>
    </div>
</body>
</html>

