<?php
	session_start();
	include_once("CONNECTION/connect.php");

	$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
	$sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_STRING);
	$cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	$senha_limp = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
	$senha = md5($senha_limp);
	$rsenha = filter_input(INPUT_POST, 'rsenha', FILTER_SANITIZE_STRING);

	$result_usuario = "INSERT INTO usuarios (nome, sobrenome, cpf, email, senha) VALUES ('$nome', '$sobrenome', '$cpf ', 
	'$email','$senha')";
	$resultado_usuario = mysqli_query($conn, $result_usuario);


	if($nome == "" || $nome == null){
		$_SESSION['msg'] = "<div class='toast-cad-false'>O campo nome deve ser preenchido!</div>";
		header("Location: ../cadastrar.php");
		exit();
	}elseif($sobrenome == "" || $sobrenome == null){
		$_SESSION['msg'] = "<div class='toast-cad-false'>O campo sobrenome deve ser preenchido!</div>";
		header("Location: ../cadastrar.php");
		exit();
	}elseif($cpf == "" || $cpf == null){
		$_SESSION['msg'] = "<div class='toast-cad-false'>O campo cpf deve ser preenchido!</div>";
		header("Location: ../cadastrar.php");
		exit();
	}elseif($email == "" || $email == null){
		$_SESSION['msg'] = "<div class='toast-cad-false'>O campo email deve ser preenchido!</div>";
		header("Location: ../cadastrar.php");
		exit();
	}elseif($senha == "" || $senha == null){
		$_SESSION['msg'] = "<div class='toast-cad-false'>O campo senha deve ser preenchido!</div>";
		header("Location: ../cadastrar.php");
		exit();
	}elseif($rsenha == $senha){
		$_SESSION['msg'] = "<div class='toast-cad-false'>As senhas se divergem</div>";
		header("Location: ../cadastrar.php");
		exit();
	}elseif(mysqli_insert_id($conn)){
		$_SESSION['msg'] = "<div class='toast-cad-true'>Cadastro realizado com sucesso, realize o login.</div>";
		header("Location: ../cadastrar.php");
		exit();
	}
?>