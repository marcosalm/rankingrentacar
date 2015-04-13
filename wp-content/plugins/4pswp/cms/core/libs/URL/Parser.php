<?php
class URL_Parser {
	public static function getParams() {
		$realURI = Context::getRealURI(false);
		return explode("/", trim($realURI,"/"));
	}
}