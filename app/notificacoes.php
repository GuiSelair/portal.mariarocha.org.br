<?php

////////////////////////////////////////////////////
////   CADASTRO DE USUÁRIOS/TURMAS/DISCIPLINAS  ////
////////////////////////////////////////////////////

$linha = NULL;
$conexao = DBConecta();

//  PROFESSORES E ADMINISTRADORES
if($_SESSION["tipo"] == "Professor" || $_SESSION["tipo"] == "Administrador"){
  $query = BuscaRetornaQuery($conexao, "calendario", "geral", "-1");
  $linha = mysqli_num_rows($query);
  if ($linha){
    while ($noticeTurmaNum = mysqli_fetch_assoc($query)){
      $noticeTurmaResults[] = $noticeTurmaNum;	// IDs DAS NOTICIAS QUE REFERENCIAM ESTA TURMA
    }
  }
}

// ALUNOS
if ($_SESSION["tipo"] == "Aluno"){
  $noticeTurmaResults = [];
	$turmas = BuscaRetornaQuery($conexao, "turma-aluno", "idAluno", $_SESSION["id"]);
	if ($turmas){
    $linha = 1;
		while ($turmaAlunoNum = mysqli_fetch_assoc($turmas)){
			$notificacoes = BuscaRetornaQuery($conexao, "calendario", "idTurma", $turmaAlunoNum["idTurma"]);
			if ($notificacoes){
				while ($disciplinas = mysqli_fetch_assoc($notificacoes)){
					$aprovado = ConfereAprovacao($conexao, $disciplinas["idDisciplina"], $_SESSION["id"]);
					if ($aprovado["conceitoDisciplina"] != "APTO"){
						if (!in_array($disciplinas, $noticeTurmaResults))
							$noticeTurmaResults[] = $disciplinas;
					}
				}
			}
		}
	}
}
 ?>

 <script>
    function desabilita(){
      $("#conta").hide();
      
    }
 </script>

<li class="dropdown notifications-menu" >
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="desabilita()">
    <i class="fa fa-bell-o"></i>
    <span class="label label-danger" id="conta"><?php if ($linha != 0) echo "!"; ?></span>
    <!--QUANDO HÁ NOTIFICAÇÕES NÃO LIDAS-->
  </a>
  <ul class="dropdown-menu">
    <?php if($linha){ ?>
    <li>
      <ul class="menu">
        <li>
          <?php if($linha){
            for ($i = 0; $i < sizeof($noticeTurmaResults); $i++){
              echo "<a><i class='fa fa-users text-aqua'></i>".$noticeTurmaResults[$i]["title"]." - ".date("d/m/Y", strtotime($noticeTurmaResults[$i]["start"]))."</a>";
            }
          }
          ?>
        </li>

      </ul>
    </li>
  <?php } ?>
  </ul>
</li>

