<?php
//referenciando o arquivo de conexão
require_once "conn.php";

//vamos verificar esse id
$id = $_GET['id'] ?? NULL;
if ($id === null || !preg_match('/^[a-f0-9]{32}$/i', $id)){
    header('Location:../html/jogo.php?error=id+invalido');
    exit;
}
session_start();
$_SESSION['id'] = $id;

