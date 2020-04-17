<?php

//////////////////////////////////////
////         TROCA SENHA          ////
//////////////////////////////////////

session_start();
include_once("conexao/config.php");
include_once("conexao/conexao.php");
include_once("../conexao/function.php");

if (!isset($_SESSION["id"])){
    header("location: ./loginUser.php");
}

// REALIZA A TROCA DE SENHA
if(isset($_POST['envia'])) {
    $conn = DBConecta();
    $senha1 = mysqli_real_escape_string($conn, $_POST['senha1']);
    $senha2 = mysqli_real_escape_string($conn, $_POST['senha2']);

    if ($senha1 == $senha2 && !empty($senha1) && !empty($senha2)){
        if($_SESSION["tipo"] == "Administrador"){
            $id = $_SESSION["id"];
            $cript = CriptografiaSenhas($senha1);
            $sql_code = "UPDATE administrador SET senha='$cript' WHERE idAdministrador='$id';";
            $verifica = mysqli_query($conn, $sql_code);
            if($verifica)
                echo "<div class='alert alert-success alert-dismissable status'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Senha atualizada com sucesso!</strong>
                </div>
                ";
            else
                echo "<div class='alert alert-danger alert-dismissable status'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Erro ao atualizar senha! Verifique sua conexão ou volte mais tarde!</strong>
                </div>";
        
        }else{
            if($_SESSION["tipo"] == "Professor"){
                $id = $_SESSION["id"];
                $cript = CriptografiaSenhas($senha1);
                $sql_code = "UPDATE professor SET senha='$cript' WHERE idProfessor='$id';";
                $verifica = mysqli_query($conn, $sql_code);
                if($verifica)
                    echo "<div class='alert alert-success alert-dismissable status'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Senha atualizada com sucesso!</strong>
                    </div>
                    ";
                else
                    echo "<div class='alert alert-danger alert-dismissable status'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Erro ao atualizar senha! Verifique sua conexão ou volte mais tarde!</strong>
                    </div>";
            }else{
                $id = $_SESSION["id"];
                $cript = CriptografiaSenhas($senha1);
                $sql_code = "UPDATE aluno SET senha='$cript' WHERE idAluno='$id';";
                $verifica = mysqli_query($conn, $sql_code);
                if($verifica)
                    echo "<div class='alert alert-success alert-dismissable status'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Senha atualizada com sucesso!</strong>
                    </div>
                    ";
                else
                    echo "<div class='alert alert-danger alert-dismissable status'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Erro ao atualizar senha! Verifique sua conexão ou volte mais tarde!</strong>
                    </div>";
            }
        }
    }
}

?>

<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="../node_modules/bootstrap/compiler/bootstrap.css">
        <title>PLATAFORMA ONLINE - &nbsp; :::&nbsp; E.E.E.M. Profª Maria Rocha&nbsp; :::</title>
        <link rel="stylesheet" href="./dist/css/Login-Recuperation.css">
        <link rel="shortcut icon" href="../img/favicon.ico" />
    </head>
    <body class="text-center">
        <form class="form-signin" action="" method="POST">
            <img class="mb-4" src="../img/Login1.png" alt="" width="150">
            <h3 class="h4 mb-3 font-weight-normal">Redefinição de Senha</h3>
            <input type="password" id="senha1" class="form-control mb-2 rounded" placeholder="Digite sua senha" name="senha1" required autofocus>
            <input type="password" id="senha2" class="form-control rounded" placeholder="Digite novamente sua senha" name="senha2" required>
            <button class="btn btn-lg btn-primary btn-block mt-3" type="submit" name="envia">Enviar</button>
            <a href="./index.php" class="btn btn-lg btn-primary btn-block rounded" >Voltar</a>
        </form>
        <script src="../node_modules/jquery/dist/jquery.js"></script>
        <script src="../node_modules/popper.js/dist/umd/popper.js" crossorigin="anonymous"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.js" crossorigin="anonymous"></script>
    </body>
</html>
