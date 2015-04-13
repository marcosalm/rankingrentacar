<?php
class Loader {

    static $paths = array(CORE_LIBS_PATH);

    public static function loadClass($class) {
        $classPath = str_replace('_', DS, $class);
        $params = explode(DS, $classPath);
        $className = end($params);

        if (!class_exists($class)) {
            $tokens = explode("_", $class);
            $suffix = end($tokens);

            /* 
            Controller Exception
            */
            if (sizeof($tokens) == 2 || sizeof($tokens) == 3) {
                if (strtolower($suffix) == 'controller') {
                    // fixing cms scope cases
                    if (sizeof($tokens) == 3) {
                        $prefix = current($tokens);
                        $class = trim(str_replace(" Cms_", "", " {$class}"));
                    }

                    $filename = strtolower($class).".php";
                    $filePath = Context::getScopePath() . DS . 'controllers' . DS . $filename;
                    
                    if (file_exists($filePath)) {
                        include($filePath);
                        return;
                    }
                }
            }

            /* 
            Component Exception 
            */
            $componentPriority = array(CORE_COMPONENTS_PATH, APP_COMPONENTS_PATH);
            if (sizeof($tokens) == 2) {
                if (strtolower($suffix) == 'component') {
                    foreach ($componentPriority as $componentPath) {
                        $filename = strtolower("{$class}.php");
                        $filePath = $componentPath . DS . $filename;

                        if (file_exists($filePath)) {
                            include($filePath);
                            return;
                        }
                    }
                }
            }

            /* 
            Model Exception 
            */
            $modelPriority = array(CORE_MODELS_PATH, APP_MODELS_PATH);

            foreach ($modelPriority as $modelPath) {
                $filename = "{$class}.php";
                $filePath = $modelPath . DS . $filename;

                if (file_exists($filePath)) {
                    // checking if the model is reserved
                    $libPath = CORE_LIBS_PATH . DS . $filename;
                    if (file_exists($libPath))
                        die("The name '{$class}' used by model is reserved. Change it.");

                    include($filePath);
                    return;
                }
            }

            // default loader
            foreach (self::$paths as $path) {
                $filePath = $path . DS . "{$classPath}.php";
                if (file_exists($filePath)) {
                    include_once($filePath);
                }
            }
        } 
    }
}