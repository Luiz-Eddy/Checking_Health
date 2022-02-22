<?php
  session_start();
  include_once("CONNECTION/connect.php");

  if (isset($_POST['emailRecupera']) | isset($_POST['nova_senha'])) {
    $email = strip_tags(filter_input(INPUT_POST, 'emailRecupera', FILTER_SANITIZE_STRING));
    $nsenha = strip_tags(filter_input(INPUT_POST, 'nova_senha', FILTER_SANITIZE_STRING));
    $senha = md5($nsenha);

    $sql = "SELECT * FROM usuarios WHERE email = '$email';";
    $verificar = mysqli_query($conn,$sql);

    if(mysqli_num_rows($verificar) == 1){
      $x = mysqli_fetch_object($verificar);
      $id_user = $x->id_usuario;

      $valida_infos = "SELECT * FROM recovery_codes WHERE id_usuario = '$id_user' AND process = 1;";
      $verificar2 = mysqli_query($conn,$valida_infos);

      if (mysqli_num_rows($verificar2) == 1) {
        $att_processo = "DELETE FROM recovery_codes WHERE id_usuario = '$id_user' AND process = 1";
        $exec_att = mysqli_query($conn,$att_processo);

        $atualiza_senha = "UPDATE usuarios SET senha = '$senha' WHERE id_usuario = '$id_user' AND email = '$email';";
        $exec_att_senha = mysqli_query($conn,$atualiza_senha);

        $_SESSION['msg'] = "<div class='toast-cad-true'>Senha alterada com sucesso!</div>";
        header('Location: ../login.php');
        exit();
      }else{
        $_SESSION['msg'] = "<div class='toast-cad-false'>Informações incorretas</div>";
        header('Location: ../login.php');
        exit();
      }
    }else{
      $_SESSION['msg'] = "<div class='toast-cad-false'>Informações incorretas</div>";
      header('Location: ../login.php');
      exit();
    }
  }else{
    $_SESSION['msg'] = "<div class='toast-cad-false'>Informações incorretas</div>";
    header('Location: ../login.php');
    exit();
  }
?>