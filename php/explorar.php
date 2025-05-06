<?php
// inclui o arquivo de conexão
require_once "conn.php";
$stmt = $conn->prepare("SELECT token FROM jogos WHERE status= :status");
$status = 'concluído';
$stmt->bindValue(':status', $status);
if($stmt->execute()){
    $jogos = $stmt->fetchAll(PDO::FETCH_ASSOC);

}else{}
?>