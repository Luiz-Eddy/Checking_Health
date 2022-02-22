<?php
$servidor = "sql113.epizy.com";
$usuario = "epiz_26080745";
$senha = "H6CejyCtGemkjn";
$dbname = "epiz_26080745_pi";

//Criar a conexao
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

if(!$conn){
        die("Falha na conexao: " . mysqli_connect_error());
    }else{
        //echo "Conexao realizada com sucesso";
    }  

?>