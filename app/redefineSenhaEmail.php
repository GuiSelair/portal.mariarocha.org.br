<?php
//////////////////////////////////////
////        REDEFINE SENHA        ////
//////////////////////////////////////

include_once("conexao/config.php");
include_once("conexao/conexao.php");
include_once("../conexao/function.php");

$conexao = DBConecta();

// VERIFICA SE A HASH ESTÁ NO BD
if (!isset($_GET["hash"]) || !VerificaHash($conexao, $_GET["hash"])){
    header("location: ./loginUser.php");
}

$hash = ValidaString($_GET["hash"]);
$email = ValidaEmail($_GET["email"]);
if (isset($_POST["redefine"]) && $_POST["senha"] != " "){
    $senha = mysqli_escape_string($conexao, $_POST['senha']);
    $senhaConfirma = mysqli_escape_string($conexao, $_POST['senhaConfirma']);
    if ($senha === $senhaConfirma){
        $nomeTabela = ConfereTipoUsuario($conexao, null, null, $email);
        if(InsereNovaSenha($conexao, $senha, $nomeTabela, "email", $email)){
            echo "<div class='alert alert-success alert-dismissable status'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Senha alterada com sucesso!</strong>
            </div>";
            RemoveHashEEmail($conexao, $email);
            Redireciona("./loginUser.php");
        }else{
            echo "<div class='alert alert-warning alert-dismissable status'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Erro ao salvar senha. Tente mair tarde</strong>
            </div>";
            Redireciona("./loginUser.php");
        }
    }
}
?>

<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="../img/favicon.ico" />
        <link rel="stylesheet" href="../node_modules/bootstrap/compiler/bootstrap.css">
        <title>PLATAFORMA ONLINE - &nbsp; :::&nbsp; E.E.E.M. Profª Maria Rocha&nbsp; :::</title>
        <script src="../node_modules/jquery/dist/jquery.min.js"></script>
        <link rel="stylesheet" href="./dist/css/Login-Recuperation.css">
    </head>
    <body class="text-center">
        <div class="status"></div>
        <form class="form-signin" method="POST" action="">
            <img class="mb-4" src="../img/Login1.png" alt="" width="150">
            <h3 class="h4 mb-3 font-weight-normal">Redefinição de Senha</h3>
            <input type="password" id="senha" class="form-control rounded" placeholder="Sua nova senha" name="senha" required id="senha">
            <input type="password" id="senhaConfirma" class="form-control rounded" placeholder="Repita sua senha" name="senhaConfirma" required id="senhaConfirma">
            <button class="btn btn-lg btn-primary btn-block mt-3" type="submit" name="redefine" id="redefine">Redefinir</button>
            <a href="./loginUser.php" class="btn btn-lg btn-primary btn-block rounded" >Voltar</a>
        </form>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#senhaConfirma").on("change", function(){
                    if ($("#senha").val() != "" && $("#senhaConfirma").val() != ""){
                        if($("#senha").val() != $("#senhaConfirma").val()){
                            $("#senha").css("border-color", "red");
                            $("#senhaConfirma").css("border-color", "red");
                        }else{
                            $("#senha").css("border-color", "green");
                            $("#senhaConfirma").css("border-color", "green");
                        }
                    }
                })
            })
        </script>
        <script src="../node_modules/jquery/dist/jquery.js"></script>
        <script src="../node_modules/popper.js/dist/umd/popper.js" crossorigin="anonymous"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.js" crossorigin="anonymous"></script>
    </body>
</html>
