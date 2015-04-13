<?php

/**
 * Classe Controller para p�ginas
 */
class Pages_Controller extends App_Controller {

	/**
     * P�gina Home 
     */
	public function home() {
	}

	/**
     * P�ginas Wordpress 
     */
	public function wppages() {
		$page = Post::find();

		// A p�gina Wordpress existe?
		if ($page) {
			$this->set('entity', $page);

			// Verifica se existe uma sidebar espec�fica para a p�gina
			$sidebars = Config::get('sidebars');
			$id       = $page->getId();
			$sidebar  = ( isset($sidebars) && isset( $sidebars[ $id ] ) ) ? $sidebars[ $id ] : false;
			$this->set('sidebar', $sidebar);

			Context::$view = 'wppages';
		} else { 
			App::redirect(array(
				'controller' => 'pages', 
				'action'     => '404', 
				'internal'   => true
			));
		}
	}
	
}