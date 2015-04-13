<?php
class Controller_Manager {

	static $instance = null;

	// singleton controller instance
	public static function getInstance() {
		$controllerName = Context::$controller;
		if (self::$instance == null) {
			$controllerClassName = ucfirst($controllerName) . "_Controller";

			if (class_exists($controllerClassName))
				self::$instance = new $controllerClassName();
			else throw new Exception_ControllerNotFound("Controller '{$controllerClassName}' was not found.");
		}
		return self::$instance;
	}

	public static function run() {
		$actionName = String_Utils::toCamelcase(Context::$view, '_');
		$actionName = String_Utils::toCamelcase(Context::$view, '-');

		// reseting instance
		self::$instance = null;

		$controller = self::getInstance();
		
		if (method_exists($controller, $actionName)) 
			$controller->$actionName();
		//else throw new Exception_ActionNotFound("Action '{$actionName} was not found on controller.'");
		
		if (isset($controller->layout) && !empty($controller->layout))
			Context::$layout = $controller->layout;
	}
}