<?php
  session_start();
  include_once("CONNECTION/connect.php");

  if (isset($_POST['emailRecupera']) | isset($_POST['codeRecupera'])) {
    $email = strip_tags(filter_input(INPUT_POST, 'emailRecupera', FILTER_SANITIZE_STRING));
    $code = strip_tags(filter_input(INPUT_POST, 'codeRecupera', FILTER_SANITIZE_STRING));

    $sql = "SELECT * FROM usuarios WHERE email = '$email';";
    $verificar = mysqli_query($conn,$sql);

    $sql1 = "SELECT * FROM recovery_codes WHERE code = '$code';";
    $verificar1 = mysqli_query($conn,$sql1);

    if(mysqli_num_rows($verificar) == 1 && mysqli_num_rows($verificar1) == 1){
      $x = mysqli_fetch_object($verificar);
      $id_user = $x->id_usuario;

      $valida_infos = "SELECT * FROM recovery_codes WHERE id_usuario = '$id_user' AND code = '$code';";
      $verificar2 = mysqli_query($conn,$valida_infos);

      if (mysqli_num_rows($verificar2) == 1) {
        $att_processo = "DELETE recovery_codes WHERE id_usuario = '$id_user' AND code = '$code';";
        $exec_att = mysqli_query($conn,$att_processo);

        $_SESSION['msg'] = "<div class='toast-cad-true'>Resolvido!</div>";
        header("Location: ../login.php");
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