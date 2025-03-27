<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/game.css">
    <title>DIDAKTOS | JOGOS</title>
</head>
<body>
    <header id="headerprimeiro">
        <section>
            <h1>DIDAKTOS</h1>
        </section>
        <section>
            <nav id="config">
                <ul>
                    <li>
                        <a href="../html/config.html" id="user" aria-label="acessar configurações do perfil do usuário "></a>                    
                    </li>
                    <li>
                        <a href="../html/index.html" id="exit" aria-label="sair do site / saídas"></a>
                    </li>
                </ul>
            </nav>
        </section>
    </header>
    <main>
        <h2>A AFIRMAÇÃO É VERDADEIRA OU FALSA?</h2> 
        <!-- <form action="../php/game.php" method="POST"> -->
        <?php
            require_once "../php/verdadeiro_falso_jogo.php";
        ?>
        <!-- </form> -->
    </main>

    <script src="../js/game.js"></script>
</body>
</html>