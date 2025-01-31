<?php
// inclui o arquivo de conexão
require_once "conn.php";
// busca no bd
$stmt=$conn->prepare("SELECT titulo, token FROM verdadeirofalso");
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($resultados){
    foreach($resultados as $jogo){
        echo '<a href="../html/game.html?id=' . $jogo['token'] . '">' . $jogo['titulo'] . '</a><br>';
        exit();
    }
}else{
    echo '<p>Nenhum jogo disponível no momento.</p>';
}