<?php 
    require_once ('header.php'); 
    require_once ('barra.php');
    include_once("FUNCOES/CONNECTION/connect.php");

    $id_vacina = $_GET['id'];
    $id_session = $_SESSION['id'];

    if (!empty($id_vacina)) {
		$queryv = "SELECT * FROM vacinacao WHERE id = '$id_vacina' AND id_usuario = '$id_session' LIMIT 1;";
		$verifica = mysqli_query($conn, $queryv);

		$rowcount = mysqli_num_rows($verifica);

		$x = mysqli_fetch_object($verifica);
		$id_dep = $x->id_dependente;

		if (!empty($id_dep)) {
			$select = "SELECT v.*, v.obs as obsi, d.*, d.id as id_i FROM vacinacao as v INNER JOIN dependente as d ON v.id_dependente = d.id WHERE v.id_usuario = '$id_session' AND v.id_dependente = '$id_dep' AND v.id = '$id_vacina';";
			$getinfo = mysqli_query($conn, $select);

			$z = mysqli_fetch_object($getinfo);
		}else{
			$select = "SELECT v.*, v.obs as obsi, u.*, u.id_usuario as id_i FROM vacinacao as v INNER JOIN usuarios as u ON v.id_usuario = u.id_usuario WHERE v.id_usuario = '$id_session' AND v.id = '$id_vacina' AND v.id_dependente IS NULL;";
			$getinfo = mysqli_query($conn, $select);

			$z = mysqli_fetch_object($getinfo);
		}
	}else{
		$_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse cadastro</div>";
		header("Location: vacinacao.php");
		exit();
	}
?>

<section class="conteudo">
	<h1>Atualizar vacinação</h1>
	<p class="min-center">Mantenha as informações da vacinação atualizadas</p>
	<section class="cadastro-form">
		<form method="POST" action="FUNCOES/att_vacina.php?id=<?php echo $id_vacina; ?>" enctype="multipart/form-data">

			<label for="nomevac">Nome da Vacina:
			<input type="text" name="nomevac" required="required" value="<?php echo $z->vacina; ?>"></label>

			<label for="user">Usuário:
				<input type="text" name="user" readonly disabled value="<?php echo $z->nome, ' ', $z->sobrenome; ?>" placeholder="Nome do usuário.">
			</label>
			
            <label for="local">Local da Vacina:
				<input type="text" name="local" value="<?php echo $z->local_vacina; ?>">
			</label>

            <label for="dtvac">Data da Vacina:
				<input type="date" name="dtvac" required="required" value="<?php echo date("Y-m-d", strtotime($z->dt_ven)); ?>">
			</label>

			<label for="dtok">Vacinado em:
			<?php
				if ($z->dt_dose == NULL | $z->dt_dose == 0) {
			?>
				<input type="date" name="dtok" value=""></label>
			<?php
				}else{
			?>
				<input type="date" name="dtok" value="<?php echo date("Y-m-d", strtotime($z->dt_dose)); ?>"></label>
			<?php
				}
			?>
			</label>

			<label for="obs">Observações:
				<textarea name="obs" placeholder="Descreva aqui detalhes sobre a vacinação"><?php echo $z->obsi; ?></textarea>
				<!-- Limpeza de elementos float -->
				<div style="clear: both;"></div>
			</label>

			<label for="arquivo">Arquivos:
				<input type="file" name="arquivo">
			</label>
			<?php
				if (!empty($z->arquivo)) {
			?>
				<p style="text-align: right; color: #6d6d6d; font-size: 12px;">Arquivo atual: <a href="UPLOADS/<?php echo $z->arquivo; ?>" style="color: #000;" target="_blank"><?php echo $z->arquivo; ?></a></p>
			<?php
				}else{
			?>
				<p style="text-align: right; color: #6d6d6d; font-size: 12px;">Nenhum arquivo carregado nessa vacinação</p>
			<?php
				}
			?>
			<br>

			<input type="submit" name="enviar" class="btn-form" value="Salvar" onclick="return confirm('Ao confirmar, todas as mudanças realizadas irão sobrescrescrever as anteriores, incluindo o arquivo (caso tenha selecionado um).')">
		</form>
	</section>
</section>
    <?php
		if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
		}
	?>