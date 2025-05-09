<?php
require_once "../php/conn.php";
session_start();
$user_id = $_SESSION['user_id'];
$jogos_usuarios = [];
$stmt = $conn->prepare("SELECT token, pin FROM jogos WHERE user_id = :user_id");
$stmt->bindValue(':user_id', $user_id);
if($stmt->execute()){
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($dados as $dado){
        $token = $dado['token'];
        $pin = $dado['pin'];
        $stmt2 = $conn->prepare("SELECT titulo, descricao FROM vf_config WHERE token_jogo = :token_jogo");
        $stmt2->bindValue(':token_jogo', $token);
        if($stmt2->execute()){
            $info = $stmt2->fetch(PDO::FETCH_ASSOC);
            if($info){
                $jogos_usuarios[] = [
                    'pin' => $pin,
                    'titulo' => $info['titulo'],
                    'descricao' => $info['descricao'],
                    'token' => $token
                ];
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/home.css">
    <title>DIDAKTOS | HOME </title>
</head>
<body>
    <main>
        <header id="cabecalho">
            <h1>DIDAKTOS</h1>
            <section id="secao">
                <a href="suporte.html">SUPORTE</a>
                <a href="feed.php">PROCURAR JOGOS</a>
                <a id="botao" href="criar_jogos.php">NOVO JOGO</a>
                <div id="menu">
                    <a id="perfil" href=""></a>
                    <div class="menucontent" >
                        <h4>User</h4>
                        <!-- <a id="config" href="config.html"></a> -->
                        <a id="sair" href="index.html"></a>
                    </div>
                </div>
            </section>
        </header>
        <section>
            <header>
                <h2>Meus Jogos</h2>
            </header>
            <section class="feed">
                <?php foreach($jogos_usuarios as $jogo): ?>
                    <a href="game.html?game=<?= htmlspecialchars($jogo['pin'])?>">
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