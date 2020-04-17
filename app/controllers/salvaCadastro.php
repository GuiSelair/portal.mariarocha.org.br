<?php

///////////////////////////////////////////////
////   SALVA CADASTROS (ADMINISTRADOR)    ////
/////////////////////////////////////////////

include_once("../conexao/conexao.php");
include_once("../conexao/config.php");
include_once("../../conexao/function.php");

$conexao = DBConecta();

// SALVA CADASTRO DE ADMINISTRADOR
if (isset($_POST["adminArray"]) && !empty($_POST["adminArray"])){
    $adminValues = $_POST["adminArray"];
    $error = false;

    // VALIDAÇÃO DO FORMULARIO
    foreach ($adminValues as $key => $value) {
        if (!ValidaString($value)){
            $error = true;
        }
        else if($key === 4 && !ValidaEmail($value)){
            $error = true;
        }
    }

    if (!$error){
        $cript = CriptografiaSenhas($adminValues[3]);
        $sql_code = "INSERT INTO `administrador`(`nome`, `sobrenome`, `login`, `senha`, `email`) VALUES ('".$adminValues[0]."','".$adminValues[1]."','".$adminValues[2]."','".$cript."','".$adminValues[4]."')";
        $query = mysqli_query($conexao, $sql_code);
        if ($query){
            echo "<div class='alert alert-success alert-dismissable' style='margin-bottom: 0px;'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Cadastro realizado com sucesso!</strong>
            </div>
            ";
        }
        else{
            echo "<div class='alert alert-danger alert-dismissable' style='margin-bottom: 0px;'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>ERRO! Verifique sua conexão.</strong>
            </div>
            ";
        }
    } 
    else{
        echo "<div class='alert alert-danger alert-dismissable' style='margin-bottom: 0px;'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <strong>Insira os dados corretamente!</strong>
        </div>
        ";
    }
}

?>