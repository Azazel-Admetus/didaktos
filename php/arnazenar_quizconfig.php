<?php 
require_once "conn.php";
session_start();
$userid = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT nome FROM users WHERE id = :userid");
$stmt->bindValue(':userid', $userid);
$stmt->execute();
$username = $stmt->fetch(PDO::FETCH_ASSOC)['nome'];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $token = $_COOKIE['id_jogo'];
    $titulo = $_POST['titulo'] ?? null;
    $descricao = $_POST['descricao'] ?? null;
    $dificuldade = $_POST['dificuldade'] ?? null;
    $publicar = $_POST['publicar'] ?? null;
    if(!empty($token) && !empty($titulo) && !empty($dificuldade) && !empty($publicar)){
        $stmt2 = $conn->prepare("INSERT INTO quiz_config (titulo, descricao, dificuldade, autor, token_jogo) VALUES (:title, :descricao, :dificuldade, :autor, :token)");
        $stmt2->bindValue(':title', $titulo);
        $stmt2->bindValue(':descricao', $descricao);
        $stmt2->bindValue(':dificuldade', $dificuldade);
        $stmt2->bindValue(':autor', $userid);
        $stmt2->bindValue(':token', $token);
        if($stmt2->execute()){
            header('Location:../html/quiz.configuracao.html?insert=true');
            exit;
        }else{
            header('Location: ../html/quiz.configuracao.html?insert=failed');
            exit;
        }
    }else{
        header('Location:../html/quiz.configuracao.html?empty=true');
        exit;
    }
    
}