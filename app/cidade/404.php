<?php
// CORE
include($virtualpath.'/_layout/define.php');
// APP
global $app;
$back_button = "true";
// Querys
$exibir = "8";
$app_id = $app['id'];
// SEO
$seo_subtitle = "Página não encontrada";
$seo_description = "Página não encontrada";
$seo_keywords = $app['title'].", ".$seo_title;
$seo_image = thumber( $app['avatar_clean'], 400 );
// HEADER
$system_header .= "";
include($virtualpath.'/_layout/head.php');
include($virtualpath.'/_layout/top.php');
include($virtualpath.'/_layout/sidebars.php');
include($virtualpath.'/_layout/modal.php');
instantrender();
?>

<div class="sceneElement">

	<div class="minfit">

		<div class="middle">

			<div class="nopaddmobile paginaerro">

				<div class="back-gray back-gray-mobile">

					<div class="container">

						<div class="row rowtitle">

							<div class="col-md-12">
								<div class="title-icon">
									<span>Não encontrada</span>
								</div>
								<div class="bread-box">
									<div class="bread">
										<a href="<?php echo $app['url']; ?>"><i class="lni lni-home"></i></a>
										<span>/</span>
										<a href="<?php echo $app['url']; ?>/404">Não encontrada</a>
									</div>
								</div>
							</div>

							<div class="col-md-12 hidden-xs hidden-sm">
								<div class="clearline"></div>
							</div>

						</div>

					</div>

				</div>

				<div class="container">

					<div class="obrigado">

						<div class="row">

							<div class="col-md-12">

								<div class="adicionado">

									<i class="checkicon lni lni-cross-circle"></i>
									<span class="text">A pagina que você esta tentando acessa é inválida ou não existe mais!</span>
									<a href="<?php echo $app['url']; ?>" class="botao-acao"><i class="lni lni-home"></i> <span>Voltar para o início</span></a>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>

<?php 
// FOOTER
$system_footer .= "";
include($virtualpath.'/_layout/rdp.php');
include($virtualpath.'/_layout/footer.php');
?>