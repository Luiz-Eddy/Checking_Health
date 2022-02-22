<?php 
  session_start();
  include_once("CONNECTION/connect.php");

  $id_usuario = $_SESSION['id'];
  $id_dependente = $_GET['id'];

  if (!empty($id_dependente)){
    $queryv = "SELECT * FROM dependente WHERE id = '$id_dependente' AND id_usuario = '$id_usuario' LIMIT 1;";
    $verifica = mysqli_query($conn, $queryv);

    $rowcount = mysqli_num_rows($verifica);

    if($rowcount == 1){
      $query = "DELETE FROM dependente WHERE id = '$id_dependente' AND id_usuario = '$id_usuario';";
      $delete = mysqli_query($conn, $query);

      if($delete){
        $_SESSION['msg'] = "<div class='toast-cad-true'>Dependente deletado com sucesso</div>";
        header("Location: ../dependentes.php");
        exit();
      } else {
        $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao remover dependente</div>";
        header("Location: ../dependentes.php");
        exit();
      }
    } else {
      $_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse dependente</div>";
      header("Location: ../dependentes.php"); 
      exit();  
    } 
  } else {
    $_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse dependente</div>";
    header("Location: ../dependentes.php");
    exit();
  }
?>