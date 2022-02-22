<?php 
    session_start();
    include_once("CONNECTION/connect.php");

    $nomevac = filter_input(INPUT_POST, 'nomevac', FILTER_SANITIZE_STRING);
    $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
    $local = filter_input(INPUT_POST, 'local', FILTER_SANITIZE_STRING);
    $dtvac = filter_input(INPUT_POST, 'dtvac', FILTER_SANITIZE_STRING);
    $dtvac1 = implode('-', array_reverse(explode('/', $dtvac)));
    $obs = filter_input(INPUT_POST, 'obs', FILTER_SANITIZE_STRING);

    $id_usuario = $_SESSION['id'];

    if ($user == $id_usuario) {
      $include = "INSERT INTO vacinacao (vacina, local_vacina, dt_ven, obs, id_usuario) VALUES ('$nomevac', '$local', '$dtvac1', '$obs', '$user');";
      $insert = mysqli_query($conn, $include);

        if($insert){
            $_SESSION['msg'] = "<div class='toast-cad-true'>Cadastro realizado com sucesso.</div>";
            header("Location: ../vacinacao.php");
            exit();
        }else{
            $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar vacina.</div>";
            header("Location: ../cadastro_vacinacao.php");
            exit();
        }
    }else{
        $valida_dependente = "SELECT * FROM dependente WHERE id = '$user' AND id_usuario = '$id_usuario';";
        $exec_valida = mysqli_query($conn, $valida_dependente);
        if (mysqli_num_rows($exec_valida) < 1) {
            $_SESSION['msg'] = "<div class='toast-cad-false'>Dependente não localizado</div>";
            header("Location: ../cadastro_vacinacao.php");
            exit();
        }else{
            $include = "INSERT INTO vacinacao (vacina, local_vacina, dt_ven, obs, id_usuario, id_dependente) VALUES ('$nomevac', '$local', '$dtvac1', '$obs', '$id_usuario', '$user');";
            $insert = mysqli_query($conn, $include);
            if($insert){
                $_SESSION['msg'] = "<div class='toast-cad-true'>Cadastro realizado com sucesso.</div>";
                header("Location: ../vacinacao.php");
                exit();
            }else{
                $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar vacina.</div>";
                header("Location: ../cadastro_vacinacao.php");
                exit();
            }
        }
    }
?>