<?php 
  session_start();
  include_once("CONNECTION/connect.php");

  $id_usuario = $_SESSION['id'];
  $id_exame = $_GET['id'];

  if (!empty($id_exame)){
    $queryv = "SELECT * FROM exames WHERE id = '$id_exame' AND id_usuario = '$id_usuario' LIMIT 1;";
    $verifica = mysqli_query($conn, $queryv);

    $rowcount = mysqli_num_rows($verifica);

    if($rowcount == 1){
      $v_arc = "SELECT * FROM info_exames WHERE id_exames = $id_exame;";
      $exec_v = mysqli_query($conn, $v_arc);

      while ($x = mysqli_fetch_object($exec_v)) {
        $name_arquivo = $x->arquivo;
        unlink("../UPLOADS/$name_arquivo");
      }      

      $query = "DELETE FROM info_exames WHERE id_exames = '$id_exame';";
      $delete = mysqli_query($conn, $query);

      $query2 = "DELETE FROM exames WHERE id = '$id_exame';";
      $delete2 = mysqli_query($conn, $query2);

      if($delete && $delete2){
        $_SESSION['msg'] = "<div class='toast-cad-true'>Exame deletado com sucesso</div>";
        header("Location: ../exames.php");
        exit();
      } else {
        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao remover exame</div>";
        header("Location: ../exames.php");
        exit();
      }
    } else {
      $_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse exame</div>";
      header("Location: ../exames.php"); 
      exit();  
    } 
  } else {
    $_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse exame</div>";
    header("Location: ../exames.php");
    exit();
  }
?>
