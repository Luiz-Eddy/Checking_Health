<?php
  session_start();
  include_once("CONNECTION/connect.php");

  if (isset($_POST['emailRecupera'])) {
    $email = strip_tags(filter_input(INPUT_POST, 'emailRecupera', FILTER_SANITIZE_STRING));
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $verificar = mysqli_query($conn,$sql);
    if(mysqli_num_rows($verificar) == 1){
      $codigo = rand(1111,9999);
      $multicode = "SELECT * FROM recovery_codes WHERE code = '$codigo';";
      $exec = mysqli_query($conn,$multicode);
      while (mysqli_num_rows($exec) >= 1) {
        $codigo = rand(1111,9999);
        $multicode = "SELECT * FROM recovery_codes WHERE code = '$codigo';";
        $exec = mysqli_query($conn,$multicode);
      }
      $x = mysqli_fetch_object($verificar);
      $id_user = $x->id_usuario;
      $email_user = $x->email;

      $verify = "SELECT * FROM recovery_codes WHERE id_usuario = '$id_user';";
      $execv = mysqli_query($conn,$verify);

      if (mysqli_num_rows($execv) >= 1) {
        $del_registry = "DELETE FROM recovery_codes WHERE id_usuario = '$id_user';";
        $delv = mysqli_query($conn,$del_registry);
      }

      $save_code = "INSERT INTO recovery_codes (id_usuario, code) VALUES ('$id_user', '$codigo');";
      $save = mysqli_query($conn,$save_code);

      ini_set('display_errors', 1);
      error_reporting(E_ALL);

      $from = "thecheckinghealth@gmail.com";
      $to = "$email_user";
      $subject = "Recuperação de Senha - Checking Health";
      $subject1 = utf8_decode($subject);
      $message = "<body>
      <img src='https://i.ibb.co/cD8jYg2/logo.png' width='250'/>
      <h3>Parece que perdeu o acesso a sua conta, vamos recuperá-la.<h3>
      <p>Esse é um e-mail para recuperação de senha do Checking Health</p>
      <h4>Seu código de recuperação de senha é: $codigo</h4>
      <p><a href='http://checkinghealth.epizy.com/valida_reset.php?mail=$email_user'>Clique aqui para recuperar sua senha</a></p>
      <br>
      <p>Caso não tenha sido você, <a href='http://checkinghealth.epizy.com/del_code.php?mail=$email_user'>Clique aqui para resolver</a></p>
      </body>";
      $message1 = utf8_decode($message);
      $headers =  'MIME-Version: 1.0' . "\r\n"; 
      $headers .= 'From: '. $from . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
      mail($to, $subject1, $message1, $headers);
      
      $_SESSION['msg'] = "<div class='toast-cad-true'>Verifique seu e-mail</div>";
      header('Location: ../login.php');
      exit();
    }else{
      $_SESSION['msg'] = "<div class='toast-cad-false'>Não encontramos cadastros</div>";
      header('Location: ../login.php');
      exit();
    }
  }else{
    $_SESSION['msg'] = "<div class='toast-cad-false'>Insira um e-mail válido</div>";
    header('Location: ../login.php');
    exit();
  }
?>