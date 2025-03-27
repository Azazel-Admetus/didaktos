<?php
require_once "../php/function.php";
//pegando o tipo de jogo pela url
if(isset($_GET['tipo'])){
    $tipo_jogo = $_GET['tipo'];
    $token = gerarToken($tipo_jogo);
    //armazenar o token no cookie com validade de 24h
    setcookie('id_jogo', $token, time() + 86400, '/');
    switch ($tipo_jogo){
        case 'quiz':
            header('Location:quiz.html');
            break;
        case 'vf':
            header('Location:verdadeirofalso.html');
            break;
        case 'objeto':
            header('Location:jogo_objeto.html');
            break;
        case 'animal':
            header('Location:jogo_animal.html');
            break;
        default:
            die("Erro ao redirecionar para página de criação do jogo. Tente novamente mais tarde. Se o erro persistir contate o suporte.");
    }
    exit();
}else{
    ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar jogos | DIDAKTOS</title>
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
                        <a href=""></a>
                    </li>
                    <li>
                        <a href="index.html">sair</a>
                    </li>
                </ul>
            </nav>
        </header>
        <section>
            <header>
                <h2>Crie seu jogo de forma totalmente <span>gratuita</span>!</h2>
                <p>Escolha o tipo de jogo e você será redirecionado para a página de criação desse jogo</p>
            </header>
            <form method="GET" action="criar_jogos.php">
                <label for="tipo">Escolha o tipo de jogo:</label>
                <select name="tipo" id="tipo">
                    <option value="quiz">Quiz</option>
                    <option value="vf">Verdadeiro ou Falso?</option>
                    <option value='objeto'>Qual objeto é esse?</option>
                    <option value="animal">Qual animal é esse?</option>
                </select>
                <button type="submit">Criar Jogo</button>
            </form>
        </section>

    </main>
    <?php
}
?>
</body>
</html>
