<?php

//////////////////////////////////////
////        QUADRO DE NOTAS      ////
//////////////////////////////////////

session_start();
include_once("conexao/config.php");
include_once("conexao/conexao.php");
include_once("../conexao/function.php");

// VERIFICA SE O USUÁRIO ESTÁ LOGADO
if (isset($_GET['deslogar'])) {
  session_destroy();
  header("location: ./loginUser.php");
}

// VERIFICA SE O USUÁRIO É ALUNO
if (!isset($_SESSION["tipo"]) == "Aluno"){
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
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <!--CABEÇALHO-->
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
            <li class="active"><a href="quadroNotas.php"><i class="fa fa-clipboard"></i> <span class="text-uppercase">Quadro de notas</span></a></li>
          <?php } ?>

          <?php if ($_SESSION['tipo'] == "Professor"){ ?>
            <li><a href="notas.php"><i class="fa fa-clipboard"></i> <span class="text-uppercase">Lançar notas</span></a></li>
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

    <!-- Titulo da Área com conteudo -->
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          QUADRO DE NOTAS
        </h1>
      </section>

      <!--ÁREA DE CONTEÚDO-->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="nav-tabs-custom">

            <!--ABAS DE OPÇÕES-->
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">NOTAS LANÇADAS</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">MATRIZ CURRICULAR</a></li>
              </ul>
              <div class="tab-content">

                <!-- TABELA DE NOTAS -->
                <div class="tab-pane active" id="tab_1">
                  <div class="box-body table-responsive ">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Nome da Avaliação</th>
                          <th>Disciplina</th>
                          <th>Turma</th>
                          <th>Data da Avaliação</th>
                          <th>Conceito</th>
                        </tr>
                      </thead>
                      <tbody id="tabela">
                        <?php 
                            $conexao = DBConecta();
                            $idAluno = $_SESSION["id"];
                            // BUSCA AVALIAÇÕES REFERENCIANDO O ALUNO
                            $sql_code = "SELECT * FROM `avalhacao` WHERE `idAluno` = $idAluno";
                            $results = mysqli_query($conexao, $sql_code);
                            if ($results && mysqli_num_rows($results)){
                                while ($avaliacoes = mysqli_fetch_assoc($results)){
                                  // VERIFICA SE O ALUNO JA ESTÁ APROVADO NA DISCIPLINA DA AVALIAÇÃO E MOSTRA CASO NÃO ESTIVER
                                  $dados = ConfereAprovacao($conexao, $avaliacoes["idDisciplina"], $idAluno);
                                  if ($dados["conceitoDisciplina"] != "APTO"){
                                    switch ($avaliacoes["conceito"]) {
                                      case 'Apto':
                                        echo "<tr><td>".$avaliacoes["nomeAvaliacao"]."</td><td>".$dados["nomeDisciplina"]."</td><td>".$avaliacoes["idTurma"]."</td><td>".date("d/m/Y", strtotime($avaliacoes["data"]))."</td><td><span class='label label-success text-uppercase'>".$avaliacoes["conceito"]."</span></td></tr>";
                                        break;
                                      case "Não Apto":
                                        echo "<tr><td>".$avaliacoes["nomeAvaliacao"]."</td><td>".$dados["nomeDisciplina"]."</td><td>".$avaliacoes["idTurma"]."</td><td>".date("d/m/Y", strtotime($avaliacoes["data"]))."</td><td><span class='label label-danger text-uppercase'>".$avaliacoes["conceito"]."</span></td></tr>";
                                        break;
                                      case "Ausente":
                                        echo "<tr><td>".$avaliacoes["nomeAvaliacao"]."</td><td>".$dados["nomeDisciplina"]."</td><td>".$avaliacoes["idTurma"]."</td><td>".date("d/m/Y", strtotime($avaliacoes["data"]))."</td><td><span class='label label-info text-uppercase'>".$avaliacoes["conceito"]."</span></td></tr>";
                                        break;
                                      
                                    }
                                  }
                                }
                                
                            }
                            else{
                              echo "<p class='text-muted'>Nenhuma nota disponível...</p>";
                            }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>

                <!--MATRIZ CURRICULAR-->
                <div class="tab-pane" id="tab_2">
                  <div class="box-body table-responsive ">
                    <?php
                      $idAluno = $_SESSION["id"];
                      $AllCursos = BuscaTodosCursos($conexao, $idAluno);
                      $todosCursos = [];
                      while ($idCurso = mysqli_fetch_assoc($AllCursos)) {
                          $nomeCurso = BuscaRetornaResponse($conexao, "curso", "idCurso", $idCurso["idCurso"]);
                          echo '<h4> -- Curso '.$nomeCurso["nome"].' --</h4>';
                          echo "<table class='table table-hover'>
                                  <thead>
                                    <tr>
                                      <th>Disciplina</th>
                                      <th>Conceito</th>
                                    </tr>
                                  </thead>
                                  <tbody id='tabela'>";
                          $query = BuscaRetornaQuery($conexao, "disciplina", "idCurso", $idCurso["idCurso"]);
                          if ($query){
                            while ($response = mysqli_fetch_assoc($query)){
                              $dados = ConfereAprovacao($conexao, $response["idDisciplina"], $idAluno); 
                              switch ($dados["conceitoDisciplina"]) {
                                case 'APTO':
                                  echo "<tr><td>".$dados["nomeDisciplina"]."</td><td><span class='label label-success'>".$dados["conceitoDisciplina"]."</span></td></tr>";
                                  break;
                                case "NÃO APTO":
                                  echo "<tr><td>".$dados["nomeDisciplina"]."</td><td><span class='label label-danger'>".$dados["conceitoDisciplina"]."</span></td></tr>";
                                  break;
                                case "AUSENTE":
                                  echo "<tr><td>".$dados["nomeDisciplina"]."</td><td><span class='label label-info'>".$dados["conceitoDisciplina"]."</span></td></tr>";
                                  break;                             
                                default:
                                  echo "<tr><td>".$dados["nomeDisciplina"]."</td><td><span class='label label-warning'>".$dados["conceitoDisciplina"]."</span></td></tr>";
                                  break;
                              }
                            } 
                          }  
                          echo "
                          </tbody>
                        </table>";                            
                      };  
                                                                
                    ?> 
                  </div>
                </div>
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

  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
  <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
</body>
</html>