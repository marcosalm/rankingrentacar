<div class="row dstk interna">
	<div class="slide-dstk"></div>
</div>
<div class="row faixa"></div>
<div class="row cont-int">
	<div class="limit">
		<div class="grid g12">
			<div class="container t12">
				<div class="titulo">
					<h1>Tarifas e modelos</h1>
				</div>
				<span class="im-ilustrativa">"Todas as imagens são meramente ilustrativas"</span>
				<?php if ( isset($grupos) && count($grupos) > 0 ) : ?>
				<ul class="carros">
					<?php foreach($grupos as $grupo) : ?>
					<li>
						<a href="<?php echo get_bloginfo('wpurl'); ?>/grupo/<?php echo $grupo->getName(); ?>.html">
							<div><i class="bt-mais"></i></div>
							<span><strong>GRUPO </strong>/ <?php echo $grupo->getTitle(); ?></span>
							<?php
							$imagem = $grupo->getThumbnail('grupo-thumb');
							if ( isset($imagem) && is_object($imagem) ) : 
							?>
							<img src="<?php echo $imagem->getSrc(); ?>" alt="<?php echo $grupo->getTitle(); ?>" title="<?php echo $grupo->getTitle(); ?>" />
							<?php endif; ?>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php else: ?>
				<h2>Nenhum grupo encontrado</h2>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>