<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$id_usuario = $_SESSION['id'];

	$query = mysqli_query($conn,"SELECT * FROM frequencia;");
	$query1 = mysqli_query($conn,"SELECT * FROM dependente WHERE id_usuario = '$id_usuario' AND id_parentesco != 0 ORDER BY id ASC;");
?>

<section class="conteudo">
	<h1>Cadastro de medicamentos</h1>
	<p class="min-center">Cadastre aqui seus medicamentos</p>

	<section class="cadastro-form">
		<form method="POST" action="FUNCOES/nw_medicamento.php" enctype="multipart/form-data">
			<label for="user">Usuário:
				<select name="user" class="select" required="required">
					<option value="">Selecione</option>
					<option value="<?php echo $_SESSION['id']; ?>"><?php echo $_SESSION['nome'], ' ', $_SESSION['sobrenome']; ?></option>
					<?php while($y = mysqli_fetch_object($query1)){ ?>
						<option value="<?php echo $y->id; ?>"><?php echo $y->nome, ' ', $y->sobrenome; ?></option>
					<?php } ?>
				</select>
			</label>

			<label for="nomemed">Medicamento:
				<input type="text" name="nomemed" required="required" placeholder="Nome do medicamento.">
			</label>

			<label for="desc">Observações:
				<textarea name="desc" placeholder="Coloque aqui as observações sobre esse medicamento, como por exemplo, a dose a ser tomada."></textarea>
				<div style="clear: both;"></div>
			</label>

			<label for="dtini">Data de Início:
				<input type="date" name="dtini" required="required">
			</label>

			<label for="htini">Hora de Início:
				<input type="time" name="htini" required="required" placeholder="12:35">
			</label>

			<label for="frequencia">Frequência:
				<select name="frequencia" class="select" required="required" id="frequencia">
					<option value="">Selecione</option>
					<?php while($x = mysqli_fetch_object($query)){ ?>
						<option value="<?php echo $x->id; ?>"><?php echo $x->alternativa; ?></option>
					<?php } ?>
				</select>
			</label>

			<label for="diariamente" class="oc-ov" id="diariamente">Número de dias:
				<input type="number" name="diariamente" placeholder="Deixe 0 para indefinido">
			</label>

			<label for="semanalmente" class="oc-ov" id="semanalmente">Número de semanas:
				<input type="number" name="semanalmente" placeholder="Deixe 0 para indefinido">
			</label>

			<label for="inthoras" class="oc-ov" id="inthoras">Intervalo de Horas:
				<input type="number" name="inthoras" placeholder="Insira o intervalo de horas entre medicamentos">
			</label>

			<label for="intdias" class="oc-ov" id="intdias">Intervalo de Dias:
				<input type="number" name="intdias" placeholder="Insira o intervalo de dias entre medicamentos">
			</label>

			<label for="intoutro" class="oc-ov" id="intoutro">Outro:
				<input type="text" name="intoutro" placeholder="Qual frequência?">
			</label>

			<label for="arquivo">Receita:
				<input type="file" name="arquivo">
			</label>
				
			<input type="submit" name="enviar" class="btn-form" value="Cadastrar">
		</form>
		<br style="margin-bottom: 4em;">
	</section>
</section>
<?php
	if(isset($_SESSION['msg'])){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
?>

<?php
	include ('footer.php');
?>