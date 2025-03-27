<?php
// inclui o arquivo de conexão com banco de dados
require_once "conn.php";

// criando as tables
try{
    $sql= "CREATE TABLE IF NOT EXISTS quiz(
    id INT PRIMARY KEY AUTO_INCREMENT,
    pergunta TEXT NOT NULL,
    resposta1 TEXT NOT NULL,  
    resposta2 TEXT NOT NULL, 
    resposta3 TEXT NOT NULL, 
    resposta4 TEXT NOT NULL,
    resposta_correta ENUM('a', 'b', 'c', 'd', 'e')
    )";

    $conn->exec($sql);
    echo "Tabela criada com sucesso";
}catch (PDOException $e){
    echo "Erro ao criar tabela: " . $e->getMessage();
}
?>

