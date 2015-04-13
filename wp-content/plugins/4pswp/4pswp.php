<?php

/*
  Plugin Name: 4Pswp
  Plugin URI: http://www.4ps.com.br
  Description: CMS de wordpress da 4Ps
  Author: 4Ps
  Version: 1.0
 */

  function install() {
    //Verifica se o plugin já foi instalado no thema
  	if (!hasCreated()) {
        //copyFilesDefaults();
  	}
  }

  function load() {
  	$app = new Loader($_REQUEST['page']);
  }

  function hasCreated() {
  	$cakewp_path = TEMPLATEPATH . DIRECTORY_SEPARATOR . 'cakewp.txt';
  	$hasCreated = is_file($cakewp_path);
  	if (!$hasCreated) {
  		$fp = fopen($cakewp_path, "w+");
  		$today = date('d/m/Y');
  		$theme = substr(TEMPLATEPATH, strrpos(TEMPLATEPATH, DIRECTORY_SEPARATOR));
  		$content = "/**\r\n* Created in: {$today}\r\n* Theme: {$theme}\r\n*/\r\n";
  		fwrite($fp, $content);
  		fclose($fp);
  	}

  	return $hasCreated;
  }

  add_action('admin_menu', 'install');

/**
 * Adiciona um item de submenu em "Configurações" apenas para leitura de dados do arquivo options.php 
 */
function submenu_options_read() {
	$optionsPath = TEMPLATEPATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config';
	$optionFile = 'options.php';

	echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
	echo '  <h2>4PsCake - Leitor de opções</h2><br />';

	$optionFilePath = $optionsPath . DIRECTORY_SEPARATOR . $optionFile;
	if ( !file_exists($optionFilePath) ) {
		echo "<p>Arquivo {$optionFile} não encontrado</p>";
	} else {
		echo "<h3>- $optionFilePath</h3>";
		include_once($optionFilePath);
		debug(Config::$properties);
	}
	echo '</div>';
}

/**
 * Gerencia configurações genéricas úteis para qualquer projeto
 */
function submenu_options_manage() {

	// Controle de acesso
	if ( !current_user_can('manage_options') ) {  
		wp_die('Permissão negada');  
	}

	// Salva configurações
	if ( count($_POST) > 0 ) {
		update_option('config_social', $_POST);
		?><div id="message" class="updated">Configuração salva</div><?php
	}

	// Opções
	$social = get_option('config_social');
	?>
	<div class="wrap">
		<?php screen_icon('options-general'); ?> <h2><?php echo get_bloginfo(); ?> - Configurações</h2>  
		<form method="post" action="">  
			<h3>Redes sociais</h3>
			<p>Digite as informações de perfil das seguintes redes sociais utilizadas</p>
			<p>Observação: Todos os campos são de preenchimento <strong>opcional</strong></p>
			<table class="form-table">
				<tr valign="top">  
					<th style="width:10%;" scope="row"><label for="facebook">Facebook</label></th>  
					<td style="width:10%"><code>https://www.facebook.com/</code></td>
					<td><input type="text" id="facebook" name="facebook" size="25" value="<?php echo isset($social['facebook']) ? $social['facebook'] : ''; ?>" /></td>  
				</tr>            
				<tr valign="top">  
					<th style="width:10%;" scope="row"><label for="twitter">Twitter</label></th>  
					<td style="width:10%"><code>https://twitter.com/</code></td>
					<td><input type="text" id="twitter" name="twitter" size="25" value="<?php echo isset($social['twitter']) ? $social['twitter'] : ''; ?>" /></td>  
				</tr>            
				<tr valign="top">  
					<th style="width:10%;" scope="row"><label for="gplus">Google Plus</label></th>  
					<td style="width:10%"><code>https://plus.google.com/</code></td> 
					<td><input type="text" id="gplus" name="gplus" size="25" value="<?php echo isset($social['gplus']) ? $social['gplus'] : ''; ?>" /></td>  
				</tr>				
				<tr valign="top">  
					<th style="width:10%;" scope="row"><label for="instagram">Instagram</label></th>  
					<td style="width:10%"><code>http://instagram.com/</code></td> 
					<td><input type="text" id="instagram" name="instagram" size="25" value="<?php echo isset($social['instagram']) ? $social['instagram'] : ''; ?>" /></td>  
				</tr>
			</table>
			<p>
				<input type="submit" value="Salvar" class="button-primary" />  
			</p>
		</form>
	</div>

	<?php }

/**
 * Registra submenus
 */
function register_submenu_options() {
	add_submenu_page( 'options-general.php', 'Cake Config', 'Cake Config', 'manage_options', '4pscake_options_read', 'submenu_options_read' ); 
	add_submenu_page( 'options-general.php', get_bloginfo(), get_bloginfo(), 'manage_options', 'project_options', 'submenu_options_manage' ); 
}

// Inicializa submenus apenas para administradores
if ( is_admin() ) {
	add_action('admin_menu', 'register_submenu_options');
}