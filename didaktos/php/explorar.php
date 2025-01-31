<?php
// inclui o arquivo de conexão
require_once "conn.php";
try{
    $stmt = $conn->prepare("SELECT titulo, descricao, dificuldade FROM verdadeirofalso");
    $stmt->execute();
    $jogos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode(($jogos));
} catch (PDOException $e){
    echo json_encode(["Erro" => "Erro aoa buscar jogos: " . $e->getMessage()]);
}