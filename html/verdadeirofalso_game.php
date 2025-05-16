<?php
require_once "../php/conn.php";
$pin = $_GET['id'] ?? null;
//pegando o token no db

$stmt = $conn->prepare("SELECT token FROM jogos WHERE pin = :pin");
$stmt->bindValue(':pin', $pin);
if($stmt->execute()){
    $token = $stmt->fetch(PDO::FETCH_ASSOC);
    //pegando as configurações dos jogos
    $stmt2= $conn->prepare("SELECT titulo, descricao, dificuldade, autor FROM vf_config WHERE token_jogo = :token ");
    $stmt2->bindValue(':token', $token['token']);
    if($stmt2->execute()){
        $config = $stmt2->fetch(PDO::FETCH_ASSOC);
        $titulo = $config['titulo'];
        $descricao = $config['descricao'];
        $dificuldade = $config['dificuldade'];
        $autor = $config['autor'];
        //buscando o conteúdo do jogo
        $stmt3 = $conn->prepare("SELECT pergunta, resposta FROM vf_game WHERE token_jogo = :token");
        $stmt3->bindValue(':token', $token['token']);
        if($stmt3->execute()){
            $conteudo = $stmt3->fetchAll(PDO::FETCH_ASSOC);
            $conteudo_jogo = [];
            foreach($conteudo as $content){
                $conteudo_jogo[] = [
                    'titulo' => $titulo, 
                    'descricao' => $descricao, 
                    'dificuldade' => $dificuldade, 
                    'autor' => $autor, 
                    'pergunta' => $content['pergunta'], 
                    'resposta' => $content['resposta']
                ];
            }
        }else{
            die("Falha ao buscar o conteúdo do jogo");
        }

    }else{
        die("Falha ao buscar as configurações do jogo");
    }
}else{
    die('Falha ao encontrar token');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/verdadeirofalso_game.css">
    <title>Verdadeiro ou Falso?</title>
</head>
<body>
    <section id='content_jogo'>
        <p id='pergunta'></p>
        <button id="btn_verdadeiro">verdadeiro</button>
        <button id="btn_falso" >falso</button>
        <div id="temporizador">10</div>
    </section>
    <section id='config_jogo'></section>
    <script>
    document.addEventListener("DOMContentLoaded", () =>{
        const perguntas = <?php echo json_encode($conteudo_jogo); ?>;
        const perguntaElemento = document.querySelector("#pergunta");
        const botaoVerdadeiro = document.querySelector("#btn_verdadeiro");
        const botaoFalso = document.querySelector("#btn_falso");
        const configJogo = document.querySelector("#config_jogo");

        let indiceAtual = 0;
        let respostasUsuarios= [];
        let temporizador = null;
        let tempoPorPergunta = 10;

        if(perguntas.length > 0){
            const config = perguntas[0];
            configJogo.innerHTML = `
                <h2>${config.titulo}</h2>
                <p>${config.descricao}</p>
                <p>Dificuldade: ${config.dificuldade}</p>
                <p>Autor: ${config.autor}</p>
            `;
        }
        function mostrarPergunta() {
            if(indiceAtual >= perguntas.length){
                mostrarResultado();
                return;
            }
            let tempo = tempoPorPergunta;
            const temporizadorElemento = document.getElementById("temporizador");
            temporizadorElemento.textContent = tempo;



            perguntaElemento.textContent =  perguntas[indiceAtual].pergunta;

            botaoVerdadeiro.disabled =false;
            botaoFalso.disabled = false;

            botaoVerdadeiro.classList.remove("selecionado");
            botaoFalso.classList.remove("selecionado");
            if(temporizador) clearInterval(temporizador);
            temporizador = setInterval(() => {
                tempo --;
                temporizadorElemento.textContent = tempo;
                if(tempo <= 0){
                    clearInterval(temporizador);
                    if(!respostasUsuarios[indiceAtual]){
                        registrarResposta("sem resposta");
                    }
                    indiceAtual ++;
                    mostrarPergunta();
                }
            }, 1000);
            
        }
        function registrarResposta(respostaUsuario){
            const respostaCorreta = perguntas[indiceAtual].resposta.toLowerCase();
            const acertou = respostaUsuario === respostaCorreta;
            respostasUsuarios[indiceAtual] = {
                pergunta: perguntas[indiceAtual].pergunta, 
                respostaCorreta,
                respostaUsuario, 
                acertou
            };
            botaoVerdadeiro.disabled = true;
            botaoFalso.disabled  = true;
        }
        function aplicarEfeitoVisual(botao){
            botao.classList.add("selecionado");
            botaoVerdadeiro.disabled = true;
            botaoFalso.disabled = true;

            setTimeout(() =>{
                registrarResposta(botao === botaoVerdadeiro ? "verdadeiro" : "falso");
            }, 1000);
        }
        botaoVerdadeiro.addEventListener("click", () => aplicarEfeitoVisual(botaoVerdadeiro));
        botaoFalso.addEventListener("click", () => aplicarEfeitoVisual(botaoFalso));

        function mostrarResultado(){
            const corretas = respostasUsuarios.filter(r => r.acertou).length;
            const total = respostasUsuarios.length;

            document.getElementById("content_jogo").innerHTML = `
                <h2>Fim do jogo!</h2>
                <p>Você acertou ${corretas} de ${total} perguntas.</p>
            `;
        }
        mostrarPergunta();
    })

    </script>
</body>
</html>