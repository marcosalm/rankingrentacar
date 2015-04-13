<?php
class Context {
    static $layout = null;
	static $controller = 'pages';
	static $view = 'home';
	static $params = array();
    static $urlParams = array();

    static $scope = 'app';
    static $redirected = false;

	public static function init() {
 		// parsing URL
		$urlParams = array_filter(URL_Parser::getParams());
        self::$urlParams = $urlParams;

        if (sizeof($urlParams) >= 2) {
            $controller = array_shift($urlParams);
            $view = array_shift($urlParams);
        }
        else if (sizeof($urlParams) == 1) {
            $view = array_shift($urlParams);
        }

        if (isset($controller)) self::$controller = $controller;
        if (isset($view)) {
            $view = str_replace(".html", "", $view);
            self::$view = $view;
        }
	}

    public static function setScope() {
        $controller = self::$controller;
        $view = self::$view;

        $appViewPath = APP_VIEWS_PATH . DS . $controller . DS . $view . VIEW_EXT;

        if (!file_exists($appViewPath))
            self::$scope = 'cms';
    }

    public static function addParam($key, $value) {
        self::$params[$key] = $value;
    }

    public static function getParam($key) {
        if (isset(self::$params[$key]))
            return self::$params[$key];

        return false;
    }

    public static function getParams() {
        return self::$params;
    }

    public static function getScopePath() {
        return (self::$scope == 'app') ? APP_PATH : CORE_PATH;
    }

    public static function getRealURI($queryVars = true) {
        $blogUrl = get_bloginfo('url');
        if (defined('WP_SITEURL'))
            $blogUrl = WP_SITEURL;

        $fullUrl = self::getFullUrl($queryVars);

        return str_replace($blogUrl, '', $fullUrl);
    }

    public static function getFullUrl($queryVars = true) {
        if (!isset($_SERVER['REQUEST_URI']))
            $uri = $_SERVER['PHP_SELF'];
        else
            $uri = $_SERVER['REQUEST_URI'];

        $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
        $protocol = String_Utils::strLeft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/") . $s;
        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);
        $fullUrl = $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $uri;

        if (!$queryVars) {
            $tokens = explode('?', $fullUrl);
            $fullUrl = current($tokens);
        }

        return $fullUrl;
    }

    public static function redirect($url) {
        header("Location: $url");
        exit();
    }
}