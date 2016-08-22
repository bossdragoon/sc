<?php

class Config extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('config/js/default.js');
        $this->view->css = array('../public/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'
            ,'../public/awesome-bootstrap-checkbox/Font-Awesome/css/font-awesome.css');        
    }

    function index() {
        $this->view->rander('config/index');
    }

    function getVar() {
        $data = $this->model->getVar();
        echo json_encode($data);
    }
    
    function getConfig() {
         $data = $this->model->configRs();
         echo json_encode($data);
    }
        
    function Pagination() {
        $this->model->Pagination();
    }

}
