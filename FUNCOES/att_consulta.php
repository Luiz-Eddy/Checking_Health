<?php 
  session_start();
  include_once("CONNECTION/connect.php");

  $nomecons = filter_input(INPUT_POST, 'nomecons', FILTER_SANITIZE_STRING);
  $nomemed = filter_input(INPUT_POST, 'nomemed', FILTER_SANITIZE_STRING);
  $dtcons = filter_input(INPUT_POST, 'dtcons', FILTER_SANITIZE_STRING);
  $dtcons1 = implode('-', array_reverse(explode('/', $dtcons)));
  $dterm = filter_input(INPUT_POST, 'dterm', FILTER_SANITIZE_STRING);
  $dterm1 = implode('-', array_reverse(explode('/', $dterm)));
  $hrcons = filter_input(INPUT_POST, 'htcons', FILTER_SANITIZE_STRING);
  $hterm = filter_input(INPUT_POST, 'hterm', FILTER_SANITIZE_STRING);
  $lcons = filter_input(INPUT_POST, 'lcons', FILTER_SANITIZE_STRING);
  $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);

  $id_usuario = $_SESSION['id'];
  $id_consulta = $_GET['id'];

  // Valida acesso
  if (!empty($id_consulta)) {
    $queryv1 = "SELECT * FROM consultas WHERE id = '$id_consulta' AND id_usuario = '$id_usuario' LIMIT 1;";
    $verifica = mysqli_query($conn, $queryv1);
    $rowcount = mysqli_num_rows($verifica);
    if ($rowcount != 1) {
      $_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos essa consulta</div>";
      header("Location: ../consultas.php");
      exit();
    }
  }else{
    $_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos essa consulta</div>";
    header("Location: ../consultas.php");
    exit();
  }
  // Fim do valida acesso

  $query = "SELECT arquivo FROM info_consultas WHERE id_consulta = '$id_consulta' LIMIT 1;";
  $exec = mysqli_query($conn, $query);
    
  //Pega arquivo atual
  $x = mysqli_fetch_object($exec);
  $arquivo = $x->arquivo;

  if (!empty($dterm)) {
    #SE A DATA DE TÉRMINO FOR DIFERENTE DE NULL
    if (!empty($hterm)) {
      #SE A HORA DE TÉRMINO FOR DIFERENTE DE NULL
      if($_FILES['arquivo']['error'] == 0){
            date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
            $name = $_FILES['arquivo']['name'];
            $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
            $dir = '../UPLOADS/'; //Diretório para uploads
            move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

            $sql1 = "UPDATE consultas SET status = 2 WHERE id = '$id_consulta' AND id_usuario = '$id_usuario';";
            $exec = mysqli_query($conn, $sql1);

            #SQL DE TUDO
            $sql = "UPDATE info_consultas SET nome_consulta = '$nomecons', nome_medico = '$nomemed', data_consulta = '$dtcons1', hora_consulta = '$hrcons', data_realizada = '$dterm1', hora_realizada = '$hterm', local = '$lcons', descricao = '$desc', arquivo = '$new_name' WHERE id_consulta = '$id_consulta';";
            $insert = mysqli_query($conn, $sql);
        }else{
          $sql1 = "UPDATE consultas SET status = 2 WHERE id = '$id_consulta' AND id_usuario = '$id_usuario';";
          $exec = mysqli_query($conn, $sql1);

          #SQL DE TUDO MENOS ARQUIVO
          $sql = "UPDATE info_consultas SET nome_consulta = '$nomecons', nome_medico = '$nomemed', data_consulta = '$dtcons1', hora_consulta = '$hrcons', data_realizada = '$dterm1', hora_realizada = '$hterm', local = '$lcons', descricao = '$desc' WHERE id_consulta = '$id_consulta';";
            $insert = mysqli_query($conn, $sql);
        }
        if($insert && $exec){
          // Remove arquivo antigo
          unlink("../UPLOADS/RECEITAS/$arquivo");

          $_SESSION['msg'] = "<div class='toast-cad-true'>Cosulta atualizada com sucesso. 1</div>";
          header("Location: ../consultas.php");
          exit();
        }else{
          $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar a consulta. 1</div>";
          header("Location: ../consultas.php");
          exit();
        }
    }else{
      #SE A HORA DE TÉRMINO FOR NULL
      if($_FILES['arquivo']['error'] == 0){
            date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
            $name = $_FILES['arquivo']['name'];
            $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
            $dir = '../UPLOADS/'; //Diretório para uploads
            move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

            $sql1 = "UPDATE consultas SET status = 2 WHERE id = '$id_consulta' AND id_usuario = '$id_usuario';";
            $exec = mysqli_query($conn, $sql1);

            #SQL DE TUDO
            $sql = "UPDATE info_consultas SET nome_consulta = '$nomecons', nome_medico = '$nomemed', data_consulta = '$dtcons1', hora_consulta = '$hrcons', data_realizada = '$dterm1', local = '$lcons', descricao = '$desc', arquivo = '$new_name' WHERE id_consulta = '$id_consulta';";
            $insert = mysqli_query($conn, $sql);
        }else{
          $sql1 = "UPDATE consultas SET status = 2 WHERE id = '$id_consulta' AND id_usuario = '$id_usuario';";
          $exec = mysqli_query($conn, $sql1);

          #SQL DE TUDO MENOS ARQUIVO
          $sql = "UPDATE info_consultas SET nome_consulta = '$nomecons', nome_medico = '$nomemed', data_consulta = '$dtcons1', hora_consulta = '$hrcons', data_realizada = '$dterm1', local = '$lcons', descricao = '$desc' WHERE id_consulta = '$id_consulta';";
            $insert = mysqli_query($conn, $sql);
        }
        if($insert && $exec){
          // Remove arquivo antigo
          unlink("../UPLOADS/RECEITAS/$arquivo");

          $_SESSION['msg'] = "<div class='toast-cad-true'>Cosulta atualizada com sucesso. 2</div>";
          header("Location: ../consultas.php");
          exit();
        }else{
          $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar a consulta. 2</div>";
          header("Location: ../consultas.php");
          exit();
        }
    }
  }else{
    #SE A DATA DE TÉRMINO FOR NULL
    if (!empty($hterm)) {
      #SE A HORA DE TÉRMINO FOR DIFERENTE DE NULL
      if($_FILES['arquivo']['error'] == 0){
            date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
            $name = $_FILES['arquivo']['name'];
            $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
            $dir = '../UPLOADS/'; //Diretório para uploads
            move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

            $sql1 = "UPDATE consultas SET status = 2 WHERE id = '$id_consulta' AND id_usuario = '$id_usuario';";
            $exec = mysqli_query($conn, $sql1);

            #SQL DE TUDO
            $sql = "UPDATE info_consultas SET nome_consulta = '$nomecons', nome_medico = '$nomemed', data_consulta = '$dtcons1', hora_consulta = '$hrcons', hora_realizada = '$hterm', local = '$lcons', descricao = '$desc', arquivo = '$new_name' WHERE id_consulta = '$id_consulta';";
            $insert = mysqli_query($conn, $sql);
        }else{
          $sql1 = "UPDATE consultas SET status = 2 WHERE id = '$id_consulta' AND id_usuario = '$id_usuario';";
          $exec = mysqli_query($conn, $sql1);

          #SQL DE TUDO MENOS ARQUIVO
          $sql = "UPDATE info_consultas SET nome_consulta = '$nomecons', nome_medico = '$nomemed', data_consulta = '$dtcons1', hora_consulta = '$hrcons', hora_realizada = '$hterm', local = '$lcons', descricao = '$desc' WHERE id_consulta = '$id_consulta';";
            $insert = mysqli_query($conn, $sql);
        }
        if($insert && $exec){
          // Remove arquivo antigo
          unlink("../UPLOADS/RECEITAS/$arquivo");

          $_SESSION['msg'] = "<div class='toast-cad-true'>Cosulta atualizada com sucesso. 3</div>";
          header("Location: ../consultas.php");
          exit();
        }else{
          $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar a consulta. 3</div>";
          header("Location: ../consultas.php");
          exit();
        }
    }else{
      #SE A HORA DE TÉRMINO FOR NULL
      if($_FILES['arquivo']['error'] == 0){
            date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
            $name = $_FILES['arquivo']['name'];
            $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
            $dir = '../UPLOADS/'; //Diretório para uploads
            move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

            $sql1 = "UPDATE consultas SET status = 1 WHERE id = '$id_consulta' AND id_usuario = '$id_usuario';";
           $exec = mysqli_query($conn, $sql1);

            #SQL DE TUDO
            $sql = "UPDATE info_consultas SET nome_consulta = '$nomecons', nome_medico = '$nomemed', data_consulta = '$dtcons1', hora_consulta = '$hrcons', local = '$lcons', descricao = '$desc', arquivo = '$new_name' WHERE id_consulta = '$id_consulta';";
            $insert = mysqli_query($conn, $sql);
        }else{
          $sql1 = "UPDATE consultas SET status = 1 WHERE id = '$id_consulta' AND id_usuario = '$id_usuario';";
          $exec = mysqli_query($conn, $sql1);

          #SQL DE TUDO MENOS ARQUIVO
          $sql = "UPDATE info_consultas SET nome_consulta = '$nomecons', nome_medico = '$nomemed', data_consulta = '$dtcons1', hora_consulta = '$hrcons', local = '$lcons', descricao = '$desc' WHERE id_consulta = '$id_consulta';";
            $insert = mysqli_query($conn, $sql);
        }
        if($insert && $exec){
          // Remove arquivo antigo
          unlink("../UPLOADS/RECEITAS/$arquivo");

          $_SESSION['msg'] = "<div class='toast-cad-true'>Cosulta atualizada com sucesso. 4</div>";
          header("Location: ../consultas.php");
          exit();
        }else{
          $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar a consulta. 4</div>";
          header("Location: ../consultas.php");
          exit();
        }
    }
  }
?>