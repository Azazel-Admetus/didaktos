<?php
session_start();
require_once "../php/conn.php";
if(!isset($_COOKIE['id_jogo'])){
    die("Nenhum token encontrado");
}
$id_jogo =$_COOKI['id_jogo'];
$pergunta = $_POST['pergunta'];
$alternativa1= $_POST['alternativa1'];
$alternativa2 = $_POST['alternativa2'];
$alternativa3 = $_POST['alternativa3'];
$alternativa4 = $_POST['alternativa4'];
$resposta = $_POST['']
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/quiz.css">
    <title>Criar Quiz - DIDAKTOS</title>
</head>
<body>
    <main>
        <header>
            <a href="home.html">
                <h1>DIDAKTOS</h1>
            </a>
            <nav>
                <ul>
                    <li>
                        <a href="config.html">Configurações</a>
                    </li>
                    <li>
                        <a href="index.html">sair</a>
                    </li>
                </ul>
            </nav>
        </header>
        <section>
            <form method='post'>
                <header>
                    <h2>Crie um quiz educativo</h2>
                </header>
                <label for="pergunta" >Pergunta</label>
                <input type="text" id="pergunta" name="pergunta" placeholder="Crie sua pergunta para o quiz" required>
                <label for="alternativa1">Alternativa A</label>
                <input type="text" id="alternativa1" name="alternativa1" placeholder="Defina uma possível resposta" required>
                <label for="alternativa2">Alternativa B</label>
                <input type="text" id="alternativa2" name="alternativa2" placeholder="Defina uma outra possível resposta" required>

                <label for="alternativa3" class="hidden">Alternativa C</label>
                <input type="text" id="alternativa3" name="alternativa3" class="hidden" placeholder="Defina uma outra possível resposta">
                <label for="alternativa4" class="hidden">Alternatica D</label>
                <input type="text" id="alternativa4" name="alternativa4" class="hidden" placeholder="Defina uma outra possível resposta">
                <label for="alternativa5" class="hidden">Alternativa E</label>
                <input type="text" id="alternativa5" name="alternativa5" class="hidden" placeholder="Defina uma outra possível resposta">
                <button type="button" id="mostrarAlt">Adicionar alternativa</button>
                
                <h3>Escolha a alternativa correta


                <button type="submit">Enviar</button>
            </form>
        </section>
    </main>
    <script>
        const botao = document.getElementById('mostrarAlt');
        const labels = [
            document.querySelector('label[for="alternativa3"]'),
            document.querySelector('label[for="alternativa4"]'),
            document.querySelector('label[for="alternativa5"]')
        ];
        const opcoes = [
            document.getElementById('alternativa3'), 
            document.getElementById('alternativa4'),
            document.getElementById('alternativa5')
        ];
        let mostrarAlternativa = 0;
        botao.addEventListener('click', () => {
            if (mostrarAlternativa < labels.length){
                labels[mostrarAlternativa].classList.remove('hidden');
                opcoes[mostrarAlternativa].classList.remove('hidden');
                mostrarAlternativa++;
            }else{
                botao.disabled= true;
                botao.textContent = 'Número máximo de alternativas alcançado';
            }
        })
    </script>
</body>
</html>