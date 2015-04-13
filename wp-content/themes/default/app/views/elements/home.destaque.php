<?php
$destaques = Post::find(array(
	'post_type'   => 'destaque',
	'post_status' => 'publish'
));

if ( isset($destaques) && is_array($destaques) && count($destaques) > 0 ) : 
?>
<div class="row dstk">
	<ul class="slide-dstk">
		<?php
		foreach($destaques as $destaque) :
			$imagem = $destaque->getThumbnail();
			if ( isset($imagem) ) :
				$link = $destaque->getCustomField('link');
				if ( !empty($link) ) :
				?>
				<li>
					<a target="_blank" href="<?php echo $link; ?>">
						<span style="background:url('<?php echo $imagem->getSrc(); ?>') no-repeat center center;"></span>
					</a>
				</li>
			<?php else: ?>
				<li><span style="background:url('<?php echo $imagem->getSrc(); ?>') no-repeat center center;"></span></li>
			<?php endif; ?>
		<?php 
			endif; 
		endforeach; 
		?>
	</ul>		
	<div class="limit cont-dstk">
		<div class="grid g12">
			<div class="container t5">
				<form method="post" action="<?php echo get_bloginfo('wpurl'); ?>/reserva/passo-2.html" name="reserva">
					<h1><strong>Reserve</strong> seu veículo</h1>
					<div class="line"><span></span></div>						
					<div class="selecao">
						<label for="retirada_local">Local da Retirada:</label>
						<select id="retirada_local" name="retirada_local" class="selectyze">
							<?php foreach($locais as $local) : ?>
							<option value="<?php echo $local; ?>"><?php echo $local; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="selecao">
						<label for="devolucao_local">Local de Devolução:</label>
						<select id="devolucao_local" name="devolucao_local" class="selectyze">
							<?php foreach($locais as $local) : ?>
							<option value="<?php echo $local; ?>"><?php echo $local; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="selecao">
						<div class="date calendario left" data-date="" data-date-format="">
							<label for="retirada_data">Data de Retirada:</label>
							<input data-title="Data de Retirada" class="need" id="retirada_data" name="retirada_data" size="16" type="text">
							<span class="add-on"><i class="icon-calendar" onclick="document.reserva.retirada_data.focus();"></i></span>
						</div>

						<div class="menor ml">
							<!--label for="retirada_hora">Hora:</label-->
							<?php createRangeSelect("Hora :","retirada_hora","need selectyze1");?>
							<!--input data-title="Hora de Retirada" class="hora need" type="text" id="retirada_hora" name="retirada_hora" style="width: 139px;" /-->
						</div>
					</div>

					<div class="selecao">
						<div class="date calendario left" data-date="" data-date-format="">
							<label for="devolucao_data">Data de Devolução</label>
							<input data-title="Data de Devolução" class="need" id="devolucao_data" name="devolucao_data" size="16" type="text">
							<span class="add-on"><i class="icon-calendar" onclick="document.reserva.devolucao_data.focus();"></i></span>
						</div>

						<div class="menor ml">
						<?php createRangeSelect("Hora :","devolucao_hora","need selectyze1");?>
							<!--label for="devolucao_hora">Hora:</label>
							<input data-title="Hora de Devolução" class="hora need" type="text" id="devolucao_hora" name="devolucao_hora" style="width: 139px;" /-->
						</div>
					</div>
					<button class="right"><i class="bl"></i><span>Continuar</span> <i class="br"></i><i class="bg-amarelo"></i> </button>
				</form>
			</div>

			<div class="container t7">
				<ul class="descricao-dstk">
					<?php foreach($destaques as $destaque) : ?>
					<li>
						<h2><?php echo $destaque->getTitle(); ?></h2>
						<span><?php echo $destaque->getContent(true); ?></span>
					</li>
					<?php endforeach; ?>
				</ul>
				<div class="bt-dstk"></div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>