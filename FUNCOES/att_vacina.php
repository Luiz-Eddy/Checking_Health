<?php 
  session_start();
  include_once("CONNECTION/connect.php");

  $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
  $nomevac = filter_input(INPUT_POST, 'nomevac', FILTER_SANITIZE_STRING);
  $local = filter_input(INPUT_POST, 'local', FILTER_SANITIZE_STRING);
  $dtvac = filter_input(INPUT_POST, 'dtvac', FILTER_SANITIZE_STRING);
  $dtvac1 = implode('-', array_reverse(explode('/', $dtvac)));
  $dtok = filter_input(INPUT_POST, 'dtok', FILTER_SANITIZE_STRING);
  $dtok1 = implode('-', array_reverse(explode('/', $dtok)));
  $obs = filter_input(INPUT_POST, 'obs', FILTER_SANITIZE_STRING);

  $id_usuario = $_SESSION['id'];
  $id_vacina = $_GET['id'];

  if (!empty($id_vacina)) {
    $queryv = "SELECT * FROM vacinacao WHERE id = '$id_vacina' AND id_usuario = '$id_usuario' LIMIT 1;";
    $verifica = mysqli_query($conn, $queryv);

    $x = mysqli_fetch_object($verifica);
    $name_arquivo = $x->arquivo;

    $rowcount = mysqli_num_rows($verifica);

    if ($rowcount == 1) {
      // UPLOAD DE ARQUIVO
      if($_FILES['arquivo']['error'] == 0){
        date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
        $name = $_FILES['arquivo']['name'];
        $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
        $dir = '../UPLOADS/'; //Diretório para uploads
        move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

        if (empty($dtok)) {
          $query = "UPDATE vacinacao SET vacina = '$nomevac', local_vacina = '$local', dt_ven = '$dtvac1', dt_dose = NULL, obs = '$obs', arquivo = '$new_name' WHERE id = '$id_vacina' AND id_usuario = '$id_usuario';";
          $exec = mysqli_query($conn, $query);
        }else{
          $query = "UPDATE vacinacao SET vacina = '$nomevac', local_vacina = '$local', dt_ven = '$dtvac1', dt_dose = '$dtok1', obs = '$obs', arquivo = '$new_name' WHERE id = '$id_vacina' AND id_usuario = '$id_usuario';";
          $exec = mysqli_query($conn, $query);
        }

        if ($query) {
          $_SESSION['msg'] = "<div class='toast-cad-true'>Vacinação atualizada com sucesso</div>";
          header("Location: ../vacinacao.php");
          unlink("../UPLOADS/$name_arquivo");
          exit();
        }else{
          $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar vacinação</div>";
          header("Location: ../vacinacao.php");
          exit();
        }
      }else{
        if (empty($dtok)) {
          $query = "UPDATE vacinacao SET vacina = '$nomevac', local_vacina = '$local', dt_ven = '$dtvac1', dt_dose = NULL, obs = '$obs' WHERE id = '$id_vacina' AND id_usuario = '$id_usuario';";
          $exec = mysqli_query($conn, $query);
        }else{
          $query = "UPDATE vacinacao SET vacina = '$nomevac', local_vacina = '$local', dt_ven = '$dtvac1', dt_dose = '$dtok1', obs = '$obs' WHERE id = '$id_vacina' AND id_usuario = '$id_usuario';";
          $exec = mysqli_query($conn, $query);
        }
        
        if ($query) {
          $_SESSION['msg'] = "<div class='toast-cad-true'>Vacinação atualizada com sucesso</div>";
          header("Location: ../vacinacao.php");
          exit();
        }else{
          $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar vacinação</div>";
          header("Location: ../vacinacao.php");
          exit();
        }
      }
    }else{
      $_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos essa vacinação</div>";
      header("Location: exames.php");
      exit();
    }
  }else{
    $_SESSION['msg'] = "<div class='toast-cad-false'>Vacinação não localizada</div>";
    header("Location: exames.php");
    exit();
  }
?>