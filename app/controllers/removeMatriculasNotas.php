<?php
//////////////////////////////////////////////////
////     PÁGINA REMOVE NOTAS E MATRICULAS     ////
//////////////////////////////////////////////////

session_start();
include_once("../conexao/config.php");
include_once("../conexao/conexao.php");
include_once("../../conexao/function.php");


if (!isset($_SESSION["id"])){
    header("location: ./loginUser.php");
}

$conexao = DBConecta();

// FUNÇÃO EXCLUI NOTA DE ALUNO
if (isset($_GET["idAvalhacao"])){
    $idAvalhacao = ValidaURL($_GET["idAvalhacao"]);
    $sql_code = "DELETE FROM `avalhacao` WHERE `idAvalhacao`= $idAvalhacao";
    $results = mysqli_query($conexao, $sql_code);
    if ($results){
        header("location: ../lancamentoDeNotas.php");
    }
    else{
        echo "<script><alert>ERRO AO APAGAR NOTA! VERIFIQUE SUA CONEXÃO OU TENTE MAIS TARDE!</alert></script>";
    }
}

// FUNÇÃO EXCLUI MATRICULA DE ALUNO
if (isset($_POST["idTurma"]) && isset($_POST["idAluno"]) && isset($_POST["semestre"])){
    $idTurma = ValidaString($_POST["idTurma"]);
    $idAluno = ValidaString($_POST["idAluno"]);
    $data = ValidaString($_POST["semestre"]);

    if ($idTurma && $idAluno && $data){
        $sql_code = "DELETE FROM `turma-aluno` WHERE `idTurma` = $idTurma AND `idAluno`= '$idAluno' AND `dataMatricula` = '$data'";
        $results = mysqli_query($conexao, $sql_code);
        if ($results){
          echo "<div class='alert alert-success alert-dismissable'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>Matricula removida com sucesso! Click no botão ATUALIZAR!</strong>
          </div>";
        }else{
          echo "<div class='alert alert-danger alert-dismissable'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>Erro ao remover o matricula! Verifique sua conexão ou tente mais tarde!</strong>
          </div>";
        }
    }
    else{
        echo "<div class='alert alert-danger alert-dismissable'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <strong>Erro ao remover o matricula! Verifique sua conexão ou tente mais tarde!</strong>
        </div>";
      }
    
}

// FUNÇÃO EXCLUI MATRICULA DE PROFESSOR AS TURMAS E DISCIPLINAS
if (isset($_POST["idTurma"]) && isset($_POST["idProfessor"]) && isset($_POST["semestre"]) && isset($_POST["idDisciplina"])){
    if (!empty($_POST["idTurma"])  && !empty($_POST["semestre"])){
        $idTurma = ValidaString($_POST["idTurma"]);
        $idProfessor = ValidaString($_POST["idProfessor"]);
        $data = ValidaString($_POST["semestre"]);
        $idDisciplina = ValidaString($_POST["idDisciplina"]);

        if ($idTurma && $idProfessor && $data && $idDisciplina){
            $sql_code = "DELETE FROM `turma-professor` WHERE `idTurma` = $idTurma AND `idProfessor`= $idProfessor AND `dataMatricula` = '$data' AND `idDisciplina` = $idDisciplina";
            $results = mysqli_query($conexao, $sql_code);
    
            if ($results){
                echo "<div class='alert alert-success alert-dismissable'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Matricula removida com sucesso! Click no botão ATUALIZAR!</strong>
                </div>";
            }
            else{
                echo "<div class='alert alert-danger alert-dismissable'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Erro ao remover o matricula! Verifique sua conexão ou tente mais tarde!</strong>
                </div>";
            }
        }
    }
}

?>
