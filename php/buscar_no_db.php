<?php
//referenciando o arquivo de conexão
require_once "conn.php";
session_start(); //iniciando a sessao para pegar o id
$id = $_SESSION['id'];
//buscar as info do jogo
$stmt = $conn->prepare('SELECT v.id, v.token, v.titulo, v.descricao, u.nome 
                        FROM verdadeirofalso v      
                        JOIN users u ON v.user_id = u.id 
                        WHERE v.token = ?');
$stmt->execute([$id]);
$jogo = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$jogo){
    header('Location:../html/jogo.php?erro=jogo+nao+encontrado');
    exit;
}
$id_info_jogo = $jogo['id']; //extrai o id do jogo para consultar a pergunta e resposta baseada nele
//buscar o conteúdo do jogo
$stmt_conteudo = $conn->prepare('SELECT pergunta, resposta 
                        FROM verdadeirofalsocontent 
                        WHERE verdadeirofalsoid = ?');
$stmt_conteudo->execute([$id_info_jogo]);
$jogo_conteudo = $stmt_conteudo->fetch(PDO::FETCH_ASSOC);
if (!$jogo_conteudo){
    header('Location:../html/jogo.php?error=conteudo+nao+encontrado');
    exit;
}

//separando as variáveis

//variaveis das informações do jogo
$usuario = $jogo['nome'];
$descricao = $jogo['descricao'];
$titulo = $jogo['titulo'];

//variaveis do conteudo do jogo
$pergunta = $jogo_conteudo['pergunta']; 
$resposta = $jogo_conteudo['resposta'];

return [
    'usuario' => $usuario,
    'descricao' => $descricao,
    'titulo' => $titulo,
    'pergunta' => $pergunta,
    'resposta' => $resposta,
];