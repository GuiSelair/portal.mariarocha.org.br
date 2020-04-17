<?php

////////////////////////////////////////////
////   ADICIONAR EVENTO AO CALENDARIO  ////
///////////////////////////////////////////

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

// PESQUISA DE TURMAS
if ($_SESSION["tipo"] == "Professor"){
  $idProfessor = $_SESSION["id"];
  $query1 = BuscaRetornaQuery($conexao, "turma-professor", "idProfessor", $idProfessor);
}

// FUNÇÃO SALVA O EVENTO AO BANCO DE DADOS
if (isset($_POST["salva"]) && $_SESSION["tipo"] != "Aluno"){
  $turma = ValidaString($_POST["turma"]);
  $cor = ValidaString($_POST["cor"]);
  $titulo = ValidaString($_POST["titulo"]);
  $editor = ValidaString($_POST["descricao"]);
  $start = ValidaString($_POST["start"]);
  $end = ValidaString($_POST["end"]);
  if ($_SESSION["tipo"] != "Administrador"){
    $idDisciplina = ValidaString($_POST["disciplina"]);
  }
  $postador = $_SESSION["nome"];
  $validacaoDate = $start < $end ? true : false;

  if ($turma && $cor && $titulo && $editor && $start && $end && $validacaoDate){
    // VERIFICA QUAL TIPO DE USUÁRIO ESTÁ GRAVANDO O EVENTO
    if ($_SESSION["tipo"] == "Administrador")
    $sql_code = "INSERT INTO calendario (title,description,color,start,end,geral,postador) VALUES ('$titulo','$editor','$cor','$start','$end','$turma','$postador')";
    else
    $sql_code = "INSERT INTO calendario (title,description,color,start,end,idTurma,idDisciplina,postador) VALUES ('$titulo','$editor','$cor','$start','$end','$turma','$idDisciplina','$postador')";
    $query = mysqli_query($conexao, $sql_code);

    if ($query){
    echo "<div class='alert alert-success alert-dismissable status' style='margin-bottom: 0px;'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>Evento adicionado com sucesso!</strong>
          </div>
          ";
    }
    else{
    echo "<div class='alert alert-danger alert-dismissable status' style='margin-bottom: 0px;'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>Erro no cadastro do evento. Tente mais tarde e verifique sua conexão!</strong>
          </div>";
    }
  }
  else{
    echo "<div class='alert alert-danger alert-dismissable status' style='margin-bottom: 0px;'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>Preencha corretamente os dados!</strong>
          </div>";
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

  <!-- IMPORTAÇÃO DATETIMEPICKER -->
  <script src="bower_components/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
  <link rel="stylesheet" href="bower_components/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css">
  <script src="bower_components/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.pt-BR.js"></script>

  <!-- IMPORTAÇÃO EDITOR SUMMERNOTE  --> 
  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
  
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
            <a href="./index.php">
              <i class="fa fa-circle text-success"><?php echo $_SESSION['tipo']; ?></i>
            </a>
          </div>
        </div>

        <!-- OPÇÕES DE MENU PARA CADA TIPO DE USUÁRIO -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MENU</li>
          <li><a href="index.php"><i class="fa fa-home"></i> <span class="text-uppercase">Inicio</span></a></li>

          <?php if ($_SESSION['tipo'] == "Professor"){ ?>
            <li><a href="lancamentoDeNotas.php"><i class="fa fa-clipboard"></i> <span class="text-uppercase">Lançar notas</span></a></li>
            <li class="active"><a href="addcalendario.php"><i class="fa fa-calendar"></i> <span class="text-uppercase">Adicionar Calendario</span></a></li>
          <?php } ?>

          <?php if ($_SESSION['tipo'] == "Administrador"){ ?>
            <li class="active"><a href="addcalendario.php"><i class="fa fa-calendar"></i> <span class="text-uppercase">Adicionar Calendario</span></a></li>
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
          ADICIONAR EVENTO AO CALENDÁRIO
        </h1>
      </section>
      <section class="content">
        <div >
            <div class="box box-primary">
              <form role="form" action="" method="POST" id="form-cadastro">
                <div class="box-body">

                  <!-- EXIBE TODAS AS TURMAS -->
                  <div class="form-group col-md-6">
                    <label>Turmas</label>
                    <select class="form-control" name="turma">
                      <option value="" id="0">Selecione uma turma</option>
                      <?php if ($_SESSION["tipo"] == "Administrador"){ ?>
                        <option value="-1" id="todos">TODOS os professores</option>
                      <?php } 
                        if ($_SESSION["tipo"] == "Professor" && $query1){
                          $AllTurmas = [];
                          while($turmas = mysqli_fetch_assoc($query1)){
                            if (!in_array($turmas["idTurma"], $AllTurmas)){
                              echo "<option value=".$turmas["idTurma"].">".$turmas["idTurma"]."</option>";
                              $AllTurmas[] = $turmas["idTurma"];
                            }
                          }
                        }
                       ?>
                    </select>
                  </div>
                  
                  <!-- EXIBE CORES -->
                  <div class="form-group col-md-6">
                    <label>Cores</label>
                    <select class="form-control" name="cor">
                      <option value="" id="0">Selecione uma cor</option>
                      <option value="#ed5959" id="1">Vermelho</option>
                      <option value="#f4cc00" id="2">Amarelo</option>
                      <option value="#576ee5" id="3">Azul</option>
                      <option value="black" id="4">Preto</option>
                    </select>
                  </div>

                  <!-- INPUT DE TITULO DO EVENTO -->
                  <div class="form-group col-md-12">
                    <label for="emailUser">Titulo</label>
                    <input type="text" class="form-control" id="tituloEvent" name="titulo" placeholder="Titulo" required>
                  </div>

                  <!-- TEXTAREA EDITOR -->
                  <div class="form-group col-md-12">
                    <label for="editor">Descrição</label>
                    <textarea class="form-control" name="descricao" id="editor" ></textarea>
                  </div>

                  <!-- DATA/HORA INICIO -->
                  <div class="form-group col-md-3">
                      <label for="matriUser">Data e hora inicial: *</label>
                      <input size="16" type="text"  class="form-control form_datetime" id="start" name="start" placeholder="AAA-MM-DD HH:mm:ss" required autocomplete="off">
                      <span class="add-on"><i class="icon-th"></i></span>
                  </div>

                  <!-- DATA/HORA FIM -->
                  <div class="form-group col-md-3">
                      <label for="matriUser">Data e hora final: *</label>
                      <input size="16" type="text"  class="form-control form_datetime" id="end" name="end" placeholder="AAA-MM-DD HH:mm:ss" required autocomplete="off">
                      <span class="add-on"><i class="icon-remove"></i></span>
                      <span class="add-on"><i class="icon-th"></i></span>
                  </div>

                  <!-- MOSTRA DISCIPLINAS DO PROFESSOR -->
                  <?php if ($_SESSION["tipo"] == "Professor"){ ?>
                    <div class="form-group col-md-3">
                      <label>Disciplina</label>
                      <select class="form-control" name="disciplina">
                        <option value="" id="0">Selecione sua disciplina</option>
                        <?php 
                          $query = BuscaRetornaQuery($conexao, "turma-professor", "idProfessor", $idProfessor);
                          if ($query){
                            $AllDisciplinas = [];
                            while($idDisciplinas = mysqli_fetch_assoc($query)){
                              if (!in_array($idDisciplinas["idDisciplina"], $AllDisciplinas)){
                                $nameDisciplina = BuscaRetornaResponse($conexao, "disciplina", "idDisciplina", $idDisciplinas["idDisciplina"]);
                                echo "<option value=".$idDisciplinas["idDisciplina"].">".$nameDisciplina["nome"]."</option>";
                                $AllDisciplinas[] = $idDisciplinas["idDisciplina"];
                              }
                            }
                          }
                              
                        ?>
                      </select>
                    </div>
                  <?php } ?>

                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary" name="salva" id="salva" style="margin-right: 5px;">Salvar</button>
                  <a href="addcalendario.php" class="btn btn-secundary" id="cancela">Cancelar</a>
                </div>
              </form>
          </div>
        </div>
      </section>
    </div>

    <!-- RODAPÉ -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <i>Algum problema? Mande um email para: escola@mariarocha.org.br</i>
      </div>
      <strong>Copyright &copy; 2019 Guilherme Selair</strong>
    </footer>
  </div>

  <!-- SCRIPT DE CONFIGURAÇÃO DO DATETIMEPICKER -->
  <script>
    $(".form_datetime").datetimepicker({
        language:  'pt-BR',
        format: "yyyy-mm-dd hh:ii",
        autoclose: true,
        todayBtn: true,
        pickerPosition: 'top-left',
    });
  </script>

  <!-- SCRIPT DE CONFIGURAÇÃO DO EDITOR SUMMERNOTE -->
  <script type="text/javascript">
    $(document).ready(function() {
        $('#editor').summernote({
            toolbar: [
                ['font', ['bold', 'italic', 'underline']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['insert', ['link']],
            ],
            height: 150,
            minHeight: 50,
            maxHeight: 400,
            focus: true,
            lang: 'pt-BR',
            codeviewFilter: false,
            codeviewIframeFilter: true,
        });
    });
    var postForm = function() {
        var content = $('textarea[name="descricao"]').html($('#editor').code());
    }
  </script>

  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
  <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>

  <!-- CONFIGURAÇÃO EDITOR SUMMERNOTE -->
  <script src="../editor/dist/lang/summernote-pt-BR.js"></script>
</body>

</html>
