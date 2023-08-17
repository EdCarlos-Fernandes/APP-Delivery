<?php
// CORE
include('../../_core/_includes/config.php');
// RESTRICT
restrict('3');
// SEO
$seo_subtitle = "Estabelecimentos! - PayLojas! Sitema multilojas de lojas online.";
$seo_description = "PayLojas! Sitema multilojas de lojas online.";
$seo_keywords = "PayLojas, Script multilojas, sistema de lojas virtuais, loja virtual gratis, ecommerce, loja delivery, pedido no whatsapp, franquia de delivery, franquia de sistemas multilojas, script delivery multilojas";
// HEADER
$system_header .= "";
include('../_layout/head.php');
include('../_layout/top.php');
include('../_layout/sidebars.php');
include('../_layout/modal.php');
?>

<?php

global $db_con;
global $simple_url;
global $httprotocol;

// Variables

$subdominio = mysqli_real_escape_string( $db_con, $_GET['subdominio'] );
$nome = mysqli_real_escape_string( $db_con, $_GET['nome'] );
$estado = mysqli_real_escape_string( $db_con, $_GET['estado'] );
$cidade = mysqli_real_escape_string( $db_con, $_GET['cidade'] );
$excluded = mysqli_real_escape_string( $db_con, $_GET['excluded'] );

$getdata = "";

foreach($_GET as $query_string_variable => $value) {
  if( $query_string_variable != "pagina" ) {
    $getdata .= "&$query_string_variable=".htmlclean($value);
  }
}

// Config

$limite = 20;
$pagina = $_GET["pagina"] == "" ? 1 : $_GET["pagina"];
$inicio = ($pagina * $limite) - $limite;

// Query

$query .= "SELECT id,nome,perfil,cidade,estado,status,excluded,subdominio FROM estabelecimentos ";


$query .= "WHERE 1=1 ";   

$query .= "AND afiliado = '$iduser'  ";   



if( $subdominio ) {
  $query .= "AND subdominio LIKE '$nome%' ";
}

if( $nome ) {
  $query .= "AND nome LIKE '$nome%' ";
}

if( $estado ) {
  $query .= "AND level = '$estado' ";
}

if( $cidade ) {
  $query .= "AND cidade = '$cidade' ";
}

if( $excluded ) {
	$query .= "AND excluded = '$excluded' ";
} else {
	$query .= "AND excluded != '1' ";
}


$query_full = $query;

if($oper == 1) {
$query .= "ORDER BY created DESC LIMIT $inicio,$limite";
} else { 
$query .= "ORDER BY created DESC LIMIT $inicio,$limite";
}
// Run

$sql = mysqli_query( $db_con, $query );

$total_results = mysqli_num_rows( $sql );

$sql_full = mysqli_query( $db_con, $query_full );

$total_results_full = mysqli_num_rows( $sql_full );

$total_paginas = Ceil($total_results_full / $limite) + ($limite / $limite);

if( !$pagina OR $pagina > $total_paginas OR !is_numeric($pagina) ) {

    $pagina = 1;

}

?>

<?php if( $_GET['msg'] == "erro" ) { ?>

<?php modal_alerta("Erro, tente novamente!","erro"); ?>

<?php } ?>

<?php if( $_GET['msg'] == "sucesso" ) { ?>

<?php modal_alerta("Ação efetuada com sucesso!","sucesso"); ?>

<?php } ?>

<div class="middle minfit bg-gray">

	<div class="container">

		<div class="row">

			<div class="col-md-12">

				<div class="title-icon pull-left">
					<i class="lni lni-home"></i>
					<span>Estabelecimentos</span>
				</div>

				<div class="bread-box pull-right">
					<div class="bread">
						<a href="<?php afiliado_url(); ?>"><i class="lni lni-home"></i></a>
						<span>/</span>
						<a href="<?php afiliado_url(); ?>/estabelecimentos">Estabelecimentos</a>
					</div>
				</div>

			</div>

		</div>

		<hr/>
		
		<!-- Content -->

		<div class="listing">

			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-6">
					<span class="listing-title"><strong class="counter"><?php echo $total_results_full; ?></strong> Registros:</span>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<div class="add-new pull-right">

						<a href="<?php afiliado_url(); ?>/estabelecimentos/adicionar">
							<span>Adicionar</span>
							<i class="lni lni-plus"></i>
						</a>

					</div>
				</div>
			</div>

			<div class="row">

				<div class="col-md-12">

					<table class="listing-table fake-table clean-table">
						<thead>
							<th></th>
							<th class="hidden-xs hidden-sm">Subdominio</th>
							<th>Nome</th>
							<th class="hidden-xs hidden-sm">Cidade</th>
							<th class="hidden-xs hidden-sm">Estado</th>
							<th></th>
						</thead>
						<tbody>

							<?php
                            while ( $data = mysqli_fetch_array( $sql ) ) {
                            $gourl = $httprotocol.$data['subdominio'].".".$simple_url;
                            $gourlclean = $data['subdominio'].".".$simple_url;
                            ?>

							<tr>
								<td>
                                    <div class="fake-table-data">
                                    	<a target="_blank" href="<?php echo $gourl; ?>">
	                                    	<div class="rounded-thumb-holder">
		                                    	<div class="rounded-thumb">
		                                    		<img src="<?php echo thumber( $data['perfil'], "100" ); ?>"/>
		                                    		<img class="blurred" src="<?php echo thumber( $data['perfil'], "300" ); ?>"/>
		                                    	</div>
	                                    	</div>
                                    	</a>
                                    </div>
                                    <div class="fake-table-break"></div>
								</td>
								<td class="hidden-xs hidden-sm">
									<a target="_blank" href="<?php echo $gourl; ?>">
	                                    <span class="fake-table-title">Subdominio</span>
	                                    <div class="fake-table-data"><?php echo $data['subdominio']; ?></div>
	                                    <div class="fake-table-break"></div>
                                	</a>
								</td>
								
								<?php if($data['status'] == 1) { $sttt = "<b style=\"color:#00CC00\">Ativo</b>";}?>
								<?php if($data['status'] == 2) { $sttt = "<b style=\"color:#FF0000\">Bloqueado</b>";}?>
								<td>
									<a target="_blank" href="<?php echo $gourl; ?>">
	                                    <span class="fake-table-title hidden-xs hidden-sm">Nome</span>
	                                    <div class="fake-table-data"><?php echo htmlclean( $data['nome'] ); ?><br/><?php print $sttt; ?></div>
	                                    <div class="fake-table-break"></div>
                                	</a>
								</td>
								<td class="hidden-xs hidden-sm">
                                    <span class="fake-table-title hidden-xs hidden-sm">Cidade</span>
                                    <div class="fake-table-data"><?php echo data_info( "cidades", $data['cidade'], "nome" ); ?></div>
                                    <div class="fake-table-break"></div>
								</td>
								<td class="hidden-xs hidden-sm">
                                    <span class="fake-table-title hidden-xs hidden-sm">Estado</span>
                                    <div class="fake-table-data"><?php echo data_info( "estados", $data['estado'], "nome" ); ?></div>
                                    <div class="fake-table-break"></div>
								</td>
								<td>
									<span class="fake-table-title">Ações</span>
                                    <div class="fake-table-data">
										<div class="form-actions pull-right">
											<a target="_blank" class="color-white" href="<?php afiliado_url(); ?>/estabelecimentos/gerenciar?id=<?php echo $data['id']; ?>" title="Gerenciar"><i class="lni lni-lock"></i></a>
											
											<?php if($data['status'] == 1) { ?>
											<a class="color-yellow" onclick="if(confirm('Tem certeza que deseja desativar este estabelecimento?')) document.location = '<?php afiliado_url(); ?>/estabelecimentos/bloquear/?id=<?php echo $data['id']; ?>'" href="#" title="Desativar Estabelecimento"><i class="lni lni-close"></i></a>
											<?php } else { ?>
											<a class="color-yellow" onclick="if(confirm('Tem certeza que deseja ativar este estabelecimento?')) document.location = '<?php afiliado_url(); ?>/estabelecimentos/ativar/?id=<?php echo $data['id']; ?>'" href="#" title="Ativar Estabelecimento"><i class="lni lni-checkmark"></i></a>
											<?php } ?>
											<a class="color-red" onclick="if(confirm('Tem certeza que deseja remover este estabelecimento?')) document.location = '<?php afiliado_url(); ?>/estabelecimentos/deletar/?id=<?php echo $data['id']; ?>&mode=<?php echo $_GET['mode']; ?>'" href="#" title="Ed"><i class="lni lni-trash"></i></a>
										</div>
                                    </div>
                                    <div class="fake-table-break"></div>
								</td>
							</tr>

                            <?php } ?>

                            <?php if( $total_results == 0 ) { ?>

                               <tr>
                                <td colspan="6">
                                  <div class="fake-table-data">
                                    <span class="nulled">Nenhum registro cadastrado ou compatível com a sua filtragem!</span>
                                  </div>
                                  <div class="fake-table-break"></div>
                                </td>
                               </tr>

                            <?php } ?>

						</tbody>
					</table>

				</div>

			</div>

		</div>

		<!-- / Content -->

		<!-- Pagination -->

        <div class="paginacao">

          <ul class="pagination">

            <?php
            $paginationpath = "estabelecimentos";
            if($pagina > 1) {
              $back = $pagina-1;
              echo '<li class="page-item pagination-back"><a class="page-link" href=" '.get_system_url().'/'.$paginationpath.'/?pagina='.$back.$getdata.' "><i class="lni lni-chevron-left"></i></a></li>';
            }
     
              for($i=$pagina-1; $i <= $pagina-1; $i++) {

                  if($i > 0) {
                  
                      echo '<li class="page-item pages-before"><a class="page-link" href=" '.get_system_url().'/'.$paginationpath.'/?pagina='.$i.$getdata.' ">'.$i.'</a></li>';
                  }

              }

              if( $pagina >= 1 ) {

                echo '<li class="page-item active"><a class="page-link" href=" '.get_system_url().'/'.$paginationpath.'/?pagina='.$i.$getdata.'" class="page-link">'.$i.'</a></li>';

              }

              for($i=$pagina+1; $i <= $pagina+1; $i++) {

                  if($i >= $total_paginas) {
                    break;
                  }  else {
                      echo '<li class="page-item pages-after"><a class="page-link" href=" '.get_system_url().'/'.$paginationpath.'/?pagina='.$i.$getdata.' ">'.$i.'</a></li> ';
                  }
              
              }

            if($pagina < $total_paginas-1) {
              $next = $pagina+1;
              echo '<li class="page-item pagination-next"><a class="page-link" href=" '.get_system_url().'/'.$paginationpath.'/?pagina='.$next.$getdata.' "><i class="lni lni-chevron-right"></i></a></li>';
            }

            ?>

          </ul>

        </div>

		<!-- / Pagination -->

	</div>

</div>

<?php 
// FOOTER
$system_footer .= "";
include('../_layout/rdp.php');
include('../_layout/footer.php');
?>

<script>

  function exibe_cidades() {
    var estado = $("#input-estado").children("option:selected").val();
    $("#input-cidade").html("<option>-- Carregando cidades --</option>");
    $("#input-cidade").load("<?php just_url(); ?>/_core/_ajax/cidades.php?estado="+estado);
  }

  // Autopreenchimento de estado
  $( "#input-estado" ).change(function() {
    exibe_cidades();
  });
  <?php if( $_POST['estado'] ) { ?>
    exibe_cidades();
  <?php } ?>

</script>