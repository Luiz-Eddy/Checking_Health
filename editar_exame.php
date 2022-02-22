<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$id_exame = $_GET['id'];
	$id_att = $_GET['idatt'];
	$id_usuario = $_SESSION['id'];

	if (!empty($id_exame) && !empty($id_att)) {
		$queryv = "SELECT * FROM exames WHERE id = '$id_exame' AND id_usuario = '$id_usuario' LIMIT 1;";
		$verifica = mysqli_query($conn, $queryv);

		$rowcount = mysqli_num_rows($verifica);

		if ($rowcount == 1) {
			$queryv1 = "SELECT * FROM info_exames WHERE id = '$id_att'";
			$verifica1 = mysqli_query($conn, $queryv1);

			$rowcount1 = mysqli_num_rows($verifica1);

			if ($rowcount1 == 1) {
				$x = mysqli_fetch_object($verifica1);
				$id_examint = $x->id_exames;

				$queryv2 = "SELECT * FROM exames WHERE id = '$id_examint';";
				$exec = mysqli_query($conn, $queryv2);

				$y = mysqli_fetch_object($exec);
				$id_dep = $y->id_dependente;

				if (!empty($id_dep)) {
					$infos = mysqli_query($conn, "SELECT e.*, e.id_dependente as idu, ie.*, d.nome, d.sobrenome FROM exames as e INNER JOIN info_exames as ie ON e.id = ie.id_exames INNER JOIN dependente as d ON d.id = e.id_dependente WHERE e.id = '$id_exame' AND ie.id = '$id_att' AND e.id_usuario = '$id_usuario' AND d.id = e.id_dependente");
					$z = mysqli_fetch_object($infos);

					$getusu = mysqli_query($conn,"SELECT * FROM dependente WHERE id_usuario = '$id_usuario' AND id_parentesco != 0 ORDER BY id ASC;");
				}else{
					$infos = mysqli_query($conn, "SELECT e.*, e.id_usuario as idu, ie.*, u.nome, u.sobrenome FROM exames as e INNER JOIN info_exames as ie ON e.id = ie.id_exames INNER JOIN usuarios as u ON u.id_usuario = e.id_usuario WHERE e.id = '$id_exame' AND ie.id = '$id_att' AND e.id_usuario = '$id_usuario' AND u.id_usuario = e.id_usuario");
					$z = mysqli_fetch_object($infos);

					$getusu = mysqli_query($conn,"SELECT * FROM dependente WHERE id_usuario = '$id_usuario' AND id_parentesco != 0 ORDER BY id ASC;");
				}
			}else {
				$_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos essa atualização</div>";
				header("Location: exames.php");
				exit();
			}
		} else {
			$_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse exame</div>";
			header("Location: exames.php");
			exit();
		}
	} else {
		$_SESSION['msg'] = "<div class='toast-cad-false'>Não localizamos esse exame</div>";
		header("Location: exames.php");
		exit();
	}
?>
<section class="conteudo">
	<h1>Editar exame</h1>
	<p class="min-center">Atualize aqui as informações do exame</p>
	
	<section class="cadastro-form">
		<form method="POST" action="FUNCOES/att_exame.php?id=<?php echo $id_exame; ?>&idatt=<?php echo $id_att; ?>" enctype="multipart/form-data">
			<label for="user">Usuário:
				<select name="user" class="select" required="required">
					<option value="<?php echo $z->idu; ?>">Atual: <?php echo $z->nome, ' ', $z->sobrenome; ?></option>
					<option value="<?php echo $_SESSION['id']; ?>"><?php echo $_SESSION['nome'], ' ', $_SESSION['sobrenome']; ?></option>
					<?php while($a = mysqli_fetch_object($getusu)){ ?>
						<option value="<?php echo $a->id; ?>"><?php echo $a->nome, ' ', $a->sobrenome; ?></option>
					<?php } ?>
				</select>
			</label>
			<label for="dtexam">Data do exame:
				<input type="date" name="dtexam" required="required" value="<?php echo date("Y-m-d", strtotime($z->data_exame)); ?>">
			</label>
			<label for="desc">Descrição:
				<textarea name="desc" placeholder="Digite aqui detalhes sobre este exame" required="required"><?php echo $z->descricao; ?></textarea> 
				<div style="clear: both;"></div>
			</label>
			<label for="arquivo">Arquivo:
				<input type="file" name="arquivo">
			</label>

			<?php if (!empty($z->arquivo)) { ?>
				<p style="text-align: right; color: #6d6d6d; font-size: 12px;">Arquivo atual: <a href="UPLOADS/<?php echo $z->arquivo; ?>" style="color: #000;"><?php echo $z->arquivo; ?></a></p>
			<?php }else{ ?>
				<p style="text-align: right; color: #6d6d6d; font-size: 12px;">Nenhum arquivo carregado nessa atualização</p>
			<?php } ?>
			
			<br>
							
			<input type="submit" name="enviar" class="btn-form" value="Atualizar" onclick="return confirm('Ao confirmar, todas as mudanças realizadas irão sobrescrescrever as anteriores. Caso o usuário seja alterado, o mesmo será alterado para todo o exame.')">
		</form>
	</section>
</section>
<?php
	include ('footer.php');
?>