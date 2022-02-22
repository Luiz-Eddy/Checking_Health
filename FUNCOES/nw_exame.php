<?php 
  session_start();
  include_once("CONNECTION/connect.php");

  $usuario_cad = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
  $dt_exam = filter_input(INPUT_POST, 'dtexam', FILTER_SANITIZE_STRING);
  $descricao = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
  $dt_exam1 = implode('-', array_reverse(explode('/', $dt_exam)));

  $id_usuario = $_SESSION['id'];

  if ($usuario_cad == $id_usuario) {
    $include = "INSERT INTO exames (id_usuario) VALUES ('$id_usuario');";
    $insert = mysqli_query($conn, $include);

  	// UPLOAD DE ARQUIVO
    if($_FILES['arquivo']['error'] == 0){
        		date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
        		$name = $_FILES['arquivo']['name'];
        		$new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
        		$dir = '../UPLOADS/'; //Diretório para uploads
  			    move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

           $include2 = "INSERT INTO info_exames (id_exames, descricao, data_exame, arquivo) VALUES (LAST_INSERT_ID(), '$descricao', '$dt_exam1', '$new_name');";
           $insert2 = mysqli_query($conn, $include2);

           if($insert && $insert2){
            $_SESSION['msg'] = "<div class='toast-cad-true'>Exame cadastrado com sucesso</div>";
            header("Location: ../exames.php");
            exit();
          }else{
            $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar o exame</div>";
            header("Location: ../cadastro_exame.php");
            exit();
          }
        }else{
          $include2 = "INSERT INTO info_exames (id_exames, descricao, data_exame) VALUES (LAST_INSERT_ID(), '$descricao', '$dt_exam1');";
          $insert2 = mysqli_query($conn, $include2);

          if($insert && $insert2){
            $_SESSION['msg'] = "<div class='toast-cad-true'>Exame cadastrado com sucesso</div>";
            header("Location: ../exames.php");
            exit();
          }else{
            $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar o exame</div>";
            header("Location: ../cadastro_exame.php");
            exit();
          }
        }
      }else{
        $include = "INSERT INTO exames (id_usuario, id_dependente) VALUES ('$id_usuario', '$usuario_cad');";
        $insert = mysqli_query($conn, $include);

  		// UPLOAD DE ARQUIVO
        if($_FILES['arquivo']['error'] == 0){
        		date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
        		$name = $_FILES['arquivo']['name'];
        		$new_name = date("Y.m.d-H.i.s") . " " . $name; //Definindo um novo nome para o arquivo
        		$dir = 'UPLOADS/'; //Diretório para uploads
  			move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

  			$include2 = "INSERT INTO info_exames (id_exames, descricao, data_exame, arquivo) VALUES (LAST_INSERT_ID(), '$descricao', '$dt_exam1', '$new_name');";
  			$insert2 = mysqli_query($conn, $include2);

  			if($insert && $insert2){
          $_SESSION['msg'] = "<div class='toast-cad-true'>Exame cadastrado com sucesso.</div>";
          header("Location: ../exames.php");
          exit();
        }else{
          $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar o exame.</div>";
          header("Location: ../cadastro_exame.php");
          exit();
        }
      }else{
        $include2 = "INSERT INTO info_exames (id_exames, descricao, data_exame) VALUES (LAST_INSERT_ID(), '$descricao', '$dt_exam1');";
        $insert2 = mysqli_query($conn, $include2);

        if($insert && $insert2){
          $_SESSION['msg'] = "<div class='toast-cad-true'>Exame cadastrado com sucesso.</div>";
          header("Location: ../exames.php");
          exit();
        }else{
          $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao cadastrar o exame.</div>";
          header("Location: ../cadastro_exame.php");
          exit();
        }
      }
    }
?>