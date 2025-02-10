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
if ($id){
    $stmt=$conn->prepare("SELECT v.id, v.token, v.titulo, v.descricao, v.dificuldade, u.nome FROM verdadeirofalso v JOIN users u ON v.user_id=u.id WHERE v.token = ?");
    $stmt->execute([$id]);

    $jogo =$stmt->fetch(PDO::FETCH_ASSOC);
    if (!$jogo){//atribuindo os valores às variaveis
        $token = $jogo['token'];
        $titulo = $jogo['titulo'];
        $descricao = $jogo['descricao'];
        $dificuldade = $jogo['dificuldade'];
        $user = $jogo['nome'];
        $id_jogo_info = $jogo['id'];
        // buscando agora as informações da tabela do conteúdo do jogo
        $stmt_content = $conn->prepare('SELECT pergunta FROM verdadeirofalsocontent WHERE verdadeirofalsoid = ?');
        $stmt_content->execute([$id_jogo_info]);// passando o id como parâmetro no where
        $content = $stmt_content->fetch(PDO::FETCH_ASSOC);
        //verificando se a consulta deu certo, atribuiremos variáveis e iremos inserir o conteúdo html
        if ($content){
            $quest = $content['pergunta'];
            //inserindo o html
            echo "
                <section id='secaoJogo'>
                    <section id='jogo'>
                         <h2 id='titulo'>$titulo</h2>
                        <header>
                            <h3 id='afirmacao'>$quest</h3>
                        </header>
                        <section id='sectionBotoes'>
                            <button type='submit' name='resposta' id='verdadeiro' value='verdadeiro'>VERDADEIRO</button>
                            <button type='submit' name='resposta' id='falso' value='falso'>FALSO</button>
                        </section>
                    </section>
                    <section id='informacaoDoJogo'>
                        <h4 id='autor'>$autor</h4>
                        <p id='descricao'>$descricao</p>
                    </section>
                </section>

            ";
        } else{
            echo "<p id='mensagemerro'>Conteúdo não encontrado</p>";
        };
    }
}else{
    header("Location: ../html/jogo.php?error=id_invalido");
    exit;
};

// agora vamos verificar a resposta do user
