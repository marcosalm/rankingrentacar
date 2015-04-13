<?php
define('CMS_PATH', dirname(__FILE__));

if (!defined('DS'))
	define('DS', DIRECTORY_SEPARATOR);

define('CORE_PATH', CMS_PATH . DS . 'core');
define('CORE_VIEWS_PATH', CORE_PATH . DS . 'views');
define('CORE_MODELS_PATH', CORE_PATH . DS . 'models');
define('CORE_LIBS_PATH', CORE_PATH . DS . 'libs');
define('CORE_COMPONENTS_PATH', CORE_PATH . DS . 'components');

// app constants
define('APP_PATH', TEMPLATEPATH . DS . 'app');
define('APP_CONFIG_PATH', APP_PATH . DS . 'config');
define('APP_VIEWS_PATH', APP_PATH . DS . 'views');
define('APP_VIEWS_LAYOUTS_PATH', APP_VIEWS_PATH . DS . 'layouts');
define('APP_MODELS_PATH', APP_PATH . DS . 'models');
define('APP_COMPONENTS_PATH', APP_PATH . DS . 'components');

define('APP_WEBROOT', get_bloginfo('stylesheet_directory') . '/app/webroot');

define('CONTENT_PATH', dirname(dirname(TEMPLATEPATH)));

$https = (isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on"));
$contentUrl = get_bloginfo('wpurl') . '/wp-content';
if ($https) {
	$contentUrl = str_replace('https://', 'http://', $contentUrl);
}

define('CONTENT_URL', $contentUrl);

define('GD_KEY', 'image');
define('GD_BASE_PATH', CONTENT_PATH);
define('GD_BASE_URL', CONTENT_URL);
define('GD_DEFAULT_FILE', '/uploads/static/default.jpg');

// basic config class
include_once(CORE_LIBS_PATH . DS . 'Config.php');

// loading app config options
include_once(APP_CONFIG_PATH . DS . 'options.php'); 

include_once(CORE_PATH . DS . 'basics.php');

if (!defined('VIEW_EXT'))
	define('VIEW_EXT', '.php');

// autoloader
include_once(CORE_LIBS_PATH . DS . 'Loader.php');
spl_autoload_register(array('Loader', 'loadClass'));

// checking if its a GD request
GD::check();


if (Config::get('DEBUG')) {
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}