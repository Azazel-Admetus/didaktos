<?php
require_once "conn.php";
$dados  = require_once "buscar_no_db.php";
if (!isset($dados)){
    header('Location:../html/jogo.php?error=dados+invalidos');
    exit;
}
//separar as variáveis começando pelas info
$titulo = $dados['titulo'];
$descricao = $dados['descricao'];
$usuario = $dados['usuario'];
//separando agora a parte do conteudo 
$pergunta = $dados['pergunta'];
//inserindo no html
echo "
    <form action='../php/analisar_resposta.php' method='POST'>
        <section id='secaoJogo'>
            <section id='jogo'>
                <h2 id='titulo'>$titulo</h2>
                <header>
                    <h3 id='afirmacao'>$pergunta</h3>
                </header>
                <section id='sectionBotoes'>
                    <button type='submit' id='verdadeiro' name='resposta' value='verdadeiro'>VERDADEIRO</button>
                    <button type='submit' id='falso' name='resposta'  value='falso'>FALSO</button>
                </section>
            </section>
            <section id='informacaoDoJogo'>
                <h4 id='autor'>$usuario</h4>
                <p id='descricao'>$descricao</p>
            </section>
        </section>
    </form>

";