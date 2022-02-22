<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$id_session = $_SESSION['id'];

	/* seleção de medicamentos do dependente */
	$dependente = mysqli_query($conn,
		"SELECT im.id_medicamento, im.data_termino, im.info_frequencia, im.id_frequencia, im.nome_medicamento, MAX(im.data_inicio) as data_inicio, d.*, d.id as idd, m.*, f.alternativa as freq
		FROM info_medicamento as im
		INNER JOIN medicamentos as m
		ON im.id_medicamento = m.id
		INNER JOIN dependente as d
		ON d.id = m.id_dependente
		INNER JOIN frequencia as f
		ON f.id = im.id_frequencia
		WHERE m.id_usuario = '$id_session' AND d.id = m.id_dependente
		GROUP BY im.id_medicamento;");

	/*seleção de medicamentos do usuario*/ 
	$query = mysqli_query($conn,
		"SELECT im.id_medicamento, im.data_termino, im.info_frequencia, im.id_frequencia, im.nome_medicamento, MAX(im.data_inicio) as data_inicio, u.*, u.id_usuario as idu, m.*, f.alternativa as freq
		FROM info_medicamento as im
		INNER JOIN medicamentos as m
		ON im.id_medicamento = m.id
		INNER JOIN usuarios as u
		ON u.id_usuario = m.id_usuario
		INNER JOIN frequencia as f
		ON f.id = im.id_frequencia
		WHERE m.id_usuario = '$id_session' AND m.id_dependente IS NULL
		GROUP BY im.id_medicamento;");
?>

	<section class="conteudo">
		<h1>Medicamentos</h1>
		<p class="min-center">Veja abaixo os medicamentos cadastrados em seu perfil</p>
		<br>
		<a href="cadastro_medicamentos.php" class="btn btn-padrao btn1">Cadastrar novo</a>
		
		<?php
		if (mysqli_num_rows($dependente) < 1 && mysqli_num_rows($query) < 1) {
			?>
			<div class="sem-resultado">
				<img src="IMG/Nenhum.png">
				<h3>Nenhum medicamento cadastrado</h3>
			</div>
		<?php }else{ ?>
			<table>
				<thead>
					<tr>
						<th>ID</th>
						<th>Medicamento</th>
						<th>Início em</th>
						<th>Finalizado em</th>
						<th>Frequência</th>
						<th>Intervalo</th>
						<th style="text-align: center;">Ações</th>
					</tr>
				</thead>

				<tbody>
					<?php while($y = mysqli_fetch_object($query)){ ?>
						<tr>
							<td><?php echo $y->id_medicamento; ?></td>
							<td><?php echo $y->nome_medicamento; ?></td>
							<td><?php echo date("d/m/Y", strtotime($y->data_inicio)); ?></td>
							<td>
								<?php
								if ($y->data_termino == NULL) {
									echo "Não definido";
								}else{
									echo date("d/m/Y", strtotime($y->data_termino));
								}
								?>
							</td>
							<td><?php echo $y->freq; ?></td>
							<td>
								<?php 
								if ($y->id_frequencia == 1) {
									if ($y->info_frequencia == 0) {
										echo "Não definido";
									}else{
										echo $y->info_frequencia, " ", "Dias";
									}
								}else if ($y->id_frequencia == 2) {
									if ($y->info_frequencia == 0) {
										echo "Não definido";
									}else{
										echo $y->info_frequencia, " ", "Semanas";
									}
								}else if ($y->id_frequencia == 3) {
									if ($y->info_frequencia == 0) {
										echo "Não definido";
									}else{
										echo "A cada ", $y->info_frequencia, " ", "Hora(s)";
									}
								}else if ($y->id_frequencia == 4) {
									if ($y->info_frequencia == 0) {
										echo "Não definido";
									}else{
										echo "A cada ", $y->info_frequencia, " ", "Dia(s)";
									}
								}else if ($y->id_frequencia == 5) {
									echo $y->info_frequencia;
								}else{
									echo "Não definido";
								}
								?>
							</td>
							<td style="text-align: center;"><a href="info_medicamento.php?id=<?php echo $y->id;?>"><img src="IMG/consulta.png" height="20px;"> Detalhar</a></td>
						</tr>
					<?php } ?>
					<?php while($x = mysqli_fetch_object($dependente)){ ?>
						<tr>
							<td><?php echo $x->id_medicamento; ?></td>
							<td><?php echo $x->nome_medicamento; ?></td>
							<td><?php echo date("d/m/Y", strtotime($x->data_inicio)); ?></td>
							<td>
								<?php
								if ($x->data_termino == NULL) {
									echo "Não definido";
								}else{
									echo $x->data_termino;
								}
								?>
							</td>
							<td><?php echo $x->freq; ?></td>
							<td>
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
							</td>
							<td style="text-align: center;"><a href="info_medicamento.php?id=<?php echo $x->id;?>"><img src="IMG/consulta.png" height="20px;"> Detalhar</a></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php }
		if(isset($_SESSION['msg'])){
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		?>
	</section>

	<?php
		include ('footer.php');
	?>