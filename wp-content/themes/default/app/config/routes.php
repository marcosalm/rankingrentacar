<?php
/**
 * Ranking - Rotas
 */

if ( !function_exists('is_plugin_active') ) {
	include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

/*
 ***********************************************************
 * Gerencia rotas para páginas não-wordpress               *
 ***********************************************************
 */
// Home
Router::connect(
	array('/'), 
	array(
		'controller' => 'pages', 
		'action'     => 'home',
		'vars'       => array(
			'seo' => array(
				'title'       => 'Ranking Rent a Car | Reserva de veículos',
				'description' => 'A Ranking Rent a Car aluga veículos no ES e oferece soluções para você e a sua empresa. Faça uma reserva!',
				'keywords'    => 'ranking, es, rent a car, aluguel de veículos, soluções veículos, caminhão pipa, tercerização de frota'
			)
		)
	)
);

// Tarifas e Modelos > Listagem
Router::connect(
	array(
		'/tarifas-e-modelos.html',
		'/grupo/listar.html'
	),
	array(
		'controller' => 'grupo', 
		'action'     => 'listar',
		'vars'       => array(
			'seo' => array(
				'title'       => 'Ranking Rent a Car | Locadora de veículos',
				'description' => 'Conheça a Ranking Rent a Car, locadora de veículos com unidades nas cidades de Vitória e Cariacica. Confira nossas vantagens!',
				'keywords'    => 'locadora de veículos, es, vitória, cariacica, ranking rent a car, ranking locadora'
			)
		)
	)
);

// Tarifas e Modelos > Visualizar
Router::connect(
	array('/grupo/*.html'), 
	array(
		'controller' => 'grupo', 
		'action'     => 'view'
	)
);

// Reserva de Veículo > Passo 1
Router::connect(
	array(
		'/reserva/passo-1.html',
		'/reserve-seu-veiculo.html'
	), 
	array(
		'controller' => 'reserva', 
		'action'     => 'first',
		'vars'       => array(
			'seo' => array(
				'title'       => 'Faça sua reserva online | Ranking Rent a Car',
				'description' => 'Alugue um carro na Ranking Rent a Car, qualidade no atendimento, carros novos e preço justo. Faça sua reserva!',
				'keywords'    => 'reserva online, aluguel de carro, reserva de veículos, locação de carros, rent a car, reserva online'
			)
		)
	)
);

// Reserva de Veículo > Passo 2
Router::connect(
	array('/reserva/passo-2.html'), 
	array(
		'controller' => 'reserva', 
		'action'     => 'second',
		'vars'       => array(
			'seo' => array(
				'title'       => 'Faça sua reserva online | Ranking Rent a Car',
				'description' => 'Alugue um carro na Ranking Rent a Car, qualidade no atendimento, carros novos e preço justo. Faça sua reserva!',
				'keywords'    => 'reserva online, aluguel de carro, reserva de veículos, locação de carros, rent a car, reserva online'
			)
		)
	)
);

// Reserva de Veículo > Passo 3
Router::connect(
	array('/reserva/passo-3.html'), 
	array(
		'controller' => 'reserva', 
		'action'     => 'third',
		'vars'       => array(
			'seo' => array(
				'title'       => 'Faça sua reserva online | Ranking Rent a Car',
				'description' => 'Alugue um carro na Ranking Rent a Car, qualidade no atendimento, carros novos e preço justo. Faça sua reserva!',
				'keywords'    => 'reserva online, aluguel de carro, reserva de veículos, locação de carros, rent a car, reserva online'
			)
		)
	)
);

// Reserva de Veículo > Passo 4
Router::connect(
	array(
		'/reserva/passo-4.html',
		'/contato/reserva/passo-4.html'
	),
	array(
		'controller' => 'reserva', 
		'action'     => 'fourth',
		'vars'       => array(
			'seo' => array(
				'title'       => 'Faça sua reserva online | Ranking Rent a Car',
				'description' => 'Alugue um carro na Ranking Rent a Car, qualidade no atendimento, carros novos e preço justo. Faça sua reserva!',
				'keywords'    => 'reserva online, aluguel de carro, reserva de veículos, locação de carros, rent a car, reserva online'
			)
		)
	)
);

// Reserva de Veículo > Cancelar
Router::connect(
	array('/reserva/cancelar.html'),
	array('controller' => 'reserva', 'action' => 'cancelar')
);

// Reserva de Veículo > Finalizar
Router::connect(
	array('/reserva/finalizar.html'),
	array('controller' => 'reserva', 'action' => 'finalizar')
);

// Faq > Listagem (Como alugar um carro)
Router::connect(
	array(
		'/faq', 
		'/faq/',
		'/como-alugar*',
		'/faq/index.html'
	),
	array('controller' => 'faq', 'action' => 'index')
);

// Ajax > Carregar veículos associados a um determinado grupo
Router::connect(
	array('/ajax/reserva/veiculos'),
	array('controller' => 'reserva', 'action' => 'loadVeiculos')
);

// Contato > Fale conosco
Router::connect(
	array(
		'/fale-conosco.html',
		'/contato/fale-conosco.html'
	),
	array(
		'controller' => 'contato', 
		'action'     => 'index',
		'vars'       => array(
			'seo' => array(
				'title'       => 'Fale Conosco | Ranking Rent a Car',
				'description' => 'Caso surja alguma qualquer dúvida ou queira fazer alguma sugestão, entre em contato conosco!',
				'keywords'    => 'ranking contato, contato, alguel de carro contato, reservar carro, duvida, rent a car contato'
			)
		)
	)
);

// Contato > Trabalhe conosco
Router::connect(
	array(
		'/trabalhe-conosco.html',
		'/contato/trabalhe-conosco.html'
	),
	array(
		'controller' => 'contato', 
		'action'     => 'trabalhe',
		'vars'       => array(
			'seo' => array(
				'title'       => 'Trabalhe Conosco | Ranking Rent a Car',
				'description' => 'Aproveite as oportunidades de trabalho na Ranking Rent a Car. Envie o seu currículo para nós!',
				'keywords'    => 'trabalhe conosco, trabalho, emprego, ranking rent a car, aluguel veiculos'
			)
		)
	)
);

// Contato > Terceirização de Frotas
Router::connect(
	array('/contato/terceirizacao-frotas.html'),
	array(
		'controller' => 'contato', 
		'action'     => 'terceirizacao',
		'vars'       => array(
			'seo' => array(
				'title'       => 'Terceirização de Frotas | Ranking Rent a Car',
				'description' => 'Conheça as vantagens de fazer terceirização de frota de veículos para sua empresa. Contate-nos.',
				'keywords'    => 'terceirização de frota, frota de veículos para empresas, aluguel de carro para empresas'
			)
		)
	)
);

// Contato > Caminhão pipa
Router::connect(
	array('/contato/caminhao-pipa.html'),
	array('controller' => 'contato', 'action' => 'caminhao')
);

/*
 ***********************************************************
 * Gerencia rotas para index de post types customizados    *
 ***********************************************************
 */
// Remove post types do Wordpress ou conhecidos e não necessários
$exclude = array("post", "page", "attachment", "revision", "nav_menu_item", "acf");
$types = array_keys( get_post_types() );
$validTypes = array_diff($types, $exclude);
foreach($validTypes as $type) {
	Router::connect(
		array(
			'/' . $type,
			'/' . $type . '/',
			'/' . $type . '/*',
			'/' . $type . '/index.html'
		),
		array('controller' => 'pages', 'action' => 'wppages')
	);
}

/*
 ***********************************************************
 * Gerencia rotas para todas as páginas Wordpress          *
 ***********************************************************
 */
$pages = new WP_Query("post_type=page");
if ( count($pages) > 0 && isset($pages->posts) && count($pages->posts) > 0 ) {
	foreach($pages->posts as $post) {
		$name = $post->post_name;

		// Adiciona .html no final dos links quando existir o plugin "Html on Pages" ativo
		if ( is_plugin_active('html-on-pages/html-on-pages.php') ) {
			$name = $name . '.html';
		}

		Router::connect(
			array('/' . $name),
			array('controller' => 'pages', 'action' => 'wppages')
		);
	}
}
?>