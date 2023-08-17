<?php
include('../../../_core/_includes/config.php');
restrict_estabelecimento();
restrict_expirado();
$subtitle = "Status";
?>

<!-- Aditional Header's -->

<?php

	$id = $_GET['id'];
	$eid = $_SESSION['estabelecimento']['id'];

	// VERIFICA SE O USUARIO TEM DIREITOS
	
	$edit = mysqli_query( $db_con, "UPDATE produtos SET status = '1' WHERE id = '$id'");
	
		if( $edit ) {

			header("Location: ../index.php?msg=sucesso");

		} else {

			header("Location: ../index.php?msg=erro");

		}


?>



