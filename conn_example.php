<?php
// criando as variáveis para poder acessar o banco de dados 
$host='localhost';
$user='root';
$pass='';
$db = 'didaktos';

try{
    // criando a variável de conexão
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // configurando para lançar exceções em caso de erro
    $conn-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    // mostra os erros 
    echo "Erro ao fazer conexão: " . $e->getMessage();
}
?>
