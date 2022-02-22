<?php 
  session_start();
  include_once("CONNECTION/connect.php");

  $id_usuario = $_SESSION['id'];
  $id_consulta = $_GET['id'];

  if (!empty($id_consulta)){
    $queryv = "SELECT * FROM consultas WHERE id = '$id_consulta' AND id_usuario = '$id_usuario' LIMIT 1;";
    $verifica = mysqli_query($conn, $queryv);

    $rowcount = mysqli_num_rows($verifica);

    if($rowcount == 1){
      $query = "DELETE FROM consultas WHERE id = '$id_consulta' AND id_usuario = '$id_usuario';";
      $delete = mysqli_query($conn, $query);

      $query2 = "DELETE FROM info_consultas WHERE id_consulta = '$id_consulta';";
      $delete2 = mysqli_query($conn, $query2);

      if($delete && $delete2){
        $_SESSION['msg'] = "<div class='toast-cad-true'>Consulta deletada com sucesso</div>";
        header("Location: ../consultas.php");
        exit();
      } else {
        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao remover consulta</div>";
        header("Location: ../consultas.php");
        exit();
      }
    } else {
      $_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos essa consulta</div>";
      header("Location: ../consultas.php"); 
      exit();  
    } 
  } else {
    $_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos essa consulta</div>";
    header("Location: ../consultas.php");
    exit();
  }
?>