<?php
class Config {
	public static $properties;
    
    public static function set($key, $value) {
        self::$properties[$key] = $value;
    }
    
    public static function get($key) {
        if (self::has($key))
            return self::$properties[$key];
        return false;
    }

    public static function has($key) {
    	return isset(self::$properties[$key]);
    }
}