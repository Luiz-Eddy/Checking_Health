<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Checking Health  - Login</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<link rel="icon" type="image/png" href="IMG/icon.png" />
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
			<h1>Login</h1>
			<p>Acesse sua conta e gerencie suas informações importantes de saúde</p>

			<form method="POST" action="FUNCOES/logar.php" id="formlogin" name="formlogin" class="login-form">
				<label>Usuário</label>
				<input type="text"name="login" id="login" required="required">
				<label>Senha</label>
				<input type="password" name="senha" id="senha" required="required">

				<input type="submit" value="Logar" class="btn btn-padrao btn-login">
			</form>
			<div class="login-btn">
				<a href="recuperar_senha.php" class="cad-btn">Recuperar Senha</a>
				<a href="cadastrar.php" class="cad-btn" style="margin-bottom: 5em;">Cadastrar</a>
			</div>
			<?php
			session_start();
			if(isset($_SESSION['msg'])){
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
			?>
		</div>
		<div class="beta-card">
			<p>Olá, o sistema está em fase de desenvolvimento, isso significa que contém diversos BUGs e não deve ser usado efetivamente.</p>
		</div>
	</section>
</body>
</html>