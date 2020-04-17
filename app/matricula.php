<?php

////////////////////////////////////////
////        PÁGINA MATRICULAS      ////
//////////////////////////////////////

session_cache_expire(20);
session_start();
include_once("conexao/config.php");
include_once("conexao/conexao.php");
include_once("../conexao/function.php");


if (isset($_GET['deslogar'])) {
  session_destroy();
  header("location: ./loginUser.php");
}

if (!isset($_SESSION["tipo"]) == "Administrador"){
  header("location: ./loginUser.php");
}

if (isset($_GET["id"])){

  switch ($_GET["id"]) {
    case '0':
      $conexao = DBConecta();
      $id = ValidaString($_GET["id"]);
      break;
    case "1":
      $conexao = DBConecta();
      $id = ValidaString($_GET["id"]);
      break;

    default:
      header("location: ./loginUser.php");
      break;
  }
  
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
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
            <li class="treeview">
              <a href="#"><i class="fa fa-plus-square"></i> <span class="text-uppercase">Cadastros</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu text-center">
                <li><a href="cadastro.php?id=0" class="text-uppercase">Aluno</a></li>
                <li><a href="cadastro.php?id=1" class="text-uppercase">Professor</a></li>
                <li><a href="cadastro.php?id=2" class="text-uppercase">Turma</a></li>
                <li><a href="cadastro.php?id=3" class="text-uppercase">Disciplina</a></li>
              </ul>
            </li>
            <li class="treeview active">
              <a href="#"><i class="fa fa-id-badge"></i><span class="text-uppercase">Matricula</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu text-center">
                <li <?php if ($id == "0") echo "class='active'" ?>><a href="matricula.php?id=0" class="text-uppercase">Aluno na turma</a></li>
                <li <?php if ($id == "1") echo "class='active'" ?>><a href="matricula.php?id=1" class="text-uppercase">Professor para disciplina</a></li>
              </ul>
            </li>
          <?php } ?>
        </ul>
      </section>
    </aside>

    <!-- ÁREA DE CONTEÚDO -->

    <!-- MATRICULAS ALUNO -->
    <?php if ($id == "0"){ ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            MATRICULA DE ALUNO
          </h1>
        </section>
        <section class="content">
          <div class="col-md-12">
              <div class="box box-primary" >
                  <div class="box-body">

                    <!-- TURMAS -->
                    <div class="form-group col-md-6">
                      <label>Turmas</label>
                      <select class="form-control" id="turma" name="turma">
                        <option value="" id="0">Selecione uma turma</option>
                        <?php
                          $query = BuscaRetornaQuery($conexao, "turma");
                          if ($query){
                            while($turmas = mysqli_fetch_assoc($query)){
                              echo "<option value=".$turmas["idTurma"].">".$turmas["idTurma"]."</option>";
                            }
                          }
                         ?>
                      </select>
                    </div>

                    <!-- ALUNOS -->
                    <div class="form-group col-md-6">
                      <label>Alunos</label>
                      <select class="form-control" id="aluno" name="aluno">
                        <option value="" id="0">Selecione um nome</option>
                        <?php
                          $query = BuscaRetornaQuery($conexao, "aluno");
                          if ($query){
                            while($alunos = mysqli_fetch_assoc($query)){
                              if (VerificaStatusUsuarios($conexao, $alunos["idAluno"])){
                                $nomeCompleto = $alunos["nome"]." ".$alunos["sobrenome"];
                                echo "<option value=".$alunos["idAluno"].">".$alunos["idAluno"]." - ".$nomeCompleto."</option>";
                              }
                            }
                          }
                         ?>
                      </select>
                    </div>

                    <!-- SEMESTRE -->
                    <div class="form-group col-md-1">
                      <label for="ano">Ano: </label>
                      <input type="text" class="form-control" id="ano" name="ano" placeholder="AAAA" required>
                    </div>
                    <div class="form-group col-md-3" >
                      <label>Semestre: </label>
                      <div class="radio"  >
                        <label style="margin-right: 5px;">
                          <input type="radio" id="1" value="1" name="semestre" >
                          1º Semestre
                        </label>
                        <label>
                          <input type="radio" id="2" value="2" name="semestre">
                          2º Semestre
                        </label>
                      </div>
                    </div>

                    <p class="text-muted col-md-12">OBS: Para realizar uma busca. Basta selecionar os campos: Turma, Ano e Semestre</p>
                  </div>
                  <div class="box-footer ">
                    <button class="btn btn-primary" id="btn-salva" style="margin-right: 5px;">Salvar</button>
                    <button class="btn btn-sucundary" id="btn-buscar" style="margin-right: 5px;">Buscar</button>
                    <a href="matricula.php?id=0" class="btn btn-light" id="cancela">Cancelar</a>
                  </div>
            </div>
          </div>
          
          <script>

            // APAGA REGISTRO
            function apagaRegistro(turma, aluno, semestre){
              $.ajax({
                type: 'POST',
                url: './controllers/removeMatriculasNotas.php',
                data: 'idTurma='+turma+'&idAluno='+aluno+'&semestre='+semestre,
                beforeSend: function () {
                  $("#btn-apaga").html("Apagando...")
                },
                success: function (html) {
                  $("#btn-buscar").html("Atualizar");
                  $('#status').html(html);
                }
              })
            }

            $(document).ready(function () {

              // SALVANDO MATRICULA
              $("#btn-salva").on("click", function () {
                const idTurma = $("#turma").val();
                const idAluno = $("#aluno").val();
                let semestre = document.getElementsByName("semestre");
                for (let i = 0; i < semestre.length; i++) {
                  if (semestre[i].checked) {
                    semestre = semestre[i].value
                  }
                }
                const ano = $("#ano").val();

                $.ajax({
                  type: 'POST',
                  url: './controllers/salvaMatriculasNotas.php',
                  data: 'idTurma='+idTurma+'&idAluno='+idAluno+'&semestre='+semestre+'&ano='+ano,
                  beforeSend: function () {
                    $("#btn-salva").html("Enviando...")
                  },
                  success: function (html) {
                    $("#btn-salva").html("Salvar")
                    $('#tabela').append(html);
                  }
                });
              })

              // BUSCANDO REGISTRO
              $("#btn-buscar").on("click", function(){
                let idTurma = $("#turma").val();
                let semestre = document.getElementsByName("semestre");
                for (let i = 0; i < semestre.length; i++) {
                  if (semestre[i].checked) {
                    semestre = semestre[i].value
                  }
                }
                const ano = $("#ano").val();
                $('#tabela').empty();
                $.ajax({
                  type: "POST",
                  url: "./controllers/buscaMatriculasNotas.php",
                  data: "idTurma="+idTurma+"&semestre="+semestre+'&ano='+ano,
                  beforeSend: function(){
                    $("#btn-buscar").html("Buscando...")
                  },
                  success: function(html){
                    $("#btn-buscar").html("Buscar")
                    $('#tabela').append(html);
                  }
                })

              })
            })

          </script>

          <!-- TABELA -->
          <div class="row">
            <div class="col-md-12">
              <div id="status"></div>
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">MATRICULAS LANÇADAS</h3>
                </div>
                <div class="box-body table-responsive ">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Aluno</th>
                        <th>Turma</th>
                        <th>Semestre</th>
                        <th>Opção</th>
                      </tr>
                    </thead>
                    <tbody id="tabela"></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    <?php }

    // MATRICULAS PROFESSOR
    elseif($id == "1"){ ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            MATRICULA DE PROFESSOR A TURMA E DISCIPLINA
          </h1>
        </section>
        <section class="content">
          <div class="col-md-12">
              <div class="box box-primary" >
                  <div class="box-body">

                    <!-- PROFESSOR -->
                    <div class="form-group col-md-6">
                      <label>Professor</label>
                      <select class="form-control" id="professor" name="professor" required>
                        <option value="" id="0">Selecione um Professor</option>
                        <?php
                          $query = BuscaRetornaQuery($conexao, "professor");
                          if ($query){
                            while($professores = mysqli_fetch_assoc($query)){
                              if (VerificaStatusUsuarios($conexao, null, $professores["idProfessor"])){
                                $nomeCompleto = $professores["nome"]." ".$professores["sobrenome"];
                                echo "<option value=".$professores["idProfessor"].">".$professores["idProfessor"] ." - ".$nomeCompleto."</option>";
                              }
                            }
                          }
                         ?>
                      </select>
                    </div>

                    <!-- TURMAS -->
                    <div class="form-group col-md-6">
                      <label>Turmas</label>
                      <select class="form-control" id="turma" name="turma" required>
                        <option value="" id="0">Selecione uma turma</option>
                        <?php
                          $query = BuscaRetornaQuery($conexao, "turma");
                          if ($query){
                            while($turmas = mysqli_fetch_assoc($query)){
                              echo "<option value=".$turmas["idTurma"].">".$turmas["idTurma"]."</option>";
                            }
                          }
                         ?>
                      </select>
                    </div>

                    <!-- DISCIPLINAS -->
                    <div class="form-group col-md-6">
                      <label>Disciplina</label>
                      <select class="form-control" id="disciplina" name="disciplina" required>
                        <option value="" id="0">Selecione uma disciplina</option>
                        <?php
                          $query = BuscaRetornaQuery($conexao, "disciplina");
                          if ($query){
                            while($disciplinas = mysqli_fetch_assoc($query)){
                              $nomeCurso = BuscaRetornaResponse($conexao, "curso", "idCurso", $disciplinas["idCurso"]);
                              echo "<option value=".$disciplinas["idDisciplina"].">".$disciplinas["idDisciplina"]." - ".$disciplinas["nome"]." - ".$nomeCurso["nome"]."</option>";
                            }
                          }
                         ?>
                      </select>
                    </div>

                    <!-- SEMESTRE -->
                    <div class="form-group col-md-1">
                      <label for="ano">Ano: </label>
                      <input type="text" class="form-control" id="ano" name="ano" placeholder="AAAA" required>
                    </div>
                    <div class="form-group col-md-3" >
                      <label>Semestre: </label>
                      <div class="radio"  >
                        <label style="margin-right: 5px;">
                          <input type="radio" id="1" value="1" name="semestre" >
                          1º Semestre
                        </label>
                        <label>
                          <input type="radio" id="2" value="2" name="semestre">
                          2º Semestre
                        </label>
                      </div>
                    </div>

                    <p class="text-muted col-md-12">OBS: PARA BUSCAR POR MATRICULAS DE PROFESSORES, BASTA SELECIONAR TURMA, DISCIPLINA, ANO E SEMESTRE</p>
                  </div>
                  <div class="box-footer ">
                    <button class="btn btn-primary" id="btn-salva" style="margin-right: 5px;">Salvar</button>
                    <button class="btn btn-secundary" id="btn-buscar" style="margin-right: 5px;">Buscar</button>
                    <a href="matricula.php?id=1" class="btn btn-light" id="cancela">Cancelar</a>
                  </div>
            </div>
          </div>

          <script>

            // APAGANDO REGISTRO
            function apagaRegistro(turma, professor, semestre, disciplina){
              $.ajax({
                type: 'POST',
                url: './controllers/removeMatriculasNotas.php',
                data: 'idTurma='+turma+'&idProfessor='+professor+'&semestre='+semestre+'&idDisciplina='+disciplina,
                beforeSend: function () {
                  $("#btn-apaga").html("Apagando...")
                },
                success: function (html) {
                  $("#btn-buscar").html("Atualizar");
                  $('#status').html(html);
                }
              })
            }

            $(document).ready(function () {

              // SALVANDO MATRICULA
              $("#btn-salva").on("click", function () {
                let idTurma = $("#turma").val();
                let idProfessor = $("#professor").val();
                let idDisciplina = $("#disciplina").val();
                let semestre = document.getElementsByName("semestre");
                for (let i = 0; i < semestre.length; i++) {
                  if (semestre[i].checked) {
                    semestre = semestre[i].value
                  }
                }
                const ano = $("#ano").val();

                $.ajax({
                  type: 'POST',
                  url: './controllers/salvaMatriculasNotas.php',
                  data: 'idTurma='+idTurma+'&idProfessor='+idProfessor+'&semestre='+semestre+'&idDisciplina='+idDisciplina+'&ano='+ano,
                  beforeSend: function () {
                    $("#btn-salva").html("Enviando...")
                  },
                  success: function (html) {
                    $("#btn-salva").html("Salvar")
                    $('#tabela').append(html);
                  }
                });
              })

              // BUSCANDO REGISTROS
              $("#btn-buscar").on("click", function(){
                let idTurma = $("#turma").val();
                let idDisciplina = $("#disciplina").val();
                let semestre = document.getElementsByName("semestre");
                for (let i = 0; i < semestre.length; i++) {
                  if (semestre[i].checked) {
                    semestre = semestre[i].value
                  }
                }
                const ano = $("#ano").val();
                $('#tabela').empty();

                $.ajax({
                  type: "POST",
                  url: "./controllers/buscaMatriculasNotas.php",
                  data: "idTurma="+idTurma+"&semestre="+semestre+'&idDisciplina='+idDisciplina+'&ano='+ano,
                  beforeSend: function(){
                    $("#btn-buscar").html("Buscando...")
                  },
                  success: function(html){
                    $("#btn-buscar").html("Buscar");
                    $('#tabela').append(html);
                  }
                })
              })
            })
          </script>

          <!-- TABELA -->
          <div class="row">
            <div class="col-md-12">
              <div id="status"></div>
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">MATRICULAS LANÇADAS</h3>
                </div>
                <div class="box-body table-responsive ">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Professor</th>
                        <th>Turma</th>
                        <th>Disciplina</th>
                        <th>Semestre</th>
                        <th>Opção</th>
                      </tr>
                    </thead>
                    <tbody id="tabela"></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    <?php } ?>
    
    <!-- RODAPÉ -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <i>Algum problema? Mande um email para: escola@mariarocha.org.br</i>
      </div>
      <strong>Copyright &copy; 2019 Guilherme Selair</strong>
    </footer>
  </div>

  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
  <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
</body>

</html>
