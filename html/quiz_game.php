<?php
require_once "../php/conn.php";
$pin = $_GET['id'] ?? null;
if (!$pin) {
    die("PIN do jogo não especificado.");
}
$stmt = $conn->prepare("SELECT token FROM jogos WHERE pin = :pin");
$stmt->bindValue(':pin', $pin);
if($stmt->execute()){
    $token = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!$token) {
        die("Nenhum jogo encontrado com esse PIN.");
    }
    $stmt2 = $conn->prepare("SELECT titulo, descricao, dificuldade, autor FROM quiz_config  WHERE token_jogo = :token");
    $stmt2->bindValue(':token', $token['token']);
    if($stmt2->execute()){
        $config = $stmt2->fetch(PDO::FETCH_ASSOC);
        $titulo = $config['titulo'];
        $descricao = $config['descricao'];
        $dificuldade = $config['dificuldade'];
        $autor = $config['autor'];
        //pegando o nome do autor
        $stmt3 = $conn->prepare("SELECT nome FROM users WHERE id = :id");
        $stmt3->bindValue(':id', $autor);
        if($stmt3->execute()){
            $usernome = $stmt3->fetch(PDO::FETCH_ASSOC);
            $username = $usernome['nome'];
            //buscando o content do game
            $stmt4 = $conn->prepare("SELECT pergunta, alt_A, alt_B, alt_C, alt_D, resposta FROM quiz_game WHERE token_jogo = :token");
            $stmt4->bindValue(':token', $token['token']);
            if($stmt4->execute()){
                $conteudo = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                $conteudo_jogo = [];
                foreach($conteudo as $content){
                    $conteudo_jogo[] = [
                        'titulo' => $titulo, 
                        'descricao' => $descricao,
                        'dificuldade' => $dificuldade,
                        'autor' => $username,
                        'pergunta' => $content['pergunta'],
                        'altA' => $content['alt_A'],
                        'altB' => $content['alt_B'],
                        'altC' => $content['alt_C'],
                        'altD' => $content['alt_D'],
                        'resposta' => $content['resposta']
                    ];
                }
            }else{
                die("Falha ao buscar o conteudo");
            }

        }else{
            die("Falha ao buscar o nome do usuário");
        
        }
    }else{
        die('Falha ao buscar as configurações do jogo');
    }
}else{
    die("falha ao buscar o token");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/quiz-game.css">
    <title>Quiz</title>
</head>
<body>
    <header>
        <a href="home.php">
            <h1>DIDAKTOS</h1>
        </a>
    </header>
    <main>
        <section id='content_jogo'>
            <h3 id='pergunta'></h3>
            <div class="botoes-linha">
                <button id='A' class="botao"></button>
                <button id='B' class="botao"></button>
            </div>
            <div class="botoes-linha">
                <button id='C' class="botao"></button>
                <button id='D' class="botao"></button>
            </div>
       
            <div id='temporizador'>10</div>
        </section>
        <section id="config_jogo"></section>
    </main>
    <script>
    document.addEventListener("DOMContentLoaded", () =>{
        const perguntas = <?php echo json_encode($conteudo_jogo);?>;

        const perguntaElemento = document.getElementById("pergunta");
        const btnA = document.getElementById('A');
        const btnB = document.getElementById("B");
        const btnC = document.getElementById("C");
        const btnD = document.getElementById("D");
        const config_jogo = document.getElementById("config_jogo");
        const temporizadorElemento = document.getElementById("temporizador");

        let indiceAtual = 0;
        let respostasUsuarios = [];
        let escolhaUsuario = null;
        let temporizador = null;
        let tempoPorPergunta = 10;

        if(perguntas.length > 0){
            const config = perguntas[0];
            config_jogo.innerHTML = `
            <h2>${config.titulo}</h2>
            <p>${config.descricao}</p>
            <p>Dificuldade: ${config.dificuldade}</p>
            <p>Autor: ${config.autor}</p>
            `;
        }

        function mostrarPergunta(){
            escolhaUsuario = null;
            if(indiceAtual >= perguntas.length){
                if(temporizador) clearInterval(temporizador);
                mostrarResultado();
                return;
            }
            const perguntaAtual = perguntas[indiceAtual];
            let tempo = tempoPorPergunta;

            perguntaElemento.textContent = perguntaAtual.pergunta;
            btnA.textContent = "A. " + perguntaAtual.altA;
            btnB.textContent = "B. " + perguntaAtual.altB;
            btnC.textContent = "C. " + perguntaAtual.altC;
            btnD.textContent = "D. " + perguntaAtual.altD;

            [btnA, btnB, btnC, btnD].forEach(btn =>{
                btn.disabled = false;
                btn.classList.remove("selecionado");
            })
            
            temporizadorElemento.textContent = tempo;

            if(temporizador) clearInterval(temporizador);
            temporizador = setInterval(() =>{
                tempo --;
                temporizadorElemento.textContent = tempo;
                if(tempo <= 0){
                    clearInterval(temporizador);
                    registrarResposta(escolhaUsuario ? escolhaUsuario : "sem resposta");
                    if(indiceAtual + 1 >= perguntas.length){
                        indiceAtual ++;
                        mostrarResultado();
                    } else{
                        indiceAtual++;
                        mostrarPergunta();

                    }
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
            [btnA, btnB, btnC, btnD].forEach(btn => btn.disabled = true);
        }
        function aplicarEfeitoVisual(botao, letra){
            [btnA, btnB, btnC, btnD].forEach(btn => btn.classList.remove("selecionado"));
            botao.classList.add("selecionado");
            escolhaUsuario = letra;
        }
        btnA.addEventListener("click", () => aplicarEfeitoVisual(btnA, "A"));
        btnB.addEventListener("click", () => aplicarEfeitoVisual(btnB, "B"));
        btnC.addEventListener("click", () => aplicarEfeitoVisual(btnC, "C"));
        btnD.addEventListener("click", () => aplicarEfeitoVisual(btnD, "D"));

        function mostrarResultado() {
            const corretas = respostasUsuarios.filter(r => r.acertou).length;
            const total = respostasUsuarios.length;

            document.getElementById("content_jogo").innerHTML = `
                <h2 id = "fim">Fim do jogo!</h2>
                <p id = "acertos">Você acertou ${corretas} de ${total} perguntas.</p>
            `;
        }
        mostrarPergunta();
    });
    </script>
</body>
</html>