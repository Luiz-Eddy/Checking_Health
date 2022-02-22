<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$id_session = $_SESSION['id'];

	/* seleção de consultas do dependente */
	$dependente = mysqli_query($conn,
		"SELECT c.*, c.id as idc, ic.*, MAX(ic.data_consulta) as data_da_consulta, d.*, d.id as idd
		FROM info_consultas as ic
		INNER JOIN consultas as c
		ON ic.id_consulta = c.id
		INNER JOIN dependente as d
		ON d.id = c.id_dependente
		WHERE c.id_usuario = '$id_session' AND d.id = c.id_dependente
		GROUP BY c.id;");

	/*seleção de consultas do usuario*/ 
	$query = mysqli_query($conn,
		"SELECT c.*, c.id as idc, ic.*, MAX(ic.data_consulta) as data_da_consulta, u.*, u.id_usuario as idu
		FROM info_consultas as ic
		INNER JOIN consultas as c
		ON ic.id_consulta = c.id
		INNER JOIN usuarios as u
		ON u.id_usuario = c.id_usuario
		WHERE c.id_usuario = '$id_session' AND c.id_dependente IS NULL
		GROUP BY c.id;");
?>

<section class="conteudo">
	<h1>Consultas</h1>
	<p class="min-center">Veja abaixo as consultas cadastradas em seu perfil</p>
	<br>
	<a href="cadastro_consultas.php" class="btn btn-padrao btn1">Cadastrar novo</a>
	
	<?php if (mysqli_num_rows($dependente) < 1 && mysqli_num_rows($query) < 1) {
			?>
			<div class="sem-resultado">
				<img src="IMG/Nenhum.png">
				<h3>Nenhuma consulta cadastrada</h3>
			</div>
	<?php }else{ ?>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Consulta</th>
					<th>Médico</th>
					<th>Local</th>
					<th>Data da Consulta</th>
					<th>Hora da Consulta</th>
					<th>Realizada</th>
					<th style="text-align: center;">Ações</th>
				</tr>
			</thead>
			
			<tbody>
				<?php while($x = mysqli_fetch_object($query)){ ?>
					<tr>
						<td><?php echo $x->idc; ?></td>
						<td><?php echo $x->nome_consulta; ?></td>
						<td><?php echo $x->nome_medico; ?></td>
						<td><?php echo $x->local; ?></td>
						<td><?php echo date("d/m/Y", strtotime($x->data_consulta)); ?></td>
						<td><?php echo $x->hora_consulta; ?></td>
						<td><?php if ($x->data_realizada == NULL) {
									echo "Não";
								  } else {
								  	echo "Sim";
						}?></td>
						<td style="text-align: center;"><a href="info_consulta.php?id=<?php echo $x->idc;?>"><img src="IMG/consulta.png" height="20px;"> Detalhar</a></td>
					</tr>
				<?php } ?>
				<?php while($y = mysqli_fetch_object($dependente)){ ?>
					<tr>
						<td><?php echo $y->idc; ?></td>
						<td><?php echo $y->nome_consulta; ?></td>
						<td><?php echo $y->nome_medico; ?></td>
						<td><?php echo $y->local; ?></td>
						<td><?php echo date("d/m/Y", strtotime($y->data_consulta)); ?></td>
						<td><?php echo $y->hora_consulta; ?></td>
						<td><?php if ($y->data_realizada == NULL) {
									echo "Não";
								  } else {
								  	echo "Sim";
						}?></td>
						<td style="text-align: center;"><a href="info_consulta.php?id=<?php echo $y->idc;?>"><img src="IMG/consulta.png" height="20px;"> Detalhar</a></td>
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