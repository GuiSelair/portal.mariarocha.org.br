<?php

/////////////////////////////////////////
////        LANÇAMENTO DE NOTAS      ////
/////////////////////////////////////////

session_cache_expire(20);
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

// BUSCA DISCIPLINAS MINISTRADAS PELO PROFESSOR LOGADO
if ($_SESSION["tipo"] == "Professor"){
    $AllDisciplinas = [];
    $query = BuscaRetornaQuery($conexao, "turma-professor", "idProfessor", $_SESSION["id"]);
    if ($query){
      while($idDisciplinas = mysqli_fetch_assoc($query)){
        if (!in_array($idDisciplinas["idDisciplina"], $AllDisciplinas)){
          $nomeDisciplina = BuscaRetornaResponse($conexao, "disciplina", "idDisciplina", $idDisciplinas["idDisciplina"]);
          $AllNameDisciplinas[] = $nomeDisciplina;
          $AllDisciplinas[] = $idDisciplinas["idDisciplina"];
        }
      }
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
  
  <!-- IMPORTAÇÃO FULLCALENDAR -->
  <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <!-- CABEÇALHO -->
    <header class="main-header">
      <a href="index.php" class="logo">
        <span class="logo-mini"><img src="../img/Logo.png" alt="logo" width="30" height="30"></span>
        <span class="logo-lg"><img src="../img/Logo.png" alt="logo" width="25" height="25"> Maria Rocha</span>
      </a>

      <!--MENU DISPOSITIVOS MÓVEIS-->
      <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <!--NOTIFICAÇÕES E USUÁRIOS-->
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
                    <a href="redefineSenhaPortal.php" class="btn btn-default btn-flat">Alterar senha</a>
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

    <!--MENU LATERAL-->
    <aside class="main-sidebar">
      <section class="sidebar">
        <div class="user-panel">
          <div class="pull-left">
            <i class="fa fa-user fa-3x" style="color: white;"></i>
          </div>
          <div class="pull-left info ">
            <p><?php echo substr($_SESSION['nome'],0,20)."..."; ?></p>
            <a><i class="fa fa-circle text-success"> <?php echo $_SESSION['tipo']; ?></i></a>
          </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MENU</li>
          <li><a href="index.php"><i class="fa fa-home"></i> <span class="text-uppercase">Inicio</span></a></li>

          <!--OPÇÕES DE MENU PARA CADA TIPO DE USUÁRIO-->
          <?php if ($_SESSION['tipo'] == "Aluno"){ ?>
            <li><a href="quadroNotas.php"><i class="fa fa-clipboard"></i> <span class="text-uppercase">Quadro de notas</span></a></li>
          <?php } ?>

          <?php if ($_SESSION['tipo'] == "Professor"){ ?>
            <li class="active"><a href="lancamentoDeNotas.php"><i class="fa fa-clipboard"></i> <span class="text-uppercase">Lançar notas</span></a></li>
            <li><a href="addcalendario.php"><i class="fa fa-calendar"></i> <span class="text-uppercase">Adicionar Calendario</span></a></li>
          <?php } ?>

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
                <li><a href="cadastro.php?id=3" class="text-uppercase">Disciplinas</a></li>
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
      <section class="content-header">
        <h1>
          LANÇAMENTO DE NOTAS
        </h1>
      </section>
      <section class="content">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body">

              <!-- DISCIPLINA -->
              <div class="form-group col-md-3">
                <label>Disciplina</label>
                <select class="form-control" name="disciplina" id="disciplina">
                  <option value="" id="0">Selecione abaixo</option>
                  <?php 
                    for ($i = 0; $i < count($AllNameDisciplinas); $i++){
                        echo "<option value=".$AllNameDisciplinas[$i]["idDisciplina"].">".$AllNameDisciplinas[$i]["nome"]."</option>";
                    }             
                    ?>
                </select>
              </div>

              <!-- TURMA -->
              <div class="form-group col-md-3">
                <label>Turma</label>
                <select class="form-control" name="turma" id="turma">
                  <option value="">Selecione uma disciplina</option>
                </select>
              </div>

              <!-- ALUNOS -->
              <div class="form-group col-md-3">
                <label>Alunos*</label>
                <select class="form-control" name="aluno" id="aluno">
                  <option value="">Selecione uma turma</option>
                </select>
              </div>
              
              <!-- DATA DE AVALIAÇÃO -->
              <div class="form-group col-md-3">
                <label for="matriUser">Data da Avaliação</label>
                <input type="date" class="form-control" id="data" name="dataAvaliacao" required>
              </div>

              <!-- NOME DA AVALIAÇÃO -->
              <div class="form-group col-md-3">
                <label for="emailUser">Nome da avaliação</label>
                <input type="text" class="form-control" id="nomeAvaliacao" name="nome" placeholder="Nome da Avaliação" required>
              </div>

              <!-- CONCEITO -->
              <div class="form-group col-md-5">
                <label>Conceito: </label>
                <div class="radio">
                  <label style="margin-right: 5px;">
                    <input type="radio" id="mensao" value="Apto" name="mensao">
                    APTO
                  </label>
                  <label>
                    <input type="radio" id="mensao" value="Não Apto" name="mensao">
                    NÃO APTO
                  </label>
                  <label style="margin-left: 5px;">
                    <input type="radio" id="mensao" value="Ausente" name="mensao">
                    AUSENTE
                  </label>
                </div>
              </div>

              <!-- CONCEITO FINAL -->
              <div class="form-group col-md-2" style="margin-top: 20px;">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="final" id="final" value="1">
                    Conceito Final*
                  </label>
                </div>
              </div>

              <p class="col-md-12 text-uppercase">*OBS: A opção "Conceito Final" só deve ser marcada quando a nota a ser lançada é a final. Desta forma é a nota que define se o aluno está apto ou não apto no semestre.</p>
              <p class="col-md-12 text-uppercase">*OBS: Para realizar buscas de notas já lançadas, não é preciso marcar a seleção "Alunos". Pois a busca realizada é por turma e por data de avaliação.</p>
            </div>
            <div class="box-footer ">
              <button class="btn btn-primary" id="salva" style="margin-right: 5px;">Salvar</button>
              <button class="btn btn-secundary" id="buscar" style="margin-right: 5px;">Buscar</button>
              <a href="lancamentoDeNotas.php" class="btn btn-light" id="cancela">Cancelar</a>
            </div>
          </div>
        </div>

        <!-- TABELA COM NOTAS LANÇADAS-->
        <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">NOTAS LANÇADAS</h3>
              </div>
              <div class="box-body table-responsive ">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Aluno</th>
                      <th>Disciplina</th>
                      <th>Turma</th>
                      <th>Data da Avaliação</th>
                      <th>Mensão</th>
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


    <!-- Rodapé -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <i>Algum problema? Mande um email para: escola@mariarocha.org.br</i>
      </div>
      <strong>Copyright &copy; 2019 Guilherme Selair</strong>
    </footer>
  </div>
  
  <script>
    $(document).ready(function () {

      // TURMAS
      $("#disciplina").on("change", function () {
        let idDisciplina = $(this).val();
        if (idDisciplina != "") {
          $.ajax({
            type: 'POST',
            url: './controllers/buscaTurmasAlunos.php',
            data: 'idDisciplina=' + idDisciplina,
            success: function (html) {
              $('#turma').html(html)
            }
          });
        }
      })

      // ALUNOS
      $("#turma").on("change", function () {
        let idTurma = $(this).val();
        let idDisciplina = $("#disciplina").val();
        if (idTurma != "") {
          $.ajax({
            type: 'POST',
            url: './controllers/buscaTurmasAlunos.php',
            data: 'idTurma='+idTurma +'&idDisciplina='+idDisciplina,
            success: function (html) {
              $('#aluno').html(html)
            }
          });
        }
      })

      // SALVA
      $("#salva").on("click", function () {
        const idDisciplina = $("#disciplina").val();
        const idTurma = $("#turma").val();
        const idAluno = $("#aluno").val();
        const data = $("#data").val();
        const nome = $("#nomeAvaliacao").val();
        let mensao = document.getElementsByName("mensao");
        for (let i = 0; i < mensao.length; i++) {
          if (mensao[i].checked) {
            mensao = mensao[i].value
          }
        }
        let final = document.getElementsByName("final");
        for (let i = 0; i < final.length; i++) {
          if (final[i].checked) {
            final = final[i].value
          }
        }
        if (final != '1') {
          final = "0";
        }

        $.ajax({
          type: 'POST',
          url: './controllers/salvaMatriculasNotas.php',
          data: 'idTurma=' + idTurma + '&idDisciplina=' + idDisciplina + '&idAluno=' + idAluno +
            '&data=' + data + '&mensao=' + mensao + '&final=' + final + '&nome=' + nome,
          beforeSend: function () {
            $("#salva").html("Enviando...")
          },
          success: function (html) {
            $("#salva").html("Salvar")
            $('#tabela').append(html);
          }
        });
      })

      // BUSCA
      $("#buscar").on("click", function(){
        let idDisciplina = $("#disciplina").val();
        let idTurma = $("#turma").val();
        let data = $("#data").val();
        $('#tabela').empty();
        $.ajax({
          type: "POST",
          url: "./controllers/buscaMatriculasNotas.php",
          data: "idTurma="+idTurma+"&idDisciplina="+idDisciplina+"&data="+data,
          beforeSend: function(){
            $("#buscar").html("Buscando...")
          },
          success: function(html){
            $("#buscar").html("Buscar")
            $('#tabela').append(html);
          }
        })
      })
    })
  </script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
  <script src="bower_components/moment/moment.js"></script>
  <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
</body>

</html>