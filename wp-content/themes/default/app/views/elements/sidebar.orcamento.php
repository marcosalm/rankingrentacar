<?php if ( isset($orcamento) ) : extract($orcamento); endif; ?>

<?php
// Valores
$valorProtecoes = 0; // Valor das proteções
$valorServicos  = 0; // Valor dos serviços adicionais
$valorDiaria    = 0; // Valor da diária (Quantidade de dias x Valor da Diária)
?>
<div class="container t3">
	<div class="faixa2"></div>
	<div class="resultado-orcamento mod2">
		<h2>Seu <strong>Orçamento</strong></h2>
		<div class="line white"><span></span></div>

		<!-- Budget -->
		<?php if ( !isset($orcamento) || ( empty($grupo) && empty($veiculo) ) ) : ?>
		<br /><br />
		<p><strong>Nenhum item adicionado</strong></p>
		<?php else: ?>
		
		<br />
		<p>
			Grupo 
			<?php echo $grupo->getTitle(); ?>
			<br />
			<?php echo $veiculo->getTitle(); ?> - <?php echo $veiculo->getCustomField('marca'); ?> / <?php echo $veiculo->getCustomField('modelo'); ?>
		</p>
		<br />
		<!-- Taxes 
		<?php if ( isset($meta['tarifa']) ) : ?>
		<hr />
		<p>Tarifa - <strong>R$ <?php echo $grupo->getTarifaValue( $meta['tarifa'][0] ); ?></strong></p>
		<?php endif; ?>
		Taxes: End -->

		<!-- Day -->
		<?php
		/**
		 * 1) Calcula a quantidade de dias entre a data de devolução e data de retirada
		 * 2) Obtém o valor da tarifa selecionada
		 * 3) Calcula o valor da diária 
		 * 4) Exibe o valor da diária apenas quando existir e for maior que zero
		 
		$devolucao   = explode("/", $meta['devolucao_data'][0]);
		$devolucaoT  = mktime(0, 0, 0, $devolucao[1], $devolucao[0], $devolucao[2]);		
		$retirada    = explode("/", $meta['retirada_data'][0]);
		$retiradaT   = mktime(0, 0, 0, $retirada[1], $retirada[0], $retirada[2]);
		$dias        = abs((($devolucaoT - $retiradaT) / 3600) / 24);
		$tarifa      = isset($meta['tarifa'][0]) ? $meta['tarifa'][0] : 0;
		$grupo       = $orcamento['grupo'];
		$valorTarifa = $grupo->getTarifaValue($tarifa, false);
		$valorDiaria = ($dias + 1) * $valorTarifa;
		*/
		
		/**
		 * 1) Calcula a quantidade de dias entre a data de devolução e data de retirada
		 * 2) Obtém o valor da tarifa selecionada
		 * 3) Calcula o valor da diária 
		 * 4) Exibe o valor da diária apenas quando existir e for maior que zero
		 **/
		 
		$devolucao   = explode("/", $meta['devolucao_data'][0]);
		$dev_hora = explode(":",$meta['devolucao_hora'][0]);
		$devolucaoT  = mktime($dev_hora[0], $dev_hora[1], 0, $devolucao[1], $devolucao[0], $devolucao[2]);		
		$retirada    = explode("/", $meta['retirada_data'][0]);
		$ret_hora = explode(":",$meta['retirada_hora'][0]);
		$retiradaT   = mktime($ret_hora[0],$ret_hora[1], 0, $retirada[1], $retirada[0], $retirada[2]);
		$horas        = abs((($devolucaoT - $retiradaT) / 3600));
		
		if ($horas < 24){
		$dias = 1;
		} 
		else{
		$dias = floor($horas / 24);
		$hora_add = $horas % 24;
		
		}
		$tarifa      = isset($meta['tarifa'][0]) ? $meta['tarifa'][0] : 0;
		$grupo       = $orcamento['grupo'];
		$valorTarifa = $grupo->getTarifaValue($tarifa, false);
		$valorDiaria = $dias * $valorTarifa;
		if (isset($hora_add)){
		$valorHoraAdicional = $hora_add * ($valorTarifa/6);
		}
		if ( is_numeric($valorTarifa) && $valorTarifa > 0) :
		?>
		<br />
		<p>De: <?php echo $meta['retirada_data'][0]; ?> às <?php echo $meta['retirada_hora'][0]; ?></p>
		<p> Até: <?php echo $meta['devolucao_data'][0]; ?> às <?php echo $meta['devolucao_hora'][0]; ?></p>
		<br />
		<table width="190">
		<tr><td >
		<p><?php echo $dias;?> <small>Diárias</small></p> </td> <td><p> <strong style="float:right;">R$ <?php echo number_format($valorDiaria, 2, ',', ''); ?></strong></p></td></tr>
		<?php if (isset($valorHoraAdicional)){?>
		<tr><td >
		<p><?php echo $hora_add;?> <small>Horas Adicionais</small> </p> </td> <td><p> <strong style="float:right;">R$ <?php echo number_format($valorHoraAdicional, 2, ',', ''); ?></strong></p></td></tr>
		<?php }?>
		<?php endif; ?>
		<!-- Day: End -->

		<!-- Security -->
		<?php 
		if ( isset($meta['protecoes'][0]) ) :
			$protecoes = maybe_unserialize( $meta['protecoes'][0] );
			if ( !is_array($protecoes) ) { $protecoes = array($protecoes); }
			foreach($protecoes as $protecao) { $valorProtecoes += $grupo->getCustomField($protecao); }
		?><tr><td width="120">
		<p>Proteção </p></td> <td> <p><strong style="float:right;">R$ <?php echo number_format($valorProtecoes * $dias , 2, ',', ''); ?></strong></p></td></tr></table>
		<?php endif; ?>
		<!-- Security: End -->

		<!-- Extras -->
		<?php if ( isset($meta['servicos'][0]) ) :
			
			$servicos = maybe_unserialize( $meta['servicos'][0] );
			$servico_nome = $servicos;
			$options  = get_option('config_servicos_adicionais');
			if ( !is_array($servicos) ) { $servicos = array($servicos); }
			foreach($servicos as $servico) { $valorServicos += (float) $options[ $servico ]; }
		?>
		<?php 
		
		foreach($servico_nome as $servico_n){
		$option  = get_option('config_servicos_adicionais');
		$valorServico = 0;
		if ($servico_n == "cadeira_bebe"){
		$valorServico =  $option[$servico_n];
	        echo "<table width='190'>
		<tr><td><p></small>Cadeira Bebê <small></p></td><td><p><strong style='float:right;'>R$ ".number_format($valorServico * $dias, 2, ',', '')."</strong></p></td></tr></table>";
				}
				 else{
					 if ($servico_n == "gps"){
					 $valorServico =  $option[ $servico_n ];
					 echo "<table width='190'>
		<tr><td width='120'><p><small>GPS</small>  </p></td><td><p><strong style='float:right;'>R$ ".number_format($valorServico * $dias, 2, ',', '')."</strong></p></td></tr></table>";
					 } 
					 else{
					 $valorServico =  $option[ $servico_n];
					 if ($valorServico != 0) {
					  echo "<table width='190'>
		<tr><td width='120'><p><small>Motorísta</small> </p></td><td><p><strong style='float:right;'>R$ ".number_format($valorServico * $dias, 2, ',', '')."</strong></p></td></tr></table>";
					 }
					 else{
					  echo "<br><p><small><strong>Motorista Bilíngue sob consulta</strong></small></p><br>";
					 }
					 }
			}
		} ?>
		<?php endif; ?>
		<!-- Extras: End -->

		<!-- Sum -->
		<?php if ($valorProtecoes || $valorServicos) : ?>
		<?php
		$tarifaTotal = $grupo->getTarifaValue( $meta['tarifa'][0], true);
		if ( !isset($tarifaTotal) ) { $tarifaTotal = 0; }
		?>
		<br />
		<hr />
		<table width="190">
		<tr><td>
			<p ><small>VALOR TOTAL</small></p></td><td>
			<strong class="price right" style="float:right;">R$ <?php echo number_format($valorDiaria + (($dias + 1) * $valorProtecoes) + (($dias + 1) * $valorServicos), 2, ',', ''); ?></strong></td></tr></table>
			<br>
			
			<?php if ( isset($orcamento) ) : ?>
		<a href="<?php echo get_bloginfo('wpurl'); ?>/reserva/cancelar.html" class="left bt-troca">Nova Cotação</a>
		<?php endif; ?>
		<a href="<?php echo get_bloginfo('wpurl'); ?>/reserva/passo-2.html" class="right bt-troca">Trocar veículo</a>
		
		<?php endif; ?>
		<!-- Sum: End -->

		<?php endif; ?>
		<!-- Budget: End -->
	</div>
</div>