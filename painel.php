<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$id_session = $_SESSION['id'];

	$query = mysqli_query($conn, "SELECT * FROM usuarios INNER JOIN tipo_sangue ON usuarios.id_sangue = tipo_sangue.id WHERE id_usuario = '$id_session' LIMIT 1;");

	$vac = mysqli_query($conn,"SELECT v.*, u.* FROM vacinacao as v INNER JOIN usuarios as u ON v.id_usuario = u.id_usuario WHERE v.id_usuario = '$id_session' AND v.dt_dose IS NULL AND v.id_dependente IS NULL LIMIT 3;");
	$rowcount = mysqli_num_rows($vac);

	$dep = mysqli_query($conn,"SELECT d.*, p.tipo FROM dependente as d INNER JOIN parentesco as p ON d.id_parentesco = p.id WHERE d.id_usuario = '$id_session' ORDER BY d.id ASC LIMIT 3;");
	$rowcount1 = mysqli_num_rows($dep);

	$med = mysqli_query($conn,"SELECT im.nome_medicamento, f.alternativa FROM info_medicamento as im INNER JOIN medicamentos as m ON m.id = im.id_medicamento INNER JOIN frequencia as f ON f.id = im.id_frequencia WHERE m.id_usuario = '$id_session' AND m.status = 1 AND im.id_frequencia != 5 AND m.id_dependente IS NULL LIMIT 3;");
	$rowcount2 = mysqli_num_rows($med);

	$cons = mysqli_query($conn,"SELECT ic.* FROM info_consultas as ic INNER JOIN consultas as c ON c.id = ic.id_consulta WHERE c.id_usuario = '$id_session' AND c.status = 1 AND c.id_dependente IS NULL LIMIT 3;");
	$rowcount3 = mysqli_num_rows($cons);
?>
<section class="conteudo">
	<h1>Bem Vindo, <?php echo $_SESSION['nome']; ?></h1>
	<p class="min-center">Esse é o seu painel com suas principais informações</p>

	<section class="cards">
		<div class="min-cards">
			<div class="card">
				<p class="card-title">Vacinação</p>
				<?php
					if ($rowcount < 1) {
				?>
						<p>Sem vacinação</p>
				<?php
					}else{
						while($y = mysqli_fetch_object($vac)){?>
							<p><?php echo $y->vacina; ?><small><?php echo date("d/m/Y", strtotime($y->dt_ven)); ?></small></p>
				<?php 	} 
					}
				?>
			</div>
			<div class="card">
				<p class="card-title">Medicação</p>
				<?php
					if ($rowcount2 < 1) {
				?>
						<p>Sem medicação</p>
				<?php
					}else{
						while($a = mysqli_fetch_object($med)){?>
							<p><?php echo $a->nome_medicamento; ?><small><?php echo $a->alternativa; ?></small></p>
				<?php 	} 
					}
				?>
			</div>
			<div class="card">
				<p class="card-title">Consultas</p>
				<?php
					if ($rowcount3 < 1) {
				?>
						<p>Sem consultas</p>
				<?php
					}else{
						while($b = mysqli_fetch_object($cons)){?>
							<p><?php echo $b->nome_consulta; ?><small><?php echo date("d/m/Y", strtotime($b->data_consulta)); ?></small></p>
				<?php 	} 
					}
				?>
			</div>
			<div class="card">
				<p class="card-title">Dependentes</p>
				<?php
					if ($rowcount1 < 1) {
				?>
						<p>Sem cadastros</p>
				<?php
					}else{
						while($z = mysqli_fetch_object($dep)){?>
							<p><?php echo $z->nome, " ", $z->sobrenome; ?><small></small></p>
				<?php 	} 
					}
				?>
			</div>
		</div>
	</section>

	<div style="clear: both;"></div>

	<section class="avisos">
		<h3>Quadro de avisos</h3>
		<div class="card-aviso atencao">
			<p>Cuidado com o coronavírus, proteja-se <br> Acesse: <a href="http://coronavirus.saude.gov.br/" target="_blank">coronavirus.saude.gov.br</a></p>
		</div>
		<div class="card-aviso alerta">
			<p>Consultas médicas estão suspensas <br> temporariamente devido ao coronavírus</p>
		</div>
	</section>

	<section class="info-user">
		<h3>Informações rápidas</h3>
		<p><span>Nome: </span><?php echo $_SESSION['nome'], ' ', $_SESSION['sobrenome']; ?></p>
		<p><span>Registro: </span><?php echo $_SESSION['id']; ?></p>
		<?php
		while($x = mysqli_fetch_object($query)){?>
				<p><span>Cartão SUS: </span><?php echo $x->sus; ?></p>
				<p><span>Sangue: </span><?php echo $x->sangue; ?></p>
				<p><span>Alergias: </span><?php echo $x->alergia; ?></p>
				<p><span>Doenças: </span><?php echo $x->doencas; ?></p>
		<?php }?>

			<div class="txt-r"><a href="configuracoes.php"><img src="IMG/extern.png" alt="Perfil" class="extern"></a></div>
		</section>

	</section>
	<?php
		include ('footer.php');
	?>