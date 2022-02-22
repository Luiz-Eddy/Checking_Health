<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$id_session = $_SESSION['id'];

	$query = mysqli_query($conn,"SELECT d.*, p.tipo FROM dependente as d INNER JOIN parentesco as p ON d.id_parentesco = p.id WHERE d.id_usuario = '$id_session' ORDER BY d.id ASC;");
?>
<section class="conteudo">
	<h1>Dependentes</h1>
	<p class="min-center">Veja abaixo os dependentes cadastrados em seu perfil</p>

	<br>
	<a href="cadastro_dependente.php" class="btn btn-padrao btn1">Cadastrar novo</a>
	
	<?php if (mysqli_num_rows($query) < 1) { ?>
		<div class="sem-resultado">
			<img src="IMG/Nenhum.png">
			<h3>Nenhum dependente cadastrado</h3>
		</div>
	<?php }else{ ?>
		<table>
			<thead>
				<tr>
					<th>Registro</th>
					<th>Nome Completo</th>
					<th>Parentesco</th>
					<th>Data de Nascimento</th>
					<th>CPF</th>
					<th>Telefone</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php while($x = mysqli_fetch_object($query)){ ?>
					<tr>
						<td><?php echo $x->id; ?></td>
						<td><?php echo $x->nome, ' ', $x->sobrenome; ?></td>
						<td><?php echo $x->tipo; ?></td>
						<td><?php echo date("d/m/Y", strtotime($x->dt_nasc)); ?></td>
						<td><?php echo $x->cpf; ?></td>
						<td><?php echo $x->telefone; ?></td>
						<td><a href="editar_dependente.php?id=<?php echo $x->id ?>"><img src="IMG/editar.png" alt="Editar" width="20px"></a> <a href="FUNCOES/dl_dependente.php?id=<?php echo $x->id ?>" onclick="return confirm('Tem certeza que deseja remover o dependente <?php echo $x->nome;?>?')"><img src="IMG/deletar.png" alt="Excluir" width="20px"></a></td>
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