<div class="footer footer-cidade">

	<div class="footer-info">

		<div class="container">

			<div class="row">

				<div class="col-md-6">

					<span class="pull-left"><?php echo $app['endereco_completo']; ?></span>

				</div>

				<div class="col-md-6">

					<div class="clear"></div>
					<div class="social">
						<?php if( $app['contato_whatsapp'] ) { ?>
						<a href="https://api.whatsapp.com/send/?phone=5511910276204&text&type=phone_number&app_absent=0" target="_blank"><i class="lni lni-whatsapp"></i></a>
						<?php } ?>
						<?php if( $app['contato_facebook'] ) { ?>
						<a href="<?php echo linker( $app['contato_facebook'] ); ?>" target="_blank"><i class="lni lni-facebook-filled"></i></a>
						<?php } ?>
						<?php if( $app['contato_instagram'] ) { ?>
						<a href="https://instagram.com/brdelivery_" target="_blank"><i class="lni lni-instagram-original"></i></a>
						<?php } ?>
						<?php if( $app['contato_youtube'] ) { ?>
						<a href="<?php echo linker( $app['contato_youtube'] ); ?>" target="_blank"><i class="lni lni-youtube"></i></a>
						<?php } ?>
					</div>

				</div>

			</div>

		</div>

	</div>

</div>