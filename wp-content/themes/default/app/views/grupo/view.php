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
				<ul class="modelos">
					<?php foreach($grupo->getVeiculos() as $veiculo) : ?>
					<li>
						<div>
							<?php
							$imagem = $veiculo->getThumbnail('grupo-thumb');
							if ( is_object($imagem) ) :
							?>
							<img src="<?php echo $imagem->getSrc(); ?>" title="" alt="" />
							<?php endif; ?>

							<!--ul>
								<li><i class="icon icon-a">pessoas</i></li>
								<li><i class="icon icon-b">mala</i></li>
								<li><i class="icon icon-c">portas</i><span>x4</span></li>
								<li><i class="icon icon-d">ar condicionado</i></li>
							</ul-->
						</div>
						<div>
							<h2><?php echo $veiculo->getTitle(); ?></h2>
							<hr>
							<p><?php echo $veiculo->getContent(); ?></p>
						</div>
						<a href="<?php echo get_bloginfo('wpurl'); ?>/reserva/passo-1.html" class="botao"><i class="bl"></i><span>Reserve já</span> <i class="br"></i><i class="bg-amarelo"></i> </a>
					</li>
					<?php endforeach; ?>
				</ul>
				<div class="tabelas">
					<h6>Tarifas</h6>
					<ul class="tarifas">
						<li>
							<span>Diária + km Rodado</span>
							<p>R$ <?php echo $grupo->getTarifaValue('valortarifadiariatext', false); ?> por km)</p>
						</li>
						<li>
							<span>Diária com 150km Livres</span>
							<p>R$ <?php echo $grupo->getTarifaValue('valortarifadiaria150livre'); ?></p>
						</li>
						<li>
							<span>Diária com km Livre <i>(Acima de 3 diárias)</i></span>
							<p>R$ <?php echo $grupo->getTarifaValue('valortarifadiariakmlivre'); ?></p>
						</li>
					</ul>						
					<h6>Proteção</h6>
					<ul class="tarifas mod2">
						<li>
							<span>10% e 20% do valor do veículo</span>
							<p>R$ <?php echo $grupo->getProtecaoValue('valorprotecao1020valorveiculo'); ?></p>
						</li>
						<li>
							<span> 5% e 10% do valor  do veículo</span>
							<p>R$ <?php echo $grupo->getProtecaoValue('valorprotecao510valorveiculo'); ?></p>
						</li>
					</ul>						
				</div>
			</div>
		</div>
	</div>
</div>