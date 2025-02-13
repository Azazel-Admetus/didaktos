<?php
//relacionando o arquivo de conexão
require_once 'conn.php';

$dados = include_once "buscar_no_db.php";
if (!isset($dados)){
    header('Location:../html/jogo.php?error=dados+invalidos');
    exit;
}
//separando os dados
$resposta_correta = $dados['resposta'];
//pegando os dados do formulário
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $resposta = $_POST['resposta'];
    // verifica se está vazio
    if (!empty($resposta)){
        //verificar se as resposta estão coerentes
        if ($resposta == $resposta_correta){
            header('Location:../html/jogo.php?answer=True');
            exit;
        }else{
            header('Location:../html/jogo.php?answer=False');
            exit;
        }
    }else{
        header('Location:../html/jogo.php?answer=empty');
        exit;
    }
}else{
    header('Location:../html/jogo.php?server=False');
    exit;
}
