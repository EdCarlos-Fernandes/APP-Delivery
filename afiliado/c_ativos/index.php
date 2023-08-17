<?php
// CORE
include('../../_core/_includes/config.php');
// RESTRICT
restrict('3');
// SEO
$seo_subtitle = "Estabelecimentos";
$seo_description = "";
$seo_keywords = "";
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

$query .= "AND status = '1'  ";  

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
					<span>Estabelecimentos Ativos</span>
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
							<span>Imprimir</span>
							<i class="lni lni-plus"></i>
						</a>

					</div>
				</div>
			</div>

			<div class="row">

				<div class="col-md-12">

					<table class="listing-table fake-table clean-table">
						<thead>
							<th>Cliente</th>
							<th class="hidden-xs hidden-sm">Cidade/UF</th>
							<th class="hidden-xs hidden-sm">Plano</th>
							<th class="hidden-xs hidden-sm">Expiração</th>
							<th class="hidden-xs hidden-sm">Valor do Plano</th>
							<th class="hidden-xs hidden-sm">Comissão Afiliado</th>
						</thead>
						<tbody>

							<?php
                            while ( $data = mysqli_fetch_array( $sql ) ) {
                            $gourl = $httprotocol.$data['subdominio'].".".$simple_url;
                            $gourlclean = $data['subdominio'].".".$simple_url;
                            
                            // total de clientes bloqueados
  
                            $queryplanos = mysqli_query( $db_con, "SELECT * FROM assinaturas WHERE rel_estabelecimentos_id = '".$data['id']."' AND status = '1'");
                            $dataplanos = mysqli_fetch_array( $queryplanos );
                            
                            $vplano = $dataplanos['valor_total'];
                            
                            $porcentagem = 60;
                            
                            $receber = $vplano * ($porcentagem / 100);
                            
                            

                            
                            ?>

							<tr>
								<td>
									<a target="_blank" href="<?php echo $gourl; ?>">
	                                    <span class="fake-table-title hidden-xs hidden-sm">Nome</span>
	                                    <div class="fake-table-data"><?php echo htmlclean( $data['nome'] ); ?></div>
	                                    <div class="fake-table-break"></div>
                                	</a>
								</td>
								<td class="hidden-xs hidden-sm">
                                    <span class="fake-table-title hidden-xs hidden-sm">Cidade/UF</span>
                                    <div class="fake-table-data"><?php echo data_info( "cidades", $data['cidade'], "nome" ); ?>/<?php echo data_info( "estados", $data['estado'], "uf" ); ?></div>
                                    <div class="fake-table-break"></div>
								</td>
								<td class="hidden-xs hidden-sm">
                                    <span class="fake-table-title hidden-xs hidden-sm">Plano</span>
                                    <div class="fake-table-data"><?php echo htmlclean( $dataplanos['nome'] ); ?></div>
                                    <div class="fake-table-break"></div>
								</td>
								<td class="hidden-xs hidden-sm">
                                    <span class="fake-table-title hidden-xs hidden-sm">Expiração</span>
                                    <div class="fake-table-data"><?php echo htmlclean( $dataplanos['expiration'] ); ?></div>
                                    <div class="fake-table-break"></div>
								</td>
								<td class="hidden-xs hidden-sm">
                                    <span class="fake-table-title hidden-xs hidden-sm">Valor do Plano</span>
                                    <div class="fake-table-data">R$: <?php echo dinheiro( $dataplanos['valor_total'], "BR" ); ?></div>
                                    <div class="fake-table-break"></div>
								</td>
								<td class="hidden-xs hidden-sm">
                                    <span class="fake-table-title hidden-xs hidden-sm">Comissão Afiliado</span>
                                    <div class="fake-table-data">R$: <?php echo dinheiro( $receber, "BR" ); ?></div>
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