<?php
require_once "conn.php";
// verificando se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email=$_POST['email'];
    $pass=$_POST['senha'];
    // verificando se os campos estão em branco
    if (!empty($email) && !empty($pass)){
        // verificando se o email existe no db
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        // verifica se o email foi encontrado
        if ($stmt->rowCount() > 0){
            $emailuser = $stmt->fetch(PDO::FETCH_ASSOC);
            // Compara a senha fornecida com a senha armazenada no db
            if (password_verify($pass, $emailuser['senha'])){
                echo "Login bem-sucedido";
                session_start();
                $_SESSION['email'] = $emailuser['email'];
                $_SESSION['user_id'] = $emailuser['id'];
                header('Location:../html/home.html');
                exit();
            } else{
                echo "Senha incorreta";
            }
        }else{
            echo "Email incorreto";
        }
    }else{
        echo "Por favor, preencha todos os campos";
    }
}
?>
