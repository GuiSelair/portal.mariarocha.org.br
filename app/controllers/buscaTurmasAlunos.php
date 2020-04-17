<?php

///////////////////////////////////////////////////////////////////
////   PÁGINA DE PESQUISA RETORNA PARA lançamentoDeNotas.php   ////
//////////////////////////////////////////////////////////////////

session_start();
include_once("../conexao/config.php");
include_once("../conexao/conexao.php");
include_once("../../conexao/function.php");


if (!isset($_SESSION["id"])){
    header("location: ./loginUser.php");
}

$conexao = DBConecta();

// FUNÇÃO BUSCA AS TURMAS QUE POSSUAM UMA DETERMINADA DISCIPLINA E PROFESSOR. RETORNE O NOME DA TURMA PARA SER EXIBIDO
if (isset($_POST["idDisciplina"]) && !isset($_POST["idTurma"])){
  $idDisciplina = ValidaString($_POST["idDisciplina"]);
  $idProfessor = $_SESSION["id"];
  echo "<option value=''>Selecione abaixo</option>";

  $sql_code = "SELECT DISTINCT `idTurma` FROM `turma-professor` WHERE `idDisciplina`= $idDisciplina AND `idProfessor` = $idProfessor";
  $results = mysqli_query($conexao, $sql_code);
  if (mysqli_num_rows($results)){
    while($idTurmas = mysqli_fetch_assoc($results)){
        echo "<option value='".$idTurmas["idTurma"]."'>".$idTurmas["idTurma"]."</option>";      
    }
  }    
}

//FUNÇÃO BUSCA ALUNOS DE UMA DETERMINADA TURMA. RETORNE O ID DO ALUNO E O NOME COMPLETO PARA SER EXIBIDO
if (isset($_POST["idTurma"]) && isset($_POST["idDisciplina"])){
  $idDisciplina = ValidaString($_POST["idDisciplina"]);
  $idTurma = ValidaString($_POST["idTurma"]);
  echo "<option value=''>Selecione abaixo</option>";

  if ($idDisciplina && $idTurma){
    // BUSCANDO ALUNOS DA TURMA SELECIONADA
    $query = BuscaRetornaQuery($conexao, "turma-aluno", "idTurma", $idTurma);
    if ($query){
      $prerequisito = VerificaPrerequisito($conexao, $idDisciplina);

      //  PERCORRE TODOS OS ALUNOS DA TURMA
      while($idAluno = mysqli_fetch_assoc($query)){
        if (VerificaStatusUsuarios($conexao, $idAluno["idAluno"], null)){
          //  EXISTE PREREQUISITO PARA A DISCIPLINA
          if($prerequisito){
            $conferePrerequisito = ConfereAprovacao($conexao, $prerequisito["prerequisito"], $idAluno["idAluno"]);
            if ($conferePrerequisito && $conferePrerequisito["conceitoDisciplina"] == "APTO"){
              $confereDisciplinaAtual = ConfereAprovacao($conexao, $idDisciplina, $idAluno["idAluno"]);
              if ($confereDisciplinaAtual && $confereDisciplinaAtual["conceitoDisciplina"] != "APTO"){
                $nomeAluno = BuscaRetornaResponse($conexao, "aluno", "idAluno", $idAluno["idAluno"]);
                echo "<option value='".$nomeAluno["idAluno"]."'>".$nomeAluno["idAluno"]." - ".$nomeAluno["nome"]." ".$nomeAluno["sobrenome"]."</option>";
              }
            }
          }
          // NÃO EXISTE PREREQUISITOS PARA A DISCIPLINA
          else{
            $confereDisciplinaAtual = ConfereAprovacao($conexao, $idDisciplina, $idAluno["idAluno"]);
            if ($confereDisciplinaAtual["conceitoDisciplina"] != "APTO"){
              $nomeAluno = BuscaRetornaResponse($conexao, "aluno", "idAluno", $idAluno["idAluno"]);
              echo "<option value='".$nomeAluno["idAluno"]."'>".$nomeAluno["idAluno"]." - ".$nomeAluno["nome"]." ".$nomeAluno["sobrenome"]."</option>";
            }
          }
        }
        
      }
    }
  }
}

?>

