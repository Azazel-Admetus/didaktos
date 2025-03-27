<?php
// inclui o arquivo de conexão
require_once "conn.php";
// pegando no bd
// verificando se ja tem paramentros na url
if (isset($_GET['empty']) && $_GET['empty'] === 'True'){
    echo "<p>Não há jogos disponíveis!</p>";
    exit;  
}
$stmt = $conn->prepare("SELECT v.token, v.titulo, v.user_id, v.descricao, u.nome FROM verdadeirofalso v JOIN users u ON v.user_id = u.id ");
if ($stmt->execute()){ //verificando se rodo
    $found = false;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // atribuindo as variaveis
        $id = $row['token'];
        $titulo = $row['titulo'];
        $autor = $row['nome'];
        $description = $row['descricao'];
        // gerando o card
        if (!empty($id) && !empty($autor) && !empty($titulo)){
            $found = true;
            echo "
            <a class='link' href='jogo.php?id=$id'> 
                <div class='card'>
                        <img class='icone' src='../img/tfjogoicon.jpeg'>
                        <img class='icon' src='../img/iconegame.png'>
                        <h3 id='titulo'>$titulo</h3>
                        <h6 id='autor'>$autor</h6>
                        <p id='descricao'>$description</p>
                </div>
            </a>
            ";
        } 
    }
    if (!$found){
        header("Location:../html/feed.php?empty=True");
        exit;
    }
} else{
    header("Location:../html/feed.php?error=True");
    exit;
}
?>