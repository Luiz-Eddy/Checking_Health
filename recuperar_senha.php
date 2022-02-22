<?php
	session_start();
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

	<div style="clear: both;"></div>

	<section class="login">
		<div class="bx-login">
			<!-- <div style="text-align: center;"><img src="IMG/logo.png" alt="Logo" class="logo-login"></div> -->
			<h1>Recuperar Senha</h1>
			<p>Esqueceu a senha da sua conta? muito simples, vamos recuperá-la!</p>

			<form method="POST" action="FUNCOES/ev_mail.php" id="formRecupera" name="formRecupera" class="login-form">
				<label>Digite seu e-mail</label>
				<input type="email" name="emailRecupera" required="required">
				<input type="submit" name="recuperar" value="Continuar" class="btn btn-padrao btn-login">
			</form>
			<div class="login-btn">
				<a href="login.php" class="cad-btn">Voltar para o login</a>
			</div>
		</div>
		<div class="beta-card">
			<p>Olá, a recuperação de senha está indisponível devido a hospedagem gratuita.</p>
		</div>
	</section>
	<?php
	if(isset($_SESSION['msg'])){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
	?>
</body>
</html>