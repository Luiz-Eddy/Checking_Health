<?php 
	session_start();
	include_once("CONNECTION/connect.php");

	$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
	$sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
	$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
	$dt_nasc = filter_input(INPUT_POST, 'dtnasc', FILTER_SANITIZE_STRING);
	$dt_nasc1 = implode('-', array_reverse(explode('/', $dt_nasc)));
	$id_sexo = filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_STRING);
	$id_estCivil = filter_input(INPUT_POST, 'estCivil', FILTER_SANITIZE_STRING);
	$id_cor = filter_input(INPUT_POST, 'cor', FILTER_SANITIZE_STRING);
	$cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
	$rg = filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_STRING);
	$cartao_sus = filter_input(INPUT_POST, 'sus', FILTER_SANITIZE_STRING);
	$alergia = filter_input(INPUT_POST, 'alergia', FILTER_SANITIZE_STRING);
	$doencas = filter_input(INPUT_POST, 'doencas', FILTER_SANITIZE_STRING);
	$id_sangue = filter_input(INPUT_POST, 'tpSangue', FILTER_SANITIZE_STRING);
	$id_fumante = filter_input(INPUT_POST, 'fum', FILTER_SANITIZE_STRING);
	$id_alcool = filter_input(INPUT_POST, 'drink', FILTER_SANITIZE_STRING);
	$id_tatuagem = filter_input(INPUT_POST, 'tatu', FILTER_SANITIZE_STRING);
	$total_tatuagem = filter_input(INPUT_POST, 'totTatuagem', FILTER_SANITIZE_STRING);
	$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
	$rua = filter_input(INPUT_POST, 'rua', FILTER_SANITIZE_STRING);
	$numero = filter_input(INPUT_POST, 'num', FILTER_SANITIZE_STRING);
	$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
	$cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
	$estado = filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_STRING);
	$obs = filter_input(INPUT_POST, 'obs', FILTER_SANITIZE_STRING);

	$id = $_SESSION['id'];

	if ($id_tatuagem == 1) {
		$atualizar_perfil = "UPDATE usuarios SET 
								nome = '$nome',
								sobrenome = '$sobrenome',
								email = '$email',
								telefone = '$telefone',
								dt_nasc = '$dt_nasc',
								id_sexo = '$id_sexo',
								id_estCivil = '$id_estCivil',
								id_cor = '$id_cor',
								cpf = '$cpf',
								rg = '$rg',
								sus = '$cartao_sus',
								alergia =  '$alergia',
								doencas = '$doencas',
								id_sangue =  '$id_sangue',
								id_fumante = '$id_fumante',
								id_alcool = '$id_alcool',
								id_tatuagem =  '$id_tatuagem',
								quant_tatuagem = '$total_tatuagem',
								cep = '$cep',
								rua = '$rua',
								numero = '$numero',
								bairro = '$bairro',
								cidade = '$cidade',
								estado = '$estado',
								obs = '$obs' 
								WHERE id_usuario = '$id';";
		$att_perfil = mysqli_query($conn, $atualizar_perfil);
	}else{
		$atualizar_perfil = "UPDATE usuarios SET 
								nome = '$nome',
								sobrenome = '$sobrenome',
								email = '$email',
								telefone = '$telefone',
								dt_nasc = '$dt_nasc',
								id_sexo = '$id_sexo',
								id_estCivil = '$id_estCivil',
								id_cor = '$id_cor',
								cpf = '$cpf',
								rg = '$rg',
								sus = '$cartao_sus',
								alergia =  '$alergia',
								doencas = '$doencas',
								id_sangue =  '$id_sangue',
								id_fumante = '$id_fumante',
								id_alcool = '$id_alcool',
								id_tatuagem =  '$id_tatuagem',
								quant_tatuagem = NULL,
								cep = '$cep',
								rua = '$rua',
								numero = '$numero',
								bairro = '$bairro',
								cidade = '$cidade',
								estado = '$estado',
								obs = '$obs'
								WHERE id_usuario = '$id';";
		$att_perfil = mysqli_query($conn, $atualizar_perfil);
	}

	if($att_perfil){
		$_SESSION['msg'] = "<div class='toast-cad-true'>Atualização de dados realizada com sucesso!</div>";
		header("Location: ../configuracoes.php");
		exit();
		
	}else{
		$_SESSION['msg'] = "<div class='toast-cad-false'>Erro ao realizar a atualização!</div>";
		header("Location: ../configuracoes.php");
		exit();
	}
?>