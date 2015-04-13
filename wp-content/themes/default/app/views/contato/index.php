<div class="row dstk interna">
	<div class="slide-dstk"></div>
</div>
<div class="row faixa"></div>
<div class="row cont-int reserve">
	<div class="limit">
		<div class="grid g12">
			<div class="container t6">
				<div class="titulo">
					<h1>Fale Conosco</h1>
				</div>
				<?php if ( isset($message) ) : ?>
				<div class="alert <?php echo $class; ?>"><?php echo $message; ?></div>
				<?php endif; ?>
				<div class="fale_conosco">
					<h2>Contato</h2>
					<form action="<?php echo get_bloginfo('wpurl'); ?>/contato/fale-conosco.html" method="post">
						<ul>
							<li>
								<label for="nome">Nome*</label>
								<input data-title="Nome" class="tam1 need" id="nome" name="nome" type="text"/>
							</li>
							<li class="left">
								<label for="email">E-mail*</label>
								<input data-title="E-Mail" type="text" id="email" name="email" class="email need"/>
							</li>
							<li class="right">
								<label for="telefone">Telefone</label>
								<input data-title="Telefone" type="text" id="telefone" name="telefone" class="phone telefone"/>
							</li>
							<li class="left">
								<label for="obs">Mensagem*</label>
								<textarea data-title="Mensagem" class="need" name="obs" id="obs" rows="10"></textarea>
							</li>
						</ul>
						<button class="right"><i class="bl"></i><span>Enviar</span> <i class="br"></i><i class="bg-amarelo"></i> </button>
					</form>
				</div>
			</div>
			<?php if ( isset($enderecos) && count($enderecos) > 0 ) : ?>
			<div class="container t6">
				<div class="faixa3"></div>	
				<div class="endereco">
					<h2>Endereço</h2>
					<ul>
						<?php 
						foreach($enderecos as $endereco) :
							$meta     = get_post_meta($endereco->getId(), 'local_values', true);
							$endereco = isset($meta['endereco'])            ? $meta['endereco']                           : '';
							$telefone = !empty($meta['telefone-comercial']) ? '<br />Tel: ' . $meta['telefone-comercial'] : '';
							if ( !empty($endereco) ) :
						?>
						<li><?php echo $endereco; ?>‎<?php echo $telefone; ?></li>
						<?php 
						endif; endforeach; 
						?>
					</ul>
					<div style="width:400px; height:289px;" id="map"></div>
					<script type="text/javascript">
					google.maps.event.addDomListener(window, 'load', function() {
						var options = {
							zoom : 8,
							center : new google.maps.LatLng(-20.28002542353371, -40.292150600000014),
							mapTypeId : google.maps.MapTypeId.ROADMAP
						};
						var map = new google.maps.Map(document.getElementById('map'), options);

						<?php 
						foreach($enderecos as $endereco) :
							$meta     = get_post_meta($endereco->getId(), 'local_values', true);
							$lat      = isset($meta['latitude'])  ? $meta['latitude']  : 0;
							$lnt      = isset($meta['longitude']) ? $meta['longitude'] : 0;
							$endereco = isset($meta['endereco'])  ? $meta['endereco']  : '';
							if (!empty($endereco) && $lat && $lnt) :
						?>
						new google.maps.Marker({
							position: new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lnt; ?>),
							map: map,
							title: '<?php echo $endereco; ?>',
						});
						<?php 
						endif; endforeach; 
						?>
					});
					</script>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>