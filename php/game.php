<?php
// inclui o arquivo de conexão
require_once "conn.php";
// verificando se ja tem parametros na url 
if (isset($_GET['empty']) && $_GET['empty'] === "True"){
    echo "<p id='mensagemerro'>Jogo não encontrado</p>";
    exit;
}
// hora de sequestrar o id da url
$id = $_GET['id'] ?? null;
//buscar as informações no db
if ($id  === null){
    header("Location: ../html/jogo.php?error=id_invalido");
    exit;
}
$stmt=$conn->prepare("SELECT v.id, v.token, v.titulo, v.descricao, v.dificuldade, u.nome FROM verdadeirofalso v JOIN users u ON v.user_id=u.id WHERE v.token = ?");
$stmt->execute([$id]);

$jogo =$stmt->fetch(PDO::FETCH_ASSOC);
if ($jogo){//atribuindo os valores às variaveis
    $token = $jogo['token'];
    $titulo = $jogo['titulo'];
    $descricao = $jogo['descricao'];
    $dificuldade = $jogo['dificuldade'];
    $user = $jogo['nome'];
    $id_jogo_info = $jogo['id'];
    // buscando agora as informações da tabela do conteúdo do jogo
    $stmt_content = $conn->prepare('SELECT pergunta, resposta FROM verdadeirofalsocontent WHERE verdadeirofalsoid = ?');
    $stmt_content->execute([$id_jogo_info]);// passando o id como parâmetro no where
    $content = $stmt_content->fetch(PDO::FETCH_ASSOC);
    //verificando se a consulta deu certo, atribuiremos variáveis e iremos inserir o conteúdo html
    if ($content){
        $quest = $content['pergunta'];
        $answer = $content['resposta'];
        //verificando a resposta
        //vericar se o formulário foi enviado 
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $resposta_user = $_POST['resposta'];
            //verifica se a resposta está vazia
            if (!empty($resposta_user)){
                //verificando se as respostas estão corretas
                if ($resposta_user ==  $answer){
                    if (!isset($_GET['answer'])){
                        header('Location: ../html/jogo.php?answer=True');
                        exit;
                    }
                }else{
                    if (!isset($_GET['answer'])){
                        header('Location: ..html/jogo.php?answer=False');
                        exit;
                    }
                }
            }
        }
        //inserindo o html
        echo "
            <form action='../php/game.php' method='POST'>
                <section id='secaoJogo'>
                    <section id='jogo'>
                        <h2 id='titulo'>$titulo</h2>
                        <header>
                            <h3 id='afirmacao'>$quest</h3>
                        </header>
                        <section id='sectionBotoes'>
                            <button type='submit' id='verdadeiro' name='resposta' value='verdadeiro'>VERDADEIRO</button>
                            <button type='submit' id='falso' name='resposta'  value='falso'>FALSO</button>
                        </section>
                    </section>
                    <section id='informacaoDoJogo'>
                        <h4 id='autor'>$user</h4>
                        <p id='descricao'>$descricao</p>
                    </section>
                </section>
            </form>

        ";
        if (isset($_GET['answer'])){
            $answer = $_GET['answer'];
            if ($answer == 'True'){
                echo "<p>Resposta Correta</p>";
            }elseif($answer == 'False'){
                echo "<p>Resposta errada</p>";
                
            }
        }
    } else{
        echo "<p id='mensagemerro'>Conteúdo não encontrado</p>";
    }
}else{
    header('Location:../html/jogo.php?error=id_invalido');
    exit;
}

