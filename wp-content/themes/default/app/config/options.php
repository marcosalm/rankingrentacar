<?php

/**
 * Ranking - Arquivo de configuração
 */

// Define modo Debug (Exibir erros PHP ou não)
Config::set('DEBUG', true);

// Define o path da logo para a página de login Wordpress
Config::set('LOGIN_IMG', APP_WEBROOT . '/img/logo_ranking.png');

// Define uma pequena lista de configuração fixa para uso de reserva que não serão editáveis via Wordpress
Config::set('reserva', array(

	// Localidades para devolução/retirada
	'locais' => array('Vitória', 'Cariacica', 'Aeroporto')
));

/**
 * Define sidebars específicas para determinados posts/páginas Wordpress por seu id
 *
 * - O arquivo das sidebars deve estar contido em themes/default/app/views/elements
 *
 * Exemplo:
 *
 * array(
 * 		'código_do_post' => 'nome_da_sidebar_sem_extensão'
 * )
 *
 */
Config::set('sidebars', array(
	'62' => 'sidebar.terceirizacao', // Terceirização de Frotas
	'64' => 'sidebar.caminhao'       // Caminhão Pipa
));

/**
 * Configura colunas personalizadas para post_types customizados
 * - Dependência: Plugin - Advanced Custom Fields (ACF)
 *
 * Exemplo:
 *
 * array(
 * 		'post_type' => array(
 *			'nome_do_campo_no_acf_contido_neste_post_type' => array(
 * 				'name' => 'Nome do campo a ser exibido no cabeçalho'
 *			)
 * 		)
 * )
 *
 * - A coluna, bem como o conteúdo da mesma, será adicionada na listagem dos post_types configurados
 */
Config::set('post_types', array(
	'veiculo' => array(
		'marca' => array(
			'name' => 'Marca'
		),
		'modelo' => array(
			'name' => 'Modelo'
		)
	),
	'grupo' => array(
		'caracteristicas' => array(
			'name' => 'Caracter&iacute;sticas'
		),
		'passageiros' => array(
			'name' => 'Passageiros'
		),
		'bagagens' => array(
			'name' => 'Bagagens'
		)
	),
	'destaque' => array(
		'link' => array(
			'name' => 'Link associado'
		)
	),
	'reserva' => array(
		'codigo' => array(
			'name' => 'Código'
		)
	)
));

// Cache de arquivos
$ud = wp_upload_dir();
Config::set('GD_CACHE', $ud['basedir'] . '/gdcache');
?>