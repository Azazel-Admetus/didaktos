<?php
require_once "../php/conn.php";
$pin = $_GET['id'];
$stmt = $conn->prepare("SELECT token FROM jogos WHERE pin = :pin");
$stmt->bindValue(':pin', $pin);
if($stmt->execute()){
    $token = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt2 = $conn->prepare("SELECT titulo, descricao, dificuldade, autor FROM quiz_config  WHERE token_jogo = :token");
    $stmt2->bindValue(':token', $token['token']);
    $stmt2->execute();
    $config_dados = $stmt2->fetch(PDO::FETCH_ASSOC);
    $stmt3 = $conn->prepare('SELECT nome FROM users WHERE id= :id');
    $stmt3->bindValue(':id', $config_dados['autor']);
    $stmt3->execute();
    $autor = $stmt3->fetch(PDO::FETCH_ASSOC);
    $stmt4 = $conn->prepare("SELECT pergunta, alt_A, alt_B, alt_C, alt_D, resposta FROM quiz_game WHERE token_jogo = :token");
    $stmt4->bindValue(':token', $token['token']);
    $stmt4->execute();
    $game_content = $stmt4->fetch(PDO::FETCH_ASSOC);
    

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
    
</body>
</html>