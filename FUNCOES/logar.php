<?php 
	session_start();
	include_once("CONNECTION/connect.php");

	$login = $_POST['login'];
	$senha = $_POST['senha'];
	$senhacript = md5($senha);

	$result = "SELECT * FROM usuarios WHERE email = '$login' AND senha = '$senhacript' LIMIT 1";
	$resultado_usuario = mysqli_query($conn, $result);
	$resultado = mysqli_fetch_assoc($resultado_usuario);

	if(isset($resultado)){
	    $_SESSION['login'] = $login;
	    $_SESSION['senha'] = $senha;
	    $_SESSION['nome'] = $resultado['nome'];
	    $_SESSION['sobrenome'] = $resultado['sobrenome'];
	    $_SESSION['id'] = $resultado['id_usuario'];
	    header("Location: ../painel.php");
	}else{
	    $_SESSION['msg'] = "<div class='toast-cad-false'>Usuário ou senha incorretos</div>";
	    header("Location: ../login.php");
	    exit();
	}
?>