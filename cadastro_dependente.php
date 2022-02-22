<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$query = mysqli_query($conn,"SELECT * FROM parentesco");
?>
<section class="conteudo">
	<h1>Cadastro de Dependente</h1>
	<p class="min-center">Cadastre aqui seus dependentes para gerenciar suas informações</p>
	
	<section class="cadastro-form">
		<form method="POST" action="FUNCOES/nw_dependente.php">
			<label for="nome">Nome:
				<input type="text" name="nome" required="required" placeholder="Insira o nome">
			</label>
			<label for="sobrenome">Sobrenome:
				<input type="text" name="sobrenome" required="required" placeholder="Insira o sobrenome">
			</label>
			<label for="dtnasc">Data de Nascimento:
				<input type="date" name="dtnasc" required="required">
			</label>
			<label for="parentesco">Parentesco
				<select name="parentesco" class="select" required="required">
					<option value="">Selecione</option>
					<?php while($x = mysqli_fetch_object($query)){ ?>
						<option value="<?php echo $x->id; ?>"><?php echo $x->tipo; ?></option>
					<?php } ?>
				</select>
			</label>
			<label for="rg">RG:
				<input type="text" name="rg" required="required" placeholder="000.000.00">
			</label>
			<label for="cpf">CPF:
				<input type="text" name="cpf" required="required" placeholder="000.000.000-00">
			</label>
			<label for="telefone">Telefone
				<input type="text" name="telefone" required="required" placeholder="(00) 00000-0000">
			</label>

			<input type="submit" name="enviar" class="btn-form" value="Cadastrar">
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
	$("input[name='cpf']").mask("999.999.999.99");
</script>				