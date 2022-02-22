<?php
session_start();
if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true)){
	unset($_SESSION['login']);
	unset($_SESSION['senha']);
	unset($_SESSION['nome']);
	header('location:login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Checking Health - controle sua saúde</title>
	<link rel="icon" type="image/png" href="IMG/icon.png" />
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>