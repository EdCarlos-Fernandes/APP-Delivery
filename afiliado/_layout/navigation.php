<?php
$cidop = user_info('cidade');
$estop = user_info('estado');
$iduser = user_info('id');
?>
<nav class="navbar pull-left">
	<ul class="nav navbar-nav">
		<li class="active"><a href="<?php afiliado_url(); ?>">Ínicio</a></li>
		 
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				Segmentação
				<i class="lni lni-chevron-down icon-right"></i>
			</a>
			<ul class="dropdown-menu">
				<li><a href="<?php afiliado_url(); ?>/segmentos"><i class="lni lni-radio-button"></i> Gerenciar</a></li>
			</ul>
		</li>
		 
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				Estabelecimentos
				<i class="lni lni-chevron-down icon-right"></i>
			</a>
			<ul class="dropdown-menu">
				<li><a href="<?php afiliado_url(); ?>/estabelecimentos/adicionar"><i class="lni lni-circle-plus"></i> Adicionar novo</a></li>
				<li><a href="<?php afiliado_url(); ?>/estabelecimentos"><i class="lni lni-radio-button"></i> Gerenciar</a></li>
				
			</ul>
		</li>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				Planos
				<i class="lni lni-chevron-down icon-right"></i>
			</a>
			<ul class="dropdown-menu">
				<li><a href="<?php afiliado_url(); ?>/vouchers"><i class="lni lni-ticket"></i> Vouchers</a></li>
				
			</ul>
		</li>
		<!-- <li class="visible-sm visible-xs"><a href="#">Suporte</a></li> -->
	</ul>
</nav> 

<nav class="navbar pull-right hidden-xs hidden-sm">
	<ul class="nav navbar-nav">
		<li class="active"><a target="_blank" href="<?php just_url(); ?>"><i class="lni lni-home"></i> Portal</a></li>
	</ul>
</nav> 

<div class="clear"></div>