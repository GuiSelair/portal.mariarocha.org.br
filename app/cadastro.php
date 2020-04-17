<?php

////////////////////////////////////////////////////
////   CADASTRO DE USUÁRIOS/TURMAS/DISCIPLINAS  ////
////////////////////////////////////////////////////

session_cache_expire(10);
session_start();

include_once("conexao/config.php");
include_once("conexao/conexao.php");
include_once("../conexao/function.php");


if (isset($_GET['deslogar'])) {
  session_destroy();
  header("location: ./loginUser.php");
}

if (!isset($_SESSION["id"])){
  header("location: ./loginUser.php");
}

$conexao = DBConecta();

//  EDITA CADASTROS
if (isset($_POST['edita'])){
  $id = $_GET['id'];
  switch ($id) {
    //  EDITA CADASTRO ALUNO
    case '0':
      $idUser = ValidaString($_POST["idAluno"]);
      $nome = ValidaString($_POST['nome']);
      $sobrenome = ValidaString($_POST['sobrenome']);
      $email = ValidaEmail($_POST['email']);
      $login = ValidaString($_POST['login']);
      $dataNascimento = ValidaString($_POST['dataNascimento']);
      $sexo = ValidaString($_POST['sexo']);
      $telefone = ValidaString($_POST["telefone"]);
      $status = ValidaString($_POST['status']);

      if ($nome && $sobrenome && $email && $login && $dataNascimento && $sexo && $telefone && $status){
        $sql_code = "UPDATE aluno SET nome = '$nome', sobrenome = '$sobrenome', dataNascimento = '$dataNascimento', email = '$email', sexo = '$sexo', login = '$login', telefone = $telefone, status = '$status' WHERE idAluno = '$idUser'";
        $execute_sql = mysqli_query($conexao, $sql_code);

        if (!$execute_sql) {
          echo "<div class='alert alert-danger alert-dismissable' style='margin-bottom: 0px;'>
              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
              <strong>Erro ao Salvar!</strong>
              </div>
              ";
        } else {
          echo "<div class='alert alert-success alert-dismissable my-0' style='margin-bottom: 0px;'>
              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
              <strong>Operação efetuada com sucesso!</strong>
              </div>
              ";
        }
      }
      else{
        echo "<div class='alert alert-warning alert-dismissable my-0 py-0' style='margin-bottom: 0px;'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <strong>Insira corretamente os dados pedidos!</strong>
        </div>
        ";

      }
      break;
    // EDITA CADASTRO PROFESSOR
    case '1':
      $idUser = ValidaInteiro($_POST["idProfessor"]);
      $nome = ValidaString($_POST['nome']);
      $sobrenome = ValidaString($_POST['sobrenome']);
      $email = ValidaEmail($_POST['email']);
      $login = ValidaString($_POST['login']);
      $sexo = ValidaString($_POST['sexo']);
      $telefone = ValidaString($_POST["telefone"]);
      $status = ValidaString($_POST['status']);

      if ($nome && $sobrenome && $email && $login && $sexo && $telefone && $status){
        $sql_code = "UPDATE professor SET nome = '$nome', sobrenome = '$sobrenome', email = '$email', sexo = '$sexo', login = '$login',telefone = '$telefone', status = '$status' WHERE idProfessor = $idUser";
        $execute_sql = mysqli_query($conexao, $sql_code);

        if (!$execute_sql) {
          echo "<div class='alert alert-danger alert-dismissable' style='margin-bottom: 0px;'>
              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
              <strong>Erro ao Salvar!</strong>
              </div>
              ";
        } else {
          echo "<div class='alert alert-success alert-dismissable' style='margin-bottom: 0px;'>
              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
              <strong>Operação efetuada com sucesso!</strong>
              </div>
              ";
        }
      }
      else{
        echo "<div class='alert alert-warning alert-dismissable my-0 py-0' style='margin-bottom: 0px;'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <strong>Insira corretamente os dados pedidos!</strong>
        </div>
        ";

      }
      break;
    //  EDITA CADASTRO TURMA
    case '2':
      $nomeTurma = ValidaString($_POST['idTurma']);
      $cursoTurma = ValidaString($_POST['idCurso']);

      if ($nomeTurma && $cursoTurma){
        $sql_code = "UPDATE turma SET idCurso = '$cursoTurma' WHERE idTurma = '$nomeTurma'";
        $execute_sql = mysqli_query($conexao, $sql_code);
        
        if (!$execute_sql) {
          echo "<div class='alert alert-danger alert-dismissable' style='margin-bottom: 0px;'>
              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
              <strong>Erro ao Salvar!</strong>
              </div>
              ";
        } else {
          echo "<div class='alert alert-success alert-dismissable' style='margin-bottom: 0px;'>
              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
              <strong>Operação efetuada com sucesso!</strong>
              </div>
              ";
        }
      }
      else{
        echo "<div class='alert alert-warning alert-dismissable my-0 py-0' style='margin-bottom: 0px;'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <strong>Insira corretamente os dados pedidos!</strong>
        </div>
        ";

      }
      break;
    //  EDITA CADASTRO DISCIPLINA
    case '3':
      $nomeDisc = ValidaString($_POST['nome']);
      $idDisc = ValidaString($_POST["idDisciplina"]);
      $DiscPre = empty($_POST["prerequisito"]) ? "" : ValidaString($_POST["prerequisito"]);
      $idCurso = ValidaString($_POST["idCurso"]);

      if ($nomeDisc && $idDisc && $DiscPre && $idCurso){
        if ($DiscPre != ""){
          $sql_code = "UPDATE disciplina SET nome = '$nomeDisc', prerequisito = $DiscPre, idCurso = $idCurso WHERE idDisciplina = $idDisc;";
        }else{
          $sql_code = "UPDATE disciplina SET nome = '$nomeDisc', idCurso = $idCurso WHERE idDisciplina = $idDisc;";
        }
        $execute_sql = mysqli_query($conexao, $sql_code);
        if (!$execute_sql) {
          echo "<div class='alert alert-danger alert-dismissable' style='margin-bottom: 0px;'>
              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
              <strong>Erro ao Salvar!</strong>
              </div>
              ";
        } else {
          echo "<div class='alert alert-success alert-dismissable' style='margin-bottom: 0px;'>
              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
              <strong>Operação efetuada com sucesso!</strong>
              </div>
              ";
        }
      }
      else{
        echo "<div class='alert alert-warning alert-dismissable my-0 py-0' style='margin-bottom: 0px;'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <strong>Insira corretamente os dados pedidos!</strong>
        </div>
        ";

      }
      break;
  }

}

//  SALVA NOVOS CADASTROS
if (isset($_POST['salva'])){
  
  $id = $_GET['id'];

  switch ($id) {
    case '0':
      $nome = ValidaString($_POST['nome']);
      $sobrenome = ValidaString($_POST['sobrenome']);
      $email = ValidaEmail($_POST['email']);
      $login = ValidaString($_POST['login']);
      $dataNascimento = ValidaString($_POST['dataNascimento']);
      $sexo = ValidaString($_POST['sexo']);
      $telefone = ValidaString($_POST["telefone"]);
      $idAluno = ValidaString($_POST["idAluno"]);
      $senha = substr($login,0,2).substr($dataNascimento,0,4);
      $cript = CriptografiaSenhas($senha);
      $status = ValidaString($_POST['status']);

      if ($idAluno && $nome && $sobrenome && $email && $login && $dataNascimento && $sexo && $telefone && $status){
        if (!VerificaExistencia($conexao, "idAluno", "aluno", "nome", $nome, "sobrenome", $sobrenome, "email", $email, "login", $login)){
          $sql_code = "INSERT INTO aluno (idAluno,nome, sobrenome, dataNascimento, email, sexo, login, telefone, senha, status) VALUES ('$idAluno','$nome','$sobrenome','$dataNascimento','$email','$sexo','$login', $telefone, '$cript', '$status')";
          $execute_sql = mysqli_query($conexao, $sql_code);

          if (!$execute_sql) {
            echo "<div class='alert alert-danger alert-dismissable' style='margin-bottom: 0px;'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Erro ao Salvar!</strong>
                </div>
                ";
          } else {
            echo "<div class='alert alert-success alert-dismissable my-0' style='margin-bottom: 0px;'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Operação efetuada com sucesso!</strong>
                </div>
                ";
          }
        }
        else{
          echo "<div class='alert alert-warning alert-dismissable my-0 py-0' style='margin-bottom: 0px;'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>Cadastro já existente!</strong>
          </div>
          ";

        }
      }
      else{
        echo "<div class='alert alert-warning alert-dismissable my-0 py-0' style='margin-bottom: 0px;'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <strong>Insira corretamente os dados pedidos!</strong>
        </div>
        ";

      }
      break;
    case '1':
      $nome = ValidaString($_POST['nome']);
      $sobrenome = ValidaString($_POST['sobrenome']);
      $email = ValidaEmail($_POST['email']);
      $login = ValidaString($_POST['login']);
      $sexo = ValidaString($_POST['sexo']);
      $telefone = ValidaString($_POST["telefone"]);
      $senha = substr($login,0,2).substr($email,0,4);
      $cript = CriptografiaSenhas($senha);
      $status = ValidaString($_POST['status']);

      if ($nome && $sobrenome && $email && $login && $sexo && $telefone && $status){
        if (!VerificaExistencia($conexao,"idProfessor", "professor", "nome", $nome, "sobrenome", $sobrenome, "email", $email, "login", $login)){
          $sql_code = "INSERT INTO professor (nome, sobrenome, email, sexo, telefone, login, senha, status) VALUES ('$nome','$sobrenome','$email','$sexo','$telefone','$login', '$cript', '$status')";
          $execute_sql = mysqli_query($conexao, $sql_code);

          if (!$execute_sql) {
            echo "<div class='alert alert-danger alert-dismissable' style='margin-bottom: 0px;'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Erro ao Salvar!</strong>
                </div>
                ";
          } else {
            echo "<div class='alert alert-success alert-dismissable' style='margin-bottom: 0px;'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Operação efetuada com sucesso!</strong>
                </div>
                ";
          }
        }
        else{
          echo "<div class='alert alert-warning alert-dismissable my-0 py-0' style='margin-bottom: 0px;'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>Cadastro já existente!</strong>
          </div>
          ";
        }
      }
      else{
        echo "<div class='alert alert-warning alert-dismissable my-0 py-0' style='margin-bottom: 0px;'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <strong>Insira corretamente os dados pedidos!</strong>
        </div>
        ";

      }
      break;
    case '2':
      $nomeTurma = ValidaString($_POST['idTurma']);
      $cursoTurma = ValidaString($_POST['idCurso']);

      if ($nomeTurma && $cursoTurma){
        if (!VerificaExistencia($conexao, "idTurma", "turma", "idTurma", $nomeTurma, "idCurso", $cursoTurma)){
          if ($nomeTurma != " "){
            $sql_code = "INSERT INTO turma (idTurma, idCurso) VALUES ('$nomeTurma','$cursoTurma')";
            $execute_sql = mysqli_query($conexao, $sql_code);
            if (!$execute_sql) {
              echo "<div class='alert alert-danger alert-dismissable' style='margin-bottom: 0px;'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                  <strong>Erro ao Salvar!</strong>
                  </div>
                  ";
            } else {
              echo "<div class='alert alert-success alert-dismissable' style='margin-bottom: 0px;'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                  <strong>Operação efetuada com sucesso!</strong>
                  </div>
                  ";
            }
          }else{
            echo "<div class='alert alert-warning alert-dismissable my-0 py-0' style='margin-bottom: 0px;'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Não é permitida a inserção de campos em branco. Preencha corretamente!</strong>
            </div>
            ";
          }
        }
        else{
          echo "<div class='alert alert-warning alert-dismissable my-0 py-0' style='margin-bottom: 0px;'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>Cadastro já existente!</strong>
          </div>
          ";
        }
      }
      else{
        echo "<div class='alert alert-warning alert-dismissable my-0 py-0' style='margin-bottom: 0px;'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <strong>Insira corretamente os dados pedidos!</strong>
        </div>
        ";

      }
      
      break;
    case '3':
      $nomeDisc = ValidaString($_POST['nome']);
      $idCurso = ValidaString($_POST["idCurso"]);
      $DiscPre = empty($_POST["prerequisito"]) ? "" : ValidaString($_POST["prerequisito"]);

      if ($nomeDisc && $idCurso && $DiscPre){
        $sql_code = "SELECT idDisciplina FROM disciplina WHERE nome = '$nomeDisc'";
        $results = mysqli_query($conexao, $sql_code);
        if ($results && !mysqli_num_rows($results)){
          if ($nomeDisc != " "){
            if ($DiscPre != ""){
              $sql_code = "INSERT INTO disciplina (nome, prerequisito, idCurso) VALUES ('$nomeDisc', $DiscPre, $idCurso)";
            }else{
              $sql_code = "INSERT INTO disciplina (nome, idCurso) VALUES ('$nomeDisc', $idCurso)";
            }
            $execute_sql = mysqli_query($conexao, $sql_code);
            if (!$execute_sql) {
              echo "<div class='alert alert-danger alert-dismissable' style='margin-bottom: 0px;'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                  <strong>Erro ao Salvar!</strong>
                  </div>
                  ";
            } else {
              echo "<div class='alert alert-success alert-dismissable' style='margin-bottom: 0px;'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                  <strong>Operação efetuada com sucesso!</strong>
                  </div>
                  ";
            }
          }else{
            echo "<div class='alert alert-warning alert-dismissable my-0 py-0' style='margin-bottom: 0px;'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Não é permitida a inserção de campos em branco. Preencha corretamente!</strong>
            </div>
            ";
          }
        }
        else{
          echo "<div class='alert alert-warning alert-dismissable my-0 py-0' style='margin-bottom: 0px;'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>Cadastro já existente!</strong>
          </div>
          ";
        }
      }else{
        echo "<div class='alert alert-warning alert-dismissable my-0 py-0' style='margin-bottom: 0px;'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <strong>Insira corretamente os dados pedidos!</strong>
        </div>
        ";

      }
      
      break;

  }

}

//  DEFINIÇÃO QUAL PÁGINA DE CADASTRO MOSTRAR
if (isset($_GET['id'])){
    $id = ValidaString($_GET['id']);

    switch ($id) {
        case '0':
            $tit = "ALUNO";
            break;
        case '1':
            $tit = "PROFESSOR";
            break;
        case '2':
            $tit = "TURMA";
            break;
        case '3':
            $tit = "DISCIPLINA";
            break;
        default:
            header("location: ./index.php");
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PLATAFORMA ONLINE - &nbsp; :::&nbsp; E.E.E.M. Profª Maria Rocha&nbsp; :::</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="../img/favicon.ico" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- IMPORTAÇÃO ADMINLTE -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <!-- CABEÇALHO -->
    <header class="main-header">
      <a href="index.php" class="logo">
      <span class="logo-mini"><img src="../img/Logo.png" alt="logo" width="30" height="30"></span>
      <span class="logo-lg"><img src="../img/Logo.png" alt="logo" width="25" height="25"> Maria Rocha</span>
      </a>

      <!-- MENU DISPOSITIVOS MÓVEIS -->
      <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <!-- NOTIFICAÇÕES E USUÁRIOS -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

            <!--IMPORTANDO O ARQUIVO DE NOTIFICAÇÕES-->
            <?php include_once("notificacoes.php") ?>

            <li class="dropdown user user-menu ">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user mx-5"></i>
                <span class="hidden-xs"><?php echo $_SESSION['nome']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-footer">
                  <div class="pull-left mx-5">
                    <a href="./redefineSenhaPortal.php" class="btn btn-default btn-flat">Alterar senha</a>
                  </div>
                  <div class="pull-right mx-5">
                    <a href="?deslogar" class="btn btn-default btn-flat">Sair</a>
                  </div>
                </li>
              </ul>
            </li>

            <!-- CADASTRO ADMINISTRADORES-->
            <li>
              <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- MENU LATERAL -->
    <aside class="main-sidebar">
      <section class="sidebar">
        <div class="user-panel">
          <div class="pull-left">
            <i class="fa fa-user fa-3x" style="color: white;"></i>
          </div>
          <div class="pull-left info ">
            <p><?php echo $_SESSION['nome']; ?></p>
            <a href="#">
              <i class="fa fa-circle text-success"> <?php echo $_SESSION['tipo']; ?></i>
            </a>
          </div>

        </div>

        <!-- OPÇÕES DE MENU PARA CADA TIPO DE USUÁRIO -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MENU</li>
          <li><a href="index.php"><i class="fa fa-home"></i> <span class="text-uppercase">Inicio</span></a></li>

          <!-- OPÇÕES APENAS DE ADMINISTRADORES -->
          <?php if ($_SESSION['tipo'] == "Administrador"){ ?>
            <li><a href="addcalendario.php"><i class="fa fa-calendar"></i> <span class="text-uppercase">Adicionar Calendario</span></a></li>
            <li class="treeview active">
              <a href="#"><i class="fa fa-plus-square"></i> <span class="text-uppercase">Cadastros</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu text-center">
                <li <?php if ($id == "0") echo "class='active'" ?>><a href="cadastro.php?id=0" class="text-uppercase">Aluno</a></li>
                <li <?php if ($id == "1") echo "class='active'" ?>><a href="cadastro.php?id=1" class="text-uppercase">Professor</a></li>
                <li <?php if ($id == "2") echo "class='active'" ?>><a href="cadastro.php?id=2" class="text-uppercase">Turma</a></li>
                <li <?php if ($id == "3") echo "class='active'" ?>><a href="cadastro.php?id=3"class="text-uppercase">Disciplina</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-id-badge"></i><span class="text-uppercase">Matricula</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu text-center">
                <li><a href="matricula.php?id=0" class="text-uppercase">Aluno na turma</a></li>
                <li><a href="matricula.php?id=1" class="text-uppercase">Professor para disciplina</a></li>
              </ul>
            </li>
          <?php } ?>
        </ul>
      </section>
    </aside>

    <!--ÁREA DE CONTEÚDO-->
    <div class="content-wrapper">
      <div id="status"></div>
      <section class="content-header">
        <h1>
          CADASTRO DE <?php echo $tit; ?>
        </h1>
      </section>
      <div class="status"></div>
      <section class="content">

        <!-- PESQUISA DE CADASTROS -->
        <div class="col-md-12">
          <div class="box box-danger container mb-3 " style="margin-bottom: 30px;">
              <div class="box-header">
                <h4 class="box-title">PESQUISE POR NOME COMPLETO OU ID</h4>
              </div>
              <div class="row">   
                <div class="col-md-3" style="margin: 10px 5px 10px;">
                  <input type="text" class="form-control" placeholder="Nome" id="buscaNome" name="buscaNome"/>
                </div>
               
                <!-- SOMENTE PARA CADASTROS DE PROFESSORES OU ALUNOS -->
                <?php if($id < "2"){ ?>
                  <div class="col-md-3" style="margin: 10px 5px 10px;">
                    <input type="text" class="form-control" placeholder="Sobrenome" id="buscaSobre" name="buscaSobre"/>
                  </div>
                <?php } ?>
                
                <div class="col-md-3" style="margin: 10px 5px 10px;">
                    <input type="text" class="form-control" placeholder= "ID/Matricula" id = "buscaID" name="buscaID"/>
                  </div>
                <div class="col-md-6">
                  <div class="box-footer ">
                    <button type="button" class="btn btn-primary" id="btn-busca" onclick="RealizaPesquisa()" style="margin: 2px 5px;">Buscar <?php echo $tit; ?></button>
                    <button type="button" class="btn btn-secundary" id="btn-edit"  onclick="LiberaEdicao()" style="margin: 2px 5px;">Editar Cadastro</button>
                  </div>  
                </div>
              </div>
          </div>
        </div>

        <!-- FORMULARIO DE CADASTRO/EDIÇÃO/EXIBIÇÃO -->
        <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header">
                <h4 class="box-title">INFORMAÇÕES DO CADASTRO</h4>
              </div>
              <form role="form" action="" method="POST" id="form-cadastro">
                <div class="box-body">

                  <!-- CADASTRO DE ALUNO OU PROFESSOR -->
                  <?php if ($id < "2"){ ?>
                    <div class="form-group col-md-6">
                      <label for="nomeUser">Nome</label>
                      <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required/>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="sobrenomeUser">Sobrenome</label>
                      <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome" required>
                    </div>
                    <div class="form-group col-md-12">
                      <label for="emailUser">Email</label>
                      <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>

                    <!-- CADASTRO ESPECIFICO DE ALUNO -->
                    <?php if ($id == '0'){ ?>
                      <div class="form-group col-md-3">
                        <label for="matriUser">Data de Nascimento</label>
                        <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" placeholder="Data de Nascimento" required>
                      </div>
                    <?php } ?>

                    <div class="form-group col-md-6">
                      <label for="foneUser">Telefone</label>
                      <input type="text" class="form-control" id="telefone" name = "telefone" placeholder="Telefone" required>
                    </div>
                    <div class="form-group col-md-3" >
                      <label>Sexo: </label>
                      <div class="radio">
                        <label style="margin-right: 5px;">
                          <input type="radio" id="masculino" value="Masculino" name="sexo" >
                          Masculino
                        </label>
                        <label>
                          <input type="radio" id="feminino" value="Feminino" name="sexo">
                          Feminino
                        </label>
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="loginUser">Login</label>
                      <input type="text" class="form-control" id="login" name="login" placeholder="Login" required>
                    </div>
                    <div class="form-group col-md-3" >
                      <label>Status: </label>
                      <div class="radio">
                        <label style="margin-right: 5px;">
                          <input type="radio" value="ativo" name="status" id="status" checked>
                          Ativo
                        </label>
                        <label>
                          <input type="radio" value="desativado" name="status" id="status1">
                          Não Ativo
                        </label>
                      </div>
                    </div>
                    <?php if ($id == "0"){ ?>
                      <div class="form-group col-md-4" id ="idMatricula">
                        <label for="idUser">ID/Matricula*</label>
                        <input type="text" class="form-control" id="idUser" name="idAluno" placeholder="ID" <?php if($id == "0") echo "required";?>>
                      </div>
                    <?php }
                    elseif ($id == "1"){?>
                      <div class="form-group col-md-4" id ="idMatricula">
                        <label for="idUser">ID/Matricula*</label>
                        <input type="text" class="form-control" id="idUser" name="idProfessor" placeholder="ID" <?php if($id == "0") echo "required";?>>
                      </div>
                    <?php } ?>
                    
                  <?php }

                  // CADASTRO DE TURMAS
                  elseif($id == "2"){ ?>
                    <div class="form-group col-md-12">
                      <label for="idTurma">Nome da Turma</label>
                      <input type="text" class="form-control" id="idTurma" name="idTurma" placeholder="Turma" required />
                    </div>
                    <div class="form-group col-md-12">
                      <label>Curso</label>
                      <select class="form-control" name="idCurso">
                        <option value="" id="0">Selecione um curso</option>
                        <option value="1" id="1">Técnico em Informática</option>
                        <option value="2" id="2">Técnico em Secretariado</option>
                        <option value="3" id="3">Técnico em Contabilidade</option>
                      </select>
                    </div>

                  <?php }
                  
                  // CADASTRO DE DISCIPLINAS
                  elseif($id == "3"){ ?>
                    <div class="form-group col-md-6">
                      <label for="nome">Nome da Disciplina</label>
                      <input type="text" class="form-control" id="nome" name="nome" placeholder="Disciplina" required/>
                    </div>
                    <div class="checkbox col-md-2 form-group" style="margin-top: 30px;">
                      <label>
                        <input type="checkbox" name="prerequisitoCheck" id="prerequisitoCheck" onclick="habilitaSelect()"> *Pré-requisito
                      </label>
                    </div>
                    <div class="form-group col-md-4">
                      <label>*Disciplina que tranca</label>
                      <select class="form-control" name="prerequisito" id="prerequisito">
                          <option value=""></option>
                        <?php
                          $query = BuscaRetornaQuery($conexao, "disciplina");
                          if ($query){
                            while ($disciplinas = mysqli_fetch_assoc($query)){
                              echo "<option value=".$disciplinas["idDisciplina"].">".$disciplinas["nome"]."</option>";
                            }
                          }
                        ?>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Curso</label>
                      <select class="form-control" name="idCurso">
                        <option value="" id="0">Selecione um curso</option>
                        <option value="1" id="1">Técnico em Informática</option>
                        <option value="2" id="2">Técnico em Secretariado</option>
                        <option value="3" id="3">Técnico em Contabilidade</option>
                      </select>
                    </div>
                    <div class="form-group col-md-12" id="divId">
                      <label for="idDisciplina">ID/Matricula</label>
                      <input type="text" class="form-control" id="idDisciplina" name="idDisciplina" placeholder="ID">
                    </div>
                <?php } ?>
                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary" name="salva" id="btn-salva" style="margin-right: 5px;">Salvar</button>
                  <button type="submit" class="btn btn-primary" name="edita" id="btn-edita" style="margin-right: 5px;">Salvar Edição</button>
                  <a href="cadastro.php?id=<?php echo $id; ?>" class="btn btn-light" id="btn-cancela">Cancelar</a>
                </div>
                
              </form>
            </div>
        </div>
      </section>
     
    
      <!-- TABELA DE EXIBIÇÃO COM TODAS AS DISCIPLINAS E TURMAS -->
      <?php if($id > "1"){ ?>
        <section class="content">
          <div class="row">

            <!-- DISCIPLINAS -->
            <div class="col-md-8">
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title text-uppercase">Disciplinas Cadastradas</h3>
                </div>
                <div class="box-body table-responsive ">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Disciplina</th>
                        <th>Pré-Requisito(ID)</th>
                        <th>Curso</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $query = BuscaRetornaQuery($conexao, "disciplina");
                        if ($query){
                          while ($disciplinas = mysqli_fetch_assoc($query)){
                            if ($disciplinas["prerequisito"]){
                              $nomeDisciplinaPreRequisito = BuscaRetornaResponse($conexao, "disciplina", "idDisciplina", $disciplinas["prerequisito"]);
                              $nomeCurso = BuscaRetornaResponse($conexao, "curso", "idCurso", $disciplinas["idCurso"]);
                              echo "<tr><td>".$disciplinas["idDisciplina"]."</td><td>".$disciplinas["nome"]."</td><td>".$nomeDisciplinaPreRequisito["nome"]."</td><td>".$nomeCurso["nome"]."</td></tr>";
                            }
                            else{
                              $nomeCurso = BuscaRetornaResponse($conexao, "curso", "idCurso", $disciplinas["idCurso"]);
                              echo "<tr><td>".$disciplinas["idDisciplina"]."</td><td>".$disciplinas["nome"]."</td><td>-</td><td>".$nomeCurso["nome"]."</td></tr>";
                            }
                          }
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <!-- TURMAS -->
            <div class="col-md-4">
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title text-uppercase">Turmas Cadastradas</h3>
                </div>
                <div class="box-body table-responsive ">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Turma</th>
                        <th>Curso</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $query = BuscaRetornaQuery($conexao, "turma");
                        if ($query){
                          while ($turma = mysqli_fetch_assoc($query)){
                            $nomeCurso = BuscaRetornaResponse($conexao, "curso", "idCurso", $turma["idCurso"]);
                            echo "<tr><td>".$turma["idTurma"]."</td><td>".$nomeCurso["nome"]."</td></tr>";
                          }
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </section>
      <?php }?>
    </div>

  <!-- RODAPÉ -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <i>Algum problema? Mande um email para: escola@mariarocha.org.br</i>
    </div>
    <strong>Copyright &copy; 2019 Guilherme Selair</strong>
  </footer>

  <!-- CADASTRO DE ADMIN -->
  <aside class="control-sidebar control-sidebar-dark">
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-theme-demo-options-tab" data-toggle="tab"><i
            class="fa fa-wrench"></i></a></li>
    </ul>
    <div class="tab-content">
      <div id="control-sidebar-theme-demo-options-tab" class="tab-pane active">
        <div id="cadastra-Admin">
          <h4 class="control-sidebar-heading">CADASTRO DE ADMIN</h4>
          <Label for="nomeADMIN">Nome: </Label>
          <input type="text" class="form-control" id="nomeADMIN" name="nomeADMIN" placeholder="Nome" required>
          <label for="sobreADMIN" style="margin-top: 10px;">Sobrenome: </label>
          <input type="text" class="form-control" id="sobreADMIN" name="sobreADMIN" placeholder="Sobrenome" required>
          <label for="loginADMIN" style="margin-top: 10px;">Login: </label>
          <input type="text" class="form-control" id="loginADMIN" name="loginADMIN" placeholder="Login" required>
          <label for="senhaADMIN" style="margin-top: 10px;">Senha: </label>
          <input type="password" class="form-control" id="senhaADMIN" name="senhaADMIN" placeholder="Senha" required>
          <label for="emailADMIN" style="margin-top: 10px;">Email: </label>
          <input type="email" class="form-control" id="emailADMIN" name="emailADMIN" placeholder="Email" required>
          <button type="submit" class="btn btn-primary btn-block" name="salvaADMIN" id="btn-salvaADMIN" onclick="salvaADMIN()" style="margin-top: 20px;">Cadastrar</button>
        </div>
      </div>
    </div>
  </aside>

  <!-- SCRIPTS DE AUTOMATIZAÇÃO DA PÁGINA -->
  <script type="text/javascript">

    $(document).ready(function(){
      //  OCULTA BOTÕES
      $('#btn-edita').hide();
      $('#btn-edit').hide();
      <?php if($id == "1"){ ?>
        $("#idMatricula").hide();
      <?php }if($id == "3"){ ?>
        $("#divId").hide();
        document.querySelector("#prerequisito").disabled = true;
      <?php } ?>
      
      //  HABILITA O BOTÃO SALVA
      $('#btn-salva').show();
    })

    //  REALIZA BUSCA E EXIBE NOS INPUTS
    function RealizaPesquisa(){

      const buscaNome = document.querySelector("#buscaNome").value;
      const buscaID = document.querySelector("#buscaID").value;
      <?php if ($id < '2'){ ?>
        const buscaSobre = document.getElementById("buscaSobre").value;
      <?php } ?>

      if (!buscaID && buscaNome){
          //  REQUISIÇÃO AJAX
          $.ajax({
            type: "POST",
            dataType:"json",
            url: "controllers/buscaCadastro.php",
            data: 'tabela_ID='+<?php echo $id; ?>+'&nome='+buscaNome<?php if ($id < '2') echo "+'&sobrenome='+buscaSobre,"; else echo",";?>
            success: function(results){
              if (results){
                DesabilitaHabilitaCampos(true, 0)
                //  HABILITA BOTÕES DE EDIÇÃO
                $('#btn-edit').show();

                //  INSERE INFORMAÇÕES NOS CAMPOS ALUNOS, PROFESSORES, TURMAS E DISCIPLINAS
                let form = document.querySelector("#form-cadastro")
                for (let campo in results){
                  let field = form.querySelector("[name="+campo+"]")
                  if (field){
                    switch (field.type) {
                      case "radio":
                        field = form.querySelector("[name="+campo+"][value="+results[campo]+"]");
                        field.checked = true;
                        break;
                      case "checkbox":
                        field.checked = results[campo];
                        break;
                      default:
                        field.value = results[campo]
                    }
                  }
                }
              }
            }
          })
          buscaNome.value = "";
          <?php if ($id < '2'){ ?>
            buscaSobre.value = "";
          <?php } ?>
      }
      //  FAZ A BUSCA ATRAVÉS DO ID DO CADASTRO
      else if (buscaID){
        //  REQUISIÇÃO AJAX
        $.ajax({
            type: "POST",
            dataType:"json",
            url: "controllers/buscaCadastro.php",
            data: 'tabela_ID='+<?php echo $id; ?>+'&id='+buscaID,
            success: function(results){
              console.log(results)
              if (results){
                DesabilitaHabilitaCampos(true, 0)
                //  HABILITA BOTÕES DE EDIÇÃO
                $('#btn-edit').show();

                //  INSERE INFORMAÇÕES NOS CAMPOS ALUNOS, PROFESSORES, TURMAS E DISCIPLINAS
                let form = document.querySelector("#form-cadastro")
                for (let campo in results){
                  let field = form.querySelector("[name="+campo+"]")
                  if (field){
                    switch (field.type) {
                      case "radio":
                        field = form.querySelector("[name="+campo+"][value="+results[campo]+"]");
                        field.checked = true;
                        break;
                      case "checkbox":
                        field.checked = results[campo];
                        break;
                      default:
                        field.value = results[campo]
                    }
                  }
                }
              }
            }
          })
          buscaNome.value = "";
          buscaID.value = ""
          <?php if ($id < '2'){ ?>
            buscaSobre.value = "";
          <?php } ?>
      }
      else{
        document.querySelector("#buscaNome").parentElement.classList.add("has-error");
        document.querySelector("#buscaID").parentElement.classList.add("has-error");
        document.getElementById("buscaSobre").parentElement.classList.add("has-error");

        } 
    }

    //  DESABILITA CAMPOS DE ACORDO COM PARAMETROS
    function DesabilitaHabilitaCampos(opcao, tipo){
      const btnSalva = document.getElementById("btn-salva")
      const btnCancela = document.getElementById("btn-cancela")
      const btnEdita = document.getElementById("btn-edita")
      const formID = document.querySelectorAll("#form-cadastro [id]")

      formID.forEach(function(elemento, index){
        elemento.disabled = opcao
      });
      if (tipo == 0){
        btnSalva.disabled = opcao
        btnCancela.disabled = opcao
      }
      if (tipo == "editar"){
        btnEdita.disabled = opcao
        btnCancela.disabled = opcao
      }
      if (tipo == "limpa"){
        $("#form-cadastro").each(function(){
          this.reset();
        })
      }
    }

    //  LIBERA BOTÕES PARA EDIÇÃO
    function LiberaEdicao(){
      DesabilitaHabilitaCampos(false, "editar")
      $('#btn-edita').show();
      $("#btn-salva").hide();
      $("#idMatricula").hide();
      <?php if ($id == "3"){ ?>
      document.querySelector("#prerequisito").disabled = true;
      <?php } ?>
    }

    //  CONTROLA A EXIBIÇÃO DOS PREREQUISITOS DE DISCIPLINAS
    function habilitaSelect(){
      const disciplinaPreRequisito = document.querySelector("#prerequisito")
      if (disciplinaPreRequisito.disabled == false){
        disciplinaPreRequisito.disabled = true;
      }
      else{
        disciplinaPreRequisito.disabled = false;
        disciplinaPreRequisito.value = " ";
      }
    }

  </script>

  <script src="./controllers/controlaFormularios.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
  <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
</body>

</html>
