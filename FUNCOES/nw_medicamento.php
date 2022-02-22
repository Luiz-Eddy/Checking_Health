<?php 
    session_start();
    include_once("CONNECTION/connect.php");

    $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
    $nomemed = filter_input(INPUT_POST, 'nomemed', FILTER_SANITIZE_STRING);
    $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
    $dtini = filter_input(INPUT_POST, 'dtini', FILTER_SANITIZE_STRING);
    $dtini1 = implode('-', array_reverse(explode('/', $dtini)));
    $htini = filter_input(INPUT_POST, 'htini', FILTER_SANITIZE_STRING);
    $frequencia = filter_input(INPUT_POST, 'frequencia', FILTER_SANITIZE_STRING);
    $diariamente = filter_input(INPUT_POST, 'diariamente', FILTER_SANITIZE_STRING);
    $semanalmente = filter_input(INPUT_POST, 'semanalmente', FILTER_SANITIZE_STRING);
    $inthoras = filter_input(INPUT_POST, 'inthoras', FILTER_SANITIZE_STRING);
    $intdias = filter_input(INPUT_POST, 'intdias', FILTER_SANITIZE_STRING);
    $intoutro = filter_input(INPUT_POST, 'intoutro', FILTER_SANITIZE_STRING);

    $id_usuario = $_SESSION['id'];

    if ($user == $id_usuario) {
        if ($diariamente == "" && $semanalmente == "" && $inthoras == "" && $intdias == "" && $intoutro == "") {
            $_SESSION['msg'] = "<div class='toast-cad-false'>Nenhuma informação sobre a frequência foi informada</div>";
            header("Location: ../medicamentos.php");
            exit();
        }else{
            $include = "INSERT INTO medicamentos (id_usuario, status) VALUES ('$id_usuario', 1);";
            $insert = mysqli_query($conn, $include);
            
            if ($desc != "") {
                // UPLOAD DE ARQUIVO
                if($_FILES['arquivo']['error'] == 0){
                    date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
                    $name = $_FILES['arquivo']['name'];
                    $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
                    $dir = '../UPLOADS/RECEITAS/'; //Diretório para uploads
                    move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

                    if ($frequencia == 1) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$diariamente', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 2) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$semanalmente', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 3) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$inthoras', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 4) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$intdias', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 5) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$intoutro', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else{
                        unlink("../UPLOADS/RECEITAS/$new_name");
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                    if ($insert && $insert2) {
                        $_SESSION['msg'] = "<div class='toast-cad-true'>Cadastro realizado com sucesso</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                }else{
                    //CASO NÃO TENHA ARQUIVO
                    if ($frequencia == 1) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$diariamente');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 2) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$semanalmente');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 3) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$inthoras');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 4) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$intdias');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 5) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$intoutro');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                    if ($insert && $insert2) {
                        $_SESSION['msg'] = "<div class='toast-cad-true'>Cadastro realizado com sucesso</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                }
            }else{
                // UPLOAD DE ARQUIVO
                if($_FILES['arquivo']['error'] == 0){
                    date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
                    $name = $_FILES['arquivo']['name'];
                    $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
                    $dir = '../UPLOADS/RECEITAS/'; //Diretório para uploads
                    move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

                    if ($frequencia == 1) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$diariamente', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 2) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$semanalmente', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 3) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$inthoras', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 4) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$intdias', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 5) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$intoutro', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else{
                        unlink("../UPLOADS/RECEITAS/$new_name");
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                    if ($insert && $insert2) {
                        $_SESSION['msg'] = "<div class='toast-cad-true'>Cadastro realizado com sucesso</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                }else{
                    //CASO NÃO TENHA ARQUIVO
                    if ($frequencia == 1) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$diariamente');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 2) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$semanalmente');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 3) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$inthoras');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 4) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$intdias');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 5) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$intoutro');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                    if ($insert && $insert2) {
                        $_SESSION['msg'] = "<div class='toast-cad-true'>Cadastro realizado com sucesso</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                }
            }
        }
    }else{
    // SE FOR DEPENDENTE
        if ($diariamente == "" && $semanalmente == "" && $inthoras == "" && $intdias == "" && $intoutro == "") {
            $_SESSION['msg'] = "<div class='toast-cad-false'>Nenhuma informação sobre a frequência foi informada</div>";
            header("Location: ../medicamentos.php");
            exit();
        }else{
            $include = "INSERT INTO medicamentos (id_usuario, id_dependente, status) VALUES ('$id_usuario', '$user', 1);";
            $insert = mysqli_query($conn, $include);
            
            if ($desc != "") {
                // UPLOAD DE ARQUIVO
                if($_FILES['arquivo']['error'] == 0){
                    date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
                    $name = $_FILES['arquivo']['name'];
                    $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
                    $dir = '../UPLOADS/RECEITAS/'; //Diretório para uploads
                    move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

                    if ($frequencia == 1) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$diariamente', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 2) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$semanalmente', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 3) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$inthoras', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 4) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$intdias', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 5) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$intoutro', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else{
                        unlink("../UPLOADS/RECEITAS/$new_name");
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                    if ($insert && $insert2) {
                        $_SESSION['msg'] = "<div class='toast-cad-true'>Cadastro realizado com sucesso</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                }else{
                    //CASO NÃO TENHA ARQUIVO
                    if ($frequencia == 1) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$diariamente');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 2) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$semanalmente');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 3) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$inthoras');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 4) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$intdias');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 5) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, observacoes, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$desc', '$dtini1', '$htini', '$frequencia', '$intoutro');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                    if ($insert && $insert2) {
                        $_SESSION['msg'] = "<div class='toast-cad-true'>Cadastro realizado com sucesso</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                }
            }else{
                // UPLOAD DE ARQUIVO
                if($_FILES['arquivo']['error'] == 0){
                    date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
                    $name = $_FILES['arquivo']['name'];
                    $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
                    $dir = '../UPLOADS/RECEITAS/'; //Diretório para uploads
                    move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

                    if ($frequencia == 1) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$diariamente', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 2) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$semanalmente', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 3) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$inthoras', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 4) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$intdias', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 5) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia, receita) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$intoutro', '$new_name');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else{
                        unlink("../UPLOADS/RECEITAS/$new_name");
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                    if ($insert && $insert2) {
                        $_SESSION['msg'] = "<div class='toast-cad-true'>Cadastro realizado com sucesso</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                }else{
                    //CASO NÃO TENHA ARQUIVO
                    if ($frequencia == 1) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$diariamente');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 2) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$semanalmente');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 3) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$inthoras');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 4) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$intdias');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else if ($frequencia == 5) {
                        $include2 = "INSERT INTO info_medicamento (id_medicamento, nome_medicamento, data_inicio, hora_inicio, id_frequencia, info_frequencia) VALUES (LAST_INSERT_ID(), '$nomemed', '$dtini1', '$htini', '$frequencia', '$intoutro');";
                        $insert2 = mysqli_query($conn, $include2);
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                    if ($insert && $insert2) {
                        $_SESSION['msg'] = "<div class='toast-cad-true'>Cadastro realizado com sucesso</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                }
            }
        }
    }
?>