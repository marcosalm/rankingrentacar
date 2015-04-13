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
				
				<form name="reserva" method="post" class="fase1" action="<?php echo get_bloginfo('wpurl'); ?>/reserva/passo-2.html">
					<ul>
						<li>
							<label for="retirada_local">Local de retirada</label>
							<select data-title="Local de Retirada" title="Local de Retirada" id="retirada_local" name="retirada_local" class="need selectyze">
								<?php foreach($locais as $local) : ?>
								<option value="<?php echo $local; ?>"><?php echo $local; ?></option>
								<?php endforeach; ?>
							</select>
						</li>
						<li>
							<div class="date calendario left">
								<label for="retirada_data">Data de retirada</label>
								<input data-title="Data de Retirada" value="<?php echo isset($data['retirada_data']) ? $data['retirada_data'][0] : ''; ?>" class="need" title="Data de Retirada" id="retirada_data" name="retirada_data" size="16" type="text" />
								<span class="add-on"><i class="icon-calendar" onclick="document.reserva.retirada_data.focus();"></i></span>
							</div>
						</li>
						<li>
							<div class="menor ml">
									<?php createRangeSelect("Hora :","retirada_hora","need selectyze1",isset($data['retirada_hora']) ? $data['retirada_hora'][0] : '');?>
							</div>
						</li>
					</ul>
					<ul>
						<li>
							<label for="devolucao_local">Local de devolução</label>
							<select data-title="Local de Devolução" title="Local de Devolução" id="devolucao_local" name="devolucao_local" class="need selectyze">
								<?php foreach($locais as $local) : ?>
								<option value="<?php echo $local; ?>"><?php echo $local; ?></option>
								<?php endforeach; ?>
							</select>
						</li>
						<li>
							<div class="date calendario left">
								<label for="devolucao_data">Data de devolução</label>
								<input data-title="Data de Devolução" value="<?php echo isset($data['devolucao_data']) ? $data['devolucao_data'][0] : ''; ?>" class="need" title="Data de Devolução" id="devolucao_data" name="devolucao_data" size="16" type="text" />
								<span class="add-on"><i class="icon-calendar" onclick="document.reserva.devolucao_data.focus();"></i></span>
							</div>								
						</li>
						<li>
							<div class="menor ml">
							<?php createRangeSelect("Hora :","devolucao_hora","need selectyze1",isset($data['devolucao_hora']) ? $data['devolucao_hora'][0] : '');?>
								
							</div>
						</li>
					</ul>
					<button class="right"><i class="bl"></i><span>Continuar</span> <i class="br"></i><i class="bg-amarelo"></i> </button>
				</form>
			</div>
			<?php if ( isset($data) ) : ?>
			<script type="text/javascript">
				<?php if ( isset($data['retirada_local']) ) : ?>
				$('select[name=retirada\\_local]').val("<?php echo $data['retirada_local'][0]; ?>");
				<?php endif; ?>				
				<?php if ( isset($data['devolucao_local']) ) : ?>
				$('select[name=devolucao\\_local]').val("<?php echo $data['devolucao_local'][0]; ?>");
				<?php endif; ?>
			</script>
			<?php endif; ?>

			<!-- Budget -->
			<?php echo $this->element('sidebar.orcamento'); ?>
			<!-- End: Budget -->
		</div>
	</div>
</div>