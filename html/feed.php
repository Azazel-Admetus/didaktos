<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/explorar.css">
    <title>DIDAKTOS | EXPLORAR JOGOS </title>
</head>
<body>
    <main>
        <header>
            <section>
                <h1>DIDAKTOS</h1>
            </section>
            <section>
                <nav id="config">
                    <ul>
                        <li>
                            <a id="user"  href="config.html" aria-label="acessar configurações de perfil do usuário" ></a>
                        </li>
                        <li>
                            <a id="exit" href="index.html" aria-label="saída / sair do site "></a>
                        </li>
                    </ul>
                </nav>
            </section>
        </header>
        <h2>Explore os jogos criados pelos Usuários </h2>
        <section class="feed">
            <?php
            //incluindo o arquivo php para gerar os cards 
            require_once "../php/explorar.php";
            ?>
        </section>
        <footer></footer>
    </main>
    <script src="../js/feed.js"></script>
</body>
</html>