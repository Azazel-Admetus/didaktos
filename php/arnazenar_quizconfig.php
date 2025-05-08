<?php 
require_once "conn.php";
session_start();
$userid = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT nome FROM users WHERE id = :userid");
$stmt->bindValue(':userid', $userid);
$stmt->execute();
$username = $stmt->fetch(PDO:: FETCH_ASSOC)['nome'];
if($_SERVER['REQUEST_METHOD']){
    $token = $_COOKIE['id_jogo'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $dificuldade = $_POST['dificuldade'];
    $publicar = $_POST['publicar'];
    if(!empty($token) && !empty($titulo) && !empty($dificuldade) && !empty($publicar)){

    }
    
}