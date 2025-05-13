<?php
require_once "../php/conn.php";
$pin = $_GET['id'] ?? null;

if (!$pin) {
    die("PIN do jogo não especificado.");
}
$stmt = $conn->prepare("SELECT token FROM jogos WHERE pin = :pin");
$stmt->bindValue(':pin', $pin);
if($stmt->execute()){
    $token = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!$token) {
        die("Nenhum jogo encontrado com esse PIN.");
    }
    $stmt2 = $conn->prepare("SELECT titulo, descricao, dificuldade, autor FROM quiz_config  WHERE token_jogo = :token");
    $stmt2->bindValue(':token', $token['token']);
    $stmt2->execute();
    $config_dados = $stmt2->fetch(PDO::FETCH_ASSOC);
     if (!$config_dados) {
        die("Configuração do quiz não encontrada.");
    }

    $stmt3 = $conn->prepare('SELECT nome FROM users WHERE id= :id');
    $stmt3->bindValue(':id', $config_dados['autor']);
    $stmt3->execute();
    $autor = $stmt3->fetch(PDO::FETCH_ASSOC);
    $stmt4 = $conn->prepare("SELECT pergunta, alt_A, alt_B, alt_C, alt_D, resposta FROM quiz_game WHERE token_jogo = :token");
    $stmt4->bindValue(':token', $token['token']);
    $stmt4->execute();
    $game_content = $stmt4->fetchAll(PDO::FETCH_ASSOC);

    

}



?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
</head>
<body>
    <main>
        <h1 id="pergunta"></h1>
        <ul>
            <li id="altA"></li>
            <li id="altB"></li>
            <li id="altC" ></li>
            <li id="altD"></li>
        </ul>
    </main>
    <script>
        const perguntas = <?php echo json_encode($game_content, JSON_UNESCAPED_UNICODE); ?>;
    </script>
    <script>
        let index = 0;
        function mostrarPergunta(){
            if(index < perguntas.length){
                const  q = perguntas[index];
                document.getElementById("pergunta").textContent = q.pergunta;
                document.getElementById("altA").textContent = "A: " + q.alt_A;
                document.getElementById("altB").textContent = "B: " + q.alt_B;
                document.getElementById("altC").textContent = "C: " + q.alt_C;
                document.getElementById("altD").textContent = "D: " + q.alt_D;
                index++;
            }else{
                document.querySelector("main").innerHTML = "<h2>Quiz finalizado!</h2>";
            }
        }
        mostrarPergunta();
        setInterval(mostrarPergunta, 10000);
    </script>
</body>
</html>