<?php

class Bootstrap {

    function __construct() {

        $url = explode('/', rtrim((isset($_GET['url']) ? $_GET['url'] : null), '/'));
        #print_r($url);

        if (empty($url[0])) {
            require 'controllers/index.php';
            $controller = new Index();
            $controller->index();
            return false;
        }

        $file = 'controllers/' . $url[0] . '.php';

        if (file_exists($file)) {
            $logged = Session::get('User');
            if (sizeof($logged) > 0 || $url[0] == 'login' || $url[0] == 'about' || $url[0] == 'about') {
                require $file;
            } else {
                $this->loginFalse();
                return false;
            }
        } else {
            $this->error();
            return false;
        }

        $controller = new $url[0];
        $controller->loadModel($url[0]);
        $controller->view->pageMenu = $url[0];

        $User = Session::get('User');
        //echo 'sizeof $User := '.sizeof($User).'</br>';
        if (sizeof($User) <= 0) {
            
        }

        if (isset($url[2])) {

            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}($url[2]);
            } else {
                $this->error();
            }
        } else if (isset($url[1])) {
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}();
            } else {
                $this->error();
            }
            
//             if (sizeof($User) <= 0) {
//                $this->error();
//            } else if (method_exists($controller, $url[1])) {
//                $controller->{$url[1]}();
//            } else {
//                $this->error();
//            }
            
        } else {

            $controller->index();
        }
    }

    function error() {
        require 'controllers/error.php';
        $controller = new Error();
        $controller->index();
        return false;
    }

    function loginFalse() {
        require 'controllers/error.php';
        $controller = new Error();
        $controller->notLogin();
        return false;
    }

}
