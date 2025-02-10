<?php
// inclui o arquivo de conexão
require_once "conn.php";
// inicia a sessão
session_start();
$user_id=$_SESSION['user_id']; //criando uma variável para a chave estrangeira
// verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $dificuldade = $_POST['dificuldade'];
    // verifica se o espaço está vazio
    if (!empty($titulo)){
        $token = bin2hex(random_bytes(16));
        $stmt = $conn->prepare( "INSERT INTO verdadeirofalso (titulo, descricao, dificuldade, user_id, token) VALUES (:titulo, :descricao, :dificuldade, :userid, :token)");
        $stmt->bindParam(":titulo", $titulo);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":userid", $user_id);
        $stmt->bindParam(":dificuldade", $dificuldade);
        $stmt->bindParam(":token", $token);
        if ($stmt->execute()){
            $verdadeirofalso_id =$conn->lastInsertId();
            $_SESSION['verdadeirofalso_id'] = $verdadeirofalso_id;
            header ("Location: ../html/truefalseconfig.html?save=True");
            exit();
        }else{
            echo "Erro ao tentar inserir informações " . $stmt->errorInfo()[2];

        }
    }
}
