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
    <title>Verdadeiro ou Falso?</title>
</head>
<body>
    <section id='content_jogo'>
        <p id='pergunta'></p>
        <button onclick="responder('verdadeiro')">verdadeiro</button>
        <button onclick="responder('falso')" >falso</button>
    </section>
    <section id='config_jogo'></section>
    <script>
    document.addEventListener("DOMContentLoaded", () =>{
        const perguntas = <?php echo json_encode($conteudo_jogo); ?>;
        const perguntaElemento = document.querySelector("#content_jogo p");
        const botaoVerdadeiro = document.querySelectorAll("#content_jogo button")[0];
        const botaoFalso = document.querySelectorAll("#content_jogo button")[1];
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
            perguntaElemento.textContent =  perguntas[indiceAtual].pergunta;

            botaoVerdadeiro.disabled =false;
            botaoFalso.disabled = false;

            botaoVerdadeiro.classList.remove("selecionado");
            botaoFalso.classList.remove("selecionado");
            
            temporizador = setTimeout(()=>{
                registrarResposta("sem resposta");
            }, tempoPorPergunta * 1000);
        }
        function registrarResposta(respostaUsuario){
            clearTimeout(temporizador);
            const respostaCorreta = perguntas[indiceAtual].resposta.toLowerCase();
            const acertou = respostaUsuario === respostaCorreta;
            respostaUsuario.push({
                pergunta: perguntas[indiceAtual].pergunta, 
                respostaCorreta,
                respostaUsuario, 
                acertou
            });
            indiceAtual++;
            mostrarPergunta();
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
            const corretas = respostaUsuario.filter(r => r.acertou).length;
            const total = respostaUsuario.length;

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