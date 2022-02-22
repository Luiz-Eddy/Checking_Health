<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$id_usuario = $_SESSION['id'];
	$id_exame = $_GET['id'];

	// Valida acesso
	if (!empty($id_exame)) {
		$queryv1 = "SELECT * FROM exames WHERE id = '$id_exame' AND id_usuario = '$id_usuario' LIMIT 1;";
		$verifica = mysqli_query($conn, $queryv1);
		$rowcount = mysqli_num_rows($verifica);
		if ($rowcount != 1) {
			$_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse exame</div>";
			header("Location: exames.php");
			exit();
		}
	}else{
		$_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse exame</div>";
		header("Location: exames.php");
		exit();
	}
	// Fim do valida acesso

	$queryv = mysqli_query($conn,"SELECT e.id_dependente FROM exames as e WHERE e.id = '$id_exame' AND e.id_usuario = '$id_usuario' LIMIT 1;");
	$x = mysqli_fetch_object($queryv);

	if($x->id_dependente != NULL){
		$query = mysqli_query($conn,"
			SELECT ie.*, ie.id as id_a, d.*, d.id, e.*
			FROM info_exames as ie
			INNER JOIN exames as e
			ON ie.id_exames = e.id
			INNER JOIN dependente as d
			ON d.id = e.id_dependente
			WHERE e.id_usuario = '$id_usuario' AND e.id = '$id_exame'
			GROUP BY ie.data_exame DESC");

		$queryall = mysqli_query($conn,"
			SELECT ie.*, d.*, d.id, e.*, ie.id as idatt
			FROM info_exames as ie
			INNER JOIN exames as e
			ON ie.id_exames = e.id
			INNER JOIN dependente as d
			ON d.id = e.id_dependente
			WHERE e.id_usuario = '$id_usuario' AND e.id = '$id_exame' ORDER BY ie.data_exame DESC LIMIT 1, 2000;");
	}else{
		$query = mysqli_query($conn,"
			SELECT ie.*, ie.id as id_a, u.*, e.*
			FROM info_exames as ie
			INNER JOIN exames as e
			ON ie.id_exames = e.id
			INNER JOIN usuarios as u
			ON u.id_usuario = e.id_usuario
			WHERE e.id_usuario = '$id_usuario' AND e.id = '$id_exame'
			GROUP BY ie.data_exame DESC");
		$queryall = mysqli_query($conn,"
			SELECT ie.*, u.*, e.*, ie.id as idatt
			FROM info_exames as ie
			INNER JOIN exames as e
			ON ie.id_exames = e.id
			INNER JOIN usuarios as u
			ON u.id_usuario = e.id_usuario
			WHERE e.id_usuario = '$id_usuario' AND e.id = '$id_exame' ORDER BY ie.data_exame DESC LIMIT 1, 2000;");
	}
?>
<section class="conteudo">
	<h1>Detalhes do Exame</h1>
	<p class="min-center">Atualize as informações do exame por aqui</p>

	<?php $x = mysqli_fetch_object($query); ?>
	
	<a href="atualizar_exame.php?id=<?php echo $x->id_exames; ?>" class="btn btn-padrao btn1 ex-btn">Nova atualização</a>

	<div class="excluir_exame">
		<p>X</p>
		<a href="FUNCOES/dl_exame.php?id=<?php echo $x->id_exames; ?>" onclick="return confirm('Tem certeza que deseja deletar o exame e todas as suas atualizações?')">Deletar Exame</a>
	</div>
	
	<div style="clear: both;"></div>
	<div class="info-ex-1">
		<h1>Última atualização</h1>
		<h2>Descrição</h2>
		<p><?php echo $x->descricao; ?></p>

		<h2>Data do Exame</h2>
		<p><?php  echo date("d/m/Y", strtotime($x->data_exame)); ?></p>

		<h2>Usuário do Exame</h2>
		<p><?php echo $x->nome, ' ', $x->sobrenome; ?></p>
		
		<div class="excluir_exame">
			<p>X</p>
			<a href="FUNCOES/dl_att_exame.php?id=<?php echo $x->id_a; ?>&ide=<?php echo $x->id;?>" onclick="return confirm('Tem certeza que deseja deletar essa atualização?')">Deletar Atualização</a>
		</div>
		<div class="editar_exame">
			<img src="IMG/editar1.png">
			<a href="editar_exame.php?id=<?php echo $x->id_exames; ?>&idatt=<?php echo $x->id_a; ?>">Editar</a>
		</div>
	</div>
	<div class="info-ex-2">
		<?php 
		if($x->arquivo == NULL){
			?>
			<img src="IMG/logo_download.png" style="filter: grayscale(100);">
			<p style="font-size: 10px; color: #6d6d6d;">Opa!</p>
			<p>Nenhum arquivo carregado nessa atualização</p>
			<?php
		}else{
			?>
			<img src="IMG/logo_download.png">
			<p style="font-size: 10px; color: #6d6d6d;">Clique no nome para baixar o arquivo</p>
			<p><a href="UPLOADS/<?php echo $x->arquivo; ?>" target="_blank"><?php echo $x->arquivo; ?></a></p>
			<?php
		}
		?>
	</div>
	
	<div style="clear: both;"></div>

	<?php 
	$rowcount = mysqli_num_rows($queryall);

	if ($rowcount >= 1) {
		?>
		<div class="info-ex-3">
			<h1>Atualizações anteriores</h1>
			<table>
				<thead>
					<tr>
						<th>Descrição</th>
						<th>Data do exame</th>
						<th>Usuário</th>
						<th style="text-align: center;">Arquivo</th>
						<th style="text-align: center;">Ação</th>
					</tr>
				</thead>
				<tbody>
					<?php while($y = mysqli_fetch_object($queryall)){ ?>
						<tr>
							<td><?php echo $y->descricao; ?></td>
							<td><?php  echo date("d/m/Y", strtotime($y->data_exame)); ?></td>
							<td><?php echo $x->nome, ' ', $x->sobrenome; ?></td>
							<td style="text-align: center;">
								<?php 
								if($y->arquivo == NULL){
									?>
									<img src="IMG/nenhum.png" alt="Nenhum arquivo" class="down-table" style="opacity: 0.5;">
									<?php
								}else{
									?>
									<a href="UPLOADS/<?php echo $y->arquivo; ?>" target="_blank">
										<img src="IMG/logo_download.png" alt="Baixar <?php echo $y->arquivo; ?>" class="down-table">
									</a>
									<?php
								}
								?>
							</td>
							<td style="text-align: center;">
								<a href="editar_exame.php?id=<?php echo $y->id_exames; ?>&idatt=<?php echo $y->idatt; ?>"><img src="IMG/editar.png" alt="Editar" width="20px"></a>

								<a href="FUNCOES/dl_att_exame.php?id=<?php echo $y->idatt; ?>&ide=<?php echo $x->id;?>" onclick="return confirm('Tem certeza que deseja deletar essa atualização?')"><img src="IMG/deletar.png" alt="Excluir" width="20px"></a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
	<?php
		}
		if(isset($_SESSION['msg'])){
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
	?>
	</section>
	<?php
		include ('footer.php');
	?>