<?php
include('../../FUNCOES/CONNECTION/connect.php');
session_start();

$id_usuario = $_SESSION['id'];

$path = "../../UPLOADS/PROFILEPHOTOS/";

$image = "";
?>

<html>
<head>
	<meta charset="utf-8">
	<title>Checking Health - Upload and Crop Profile Photo</title>
</head>
<link rel="stylesheet" type="text/css" href="../../css/style.css">
<link rel="stylesheet" type="text/css" href="css/imgareaselect-default.css" />
<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript">
	function getSizes(im,obj)
	{
		var x_axis = obj.x1;
		var x2_axis = obj.x2;
		var y_axis = obj.y1;
		var y2_axis = obj.y2;
		var thumb_width = obj.width;
		var thumb_height = obj.height;
		if(thumb_width > 0)
		{
			if(confirm("Clique em OK para salvar"))
			{
				$.ajax({
					type:"GET",
					url:"ajax_image.php?t=ajax&img="+$("#image_name").val()+"&w="+thumb_width+"&h="+thumb_height+"&x1="+x_axis+"&y1="+y_axis,
					cache:false,
					success:function(rsponse)
					{
						window.location.href = ("redir.php");
					}
				});
			}
		}
		else
			alert("Selecione a área da foto");
	}

	$(document).ready(function () {
		$('img#photo').imgAreaSelect({
			aspectRatio: '3:4',
			onSelectEnd: getSizes
		});
	});
</script>
<?php

$valid_formats = array("jpg", "png", "gif", "bmp");
if(isset($_POST['submit']))
{
	$name = $_FILES['photoimg']['name'];
	$size = $_FILES['photoimg']['size'];

	if(strlen($name))
	{
		list($txt, $ext) = explode(".", $name);
		if(in_array($ext,$valid_formats))
		{
			$actual_image_name = time().substr($txt, 5).".".$ext;
			$tmp = $_FILES['photoimg']['tmp_name'];
			if(move_uploaded_file($tmp, $path.$actual_image_name))
			{
				$query = mysqli_query($conn,"UPDATE usuarios SET foto = '$actual_image_name' WHERE id_usuario = '$id_usuario';");
				$image="<h1 class='profile-h1'>Arraste sobre a imagem para cortar</h1><img src='../../UPLOADS/PROFILEPHOTOS/".$actual_image_name."' id=\"photo\">";

			}
			else
				echo "Erro 0x1";
		}
		else
			echo "Selecione um formato de imagem válido. (JPG, PNG, GIF, BMP)";					
	}
	else
		echo "Selecione uma imagem";
}
?>
<body>
	<div style="margin:0 auto; width: 100%; text-align: center;">
		<?php echo $image; ?>
		<div id="thumbs"></div>
		<div>
			<form id="cropimage" method="post" enctype="multipart/form-data">
				<label class="label-profile">Selecione uma imagem</label><br style='margin: 3em 0em;'>
				<input type="file" name="photoimg" id="photoimg" />
				<input type="hidden" name="image_name" id="image_name" value="<?php echo($actual_image_name)?>" />
				<br>
				<br style='margin-top: 1em;'>
				<input type="submit" name="submit" value="Enviar" class="btn-form" />
			</form>
		</div>
	</div>
</body>
</html>