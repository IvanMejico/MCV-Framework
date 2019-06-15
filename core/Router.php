<?php

class Router {
    public static function route($url) {
        // controller
        $controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]) : DEFAULT_CONTROLLER;
        $controller_name = $controller;
        array_shift($url);

        // action
        $action = (isset($url[0]) && $url[0] != '') ? $url[0] . 'Action' : 'indexAction';
        $action_name = (isset($url[0]) && $url[0] != '') ? $url[0] : 'index';
        array_shift($url);

        // acl check
        $grantAccess = self::hasAccess($controller_name, $action_name);
        if(!$grantAccess) {
            $controller_name = $controller = ACCESS_RESTRICTED;
            $action = 'indexAction';
        }

        // params
        $queryParams = $url;

        $dispatch = new $controller($controller_name, $action_name);

        if(method_exists($controller, $action)) {            
            call_user_func_array([$dispatch, $action], $queryParams);
        } else {
            die('That method does not exist in the controller "' . $controller_name . '"');
        }
    }

    public static function redirect($location) {
        if(!headers_sent()) {
            header('Location: '.PROOT.$location);
            exit();
        } else {
            echo '<script type="text/javascript">';
            echo 'window.location.href='.PROOT.$location.'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.$location.'"/>';
            echo '</noscript>';exit();
        }
    }

    public static function hasAccess($controller_name, $action_name='index') {
        $acl_file = file_get_contents(ROOT . DS . 'app' . DS . 'acl.json');
        $acl = json_decode($acl_file, true);
        $current_user_acls = ["Guest"];
        $grantAccess = true;

        if(Session::exists(CURRENT_USER_SESSION_NAME)) { // Check if user is logged in
            $current_user_acls[] = "LoggedIn";
            foreach(currentUser()->acls() as $a) {  // Retrieve acl data from database
                $current_user_acls[] = $a;
            }
        }
        
        // Checks if Guest/LoggedIn exists in the JSON file.
        // Checks if the controller name is inside
        // Check if the action name is inside
        // Grant access if satisfied 
        // dnd($current_user_acls);
        // dnd($acl['LoggedIn']);
        foreach($current_user_acls as $level) {
            if(array_key_exists($level, $acl) && array_key_exists($controller_name, $acl[$level])) {
                if(in_array($action_name, $acl[$level][$controller_name]) || in_array("*", $acl[$level][$controller_name])) {
                    $grantAccess = true;
                    break;
                }
            }
        }

        // check for denied
        foreach($current_user_acls as $level) {
            $denied = $acl[$level]['denied'];
            if(!empty($denied) && array_key_exists($controller_name, $denied) && in_array($action_name, $denied[$controller_name])) {
                $grantAccess = false; 
                break;
            }
        }
        
        return $grantAccess;
    }
}
