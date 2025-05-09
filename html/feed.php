<?php
require_once "../php/conn.php";
$status = 'concluído';
$jogos_feed = [];
$stmt = $conn->prepare("SELECT token, pin FROM jogos WHERE status = :status");
$stmt->bindValue(':status', $status);
if($stmt->execute()){
    $tokens = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(empty($tokens)){
        echo "Conteúdo não encontrado. Tente novamente mais tarde ou contate o serviço de suporte ao cliente.";
        exit;
    }
    foreach ($tokens as $linha){
        $token = $linha['token'];
        $pin = $linha['pin'];
       
        $stmt2 = $conn->prepare("SELECT titulo, descricao, dificuldade, autor FROM vf_config WHERE token_jogo = :token");
        $stmt2->bindValue(':token', $token);
        if($stmt2->execute()){
            $jogos = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($jogos as $jogo){
                $jogos_feed[] = [
                    'titulo' => $jogo['titulo'],
                    'descricao' => $jogo['descricao'],
                    'dificuldade' => $jogo['dificuldade'],
                    'autor' => $jogo['autor']
                ];
            }
        }
    }
} else{
    echo "erro ao buscar dados.";
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
        <a href="game.html?game=<?= htmlspecialchars($pin)?>" class="feed">
            <?php foreach($jogos_feed as $jogo):
                $dificuldade = strtolower(trim($jogo['dificuldade']));
                $classe_dificuldade = match($dificuldade){
                    'facil' => 'facil', 
                    'medio' => 'medio', 
                    'dificil' => 'dificil',
                    default => 'desconhecido'
                };
            ?>
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
            <?php endforeach; ?>
        </section>
        <footer></footer>
    </main>
    <script src="../js/feed.js"></script>
</body>
</html>