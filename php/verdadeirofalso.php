<?php
require_once "conn.php";
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //criando as variaveis
    $pergunta = $_POST['pergunta'];
    $resposta = $_POST['resposta'];
    //pegando o cookie
    $token = $_COOKIE['id_jogo'] ?? null;
    if(!empty($pergunta) && !empty($resposta) && !empty($token)){
        //inserindo no db
        $stmt = $conn->prepare('INSERT INTO vf_game (pergunta, resposta, token_jogo) VALUES (:pergunta, :resposta, :token_jogo)');
        $stmt->bindValue(':pergunta', $pergunta);
        $stmt->bindValue(':resposta', $resposta);
        $stmt->bindValue(':token_jogo', $token);
        if($stmt->execute()){
            header('Location:../html/verdadeirofalso.html?insert=True');
            exit;
        }else{
            header('Location:../html/verdadeirofalso.html?error=insertcontentfailed');
            exit;
        }
    }else{
        header('Location:../html/verdadeirofalso.html?error=valuesempty');
        exit;
    }
        
}

