<?php
/*
  Plugin Name: 4Ps - Locais
  Plugin URI: http://www.4ps.com.br
  Description: Este simples módulo permite gerenciar cadastro de locais. É possível inserir e controlar informações como endereço, latitude e longitude, múltiplos números de telefone.
  Author: 4Ps
  Version: 1.1
 */

/*
 *****************************************************************************
 * 4PS - Plugin para cadastro de locais
 *****************************************************************************
 * @date 12/09/2013 - 10:29
 *****************************************************************************
 */

/**
 * Definição de constantes
 */
define("LOCAL_DIR_PLUGIN", plugin_dir_url(__FILE__) );
define("LOCAL_DIR_IMG",    LOCAL_DIR_PLUGIN . 'img/');
define("LOCAL_DIR_JS",     LOCAL_DIR_PLUGIN . 'js/');
define("LOCAL_DIR_CSS",    LOCAL_DIR_PLUGIN . 'css/');
define("LOCAL_ICON_MENU",  LOCAL_DIR_IMG . 'icon_16x16.png');
define("LOCAL_ICON_POST",  LOCAL_DIR_IMG . 'icon_32x32.png');

/**
 * Carrega dependências (Javascript, CSS etc)
 */
function quatrops_local_enqueue_resources() {

	// Validate Fields
	wp_enqueue_script( 'jquery-validate', LOCAL_DIR_JS . 'jquery.validate.min.js', array('jquery') );

	// Masked Input
	wp_enqueue_script( 'jquery-maskedinput', LOCAL_DIR_JS . 'jquery.maskedinput.min.js', array('jquery') );

	// jQuery UI v1.10.3
	wp_enqueue_script( 'jquery-ui', 'http://code.jquery.com/ui/1.10.3/jquery-ui.min.js', array('jquery') );
	wp_enqueue_style('jquery-ui-css', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.min.css');

	// Google Maps v3
	wp_enqueue_script('gmaps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&amp;language=pt-BR&amp;sensor=false');

	// Metabox de Locais
	wp_enqueue_style('metabox-locais-css', LOCAL_DIR_CSS . 'metabox.locais.css');
	wp_enqueue_script('metabox-locais-js', LOCAL_DIR_JS . 'metabox.locais.js');
}

/**
 * Registra post type para gerenciamento de locais
 */
function quatrops_local_manage() {
	register_post_type('local', array(
		'labels' => array(
			'name'               => __('Locais'),
			'singular_name'      => __('Local'),
			'add_new'            => __('Novo local'),
			'add_new_item'       => __('Adicionar novo local'),
			'edit_item'          => __('Editar local'),
			'new_item'           => __('Novo local'),
			'view_item'          => __('Ver local'),
			'search_items'       => __('Buscar locais'),
			'not_found'          => __('Nenhum local encontrado'),
			'not_found_in_trash' => __('Nada encontrado na Lixeira'),
			'parent_item_colon'  => ''
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => LOCAL_ICON_MENU,
		'supports'           => array('title')
	));
}

/**
 * Registra Metabox para post type de locais
 */
function quatrops_local_register_metabox($post_type, $post) {
	add_meta_box(
		'meta-box-local',
		__('Dados de Locais'),
		'quatrops_local_manage_metabox',
		'local',
		'normal'
	);
}

/**
 * Gerencia o módulo de locais
 */
function quatrops_local_manage_metabox($post) {
	
	// Nonce
	wp_nonce_field('meta-box-local', 'meta-box-local-nonce');

	// Dados de locais
	$values      = get_post_meta($post->ID, 'local_values', true);
	$endereco    = isset($values['endereco'])             ? $values['endereco']             : '';
	$latitude    = isset($values['latitude'])             ? $values['latitude']             : '';
	$longitude   = isset($values['longitude'])            ? $values['longitude']            : '';
	$residencial = isset($values['telefone-residencial']) ? $values['telefone-residencial'] : '';
	$comercial   = isset($values['telefone-comercial'])   ? $values['telefone-comercial']   : '';
	$outro       = isset($values['telefone-outro'])       ? $values['telefone-outro']       : '';
	?>
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1"><?php _e("Localização"); ?></a></li>
			<li><a href="#tabs-2"><?php _e("Telefones"); ?></a></li>
		</ul>
		<div id="tabs-1">
			<div class="meta-box-local-wrap">
				<div class="meta-box-local-field">
					<p>
						<label for="meta-box-local-endereco"><?php _e("Endereco"); ?><span class="mandatory">*</span></label>
					</p>
					<p class="description">
						<?php _e("Digite o endereço completo do local"); ?>
					</p>
				</div>
				<div>
					<input class="need" type="text" id="meta-box-local-endereco" title="<?php echo esc_attr($endereco); ?>" name="endereco" value="<?php echo esc_attr($endereco); ?>" />
				</div>
				<div class="margin-top">
					<input name="addresslatlng" type="button" class="button button-primary" value="Obter Coordenadas" />
				</div>
			</div>
			<div class="meta-box-local-wrap">
				<div class="meta-box-local-field">
					<p>
						<label for="meta-box-local-latitude"><?php _e("Latitude"); ?></label>
					</p>
					<p class="description">
						<?php _e("Digite a latitude do local"); ?>
					</p>
				</div>
				<div>
					<input type="text" id="meta-box-local-latitude" name="latitude" value="<?php echo esc_attr($latitude); ?>" />
				</div>
			</div>
			<div class="meta-box-local-wrap">
				<div class="meta-box-local-field">
					<p>
						<label for="meta-box-local-longitude"><?php _e("Longitude"); ?></label>
					</p>
					<p class="description">
						<?php _e("Digite a longitude do local"); ?>
					</p>
				</div>
				<div>
					<input type="text" id="meta-box-local-longitude" name="longitude" value="<?php echo esc_attr($longitude); ?>" />
				</div>
				<div class="margin-top">
					<input name="latlngaddress" type="button" class="button button-primary" value="Obter Endereço" />
				</div>
				<div class="margin-top note">
					<p class="description">As informações obtidas de endereço e coordenadas podem não ser precisas</p>
					<p class="description">Todos os dados de retorno são de responsabilidade da API do <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/examples/?hl=pt-br">Google Maps</a></p>
				</div>
			</div>
		</div>
		<div id="tabs-2">
			<div class="meta-box-local-wrap">
				<div class="meta-box-local-field">
					<p>
						<label for="meta-box-local-telefone-residencial"><?php _e("Telefone Residencial"); ?></label>
					</p>
					<p class="description">
						<?php _e("Informe o número do telefone residencial"); ?>
					</p>
				</div>
				<div>
					<input class="phone" type="text" id="meta-box-local-telefone-residencial" title="<?php echo esc_attr($residencial); ?>" name="telefone-residencial" value="<?php echo esc_attr($residencial); ?>" />
				</div>
			</div>
			<div class="meta-box-local-wrap">
				<div class="meta-box-local-field">
					<p>
						<label for="meta-box-local-telefone-comercial"><?php _e("Telefone Comercial"); ?></label>
					</p>
					<p class="description">
						<?php _e("Informe o número do telefone comercial"); ?>
					</p>
				</div>
				<div>
					<input class="phone" type="text" id="meta-box-local-telefone-comercial" title="<?php echo esc_attr($comercial); ?>" name="telefone-comercial" value="<?php echo esc_attr($comercial); ?>" />
				</div>
			</div>
			<div class="meta-box-local-wrap">
				<div class="meta-box-local-field">
					<p>
						<label for="meta-box-local-telefone-outro"><?php _e("Telefone (Outro)"); ?></label>
					</p>
					<p class="description">
						<?php _e("Informe o número de algum outro telefone se for necessário"); ?>
					</p>
				</div>
				<div>
					<input class="phone" type="text" id="meta-box-local-telefone-outro" title="<?php echo esc_attr($outro); ?>" name="telefone-outro" value="<?php echo esc_attr($outro); ?>" />
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Salva os dados meta post para locais
 */
function quatrops_local_save_post($post_id) {
	if ( !isset($_POST['meta-box-local-nonce']) ) {
		return $post_id;
	}

	$nonce = $_POST['meta-box-local-nonce'];
	if ( !wp_verify_nonce($nonce, 'meta-box-local') ) {
		return $post_id;
	}

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return $post_id;
	}

	if ( !current_user_can('edit_post', $post_id) ) {
		return $post_id;
	}

	update_post_meta( $post_id, 'local_values', array_map('sanitize_text_field', $_POST) );
}

/**
 * Adiciona novas colunas na listagem de locais
 */
function quatrops_local_columns_head($defaults) {
	global $post;
	
	if ( is_object($post) && $post->post_type == "local" ) {
		$defaults['endereco']  = __("Endereco");
		$defaults['latitude']  = __("Latitude");
		$defaults['longitude'] = __("Longitude");
	}

	return $defaults;
}

/**
 * Adiciona conteúdo nas novas colunas de locais
 */
function quatrops_local_columns_content($column_name, $post_ID) {
	global $post;

	if ($post->post_type == "local") {
		$values = get_post_meta($post_ID, 'local_values', true);

		switch ($column_name) {
			case 'endereco' : {
				echo $values['endereco'];
				break;
			}
			case 'latitude' : {
				echo $values['latitude'];
				break;
			}
			case 'longitude': {
				echo $values['longitude'];
				break;
			}
		}
	}
}

/**
 * Remove exibição de permalink de contatos
 */
function quatrops_local_permalink_html($return) {
	global $post;
	if ( is_object($post) && $post->post_type == "local") { return ""; }

	return $return;
}

/**
 * Registra as novas colunas de locais como "sortable", permitindo ordena-las
 */
function quatrops_local_columns_sortable($defaults) {  
	$defaults['endereco']  = __("Endereço");
	$defaults['latitude']  = __("Latitude");
	$defaults['longitude'] = __("Longitude");

	return $defaults;  
}

/**
 * Gerencia a forma como as novas colunas serão ordenadas
 */
function quatrops_local_columns_sortable_order($query) { 
	global $post;

	if ( isset($post) && $post->post_type == "local") {
		$orderby = $query->get('orderby');  
		$query->set('orderby', 'meta_value');

		switch ($orderby) {
			case 'endereco' : {
				$query->set('meta_key', 'endereco');
				break;
			}
			case 'latitude' : {
				$query->set('meta_key', 'latitude');
				break;
			}
			case 'longitude' : {
				$query->set('meta_key', 'longitude');
				break;
			}
		}
	}
}

/**
 * Define um pequeno ícone na tela de edição/listagem de locais
 */
function quatrops_local_head_icon() {
?>
	<style type="text/css" media="screen">
	#icon-edit.icon32-posts-local { background: url(<?php echo LOCAL_ICON_POST; ?>) no-repeat; }
	</style>
<?php 
}

// Actions
add_action('admin_enqueue_scripts',              'quatrops_local_enqueue_resources');   
add_action('add_meta_boxes',                     'quatrops_local_register_metabox', 10, 2);
add_action('init',                               'quatrops_local_manage');
add_action('save_post',                          'quatrops_local_save_post');
add_action('manage_posts_custom_column',         'quatrops_local_columns_content', 10, 2);
add_action('pre_get_posts',                      'quatrops_local_columns_sortable_order');
add_action('admin_head',                         'quatrops_local_head_icon');

// Filters
add_filter('manage_posts_columns',               'quatrops_local_columns_head');
add_filter('manage_edit-local_sortable_columns', 'quatrops_local_columns_sortable'); 
add_filter('get_sample_permalink_html',          'quatrops_local_permalink_html', '', 4);
?>