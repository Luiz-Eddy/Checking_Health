<?php 
  session_start();
  include_once("CONNECTION/connect.php");

  $id_usuario = $_SESSION['id'];
  $id_vacina = $_GET['id'];

  if (!empty($id_vacina)){
      $queryv = "SELECT * FROM vacinacao WHERE id = '$id_vacina' AND id_usuario = '$id_usuario' LIMIT 1;";
      $verifica = mysqli_query($conn, $queryv);

      $x = mysqli_fetch_object($verifica);
      $name_arquivo = $x->arquivo;

      $rowcount = mysqli_num_rows($verifica);

      if($rowcount == 1){
        $query = "DELETE FROM vacinacao WHERE id = '$id_vacina' AND id_usuario = '$id_usuario';";
        $delete = mysqli_query($conn, $query);

        if($delete){
          unlink("../UPLOADS/$name_arquivo");
          $_SESSION['msg'] = "<div class='toast-cad-true'>Vacina deletada com sucesso</div>";
          header("Location: ../vacinacao.php");
          exit();
        } else {
          $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao remover vacina</div>";
          header("Location: ../vacinacao.php");
          exit();
        }
      } else {
      $_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos essa vacina</div>";
      header("Location: ../vacinacao.php");  
      exit(); 
      } 
  } else {
      $_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos essa vacina</div>";
      header("Location: ../vacinacao.php");
      exit();
  }
?>