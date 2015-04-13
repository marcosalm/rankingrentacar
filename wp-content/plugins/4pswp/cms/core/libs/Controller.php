<?php
class Controller {
	private $sets = array();
	public $uses = array();

	public function set($key, $value) {
		$this->sets[$key] = $value;
	}

	public function getSets() {
		return $this->sets;
	}

	public function __construct() {
		if ( method_exists($this, 'beforeFilter') ) {
			$this->beforeFilter();
		}

		$classModelName = ucfirst( current( explode( "_", get_class($this) ) ) );
		if ( !is_array($this->uses) && is_string($this->uses) ) { 
			$this->uses = array($this->uses); 
		}

		if ( !in_array($classModelName, $this->uses) ) {
			if ( class_exists($classModelName) ) {
				$this->uses[] = $classModelName;
			}
		}
	}

	public function __get($modelName) {
		if ( !is_array($this->uses) && is_string($this->uses) ) { 
			$this->uses = array($this->uses); 
		}

		if ( in_array($modelName, $this->uses) ) {
			if ( class_exists($modelName) ) {
				$model = new $modelName();
				return $model;
			}
		}
		
		// Erro original
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $modelName .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE
        );

        return null;
	}
}