<?php 
  session_start();
  include_once("CONNECTION/connect.php");

  $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
  $sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_STRING);
  $rg = filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_STRING);
  $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
  $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
  $id_parentesco = filter_input(INPUT_POST, 'parentesco', FILTER_SANITIZE_STRING);
  $dt_nasc = filter_input(INPUT_POST, 'dtnasc', FILTER_SANITIZE_STRING);
  $dt_nasc1 = implode('-', array_reverse(explode('/', $dt_nasc)));
  $id_dependente = $_GET['id'];

  if($nome == "" || $nome == null){
    echo"<script language='javascript' type='text/javascript'>
    alert('O campo nome deve ser preenchido');window.location.href='../cadastro_dependente.php';</script>";
    
  }else{
    $query = "UPDATE dependente SET nome = '$nome', sobrenome = '$sobrenome', dt_nasc = '$dt_nasc1', rg = '$rg', cpf = '$cpf', telefone = '$telefone', id_parentesco = '$id_parentesco' WHERE id = '$id_dependente';";
    
    $insert = mysqli_query($conn, $query);

    if($insert){
      $_SESSION['msg'] = "<div class='toast-cad-true'>Dependente atualizado realizado com sucesso.</div>";
      header("Location: ../dependentes.php?id=$id_dependente");
      exit();
    }else{
      $_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao atualizar.</div>";
      header("Location: ../editar_dependente.php?id=$id_dependente");
      exit();
    }
  }
?>