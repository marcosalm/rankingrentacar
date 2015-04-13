<?php

/**
 * Classe model para reserva de veículos
 */
class Reserva extends Post {

	/**
	 * Busca reservas
	 *
	 * @param array $params Parmetros utilizados no Wordpress (WP_Query)
	 * @see WP_Query
	 * @return array Um array de reservas
	 */
	public static function find( $params = array() ) {
		$defaultParams = array(
			'post_type' => 'reserva'
		);

		$finalParams = array_merge($defaultParams, $params);
		return parent::find($finalParams, 'Reserva');
	}

	/**
	 * Insere ou atualiza os dados de orçamento para reserva
	 *
	 * @param array $data Os dados a serem inseridos ou modificados
	 * @param string $status O status da reserva (Post status)
	 * @return mixed Retorna o código da reserva ou 0 em caso de erros
	 */
	public function update($data = array(), $status = 'draft') {
		if (count($data) > 0) {

			// Atualiza ou salva
			$post_id = isset($_SESSION['reserva']) ? $_SESSION['reserva'] : 0;

			// Gera código único quando não existir post
			if ( !$post_id ) {
				$uniqid = uniqid();
			}

			// Salva no Wordpress
			$post_id = wp_insert_post(array(
				'ID'          => $post_id,
				'post_type'   => 'reserva',
				'post_status' => $status,
				'post_title'  => 'Reserva'
			));

			if ($post_id) {

				if ( isset($uniqid) ) {
					update_post_meta($post_id, 'codigo', $uniqid);
				}

				// Salva dados post_meta (Wordpress)
				foreach($data as $key => $value) {
					update_post_meta($post_id, $key, $value);
				}

				// Salva o código da reserva na sessão
				$_SESSION['reserva'] = $post_id;
			}

			return $post_id;
		}

		return false;
	}
}
?>