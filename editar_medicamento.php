<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$id_usuario = $_SESSION['id'];
	$id_medicamento = $_GET['id'];

	// Valida acesso
	if (!empty($id_medicamento)) {
		$queryv1 = "SELECT * FROM medicamentos WHERE id = '$id_medicamento' AND id_usuario = '$id_usuario' LIMIT 1;";
		$verifica = mysqli_query($conn, $queryv1);
		$rowcount = mysqli_num_rows($verifica);
		if ($rowcount != 1) {
			$_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse medicamento</div>";
			header("Location: medicamentos.php");
			exit();
		}
	}else{
		$_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse medicamento</div>";
		header("Location: medicamentos.php");
		exit();
	}
	// Fim do valida acesso

	$queryv = mysqli_query($conn,"SELECT m.id_dependente FROM medicamentos as m WHERE m.id = '$id_medicamento' AND m.id_usuario = '$id_usuario' LIMIT 1;");
	$x = mysqli_fetch_object($queryv);

	if($x->id_dependente != NULL){
		$query = mysqli_query($conn,
		"SELECT im.*, d.*, d.id as id_user, m.*, f.alternativa as freq
		FROM info_medicamento as im
		INNER JOIN medicamentos as m
		ON im.id_medicamento = m.id
		INNER JOIN dependente as d
		ON d.id = m.id_dependente
		INNER JOIN frequencia as f
		ON f.id = im.id_frequencia
		WHERE m.id_usuario = '$id_usuario' AND m.id = '$id_medicamento' AND d.id = m.id_dependente;");
	}else{
		$query = mysqli_query($conn,
		"SELECT im.*, u.*, u.id_usuario as id_user, m.*, f.alternativa as freq
		FROM info_medicamento as im
		INNER JOIN medicamentos as m
		ON im.id_medicamento = m.id
		INNER JOIN usuarios as u
		ON u.id_usuario = m.id_usuario
		INNER JOIN frequencia as f
		ON f.id = im.id_frequencia
		WHERE m.id_usuario = '$id_usuario' AND m.id = '$id_medicamento' AND m.id_dependente IS NULL;");
	}
	$z = mysqli_fetch_object($query);

	$query = mysqli_query($conn,"SELECT * FROM frequencia;");
?>

<section class="conteudo">
	<h1>Editar medicamento</h1>
	<p class="min-center">Atualize aqui as informações sobre seu medicamento</p>

	<section class="cadastro-form">
		<form method="POST" action="FUNCOES/att_medicamento.php?id=<?php echo $z->id_medicamento; ?>" enctype="multipart/form-data">
			<label for="user">Usuário:
				<input type="text" name="user" readonly disabled value="<?php echo $z->nome, ' ', $z->sobrenome; ?>" placeholder="Nome do usuário.">
			</label>

			<label for="nomemed">Nome do Medicamento:
				<input type="text" name="nomemed" required="required" value="<?php echo $z->nome_medicamento ?>" placeholder="Coloque aqui o nome do medicamento.">
			</label>

			<label for="desc">Observações:
				<textarea name="desc" placeholder="Coloque aqui as observações sobre esse medicamento, como por exemplo, a dose a ser tomada."><?php echo $z->observacoes ?></textarea>
				<div style="clear: both;"></div>
			</label>

			<label for="dtini">Data de Início:
				<input type="date" name="dtini" required="required" value="<?php echo date("Y-m-d", strtotime($z->data_inicio)); ?>">
			</label>

			<label for="htini">Hora de Início:
				<input type="time" name="htini" required="required" placeholder="12:35" value="<?php echo $z->hora_inicio ?>">
			</label>

			<label for="dterm">Data de Término:
				<?php if ($z->data_termino == NULL) { ?>
					<input type="date" name="dterm">
				<?php } else { ?>
					<input type="date" name="dterm" value="<?php echo date("Y-m-d", strtotime($z->data_termino)); ?>">
				<?php } ?>
			</label>

			<label for="hterm">Hora de Término:
				<?php if ($z->hora_termino == NULL) { ?>
					<input type="time" name="hterm" placeholder="12:35">
				<?php } else { ?>
					<input type="time" name="hterm" placeholder="12:35" value="<?php echo $z->hora_termino ?>">
				<?php } ?>
			</label>

			<label for="frequencia">Frequência:
				<select name="frequencia" class="select" required="required" id="frequencia">
					<option value="6">Atual: <?php echo $z->freq; ?></option>
					<?php while($x = mysqli_fetch_object($query)){ ?>
						<option value="<?php echo $x->id; ?>"><?php echo $x->alternativa; ?></option>
					<?php } ?>
				</select>
			</label>
			
			<label for="atual" id="atual">Intervalo atual:
				<input type="text" name="atual" placeholder="Não definido" value="<?php echo $z->info_frequencia; ?>" readonly>
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
			<?php
				if (!empty($z->receita)) {
			?>
				<p style="text-align: right; color: #6d6d6d; font-size: 12px;">Arquivo atual: <a href="UPLOADS/RECEITAS/<?php echo $z->receita; ?>" style="color: #000;" target="_blank"><?php echo $z->receita; ?></a></p>
			<?php
				}else{
			?>
				<p style="text-align: right; color: #6d6d6d; font-size: 12px;">Nenhuma receita carregada</p>
			<?php
				}
			?>
			<br>
			<input type="submit" name="enviar" class="btn-form" value="Salvar">
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