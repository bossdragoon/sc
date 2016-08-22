<?php

class ItemsType extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('itemsType/js/default.js');
        $this->view->css = array('../public/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'
            , '../public/awesome-bootstrap-checkbox/Font-Awesome/css/font-awesome.css');
    }

    function index() {
//        $this->view->getFrequency = $this->getFrequency();
        $this->view->getStatus = $this->getStatus();
        $this->view->rander('itemsType/index');
    }

    function getListings() {
        $data = $this->model->getDataListings();
        echo json_encode($data);
    }

    function getByID() {
        $data = $this->model->getDataByID();
        echo json_encode($data);
    }

    function insertByID() {
        $this->model->insertDataByID();
    }

    function updateByID() {
        $this->model->updateDataByID();
    }

    function deleteByID() {
        $this->model->deleteDataByID();
    }

    function checkUseByID() {
        return $this->model->checkDataUseByID();
    }

    function Pagination() {
        $this->model->Pagination();
    }

    function getStatus() {
        $result = $this->model->getDataStatus();
        $enumList = explode(",", str_replace("'", "", substr($result, 5, (strlen($result) - 6))));
        return $enumList;
    }
    
}
