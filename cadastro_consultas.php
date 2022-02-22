<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$id_usuario = $_SESSION['id'];
	$query1 = mysqli_query($conn,"SELECT * FROM dependente WHERE id_usuario = '$id_usuario' AND id_parentesco != 0 ORDER BY id ASC;");
?>

<section class="conteudo">
	<h1>Cadastro de Consultas</h1>
	<p class="min-center">Cadastre aqui suas Consultas</p>

	<section class="cadastro-form">
		<form method="POST" action="FUNCOES/nw_consulta.php" enctype="multipart/form-data">
			<label for="user">Usuário:
				<select name="user" class="select" required="required">
					<option value="">Selecione</option>
					<option value="<?php echo $_SESSION['id']; ?>"><?php echo $_SESSION['nome'], ' ', $_SESSION['sobrenome']; ?></option>
					<?php while($y = mysqli_fetch_object($query1)){ ?>
						<option value="<?php echo $y->id; ?>"><?php echo $y->nome, ' ', $y->sobrenome; ?></option>
					<?php } ?>
				</select>
			</label>

			<label for="nomecons">Especialização:
				<input type="text" name="nomecons" required="required" placeholder="Consulta de que?">
			</label>
				
			<label for="nomemed">Nome do(a) Médico(a):
				<input type="text" name="nomemed" required="required" placeholder="Nome do(a) médico(a)">
			</label>

			<label for="dtcons">Data da Consulta:
				<input type="date" name="dtcons" required="required">
			</label>

			<label for="htcons">Hora da Consulta:
				<input type="time" name="htcons" required="required">
			</label>

			<label for="lcons">Local da Consulta:
				<input type="text" name="lcons" required="required" placeholder="Onde irá realizar a consulta?">
			</label>

			<label for="desc">Descrição:
				<textarea name="desc" placeholder="Digite aqui uma descrição detalhada sobre a consulta"></textarea>
				<div style="clear: both;"></div>
			</label>

			<label for="arquivo">Arquivo:
				<input type="file" name="arquivo">
			</label>

			<input type="submit" name="enviar" class="btn-form" value="Cadastrar">
		</form>
		<br style="margin-bottom: 4em;">
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