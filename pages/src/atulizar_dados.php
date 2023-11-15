<?php 
include_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM usuario WHERE id_usuario = $id";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
    
        echo "<form method='post' action='processar.dados.php'>
                <input type='hidden' name='id' value='{$row['id_usuario']}'>
                Nome: <input type='text' name='nome' value='{$row['nome_usuario']}'><br>
                Email: <input type='text' name='email' value='{$row['email']}'><br>
                Senha: <input type='password' name='senha' value='{$row['senha']}'><br>
                Img: <input type='text' name='img' value='{$row['img_url']}'><br>
                Coins: <input type='text' name='coins' value='{$row['coins']}'><br>
                Nível: <input type='Number' name='level' value='{$row['nivel']}' max='1'><br>
                <input type='submit' value='Atualizar'>
              </form>";
    } else {
        echo "Registro não encontrado.";
    }
}

?>

