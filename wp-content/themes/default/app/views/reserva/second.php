<?php 
// Dados de orçamento
if ( isset($orcamento) ) { $data = $orcamento['meta']; }
?>
<div class="row dstk interna">
	<div class="slide-dstk"></div>
</div>
<div class="row faixa"></div>
<div class="row cont-int reserve">
	<div class="limit">
		<div class="grid g12">
			<div class="container t9">
				<div class="titulo">
					<h1>Reserve seu veículo</h1>
				</div>

				<!-- Navigation -->
				<?php echo $this->element('reserva.navegacao'); ?>
				<!-- End: Navigation -->

				<span class="im-ilustrativa">"Todas as imagens são meramente ilustrativas"</span>

				<?php if ( isset($grupos) && is_array($grupos) && count($grupos) > 0 ) : ?>
				<form id="reserva" name="reserva" method="post" class="fase2" action="<?php echo get_bloginfo('wpurl'); ?>/reserva/passo-3.html">
					<input type="hidden" name="grupo" value="<?php echo isset($data['grupo'][0]) ? $data['grupo'][0] : ''; ?>" />
					<input type="hidden" name="veiculo" value="<?php echo isset($data['veiculo'][0]) ? $data['veiculo'][0] : ''; ?>"/>
					<?php $i = 1; ?>
					<ul class="carros mod2" style="position: relative;">
						<?php foreach($grupos as $grupo) : ?>
						<li>
							<a class="active" href="#" rel="<?php echo $grupo->getId(); ?>">
								<?php if (count($grupo->caracteristicas) > 0) : ?>
								<div class="descricao">
									<?php foreach($grupo->caracteristicas as $caracteristica) : ?>
									<p>- <?php echo $caracteristica; ?></p>
									<?php endforeach; ?>
								</div>
								<?php endif; ?>
								<span><?php echo quebra_limit_text("GRUPO ".$grupo->getTitle()); ?></span>
								<?php
								$imagem = $grupo->getThumbnail('grupo-thumb');
								if ( isset($imagem) && is_object($imagem) ) : 
								?>
								<img src="<?php echo $imagem->getSrc(); ?>" alt="<?php echo $grupo->getTitle(); ?>" title="<?php echo $grupo->getTitle(); ?>" />
								<?php endif; ?>
							</a>
						</li>
						<?php if ($i % 3 == 0) : ?>
						</ul>
						<?php if ( count($grupos) > 3) : ?>
						<ul class="carros mod2" style="position: relative;">
						<?php endif; ?>
						<?php endif; ?>
						<?php $i++; endforeach; ?>
					</ul>
					<div class="ajax-box-veiculos">
						<div class="box-selecao-veiculos" style="display:none;">
							<i class="seta-box"></i>
							<ul></ul>
						</div>
					</div>
					<button class="right"><i class="bl"></i><span>Continuar</span> <i class="br"></i><i class="bg-amarelo"></i> </button>	
				</form>			
				<?php endif; ?>
			</div>
			<?php if ( isset($data['grupo'][0]) ) : ?>
			<script type="text/javascript">
			jQuery(document).ready(function($) {
				var $box = $(".carros a.active[rel=<?php echo $data['grupo'][0]; ?>]");
				var data = {};

				<?php if ( isset($data['veiculo'][0]) ) : ?>
				data.veiculo = "<?php echo $data['veiculo'][0]; ?>";
				<?php endif; ?>

				$box.trigger('click', data);
				setTimeout(function() {
					$('html, body').scrollTop($box.offset().top);		
				}, 200);
			});		
			</script>
			<?php endif; ?>

			<!-- Budget -->
			<?php echo $this->element('sidebar.orcamento'); ?>
			<!-- End: Budget -->

		</div>
	</div>
</div>