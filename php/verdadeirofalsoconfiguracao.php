<?php
require_once "conn.php";
session_start();
$userid = $_SESSION['user_id'];
$stmt = $conn->prepare('SELECT nome FROM users WHERE id = :user_id ');
$stmt->bindValue(':user_id', $userid);
$stmt->execute();
$username = $stmt->fetch(PDO::FETCH_ASSOC)['nome'];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $dificuldade = $_POST['dificuldade'];
    $publicar = $_POST['publicar'];
    $token = $_COOKIE['id_jogo'] ?? null;
    if(!empty($titulo) && !empty($dificuldade) && !empty($publicar) && !empty($token)){
        $stmt= $conn->prepare('INSERT INTO vf_config (titulo, descricao, dificuldade, token_jogo, autor) VALUES (:titulo, :descricao, :dificuldade, :token_jogo, :autor)');
        $stmt->bindValue(':titulo',  $titulo);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':dificuldade', $dificuldade);
        $stmt->bindValue(':autor', $username);
        if($stmt->execute()){
            if($publicar == 'sim'){
                $stmt = $conn->prepare('UPDATE jogos SET status = concluido WHERE token = :token');
                $stmt->bindValue(':token', $token);
                $stmt->execute();
            };
            header('Location:../html/verdadeirofalsoconfiguracao.html?insert=True');
            exit;
        }else{
            header('Location:../html/verdadeirofalsoconfiguracao.html?error=insertfailed');
            exit;
        }

    }else{
        header('Location:../html/verdadeirofalsoconfiguracao.html?error=valuesempty');
        exit;
    }
    session_write_close();
    exit;
}
?>