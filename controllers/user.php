<?php

class User extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('user/js/default.js'
            , '../public/bootstrap-switch/js/bootstrap-switch.min.js'
        );
        $this->view->css = array('../public/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'
            , '../public/awesome-bootstrap-checkbox/Font-Awesome/css/font-awesome.css'
            , '../public/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css'
        );
    }

    function index() {

        $this->view->getQIT = $this->getQIT();
        $this->view->getDepart = $this->getDepart();
        $this->view->getConfig = $this->getConfig();
        $this->view->rander('user/index');
    }

    function technician() {
        $this->model->technician();
    }

    function getListings() {
        $data = $this->model->getDataListings();
        echo json_encode($data);
    }

    function insertByID() {
//        $this->model->insertDataByID();
    }

    function editByID() {
//        $this->model->editDataByID();
    }

    function updatePerson() {
        $this->model->updatePersonByID();
    }

    function deleteByID() {

        $data = array('chk' => $this->checkUseByID());
        if ($data['chk']) {
            $this->model->deleteDataByID();
        }
        echo json_encode($data);
    }

    function getByID() {
        $this->model->getDataByID();
    }

    function checkUseByID() {
        return $this->model->checkDataUseByID();
    }

    public function getPerson() {
        $this->model->personalRs();
    }

    function Pagination() {
        $this->model->Pagination();
    }

    public function getVar() {
        $this->loadModel('config');
        return $this->model->getVar();
    }

    function getQIT() {
        $data = $this->model->QitRs();
        return $data;
    }

    public function getConfig() {
        $this->loadModel('config');
        $data = $this->model->configRs();
        return $data;
    }

    public function getDepart() {
        $this->loadModel('depart');
        $data = $this->model->departRs();
        return $data;
    }

}
