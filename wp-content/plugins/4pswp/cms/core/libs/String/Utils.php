<?php

class String_Utils {

    public static function strLeft($s1, $s2) {
        return substr($s1, 0, strpos($s1, $s2));
    }

    public static function urldecode($string) {
        return urldecode($string);
    }

    public static function validateEmail($email) {
        if(preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(\.[[:lower:]]{2,3})(\.[[:lower:]]{2})?$/", $email)) {
    		return true;
    	} else{
    		return false;
    	}
    }

    public static function toCamelcase($string, $token = '_') {
        $string = str_replace($token, ' ', $string);

        $tokens = explode(' ', $string);
        $firstWord = array_shift($tokens);

        $result = $firstWord;
        foreach ($tokens as $word) {
            $result .= ucfirst($word);
        }

        return $result;
    }
}

