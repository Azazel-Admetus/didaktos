<?php
require_once "../php/conn.php";
require_once "../php/function.php";

$pin = $_GET['game'] ?? null;
$stmt = $conn->prepare("SELECT token FROM jogos WHERE pin = :pin");
$stmt->bindValue(':pin', $pin);
if($stmt->execute()){
    $token = $stmt->fetch(PDO::FETCH_ASSOC);
    $tipo = TipoToken($token['token']);
    switch($tipo){
        case 'quiz':
            header('Location:quiz_game.php?id=' . urlencode($pin));
            break;
        case 'verdadeiro ou falso':
            header('Location:verdadeirofalso_game.php?id=' . urlencode($pin));
            break;
        default:
            exit("Token desconhecido");
    }
}
?>