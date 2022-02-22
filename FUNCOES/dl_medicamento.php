<?php 
  session_start();
  include_once("CONNECTION/connect.php");

  $id_usuario = $_SESSION['id'];
  $id_medicamento = $_GET['id'];

  if (!empty($id_medicamento)){
      $queryv = "SELECT * FROM medicamentos WHERE id = '$id_medicamento' AND id_usuario = '$id_usuario' LIMIT 1;";
      $verifica = mysqli_query($conn, $queryv);

      $rowcount = mysqli_num_rows($verifica);

      if($rowcount == 1){
        $queryv1 = mysqli_query($conn, "SELECT receita FROM info_medicamento INNER JOIN medicamentos ON info_medicamento.id_medicamento = medicamentos.id AND medicamentos.id = '$id_medicamento' AND medicamentos.id_usuario = '$id_usuario';");

        $x = mysqli_fetch_object($queryv1);
        $name_arquivo = $x->receita;

        unlink("../UPLOADS/RECEITAS/$name_arquivo");

        $query = "DELETE FROM medicamentos WHERE id = '$id_medicamento' AND id_usuario = '$id_usuario';";
        $delete = mysqli_query($conn, $query);

        if($delete){
          $_SESSION['msg'] = "<div class='toast-cad-true'>Medicamento deletado com sucesso</div>";
          header("Location: ../medicamentos.php");
          exit();
        } else {
          $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao remover medicamento</div>";
          header("Location: ../medicamentos.php");
          exit();
        }
      } else {
      $_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse medicamento</div>";
      header("Location: ../medicamentos.php");  
      exit(); 
      } 
  } else {
      $_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse medicamento</div>";
      header("Location: ../medicamentos.php");
      exit();
  }
?>