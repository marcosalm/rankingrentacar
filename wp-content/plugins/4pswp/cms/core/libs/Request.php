<?php
class Request {

    const POST = "POST";
    const GET = "GET";

    public static function getParameter($name) {
        if (!self::hasParameter($name)) {
            return null;
        } else {
            if (array_key_exists($name, $_REQUEST)) {
                return $_REQUEST[$name];
            }

            else if (array_key_exists($name, $_GET)) {
                return $_GET[$name];
                
            } else if (array_key_exists($name, $_POST)) {
                return $_POST[$name];
            }
        }
    }


    public static function setParameter($name, $value) {
        if (!empty($name)) {
            $_REQUEST[$name] = $value;
        }
    }


    public static function hasParameter($name) {
        return (array_key_exists($name, $_REQUEST) || array_key_exists($name, $_GET) || array_key_exists($name, $_POST));
    }


}
