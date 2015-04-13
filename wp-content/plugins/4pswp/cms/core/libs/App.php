<?php
class App {
    public static function run() {	
	
        // initing context
        Context::init();

        // processing context
        try {
            self::processContext();
        }
        catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public static function processContext() {
        try {
            Router::init();
            Context::setScope();
            Controller_Manager::run();
            View_Manager::render();
        }
        catch (Exception_NotFound $e) {
            status_header('404');

            if (Context::$redirected) {
                throw new Exception("View '404' was not found.");
            }

            self::redirect(array(
                'controller' => 'pages', 'action' => '404', 'internal' => true)
            );
        }
    }

    public static function getBlogUrl() {
        return get_bloginfo('wpurl');
    }

    public static function getThemeUrl() {
        return get_bloginfo('stylesheet_directory');
    }

    public static function redirect($mixed) {
        $url = $mixed;
        if (is_array($mixed)) {
            $controller = $mixed['controller'];
            $action = $mixed['action'];
            $internal = (isset($mixed['internal'])) ?  $mixed['internal'] : false;

            if ($internal) {
                Context::$controller = $controller;
                Context::$view = $action;
                Context::$redirected = true;
                Context::$scope = 'app';
                self::processContext();
            }
            else {
                $blogUrl = self::getBlogUrl() . "/{$controller}/{$action}";
                header("location: {$blogUrl}");
            }
        } else {
            header("location: $mixed");
        }
        die();
    }
}