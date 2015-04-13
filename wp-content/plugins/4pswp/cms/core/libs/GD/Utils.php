<?php
class GD_Utils {
	public static function encodePath($path) {
		return base64_encode($path);
	}
	public static function decodePath($path) {
		return base64_decode($path);
	}
	public static function parseURI($url) {
        return str_replace(GD_BASE_URL, '', $url);
    }
}