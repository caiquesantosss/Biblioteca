<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados da Pesquisa</title>
</head>

<body>
    <?php
    session_start();

    if (!isset($_SESSION['user_id']) || $_SESSION['nivel'] !== 1) {

        header("Location: ../login.php");
        exit();
    }

    $userId = $_SESSION['user_id'];


    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
    echo "<script>console.log('Nome do Livro: " . $searchTerm . "');</script>";
    echo "<script>window.location.href = '../comprar-livro.php?titulo=" . urlencode($searchTerm) . "';</script>";
    ?>

    <!-- Conteúdo da página de resultados da pesquisa (isso não será exibido devido ao redirecionamento automático) -->
</body>

</html>