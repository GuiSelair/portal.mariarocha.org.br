<?php

//////////////////////////////////////
////        PÁGINA PRINCIPAL      ////
//////////////////////////////////////

session_cache_expire(20);
session_start();
include_once("conexao/config.php");
include_once("conexao/conexao.php");
include_once("../conexao/function.php");


// DESLOGAR
if (isset($_GET['deslogar'])) {
  session_destroy();
  header("location: ./loginUser.php");
}

// VERIFICA SE O USUÁRIO ESTA LOGADO
if (!isset($_SESSION["id"])){
  header("location: ./loginUser.php");
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
          <li class="active"><a href="index.php"><i class="fa fa-home"></i> <span class="text-uppercase">Inicio</span></a></li>

          <!--OPÇÕES DE MENU PARA CADA TIPO DE USUÁRIO-->
          <?php if ($_SESSION['tipo'] == "Aluno"){ ?>
            <li><a href="quadroNotas.php"><i class="fa fa-clipboard"></i> <span class="text-uppercase">Quadro de notas</span></a></li>
          <?php } ?>

          <?php if ($_SESSION['tipo'] == "Professor"){ ?>
            <li><a href="lancamentoDeNotas.php"><i class="fa fa-clipboard"></i> <span class="text-uppercase">Lançar notas</span></a></li>
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
      <section class="content">
        <div class="row ">
          <div class="col-md-10 col-lg-12">
            <div class="box box-primary">
              <div class="box-body no-padding">
                <!-- INCLUSÃO CALENDARIO -->
                <div id="calendar"></div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    
    <!--DESCRIÇÃO DE EVENTOS MODAL-->
    <div class="modal fade" id="visualiza" tabindex="-1" role="dialog" aria-labelledby="visualiza" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">X</span>
            </button>
            <h4 class="modal-title" id="visualiza">Informações sobre a postagem:</h4>
          </div>
          <div class="modal-body">
            <dl class="dl-horizontal">
              <dt>Titulo:</dt>
              <dd id="title"></dd>
              <dt>Descricao:</dt>
              <dd id="descricao"></dd>
              <dt>Postado por:</dt>
              <dd id="postador"></dd>
              <dt>Disciplina:</dt>
              <dd id="disciplina"></dd>
              <dt>De: </dt>
              <dd id="start"></dd>
              <dt>Até: </dt>
              <dd id="end"></dd>
            </dl>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- RODAPÉ -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <i>Algum problema? Mande um email para: escola@mariarocha.org.br</i>
      </div>
      <strong>Copyright &copy; 2019 - Guilherme Selair</strong>
    </footer>
  </div>

  <!--CONFIGURAÇÃO FULLCALENDAR-->
  <script>
    $(document).ready(function () {
      $('#calendar').fullCalendar({
        locale: "pt-br",
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro',
          'Outubro', 'Novembro', 'Dezembro'
        ],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        buttonText: {
          prev: "<",
          next: ">",
          today: "Hoje",
          month: "Mês",
          week: "Semana",
          day: "Dia"
        },
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: Date(),
        navLinks: true,
        editable: false,
        events: "./controllers/eventosCalendario.php", //ARQUIVO QUE BUSCA OS EVENTOS
        eventLimit: true,
        contentHeight: 500,
        selectable: true,

        //MANDA INFORMAÇÕES PARA O MODAL
        eventClick: function (event) {
          $("#visualiza #title").text(event.title)
          $("#visualiza #descricao").html(event.description)
          $("#visualiza #start").text(event.start.format("DD/MM/YYYY HH:mm"))
          $("#visualiza #end").text(event.end.format("DD/MM/YYYY HH:mm"))
          $("#visualiza #disciplina").text(event.idDisciplina)
          $("#visualiza #postador").text(event.postador)
          $('#visualiza').modal('show')
        }

      });
    });
  </script>

  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
  <script src="bower_components/moment/moment.js"></script>
  <script src="bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
  <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
</body>
</html>
