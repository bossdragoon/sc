<?php

class Index extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('index/js/default.js');
        $this->view->css = array('index/css/default.css');
    }

    function index() {
        $this->view->rander('index/index');
    }

    function details() {
        $this->view->rander('index/details');
    }
    
   

}
