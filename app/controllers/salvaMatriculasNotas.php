<?php

///////////////////////////////////////////////////////////
////        PÁGINA SALVA REGISTRO E RETORNA LINHA      ////
///////////////////////////////////////////////////////////

session_start();
include_once("../conexao/config.php");
include_once("../conexao/conexao.php");
include_once("../../conexao/function.php");


if (!isset($_SESSION["id"])){
    header("location: ./loginUser.php");
}

$conexao = DBConecta();

// FUNÇÃO SALVA A NOTA DO ALUNO E RETORNA A LINHA INSERIDA PARA SER MOSTRADA NA TABELA
if (isset($_POST["mensao"]) && isset($_POST["idAluno"]) && isset($_POST["idDisciplina"]) && isset($_POST["final"]) && isset($_POST["idTurma"]) && isset($_POST["nome"])){
    $idTurma = ValidaString($_POST["idTurma"]);
    $idDisciplina = ValidaString($_POST["idDisciplina"]);
    $idAluno = ValidaString($_POST["idAluno"]);
    $mensao = ValidaString($_POST["mensao"]);
    $final = ValidaString($_POST["final"]);
    $data = ValidaString($_POST["data"]);
    $nome = ValidaString($_POST["nome"]);

    if ($idTurma && $idDisciplina && $idAluno && $mensao && $data && $nome){
        $sql_code = "INSERT INTO `avalhacao`(`idDisciplina`, `idTurma`, `idAluno`, `nomeAvaliacao`, `conceito`, `final`, `data`) VALUES ($idDisciplina,$idTurma,'$idAluno', '$nome', '$mensao',$final, '$data')";
        $results = mysqli_query($conexao, $sql_code);

        if ($results){
            $sql_code = "SELECT `idAvalhacao` FROM `avalhacao` WHERE `idDisciplina` = $idDisciplina AND `idAluno` = '$idAluno' AND `data` = '$data'";
            $results = mysqli_query($conexao, $sql_code);
            $idAvalhacao = mysqli_fetch_assoc($results);
            $idAvaliacao = $idAvalhacao['idAvalhacao'];
            //  VERIFICA SE É A NOTA FINAL DA DISCIPLINA
            if ($final != "0"){
                $idAvaliacao = $idAvalhacao['idAvalhacao'];
                $sql_code = "INSERT INTO `aluno-disciplina`(`idAluno`, `idDisciplina`, `conceito`, `idAvalhacao`) VALUES ('$idAluno',$idDisciplina,'$mensao', $idAvaliacao)";
                $results = mysqli_query($conexao, $sql_code);
            }

            $nomeAluno = BuscaRetornaResponse($conexao, "aluno", "idAluno", $idAluno);
            $nomeDisciplina = BuscaRetornaResponse($conexao, "disciplina", "idDisciplina", $idDisciplina);
            $dataNova = date("d/m/Y", strtotime($data));
            $nomeCompleto = $nomeAluno["nome"]." ".$nomeAluno["sobrenome"];

            //  RETORNA LINHA DA TABELA COM INFORMAÇÕES
            if ($mensao == "Apto")
                echo "<tr><td>".$nomeCompleto."</td><td>".$nomeDisciplina["nome"]."</td><td>".$idTurma."</td><td>".$dataNova."</td><td><span class='label label-success text-uppercase'>".$mensao."</span></td><td><a class='btn btn-danger' href='./controllers/removeMatriculasNotas.php?idAvalhacao=".$idAvaliacao."'><i class='fa fa-trash'></i>Excluir</a></td></tr>";
            else
                echo "<tr><td>".$nomeCompleto."</td><td>".$nomeDisciplina["nome"]."</td><td>".$idTurma."</td><td>".$dataNova."</td><td><span class='label label-danger text-uppercase'>".$mensao."</span></td><td><a class='btn btn-danger' href='./controllers/removeMatriculasNotas.php?idAvalhacao=".$idAvaliacao."'><i class='fa fa-trash'></i>Excluir</a></td></tr>";
        }
    }
}

// FUNÇÃO SALVA A MATRICULA DO ALUNO E RETORNA A LINHA INSERIDA PARA MOSTRAR NA TABELA
if (isset($_POST["idTurma"]) && isset($_POST["idAluno"]) && !empty($_POST["semestre"]) && !empty($_POST["ano"])){
    $idTurma = ValidaString($_POST["idTurma"]);
    $idAluno = ValidaString($_POST["idAluno"]);
    $semestre = ValidaString($_POST["semestre"]);
    $data = $_POST["ano"].".0".$semestre;

    if ($idTurma && $idAluno && $data){
        $sql_code = "INSERT INTO `turma-aluno`(`idTurma`,`idAluno`, `dataMatricula`) VALUES ($idTurma,'$idAluno','$data')";
        $results = mysqli_query($conexao, $sql_code);
    
        if ($results){
            $nomeAluno = BuscaRetornaResponse($conexao, "aluno", "idAluno", $idAluno);
            $nomeCompleto = $nomeAluno["nome"]." ".$nomeAluno["sobrenome"];
            echo "<tr><td>".$nomeCompleto."</td><td>".$idTurma."</td><td>".$data."</td><td><a class='btn btn-danger' id='apaga' onclick='apagaRegistro($idTurma, \"$idAluno\", \"$data\")'><i class='fa fa-trash'></i>Excluir</a></td></tr>";
        }
    }
}

//FUNÇÃO SALVA MATRICULA DO PROFESSOR A TURMA E DISCIPLINA E RETORNE A LINHA INSERIDA PARA MOSTRAR NA TABELA
if (isset($_POST["idProfessor"]) && isset($_POST["idDisciplina"]) && isset($_POST["idTurma"]) && !empty($_POST["semestre"]) && !empty($_POST["ano"])){
    if (!empty($_POST["idTurma"]) && !empty($_POST["semestre"])){  
        $idProfessor = ValidaString($_POST["idProfessor"]);
        $idTurma = ValidaString($_POST["idTurma"]);
        $idDisciplina = ValidaString($_POST["idDisciplina"]);
        $semestre = ValidaString($_POST["semestre"]);
        $data = ValidaString($_POST["ano"]).".0".$semestre;

        if ($idProfessor && $idTurma && $idDisciplina && $data){
            $sql_code = "INSERT INTO `turma-professor` (`idDisciplina`, `idProfessor`, `idTurma`, `dataMatricula`) VALUES ($idDisciplina, $idProfessor, $idTurma, '$data')";
            $results = mysqli_query($conexao, $sql_code);
    
            if ($results){
                //BUSCA O NOME DO PROFESSOR INSERIDO
                $nomeAluno = BuscaRetornaResponse($conexao, "professor", "idProfessor", $idProfessor);
                $nomeCompleto = $nomeAluno["nome"]." ".$nomeAluno["sobrenome"];
    
                //BUSCA O NOME DA DISCIPLINA INSERIDA
                $nomeDisciplina = BuscaRetornaResponse($conexao,"disciplina", "idDisciplina", $idDisciplina);
    
                //RETORNE LINHA PARA SER EXIBIDA NA TABELA
                echo "<tr><td>".$nomeCompleto."</td><td>".$idTurma."</td><td>".$nomeDisciplina['nome']."</td><td>".$data."</td><td><a class='btn btn-danger' id='apaga' onclick='apagaRegistro($idTurma, $idProfessor, $data, $idDisciplina)'><i class='fa fa-trash'></i>Excluir</a></td></tr>";
            }
        }
    }   
}

?>
