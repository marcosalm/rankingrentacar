<?php $services = get_option('config_servicos_adicionais'); ?>
<div class="row servicos">
	<div class="limit">
		<div class="grid g12">
			<div class="container t4 c-pipa">
				<a href="<?php echo get_bloginfo('wpurl'); ?>/caminhao-de-pipa.html">
					<img src="<?php echo APP_WEBROOT; ?>/img/icon-gota.png" alt="" title="" />
				</a>
				<h4><a href="<?php echo get_bloginfo('wpurl'); ?>/caminhao-de-pipa.html">Caminhão Pipa</a></h4>
				<?php if ( isset($services[ 'home' ][ 'caminhao_pipa' ]) ) : ?>
				<p><a href="<?php echo get_bloginfo('wpurl'); ?>/caminhao-de-pipa.html"><?php echo $services[ 'home' ][ 'caminhao_pipa' ]; ?></a></p>
				<?php endif; ?>
			</div>
			<div class="container t4">
				<a href="<?php echo get_bloginfo('wpurl'); ?>/terceirizacao-de-frota.html">
					<img src="<?php echo APP_WEBROOT; ?>/img/icon-frota.png" alt="" title="" />
				</a>
				<h4><a href="<?php echo get_bloginfo('wpurl'); ?>/terceirizacao-de-frota.html">Terceirização de Frotas</a></h4>
				<?php if ( isset($services[ 'home' ][ 'terceirizacao_frotas' ]) ) : ?>
				<p><a href="<?php echo get_bloginfo('wpurl'); ?>/terceirizacao-de-frota.html"><?php echo $services[ 'home' ][ 'terceirizacao_frotas' ]; ?></a></p>
				<?php endif; ?>
			</div>
			<div class="container t4 s-carro">
				<a href="<?php echo get_bloginfo('wpurl'); ?>/conheca-nossos-seminovos.html">
					<img src="<?php echo APP_WEBROOT; ?>/img/icon-carro.png" alt="" title="" />
				</a>
				<h4><a href="<?php echo get_bloginfo('wpurl'); ?>/conheca-nossos-seminovos.html">Carros seminovos</a></h4>
				<?php if ( isset($services[ 'home' ][ 'seminovos' ]) ) : ?>
				<p><a href="<?php echo get_bloginfo('wpurl'); ?>/conheca-nossos-seminovos.html"><?php echo $services[ 'home' ][ 'seminovos' ]; ?></a></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>