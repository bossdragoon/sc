<?php

class View {

    function __construct() {
        #echo 'This is the View </br>';
    }

    public function rander($name, $noInclude = false) {
        set_time_limit(180); // this way old value 90
        ini_set('max_execution_time', 180); // or this way old value 90
        if ($noInclude == true) {
            require 'views/pagescript.php';
            require 'views/' . $name . '.php';
        } else {
            require 'views/header.php';
            require 'views/menutop.php';
            require 'views/' . $name . '.php';
            require 'views/footer.php';
        }
    }

    public function randerList($name_list, $noInclude = false) {

        //if $name_list is not array(only one value), change it
        if (is_array($name_list) == false){$name_list = array($name_list);}


        if ($noInclude == true) {
            require 'views/pagescript.php';
            foreach ($name_list as $name) {
                require 'views/' . $name . '.php';
            }
        } else {
            require 'views/header.php';
            require 'views/menutop.php';
            foreach ($name_list as $name) {
                require 'views/' . $name . '.php';
            }
            require 'views/footer.php';
        }
    }
    
    
    /*=================
     * Extract rander
     ==================*/

    public function randerHeader() {
        require 'views/header.php';
        require 'views/menutop.php';
    }
    
    public function randerFooter() {
        require 'views/footer.php';
    }
    
    public function randerScript() {
        //not require this when you have already rander header
        require 'views/pagescript.php';
    }
    
    public function randerContent($name_list) {
        if (is_array($name_list) == false){$name_list = array($name_list);}
        foreach ($name_list as $name) 
        {
            require 'views/' . $name . '.php';
        }
    }
    
//    public function randerSubDirectory($path) {
//        require 'views/' . $path . '.php';
//    }

}
