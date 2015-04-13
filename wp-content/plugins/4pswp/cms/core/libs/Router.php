<?php
class Router {
    static private $matched = false;

    public static function connect($routes, $defaults = array()) {

        if (!is_array($routes))
            $routes = array($routes);
//		echo '<pre>';
        foreach ($routes as $route) {
            if (!self::$matched) {
                $activeURI = Context::getRealURI(false); 
                $expression = Router_Utils::prepare( apply_filters('router_name', $route) );
                $tokens = self::match($activeURI, $expression);
				// var_dump(array(
				// 	'route' => $route,
				// 	'activeUri' => $activeURI,
				// 	'expression' => $expression,
				// 	'tokens' => $tokens
				// ));
                if ($tokens !== null) {
                    self::$matched = true;

                    foreach ($tokens as $key => $value) {
                        Context::addParam($key, $value);
                    }

                    if (isset($defaults['controller']) && !empty($defaults['controller']))
                        Context::$controller = $defaults['controller'];

                    if (isset($defaults['action']) && !empty($defaults['action']))
                        Context::$view = $defaults['action'];
					
					if(isset($defaults['vars']) && is_array($defaults['vars']) && count($defaults['vars'])){
						foreach($defaults['vars'] as $k => $v){
							if(!Context::getParam($k))
								Context::addParam($k, $v);
                }
            }
					
					do_action('router_match', array('route' => $route, 'defaults' => $defaults, 'tokens' => $tokens));
        }
            }
        }
//		echo '</pre>';
    }

    public static function match($activeURI, $expression) {
        preg_match_all($expression, $activeURI, $results);

        $results = array_filter($results);

        $tokens = null;
        if (is_array($results) && sizeof($results)) {

            $tokens = array();
            $count = 0;

            foreach ($results as $key => $value) {
                // skipping full url
                if ($count == 0) {
                    $count++;
                    continue;
                }
                
                // checking if its a named case
                if (!is_numeric($key)) {

                    $namedValue = $value;
                    if (is_array($value))
                        $namedValue = current($value);

                    $tokens[$key] = $namedValue;
                }
                // numeric keys (possible generic pattern)
                else {
                    if (is_array($value))
                        $value = current($value);

                    if (!in_array($value, $tokens)) {
                        $tokens['generic'] = $value;
                    }
                }

                $count++;
            }
        }

        return $tokens;
    }

    public static function init() {
        include Context::getScopePath() . DS . 'config' . DS . 'routes.php';
    }
}