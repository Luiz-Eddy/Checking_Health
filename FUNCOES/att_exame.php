<?php 
  session_start();
  include_once("CONNECTION/connect.php");

  $usuario_cad = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
  $dt_exam = filter_input(INPUT_POST, 'dtexam', FILTER_SANITIZE_STRING);
  $descricao = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
  $dt_exam1 = implode('-', array_reverse(explode('/', $dt_exam)));

  $id_usuario = $_SESSION['id'];
  $id_exame = $_GET['id'];
  $id_att = $_GET['idatt'];

  if (!empty($id_exame) && !empty($id_att)) {
    $queryv = "SELECT * FROM exames WHERE id = '$id_exame' AND id_usuario = '$id_usuario' LIMIT 1;";
    $verifica = mysqli_query($conn, $queryv);

    $rowcount = mysqli_num_rows($verifica);

    if ($rowcount == 1) {
      $queryv1 = "SELECT * FROM info_exames WHERE id = '$id_att'";
      $verifica1 = mysqli_query($conn, $queryv1);

      $x = mysqli_fetch_object($verifica1);
      $name_arquivo = $x->arquivo;

      $rowcount1 = mysqli_num_rows($verifica1);

      if ($rowcount1 == 1) {
        // UPLOAD DE ARQUIVO
        if($_FILES['arquivo']['error'] == 0){
            date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
            $name = $_FILES['arquivo']['name'];
            $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
            $dir = '../UPLOADS/'; //Diretório para uploads
        move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

        unlink("../UPLOADS/$name_arquivo");

        $atualiza_info = "UPDATE info_exames SET data_exame = '$dt_exam1', descricao = '$descricao', arquivo = '$new_name' WHERE id = '$id_att';";
        $atualiza_info_exec = mysqli_query($conn, $atualiza_info);

        if ($usuario_cad == $id_usuario) {
          $atualiza_exam = "UPDATE exames SET id_usuario = '$usuario_cad', id_dependente = NULL WHERE id = '$id_exame';";
          $atualiza_exam_exec = mysqli_query($conn, $atualiza_exam);
        }else{
          $atualiza_exam = "UPDATE exames SET id_usuario = '$id_usuario', id_dependente = '$usuario_cad' WHERE id = '$id_exame';";
          $atualiza_exam_exec = mysqli_query($conn, $atualiza_exam);
        }

        if($atualiza_info_exec && $atualiza_exam_exec){
          $_SESSION['msg'] = "<div class='toast-cad-true'>Exame atualizado com sucesso</div>";
          header("Location: ../info_exame.php?id=$id_exame");
          exit();
        }else{
          $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar o exame</div>";
          header("Location: ../editar_exame.php?id=$id_exame&idatt=$id_att");
          exit();
        }
      }else{
       $atualiza_info = "UPDATE info_exames SET data_exame = '$dt_exam1', descricao = '$descricao' WHERE id = '$id_att';";
       $atualiza_info_exec = mysqli_query($conn, $atualiza_info);
       if ($usuario_cad == $id_usuario) {
        $atualiza_exam = "UPDATE exames SET id_usuario = '$usuario_cad', id_dependente = NULL WHERE id = '$id_exame';";
        $atualiza_exam_exec = mysqli_query($conn, $atualiza_exam);
      }else{
        $atualiza_exam = "UPDATE exames SET id_dependente = '$usuario_cad' WHERE id = '$id_exame';";
        $atualiza_exam_exec = mysqli_query($conn, $atualiza_exam);
      }

      if($atualiza_info_exec && $atualiza_exam_exec){
        $_SESSION['msg'] = "<div class='toast-cad-true'>Exame atualizado com sucesso</div>";
        header("Location: ../info_exame.php?id=$id_exame");
        exit();
      }else{
        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar o exame</div>";
        header("Location: ../editar_exame.php?id=$id_exame&idatt=$id_att");
        exit();
      }
    }
  }else{
    $_SESSION['msg'] = "<div class='toast-cad-false'>Informações do exame não localizadas</div>";
    header("Location: exames.php");
    exit();
  }
  }else{
    $_SESSION['msg'] = "<div class='toast-cad-false'>Informações do exame não localizadas</div>";
    header("Location: exames.php");
    exit();
  }
  }else{
    $_SESSION['msg'] = "<div class='toast-cad-false'>Informações do exame não localizadas</div>";
    header("Location: exames.php");
    exit();
  }
?>