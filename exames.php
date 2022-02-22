<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$id_session = $_SESSION['id'];

	/* seleção de exames de dependente */
	$dependente = mysqli_query($conn,
		"SELECT ie.descricao, MAX(ie.data_exame) as data_exame, d.*, d.id as idd, e.*
		FROM info_exames as ie
		INNER JOIN exames as e
		ON ie.id_exames = e.id
		INNER JOIN dependente as d
		ON d.id = e.id_dependente
		WHERE e.id_usuario = '$id_session' AND d.id = e.id_dependente
		GROUP BY ie.id_exames;");

	/*seleção de exames do usuario*/ 
	$query = mysqli_query($conn,
		"SELECT ie.descricao, MAX(ie.data_exame) as data_exame, u.*, e.*
		FROM info_exames as ie 
		INNER JOIN exames as e 
		ON ie.id_exames = e.id 
		INNER JOIN usuarios as u 
		ON u.id_usuario = e.id_usuario
		WHERE e.id_usuario = '$id_session' AND e.id_dependente IS NULL
		GROUP BY e.id");
?>
	<section class="conteudo">
		<h1>Exames</h1>
		<p class="min-center">Gerencie os exames realizados</p>
		<br>
		<a href="cadastro_exame.php" class="btn btn-padrao btn1">Cadastrar novo</a>

		<?php
		if (mysqli_num_rows($query) < 1 && mysqli_num_rows($dependente) < 1) {
			?>
			<div class="sem-resultado">
				<img src="IMG/Nenhum.png">
				<h3>Nenhum exame cadastrado</h3>
			</div>
			<?php
		}else{
			?>
			<table>
				<thead>
					<tr>
						<th>Descrição</th>
						<th>Usuário</th>
						<th>Última atualização</th>
						<th style="text-align: center;">Detalhar Exame</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while($x = mysqli_fetch_object($query)){ ?>
						<tr>
							<td><?php  echo $x->descricao; ?></td>
							<td><?php  echo $x->nome, ' ', $x->sobrenome; ?></td>
							<td><?php  echo date("d/m/Y", strtotime($x->data_exame)); ?></td>
							<td style="text-align: center;"><a href="info_exame.php?id=<?php echo $x->id;?>"><img src="IMG/consulta.png" height="20px;"> Detalhar</a></td>
						</tr>
					<?php } ?>
					<?php
					while($x = mysqli_fetch_object($dependente)){ ?>
						<tr>
							<td><?php  echo $x->descricao; ?></td>
							<td><?php  echo $x->nome, ' ', $x->sobrenome; ?></td>
							<td><?php  echo date("d/m/Y", strtotime($x->data_exame)); ?></td>
							<td style="text-align: center;"><a href="info_exame.php?id=<?php echo $x->id;?>"><img src="IMG/consulta.png" height="20px;"> Detalhar</a></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
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