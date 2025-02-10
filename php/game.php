<?php
// inclui o arquivo de conexão
require_once "conn.php";
// verificando se ja tem parametros na url 
if (isset($_GET['empty']) && $_GET['empty'] === "True"){
    echo "<p>Jogo não encontrado</p>";
    exit;
}
// hora de sequestrar o id da url
$id = $_GET['id'] ?? null;
echo $id;