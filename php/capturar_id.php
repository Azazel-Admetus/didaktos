<?php
//referenciando o arquivo de conexão
require_once "conn.php";

//vamos verificar esse id
function capturar_id(){
    $id = $_GET['id'] ?? NULL;
    if ($id === null || !preg_match('/^[a-f0-9]{32}$/i', $id)){
        header('Location: ../html/jogo.php?error=id_invalido');
        exit;
    } 
    return $id;
}
