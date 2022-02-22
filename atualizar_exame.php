<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$id_usuario = $_SESSION['id'];
	$id_exame = $_GET['id'];

	if (!empty($id_exame)) {
		$queryv = "SELECT * FROM exames WHERE id = '$id_exame' AND id_usuario = '$id_usuario' LIMIT 1;";
		$verifica = mysqli_query($conn, $queryv);

		$rowcount = mysqli_num_rows($verifica);

		if($rowcount == 1){
			$queryv1 = "SELECT id_dependente FROM exames WHERE id = '$id_exame'";
			$verifica1 = mysqli_query($conn, $queryv1);

			$x = mysqli_fetch_object($verifica1);

			if (!empty($x->id_dependente)) {
				$query = "SELECT e.*, ie.*, d.* FROM exames as e INNER JOIN info_exames as ie ON ie.id_exames = e.id INNER JOIN dependente as d ON d.id = e.id_dependente WHERE e.id_usuario = '$id_usuario' AND e.id = '$id_exame'";
				$exec1 = mysqli_query($conn, $query);
			}else{
				$query = "SELECT e.*, ie.*, u.* FROM exames as e INNER JOIN info_exames as ie ON ie.id_exames = e.id INNER JOIN usuarios as u ON u.id_usuario = e.id_usuario WHERE e.id_usuario = '$id_usuario' AND e.id = '$id_exame'";
				$exec1 = mysqli_query($conn, $query);
			}
?>
	<section class="conteudo">
		<h1>Cadastrar atualização do exame</h1>
		<p class="min-center">Mantenha o estado do exame sempre atualizado para não perder nenhuma informação</p>
		<?php $x = mysqli_fetch_object($exec1); ?>
		<section class="cadastro-form">
			<form method="POST" action="FUNCOES/nw_att_exame.php?id=<?php echo $id_exame; ?>" enctype="multipart/form-data">
				<label for="user">Usuário:
					<select name="user" class="select" required="required">
						<option value="<?php echo $x->id; ?>">Usando: <?php echo $x->nome, ' ', $x->sobrenome; ?></option>
					</select>
				</label>
				<label for="dtexam">Data do exame:
					<input type="date" name="dtexam" required="required">
				</label>
				<label for="desc">Descrição:
					<textarea name="desc" placeholder="Digite aqui detalhadamente sobre o exame realizado" required="required"></textarea>
					<div style="clear: both;"></div>
				</label>
				<label for="arquivo">Arquivos:
					<input type="file" name="arquivo">
				</label>
									
				<p style="text-align: right; color: #6d6d6d; font-size: 12px;">* Não é possível alterar o usuário do exame</p>
				<br>
				<input type="submit" name="enviar" class="btn-form" value="Cadastrar">
			</form>
		</section>
	<?php
		if(isset($_SESSION['msg'])){
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
	?>

	<?php
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
	</section>
<?php
	include ('footer.php');
?>