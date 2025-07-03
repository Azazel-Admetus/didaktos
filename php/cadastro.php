<?php
// incluo o arquivo de conexão
require_once "conn.php";

// verificando se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // começando atribuindo as variáveis aos inputs 

    $user = trim($_POST['username']); //Relaciono entre [] o name dos inputs
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); //uso criptografia para as senhas. Um tipo de criptografia que não dá para descriptografar
    //função !empty verifica se os campos não estão vazios
    if (!empty($user) && !empty($pass)){
        $check = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $check->bindParam(":email", $email);
        $check->execute();
        if($check->rowCount){
            header("Location:../html/login.html?error=email_exists");
            exit();
        }
        try{
            $stmt = $conn->prepare("INSERT INTO users (nome, email, senha) VALUES (:user, :email, :pass)");
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pass', $pass);
            if ($stmt->execute()){
                header("Location: ../html/home.php");
                exit();
            }else {
                header("Location:../html/cadastro.html?error=fail");
                exit();
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            header("Location:../html/cadastro.html?error=empty");
            exit();
        
        }
      
    }

}
?>
