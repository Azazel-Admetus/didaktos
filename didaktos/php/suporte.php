<?php
// inclui o arquivo de conexão
require_once "conn.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){ //verifica se formulário foi enviado
    //começando atribuindo as variáveis aos inputs
    $email = $_POST['email'];
    $nome = $_POST['nome'];
    $pergunta = $_POST['pergunta'];
    //verificando se os campos estão vazios
    if (!empty($email) && !empty($pergunta)){
        try{
            $stmt = $conn->prepare("INSERT INTO suporte (email, nome, pergunta) VALUES (:email, :nome, :pergunta)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':pergunta', $pergunta);
            if ($stmt->execute()){
                header("Location: ../html/suporte.html?sent=true");
                exit();
            }else{
                echo "Erro ao inserir informações: " . $stmt->errorInfo()[2];
            }
        }catch (PDOException $e){
            echo "Erro ao inserir informações: " . $e->getMessage();
        }
    }
}