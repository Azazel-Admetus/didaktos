<?php
require_once "conn.php";
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //criando as variaveis
    $pergunta = $_POST['pergunta'];
    $resposta = $_POST['resposta'];
    //pegando o cookie
    $token = $_COOKIE['id_jogo'] ?? null;
    if(!empty($pergunta) && !empty($resposta)){
        //inserindo no db
        $stmt = $conn->prepare('INSERT INTO jogos (token) VALUES (:token)');
        $stmt->bindValue(':token', $token);
        if($stmt->execute()){
            header('Location:../html/verdadeirofalso.html?quest=salvada');
            exit;
        }else{
            header('Location:../html/verdadeirofalso.html?quest=!salvada');
        }
        
    }

}