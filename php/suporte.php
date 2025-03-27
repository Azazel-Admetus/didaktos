<?php
// inclui o arquico de conexão
require_once 'conn.php';
// inicia a sessão onde tem o user_id armazenado
session_start();
$user_id = $_SESSION['user_id'];//criando variável com a chave estrangeira
// verificando se o formulário foi enviado 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $nome = $_POST['nome'];
    $pergunta = $_POST['pergunta'];
    if (!empty($email) && !empty($nome) && !empty($pergunta)){
        $stmt=$conn->prepare("INSERT INTO suporte (nome, email, pergunta, user_id) VALUES (:nome, :email, :pergunta, :user_id)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pergunta', $pergunta );
        $stmt->bindParam(':user_id', $user_id);
        if($stmt->execute()){
            header("Location: ../html/suporte.html?sent=true");
            exit();
        }else{
            echo "Erro ao inserir informações " . $stmt->errorInfo()[2]; 
        }
    }
}