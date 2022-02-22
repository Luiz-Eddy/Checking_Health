<?php 
    session_start();
    include_once("CONNECTION/connect.php");

    $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
    $nomecons = filter_input(INPUT_POST, 'nomecons', FILTER_SANITIZE_STRING);
    $nomemed = filter_input(INPUT_POST, 'nomemed', FILTER_SANITIZE_STRING);
    $dtcons = filter_input(INPUT_POST, 'dtcons', FILTER_SANITIZE_STRING);
    $dtcons1 = implode('-', array_reverse(explode('/', $dtcons)));
    $hrcons = filter_input(INPUT_POST, 'htcons', FILTER_SANITIZE_STRING);
    $lcons = filter_input(INPUT_POST, 'lcons', FILTER_SANITIZE_STRING);
    $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);

    $id_usuario = $_SESSION['id'];

    if ($user == $id_usuario) {
        $include = "INSERT INTO consultas (id_usuario, status) VALUES ('$id_usuario', 1);";
        $insert = mysqli_query($conn, $include);

        if($_FILES['arquivo']['error'] == 0){
            date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
            $name = $_FILES['arquivo']['name'];
            $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
            $dir = '../UPLOADS/'; //Diretório para uploads
            move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

            $include2 = "INSERT INTO info_consultas (id_consulta, nome_consulta, nome_medico, data_consulta, hora_consulta, local, descricao, arquivo) VALUES (LAST_INSERT_ID(), '$nomecons', '$nomemed', '$dtcons1', '$hrcons', '$lcons', '$desc', '$new_name');";
            $insert2 = mysqli_query($conn, $include2);
        }else{
            $include2 = "INSERT INTO info_consultas (id_consulta, nome_consulta, nome_medico, data_consulta, hora_consulta, local, descricao) VALUES (LAST_INSERT_ID(), '$nomecons', '$nomemed', '$dtcons1', '$hrcons', '$lcons', '$desc');";
            $insert2 = mysqli_query($conn, $include2);
        }
        if($insert && $insert2){
            $_SESSION['msg'] = "<div class='toast-cad-true'>Cadastro da consulta realizado com sucesso.</div>";
            header("Location: ../consultas.php");
            exit();
        }else{
            $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar a consulta.</div>";
            header("Location: ../consultas.php");
            exit();
        }
    }else{
        $include = "INSERT INTO consultas (id_usuario, id_dependente, status) VALUES ('$id_usuario', '$user', 1);";
         $insert = mysqli_query($conn, $include);

        if($_FILES['arquivo']['error'] == 0){
            date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
            $name = $_FILES['arquivo']['name'];
            $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
            $dir = '../UPLOADS/'; //Diretório para uploads
            move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

            $include2 = "INSERT INTO info_consultas (id_consulta, nome_consulta, nome_medico, data_consulta, hora_consulta, local, descricao, arquivo) VALUES (LAST_INSERT_ID(), '$nomecons', '$nomemed', '$dtcons1', '$hrcons', '$lcons', '$desc', '$new_name');";
            $insert2 = mysqli_query($conn, $include2);
        }else{
            $include2 = "INSERT INTO info_consultas (id_consulta, nome_consulta, nome_medico, data_consulta, hora_consulta, local, descricao) VALUES (LAST_INSERT_ID(), '$nomecons', '$nomemed', '$dtcons1', '$hrcons', '$lcons', '$desc');";
            $insert2 = mysqli_query($conn, $include2);
        }
        if($insert && $insert2){
            $_SESSION['msg'] = "<div class='toast-cad-true'>Cadastro da consulta realizado com sucesso.</div>";
            header("Location: ../consultas.php");
            exit();
        }else{
            $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar a consulta.</div>";
            header("Location: ../consultas.php");
            exit();
        }
    }
?>
