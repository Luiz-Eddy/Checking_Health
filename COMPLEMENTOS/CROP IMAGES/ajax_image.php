<?php
include('../../FUNCOES/CONNECTION/connect.php');
session_start();

$id_usuario = $_SESSION['id'];

$t_width = 700;	// Maximum thumbnail width
$t_height = 1000;	// Maximum thumbnail height

$new_name = "profileid".$id_usuario.".jpg"; // Thumbnail image name
$path = "../../UPLOADS/PROFILEPHOTOS/";

if(isset($_GET['t']) and $_GET['t'] == "ajax")
{
	extract($_GET);
	$ratio = ($t_width/$w); 
	$nw = ceil($w * $ratio);
	$nh = ceil($h * $ratio);
	$nimg = imagecreatetruecolor($nw,$nh);
	$im_src = imagecreatefromjpeg($path.$img);
	imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w,$h);
	imagejpeg($nimg,$path.$new_name,90);
	$query = mysqli_query($conn,"UPDATE usuarios SET foto = '$new_name' WHERE id_usuario = '$id_usuario';");
	echo $new_name."?".time();
	unlink("../../UPLOADS/PROFILEPHOTOS/$_GET[img]");
	exit;
}

?>