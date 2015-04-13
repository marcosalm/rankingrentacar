<?php
class Router_Utils {
	const GLOBAL_REGEX = '\S+';
    const STANDARD_REGEX = '[^\/]{1,}';
    
	public static function prepare($string) {
        // finding named tokens
        $pattern = '/{([0-9a-zA-Z_-]+)}/';
        preg_match_all ($pattern, $string, $result);

        $result = array_filter($result);

        $string = str_replace('/', '\/', $string);

        if (sizeof($result)) {
            $tokens = current($result);
            $names = end($result);

            for ($i = 0; $i < sizeof($tokens); $i++) {
                $regex = self::STANDARD_REGEX;
                $expression = "(?'{$names[$i]}'{$regex})";
                $string = str_replace($tokens[$i], $expression, $string);
            }
        }

        $string = str_replace('*', "(" . self::GLOBAL_REGEX . "){0,}", $string);
        $string = "/^{$string}$/";

        return $string;
    }
}