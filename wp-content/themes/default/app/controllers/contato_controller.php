<?php

/**
 * Classe Controller para contato
 */
class Contato_controller extends App_Controller {

	/**
	 * Representa os e-mails de contato
	 * @var array
	 */
	private $emails;

	/**
	 * Construtor
	 */
	public function __construct() {
		parent::__construct();

		// Utilizado para e-mail padrão (Quando não existir um associado)
		$emailDefault = get_option('admin_email');

		// Popula os e-mails de contato
		$emails = get_option('config_servicos_adicionais');
		$this->emails['contato']       = isset($emails['fale_conosco'])         ? $emails['fale_conosco']         : $emailDefault;
		$this->emails['trabalhe']      = isset($emails['trabalhe_conosco'])     ? $emails['trabalhe_conosco']     : $emailDefault;
		$this->emails['terceirizacao'] = isset($emails['terceirizacao_frotas']) ? $emails['terceirizacao_frotas'] : $emailDefault;
		$this->emails['caminhao']      = isset($emails['caminhao_pipa'])        ? $emails['caminhao_pipa']        : $emailDefault;
	}

	/**
	 * Contato > Fale conosco
	 */
	public function index() {
		$this->set('enderecos', Post::find(array(
			'post_type'   => 'local',
			'post_status' => 'publish'
		)));

		if (count($_POST) > 0) {
			$data = array(
				'subject'     => 'Fale conosco',
				'title'       => esc_attr($_POST['nome']),
				'name'        => esc_attr($_POST['nome']),
				'email'       => esc_attr($_POST['email']),
				'telefone'    => esc_attr($_POST['telefone']),
				'observacoes' => esc_attr($_POST['obs'])
			);

			if ( rk_contact_new($data, true, $this->emails['contato']) ) {
				$this->set('class', 'alert-success');
				$this->set('message', 'Obrigado por seu retorno. Em breve iremos entrar em contato');
			} else {
				$this->set('class', 'alert-error');
				$this->set('message', 'Erro ao tentar realizar a operação. Tente novamente');
			}
		} 
	}

	/**
	 * Contato > Trabalhe conosco
	 */
	public function trabalhe() {

		if (count($_POST) > 0) { 
			$data = array(
				'subject'  => 'Trabalhe conosco',
				'title'    => esc_attr($_POST['nome']),
				'name'     => esc_attr($_POST['nome']),
				'email'    => esc_attr($_POST['email']),
				'telefone' => esc_attr($_POST['telefone'])
			);

			if ( rk_contact_new($data, true, $this->emails['trabalhe']) ) {
				$this->set('class', 'alert-success');
				$this->set('message', 'Currículo cadastrado com sucesso! Aguarde contato de nossa equipe');
			} else {
				$this->set('class', 'alert-error');
				$this->set('message', 'Erro ao tentar realizar a operação. Tente novamente');
			}
		}
	}

	/**
	 * Contato > Terceirização de frotas
	 */
	public function terceirizacao() {
		if (count($_POST) > 0) {
			$data = array(
				'subject'     => 'Terceirização de Frotas',
				'title'       => esc_attr($_POST['nome']),
				'name'        => esc_attr($_POST['nome']),
				'email'       => esc_attr($_POST['email']),
				'telefone'    => esc_attr($_POST['telefone']),
				'empresa'     => esc_attr($_POST['empresa']),
				'frota'       => esc_attr($_POST['frota']),
				'observacoes' => esc_attr($_POST['obs'])
			);

			if ( rk_contact_new($data, true, $this->emails['terceirizacao']) ) {
				$this->set('class', 'alert-success');
				$this->set('message', 'Dados enviados com sucesso, em breve entraremos em contato. Obrigado');
			}
		} else {
			$this->set('class', 'alert-error');
			$this->set('message', 'Erro ao tentar realizar a operação. Tente novamente');
		}
	}

	/**
	 * Contato > Caminhão pipa
	 */
	public function caminhao() {
		if (count($_POST) > 0) {
			$data = array(
				'subject'     => 'Caminhão Pipa',
				'title'       => esc_attr($_POST['nome']),
				'name'        => esc_attr($_POST['nome']),
				'email'       => esc_attr($_POST['email']),
				'telefone'    => esc_attr($_POST['telefone']),
				'empresa'     => esc_attr($_POST['empresa']),
				'observacoes' => esc_attr($_POST['obs'])
			);

			if ( rk_contact_new($data, true, $this->emails['caminhao']) ) {
				$this->set('class', 'alert-success');
				$this->set('message', 'Obrigado por seu retorno. Em breve iremos entrar em contato');
			}
		} else {
			$this->set('class', 'alert-error');
			$this->set('message', 'Erro ao tentar realizar a operação. Tente novamente');
		}
	}
}
?>