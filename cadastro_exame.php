<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$id_usuario = $_SESSION['id'];

	$query = mysqli_query($conn,"SELECT * FROM dependente WHERE id_usuario = '$id_usuario' AND id_parentesco != 0 ORDER BY id ASC;");
?>
<section class="conteudo">
	<h1>Cadastro de exames</h1>
	<p class="min-center">Cadastre aqui seus exames e mantenha suas informações sempre atualizadas e centralizadas</p>
	
	<section class="cadastro-form">
		<form method="POST" action="FUNCOES/nw_exame.php" enctype="multipart/form-data">
			<label for="user">Usuário:
				<select name="user" class="select" required="required">
					<option value="">Selecione</option>
					<option value="<?php echo $_SESSION['id']; ?>"><?php echo $_SESSION['nome'], ' ', $_SESSION['sobrenome']; ?></option>
					<?php while($x = mysqli_fetch_object($query)){ ?>
						<option value="<?php echo $x->id; ?>"><?php echo $x->nome, ' ', $x->sobrenome; ?></option>
					<?php } ?>
				</select>
			</label>
			<label for="dtexam">Data do exame:
				<input type="date" name="dtexam" required="required">
			</label>
			<label for="desc">Qual o exame?
				<textarea name="desc" placeholder="Escreva aqui, o exame a ser feito, sem grandes detalhes." required="required"></textarea>
				<div style="clear: both;"></div>
			</label>
			<label for="arquivo">Arquivos:
				<input type="file" name="arquivo">
			</label>
							
			<input type="submit" name="enviar" class="btn-form" value="Cadastrar">
		</form>
	</section>
	<?php
		if(isset($_SESSION['msg'])){
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
	?>
</section>
<?php
	include ('footer.php');
?>