<?php
// inclui o arquivo de conexão
require_once "conn.php";
// inicia a sessão
session_start();
$user_id=$_SESSION['user_id'];//criando uma variável para a chave estrangeira
// verificando se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $pergunta = $_POST['afirmacao'];
    $resposta = $_POST['alternativa'];
    if (!empty($pergunta)){
        if (isset($_SESSION['verdadeirofalso_id'])){
            $verdadeirofalso_id = $_SESSION['verdadeirofalso_id'];
            $stmt = $conn->prepare("INSERT INTO verdadeirofalsocontent (pergunta, resposta, verdadeirofalsoid) VALUES (:pergunta, :resposta, :verdadeirofalsoid) ");
            $stmt->bindParam(":pergunta", $pergunta);
            $stmt->bindParam(":resposta", $resposta);
            $stmt->bindParam(":verdadeirofalsoid", $verdadeirofalso_id);
            if ($stmt->execute()){
                header("Location: ../html/truefalse.html?salvar=True");
                exit();
            }else{
                echo "Erro ao tentar inserir informações " . $stmt->errorInfo()[2];
            }

        }else{
            echo "não existe na sessão";
        }
    }else{
        echo "O campo está vazio";
    }
}