<?php

class Controller {

    function __construct() {
        //echo 'Main Controllers </br>';
        $User = Session::get('User');
        //echo 'sizeof $User := '.sizeof($User).'</br>';
        //if (sizeof($User) <= 0) {} 
        
        $this->view = new View();
        
        
    }
    

    public function loadModel($name) {

        $path = 'models/' . $name . '_model.php';
        if (file_exists($path)) {
            require_once $path;

            $modelName = $name . '_Model';
            $this->model = new $modelName();
        }
    }

    public function unloadModel() {
//        $modelName = $name . '_Model';
        unset($this->model);
    }

}
