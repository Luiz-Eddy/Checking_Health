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
		"SELECT im.*, d.*, d.id as idd, m.*, f.alternativa as freq
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
		"SELECT im.*, u.*, u.id_usuario as idu, m.*, f.alternativa as freq
		FROM info_medicamento as im
		INNER JOIN medicamentos as m
		ON im.id_medicamento = m.id
		INNER JOIN usuarios as u
		ON u.id_usuario = m.id_usuario
		INNER JOIN frequencia as f
		ON f.id = im.id_frequencia
		WHERE m.id_usuario = '$id_usuario' AND m.id = '$id_medicamento' AND m.id_dependente IS NULL;");
	}
?>
<section class="conteudo">
	<h1>Detalhes do Medicamento</h1>
	<p class="min-center">Veja e atualize as informações do medicamento por aqui</p>
	
	<a href="editar_medicamento.php?id=<?php echo $id_medicamento; ?>" class="btn btn-padrao btn1 ex-btn">Editar Informações</a>

	<div class="excluir_exame">
		<p>X</p>
		<a href="FUNCOES/dl_medicamento.php?id=<?php echo $id_medicamento; ?>" onclick="return confirm('Ao invés de deletar o medicamento, você pode marcar como uso finalizado em editar informações, deseja prosseguir com a remoção?')">Remover</a>
	</div>
	
	<div style="clear: both;"></div>
	<div class="info-ex-1" style="margin-bottom: 3em;">
		<?php $x = mysqli_fetch_object($query); ?>
		<h1>Informações</h1>
		<h2>Usuário</h2>
		<p><?php echo $x->nome, " ", $x->sobrenome; ?></p>

		<h2>Medicamento</h2>
		<p><?php echo $x->nome_medicamento; ?></p>

		<h2>Observações</h2>
		<p><?php echo $x->observacoes; ?></p>

		<h2>Data Início</h2>
		<p><?php echo date("d/m/Y", strtotime($x->data_inicio)); ?></p>

		<h2>Hora de Início</h2>
		<p><?php echo $x->hora_inicio; ?></p>

		<h2>Data de Término</h2>
		<p>
			<?php if ($x->data_termino == NULL) {
				echo "Não definido";
			}else{
				echo date("d/m/Y", strtotime($x->data_termino));
			} ?>
		</p>

		<h2>Hora de Término</h2>
		<p>
			<?php if ($x->hora_termino == NULL) {
				echo "Não definido";
			}else{
				echo $x->hora_termino;
			} ?>
		</p>
		
		<h2>Frequência</h2>
		<p><?php echo $x->freq; ?></p>

		<h2>Intervalo</h2>
		<p>
			<?php
				if ($x->id_frequencia == 1) {
					if ($x->info_frequencia == 0) {
						echo "Não definido";
					}else{
						echo $x->info_frequencia, " ", "Dias";
					}
				}else if ($x->id_frequencia == 2) {
					if ($x->info_frequencia == 0) {
						echo "Não definido";
					}else{
						echo $x->info_frequencia, " ", "Semanas";
					}
				}else if ($x->id_frequencia == 3) {
					if ($x->info_frequencia == 0) {
						echo "Não definido";
					}else{
						echo "A cada ", $x->info_frequencia, " ", "Hora(s)";
					}
				}else if ($x->id_frequencia == 4) {
					if ($x->info_frequencia == 0) {
						echo "Não definido";
					}else{
						echo "A cada ", $x->info_frequencia, " ", "Dia(s)";
					}
				}else if ($x->id_frequencia == 5) {
					echo $x->info_frequencia;
				}else{
					echo "Não definido";
				}
			?>
		</p>
	</div>
	<div class="info-ex-2">
		<?php 
		if($x->receita == NULL){
			?>
			<img src="IMG/logo_download.png" style="filter: grayscale(100);">
			<p style="font-size: 10px; color: #6d6d6d;">Opa!</p>
			<p>Nenhum arquivo carregado nesse medicamento</p>
			<?php
		}else{
			?>
			<img src="IMG/logo_download.png">
			<p style="font-size: 10px; color: #6d6d6d;">Clique no nome para baixar o arquivo</p>
			<p><a href="UPLOADS/RECEITAS/<?php echo $x->receita; ?>" target="_blank"><?php echo $x->receita; ?></a></p>
			<?php
		}
		?>
	</div>
	<div style="clear: both;"></div>
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