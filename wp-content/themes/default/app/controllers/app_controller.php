<?php

/**
 * Classe App Controller
 */
class App_Controller extends Controller {

	/**
	 * Construtor
	 */
	public function __construct() {
		parent::__construct();
		
		// Define o layout
		$this->layout = 'default';

		// Obtém dados de configuração de reserva
		$dados = Config::get('reserva');
		$this->set('locais', $dados['locais']);

		// Informações SEO
		$seo = Context::getParam('seo');
		if ($seo) { $this->set('seo', (object) $seo); }

		// Inicializa sessão
		if ( !isset($_SESSION) ) {
			session_start();
		}
	}
}
?>