<?php
// Monta navegação de acordo com a URL atual
$url = Context::getRealURI();
switch($url) {
	case '/reserva/passo-1.html' :
	case '/reserve-seu-veiculo.html' :
		$width = '0px';
		$active = 1;
	break;

	case '/reserva/passo-2.html' :
		$width = '340px';
		$active = 2;
		break;
		
	case '/reserva/passo-3.html' :
	default:
		$width = '660px';
		$active = 3;
		break;
}
?>
<div class="fases">
	<div class="fundo"></div>
	<div class="avanco" style="width: <?php echo $width; ?>"></div>
	<div class="etapa left">
		<a class="<?php echo $active >= 1 ? 'active' : ''; ?>" href="<?php echo get_bloginfo('wpurl'); ?>/reserva/passo-1.html">1</a>
		<p>Reserve<br />seu veículo</p>
	</div>
	<div class="etapa center">
		<?php if ( isset($orcamento['meta']) && count($orcamento['meta']) > 0 ) : ?>
		<a class="<?php echo $active >= 2 ? 'active' : ''; ?>" href="<?php echo get_bloginfo('wpurl'); ?>/reserva/passo-2.html">2</a>
		<?php else: ?>
		<span>2</span>
		<?php endif; ?>
		<p>Escolha<br />seu veículo</p>
	</div>
	<div class="etapa right">
		<?php if ( isset($orcamento[ 'grupo' ]) && count($orcamento[ 'grupo' ]) > 0 ) : ?>
		<a class="<?php echo $active >= 3 ? 'active' : ''; ?>" href="<?php echo get_bloginfo('wpurl'); ?>/reserva/passo-3.html">3</a>
		<?php else: ?>
		<span>3</span>
		<?php endif; ?>
		<p>Tarifas /<br />Proteção</p>
	</div>
</div>