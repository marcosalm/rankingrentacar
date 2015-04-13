<?php
class View_Manager {
	public static function render() {
		$controller = Context::$controller;
		$action = Context::$view;
		$layout = Context::$layout;

		$view = new View($controller, $action, $layout);
		$view->render();
	}
}