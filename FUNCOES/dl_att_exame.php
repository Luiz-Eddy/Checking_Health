<?php 
  session_start();
  include_once("CONNECTION/connect.php");

  $id_usuario = $_SESSION['id'];
  $id_atualizacao = $_GET['id'];
  $id_exam = $_GET['ide'];

  if (!empty($id_atualizacao)){
    $queryv = "SELECT ie.*, e.id_usuario FROM info_exames as ie INNER JOIN exames as e ON ie.id_exames = e.id WHERE ie.id = '$id_atualizacao' AND e.id_usuario = '$id_usuario' LIMIT 1;";
    $verifica = mysqli_query($conn, $queryv);

    $rowcount = mysqli_num_rows($verifica);

    if($rowcount == 1){
      $queryv2 = "SELECT * FROM info_exames WHERE id_exames = $id_exam;";
      $exec = mysqli_query($conn, $queryv2);

      $rowcount1 = mysqli_num_rows($exec);

      if ($rowcount1 == 1){
        $_SESSION['msg'] = "<div class='toast-cad-false'>Não é possível deletar atualização</div>";
        header("Location: ../info_exame.php?id=$id_exam");
        exit();
      }else{
        $v_arc = "SELECT * FROM info_exames WHERE id = $id_atualizacao;";
        $exec_v = mysqli_query($conn, $v_arc);

        $x = mysqli_fetch_object($exec_v);
        $name_arquivo = $x->arquivo;

        $queryd = "DELETE FROM info_exames WHERE id = '$id_atualizacao';";
        $delete = mysqli_query($conn, $queryd);

        if($delete){
          unlink("../UPLOADS/$name_arquivo");

          $_SESSION['msg'] = "<div class='toast-cad-true'>Atualização deletada com sucesso</div>";
          header("Location: ../info_exame.php?id=$id_exam");
          exit();
        } else {
          $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao deletar atualização</div>";
          header("Location: ../info_exame.php?id=$id_exam");
          exit();
        }
      }
    } else {
      $_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos essa atualização</div>";
      header("Location: ../info_exame.php?id=$id_exam");   
      exit();
    } 
  } else {
    $_SESSION['msg'] = "<div class='toast-cad-false'>ERRO</div>";
    header("Location: ../exames.php");
    exit();
  }
?>
