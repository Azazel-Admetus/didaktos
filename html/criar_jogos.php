<?php
require_once "../php/function.php";
//pegando o tipo de jogo pela url
if(isset($_GET['tipo'])){
    $tipo_jogo = $_GET['tipo'];
    $token = gerarToken($tipo_jogo);
    //armazenar o token no cookie com validade de 24h
    setcookie('id_jogo', $token, time() + 86400, '/');
    require_once "../php/conn.php";
    $stmt = $conn->prepare('INSERT INTO jogos (token) VALUES (:token)');
    $stmt->bindValue(':token', $token);

    switch ($tipo_jogo){
        case 'quiz':
            $stmt->execute();
            header('Location:quiz.html');
            break;
        case 'vf':
            $stmt->execute();
            header('Location:verdadeirofalso.html');
            break;
        case 'objeto':
            $stmt->execute();
            header('Location:jogo_objeto.html');
            break;
        case 'animal':
            $stmt->execute();
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
    <script src="https://kit.fontawesome.com/166d077dc6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/criar_jogos.css">
    <title>Criar jogos | DIDAKTOS</title>
</head>
<body>
    <main>
        <header id="cabecalho">
            <h1>DIDAKTOS</h1>
            <section id="secao">
              
                <div id="menu">
                    <a id="perfil" href=""></a>
                    <div class="menucontent" >
                        <h4>User</h4>
                        <!-- <a id="config" href="#"></a> -->
                        <a href="suporte.html">
                            <i class="fa-solid fa-circle-question fa-2x" title="Suporte ao cliente para tirar dúvidas ou solucionar problemas."></i>
                        </a>
                        <a id="sair" href="index.html" title="Deslogar"></a>
                        
                    </div>
                </div>
            </section>
        </header>
     
        <section id="secao-main">
            <header>
                <!-- <h2>Crie seu jogo de forma totalmente <span>gratuita</span>!</h2> -->
                <p>Escolha o tipo de jogo e você será redirecionado para a página de criação desse jogo</p>
            </header>
            <section>
                <section>
                    <h3>Escolha uma opção de jogo e clique em <span>Criar Jogo</span></h3>
                    <p>Você será redirecionado para a página de criação desse jogo</p>
                </section>
                    <form method="GET" action="criar_jogos.php">
                    <label for="tipo">Escolha o tipo de jogo:</label>
                    <select name="tipo" id="tipo">
                        <option value="quiz">Quiz</option>
                        <option value="vf">Verdadeiro ou Falso?</option>
                    <!-- <option value='objeto'>Qual objeto é esse?</option>
                    <option value="animal">Qual animal é esse?</option> -->
                    </select>
                    <button type="submit">Criar Jogo</button>
                </form>
            </section>
          
        </section>

    </main>
    <?php
}
?>
</body>
</html>
