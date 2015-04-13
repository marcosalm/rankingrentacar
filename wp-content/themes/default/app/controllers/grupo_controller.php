<?php

/**
 * Classe Controller para grupo
 */
class grupo_controller extends App_Controller {
	public $uses = array('Grupo');

	/**
	 * Listagem de grupos
	 */
	public function listar() {
		$this->set( 'grupos', $this->Grupo->find() );
	}

	/**
	 * Dados de um determinado grupo
	 */
	public function view() {

		// Pega o slug passado
		$slug = current( Context::getParams() );

		// Pega os dados do grupo selecionado
		if ( isset($slug) && is_string($slug) ) { 
			$grupo = current( $this->Grupo->find( array('name' => $slug) ) );

			if ( isset($grupo) ) { 
				$this->set('grupo', $grupo);
			}

			// SEO específico
			$this->set('seo', (object) array(
				'title'       => 'Ranking Rent a Car | Locadora de veículos',
				'description' => 'Conheça a Ranking Rent a Car, locadora de veículos com unidades nas cidades de Vitória e Cariacica. Confira nossas vantagens!',
				'keywords'    => 'locadora de veículos, es, vitória, cariacica, ranking rent a car, ranking locadora'
			));
		}

		// Em caso de erros (slug inválido ou não informado) redireciona para página 404
		if ( !isset($grupo) ) {
			App::redirect(array(
				'controller' => 'pages', 
				'action'     => '404', 
				'internal'   => true
			));
		}
	}
}
?>