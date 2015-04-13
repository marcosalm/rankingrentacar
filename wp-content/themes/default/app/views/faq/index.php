<?php $page = Post::findById(60); ?>
<?php
$i = ($pagobj->getActivePage() - 1);
if ($pagobj->getActivePage() > 0) $i = ($i * 10) + 1;
?>

<div class="row dstk interna">
	<div class="slide-dstk"></div>
</div>
<div class="row faixa"></div>
<div class="row cont-int2">
	<div class="limit">
		<div class="grid g12">
			<div class="container t12">
				<div class="titulo">
					<h1>Como alugar um carro</h1>
				</div>
				<?php echo $page->getContent(true); ?>
				<?php if ( isset($faqs) && count($faqs) ) : ?>
				<h6>Perguntas Frequentes</h6>
				<div class="panel-group" id="accordion">
					<?php foreach($faqs as $faq) : ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $faq->getId(); ?>">
									<span class="active"><?php echo $i; ?>.</span> <?php echo $faq->getTitle(); ?>
								</a>
							</h4>
						</div>
						<div id="collapse-<?php echo $faq->getId(); ?>" class="panel-collapse collapse">
							<div class="panel-body">
								<?php echo $faq->getContent(); ?>
							</div>
						</div>
					</div>
					<?php $i++; endforeach; ?>
				</div>
				<ul class="pagination">
					<?php echo $paginator; ?>
				</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>