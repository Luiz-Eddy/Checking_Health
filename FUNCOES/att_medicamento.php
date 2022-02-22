<?php 
    session_start();
    include_once("CONNECTION/connect.php");

    $nomemed = filter_input(INPUT_POST, 'nomemed', FILTER_SANITIZE_STRING);
    $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
    $dtini = filter_input(INPUT_POST, 'dtini', FILTER_SANITIZE_STRING);
    $dtini1 = implode('-', array_reverse(explode('/', $dtini)));
    $htini = filter_input(INPUT_POST, 'htini', FILTER_SANITIZE_STRING);
    $dterm = filter_input(INPUT_POST, 'dterm', FILTER_SANITIZE_STRING);
    $dterm1 = implode('-', array_reverse(explode('/', $dterm)));
    $hterm = filter_input(INPUT_POST, 'hterm', FILTER_SANITIZE_STRING);
    $frequencia = filter_input(INPUT_POST, 'frequencia', FILTER_SANITIZE_STRING);
    $diariamente = filter_input(INPUT_POST, 'diariamente', FILTER_SANITIZE_STRING);
    $semanalmente = filter_input(INPUT_POST, 'semanalmente', FILTER_SANITIZE_STRING);
    $inthoras = filter_input(INPUT_POST, 'inthoras', FILTER_SANITIZE_STRING);
    $intdias = filter_input(INPUT_POST, 'intdias', FILTER_SANITIZE_STRING);
    $intoutro = filter_input(INPUT_POST, 'intoutro', FILTER_SANITIZE_STRING);

    $id_usuario = $_SESSION['id'];
    $id_medicamento = $_GET['id'];

    // Valida acesso
    if (!empty($id_medicamento)) {
        $queryv1 = "SELECT * FROM medicamentos WHERE id = '$id_medicamento' AND id_usuario = '$id_usuario' LIMIT 1;";
        $verifica = mysqli_query($conn, $queryv1);
        $rowcount = mysqli_num_rows($verifica);
        if ($rowcount != 1) {
            $_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse medicamento 1</div>";
            header("Location: ../medicamentos.php");
            exit();
        }
    }else{
        $_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse medicamento 2</div>";
        header("Location: ../medicamentos.php");
        exit();
    }
    // Fim do valida acesso
    
    $query = "SELECT receita FROM info_medicamento WHERE id_medicamento = '$id_medicamento' LIMIT 1;";
    $exec = mysqli_query($conn, $query);
    
    //Pega arquivo atual
    $x = mysqli_fetch_object($exec);
    $receita = $x->receita;
    
    if (!empty($dterm)) {
        #Se a data de término for diferente de NULL
        if (!empty($hterm)) {
            #Se a hora de término for diferente de NULL
            if ($frequencia == 6) {
                # Se a frequência for igual a atual
                if($_FILES['arquivo']['error'] == 0){
                    date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
                    $name = $_FILES['arquivo']['name'];
                    $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
                    $dir = '../UPLOADS/RECEITAS/'; //Diretório para uploads
                    move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

                    // Remove arquivo antigo
                    unlink("../UPLOADS/RECEITAS/$receita");

                    //SQL TUDO MENOS FREQUENCIA
                    $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', hora_termino = '$hterm', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                    $insert = mysqli_query($conn, $sql);
                } else {
                    //SQL TUDO MENOS FREQUENCIA E RECEITA
                    $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', hora_termino = '$hterm' WHERE id_medicamento = '$id_medicamento';";
                    $insert = mysqli_query($conn, $sql);
                }
                if ($insert) {
                    $close_med = "UPDATE medicamentos SET status = 2 WHERE id = '$id_medicamento';";
                    $close = mysqli_query($conn, $sql);

                    $_SESSION['msg'] = "<div class='toast-cad-true'>Atualização realizada com sucesso</div>";
                    header("Location: ../medicamentos.php");
                    exit();
                }else{
                    $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                    header("Location: ../medicamentos.php");
                    exit();
                }
            } else {
                # Se a frequência for diferente da atual
                if($_FILES['arquivo']['error'] == 0){
                    date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
                    $name = $_FILES['arquivo']['name'];
                    $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
                    $dir = '../UPLOADS/RECEITAS/'; //Diretório para uploads
                    move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

                    //SQL TUDO
                    if ($frequencia == 1) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', hora_termino = '$hterm', id_frequencia = '$frequencia', info_frequencia = '$diariamente', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else if ($frequencia == 2) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', hora_termino = '$hterm', id_frequencia = '$frequencia', info_frequencia = '$semanalmente', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else if ($frequencia == 3) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', hora_termino = '$hterm', id_frequencia = '$frequencia', info_frequencia = '$inthoras', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else if ($frequencia == 4) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', hora_termino = '$hterm', id_frequencia = '$frequencia', info_frequencia = '$intdias', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else if ($frequencia == 5) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', hora_termino = '$hterm', id_frequencia = '$frequencia', info_frequencia = '$intoutro', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else{
                        unlink("../UPLOADS/RECEITAS/$new_name");
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                        header("Location: ../medicamentos.php");
                    }
                    if ($insert) {
                        $close_med = "UPDATE medicamentos SET status = 2 WHERE id = '$id_medicamento';";
                        $close = mysqli_query($conn, $sql);

                        $_SESSION['msg'] = "<div class='toast-cad-true'>Atualização realizada com sucesso</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                } else {
                    //SQL TUDO MENOS RECEITA
                    if ($frequencia == 1) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', hora_termino = '$hterm', id_frequencia = '$frequencia', info_frequencia = '$diariamente' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else if ($frequencia == 2) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', hora_termino = '$hterm', id_frequencia = '$frequencia', info_frequencia = '$semanalmente' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else if ($frequencia == 3) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', hora_termino = '$hterm', id_frequencia = '$frequencia', info_frequencia = '$inthoras' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else if ($frequencia == 4) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', hora_termino = '$hterm', id_frequencia = '$frequencia', info_frequencia = '$intdias' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else if ($frequencia == 5) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', hora_termino = '$hterm', id_frequencia = '$frequencia', info_frequencia = '$intoutro' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                        header("Location: ../medicamentos.php");
                    }
                    if ($insert) {
                        $close_med = "UPDATE medicamentos SET status = 2 WHERE id = '$id_medicamento';";
                        $close = mysqli_query($conn, $sql);

                        $_SESSION['msg'] = "<div class='toast-cad-true'>Atualização realizada com sucesso</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                }
            }
        } else {
            #Se a hora de término for NULL
            if ($frequencia == 6) {
                # Se a frequência for igual a atual
                if($_FILES['arquivo']['error'] == 0){
                    date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
                    $name = $_FILES['arquivo']['name'];
                    $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
                    $dir = '../UPLOADS/RECEITAS/'; //Diretório para uploads
                    move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

                    // Remove arquivo antigo
                    unlink("../UPLOADS/RECEITAS/$receita");

                    //SQL TUDO MENOS FREQUENCIA E HORA DE TÉRMINO
                    $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                    $insert = mysqli_query($conn, $sql);
                } else {
                    //SQL TUDO MENOS FREQUENCIA, RECEITA E HORA DE TÉRMINO
                    $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1' WHERE id_medicamento = '$id_medicamento';";
                    $insert = mysqli_query($conn, $sql);
                }
                if ($insert) {
                    $close_med = "UPDATE medicamentos SET status = 2 WHERE id = '$id_medicamento';";
                    $close = mysqli_query($conn, $sql);

                    $_SESSION['msg'] = "<div class='toast-cad-true'>Atualização realizada com sucesso</div>";
                    header("Location: ../medicamentos.php");
                    exit();
                }else{
                    $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                    header("Location: ../medicamentos.php");
                    exit();
                }
            } else {
                # Se a frequência for diferente da atual
                if($_FILES['arquivo']['error'] == 0){
                    date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
                    $name = $_FILES['arquivo']['name'];
                    $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
                    $dir = '../UPLOADS/RECEITAS/'; //Diretório para uploads
                    move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

                    //SQL TUDO MENOS HORA DE TÉRMINO
                    if ($frequencia == 1) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', id_frequencia = '$frequencia', info_frequencia = '$diariamente', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else if ($frequencia == 2) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', id_frequencia = '$frequencia', info_frequencia = '$semanalmente', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else if ($frequencia == 3) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', id_frequencia = '$frequencia', info_frequencia = '$inthoras', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else if ($frequencia == 4) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', id_frequencia = '$frequencia', info_frequencia = '$intdias', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else if ($frequencia == 5) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', id_frequencia = '$frequencia', info_frequencia = '$intoutro', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else{
                        unlink("../UPLOADS/RECEITAS/$new_name");
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                        header("Location: ../medicamentos.php");
                    }
                    if ($insert) {
                        $close_med = "UPDATE medicamentos SET status = 2 WHERE id = '$id_medicamento';";
                        $close = mysqli_query($conn, $sql);

                        $_SESSION['msg'] = "<div class='toast-cad-true'>Atualização realizada com sucesso</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                } else {
                    //SQL TUDO MENOS RECEITA E HORA DE TÉRMINO
                    if ($frequencia == 1) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', id_frequencia = '$frequencia', info_frequencia = '$diariamente' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else if ($frequencia == 2) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', id_frequencia = '$frequencia', info_frequencia = '$semanalmente' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else if ($frequencia == 3) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', id_frequencia = '$frequencia', info_frequencia = '$inthoras' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else if ($frequencia == 4) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', id_frequencia = '$frequencia', info_frequencia = '$intdias' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else if ($frequencia == 5) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', data_termino = '$dterm1', id_frequencia = '$frequencia', info_frequencia = '$intoutro' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                        header("Location: ../medicamentos.php");
                    }
                    if ($insert) {
                        $close_med = "UPDATE medicamentos SET status = 2 WHERE id = '$id_medicamento';";
                        $close = mysqli_query($conn, $sql);

                        $_SESSION['msg'] = "<div class='toast-cad-true'>Atualização realizada com sucesso</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                }
            }
        }
    } else {
        #Se a data de término for NULL
        if (!empty($hterm)) {
            #Se a hora de término for diferente de NULL
            if ($frequencia == 6) {
                # Se a frequência for igual a atual
                if($_FILES['arquivo']['error'] == 0){
                    date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
                    $name = $_FILES['arquivo']['name'];
                    $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
                    $dir = '../UPLOADS/RECEITAS/'; //Diretório para uploads
                    move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

                    // Remove arquivo antigo
                    unlink("../UPLOADS/RECEITAS/$receita");

                    //SQL TUDO MENOS DATA DE TÉRMINO E FREQUENCIA
                    $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                    $insert = mysqli_query($conn, $sql);
                } else {
                    //SQL TUDO MENOS DATA DE TÉRMINO, FREQUENCIA E RECEITA
                    $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini' WHERE id_medicamento = '$id_medicamento';";
                    $insert = mysqli_query($conn, $sql);
                }
                if ($insert) {
                    $close_med = "UPDATE medicamentos SET status = 2 WHERE id = '$id_medicamento';";
                    $close = mysqli_query($conn, $sql);

                    $_SESSION['msg'] = "<div class='toast-cad-true'>Atualização realizada com sucesso</div>";
                    header("Location: ../medicamentos.php");
                    exit();
                }else{
                    $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                    header("Location: ../medicamentos.php");
                    exit();
                }
            } else {
                # Se a frequência for diferente da atual
                if($_FILES['arquivo']['error'] == 0){
                    date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
                    $name = $_FILES['arquivo']['name'];
                    $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
                    $dir = '../UPLOADS/RECEITAS/'; //Diretório para uploads
                    move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

                    // Remove arquivo antigo
                    unlink("../UPLOADS/RECEITAS/$receita");

                    //SQL TUDO MENOS DATA DE TÉRMINO
                    if ($frequencia == 1) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$diariamente', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else if ($frequencia == 2) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$semanalmente', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else if ($frequencia == 3) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$inthoras', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else if ($frequencia == 4) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$intdias', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else if ($frequencia == 5) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$intoutro', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else{
                        unlink("../UPLOADS/RECEITAS/$new_name");
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                        header("Location: ../medicamentos.php");
                    }
                    if ($insert) {
                        $close_med = "UPDATE medicamentos SET status = 2 WHERE id = '$id_medicamento';";
                        $close = mysqli_query($conn, $sql);

                        $_SESSION['msg'] = "<div class='toast-cad-true'>Atualização realizada com sucesso</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                } else {
                    //SQL TUDO MENOS DATA DE TÉRMINO E RECEITA
                    if ($frequencia == 1) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$diariamente' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else if ($frequencia == 2) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$semanalmente' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else if ($frequencia == 3) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$inthoras' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else if ($frequencia == 4) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$intdias' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else if ($frequencia == 5) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$intoutro' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                        header("Location: ../medicamentos.php");
                    }
                    if ($insert) {
                        $close_med = "UPDATE medicamentos SET status = 2 WHERE id = '$id_medicamento';";
                        $close = mysqli_query($conn, $sql);

                        $_SESSION['msg'] = "<div class='toast-cad-true'>Atualização realizada com sucesso</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                }
                $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                header("Location: ../medicamentos.php");
                exit();
            }
            $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
            header("Location: ../medicamentos.php");
            exit();
        }else{
            #Se a hora de término for NULL
            if ($frequencia == 6) {
                # Se a frequência for igual a atual
                if($_FILES['arquivo']['error'] == 0){
                    date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
                    $name = $_FILES['arquivo']['name'];
                    $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
                    $dir = '../UPLOADS/RECEITAS/'; //Diretório para uploads
                    move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

                    // Remove arquivo antigo
                    unlink("../UPLOADS/RECEITAS/$receita");

                    //SQL TUDO MENOS DATA DE TÉRMINO E FREQUENCIA
                    $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                    $insert = mysqli_query($conn, $sql);
                } else {
                    //SQL TUDO MENOS DATA DE TÉRMINO, FREQUENCIA E RECEITA
                    $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini' WHERE id_medicamento = '$id_medicamento';";
                    $insert = mysqli_query($conn, $sql);
                }
                if ($insert) {
                    $close_med = "UPDATE medicamentos SET status = 2 WHERE id = '$id_medicamento';";
                    $close = mysqli_query($conn, $sql);

                    $_SESSION['msg'] = "<div class='toast-cad-true'>Atualização realizada com sucesso</div>";
                    header("Location: ../medicamentos.php");
                    exit();
                }else{
                    $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                    header("Location: ../medicamentos.php");
                    exit();
                }
            } else {
                # Se a frequência for diferente da atual
                if($_FILES['arquivo']['error'] == 0){
                    date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
                    $name = $_FILES['arquivo']['name'];
                    $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
                    $dir = '../UPLOADS/RECEITAS/'; //Diretório para uploads
                    move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

                    // Remove arquivo antigo
                    unlink("../UPLOADS/RECEITAS/$receita");

                    //SQL TUDO MENOS DATA DE TÉRMINO
                    if ($frequencia == 1) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$diariamente', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else if ($frequencia == 2) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$semanalmente', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else if ($frequencia == 3) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$inthoras', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else if ($frequencia == 4) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$intdias', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else if ($frequencia == 5) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$intoutro', receita = '$new_name' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                        // Remove arquivo antigo
                        unlink("../UPLOADS/RECEITAS/$receita");
                    }else{
                        unlink("../UPLOADS/RECEITAS/$new_name");
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                        header("Location: ../medicamentos.php");
                    }
                    if ($insert) {
                        $close_med = "UPDATE medicamentos SET status = 2 WHERE id = '$id_medicamento';";
                        $close = mysqli_query($conn, $sql);

                        $_SESSION['msg'] = "<div class='toast-cad-true'>Atualização realizada com sucesso</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                } else {
                    //SQL TUDO MENOS DATA DE TÉRMINO E RECEITA
                    if ($frequencia == 1) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$diariamente' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else if ($frequencia == 2) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$semanalmente' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else if ($frequencia == 3) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$inthoras' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else if ($frequencia == 4) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$intdias' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else if ($frequencia == 5) {
                        $sql = "UPDATE info_medicamento SET nome_medicamento = '$nomemed', observacoes = '$desc', data_inicio = '$dtini1', hora_inicio = '$htini', id_frequencia = '$frequencia', info_frequencia = '$intoutro' WHERE id_medicamento = '$id_medicamento';";
                        $insert = mysqli_query($conn, $sql);
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                        header("Location: ../medicamentos.php");
                    }
                    if ($insert) {
                        $close_med = "UPDATE medicamentos SET status = 2 WHERE id = '$id_medicamento';";
                        $close = mysqli_query($conn, $sql);

                        $_SESSION['msg'] = "<div class='toast-cad-true'>Atualização realizada com sucesso</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }else{
                        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
                        header("Location: ../medicamentos.php");
                        exit();
                    }
                }
            }
        }
        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
        header("Location: ../medicamentos.php");
        exit();
    }
    $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar medicamento</div>";
    header("Location: ../medicamentos.php");
    exit();
?>