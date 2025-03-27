<?php
//aqui colocaremos todas as funções que utilizaremos
//essa será a função para criar um token para os jogos
function gerarToken($tipo){
    $id_unico = bin2hex(random_bytes(4));
    return $tipo . '_' .$id_unico;
}
//essa função vai identificar o tipo de token
function TipoToken($token){
    if(strpos($token, 'quiz_') === 0){
        return 'quiz';
    }elseif (strpos($token, 'vf_') === 0){
        return 'verdadeiro ou falso';
    }elseif(strpos($token, 'objeto_') === 0){
        return 'qual objeto é esse';
    }elseif(strpos($token, 'animal_') === 0){
        return 'qual animal é esse';
    }else{
        return 'desconhecido';
    }
}

//função para validar o formato do token
function validarToken($token){
    return preg_match('/^(quiz|vf|objeto|animal)_[a-f0-9]{8}$/', $token);

}