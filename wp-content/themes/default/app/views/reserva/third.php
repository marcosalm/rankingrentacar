<?php 
// Dados de orçamento
if ( isset($orcamento) ) : extract($orcamento); endif; 
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

				<form name="reserva" method="post" action="<?php echo get_bloginfo('wpurl'); ?>/reserva/passo-4.html">
					<div class="grid g9">
						<div class="container t6 re-3">
							<h6 style="margin-top:0;">TARIFAS</h6>
							<ul class="tarifas">
								<li>
									<span>Diária + km Rodado</span>
									<!--p><input checked="checked" name="tarifa" value="valortarifadiaria" type="radio">R$ <?php /*echo $grupo->getTarifaValue('valortarifadiaria');*/ ?> (por km)</p -->
									<p><input checked="checked" name="tarifa" value="valortarifadiaria" type="radio">R$ <?php echo $grupo->getTarifaValue('valortarifadiariatext', false); ?> por km)</p>
								</li>
								<li>
									<span>Diária com 150km Livres</span>
									<p><input name="tarifa" value="valortarifadiaria150livre" type="radio">R$ <?php echo $grupo->getTarifaValue('valortarifadiaria150livre'); ?></p>
								</li>
								<li>
									<span>Diária com km Livre <i>(Acima de 3 diárias)</i></span>
									<p><input name="tarifa" value="valortarifadiariakmlivre" type="radio">R$ <?php echo $grupo->getTarifaValue('valortarifadiariakmlivre'); ?></p>
								</li>
							</ul>
							<h6>PROTEÇÃO</h6>
							<ul class="lista">
								<li>
									<input checked="checked" type="radio" name="protecoes[]" value="valorprotecao1020valorveiculo" /><p>
									<strong><a href="#" title="Em caso de roubo, incêndio, furto ou perda total você deve ressarcir à locadora 20% do valor de mercado do 
										veículo baseado na tabela da Fundação Instituto de Pesquisas Econômicas (Fipe). Outros danos, como colisões, responsabilizam o usuário 
										a pagar até 10% do valor para custear a manutenção.">Proteção de 10% e 20%</a> do valor do veículo.</strong>
									</p>
								</li>
								<li>
									<input type="radio" name="protecoes[]" value="valorprotecao510valorveiculo" /><p><strong><a href="#" title="Em caso de roubo, incêndio, furto ou perda total você deve ressarcir à locadora 10% do valor 
									de mercado do veículo baseado na tabela da FIPE (Fundação Instituto de Pesquisas Econômicas). Outros danos, como colisões, responsabilizam o 
									usuário a pagar até 5% do valor para custear a manutenção.">Proteção de 5% e 10%</a> do valor do veículo.</strong></p>
								</li>
							</ul>
							<h6>SERVIÇOS ADICIONAIS</h6>
							<?php $servicos = get_option('config_servicos_adicionais'); ?>
							<ul class="lista">
								<li>
									<input name="servicos[]" value="cadeira_bebe" type="checkbox"><p><strong>Cadeira de Bebê - <?php echo is_numeric($servicos['cadeira_bebe']) ? 'R$ ' . number_format($servicos['cadeira_bebe'], 2, ',', '') . ' /diária' : 'Sob consulta'; ?></strong></p>
								</li>
								<li>
									<input name="servicos[]" value="motorista_bilingue" type="checkbox"><p><strong>Motorista Bilíngue - <?php echo is_numeric($servicos['motorista_bilingue']) ? 'R$ ' . number_format($servicos['motorista_bilingue'], 2, ',', '') . ' /diária' : 'Sob consulta'; ?></strong></p>
								</li>								
								<li>
									<input name="servicos[]" value="gps" type="checkbox"><p><strong>GPS - <?php echo is_numeric($servicos['gps']) ? 'R$ ' . number_format($servicos['gps'], 2, ',', '') . ' /diária' : 'Sob consulta'; ?></strong></p>
								</li>
							</ul>
						</div>
						<div class="container t3">
							<div class="modelo">
								<?php
								// Exibição do veículo
								if ( isset($orcamento['grupo']) && isset($orcamento['veiculo']) ) : 
									$grupo   = $orcamento['grupo'];
									$veiculo = $orcamento['veiculo'];
								?>
								<h2>Grupo <?php echo $grupo->getTitle(); ?></h2>
								<h3><?php echo $veiculo->getTitle(); ?></h3>
								<?php
								$imagem = $veiculo->getThumbnail('grupo-thumb');
								if ( is_object($imagem) ) :
								?>
								<img src="<?php echo $imagem->getSrc(); ?>" title="<?php echo $veiculo->getTitle(); ?>" alt="<?php echo $veiculo->getTitle(); ?>" />
								<?php endif; ?>
								<?php endif; ?>
								<span class="im-ilustrativa">"Todas as imagens são meramente ilustrativas"</span>
							</div>
						</div>
					</div>
					<button class="right" type="submit"><i class="bl"></i><span>Continuar</span> <i class="br"></i><i class="bg-amarelo"></i> </button>	
				</form>	
			</div>
			<script type="text/javascript">
			jQuery(document).ready(function($) {
				<?php if ( isset($orcamento['meta']['tarifa'][0]) ) : ?>
				$("input[name=tarifa][value=<?php echo $orcamento['meta']['tarifa'][0]; ?>]").trigger("click");
				<?php endif; ?>
				<?php 
				if ( isset($orcamento['meta']['protecoes'][0]) ) {
					$protecoes = maybe_unserialize($orcamento['meta']['protecoes'][0]);
					if ( !is_array($protecoes) ) { $protecoes = array($protecoes); }
					foreach($protecoes as $protecao) {
				?>
				$("input[value=<?php echo $protecao; ?>]").trigger("click");
				<?php
					}
				}
				?>
				<?php 
				if ( isset($orcamento['meta']['servicos'][0]) ) {
					$servicos = maybe_unserialize($orcamento['meta']['servicos'][0]);
					if ( !is_array($servicos) ) { $servicos = array($servicos); }
					foreach($servicos as $servico) {
				?>
				$("input[value=<?php echo $servico; ?>]").trigger("click");
				<?php
					}
				}
				?>
			});
			</script>

			<!-- Budget -->
			<?php echo $this->element('sidebar.orcamento'); ?>
			<!-- End: Budget -->
		</div>
	</div>
</div>