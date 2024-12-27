<?php
// inclui o arquivo de conexão com banco de dados
require_once "conn.php";

// criando as tables
try{
    $sql= "CREATE TABLE IF NOT EXISTS suporte(
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    nome VARCHAR(50) NOT NULL,
    pergunta TEXT NOT NULL,
    data TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (email))";

    $conn->exec($sql);
    echo "Tabela criada com sucesso";
}catch (PDOException $e){
    echo "Erro ao criar tabela: " . $e->getMessage();
}
?>

