<?php

////////////////////////////////////////////
////   BUSCA NOMES E ID DE USUÁRIOS    ////
///////////////////////////////////////////


include_once("../conexao/conexao.php");
include_once("../conexao/config.php");
include_once("../../conexao/function.php");

$conexao = DBConecta();

// METODO DE BUSCA: NOME COMPLETO
if(isset($_POST["tabela_ID"]) && isset($_POST["nome"])){
    $id = ValidaString($_POST["tabela_ID"]);
    switch ($id) {
        case '0':
            $tabela = "aluno";
            break;
        case '1':
            $tabela = "professor";
            break;
        case '2':
            $tabela = "turma";
            break;
        case '3':
            $tabela = "disciplina";
            break;
    }
    $buscaNome = ValidaString($_POST["nome"]);
    if (!empty($_POST["sobrenome"])) $buscaSobre = ValidaString($_POST["sobrenome"]);

    if ($buscaNome){
        //  CASO A TABELA ESCOLHIDA FOR ALUNO OU PROFESSOR
        if ($id < '2'){
            $sql_code = "SELECT * FROM $tabela WHERE nome='$buscaNome' AND sobrenome='$buscaSobre';";
            $sql = mysqli_query($conexao, $sql_code);
            $row = mysqli_fetch_assoc($sql);
            $cadastro = json_encode($row);
            echo $cadastro;
        }
        //  CASO A TABELA ESCOLHIDA FOR TURMA
        elseif($id == '2'){
            $response = BuscaRetornaResponse($conexao, $tabela, "idTurma", $buscaNome);
            $response ? $cadastro = json_encode($response) : $cadastro = null;
            echo $cadastro;
        }
        //  CASO A TABELA ESCOLHIDA FOR DISCIPLINA
        else{
            $response = BuscaRetornaResponse($conexao, $tabela, "nome", $buscaNome);
            $response ? $cadastro = json_encode($response) : $cadastro = null;
            echo $cadastro;
        }
    }
}


// METODO DE BUSCA: ID
if(isset($_POST["tabela_ID"]) && isset($_POST["id"])){
    $idUser = ValidaString($_POST["id"]);
    $id = ValidaString($_POST["tabela_ID"]);
    switch ($id) {
        case '0':
            $tabela = "aluno";
            $idTabela = "idAluno";
            break;
        case '1':
            $tabela = "professor";
            $idTabela = "idProfessor";
            break;
        case '2':
            $tabela = "turma";
            $idTabela = "idTurma";
            break;
        case '3':
            $tabela = "disciplina";
            $idTabela = "idDisciplina";
            break;
    }
    $response = BuscaRetornaResponse($conexao, $tabela, $idTabela, $idUser);
    $response ? $cadastro = json_encode($response) : $cadastro = null;
    echo $cadastro;
}

?>
