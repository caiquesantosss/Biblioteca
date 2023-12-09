<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra de Coins</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            font-family: "Raleway", sans-serif;
        }

        .logo {
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

        .user-info {
            text-align: right;
        }

        .coins {
            font-size: 18px;
            margin: 0;
        }

        .coin-purchase {
            margin-top: 20px;
        }

        h1 {
            color: #474bff;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        button {
            background-color: #474bff;
            color: white;
            border: none;
            padding: 10px;
            margin: 10px 0;
            cursor: pointer;
            width: 48%;
        }

        button:hover {
            background-color: #333;
        }

        .back-button {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px;
            margin-top: 20px;
            cursor: pointer;
            width: 100%;
        }

        .back-button:hover {
            background-color: #555;
        }

        .content {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .section {
            margin-bottom: 20px;
        }

        .section h1 span {
            color: #474bff;
        }

        .section p {
            line-height: 1.5;
        }

        .section-small {
            text-align: center;
            margin-top: 20px;
        }

        small {
            font-size: 12px;
            color: #777;
        }

        @media (max-width: 600px) {
            button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <header class="logo">
        <h2>Livrosia</h2>
    </header>

    <main>
        <section class="user-info">
            <p class="coins">Seus coins:
                <?php 
                session_start();
                $coins = isset($_SESSION['coins']) ? $_SESSION['coins'] : 0;
                echo $coins; ?>
            </p>
        </section>

        <section class="coin-purchase">
            <h1>Compra de Coins</h1>
            <form action="./src/processar.php" method="post" class="form_button_coins">
                <button type="submit" name="comprar_coins" value="50">Comprar 50 coins</button>
                <button type="submit" name="comprar_coins" value="100">Comprar 100 coins</button>
                <button type="submit" name="comprar_coins" value="200">Comprar 200 coins</button>
                <button type="submit" name="comprar_coins" value="500">Comprar 500 coins</button>
                <button type="submit" name="comprar_coins" value="760">Comprar 760 coins</button>
                <button type="submit" name="comprar_coins" value="1000">Comprar 1000 coins</button>
            </form>
        </section>

        <button class="back-button" onclick="window.history.back()">Voltar</button>
    </main>

    <div class="content">
        <div class="section">
            <h1>Sobre os <span>Coins</span> no Site</h1>
            <p>
                Bem-vindo aos Coins! No nosso site, os Coins são uma moeda virtual que você pode usar para realizar
                diversas atividades, como comprar livros exclusivos, acessar conteúdo premium e muito mais.
                Explore um mundo de possibilidades enquanto acumula Coins em sua conta. Desfrute de benefícios exclusivos,
                incluindo acesso a eventos especiais, descontos em produtos e serviços e a oportunidade de participar de
                programas de fidelidade emocionantes.
            </p>
        </div>

        <div class="section">
            <h2>Como Funciona</h2>
            <p>
                Os Coins são adquiridos através de compras, mas lembre-se, esta é uma funcionalidade totalmente fictícia
                e destinada apenas a aprimorar a experiência de navegação no site. Não há transações reais envolvidas.
                Embora os Coins não tenham valor real, eles oferecem uma liberdade virtual para explorar o melhor que
                nosso site tem a oferecer. Use seus Coins com sabedoria e aproveite as vantagens exclusivas que eles
                proporcionam. Experimente a sensação de ter poder de compra virtual e acesse conteúdos especiais
                disponíveis apenas para usuários de Coins. Lembre-se, os Coins são uma criação fictícia para tornar sua
                experiência mais envolvente e divertida. Aprecie todas as possibilidades que os Coins trazem, e continue
                explorando nosso site com entusiasmo! Esta mensagem é apenas uma descrição fictícia para aprimorar a
                experiência do usuário. Não há transações reais envolvidas.
            </p>
        </div>

        <div class="section-small">
            <small>Esta compra é totalmente fictícia e não envolve transações financeiras reais.</small>
        </div>
    </div>
</body>

</html>
