<?php
// incluo o arquivo de conexão
require_once "conn.php";

// verificando se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // começando atribuindo as variáveis aos inputs 

    $user = $_POST['username']; //Relaciono entre [] o name dos inputs
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); //uso criptografia para as senhas. Um tipo de criptografia que não dá para descriptografar
    //função !empty verifica se os campos não estão vazios
    if (!empty($user) && !empty($pass)){
        try{
            $stmt = $conn->prepare("INSERT INTO users (nome, email, senha) VALUES (:user, :email, :pass)");
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pass', $pass);
            if ($stmt->execute()){
                header("Location: ../html/home.html");
                exit();
            }else {
                echo "Erro ao cadastrar: " . $stmt->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo "Erro ao cadastrar: " . $e->getMessage();
        
        }
      
    }

}
?>
