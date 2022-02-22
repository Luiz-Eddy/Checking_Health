<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$id_dependente = $_GET['id'];
	$id_session = $_SESSION['id'];

	// Valida acesso
	if (!empty($id_dependente)) {
		$queryv1 = "SELECT * FROM dependente WHERE id = '$id_dependente' AND id_usuario = '$id_session' LIMIT 1;";
		$verifica = mysqli_query($conn, $queryv1);
		$rowcount = mysqli_num_rows($verifica);
		if ($rowcount != 1) {
			$_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse dependente</div>";
			header("Location: dependentes.php");
			exit();
		}
	}else{
		$_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse dependente</div>";
		header("Location: dependentes.php");
		exit();
	}
	// Fim do valida acesso

	$query = mysqli_query($conn, "SELECT d.*, p.tipo FROM dependente as d INNER JOIN parentesco as p ON d.id_parentesco = p.id WHERE d.id = '$id_dependente' AND d.id_usuario = '$id_session';");
	$x = mysqli_fetch_object($query);

	$query1 = mysqli_query($conn,"SELECT * FROM parentesco");
?>
<section class="conteudo">
	<h1>Alterar o dependente <?php echo $x->nome, ' ', $x->sobrenome; ?></h1>
	<p class="min-center">Atualize as informações do dependente</p>

	<section class="cadastro-form">
		<form method="POST" action="FUNCOES/att_dep.php?id=<?php echo $id_dependente; ?>">
			<label for="nome">Nome:
				<input type="text" name="nome" required="required" value="<?php echo $x->nome; ?>">
			</label>
			<label for="sobrenome">Sobrenome:
				<input type="text" name="sobrenome" required="required" value="<?php echo $x->sobrenome; ?>">
			</label>
			<label for="dtnasc">Data de Nascimento:
				<input type="date" name="dtnasc" required="required" value="<?php echo date("Y-m-d", strtotime($x->dt_nasc)); ?>">
			</label>
			<label for="parentesco">Parentesco
				<select name="parentesco" class="select" required="required">
					<option value="<?php echo $x->id_parentesco; ?>">Atual: <?php echo $x->tipo; ?></option>
					<?php while($y = mysqli_fetch_object($query1)){ ?>
						<option value="<?php echo $y->id; ?>"><?php echo $y->tipo; ?></option>
					<?php } ?>
				</select>
			</label>
			<label for="rg">RG:
				<input type="text" name="rg" required="required" value="<?php echo $x->rg; ?>">
			</label>
			<label for="cpf">CPF:
				<input type="text" name="cpf" required="required" value="<?php echo $x->cpf; ?>">
			</label>
			<label for="telefone">Telefone
				<input type="text" name="telefone" required="required" value="<?php echo $x->telefone; ?>">
			</label>

			<input type="submit" name="enviar" class="btn-form" value="Salvar">
		</form>
		<?php
			if(isset($_SESSION['msg'])){
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
		?>
	</section>
</section>
							
<?php
	include ('footer.php');
?>
<script>
	$("input[name='cpf']").mask("999.999.999.99")
</script>