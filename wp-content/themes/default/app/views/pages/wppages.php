<div class="row dstk interna">
	<div class="slide-dstk"></div>
</div>
<div class="row faixa"></div>
<div class="row cont-int">
	<div class="limit">
		<div class="grid g12">
			<div class="container <?php echo ($sidebar) ? 't8' : 't12'; ?>">
				<div class="titulo">
					<h1><?php echo $entity->getTitle(); ?></h1>
				</div>
				<?php 
				$content = $entity->getContent(true);
				if ( empty($content) ) :
				?>
				<h3>Página em construção</h3>
				<?php else: ?>
				<?php echo $content; ?>
				<?php endif; ?>
			</div>
			<?php if ($sidebar) { echo $this->element($sidebar); } ?>
		</div>
	</div>
</div>