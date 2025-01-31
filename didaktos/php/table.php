<?php
// inclui o arquivo de conexão com banco de dados
require_once "conn.php";

// criando as tables
try{
    $sql= "CREATE TABLE IF NOT EXISTS verdadeirofalsocontent(
    id INT AUTO_INCREMENT PRIMARY KEY,
    verdadeirofalsoid INT NOT NULL,
    pergunta TEXT NOT NULL,
    resposta VARCHAR(50) NOT NULL,
    data TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (verdadeirofalsoid) REFERENCES verdadeirofalso(id)
    )";

    $conn->exec($sql);
    echo "Tabela criada com sucesso";
}catch (PDOException $e){
    echo "Erro ao criar tabela: " . $e->getMessage();
}
?>

