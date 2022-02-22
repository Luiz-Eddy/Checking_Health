<?php
	session_start();
	$emailrec = $_GET['mail'];

	if (empty($emailrec)){
		$_SESSION['msg'] = "<div class='toast-cad-false'>Erro na solicitação</div>";
		header('Location: recuperar_senha.php');
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Checking Health  - Recuperar Senha</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<section class="painel">
		<img src="IMG/logo.png" alt="Logo">
	</section>

	<!-- Limpeza de elementos float -->
	<div style="clear: both;"></div>

	<section class="login">
		<div class="bx-login">
			<!-- <div style="text-align: center;"><img src="IMG/logo.png" alt="Logo" class="logo-login"></div> -->
			<h1>Recuperar Senha</h1>
			<p>Perfeito, vamos agora conferir se você é você mesmo</p>

			<form method="POST" action="FUNCOES/val_cod.php" id="formRecupera" name="formRecupera" class="login-form">
				<label>Seu e-mail:</label>
				<input type="email" name="emailRecupera" required="required" readonly value="<?php echo $emailrec; ?>">
				<label>Qual o código recebido?</label>
				<input type="text" name="codeRecupera" required="required" maxlength="4">

				<input type="submit" name="recuperar" value="Continuar" class="btn btn-padrao btn-login">
			</form>
			<a href="login.php" class="cad-btn">Voltar para o login</a>
		</div>
	</section>
</body>
</html>