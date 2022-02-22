<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$id_usuario = $_SESSION['id'];
	$id_consulta = $_GET['id'];

	// Valida acesso
	if (!empty($id_consulta)) {
		$queryv1 = "SELECT * FROM consultas WHERE id = '$id_consulta' AND id_usuario = '$id_usuario' LIMIT 1;";
		$verifica = mysqli_query($conn, $queryv1);
		$rowcount = mysqli_num_rows($verifica);
		if ($rowcount != 1) {
			$_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos essa consulta</div>";
			header("Location: consultas.php");
			exit();
		}
	}else{
		$_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos essa consulta</div>";
		header("Location: consultas.php");
		exit();
	}
	// Fim do valida acesso
	
	$queryv = mysqli_query($conn,"SELECT c.id_dependente FROM consultas as c WHERE c.id = '$id_consulta' AND c.id_usuario = '$id_usuario' LIMIT 1;");
	$x = mysqli_fetch_object($queryv);

	if($x->id_dependente != NULL){
		$query = mysqli_query($conn,
		"SELECT ic.*, d.*, d.id as idd, c.*
		FROM info_consultas as ic
		INNER JOIN consultas as c
		ON ic.id_consulta = c.id
		INNER JOIN dependente as d
		ON d.id = c.id_dependente
		WHERE c.id_usuario = '$id_usuario' AND c.id = '$id_consulta' AND d.id = c.id_dependente;");
	}else{
		$query = mysqli_query($conn,
		"SELECT ic.*, u.*, u.id_usuario as idu, c.*
		FROM info_consultas as ic
		INNER JOIN consultas as c
		ON ic.id_consulta = c.id
		INNER JOIN usuarios as u
		ON u.id_usuario = c.id_usuario
		WHERE c.id_usuario = '$id_usuario' AND c.id = '$id_consulta' AND c.id_dependente IS NULL;");
	}
?>

<section class="conteudo">
	<h1>Detalhes da Consulta</h1>
	<p class="min-center">Veja e atualize as informações da consulta por aqui</p>
	
	<a href="editar_consulta.php?id=<?php echo $id_consulta; ?>" class="btn btn-padrao btn1 ex-btn">Editar Informações</a>

	<div class="excluir_exame">
		<p>X</p>
		<a href="FUNCOES/dl_consulta.php?id=<?php echo $id_consulta; ?>" onclick="return confirm('Ao invés de deletar a consulta, você pode marcar como realizada em editar informações, deseja prosseguir com a remoção?')">Remover</a>
	</div>
	
	<div style="clear: both;"></div>
	<div class="info-ex-1" style="margin-bottom: 3em;">
		<?php $x = mysqli_fetch_object($query); ?>
		<h1>Informações</h1>
		<h2>Usuário</h2>
		<p><?php echo $x->nome, " ", $x->sobrenome; ?></p>

		<h2>Consulta</h2>
		<p><?php echo $x->nome_consulta; ?></p>

		<h2>Médico</h2>
		<p><?php echo $x->nome_medico; ?></p>

		<h2>Descrição</h2>
		<p><?php if($x->descricao == ""){
					echo "Não definido";
				}else{
					echo $x->descricao;
				} ?></p>

		<h2>Data da Consulta</h2>
		<p><?php echo date("d/m/Y", strtotime($x->data_consulta)); ?></p>

		<h2>Hora da Consulta</h2>
		<p><?php echo $x->hora_consulta; ?></p>

		<h2>Data de realização</h2>
		<p>
			<?php if ($x->data_realizada == NULL) {
				echo "Não definido";
			}else{
				echo date("d/m/Y", strtotime($x->data_realizada));
			} ?>
		</p>

		<h2>Hora da realização</h2>
		<p>
			<?php if ($x->hora_realizada == NULL) {
				echo "Não definido";
			}else{
				echo $x->hora_realizada;
			} ?>
		</p>

		<h2>Local</h2>
		<p><?php echo $x->local; ?></p>
	</div>
	<div class="info-ex-2">
		<?php 
		if($x->arquivo == NULL){
			?>
			<img src="IMG/logo_download.png" style="filter: grayscale(100);">
			<p style="font-size: 10px; color: #6d6d6d;">Opa!</p>
			<p>Nenhum arquivo carregado para essa consulta</p>
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
		if(isset($_SESSION['msg'])){
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
	?>
</section>
<?php
	include ('footer.php');
?>