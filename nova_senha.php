<?php
	session_start();
	include_once("FUNCOES/CONNECTION/connect.php");

	$emailrec = $_GET['mail'];
	$code = $_GET['code'];

	if (empty($emailrec) | empty($code)){
		$_SESSION['msg'] = "<div class='toast-cad-false'>Erro na solicitação</div>";
		header('Location: login.php');
		exit();
	}else{
		$sql = "SELECT * FROM usuarios WHERE email = '$emailrec';";
		$verificar = mysqli_query($conn,$sql);
		$x = mysqli_fetch_object($verificar);
		$id_user = $x->id_usuario;

		$valida_dados = "SELECT * FROM recovery_codes WHERE id_usuario = '$id_user' AND code = '$code' AND process = 1;";
		$exec_valida = mysqli_query($conn,$valida_dados);

		if(mysqli_num_rows($exec_valida) != 1){
			$_SESSION['msg'] = "<div class='toast-cad-false'>Informações incorretas</div>";
			header('Location: login.php');
			exit();
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Checking Health  - Recuperar Senha</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
</head>
<body>
	<section class="painel">
		<img src="IMG/logo.png" alt="Logo">
	</section>

	<div style="clear: both;"></div>

	<section class="login">
		<div class="bx-login">
			<div style="text-align: center;"><img src="IMG/logo.png" alt="Logo" class="logo-login"></div>
			<h1>Recuperar Senha</h1>
			<p>Perfeito, agora vamos mudar sua senha</p>

			<form method="POST" action="FUNCOES/att_senha_last.php" id="formRecupera" name="formRecupera" class="login-form">
				<label>Seu e-mail:</label>
				<input type="email" name="emailRecupera" required="required" readonly value="<?php echo $emailrec; ?>" readonly>
				<label>Nova Senha:</label>
				<input type="password" name="nova_senha" required="required">

				<input type="submit" name="recuperar" value="Continuar" class="btn btn-padrao btn-login">
			</form>
		</div>
	</section>
</body>
</html>