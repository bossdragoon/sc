<?php

//    make by Shikaru 
class Login extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('login/js/default.js');
    }

    function index() {
        $this->view->rander('login/index',true);
    }

    function run() {
        $this->model->dataRun();
    }

    function logout() {
        Session::destroy();
        header('location: ' . URL . 'index');
        exit();
    }

}
