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
		"SELECT ic.*, d.*, d.id as idd, c.*, c.id as idc
		FROM info_consultas as ic
		INNER JOIN consultas as c
		ON ic.id_consulta = c.id
		INNER JOIN dependente as d
		ON d.id = c.id_dependente
		WHERE c.id_usuario = '$id_usuario' AND c.id = '$id_consulta' AND d.id = c.id_dependente;");
	}else{
		$query = mysqli_query($conn,
		"SELECT ic.*, u.*, u.id_usuario as idu, c.*, c.id as idc
		FROM info_consultas as ic
		INNER JOIN consultas as c
		ON ic.id_consulta = c.id
		INNER JOIN usuarios as u
		ON u.id_usuario = c.id_usuario
		WHERE c.id_usuario = '$id_usuario' AND c.id = '$id_consulta' AND c.id_dependente IS NULL;");
	}
	$z = mysqli_fetch_object($query);
?>

<section class="conteudo">
	<h1>Alterar Consulta</h1>
	<p class="min-center">Atualize as informações da sua consulta</p>

	<section class="cadastro-form">
		<form method="POST" action="FUNCOES/att_consulta.php?id=<?php echo $z->idc; ?>" enctype="multipart/form-data">
			<label for="user">Usuário:
				<input type="text" name="user" readonly disabled value="<?php echo $z->nome, ' ', $z->sobrenome; ?>" placeholder="Nome do usuário.">
			</label>

			<label for="nomecons">Especialização da Consulta:
				<input type="text" name="nomecons" required="required" value="<?php echo $z->nome_consulta ?>">
			</label>
				
			<label for="nomemed">Nome do(a) Médico(a):
				<input type="text" name="nomemed" required="required" value="<?php echo $z->nome_medico ?>">
			</label>

			<label for="dtcons">Data da Consulta:
				<input type="date" name="dtcons" required="required" value="<?php echo date("Y-m-d", strtotime($z->data_consulta)); ?>">
			</label>

			<label for="htcons">Hora da Consulta:
				<input type="time" name="htcons" required="required" value="<?php echo $z->hora_consulta ?>">
			</label>

			<label for="dterm">Data Realizada:
				<?php if ($z->data_realizada == NULL) { ?>
					<input type="date" name="dterm">
				<?php } else { ?>
					<input type="date" name="dterm" value="<?php echo date("Y-m-d", strtotime($z->data_realizada)); ?>">
				<?php } ?>
			</label>

			<label for="hterm">Hora Realizada:
				<?php if ($z->hora_realizada == NULL) { ?>
					<input type="time" name="hterm" placeholder="12:35">
				<?php } else { ?>
					<input type="time" name="hterm" placeholder="12:35" value="<?php echo $z->hora_realizada ?>">
				<?php } ?>
			</label>

			<label for="lcons">Local da Consulta:
				<input type="text" name="lcons" required="required" value="<?php echo $z->local ?>">
			</label>

			<label for="desc">Descrição:
				<textarea name="desc" placeholder="Digite aqui uma descrição detalhada sobre a consulta"><?php echo $z->descricao ?></textarea>
				<div style="clear: both;"></div>
			</label>

			<label for="arquivo">Arquivo:
				<input type="file" name="arquivo">
			</label>
			<?php
				if (!empty($z->arquivo)) {
			?>
				<p style="text-align: right; color: #6d6d6d; font-size: 12px;">Arquivo atual: <a href="UPLOADS/<?php echo $z->arquivo; ?>" style="color: #000;" target="_blank"><?php echo $z->arquivo; ?></a></p>
			<?php
				}else{
			?>
				<p style="text-align: right; color: #6d6d6d; font-size: 12px;">Nenhum arquivo carregada</p>
			<?php
				}
			?>
			<br>
			<input type="submit" name="enviar" class="btn-form" value="Salvar">
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