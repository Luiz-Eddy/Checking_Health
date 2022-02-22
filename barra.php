<aside class="barra barra_min" id="barra">
	<div class="icon-menu">
		<img src="IMG/menu.png" width="30px;" onclick="abrir_menu()" id="open">
		<img src="IMG/menu.png" width="30px;" onclick="fechar_menu()" id="close" class="oc-ov close-menu">
	</div>
	<div class="topo-barra oc-uv over" id="topo-barra">
		<img src="IMG/logo.png" alt="Logo">
		<p><?php echo $_SESSION['nome'], ' ', $_SESSION['sobrenome']; ?></p>
		<p>Registro: <?php echo $_SESSION['id']; ?></p>
	</div>
	<nav class="menu oc-uv over" id="menu">
		<ul>
			<li><a href="painel.php">Painel</a></li>
			<li><a href="dependentes.php">Dependentes</a></li>
			<li><a href="vacinacao.php">Vacinação</a></li>
			<li><a href="medicamentos.php">Medicamentos</a></li>
			<li><a href="consultas.php">Consultas</a></li>
			<li><a href="exames.php">Exames</a></li>
		</ul>
	</nav>
</aside>
<section class="top-bar">
	<nav>
		<ul>
			<li><a href="configuracoes.php">Configurações</a></li>
			<li><a href="FUNCOES/logout.php?token='.session_id().'">Sair</li></a>
		</ul>
	</nav>
</section>