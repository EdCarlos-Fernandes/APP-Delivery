<?php
require_once("../_core/_includes/config.php");
// SEO
$seo_subtitle = "Comece já! - BR delivery Sitema catalogo de lojas online.";
$seo_description = "BR delivery, multilojas, sistema de lojas virtuais, loja virtual gratis, ecommerce, loja delivery, pedido no whatsapp, franquia de delivery, franquia de sistemas multilojas, delivery multilojas";
$seo_keywords = $app['title'].", ".$seo_title;
$seo_image = get_just_url()."/_core/_cdn/img/favicon.png";
// HEADER
$system_header .= "";
include('../_core/_layout/head.php');
include('../_core/_layout/top.php');
include('../_core/_layout/sidebars.php');
include('../_core/_layout/modal.php');
global $plano_default;
$afiliado = $_SESSION['afiliado'];
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
					<i class="lni lni-rocket icon-white"></i>
					<span>Criar uma nova conta</span>
				</div>

				
			</div>

		</div>

		<div class="row">

			<div class="col-md-12">

				<div class="adicionado comece">

				
					<span class="text">
						Ao se cadastrar você ganha <br/> <strong><?php echo data_info( "planos",$plano_default,"duracao_dias" ); ?> dias</strong> <br/>para testar nossa plataforma, criar seu catálogo e impulsionar suas vendas.
					</span>
					
					<!--
					<span class="text">
						Ao se cadastrar você pode testar nossa plataforma, criar seu catálogo e impulsionar suas vendas.
					</span>
					-->
					<a href="<?php echo just_url(); ?>/comece/cadastrar" class="botao-acao"><i class="lni lni-rocket"></i> <span>Quero me cadastrar</span></a>

				</div>

			</div>

		</div>

	</div>

</div>

<?php 
// FOOTER
$system_footer .= "";
include('../_core/_layout/rdp.php');
include('../_core/_layout/footer.php');
?>