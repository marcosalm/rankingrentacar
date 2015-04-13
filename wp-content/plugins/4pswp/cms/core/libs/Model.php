<?php
class Model {
	public function __construct($object = false) {
		if ($object)
			$this->load($object);
	}

	public function load($object, $prefix = false) {
		$usedMethods = array();
		foreach ($object as $property => $value) {
			$tokens = explode('_', $property);
			$propertyPrefix = array_shift($tokens);
			$propertyName = "set";

			foreach ($tokens as $token) {
				$propertyName .= ucfirst($token);
			}

			// ignoring properties that not match with the prefix
			if ($prefix && $propertyPrefix != $prefix)
				continue;

			if (method_exists($this, $propertyName) && !in_array($propertyName, $usedMethods)) {
				$this->$propertyName($value);
				$usedMethods[] = $propertyName;
			}
		}
	}
}