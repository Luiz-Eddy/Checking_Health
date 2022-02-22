<?php
	session_start();
	$emailrec = $_GET['mail'];

	if (empty($emailrec)){
		$_SESSION['msg'] = "<div class='toast-cad-false'>Erro na solicitação</div>";
		header('Location: recuperar_senha.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Checking Health - Resolver problema de segurança</title>
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
			<h1>Acesso Suspeito</h1>
			<p>Opa, parece que você não solicitou a mudança de senha, vamos resolver isso.</p>

			<form method="POST" action="FUNCOES/dl_code.php" id="formRecupera" name="formRecupera" class="login-form">
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