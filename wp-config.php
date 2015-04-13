<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'ranking');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'quatrops');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'u3Xhd9btCq');

/** nome do host do MySQL */
define('DB_HOST', '192.168.0.3');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'amGKb,V4WN%G]hH-3B@#]I,B*<]PJBk)r: Xo[0#AM T-DQY s1tM>76@WOn<hfh');
define('SECURE_AUTH_KEY',  'X?[%wQ1uBQ$5>!.e6j-yG0x{h<gXw]fWB>;iae7V!$1uZ+z*,%K11BgNeI0PI(dy');
define('LOGGED_IN_KEY',    'Pdl8C~k_<^hP,,LNk(D+%D?Yd4!oEqz3wqG|nc81A{-oMSoI_YA{m2Q<z0.5YQ92');
define('NONCE_KEY',        'q@l(|rX >iHum]Y^~ZyB1P8BCIO]kWS1inI<l;>rna8t2x/4z8V^,@}}^a?{PGYK');
define('AUTH_SALT',        '|L3gLVuD/&&`{:GI)+(-^L9W<c*5]2IFN!Z|`O_^bSo{deYQ`o)Dy)UwFnCS,Gs3');
define('SECURE_AUTH_SALT', 'l7|(w$k5c(pLb*Y:r>uhG%fLR(J&>f<ZfOLNfMRHj-iWcX|xiN]4q$5Eazn4}f=c');
define('LOGGED_IN_SALT',   ' ;;< o6%Z1T_-RpGDKf=VPfpj+EwQ!Iv:f`vsUN_ 7#DeG-p>ItJO|dtjH*Mj ze');
define('NONCE_SALT',       '=W&ok8ABtY2exH(AJnwzDR!Vb@|w;^p!+?H+w9:0u+~]]yWveiUTWV07)|>7bl`)');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * O idioma localizado do WordPress é o inglês por padrão.
 *
 * Altere esta definição para localizar o WordPress. Um arquivo MO correspondente ao
 * idioma escolhido deve ser instalado em wp-content/languages. Por exemplo, instale
 * pt_BR.mo em wp-content/languages e altere WPLANG para 'pt_BR' para habilitar o suporte
 * ao português do Brasil.
 */
define('WPLANG', 'pt_BR');

/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
