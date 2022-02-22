<?php 
  session_start();
  include_once("CONNECTION/connect.php");

  $dt_exam = filter_input(INPUT_POST, 'dtexam', FILTER_SANITIZE_STRING);
  $descricao = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
  $dt_exam1 = implode('-', array_reverse(explode('/', $dt_exam)));

  $id_usuario = $_SESSION['id'];
  $id_exame = $_GET['id'];

  if (!empty($id_exame)) {
    $queryv = "SELECT * FROM exames WHERE id = '$id_exame' AND id_usuario = '$id_usuario' LIMIT 1;";
    $verifica = mysqli_query($conn, $queryv);

    $rowcount = mysqli_num_rows($verifica);

    if($rowcount == 1){

        // UPLOAD DE ARQUIVO
      if($_FILES['arquivo']['error'] == 0){
            date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
            $name = $_FILES['arquivo']['name'];
            $new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
            $dir = '../UPLOADS/'; //Diretório para uploads
            move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

            $include = "INSERT INTO info_exames (id_exames, descricao, data_exame, arquivo) VALUES ('$id_exame', '$descricao', '$dt_exam1', '$new_name');";
            $insert = mysqli_query($conn, $include);

            if($insert){
              $_SESSION['msg'] = "<div class='toast-cad-true'>Exame cadastrado com sucesso</div>";
              header("Location: ../info_exame.php?id=$id_exame");
              exit();
            }else{
              $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar o exame</div>";
              header("Location: ../atualizar_exame.php?id=$id_exame");
              exit();
            }
          }else{
            $include = "INSERT INTO info_exames (id_exames, descricao, data_exame) VALUES ('$id_exame', '$descricao', '$dt_exam1');";
            $insert = mysqli_query($conn, $include);

            if($insert){
              $_SESSION['msg'] = "<div class='toast-cad-true'>Exame atualizado com sucesso</div>";
              header("Location: ../info_exame.php?id=$id_exame");
              exit();
            }else{
              $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar o exame</div>";
              header("Location: ../atualizar_exame.php?id=$id_exame");
              exit();
            }
          }
        }else {
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