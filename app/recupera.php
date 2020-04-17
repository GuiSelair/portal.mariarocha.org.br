<?php
//////////////////////////////////////
////        RECUPERA SENHA        ////
//////////////////////////////////////
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
        <div class="container-fluid text-center form-signin">
            <div class="col-sm-12">
                <img class="mb-4" src="../img/Login1.png" alt="" width="150">
                <h3 class="h4 mb-3 font-weight-normal">Recuperação de Senha</h3>
                <input type="email" id="email" class="form-control rounded" placeholder="Email" name="email" required>
                <button class="btn btn-lg btn-primary btn-block mt-3" type="submit" name="envia" id="envia">Enviar</button>
                <a href="./loginUser.php" class="btn btn-lg btn-primary btn-block rounded" >Voltar</a>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#envia").on("click", function(){
                    let email = document.querySelector("#email").value;        
                    $.ajax({
                        type: "POST",
                        url: "controllers/enviaEmail.php",
                        data: "email="+email+"&tipo=portal",
                        beforeSend: function(){
                            $("#envia").html("Enviando...");
                        },
                        success: function(html){                                            
                            $(".status").html(html);
                            $("#envia").html("Enviar");
                            email = "";
                        }
                    });
                })
            })
        </script>
        <script src="../node_modules/jquery/dist/jquery.js"></script>
        <script src="../node_modules/popper.js/dist/umd/popper.js" crossorigin="anonymous"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.js" crossorigin="anonymous"></script>
    </body>
</html>
