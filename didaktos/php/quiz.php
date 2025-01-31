<?php
// inclui o arquivo de conexão
include_once "conn.php";
// verifica se o formulário foi enviado 
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // cria as variáveis relacionando com os inputs
    $pergunta = $_POST['pergunta'];
    $a = $_POST['alternativaA'];
    $b = $_POST['alternativaB'];
    $c = $_POST['alternativaC'];
    $d = $_POST['alternativaD'];
    $correta = $_POST['correta'];
    // verifica se o campo de pergunta não está vazio 
    if (!empty($pergunta)){
        try{
            // prepara os arquivos para inserir no banco de dados
            $stmt=$conn->prepare("INSERT INTO quiz (pergunta, alternativaA, alternativaB, alternativaC, alternativaD, correta) VALUES (:pergunta, :A, :B, :C, :D, :correta) ");
            $stmt->bindParam(':pergunta', $pergunta);
            $stmt->bindParam(':A', $a);
            $stmt->bindParam(':B', $b);
            $stmt->bindParam(':C', $c);
            $stmt->bindParam(':D', $d);
            $stmt->bindParam(':correta', $correta);
            if ($stmt->execute()){
                header("Location: ../html/quiz.html");
                exit();
            }else{
                echo "Erro ao inserir informaçõe: " . $stmt->errorInfo()[2];
            }
        }catch (PDOException $e){
            echo "Erro ao inserir informações: " . $e->getMessage();
        }
        }
      
}