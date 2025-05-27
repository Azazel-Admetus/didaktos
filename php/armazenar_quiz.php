<?php
require_once "conn.php";
if($_SERVER['REQUEST_METHOD']){
    $pergunta = $_POST['pergunta'];
    $alternativa_1 = $_POST['alternativa1'];
    $alternativa_2 = $_POST['alternativa2'];
    $alternativa_3 = $_POST['alternativa3'];
    $alternativa_4 = $_POST['alternativa4'];
    $resposta_correta = $_POST['resposta'];
    $token  = $_COOKIE['id_jogo'] ?? null;
    if(!empty($pergunta)){
        $stmt = $conn->prepare("INSERT INTO quiz_game (pergunta, alt_A, alt_B, alt_C, alt_D, resposta, token_jogo) VALUES (:pergunta, :altA, :altB, :altC, :altD, :resposta, :token)");
        $stmt->bindValue(':pergunta', $pergunta);
        $stmt->bindValue(':altA', $alternativa_1);
        $stmt->bindValue(':altB', $alternativa_2);
        $stmt->bindValue(':altC', $alternativa_3);
        $stmt->bindValue(':altD', $alternativa_4);
        $stmt->bindValue(':resposta', $resposta_correta);
        $stmt->bindValue(':token', $token);
        if($stmt->execute()){
            header('Location:../html/quiz.html?insert=True');
            exit;
        }else{
            header('Location:../html/quiz.html?error=failed_insert');
            exit;
        }
    }else{
        header('Location:../html/quiz.html?error=emptyquest');
        exit;
    }
}else{
    header('Location:../html/quiz.html?error=naoenviado');
    exit;
}