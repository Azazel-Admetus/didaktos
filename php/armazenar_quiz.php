<?php
session_start();
require_once "../php/conn.php";
if(!isset($_COOKIE['id_jogo'])){
    die("Nenhum token encontrado");
}
$id_jogo =$_COOKIE['id_jogo'];
$pergunta = $_POST['pergunta'];
$alternativa1= $_POST['alternativa1'];
$alternativa2 = $_POST['alternativa2'];
$alternativa3 = $_POST['alternativa3'];
$alternativa4 = $_POST['alternativa4'];
$resposta = $_POST['alternativas'];
echo $id_jogo, $pergunta, $alternativa1, $alternativa2, $alternativa3, $alternativa4, $resposta;
