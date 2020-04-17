<?php

///////////////////////////////////////////////////////////
////     ARQUIVO DE PESQUISA DE NOTAS E MATRICULAS     ////
//////////////////////////////////////////////////////////

session_start();
include_once("../conexao/config.php");
include_once("../conexao/conexao.php");
include_once("../../conexao/function.php");

if (!isset($_SESSION["id"])){
    header("location: ./loginUser.php");
}

$conexao = DBConecta();

// FUNÇÃO BUSCA NOTA DE ALUNOS E RETORNA LINHAS PARA SEREM MOSTRADAS NA TABELA
if (isset($_POST["idDisciplina"]) && isset($_POST["idTurma"]) && isset($_POST["data"])){
    $idDisciplina = ValidaString($_POST["idDisciplina"]);
    $idTurma = ValidaString($_POST["idTurma"]);
    $data = ValidaString($_POST["data"]);

    if ($idDisciplina && $idTurma && $data){
      $nomeDisciplina = BuscaRetornaResponse($conexao, "disciplina", "idDisciplina", $idDisciplina);

      $sql_code = "SELECT * FROM `avalhacao` WHERE `idDisciplina`= $idDisciplina AND `idTurma`= $idTurma AND`data`= '$data'";
      $results = mysqli_query($conexao, $sql_code);
      if (mysqli_num_rows($results)){
        while ($notas = mysqli_fetch_assoc($results)){
          $nomeAluno = BuscaRetornaResponse($conexao, "aluno", "idAluno", $notas["idAluno"]);
          $nomeCompleto = $nomeAluno["nome"]." ".$nomeAluno["sobrenome"];
          $dataNova = date("d/m/Y", strtotime($data));
  
          if ($notas["conceito"] == "Apto")
            echo "<tr><td>".$nomeCompleto."</td><td>".$nomeDisciplina["nome"]."</td><td>".$idTurma."</td><td>".$dataNova."</td><td><span class='label label-success'>".$notas["conceito"]."</span></td><td><a class='btn btn-danger' href='./controllers/removeMatriculasNotas.php?idAvalhacao=".$notas["idAvalhacao"]."'><i class='fa fa-trash'></i>Excluir</a></td></tr>";
          else
            echo "<tr><td>".$nomeCompleto."</td><td>".$nomeDisciplina["nome"]."</td><td>".$idTurma."</td><td>".$dataNova."</td><td><span class='label label-danger'>".$notas["conceito"]."</span></td><td><a class='btn btn-danger' href='./controllers/removeMatriculasNotas.php?idAvalhacao=".$notas["idAvalhacao"]."'><i class='fa fa-trash'></i>Excluir</a></td></tr>";
        }
      }
    }
}

// FUNÇÃO BUSCA MATRICULAS DE PROFESSORS AS TURMAS E DISCIPLINAS E RETORNA LINHAS
if (isset($_POST["idTurma"]) && isset($_POST["semestre"]) && isset($_POST["idDisciplina"]) && isset($_POST["ano"])){
  if (!empty($_POST["idTurma"]) && !empty($_POST["semestre"])){
    $idTurma = ValidaString($_POST["idTurma"]);
    $idDisciplina = ValidaString($_POST["idDisciplina"]);
    $semestre = ValidaString($_POST["semestre"]);
    $data = ValidaString($_POST["ano"]).".0".$semestre;

    if ($idTurma && $idDisciplina && $semestre){
      $sql_code = "SELECT * FROM `turma-professor` WHERE `idTurma`= $idTurma AND `dataMatricula`= '$data' AND `idDisciplina`=$idDisciplina";
      $results = mysqli_query($conexao, $sql_code);
  
      if ($results && mysqli_num_rows($results)){
        while ($matricula = mysqli_fetch_assoc($results)){
          //BUSCANDO NOME DO PROFESSOR
          $nomeProfessor = BuscaRetornaResponse($conexao, "professor", "idProfessor", $matricula["idProfessor"]);
          $nomeCompleto = $nomeProfessor["nome"]." ".$nomeProfessor["sobrenome"];
  
          //BUSCANDO NOME DA DISCIPLINA
          $nomeDisciplina = BuscaRetornaResponse($conexao, "disciplina", "idDisciplina", $idDisciplina);
          $idProfessor = $nomeProfessor["idProfessor"];
          //RETORNANDO LINHA
          echo "<tr><td>".$nomeCompleto."</td><td>".$idTurma."</td><td>".$nomeDisciplina["nome"]."</td><td>".$data."</td><td><a class='btn btn-danger' id='apaga' onclick='apagaRegistro($idTurma,$idProfessor, $data, $idDisciplina)'><i class='fa fa-trash'></i>Excluir</a></td></tr>";
        }
      }
    }
  }
}

// FUNÇÃO BUSCA MATRICULAS DE ALUNOS NAS TURMAS E RETORNA LINHAS PARA SEREM MOSTRADAS NA TABELA
if (isset($_POST["idTurma"]) && isset($_POST["semestre"]) && !isset($_POST["idDisciplina"]) && isset($_POST["ano"])){
  $idTurma = ValidaString($_POST["idTurma"]);
  $semestre = ValidaString($_POST["semestre"]);
  $data = ValidaString($_POST["ano"]).".0".$semestre;

  if ($idTurma && $semestre){
    $sql_code = "SELECT * FROM `turma-aluno` WHERE `idTurma`= $idTurma AND `dataMatricula`= '$data' ";
    $results = mysqli_query($conexao, $sql_code);
  
    if (mysqli_num_rows($results)){
      while ($matricula = mysqli_fetch_assoc($results)){
        $nomeAluno = BuscaRetornaResponse($conexao, "aluno", "idAluno", $matricula["idAluno"]);
        if ($nomeAluno){
          $nomeCompleto = $nomeAluno["nome"]." ".$nomeAluno["sobrenome"];
          $idAluno = $nomeAluno["idAluno"];
          echo "<tr><td>".$nomeCompleto."</td><td>".$idTurma."</td><td>".$data."</td><td><a class='btn btn-danger' id='apaga' onclick='apagaRegistro($idTurma,\"$idAluno\", $data)'><i class='fa fa-trash'></i>Excluir</a></td></tr>";
          }
      }
    }
  }
}

?>
