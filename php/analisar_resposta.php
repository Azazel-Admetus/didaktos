<?php
//relacionando o arquivo de conexão
require_once 'conn.php';
// verificando se ja tem parametros na url 
if (isset($_GET['empty']) && $_GET['empty'] === "True"){
    echo "<p id='mensagemerro'>Jogo não encontrado</p>";
    exit;
}
//sequestrando a id da URL
$id = $_GET['id'] ?? null;
if ($id){
    //verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        //criando a variavel e atribuindo o value como valor
        $resposta = $_POST['resposta'];
        //verifica se o valor da variável está vazio
        if (!empty($resposta)){
            //select no db para pegar o valor da coluna resposta
            $stmt = $conn->prepare('SELECT resposta FROM verdadeirofalsocontent WHERE verdadeirofalsoid = ?');
            $stmt->execute([$id]);
            $resposta_correta = $stmt->fetch(PDO::FETCH_ASSOC);
            //verifica se retornou resultado da tabela
            if ($resposta_correta){
                //comparando a resposta para descobrir se estava certo
                if ($resposta == $resposta_correta['resposta']){
                    header('Location:../html/jogo.php?answer=True');
                    exit;
                }else{
                    header('Location:../html/jogo.php?answer=False');
                    exit;
                };
            }
        }
    };
}