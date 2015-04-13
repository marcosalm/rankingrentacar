<?php

/**
 * Classe Controller para reserva de veículos
 */
class Reserva_controller extends App_Controller {
	public $uses = array('Grupo');

	/**
	 * Define se existe orçamento de reserva
	 * @var bool
	 */
	public $hasReserva = false;

	/**
	 * Construtor
	 */
	public function __construct() {
		parent::__construct();

		// Atualiza o orçamento de reserva sempre que for possível
		if ( count($_POST) ) {
			$this->Reserva->update($_POST);
		}

		// Atualiza verificador de reserva
		$this->hasReserva = isset($_SESSION['reserva']);

		// Carrega o orçamento (Se existir)
		if ($this->hasReserva) {
			$post_id = $_SESSION['reserva'];
			$reserva = $this->Reserva->findById($post_id);
			
			if ($reserva) {
				$veiculo = false;
				$grupo   = false;

				// Carrega post metas
				$meta = get_post_custom($post_id);

				// Carrega dados do grupo selecionado (Caso exista)
				if ( isset($meta['grupo'][0]) ) {
					$grupo = $this->Grupo->findById($meta['grupo'][0]);
				}

				// Carrega dados do veículo selecionado (Caso exista)
				if ( isset($meta['veiculo'][0]) ) {
					$veiculo = Post::findById($meta['veiculo'][0]);
				}

				// Dados de orçamento completo
				$this->set('orcamento', array(
					'reserva' => $reserva, // Dados da reserva (Reserva Object)
					'meta'    => $meta,    // Dados do orçamento (Post metas)
					'grupo'   => $grupo,   // Dados do grupo selecionado (Grupo Object)
					'veiculo' => $veiculo  // Dados do veículo selecionado (Veiculo Object)
				));
			}
		}
	}

	/**
	 * Redireciona a página index de reserva para o Passo 1
	 */
	public function index() { 
		App::redirect(array(
			'controller' => 'reserva', 
			'action'     => 'passo-1.html'
		));
	}

	/**
	 * Reserva de veículos > Passo 2
	 */
	public function second() {
		global $wpdb;

		// Caso não exista orçamento de reserva, o passo 1 deve ser executado
		if (!$this->hasReserva) {
			App::redirect(array(
				'controller' => 'reserva', 
				'action'     => 'passo-1.html'
			));
		}

		// Carrega grupos
		$grupos = Post::find(array(
			'post_type'      => 'grupo',
			'posts_per_page' => -1
		));

		/**
		 *  Integra as características no grupo (campo personalizado)
		 * - Dependência: Advanced Custom Fields
		 * - Campo personalizado: caracteristicas
		 */
		foreach($grupos as $grupo) {
			$grupo->caracteristicas = array();
			$fieldName              = 'caracteristicas';
			$theField               = $grupo->getCustomField($fieldName);

			if ( is_array($theField) && count($theField) > 0 ) {
				$result  = $wpdb->get_results("
					SELECT meta_value 
					FROM wp_postmeta 
					WHERE meta_key = (SELECT meta_value FROM wp_postmeta WHERE meta_key = '_{$fieldName}' AND post_id = " . $grupo->getId() . ")
				");

				$object  = current($result);
				$serial  = maybe_unserialize( (string) $object->meta_value );
				$choices = $serial['choices'];
			
				foreach($theField as $field) {
					$grupo->caracteristicas[] = $choices[ $field ];
				}
			}
		}
		$this->set('grupos', $grupos);
	}

	/**
	 * Reserva de veículos > Passo 3
	 */
	public function third() {
		if ( !$this->hasReserva ) {
			App::redirect(array(
				'controller' => 'reserva', 
				'action'     => 'passo-1.html'
			));
		}
	}

	/**
	 * Reserva de veículos > Passo 4
	 */
	public function fourth() {
		if ( !$this->hasReserva ) {
			App::redirect(array(
				'controller' => 'reserva', 
				'action'     => 'passo-1.html'
			));
		}
		$post_id = $_SESSION['reserva'];
		$meta = get_post_custom($post_id);
		//print_r($meta);
		//die;
		// Finaliza o orçamento de reserva
		if ( isset($_POST['finish']) ) {
		
			/*if (!validaCPF($_POST['cpfcnpj'])) {
				
			}
			if (!validaEmail($_POST['email'])){
				 echo "<div class='alert alert-error'> Preencha com seu email corretamente!</div>";
			}*/
			 
				$this->Reserva->update($_POST, 'publish');
				$this->set('finish', true);

				// Utilizado para e-mail padrão (Quando não existir um associado)
				$emailDefault = get_option('admin_email');

				// Pega o e-mail responsável para finalização de reservas
				$emails       = get_option('config_servicos_adicionais');
				$emailReserva = isset($emails['reserva']) ? $emails['reserva'] : $emailDefault;

				// Envia e-mail
				
				$data = array(
					'subject'    		=> 'Finalização de Reserva',
					'title'				=> esc_attr($_POST['cliente']),
					'name'      		=> esc_attr($_POST['cliente']),
					'email'       		=> esc_attr($_POST['email']),
					'cpf'       		=> esc_attr($_POST['cpfcnpj']),
					'telefone'    		=> esc_attr($_POST['telefone']),
					'retirada_local'    => esc_attr($meta['retirada_local'][0]),
					'devolucao_local'   => esc_attr($meta['devolucao_local'][0]),
					'retirada_data'    	=> esc_attr($meta['retirada_data'][0]),
					'devolucao_data'    => esc_attr($meta['devolucao_data'][0]),
					'retirada_hora'    	=> esc_attr($meta['retirada_hora'][0]),
					'devolucao_hora'    => esc_attr($meta['devolucao_hora'][0]),
					'tarifa'			=> esc_attr($meta['tarifa'][0]),
					'protecoes'   		=> esc_attr($meta['protecoes'][0]),
					'servicos'    		=> esc_attr($meta['servicos'][0]),
					'grupo'    			=> esc_attr(get_the_title($meta['grupo'][0])),
					'veiculo'    		=> esc_attr(get_the_title($meta['veiculo'][0])),
					'observacoes' 		=> esc_attr($_POST['observacoes'])
				);
				rk_contact_new($data, true, $emailReserva);
			/*
					
			*/
		}
	}

	/**
	 * Reserva de veículos > Cancelar
	 */
	public function cancelar() {
		if ($this->hasReserva) {
			wp_delete_post($_SESSION['reserva'], true);
			unset($_SESSION['reserva']);
		}

		App::redirect( get_bloginfo('wpurl') );
	}

	/**
	 * Reserva de veículos > Finalizar
	 */
	public function finalizar() {
		if ($this->hasReserva) {
			unset($_SESSION['reserva']);
		}

		App::redirect( get_bloginfo('wpurl') );
	}

	/**
	 * Retorna todos os veículos associados a este grupo em JSON
	 * @param $_REQUEST['id'] O Código do grupo
	 * @return string Uma string em JSON contendo informações básicas
	 */
	public function loadVeiculos() {
		$this->layout = 'ajax';

		if ( isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ) {
			$id     = $_REQUEST['id'];
			$grupo  = Post::findById($id);
			$output = array();

			if ( isset($grupo) ) {
				$veiculos = $grupo->getCustomField('veiculos');
				if ( is_array($veiculos) && count($veiculos) > 0 ) {
					foreach($veiculos as $veiculo) {
						$v = new Post($veiculo);

						$image = $v->getThumbnail('grupo-thumb');
						if ( is_object($image) ) {
							$image = $image->getSrc();
						}

						array_push($output, array(
							'ID'    => $v->getId(),
							'image' => $image,
							'text'  => $v->getTitle() . ' ' . $v->getCustomField('marca') . '/' . $v->getCustomField('modelo')
						));
					}

					echo json_encode($output);
				}
			}
		}

		return false;
	}
}