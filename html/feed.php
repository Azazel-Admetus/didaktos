<?php
require_once "../php/conn.php";
$status = 'concluído';
$jogos_feed = [];

$stmt_vf = $conn->query("SELECT token_jogo AS token, titulo, descricao, dificuldade, autor FROM vf_config");
$vf_jogos = $stmt_vf->fetchAll(PDO::FETCH_ASSOC);

$stmt_quiz= $conn->query("SELECT token_jogo AS token, titulo, descricao, dificuldade, autor FROM quiz_config");
$quiz_jogos = $stmt_quiz->fetchAll(PDO::FETCH_ASSOC);


$todos_jogos = array_merge($vf_jogos, $quiz_jogos);


foreach($todos_jogos as $jogo){
    $stmt_pin = $conn->prepare("SELECT pin FROM jogos WHERE token = :token AND status = 'concluído'");
    $stmt_pin->bindValue(':token', $jogo['token']);
    $stmt_pin->execute();
    $pin_result = $stmt_pin->fetch(PDO::FETCH_ASSOC);

    if($pin_result){
        $jogos_feed[] = array_merge($jogo, ['pin'=> $pin_result['pin']]);
    }

}

?>

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
        <section  class="feed">
            <?php if(empty($jogos_feed)): ?>
                <p class="sem-jogos">Nenhum jogo encontrado no momento.</p>
             <?php else: ?>
                <?php foreach($jogos_feed as $jogo):
                    $dificuldade = strtolower(trim($jogo['dificuldade']));
                    $classe_dificuldade = match($dificuldade){
                        'facil' => 'facil', 
                        'medio' => 'medio', 
                        'dificil' => 'dificil',
                        default => 'desconhecido'
                    };
                ?>
                    <a href="game.php?game=<?= htmlspecialchars($jogo['pin'])?>">
                        <div class="card" data-dificuldade="<?= htmlspecialchars(strtolower($jogo['dificuldade'])) ?>">
                            <header>
                                <img src="../img/" alt="imagem do jogo">
                            </header>
                            <section>
                                <h2 class="titulo"><?= htmlspecialchars($jogo['titulo']) ?></h2>
                                <p class="descricao"><?= htmlspecialchars($jogo['descricao']) ?></p>
                                <p class="autor">Autor: <?= htmlspecialchars($jogo['autor']) ?></p>
                            </section>
                        </div>
                    </a>
                <?php endforeach; ?>               
            <?php endif; ?>
        </section>
        <footer></footer>
    </main>
    <script src="../js/feed.js"></script>
</body>
</html>