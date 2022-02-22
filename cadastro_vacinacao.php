<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$id_usuario = $_SESSION['id'];

	$query = mysqli_query($conn,"SELECT * FROM dependente WHERE id_usuario = '$id_usuario' AND id_parentesco != 0 ORDER BY id ASC;");
?>

<section class="conteudo">
	<h1>Cadastro de Vacinação</h1>
	<p class="min-center">Cadastre suas vacinas para manter um maior controle de suas informações</p>

	<section class="cadastro-form">
		<form method="POST" action="FUNCOES/nw_vacinas.php">
			<label for="nomevac">Nome da vacina:
				<input type="text" name="nomevac" required="required" placeholder="Insira o nome">
			</label>

			<label for="user">Usuário:
				<select name="user" class="select" required="required">
					<option value="">Selecione</option>
					<option value="<?php echo $_SESSION['id']; ?>"><?php echo $_SESSION['nome'], ' ', $_SESSION['sobrenome']; ?></option>
					<?php while($x = mysqli_fetch_object($query)){ ?>
						<option value="<?php echo $x->id; ?>"><?php echo $x->nome, ' ', $x->sobrenome; ?></option>
					<?php } ?>
				</select>
			</label>

			<label for="local">Local de vacinação:
				<input type="text" name="local" placeholder="Onde irá vacinar?">
			</label>

			<label for="dtvac">Data da vacina:
				<input type="date" name="dtvac" required="required">
			</label>

			<label for="obs">Observações:
				<textarea name="obs" placeholder="Escreva aqui, todas as informações necessárias para a vacinação."></textarea>
				<!-- Limpeza de elementos float -->
				<div style="clear: both;"></div>
			</label>

			<input type="submit" name="enviar" class="btn-form" value="Cadastrar">
		</form>

		<?php
			if(isset($_SESSION['msg'])){
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
		?>
	</section>
</section>

<?php
	include ('footer.php');
?>