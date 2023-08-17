<?php
include('../../../_core/_includes/config.php');
restrict_estabelecimento();
restrict_expirado();
$subtitle = "Bloquear";
?>

<!-- Aditional Header's -->

<?php

	$id = $_GET['id'];

	// ATIVAR ESTABELECIMENTO

	$edit = mysqli_query( $db_con, "UPDATE estabelecimentos SET status = '2' WHERE id = '$id'");
	
	if( $edit ) {

		header("Location: ../index.php?msg=sucesso");
	
	} else {

		header("Location: ../index.php?msg=erro");

	}

?>



