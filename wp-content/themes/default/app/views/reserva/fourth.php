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

				<form name="reserva" class="fase1 mod2" method="post" action="<?php echo get_bloginfo('wpurl'); ?>/contato/reserva/passo-4.html">
					<input type="hidden" name="finish" />
					<ul>
						<li>
							<label for="cliente">Nome do cliente*</label>
							<input data-title="Nome do Cliente" class="tam1 need" id="cliente" type="text" name="cliente" />
						</li>
						<li>
							<label for="cpfcnpj">CPF*</label>
							<input data-title="CPF" type="text" id="cpfcnpj" name="cpfcnpj" class="need cpf" />
							</li>
						<li>
							<label for="email">E-mail*</label>
							<input data-title="E-Mail" class="tam1 need" id="email" type="text" name="email" />
							
						</li>
						<li>
							<label for="telefone">Telefone*</label>
							<input data-title="Telefone" class="phone need" id="telefone" type="text" name="telefone" />
						</li>
						<li>
							<label for="observacoes">Observações</label>
							<textarea name="observacoes" id="observacoes" rows="10"></textarea>
						</li>
					</ul>
					<?php
					// Arquivo de contrato
					$options = get_option('config_servicos_adicionais');
					if ( isset($options['contrato']) ) : $contrato = $options['contrato']; 
					?>
					<a target="_blank" href="<?php echo $contrato; ?>">
						<button class="left" type="button"><i class="bl"></i><span>Download PDF</span> <i class="br"></i><i class="bg-amarelo icon-pdf"></i> </button>
					</a>
					<?php endif; ?>
					<button class="right" type="submit"><i class="bl"></i><span>Finalizar</span> <i class="br"></i><i class="bg-amarelo"></i> </button>
				</form>
			</div>

			<!-- Budget -->
			<?php echo $this->element('sidebar.orcamento'); ?>
			<!-- End: Budget -->

			<?php if ( isset($finish) ) : ?>
			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">
							<p>Reserva efetuada com sucesso! A Ranking agradece pela preferência. Nossa equipe entrará em contato em alguns instantes.</p>
							<div class="bloco">
								<div class="modal_carro">
									<?php
									$veiculo = $orcamento['veiculo'];
									$marca   = $veiculo->getCustomField('marca');
									$modelo  = $veiculo->getCustomField('modelo');
									?>
									<h3><?php echo $veiculo->getTitle(); ?></h3>
									<?php
									$imagem = $veiculo->getThumbnail('grupo-thumb');
									if ( isset($imagem) && is_object($imagem) ) : 
									?>
									<img src="<?php echo $imagem->getSrc(); ?>" alt="" title="" />
									<?php endif; ?>
									<span class="im-ilustrativa">"Todas as imagens são meramente ilustrativas"</span>
									<!--ul class="carro">
										<li><i class="icon icon-a">pessoas</i></li>
										<li><i class="icon icon-b">mala</i></li>
										<li><i class="icon icon-c">portas</i><span>x4</span></li>
										<li><i class="icon icon-d">ar condicionado</i></li>
									</ul-->
								</div>
								<ul class="informacoes">
									<li><strong><p>Código</p></strong> <?php echo $orcamento['meta']['codigo'][0]; ?></li>
									<li><strong><p>Local de Retirada</p></strong> <?php echo $orcamento['meta']['retirada_local'][0]; ?></li>
									<!--li><strong><p>Valor Total</p></strong></li-->
								</ul>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" data-toggle="modal" href="<?php echo get_bloginfo('wpurl'); ?>/reserva/finalizar.html" class="right" onclick="document.location.href = '<?php echo get_bloginfo('wpurl'); ?>/reserva/finalizar.html';"><i class="bl"></i><span>Concluir</span> <i class="br"></i><i class="bg-amarelo"></i> </button>
						</div>
					</div>
				</div>
			</div>
			<!-- Modal: End -->
			<script>
			$(function() { $('#myModal').modal(); });
			</script>
			<?php endif; ?>
		</div>
	</div>
</div>