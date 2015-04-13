<?php

/**
 * Classe Controller para FAQ
 */
class Faq_Controller extends App_Controller {

	/**
	 * Index de FAQ
	 */
	public function index() {

		// Define a página atual
		$page = isset($_GET['p']) ? (int) $_GET['p'] : 1;

		// Busca por posts do tipo FAQ com paginação
		$faqs = new Paginator('Post', array(
			'post_type'   => 'faq',
			'post_status' => 'publish',
			'paged'       => $page
		));

		// Configura URL de páginas
		$faqs->setUrl('?p={index}');

		$this->set('faqs', $faqs->getResults() );
		$this->set('paginator', $faqs->getHtml() );
		$this->set('pagobj', $faqs);
	}
}
?>