<?php

//////////////////////////////////////
////            LOGIN             ////
//////////////////////////////////////

session_start();
include_once("conexao/config.php");
include_once("conexao/conexao.php");
include_once("../conexao/function.php");

// TESTES DE TIPOS DE USUÁRIOS
if(isset($_POST['entrar'])) {
    $conn = DBConecta();
    $login = mysqli_escape_string($conn, $_POST['login']);
    $senha = mysqli_escape_string($conn, $_POST['senha']);
    $cript = CriptografiaSenhas($senha);
    $tipoUsuario = ConfereTipoUsuario($conn, $login, $cript);
    
    if($tipoUsuario["tipo"]){
        $_SESSION["logado"] = true;
        $_SESSION["user"] = $login;
        $_SESSION["tipo"] = $tipoUsuario["tipo"];
        $_SESSION["id"] = $tipoUsuario["id"];
        $_SESSION["nome"] = $tipoUsuario['nome']." ".$tipoUsuario['sobrenome'];
        header("location: ./index.php");
    }   
    // DADOS INCORRETOS
    else{
        echo "<div class='alert alert-danger alert-dismissable status'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <strong>Usuário ou Senha inválida!</strong>
        </div>";
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
            <img class="mb-4" src="../img/Login1.png" alt="" width="150" height="150">
            <h3 class="h4 mb-3 font-weight-normal">Entrar na Plataforma online</h3>
            <input type="text" id="inputEmail" class="form-control mb-2 rounded" placeholder="Login" name="login" required autofocus>
            <input type="password" id="inputPassword" class="form-control rounded" placeholder="Senha" name="senha" required>
            <div class="checkbox mb-3">
                <label>
                    <a href="recupera.php">Esqueceu sua senha?</a>
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="entrar">Entrar</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2019</p>
        </form>
        <script src="../node_modules/jquery/dist/jquery.js"></script>
        <script src="../node_modules/popper.js/dist/umd/popper.js" crossorigin="anonymous"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.js" crossorigin="anonymous"></script>
    </body>
</html>
