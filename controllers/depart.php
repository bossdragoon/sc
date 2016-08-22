<?php

class Depart extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('depart/js/default.js');
        $this->view->css = array('../public/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'
            ,'../public/awesome-bootstrap-checkbox/Font-Awesome/css/font-awesome.css');        
    }

    function index() {
        $this->view->rander('depart/index');
    }

    function getListings() {
        $this->model->getDataListings();
    }

    function insertByID() {
        $this->model->insertDataByID();
    }

    function editByID() {
        $this->model->editDataByID();
    }
    
    function deleteByID() {
        
        $data = array('chk' => $this->checkUseByID());
        if ($data['chk']) {
            $this->model->deleteDataByID();
        }
        echo json_encode($data);
        
    }
function getDepartNameByID() {
        $data = $this->model->getDataDepartNameByID();
        echo json_encode($data);
        
    }
    
    function getByID() {
        $this->model->getDataByID();
    }

    function checkUseByID() {
       return $this->model->checkDataUseByID();
    }
    
    function Pagination() {
        $this->model->Pagination();
    }

}
