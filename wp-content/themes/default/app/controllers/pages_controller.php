<?php

/**
 * Classe Controller para páginas
 */
class Pages_Controller extends App_Controller {

	/**
     * Página Home 
     */
	public function home() {
	}

	/**
     * Páginas Wordpress 
     */
	public function wppages() {
		$page = Post::find();

		// A página Wordpress existe?
		if ($page) {
			$this->set('entity', $page);

			// Verifica se existe uma sidebar específica para a página
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