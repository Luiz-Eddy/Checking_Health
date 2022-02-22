<?php 
  require_once ('header.php'); 
  require_once ('barra.php');
  include_once("FUNCOES/CONNECTION/connect.php");

  $id_session = $_SESSION['id'];

  $queryuser = mysqli_query($conn, "SELECT * FROM usuarios WHERE id_usuario = '$id_session';");
  $w = mysqli_fetch_object($queryuser);

  $querycor = mysqli_query($conn, "SELECT u.id_usuario, u.id_cor, c.* FROM usuarios as u INNER JOIN cor as c ON u.id_cor = c.id WHERE u.id_usuario = '$id_session';");
  $x = mysqli_fetch_object($querycor);

  $querysexo = mysqli_query($conn, "SELECT u.id_usuario, u.id_sexo, s.* FROM usuarios as u INNER JOIN sexo as s ON u.id_sexo = s.id WHERE u.id_usuario = '$id_session';");
  $z = mysqli_fetch_object($querysexo);

  $queryesci = mysqli_query($conn,"SELECT u.id_usuario, u.id_estCivil, es.* FROM usuarios as u INNER JOIN estado_civil as es ON u.id_estCivil = es.id WHERE u.id_usuario = '$id_session';");
  $b = mysqli_fetch_object($queryesci);

  $querytps = mysqli_query($conn, "SELECT u.id_usuario, u.id_sangue, ts.* FROM usuarios as u INNER JOIN tipo_sangue as ts ON u.id_sangue = ts.id WHERE u.id_usuario = '$id_session';");
  $e = mysqli_fetch_object($querytps);

  $queryfum = mysqli_query($conn, "SELECT u.id_usuario, u.id_fumante, o.* FROM usuarios as u INNER JOIN opcoes as o ON u.id_fumante = o.id WHERE u.id_usuario = '$id_session';");
  $g = mysqli_fetch_object($queryfum);
  
  $queryal = mysqli_query($conn, "SELECT u.id_usuario, u.id_alcool, o.* FROM usuarios as u INNER JOIN opcoes as o ON u.id_alcool = o.id WHERE u.id_usuario = '$id_session';");
  $h = mysqli_fetch_object($queryal);

  $queryt = mysqli_query($conn, "SELECT u.id_usuario, u.id_tatuagem, o.* FROM usuarios as u INNER JOIN opcoes as o ON u.id_tatuagem = o.id WHERE u.id_usuario = '$id_session';");
  $i = mysqli_fetch_object($queryt);
?>
<section class="conteudo">
	<h1>Configurações</h1>
	<p class="min-center">Altere configurações da sua conta</p>

	<div class="box-config">
		<h4>Perfil</h4>
		<div class="box-config-priori">
			<p><strong>Matrícula:</strong><?php echo $_SESSION['id']; ?></p>
			<p><strong>Data de Cadastro:</strong> <?php echo date("d/m/Y", strtotime($w->CREATE_DATE)); ?></p>
		</div>
											
		<div class="profile-photo">
			<div class="sec-img">
        <?php
          if ($w->foto != NULL) {
        ?>
            <img src="UPLOADS/PROFILEPHOTOS/<?php echo $w->foto; ?>" alt="Foto de Perfil" style="width: 100%; height: 100%;">
        <?php
          }else{
        ?>
            <img src="IMG/user.png" alt="Foto de Perfil">
        <?php
          }
        ?>
			</div>
			<div class="btn-alt-img">
				<a onclick="openModal();" style="cursor: pointer;">Alterar Imagem</a>
			</div>
		</div>

		<div class="basic-info">
			<h1><?php echo $w->nome, " ", $w->sobrenome; ?></h1>
			<p><strong>E-mail:</strong> <?php echo $w->email; ?></p>
			<?php if ($w->telefone == "") { ?>
        <p><strong>Telefone:</strong> Não definido</p>
      <?php } else{ ?>
        <p><strong>Telefone:</strong> <?php echo $w->telefone; ?></p>
      <?php } ?>
			<p><strong>Data de Nascimento:</strong> <?php echo date("d/m/Y", strtotime($w->dt_nasc)); ?></p>
			<?php if ($w->id_sexo == NULL | $w->id_sexo == "") { ?>
        <p><strong>Sexo:</strong> Não definido</p>
      <?php }else{ ?>
        <p><strong>Sexo:</strong> <?php echo $z->sexo; ?></p>
      <?php } ?>
			<?php if ($w->id_estCivil == NULL | $w->id_estCivil == "" | $w->id_estCivil == 0) { ?>
        <p><strong>Estado Civil:</strong> Não definido</p>
      <?php }else{ ?>
        <p><strong>Estado Civil:</strong> <?php echo $b->estado; ?></p>
      <?php } ?>
      <?php if ($w->id_cor == NULL | $w->id_cor == "" | $w->id_cor == 0) { ?>
        <p><strong>Cor:</strong> Não definido</p>
      <?php }else{ ?>
        <p><strong>Cor:</strong> <?php echo $x->cor; ?></p>
      <?php } ?>

			<br>
			
			<p><strong>CPF:</strong> <?php echo $w->cpf; ?></p>
			<?php if ($w->rg == "") { ?>
        <p><strong>RG:</strong> Não definido</p>
      <?php }else{ ?>
        <p><strong>RG:</strong> <?php echo $w->rg; ?></p>
      <?php } ?>
			<?php if ($w->sus == "") { 	?>
        <p><strong>Cartão SUS:</strong> Não definido</p>
      <?php }else{ ?>
        <p><strong>Cartão SUS:</strong> <?php echo $w->sus; ?></p>
      <?php } ?>

			<br>
			
			<?php if ($w->cep == "") { ?>
        <p><strong>Endereço:</strong> Não definido</p>
      <?php }else{ ?>
        <p><strong>Endereço:</strong> <?php echo $w->rua; ?></p>
				<p><strong>Nº:</strong> <?php echo $w->numero; ?></p>
				<p><strong>Bairro:</strong> <?php echo $w->bairro; ?></p>
				<p><strong>Cidade:</strong> <?php echo $w->cidade; ?></p>
				<p><strong>Estado:</strong> <?php echo $w->estado; ?></p>
				<p><strong>CEP:</strong> <?php echo $w->cep; ?></p>
      <?php } ?>
		</div>

		<div class="rapid-action">
			<div class="box-rapid-info sangue">
				<p>Tipo Sanguíneo</p>
				<?php if ($w->id_sangue == NULL | $w->id_sangue == "" | $w->id_sangue == 0) { ?>
          <h1>?</h1>
        <?php }else{ ?>
          <h1><?php echo $e->sangue; ?></h1>
        <?php } ?>
			</div>
			<div class="box-rapid-info fumante">
				<p>Fumante</p>
				<?php if ($w->id_fumante == NULL | $w->id_fumante == "" | $w->id_fumante == 0) { ?>
          <h1>?</h1>
        <?php }else{ ?>
          <h1><?php echo $g->opcao; ?></h1>
         <?php } ?>
			</div>
			<div class="box-rapid-info bebida">
				<p>Bebida</p>
				<?php if ($w->id_alcool == NULL | $w->id_alcool == "" | $w->id_alcool == 0) { ?>
          <h1>?</h1>
        <?php }else{ ?>
          <h1><?php echo $h->opcao; ?></h1>
        <?php } ?>
			</div>
			<div class="box-rapid-info tatto">
				<p>Tatuagem</p>
				<?php if ($w->id_tatuagem == NULL | $w->id_tatuagem == "" | $w->id_tatuagem == 0) { ?>
          <h1>?</h1>
        <?php }else{ ?>
          <h1><?php echo $i->opcao; ?> (<?php echo $w->quant_tatuagem; ?>)</h1>
        <?php } ?>
			</div>
		</div>
		<div class="box-config-set">
			<div class="sec1">
				<h1>Alergias</h1>
				<?php if ($w->alergia == "") { ?>
          <p>Nenhuma informação cadastrada</p>
        <?php }else{ ?>
          <p><?php echo $w->alergia; ?></p>
        <?php } ?>
			</div>
			<div class="sec2">
				<h1>Doenças:</h1>
				<?php if ($w->doencas == "") { ?>
          <p>Nenhuma informação cadastrada</p>
        <?php }else{ ?>
          <p><?php echo $w->doencas; ?></p>
        <?php } ?>
			</div>
			<div class="sec3">
				<h1>Observações:</h1>
				<?php if ($w->obs == "") { ?>
          <p>Nenhuma informação cadastrada</p>
        <?php }else{ ?>
          <p><?php echo $w->obs; ?></p>
        <?php } ?>
			</div>
		</div>

		<br>
    
		<a href="editarperfil.php" class="btn btn-padrao btn1">Editar informações</a>
		<div style="clear: both;"></div>
	</div>
</section>
<div class="overlay oc-ov" id="overlay">
  <div class="modal-vac">
    <div class="close-btn">
      <img src="IMG/fechar.png" alt="Fechar" onclick="closeModal();">
      <h1 style="float: left; font-size: 20px; margin: 30px 0px 0px 10px; font-weight: bold;">Alterar foto de perfil</h1>
      <br>
      <iframe src="COMPLEMENTOS/CROP IMAGES/index.php" style="width: 100%; height: 370px;"></iframe>
    </div>
  </div>
</div>
<?php
  if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
  }
?>
<?php
	include ('footer.php');
?>