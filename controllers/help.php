<?php

class Help extends Controller {

    function __construct() {
        parent::__construct();
    }
    
    function index(){
        $this->view->rander('help/index');        
    }

    public function other($arg = false) {
        
        require 'models/help_model.php';
        $model = new Help_Model();        
        $this->view->blah = $model->blah();
    }

}