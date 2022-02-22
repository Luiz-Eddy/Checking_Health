<?php 
	require_once ('header.php'); 
	require_once ('barra.php');
	include_once("FUNCOES/CONNECTION/connect.php");

	$id_session = $_SESSION['id'];

	$vac = mysqli_query($conn,"SELECT v.*, u.* FROM vacinacao as v INNER JOIN usuarios as u ON v.id_usuario = u.id_usuario WHERE v.id_usuario = '$id_session' AND v.id_dependente IS NULL;");
	$vac1 = mysqli_query($conn,"SELECT v.*, d.nome, d.sobrenome FROM vacinacao as v INNER JOIN usuarios as u ON v.id_usuario = u.id_usuario INNER JOIN dependente as d ON v.id_dependente = d.id WHERE v.id_usuario = '$id_session' AND v.id_dependente != 0;");
?>

<!-- Cronograma -->
	<div class="overlay oc-ov" id="overlay" style="z-index: 10;">
		<div class="cronograma-vac">
			<div class="close-btn">
				<img src="IMG/fechar.png" alt="Fechar" onclick="closeCronograma();">
			</div>
			<h2>Cronograma de vacinação do SUS</h2>
			<p>Selecione uma opção no menu abaixo para realizar a consulta</p>
			<nav class="menu-cron">
				<ul>
					<li onclick="dcrianca();">Criança</li>
					<li onclick="dadolescente();">Adolescente</li>
					<li onclick="dadulto();">Adulto</li>
					<li onclick="didoso();">Idoso</li>
					<li onclick="dgestante();">Gestante</li>
					<li onclick="dindigena();">Povos Indígenas</li>
				</ul>
			</nav>

			<div class="box-info bx1" id="crianca">
				<h3>Criança</h3>
				<p>Para vacinar, basta levar a criança a um posto ou Unidade Básica de Saúde (UBS) com o cartão/caderneta da criança. O ideal é que cada dose seja administrada na idade recomendada. Entretanto, se perdeu o prazo para alguma dose é importante voltar à unidade de saúde para atualizar as vacinas. A maioria das vacinas disponíveis no Calendário Nacional de Vacinação é destinada a crianças. São 15 vacinas, aplicadas antes dos 10 anos de idade.</p>

				<h4>Ao Nascer:</h4>
				<p><strong>BCG (Bacilo Calmette-Guerin)</strong> – (previne as formas graves de tuberculose, principalmente miliar e meníngea) - dose única</p>
				<p><strong>Hepatite B</strong> – (previne a hepatite B) - dose ao nascer</p>

				<h4>2 meses:</h4>
				<p><strong>Penta</strong> (previne difteria, tétano, coqueluche, hepatite B e infecções causadas pelo Haemophilus influenzae B) – 1ª dose</p>
				<p><strong>Vacina Poliomielite 1, 2 e 3 (inativada) - (VIP)</strong> (previne a poliomielite) – 1ª dose</p>
				<p><strong>Pneumocócica 10 Valente (conjugada)</strong>  (previne a pneumonia, otite, meningite e outras doenças causadas pelo Pneumococo) – 1ª dose</p>
				<p><strong>Rotavírus humano</strong> (previne diarreia por rotavírus) – 1ª dose</p>

				<h4>3 meses:</h4>
				<p><strong>Meningocócica C (conjugada)</strong> - (previne Doença invasiva causada pela Neisseria meningitidis do sorogrupo C) – 1ª dose</p>

				<h4>4 meses:</h4>
				<p><strong>Penta</strong> (previne difteria, tétano, coqueluche, hepatite B e infecções causadas pelo Haemophilus influenzae B) – 2ª dose</p>
				<p><strong>Vacina Poliomielite 1, 2 e 3 (inativada) - (VIP)</strong> (previne a poliomielite) – 2ª dose</p>
				<p><strong>Pneumocócica 10 Valente (conjugada)</strong>  (previne a pneumonia, otite, meningite e outras doenças causadas pelo Pneumococo) – 2ª dose</p>
				<p><strong>Rotavírus humano</strong> (previne diarreia por rotavírus) – 2ª dose</p>

				<h4>5 meses:</h4>
				<p><strong>Meningocócica C (conjugada)</strong> - (previne Doença invasiva causada pela Neisseria meningitidis do sorogrupo C) – 2ª dose</p>

				<h4>6 meses:</h4>
				<p><strong>Penta</strong> (previne difteria, tétano, coqueluche, hepatite B e infecções causadas pelo Haemophilus influenzae B) – 3ª dose</p>
				<p><strong>Vacina Poliomielite 1, 2 e 3 (inativada) - (VIP)</strong> (previne a poliomielite) – 3ª dose</p>

				<h4>9 meses:</h4>
				<p><strong>Febre Amarela</strong> – uma dose (previne a febre amarela)</p>

				<h4>12 meses:</h4>
				<p><strong>Tríplice viral</strong> (previne sarampo, caxumba e rubéola) – 1ª dose</p>
				<p><strong>Pneumocócica 10 Valente (conjugada)</strong> - (previne pneumonia, otite, meningite e outras doenças causadas pelo Pneumococo) – Reforço</p>
				<p><strong>Meningocócica C (conjugada)</strong> (previne doença invasiva causada pela Neisseria meningitidis do sorogrupo C) – Reforço</p>

				<h4>15 meses:</h4>
				<p><strong>DTP</strong> (previne a difteria, tétano e coqueluche) – 1º reforço</p>
				<p><strong>Vacina Poliomielite 1 e 3 (atenuada) (VOP)</strong> (previne poliomielite) – 1º reforço</p>
				<p><strong>Hepatite A</strong> – uma dose</p>
				<p><strong>Tetra viral</strong> – (previne sarampo, rubéola, caxumba e varicela/catapora) - Uma dose</p>

				<h4>4 anos:</h4>
				<p><strong>DTP</strong> (previne a difteria, tétano e coqueluche) – 2º reforço</p>
				<p><strong>Vacina Poliomielite 1 e 3 (atenuada) (VOP)</strong> (previne poliomielite) – 2º reforço</p>
				<p><strong>Varicela atenuada</strong> (previne varicela/catapora) – uma dose</p>
				
				<div class="info">
					<p><strong>Atenção:</strong>Crianças de 6 meses a 5 anos (5 anos 11 meses e 29 dias) de idade deverão tomar uma ou duas doses da vacina influenza durante a Campanha Anual de Vacinação da Gripe.</p>
				</div>
			</div>

			<div class="box-info bx2" id="adolescente">
				<h3>Adolescente</h3>
				<p>A caderneta de vacinação deve ser frequentemente atualizada. Algumas vacinas só são administradas na adolescência. Outras precisam de reforço nessa faixa etária. Além disso, doses atrasadas também podem ser colocadas em dia. Veja as vacinas recomendadas a adolescentes:</p>

				<h4>MENINAS 9 a 14 anos:</h4>
				<p><strong>HPV</strong> (previne o papiloma, vírus humano que causa cânceres e verrugas genitais) - 2 doses (seis meses de intervalo entre as doses)</p>

				<h4>MENINOS 11 a 14 anos:</h4>
				<p><strong>HPV</strong> (previne o papiloma, vírus humano que causa cânceres e verrugas genitais) - 2 doses (seis meses de intervalo entre as doses)</p>

				<h4>11 a 14 anos:</h4>
				<p><strong>Meningocócica C (conjugada)</strong> (previne doença invasiva causada por Neisseria meningitidis do sorogrupo C) – Dose única ou reforço (a depender da situação vacinal anterior)</p>

				<h4>10 a 19 anos:</h4>
				<p><strong>Hepatite B</strong> - 3 doses (a depender da situação vacinal anterior)</p>
				<p><strong>Febre Amarela</strong> – 1 dose (a depender da situação vacinal anterior)</p>
				<p><strong>Dupla Adulto (dT)</strong> (previne difteria e tétano) – Reforço a cada 10 anos</p>
				<p><strong>Tríplice viral</strong> (previne sarampo, caxumba e rubéola) - 2 doses (de acordo com a situação vacinal anterior)</p>
				<p><strong>Pneumocócica 23 Valente</strong> (previne pneumonia, otite, meningite e outras doenças causadas pelo Pneumococo) – 1 dose (a depender da situação vacinal anterior) - (está indicada para população indígena e grupos-alvo específicos)</p>
			</div>
			
			<div class="box-info bx3" id="adulto">
				<h3>Adulto</h3>
				<p>É muito importante que os adultos mantenham suas vacinas em dia. Além de se proteger, a vacina também evita a transmissão para outras pessoas que não podem ser vacinadas. Imunizados, familiares podem oferecer proteção indireta a bebês que ainda não estão na idade indicada para receber algumas vacinas, além de outras pessoas que não estão protegidas. Veja lista de vacinas disponibilizadas a adultos de 20 a 59 anos:</p>

				<h4>20 a 59 anos:</h4>
				<p><strong>Hepatite B</strong> - 3 doses (a depender da situação vacinal anterior)</p>
				<p><strong>Febre Amarela</strong> – dose única (a depender da situação vacinal anterior)</p>
				<p><strong>Tríplice viral</strong> (previne sarampo, caxumba e rubéola) – Verificar a situação vacinal anterior, se nunca vacinado: receber 2 doses (20 a 29 anos) e 1 dose (30 a 49 anos);</p>
				<p><strong>Dupla adulto (dT)</strong> (previne difteria e tétano) – Reforço a cada 10 anos</p>
				<p><strong>Pneumocócica 23 Valente</strong> (previne pneumonia, otite, meningite e outras doenças causadas pelo Pneumococo) – 1 dose (Está indicada para população indígena e grupos-alvo específicos)</p>
			</div>

			<div class="box-info bx4" id="idoso">
				<h3>Idoso</h3>
				<p>São quatro as vacinas disponíveis para pessoas com 60 anos ou mais, além da vacina anual contra a gripe:</p>

				<h4>60 anos ou mais:</h4>
				<p><strong>Hepatite B</strong> - 3 doses (verificar situação vacinal anterior)</p>
				<p><strong>Febre Amarela</strong> – dose única (verificar situação vacinal anterior)</p>
				<p><strong>Dupla Adulto (dT)</strong>  - (previne difteria e tétano) – Reforço a cada 10 anos</p>
				<p><strong>Pneumocócica 23 Valente</strong> (previne pneumonia, otite, meningite e outras doenças causadas pelo Pneumococo) – reforço (a depender da situação vacinal anterior) - A vacina está indicada para população indígena e grupos-alvo específicos, como pessoas com 60 anos e mais não vacinados que vivem acamados e/ou em instituições fechadas.</p>
				<p><strong>Influenza</strong> – Uma dose (anual)</p>
			</div>

			<div class="box-info bx5" id="gestante">
				<h3>Gestante</h3>
				<p>A vacina para mulheres grávidas é essencial para prevenir doenças para si e para o bebê. Veja as vacinas indicadas para gestantes.</p>

				<h4>Gestantes</h4>
				<p><strong>Hepatite B</strong> - 3 doses (a depender da situação vacinal anterior)</p>
				<p><strong>Dupla Adulto (dT)</strong> (previne difteria e tétano) – 3 doses (a depender da situação vacinal anterior)</p>
				<p><strong>dTpa</strong> (Tríplice bacteriana acelular do tipo adulto) – (previne difteria, tétano e coqueluche) – Uma dose a cada gestação a partir da 20ª semana de gestação ou no puerpério (até 45 dias após o parto).</p>
				<p><strong>Influenza</strong> – Uma dose (anual)</p>
			</div>

			<div class="box-info bx6" id="indigena">
				<h3>Calendário Nacional de Vacinação dos Povos Indígenas</h3>
				<h4>EM BREVE</h4>
			</div>

		</div>
	</div>

<section class="conteudo">
	<h1>Vacinação</h1>
	<p class="min-center">Gerencie suas vacinas de modo prático e rápido</p>
	<br>
	<a href="cadastro_vacinacao.php" class="btn btn-padrao btn1">Cadastrar novo</a>
	
	<div class="complemento">
		<img src="IMG/calendar.png" alt="cronograma" onclick="openCronograma();">
		<p onclick="openCronograma();">Acessar cronograma do SUS</p>
	</div>

	<?php
	if (mysqli_num_rows($vac) < 1 && mysqli_num_rows($vac1) < 1) {
		?>
		<div class="sem-resultado">
			<img src="IMG/Nenhum.png">
			<h3>Nenhuma vacina cadastrada</h3>
		</div>
	<?php
	}else{
	?>
		<table>
			<thead>
				<tr>
					<th>Descrição</th>
					<th>Local</th>
					<th>Data agendada</th>
					<th>Data da vacinação</th>
					<th>Usuário</th>
					<th style="text-align: center;">Arquivo</th>
					<th>Ações</th>
				</tr>
			</thead>

			<tbody>
				<?php
				while($x = mysqli_fetch_object($vac)){
				?>
					<tr>
						<td><?php echo $x->vacina; ?></td>
						<td>
							<?php if ($x->local_vacina != "") {
								echo $x->local_vacina;
							}else{
								echo "Não informado";
							}?>
						</td>
						<td><?php echo date("d/m/Y", strtotime($x->dt_ven)); ?></td>
						<td>
							<?php if ($x->dt_dose != NULL) {
								echo date("d/m/Y", strtotime($x->dt_dose));
							}else{
								echo "Não tomou";
							}?>
						</td>
						<td><?php echo $x->nome, " ", $x->sobrenome; ?></td>
						<td style="text-align: center;">
							<?php if($x->arquivo == NULL){ ?>
								<img src="IMG/nenhum.png" alt="Nenhum arquivo" class="down-table" style="opacity: 0.5;">
							<?php }else{ ?>
								<a href="UPLOADS/<?php echo $x->arquivo; ?>" target="_blank">
									<img src="IMG/logo_download.png" alt="Baixar <?php echo $x->arquivo; ?>" class="down-table">
								</a>
							<?php } ?>
						</td>
						<td>
							<a href="editar_vacina.php?id=<?php echo $x->id ?>"><img src="IMG/editar.png" alt="Editar" width="20px"></a> 
							<a href="FUNCOES/dl_vacina.php?id=<?php echo $x->id ?>" onclick="return confirm('Remover a vacinação <?php echo $x->vacina;?>?')"><img src="IMG/deletar.png" alt="Excluir" width="20px"></a>
						</td>
					</tr>
					<?php 
				}
				?>
				<?php
				while($y = mysqli_fetch_object($vac1)){
				?>
					<tr>
						<td><?php echo $y->vacina; ?></td>
						<td>
							<?php if ($y->local_vacina != "") {
								echo $y->local_vacina;
							}else{
								echo "Não informado";
							}?>
						</td>
						<td><?php echo date("d/m/Y", strtotime($y->dt_ven)); ?></td>
						<td>
							<?php if ($y->dt_dose != NULL) {
								echo date("d/m/Y", strtotime($y->dt_dose));
							}else{
								echo "Não tomou";
							}?>
						</td>
						<td><?php echo $y->nome, " ", $y->sobrenome; ?></td>
						<td style="text-align: center;">
							<?php if($y->arquivo == NULL){ ?>
								<img src="IMG/nenhum.png" alt="Nenhum arquivo" class="down-table" style="opacity: 0.5;">
							<?php }else{ ?>
								<a href="UPLOADS/<?php echo $y->arquivo; ?>" target="_blank">
									<img src="IMG/logo_download.png" alt="Baixar <?php echo $y->arquivo; ?>" class="down-table">
								</a>
							<?php } ?>
						</td>
						<td><a href="editar_vacina.php?id=<?php echo $y->id ?>"><img src="IMG/editar.png" alt="Editar" width="20px"></a> <a href="FUNCOES/dl_vacina.php?id=<?php echo $y->id ?>" onclick="return confirm('Tem certeza que deseja remover essa vacina <?php echo $y->vacina;?>?')"><img src="IMG/deletar.png" alt="Excluir" width="20px"></a></td>
					</tr>
					<?php 
				}
				?>
			</tbody>
		</table>
	</section>
<?php }
if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
include ('footer.php');
?>