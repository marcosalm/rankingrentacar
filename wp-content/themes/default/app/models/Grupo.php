<?php

/**
 * Classe model para Grupos
 */
class Grupo extends Post {

	/**
	 * Representa um array de veículos associados ao grupo
	 * @var array
	 */
	private $veiculos = array();

	/**
	 * Representa um array de características do grupo
	 * @var array
	 */
	private $caracteristicas = array();

	/**
	 * Represeta um array de tarifas do grupo
	 * @var array
	 */
	private $tarifas = array();

	/**
	 * Represeta um array de proteções do grupo
	 * @var array
	 */
	private $protecoes = array();

	/**
	 * Retorna os veículos associados ao grupo
	 *
	 * @return array Um array de veículos
	 */
	public function getVeiculos() {
		return $this->veiculos;
	}

	/**
	 * Retorna as características do grupo
	 *
	 * @return array Um array de características
	 */
	public function getCaracteristicas() {
		return $this->caracteristicas;
	}

	/**
	 * Retorna as tarifas do grupo
	 *
	 * @return array Um array de tarifas
	 */
	public function getTarifas() {
		return $this->tarifas;
	}

	/**
	 * Retorna as proteções do grupo
	 *
	 * @return array Um array de proteções
	 */
	public function getProtecoes() {
		return $this->protecoes;
	}

	/**
	 * Retorna o valor de uma tarifa pelo seu slug
	 *
	 * @param string $name O slug da tarifa
	 * @param boolean $format Define se o valor da tarifa deve ser formatado (pontuação)
	 * @return string|float O valor da tarifa ou 0 caso a mesma não exista
	 */
	public function getTarifaValue($name, $format = true) {
		$tarifas = $this->getTarifas();
		if ( isset($tarifas[ $name ]) ) {
			$tarifa = $tarifas[ $name ];
			if ($format) { return number_format($tarifa, 2, ',', ''); }
			return $tarifa;
		}

		return 0;
	}

	/**
	 * Retorna o label de uma tarifa pelo seu slug
	 *
	 * @param string $name O slug da tarifa
	 * @return string O label da tarifa
	 */
	public function getTarifaLabel($name) {
		global $wpdb;

		$result = $wpdb->get_results("
			SELECT meta_value 
			FROM wp_postmeta 
			WHERE meta_key = (SELECT meta_value FROM wp_postmeta WHERE meta_key = '_{$name}' AND post_id = " . $this->getId() . ")
		");

		$object = current($result);
		$serial = $object->meta_value;
		$data   = maybe_unserialize($serial);

		return $data['label'];
	}

	/**
	 * Retorna o valor de uma determinada proteção
	 *
	 * @param string $name O nome da tarifa
	 * @param boolean $format Define se o valor da proteção deve ser formatado (pontuação)
	 * @return string|float O valor da proteção ou 0 caso a mesma não exista
	 */
	public function getProtecaoValue($name, $format = true) {
		$protecoes = $this->getProtecoes();
		if ( isset($protecoes[ $name ]) ) {
			$protecao = $protecoes[ $name ];
			if ($format) { return number_format($protecao, 2, ',', ''); }
			return $protecao;
		}

		return 0;
	}

	/**
	 * Busca grupos
	 *
	 * @param array $params Parmetros utilizados no Wordpress (WP_Query)
	 * @see WP_Query
	 * @return array Um array de grupos
	 */
	public static function find( $params = array() ) {
		$defaultParams = array(
			'post_type'   => 'grupo',
			'post_status' => 'publish',
			'posts_per_page' => -1
		);

		$finalParams = array_merge($defaultParams, $params);
		return parent::find($finalParams, 'Grupo');
	}

	/**
	 * Busca um grupo pelo seu post ID
	 *
	 * @param int $id O Código Post ID do grupo
	 * @return Um objeto Grupo ou false caso o mesmo não exista
	 */
	public static function findById($id) {
		$post = get_post($id);

		if ($post) {
			return new Grupo($post);
		}

		return false;
	}

	/**
	 * Sobreescreve o método load para popular valores de campos personalizados
	 *
	 * @param WP_Post $post Um objeto WP_Post contendo os dados do post atual 
	 * @see WP_Post
	 */
	public function load($post) {
		parent::load($post);
		global $wpdb;

		// Veículos
		$veiculos = $this->getCustomField('veiculos');
		foreach($veiculos as $veiculo) {
			$this->veiculos[] = new Post($veiculo);
		}

		// Características
		$caracteristicas = array();
		$fieldName       = 'caracteristicas';
		$theField        = $this->getCustomField($fieldName);
		if ( is_array($theField) && count($theField) > 0 ) {
			$result  = $wpdb->get_results("
				SELECT meta_value 
				FROM wp_postmeta 
				WHERE meta_key = (SELECT meta_value FROM wp_postmeta WHERE meta_key = '_{$fieldName}' AND post_id = {$post->ID})
			");

			$object  = current($result);
			$serial  = maybe_unserialize( (string) $object->meta_value );
			$choices = $serial['choices'];
		
			foreach($theField as $field) {
				$this->caracteristicas[ $field ] = $choices[ $field ];
			}
		}

		// Tarifas 
		$valorTarifaDiaria         = $this->getCustomField('valortarifadiaria');
		$valorTarifaDiariaKmRodado = $this->getCustomField('valortarifakmrodado');

		$this->tarifas['valortarifadiariatext']     = number_format($valorTarifaDiaria, 2, ',', '.') . ' (+ ' . number_format($valorTarifaDiariaKmRodado, 2, ',', '.');
		$this->tarifas['valortarifadiaria']         = $valorTarifaDiaria + $valorTarifaDiariaKmRodado;
		$this->tarifas['valortarifadiaria150livre'] = $this->getCustomField('valortarifadiaria150livre');
		$this->tarifas['valortarifadiariakmlivre']  = $this->getCustomField('valortarifadiariakmlivre');

		// Proteções
		$this->protecoes['valorprotecao1020valorveiculo'] = $this->getCustomField('valorprotecao1020valorveiculo');
		$this->protecoes['valorprotecao510valorveiculo']  = $this->getCustomField('valorprotecao510valorveiculo');
	}
}
?>