<?php
require_once "../php/conn.php";
session_start();
$user_id = $_SESSION['user_id'];
$jogos_usuarios = [];

$stmt = $conn->prepare("
    SELECT j.pin, j.token, c.titulo, c.descricao
    FROM jogos j
    INNER JOIN vf_config c ON j.token = c.token_jogo
    WHERE j.user_id = :user_id

    UNION

    SELECT j.pin, j.token, q.titulo, q.descricao
    FROM jogos j
    INNER JOIN quiz_config q ON j.token = q.token_jogo
    WHERE j.user_id = :user_id

");
$stmt->bindValue(':user_id', $user_id);

if($stmt->execute()){
    $jogos_usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

}
$stmt2 = $conn->prepare("SELECT nome FROM users WHERE id = :id");
$stmt2->bindValue(':id', $user_id);
if($stmt2->execute()){
    $user = $stmt2->fetch(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/home.css?v=1.1">
    <title>DIDAKTOS | HOME </title>
</head>
<body>
    <main>
        <header id="cabecalho">
            <a href="home.php" id="link-logo">
                <h1>DIDAKTOS</h1>
            </a>
            <section id="secao">
                <a href="suporte.html">SUPORTE</a>
                <a href="feed.php">PROCURAR JOGOS</a>
                <a id="botao" href="criar_jogos.php">NOVO JOGO</a>
                <div id="menu">
                    <a id="perfil" href="config.html"></a>
                    <a id="sair" href="../php/logout.php"></a>
                </div>
            </section>
        </header>
        <section>
            <header>
                <h2 id="header-h2">Meus Jogos</h2>
            </header>
            <section class="feed">
                <?php foreach($jogos_usuarios as $jogo): ?>
                    <a href="game.php?game=<?= htmlspecialchars($jogo['pin'])?>">
                        <div class="card">
                            <header>
                                <img src="../img/" alt="imagem do jogo">
                            </header>
                            <section>
                                <h2 class="titulo"><?= htmlspecialchars($jogo['titulo']) ?></h2>
                                <p class="descricao"><?= htmlspecialchars($jogo['descricao']) ?></p>
                                <p class="autor">Token: <?= htmlspecialchars($jogo['token']) ?></p>
                            </section>
                        </div>
                    </a>
                <?php endforeach; ?>
            </section>
            <footer></footer>
        </section>
     

    </main>
</body>
</html>