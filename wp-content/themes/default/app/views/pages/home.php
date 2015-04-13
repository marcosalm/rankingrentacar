<!-- Featured -->
<?php echo $this->element('home.destaque'); ?>
<!-- End: Featured -->

<!-- FAQ -->
<?php echo $this->element( 'home.faq', array('limit' => 3) ); ?>
<!-- End: FAQ -->

<!-- Info -->
<div class="row emp-cert">
	<div class="limit">
		<div class="grid g12">
			<div class="container t12">
				<div class="left">
					<h4>empresa</h4>
					<span><strong>Desde 1990,</strong> a Ranking prioriza o bom atendimento  buscando sempre a satisfação dos clientes.</span>
					<p>Com uma equipe profissional capacitada e uma frota constantemente aperfeiçoada, os serviços prestados garantem – nos os melhores resultados.</p>
				</div>
				<div class="right">
					<h4>certificados</h4>
					<ul>
						<li><img src="<?php echo APP_WEBROOT; ?>/img/cert_fornecedor.png" alt=""></li>
						<li><img src="<?php echo APP_WEBROOT; ?>/img/cert-iso.png" alt="" class="cert-iso"></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End: Info -->

<!-- Services -->
<?php echo $this->element('home.servicos'); ?>
<!-- End: Services -->