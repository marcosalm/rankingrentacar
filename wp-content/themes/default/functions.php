<?php
/**
 * Ranking - Functions 
 */

// Inicializa o plugin 4PsCakeWP
include WP_PLUGIN_DIR . '/4pswp/cms/bootstrap.php';

// Remove redirect de URL canonical
remove_filter('template_redirect', 'redirect_canonical');

// Configurações de tema
function rk_theme_features() {

	// Adiciona suporte para menus
	add_theme_support('menus');

	// Adiciona suporte para thumbnails
	add_theme_support('post-thumbnails');

	// Cria tamanhos específicos de thumbnails 
	if ( function_exists('add_image_size') ) {

		// Utilizada para destaques da home
		add_image_size('featured-thumb', 1248, 477, true);

		// Utilizada para destaques de grupos
		add_image_size('grupo-thumb', 198, 96, true);
	}

	// Registra menus
	register_nav_menu('footer', 'Rodapé');
	register_nav_menu('header', 'Topo');

	// Define o domínio de texto (Caso precise de multi-idioma)
	load_theme_textdomain('default', get_template_directory() . '/lang');	
}
add_action('after_setup_theme', 'rk_theme_features');

// Remove caracteres especiais em upload de arquivos
function rk_sanitize_chars($filename) {
	return remove_accents($filename);
}
add_filter('sanitize_file_name', 'rk_sanitize_chars', 10);

// Adiciona um item de menu de rodapé para redes sociais
function rk_footer_menu_social($items, $args) {
	$social = get_option('config_social');

	if ( count($social) > 0 && !empty($social['facebook']) ) {
		return $items .= $args->theme == 'footer' ? '
		<li class="social-links">
			<a>Compartilhe</a>
			<ul>
				<li>
					<a target="_blank" class="facebook-icon" href="https://www.facebook.com/' . $social['facebook'] . '">
						<img src="' . APP_WEBROOT . '/img/facebook_icon.png" alt="Facebook" title="Facebook" />
					</a>
				</li>
				<li>
					<a target="_blank" class="twitter-icon" href="https://twitter.com/' . $social['twitter'] . '">
						<img src="' . APP_WEBROOT . '/img/icon-twitter.png" alt="Twitter" title="Twitter" />
					</a>
				</li>
				<li>
					<a target="_blank" class="instagram-icon" href="http://instagram.com/' . $social['instagram'] . '">
						<img src="' . APP_WEBROOT . '/img/icon-instagram.png" alt="Instagram" title="Instagram" />
					</a>
				</li>
			</ul>
		</li>
		' : '';
	}

	return $items;
}
add_filter('wp_nav_menu_items', 'rk_footer_menu_social', 10, 2);

/**
 * Função helper para limitar tamanho de texto
 *
 * @param string $text O texto inicial
 * @param int $limit O limite de caracteres a ser respeitado
 * @param string $delimiter O delimitador a ser utilizado
 * 
 * Obs: Caso o texto inicial possua código HTML, talvez seja necessário tratar com strip_tags() no frontend
 */
function rk_limit_text($text, $limit, $delimiter = '...') {
	$content = explode(' ', $text, $limit);
	if ( count($content) >= $limit ) {
		array_pop($content);
		$content = implode(" ", $content).$delimiter;
	} else {
		$content = implode(" ", $content);
	}	

	return $content;
}
/** 
* Função cria quebra de linha para os titulos na seção 2 de reserva de carro
*/ 
function quebra_limit_text($text) {
	$content = explode(' ', $text);
	
	if ( count($content) == 3 ) {
		$content_cima = array_slice($content, 0, 2);
		$content_baixo = array_slice($content, 2);
		$content = "<strong>".implode(" ", $content_cima)."</strong> <br/> ".implode(" ",$content_baixo);
	} 
	else  {
		$content_cima = array_slice($content, 0, 3);
		$content_baixo = array_slice($content, 3);
		$content = "<strong>".implode(" ", $content_cima)."</strong>  <br/> <span style='font-size:0.95em'>".implode(" ",$content_baixo)."</span>";
	}	

	return $content;
}


/** 
* Função que cria select com um intervalo de minutos
*/

function createRangeSelect($label, $name, $class, $data ='') {

$min =0;
 $options = array();
 for ($i = 1; $i <= 96; $i++) {
	$start = date("H:i",mktime(0,$min));
	if (!empty($data) && $data == $start){
    $options[] = "<option value='$start' selected='selected'>$start</option>";
	} 
	else {
	 $options[] = "<option value='$start'>$start</option>";
	}	
	$min=$min+15;
  }
  echo "<div style='clear:both;' >";
  echo "<label for='{$name}'>{$label}</label>";
  echo "<select id='{$name}' size='1' name='{$name}' class='{$class}' style='width: 139px;' >";
  echo implode("\n", $options);
  echo '</select></div>';
}

/**
 * Cadastra um novo contato no Wordpress
 *
 * Essa função genérica cadastra um novo registro de contato (post_type=contato) e envia e-mail para algum destinatário se necessário
 *
 * @param array $data Um array de informações (post metas). Exemplo de estrutura mais abaixo
 * @param bool $email Define se deve ser enviado e-mail
 * @param string $to O e-mail destinatário (Por padrão, todos os e-mails são enviados para a Ranking)
 * @return mixed Retorna o código do post do contato cadastrado ou false em caso de erros 
 *
 * Estrutura do parâmetro $data
 *
 * array(
 * 		title       => 'Título da mensagem/email',
 *		subject     => 'Assunto do email/mensagem',
 * 		name        => 'Nome completo',
 * 		email       => 'endereco@de.email',
 *		telefone    => 'Telefone do contato',
 *		observacoes => 'Observações'
 * )
 */
function rk_contact_new($data = array(), $email = false, $to = 'noreply@ranking.com.br') {
	
		// Cadastra o contato
	$post_id = wp_insert_post(array(
		'post_type'   => 'contato',
		'post_status' => 'publish',
		'post_title'  => $data['title']
	));
	if ($post_id) {

		// Upload de arquivo
		if ( !empty($_FILES[ 'curriculum' ][ 'name' ]) ) {
			$upload = wp_upload_bits(
				$_FILES[ 'curriculum' ][ 'name' ], 
				null,
				file_get_contents($_FILES[ 'curriculum' ][ 'tmp_name' ])
			);
			if (!isset($upload['error']) || $upload['error'] == 0) {
				$data['curriculum'] = $upload['url'];  
			}
		}

		update_post_meta($post_id, 'contato_values', $data);
		
	}
	
	if ($email) {

		// E-mail remetente (Configurável via Wordpress > WP-Admin > Configurações > Geral)
		$from = get_option('admin_email');

		// Quebra de linha 
		$lb = (strtoupper( substr(PHP_OS, 0, 3) ) === 'WIN') ? "\n" : "\r\n";

		// Cabeçalho
		$headers = "Mime-Version: 1.0{$lb}Content-type: text/html; charset=utf-8{$lb}From: {$from}{$lb}";

		// Monta o template de email
		$template = APP_VIEWS_PATH . DS . 'templates' . DS . 'emails' . DS . 'index.html';
		if ( file_exists($template) ) {
			$template = file_get_contents($template);
			$logo     = APP_WEBROOT . DS . 'img' . DS . 'topo.jpg';
			$template = str_replace(
				array(
					'%logo%', 
					'%subject%',
					'%nome%',
					'%email%',
					'%telefone%',
					'%cpf%'
				),
				array(
					$logo, 
					$data['subject'],
					isset($data['name']    ) ? $data['name']     : '',
					isset($data['email']   ) ? $data['email']    : '',
					isset($data['telefone']) ? $data['telefone'] : '',
					isset($data['cpf']) ? $data['cpf'] : ''
				),
				$template
			);
			
			if ( isset($data['retirada_local']) ) {
			$meta = get_post_custom($post_id);
			$str_serv ='';
			$str_prot ='';
			$servicos = maybe_unserialize( isset($meta['servicos'][0])? $meta['servicos'][0]: '' );
			if ( !is_array($servicos) ) { $servicos = array($servicos); }
			foreach($servicos as $servico) { $str_serv .= $servico.', '; }
			
			$protecoes = maybe_unserialize( isset($meta['protecoes'][0])?$meta['protecoes'][0]:'' );
			if ( !is_array($protecoes) ) { $protecoes = array($protecoes); }
			foreach($protecoes as $proteco) { $str_prot .= $proteco.', '; }
				$template = str_replace(
					'%content%',
					'<p style="margin:10px;"><font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"><b>Reserva:</b></font> <br> <font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"><b>Grupo:</b></font><font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">' . $data['grupo'] . '</font><br><font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"><b>Veículo:</b></font><font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">' . $data['veiculo'] . '</font><br> <font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"><b>Retirada:</b></font> <br> Dia:'.$data['retirada_data'].' - Hora:'.$data['retirada_hora'].' - Local:' . $data['retirada_local'] . '<br> <font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"><b>Devolução:</b></font> <br> Dia:'.$data['devolucao_data'].' - Hora:'.$data['devolucao_hora'].' - Local:' . $data['devolucao_local'] . '<br><font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"><b>Tarifa:</b></font><font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">' . $data['tarifa'] . '</font><br><font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"><b>Proteçoes:</b></font><font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">' . $str_prot . '</font><br><font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"><b>Serviços:</b></font><font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">' . $str_serv . '</font><br></p>%content%', 
					$template
				);
			}	
			$value     = get_post_meta($post_id, 'contato_values', true);
			$curriculum  = isset($value['curriculum'])?$value['curriculum']:'' ;
			if (isset($curriculum) ) {
				$template = str_replace(
					'%content%',
					'<p style="margin:10px;"><font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"><b>Link Curriculo:</b></font> <font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">' . $curriculum . '</font></p>%content%', 
					$template
				);
			}	
			
			if ( isset($data['observacoes']) ) {
				$template = str_replace(
					'%content%',
					'<p style="margin:10px;"><font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"><b>Observações:</b></font> <font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">' . $data['observacoes'] . '</font></p>%content%', 
					$template
				);
			}				

			if ( isset($data['empresa']) ) {
				$template = str_replace(
					'%content%',
					'<p style="margin:10px;"><font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"><b>Empresa:</b></font> <font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">' . $data['empresa'] . '</font></p>%content%', 
					$template
				);
			}			

			if ( isset($data['frota']) ) {
				$template = str_replace(
					'%content%',
					'<p style="margin:10px;"><font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"><b>Frota:</b></font> <font style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">' . $data['frota'] . '</font></p>%content%', 
					$template
				);
			}

			$template = str_replace('%content%', '', $template);
			@mail($to, $data['subject'], $template, $headers);
		}
	}
return $post_id;


}

/*
 ***********************************************************
 * Gerencia configurações específicas do projeto           *
 ***********************************************************
 */
function rk_menu_options_manage() {

	// Controle de acesso
	if ( !current_user_can('publish_posts') ) {  
		wp_die('Permissão negada');  
	}

	// Salva configurações
	if ( count($_POST) > 0 ) {
		foreach($_POST as $key => $value) {
			if ( in_array($key, array('cadeira_bebe', 'motorista_bilingue', 'gps') ) ) {
				$_POST[ $key ] = str_replace(',', '.', $value); 
			}
		}

		$options = get_option('config_servicos_adicionais');
		if ( isset($options['contrato']) ) {
			$_POST['contrato'] = $options['contrato'];
		}

		update_option('config_servicos_adicionais', $_POST);
		?><div id="message" class="updated">Configuração salva</div><?php
	}

	// Upload de contrato
	if ( !empty($_FILES[ 'contrato' ][ 'name' ]) ) {
		$types    = array("application/pdf");
		$arr_type = wp_check_filetype( basename($_FILES[ 'contrato' ][ 'name' ]) );
		$type     = $arr_type['type'];
		if ( !in_array($type, $types) ) {
			wp_die('Erro: A extensão do arquivo é inválida');
		}

		$upload = wp_upload_bits(
			$_FILES[ 'contrato' ][ 'name' ],
			null,
			file_get_contents($_FILES[ 'contrato' ][ 'tmp_name' ])
		);

		if ( isset($upload['error']) && $upload['error'] != 0 ) {
			wp_die('Erro ao tentar fazer upload do arquivo. Motivo: ' . $upload['error']);
		} else {
			$options = get_option('config_servicos_adicionais');
			$options['contrato'] = $upload['url'];
			update_option('config_servicos_adicionais', $options);
		}
	}

	// Valores	
	$valores = get_option('config_servicos_adicionais');
	if ($valores) {
		foreach($valores as $key => $valor) {
			if ( is_numeric($valor) ) { $valores[ $key ] = str_replace('.', ',', $valor); }
		}

		extract($valores);
	}
	?>
	<div class="wrap">
		<?php screen_icon('options-general'); ?> <h2><?php echo get_bloginfo(); ?> - Configurações</h2>
		<form name="valores_servicos" method="post" action="" enctype="multipart/form-data">
			<h3>Página Home</h3>
			<p>Defina os textos descritivos de cada seção na página Home</p>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="home[caminhao_pipa]">Caminhão Pipa</label></th>
					<td><input type="text" name="home[caminhao_pipa]" size="130" value="<?php echo isset($home['caminhao_pipa']) ? esc_attr($home['caminhao_pipa']) : ''; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="home[seminovos]">Seminovos</label></th>
					<td><input type="text" name="home[seminovos]" size="130" value="<?php echo isset($home['seminovos']) ? esc_attr($home['seminovos']) : ''; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="home[terceirizacao_frotas]">Terceirização de Frotas</label></th>
					<td><input type="text" name="home[terceirizacao_frotas]" size="130" value="<?php echo isset($home['terceirizacao_frotas']) ? esc_attr($home['terceirizacao_frotas']) : ''; ?>" /></td>
				</tr>
			</table>
			<hr />
			<h3>Valores de Serviços Adicionais</h3>
			<p>Campos em branco serão exibidos como "Sob consulta"</p> 
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="cadeira_bebe">Cadeira de Bebê</label></th>
					<td><input type="text" name="cadeira_bebe" size="10" value="<?php echo isset($cadeira_bebe) ? $cadeira_bebe : ''; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="motorista_bilingue">Motorista Bilígue</label></th>
					<td><input type="text" name="motorista_bilingue" size="10" value="<?php echo isset($motorista_bilingue) ? $motorista_bilingue : ''; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="gps">GPS</label></th>
					<td><input type="text" name="gps" size="10" value="<?php echo isset($gps) ? $gps : ''; ?>" /></td>
				</tr>
			</table>
			<hr />
			<h3>E-Mails para contato</h3>
			<p>Defina os endereços de e-mail de cada seção (Obs: Múltiplos e-mails podem ser inseridos separando-os por vírgula)</p>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="fale_conosco">Fale conosco</label></th>
					<td><input type="text" name="fale_conosco" size="40" value="<?php echo isset($fale_conosco) ? $fale_conosco : ''; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="trabalhe_conosco">Trabalhe conosco</label></th>
					<td><input type="text" name="trabalhe_conosco" size="40" value="<?php echo isset($trabalhe_conosco) ? $trabalhe_conosco : ''; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="terceirizacao_frotas">Terceirização de frotas</label></th>
					<td><input type="text" name="terceirizacao_frotas" size="40" value="<?php echo isset($terceirizacao_frotas) ? $terceirizacao_frotas : ''; ?>" /></td>
				</tr>				
				<tr valign="top">
					<th scope="row"><label for="caminhao_pipa">Caminhão Pipa</label></th>
					<td><input type="text" name="caminhao_pipa" size="40" value="<?php echo isset($caminhao_pipa) ? $caminhao_pipa : ''; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="reserva">Reserva</label></th>
					<td><input type="text" name="reserva" size="40" value="<?php echo isset($reserva) ? $reserva : ''; ?>" /></td>
				</tr>
			</table>
			<hr />
			<h3>Outras configurações</h3>
			<p>Arquivo de contrato de locação</p>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="fale_conosco">Selecione um arquivo</label></th>
					<td><input type="file" name="contrato" size="40" /></td>
				</tr>
			</table>
			<p>Extensões permitidas: <code>pdf</code></p>
			<?php if ( isset($contrato) ) : ?>
			<p>Arquivo atual: <a target="_blank" href="<?php echo $contrato; ?>"><code><?php echo $contrato; ?></code></a>
			<?php endif; ?>
			<p>
				<input type="submit" value="Salvar" class="button-primary" />
			</p>
		</form>
	</div>
	<script type="text/javascript">
	(function($) {
		var $form = $('form[name=valores\\_servicos]');
		$('input[type=text]', $form).keyup(function() {
			$(this).val( $(this).val().replace(/[^\d]/g, '').replace(/(\d\d?)$/, ',$1') );
		}).eq(0).focus();
	})(jQuery);
	<?php
}

// Registra menus
function rk_register_menu_options() {
	add_menu_page( get_bloginfo(), get_bloginfo(), 'publish_posts', 'ranking_options', 'rk_menu_options_manage' , '', 3 ); 
}

// Inicializa 
if ( is_admin() ) {
	add_action('admin_menu', 'rk_register_menu_options');
}
/**********************************************************/

// Adiciona coluna com exibição da imagem em destaque em determinados post types
function rk_column_thumb_head($defaults) {
	global $post;

	// Post types a receberam a coluna
	$post_types = array(
		"destaque",
		"grupo",
		"veiculo"
	);

	if ( is_object($post) && in_array($post->post_type, $post_types) ) {
		$defaults['thumb'] = 'Imagem associada';
	}

	return $defaults;
}
function rk_column_thumb_content($column_name, $post_ID) {
	if ($column_name == 'thumb') { 
		echo get_the_post_thumbnail($post_ID, 'medium');
	}
}
add_filter('manage_posts_columns', 'rk_column_thumb_head');
add_action('manage_posts_custom_column', 'rk_column_thumb_content', 10, 2);

// Remove o menu de "Reordenar" em Reservas caso o mesmo exista e encontra-se ativo
function reserva_menu_disable_sort() {
	if ( is_plugin_active('post-types-order/post-types-order.php') ) {
		remove_submenu_page('edit.php?post_type=reserva', 'order-post-types-reserva');
	}
}
add_action('admin_init', 'reserva_menu_disable_sort');

/*
 ***********************************************************
 * Adiciona colunas personalizadas dependendo do post type *
 ***********************************************************
 * - Configurador: themes/default/app/config/options.php   *
 * - Dependência: Plugin - Advanced Custom Fields (ACF)    *
 ***********************************************************
 */
function rk_columns_head($defaults) {  
	global $post;

	$post_types = Config::get('post_types');

	$types = array_keys($post_types);
	if ( is_object($post) && in_array($post->post_type, $types) ) {
		$fields = $post_types[ (string) $post->post_type ];

		if ( is_array($fields) && count($fields) > 0 ) {
			$field = array_keys($fields);
			foreach ($field as $name) {
				$defaults[ $name ] = $fields[ $name ][ 'name' ];
			}
		}
	}

	return $defaults;  
} 
function rk_columns_content($column_name, $post_ID) { 
	global $post;
	global $wpdb;

	$post_types = Config::get('post_types');

	$types = array_keys($post_types);
	if ( in_array($post->post_type, $types) ) {
		$fields = $post_types[ (string) $post->post_type ];
		$columns = array_keys($fields);

		foreach($columns as $column) {
			if ($column_name == $column) {
				$field = get_field($column);

				/**
				 * - Quando o tipo do campo personalizado for array, é preciso realizar uma consulta para obter o "Label" de cada item
				 * - Infelizmente, o plugin "Advanced Custom Fields" não disponibiliza em sua API, uma função para tal propósito
				 */
				if ( is_array($field) ) {
					$result = $wpdb->get_results("
						SELECT meta_value 
						FROM wp_postmeta 
						WHERE meta_key = (SELECT meta_value FROM wp_postmeta WHERE meta_key = '_{$column}' AND post_id = {$post_ID})
					");

					if ( is_array($result) && count($result) > 0 ) {
						$object  = current($result);
						$serial  = maybe_unserialize( (string) $object->meta_value );
						$choices = $serial['choices'];
						$names   = array();
						foreach($field as $f) {
							$names[] = $choices[ $f ];
						}

						$field = implode(", ", $names);
					}
				}

				// Renderiza o valor na coluna personalizada
				echo apply_filters('rk_column_content', $field);
			}
		}
	}
}
function rk_column_content_parse_html($text) {

	// Exibe link "clicável" na coluna quando o mesmo for uma URL válida
	if ( preg_match('/(http(s)?:\/\/)?(www\.)?(.+?)\.(.+?)+/', $text, $match) ) {
		return '<a target="_blank" href="' . $match[0] . '">' . $match[0] . '</a>';
	}

	return $text;
}

function rk_columns_init() {

	// O plugin "Advanced Custom Fields" precisa existir e estar ativo
	if ( is_plugin_active('advanced-custom-fields/acf.php') ) {
		add_filter('manage_posts_columns', 'rk_columns_head');
		add_action('manage_posts_custom_column', 'rk_columns_content', 10, 2); 
		add_filter('rk_column_content', 'rk_column_content_parse_html');
	}
}
add_action('admin_init', 'rk_columns_init');
/**********************************************************/

// Desabilita alguns itens do menu administrativo (Frontend)
function rk_admin_disable_options_frontend() {
	global $wp_admin_bar;

	// Itens de menu não "utilizáveis" neste projeto ou desnecessários para o usuário final
	$wp_admin_bar->remove_menu('themes');
	$wp_admin_bar->remove_menu('menus');
	$wp_admin_bar->remove_menu('appearance');
	$wp_admin_bar->remove_menu('new-post');
	$wp_admin_bar->remove_menu('new-link');
	$wp_admin_bar->remove_menu('new-page');
	$wp_admin_bar->remove_menu('new-user');
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('updates');
	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('search');

	// Atualiza o href de adicionar novo post para #
	$new_content_node = $wp_admin_bar->get_node('new-content');
	$new_content_node->href = '#';
	$wp_admin_bar->add_node($new_content_node);
	$wp_admin_bar->remove_menu('new-post');
}
add_action('wp_before_admin_bar_render', 'rk_admin_disable_options_frontend');

// Desabilita alguns itens do menu administrativo (Backend)
function rk_admin_disable_options_backend() {
	remove_menu_page('edit-comments.php');
	remove_menu_page('edit.php');
	remove_menu_page('tools.php');
	remove_menu_page('users.php');
	remove_menu_page('plugins.php');
	remove_menu_page('themes.php');
	remove_menu_page('edit.php?post_type=acf');

	// Nenhuma página nova (além das existentes) deve ser adicionada
	remove_submenu_page('edit.php?post_type=page', 'post-new.php?post_type=page');

	// Remove o subitem de Atualizações
	remove_submenu_page('index.php', 'update-core.php');
}
add_action('admin_menu', 'rk_admin_disable_options_backend', 10);

// Desabilita a visualização do botão de adicionar e remover páginas
function rk_admin_disable_page_options() {
	global $current_screen;

	// Nenhuma página nova deve ser criada ou as existentes devem ser removidas
	if ($current_screen->post_type == 'page') {
		echo '
		<style type="text/css">
		.add-new-h2, #delete-action { display: none; }
		</style>
		';
	}
}
add_action('admin_head','rk_admin_disable_page_options');

// Desabilita o botão "Lixeira" no QuickEdit em páginas
function rk_admin_disable_page_row_action_trash($actions) {

	// Nenhuma página deve ser removida
	unset($actions['trash']);
	return $actions;
}
add_filter('page_row_actions', 'rk_admin_disable_page_row_action_trash', 10, 1);

// Corrige pré-visualização de permalink adicionando .html no final
function rk_update_permalink_html($return) {

	// Necessita possuir o plugin "Html on Pages" instalado e habilitado
	if ( is_plugin_active('html-on-pages/html-on-pages.php') ) {
		global $post;

		// Proteção para ausência de post
		if ( !is_object($post) ) { return ""; }

		// Evita adicionar novamente .html em link de páginas 
		if ($post->post_type != "page") {
			$slug = $post->post_name;
			$return = str_replace($slug, $slug . '.html', $return);
		}

		// Retorna o novo link sem o botão de editar 
		return preg_replace('/<span id="edit-slug-buttons">(.*?)<\/span>/i', '', $return);
	}

	// Na ausência do plugin, retorna o conteúdo original
	return $return;
}
add_filter('get_sample_permalink_html', 'rk_update_permalink_html', '', 4);

// Desativa a exibição de reservas que ainda não foram concluídas (Not publish)
function rk_disble_pending_reserva($views) {
	$screen = get_current_screen();

	if ($screen->post_type == "reserva") {
		unset($views['all']);
		unset($views['pending']);
		unset($views['draft']);
	}

	return $views;
}
add_filter('views_edit-reserva', 'rk_disble_pending_reserva');

// Modifica o item de menu reserva para carregar apenas reservas concluídas (publish como padrão)
function rk_submenu_reserva_publish() {
	global $submenu;
	
	$type = 'reserva';
	foreach($submenu['edit.php?post_type=' . $type] as $key => $value) {
		if ( in_array('edit.php?post_type=' . $type, $value) ) {
			$submenu[ 'edit.php?post_type=' . $type ][ $key ][2] = 'edit.php?post_status=publish&post_type=' . $type;
		}
	} 
}
add_action('admin_menu', 'rk_submenu_reserva_publish');

/*
 ***********************************************************
 * Adiciona post types customizados para o projeto         *
 ***********************************************************
 */
// Post type > Destaques
register_post_type('destaque', array(
	'labels' => array(
		'name'               => __('Destaques'),
		'singular_name'      => __('Destaque'),
		'add_new'            => __('Novo destaque'),
		'add_new_item'       => __('Adicionar novo destaque'),
		'edit_item'          => __('Editar destaque'),
		'new_item'           => __('Novo destaque'),
		'view_item'          => __('Ver destaque'),
		'search_items'       => __('Buscar destaques'),
		'not_found'          => __('Nenhum destaque encontrado'),
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
	'supports'           => array('title', 'editor', 'thumbnail')
));

// Post type > Veículos
register_post_type('veiculo', array(
	'labels' => array(
		'name'               => __('Veículos'),
		'singular_name'      => __('Veículo'),
		'add_new'            => __('Novo veículo'),
		'add_new_item'       => __('Adicionar novo veículo'),
		'edit_item'          => __('Editar veículo'),
		'new_item'           => __('Novo veículo'),
		'view_item'          => __('Ver veículo'),
		'search_items'       => __('Buscar veículos'),
		'not_found'          => __('Nenhum veículo encontrado'),
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
	'supports'           => array('title', 'editor', 'thumbnail')
));

// Post type > Grupos
register_post_type('grupo', array(
	'labels' => array(
		'name'               => __('Grupos'),
		'singular_name'      => __('Grupo'),
		'add_new'            => __('Novo grupo'),
		'add_new_item'       => __('Adicionar novo grupo'),
		'edit_item'          => __('Editar grupo'),
		'new_item'           => __('Novo grupo'),
		'view_item'          => __('Ver grupo'),
		'search_items'       => __('Buscar grupos'),
		'not_found'          => __('Nenhum grupo encontrado'),
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
	'supports'           => array('title', 'thumbnail')
));

// Post type > Reservas
register_post_type('reserva', array(
	'labels' => array(
		'name'               => __('Reservas'),
		'singular_name'      => __('Reserva'),
		'add_new'            => __('Nova reserva'),
		'add_new_item'       => __('Adicionar nova reserva'),
		'edit_item'          => __('Editar reserva'),
		'new_item'           => __('Nova reserva'),
		'view_item'          => __('Ver reserva'),
		'search_items'       => __('Buscar reservas'),
		'not_found'          => __('Nenhuma reserva encontrada'),
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
	'supports'           => false
));

// Post type > FAQ
register_post_type('faq', array(
	'labels' => array(
		'name'               => __('FAQs'),
		'singular_name'      => __('FAQ'),
		'add_new'            => __('Novo item FAQ'),
		'add_new_item'       => __('Adicionar novo item FAQ'),
		'edit_item'          => __('Editar FAQ'),
		'new_item'           => __('Novo FAQ'),
		'view_item'          => __('Ver FAQ'),
		'search_items'       => __('Buscar FAQs'),
		'not_found'          => __('Nenhum item FAQ encontrado'),
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
	'supports'           => array('title', 'editor')
));
/**********************************************************/

/*
 ***********************************************************
 * Gerenciador de contatos                                 *
 ***********************************************************
 */

// Registra post type de contatos 
register_post_type('contato', array(
	'labels' => array(
		'name'               => __('Contatos'),
		'singular_name'      => __('Contato'),
		'add_new'            => __('Novo contato'),
		'add_new_item'       => __('Adicionar novo contato'),
		'edit_item'          => __('Editar contato'),
		'new_item'           => __('Novo contato'),
		'view_item'          => __('Ver contato'),
		'search_items'       => __('Buscar contatos'),
		'not_found'          => __('Nenhum contato encontrado'),
		'not_found_in_trash' => __('Nada encontrado na Lixeira'),
		'parent_item_colon'  => ''
	),
	'public'             => false,
	'publicly_queryable' => true,
	'show_ui'            => true,
	'query_var'          => true,
	'rewrite'            => true,
	'capability_type'    => 'post',
	'hierarchical'       => false,
	'menu_position'      => 5,
	'supports'           => array('title', 'attachment')
));

// Carrega dependências
function contato_enqueue_resources() {

	// Validate Fields
	wp_enqueue_script( 'jquery-validate', APP_WEBROOT . '/js/jquery.validate.min.js', array('jquery') );

	// Masked Input
	wp_enqueue_script( 'jquery-maskedinput', APP_WEBROOT . '/js/jquery.maskedinput.min.js', array('jquery') );
}

// Registra Metabox para contatos
function contato_register_metabox($post_type, $post) {
	add_meta_box(
		'meta-box-contato',
		__('Dados do Contato'),
		'contato_manage_metabox',
		'contato',
		'normal'
	);
}

// Gerencia Metabox de contatos
function contato_manage_metabox($post) {

	// Nonce
	wp_nonce_field('meta-box-contato', 'meta-box-contato-nonce');

	// Dados genéricos do contato
	$values      = get_post_meta($post->ID, 'contato_values', true);
	$assunto     = isset($values['subject'])     ? $values['subject']     : '';
	$telefone    = isset($values['telefone'])    ? $values['telefone']    : '';
	$email       = isset($values['email'])       ? $values['email']       : '';
	$observacoes = isset($values['observacoes']) ? $values['observacoes'] : '';

	// Dados mais específicos
	$frota       = isset($values['frota'])       ? $values['frota']       : '';
	$empresa     = isset($values['empresa'])     ? $values['empresa']     : '';
	$curriculum  = isset($values['curriculum'])  ? $values['curriculum']  : '';
	?>
	<style type="text/css">
	#meta-box-contato .inside { 
		margin: 0; 
		padding: 0;
	}
	.meta-box-contato-wrap {
		padding: 0 10px;
		border-bottom: #e8e8e8 solid 1px;
		padding-bottom: 13px;
	}
	.meta-box-contato-wrap .meta-box-contato-field {
		position: relative;
		margin: 10px 0 0 0;
	}
	.meta-box-contato-wrap .meta-box-contato-field label { 
		font-size: 13px;
		font-weight: bold;
		color: #333333;
	}
	.meta-box-contato-wrap .meta-box-contato-field p { 
		line-height: 1.1em;
		margin: 0 0 5px 0;
		padding: 0;
		color: #000000;
		text-shadow: 0 1px 0 #ffffff;
	}
	.meta-box-contato-wrap .mandatory {
		color: #ff0000;
	}
	.meta-box-contato-wrap .meta-box-contato-field p.description { 
		font-size: 11px;
		font-style: normal !important;
		color: #666666;
	}
	.meta-box-contato-wrap .separator {
		border-bottom: #e8e8e8 solid 1px;
	}
	.meta-box-contato-wrap input[type=text], .meta-box-contato-wrap textarea { width: 100%; }
	.meta-box-contato-wrap input[type=file] { width: 99%; }
	</style>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		var $form = $('#post');
		$('.phone').mask('(99) 99999-9999');
		$form.validator({
			attr : 'title',
			fail : function() {
				$('.spinner').removeAttr('style');
				$('#publish').removeClass('button-primary-disabled');
			}
		});
		$('#title', $form).attr('readonly', true);
	});
	</script>
	<div class="meta-box-contato-wrap">
		<div class="meta-box-contato-field">
			<p>
				<label for="meta-box-contato-assunto">Assunto</label>
			</p>
		</div>
		<div>
			<input readonly="readonly" type="text" id="meta-box-contato-assunto" title="Assunto" name="assunto" value="<?php echo esc_attr($assunto); ?>" />
		</div>
	</div>	
	<div class="meta-box-contato-wrap">
		<div class="meta-box-contato-field">
			<p>
				<label for="meta-box-contato-assunto">Data</label>
			</p>
		</div>
		<div>
			<input readonly="readonly" type="text" id="meta-box-contato-data" title="Data" name="data" value="<?php echo date( 'd/m/Y H:i:s', strtotime($post->post_date) ); ?>" />
		</div>
	</div>
	<div class="meta-box-contato-wrap">
		<div class="meta-box-contato-field">
			<p>
				<label for="meta-box-contato-telefone">Telefone</label>
			</p>
		</div>
		<div>
			<input readonly="readonly" type="text" id="meta-box-contato-telefone" title="Telefone" name="telefone" value="<?php echo esc_attr($telefone); ?>" />
		</div>
	</div>
	<div class="meta-box-contato-wrap">
		<div class="meta-box-contato-field">
			<p>
				<label for="meta-box-contato-email">E-mail</label>
			</p>
		</div>
		<div>
			<input readonly="readonly" type="text" id="meta-box-contato-email" title="E-Mail" name="email" value="<?php echo esc_attr($email); ?>" />
		</div>
	</div>
	<?php if ($empresa) : ?>
	<div class="meta-box-contato-wrap">
		<div class="meta-box-contato-field">
			<p>
				<label for="meta-box-contato-empresa">Empresa</label>
			</p>
		</div>
		<div>
			<input readonly="readonly" type="text" id="meta-box-contato-empresa" title="Empresa" name="empresa" value="<?php echo esc_attr($empresa); ?>" />
		</div>
	</div>
	<?php endif; ?>
	<?php if ($frota) : ?>
	<div class="meta-box-contato-wrap">
		<div class="meta-box-contato-field">
			<p>
				<label for="meta-box-contato-frota">Frota</label>
			</p>
		</div>
		<div>
			<input readonly="readonly" type="text" id="meta-box-contato-frota" title="Frota" name="frota" value="<?php echo esc_attr($frota); ?>" />
		</div>
	</div>
	<?php endif; ?>
	<?php if ($observacoes) : ?>
	<div class="meta-box-contato-wrap">
		<div class="meta-box-contato-field">
			<p>
				<label for="meta-box-contato-obs">Observações</label>
			</p>
		</div>
		<div>
			<textarea readonly="readonly" id="meta-box-contato-obs" rows="5" title="Observações" name="observacoes"><?php echo esc_attr($observacoes); ?></textarea>
		</div>
	</div>
	<?php endif; ?>
	<?php if ($curriculum) : ?>
	<div class="meta-box-contato-wrap">
		<div class="meta-box-contato-field">
			<p>
				<label for="meta-box-contato-curriculum">Curriculum</label>
			</p>
			<p class="description"><a target="_blank" href="<?php echo $curriculum; ?>">Visualizar</a></p>
		</div>
	</div>
	<?php endif; ?>
	<?php
}

// Salva os dados de contato
function contato_save_post($post_id) {
	if ( !isset($_POST['meta-box-contato-nonce']) ) {
		return $post_id;
	}

	$nonce = $_POST['meta-box-contato-nonce'];
	if ( !wp_verify_nonce($nonce, 'meta-box-contato') ) {
		return $post_id;
	}

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return $post_id;
	}

	if ( !current_user_can('edit_post', $post_id) ) {
		return $post_id;
	}

	// Upload de arquivo
	if ( !empty($_FILES[ 'curriculum' ][ 'name' ]) ) {
		$upload = wp_upload_bits(
			$_FILES[ 'curriculum' ][ 'name' ], 
			null,
			file_get_contents( $_FILES[ 'curriculum' ][ 'tmp_name' ] )
		);

		if ( isset($upload['error']) && $upload['error'] != 0) {  
			wp_die('Não foi possivel realizar o upload. Motivo: ' . $upload['error']);  
		} else {  
			$_POST['curriculum'] = $upload['url'];      
		} 
	}

	update_post_meta( $post_id, 'contato_values', array_map('sanitize_text_field', $_POST) );
}

// Altera o label da coluna "Título" por "Nome" e adiciona a coluna "Assunto" na listagem de contatos
function contato_columns_head($defaults) {
	global $post;

	if ( is_object($post) && $post->post_type == "contato" ) {
		$defaults['title']   = 'Nome';
		$defaults['subject'] = 'Assunto';
	}

	return $defaults;
}

// Renderiza o conteúdo da coluna "Assunto" na listagem de contatos
function contato_columns_content($column_name, $post_ID) {
	if ($column_name == 'subject') { 
		$meta = get_post_meta($post_ID, 'contato_values', true);
		echo $meta['subject'];
	}
}

// Registra colunas de contatos como "sortable", permitindo ordena-las
function contato_columns_sortable($defaults) { 
	$defaults['subject']  = "subject";

	return $defaults;  
}

// Gerencia a forma como as novas colunas de contatos serão ordenadas
function contato_columns_sortable_order($query) {
	$orderby = $query->get('orderby');  

	switch ($orderby) {
		case 'subject' : { 
			$query->set('orderby', 'meta_value');
			$query->set('meta_key', 'contato_values');
			break;
		}
	}
}

// Adiciona enctype no formulário, permitindo realizar upload de arquivos
function contato_update_edit_form($post) {  
	if ($post->post_type == "contato") {
		echo 'enctype="multipart/form-data"';
	}
}

// Desabilita o QuickEdit de ações 
function contato_row_actions($actions) {
	global $post;

	if ($post->post_type == "contato") {
		unset($actions);
	} else {
		return $actions;
	}
}

// Desabilita o menu de adicionar novo contato
function contato_menu_disable_new() {
	remove_submenu_page('edit.php?post_type=contato', 'post-new.php?post_type=contato');

	// Remove o menu de "Reordenar" caso o mesmo exista e encontra-se ativo
	if ( is_plugin_active('post-types-order/post-types-order.php') ) {
		remove_submenu_page('edit.php?post_type=contato', 'order-post-types-contato');
	}
}

// Desabilita a visualização do botão de adicionar novo contato
function contato_button_disable_new() {
	$screen = get_current_screen();
	if ($screen->post_type == "contato") {
		echo '
		<style type="text/css">
		#postbox-container-1, .add-new-h2 { display: none; }
		</style>
		';
	}
}

// Validaçao Server Side CPF
function validaCPF($cpf){	

// Verifiva se o numero digitado contem todos os digitos
  //  $cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);
	
	// Verifica se nenhuma das sequÃªncias abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
	{
	return false;
    }
	else
	{   // Calcula os nÃºmeros para verificar se o CPF Ã© verdadeiro
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }
}

// Validaçao Server Side Email
function validaEmail($mail){
	if(preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(.[[:lower:]]{2,3})(.[[:lower:]]{2})?$/", $mail)) {
		return true;
	}else{
		return false;
	}
}

// Actions/Filters de contato
add_action('admin_init',                           'contato_menu_disable_new');
add_action('admin_head',                           'contato_button_disable_new');
add_action('admin_enqueue_scripts',                'contato_enqueue_resources');  
add_action('add_meta_boxes',                       'contato_register_metabox', 10, 2);
add_action('post_edit_form_tag',                   'contato_update_edit_form');
add_action('save_post',                            'contato_save_post');
add_action('manage_posts_custom_column',           'contato_columns_content', 10, 2);
add_action('pre_get_posts',                        'contato_columns_sortable_order');

add_filter('manage_posts_columns',                 'contato_columns_head');
add_filter('post_row_actions',                     'contato_row_actions', 10, 1);
add_filter('manage_edit-contato_sortable_columns', 'contato_columns_sortable'); 
?>