<!-- <?php
require_once "../php/function.php";
//pegando o tipo de jogo pela url
if(isset($_GET['tipo'])){
    $tipo_jogo = $_GET['tipo'];
    $token = gerarToken($tipo_jogo);
    //armazenar o token no cookie com validade de 24h
    setcookie('id_jogo', $token, time() + 86400, '/', '', true, true);
    require_once "../php/conn.php";
    $pin = gerarPin();
    session_start();
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare('INSERT INTO jogos (token, pin, user_id) VALUES (:token, :pin, :user_id)');
    $stmt->bindValue(':pin', $pin);
    $stmt->bindValue(':token', $token);
    $stmt->bindValue(':user_id', $user_id);

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
    ?> -->
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
            <header id="cabecalho-section">
                <h2>Crie seu jogo de forma totalmente <span>gratuita</span>!</h2>
            </header>
            <section id="container">
                <form method="GET" action="criar_jogos.php">
                    <section>
                        <h3 class="texto">Escolha uma opção de jogo e clique em <span>Criar Jogo</span></h3>
                        <p class="texto" >Você será redirecionado para a página de criação desse jogo</p>
                    </section>
                    <label for="tipo" class="texto">Escolha o tipo de jogo:</label>
                    <select name="tipo" id="tipo">
                        <option value="quiz" class="texto">Quiz</option>
                        <option value="vf" class="texto">Verdadeiro ou Falso?</option>
                    <!-- <option value='objeto'>Qual objeto é esse?</option>
                    <option value="animal">Qual animal é esse?</option> -->
                    </select>
                    <button type="submit" class="texto">Criar Jogo</button>
                </form>
            </section>
          
        </section>

    </main>
    <?php
}
?>
</body>
</html>
