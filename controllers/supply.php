<?php

class Supply extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('supply/js/default.js');
        $this->view->css = array('../public/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'
            , '../public/awesome-bootstrap-checkbox/Font-Awesome/css/font-awesome.css');

    }

    function index() {
        $this->view->getDepart = $this->getDepart();
//        $this->view->getInputReadonly = $this->getInputReadonly();
//        $this->view->getFormInput = $this->getFormInput();
//        $this->view->getFontBold = $this->getFontBold();
//        $this->view->getNotNull = $this->getNotNull();
//        $this->view->getStatus = $this->getStatus();
//        $this->view->getFormStatusY = $this->getFormStatus();
        $this->view->rander('supply/index');
    }

    function putSession() {
        //Session::set('productItems_select_form',"{$_POST['value']}");
    }

    function getListings() {
        $data = $this->model->getDataListings();
        echo json_encode($data);
    }
//
//    function getByID() {
//        $data = $this->model->getDataByID();
//        echo json_encode($data);
//    }
//
//    function insertByID() {
//        $this->model->insertDataByID();
//    }
//
//    function updateByID() {
//        $this->model->updateDataByID();
//    }
//
//    function deleteByID() {
//        $this->model->deleteDataByID();
//    }
//
//    function checkUseByID() {
//        return $this->model->checkDataUseByID();
//    }
//
//    /*
//      public function newCode() {
//      $this->model->newItemsCode();
//      }
//     */
//
    function Pagination($model = NULL) {
        if ($model) {
            $this->loadModel($model);
        }
        $data = $this->model->pagination();
        echo json_encode($data);
    }
//
    
    public function getDepart() {
        $this->loadModel('depart');
        return $this->model->departRs();
    }

//    function getType() {
//        $result = $this->model->getType();
//        $enumList = explode(",", str_replace("'", "", substr($result, 5, (strlen($result) - 6))));
//        return $enumList;
//    }
//
//    function getInputReadonly() {
//        $result = $this->model->getInputReadonly();
//        $enumList = explode(",", str_replace("'", "", substr($result, 5, (strlen($result) - 6))));
//        return $enumList;
//    }
//
//    function getFormInput() {
//        $result = $this->model->getFormInput();
//        $enumList = explode(",", str_replace("'", "", substr($result, 5, (strlen($result) - 6))));
//        return $enumList;
//    }
//
//    function getFontBold() {
//        $result = $this->model->getDataFontBold();
//        $enumList = explode(",", str_replace("'", "", substr($result, 5, (strlen($result) - 6))));
//        return $enumList;
//    }
//
//    function getNotNull() {
//        $result = $this->model->getDataNotNull();
//        $enumList = explode(",", str_replace("'", "", substr($result, 5, (strlen($result) - 6))));
//        return $enumList;
//    }
//    
//    function getStatus() {
//        $result = $this->model->getStatus();
//        $enumList = explode(",", str_replace("'", "", substr($result, 5, (strlen($result) - 6))));
//        return $enumList;
//    }
//
//    public function getFormStatus() {
//        $this->loadModel('productForm');
//        return $this->model->getDataFormStatus('Y');
//    }
//
//    public function upItemsIndex() {
//        $this->model->upDataItemsIndex();
//    }
//
//     public function getItemsIndex() {
//        $data = $this->model->getDataItemsIndex();
//        echo json_encode($data);
//        
//    }
//    
//     public function getItemsIndexOver() {
//        $data = $this->model->getDataItemsIndexOver();
//        echo json_encode($data);
//        
//    }
    
}
