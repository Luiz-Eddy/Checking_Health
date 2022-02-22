<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Checking Health - Cadastro</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<link rel="icon" type="image/png" href="IMG/icon.png" />
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
			<h1>Cadastrar-se</h1>
			<p>Você está a um passo de ter um maior controle sobre sua saúde</p>

			<form method="POST" action="FUNCOES/nw_usuario.php" class="login-form cad-form">
				<label>Nome:
					<input type="text" name="nome" required="required">
				</label>
				<label>Sobrenome:
					<input type="text" name="sobrenome" required="required">
				</label>
				<label>CPF:
					<input type="text" name="cpf" required="required">
				</label>
				<label>E-mail:
					<input type="email" name="email" required="required">
				</label>
				<label>Senha:
					<input type="password" name="senha" required="required">
				</label>
				<label>Senha:
					<input type="password" name="rsenha" required="required">
				</label>
				
				<br>
				<input type="submit" class="btn btn-form" value="Cadastrar">
			</form>
			<a href="login.php" class="cad-btn1 ">Voltar para login</a>
			<p></p>
			
		</div>
		<?php
		if(isset($_SESSION['msg'])){
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		?>
	</section>
	<script src="/JS/jquery-3.2.1.min.js"></script>
	<script src="/JS/jquery.mask.min.js"></script>
	<script>
		$("input[name='cpf']").mask("999.999.999.99")
	</script>
</body>
</html>