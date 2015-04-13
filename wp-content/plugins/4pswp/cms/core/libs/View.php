<?php
class View {

	private $name;
	private $controller;
	private $layout;

	public function getName() {
	    return $this->name;
	}
	
	public function setName($newName) {
	    $this->name = $newName;
	}

	public function getController()	{
	    return $this->controller;
	}
	
	public function setController($newController) {
	    $this->controller = $newController;
	}

	public function getLayout()	{
	    return $this->layout;
	}

	public function setLayout($newLayout) {
	    $this->layout = $newLayout;
	}

	public function __construct($controller = false, $name = false, $layout = false) {
		if ($controller) $this->controller = $controller;
		if ($name) $this->name = $name;
		if ($layout) $this->layout = $layout;
	}

	public function render() {
		$controller = Controller_Manager::getInstance();

		if (method_exists($controller, 'beforeRender'))
			$controller->beforeRender();

		// rendering view
		$layout = $this->layout;

		// mounting var sets scope
		foreach ($controller->getSets() as $name => $value) {
			global $$name;
			$$name = $value;
		}

		status_header("200");

		// getting view content
		$content_for_layout = $this->getContent();

		if (!empty($layout)) {
			$layoutPath = Context::getScopePath() . DS . 'views' . DS . 'layouts' . DS . $layout . VIEW_EXT;
			if (file_exists($layoutPath))
				include $layoutPath;
			else
				throw new Exception("O arquivo '{$layoutPath} não foi encontrado.'");
		}
		else {
			echo $content_for_layout;
		}

		if (method_exists($controller, 'afterRender'))
			$controller->afterRender();
	}

	public function getContent() {
		$view = new View();
		return $view->readContent($this->controller, $this->name);
	}

	public function readContent($directory, $name, $data = array()) {

		// TODO view hierarchy
		$filename = $name . VIEW_EXT;
		$viewPath = Context::getScopePath() . DS . 'views' . DS . $directory . DS . $filename;

		$controller = Controller_Manager::getInstance();
		// mounting var sets scope
		foreach ($controller->getSets() as $name => $value) {
			global $$name;
			$$name = $value;
		}

		if ( is_array($data) && count($data) > 0 ) {
			foreach($data as $var => $v) {
				global $$var;
				$$var = $v;
			}
		}

		if (file_exists($viewPath)) {
			ob_start();
			include $viewPath;
			return ob_get_clean();
		}

		throw new Exception_ViewNotFound("O arquivo '{$viewPath}' não foi encontrado.");
	}

	// View scope functions
	public function element($name, $data = array()) {
		$view = new View();
		return $view->readContent('elements', $name, $data);
	}
}