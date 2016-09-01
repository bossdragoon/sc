<?php

class Supply extends Controller {

    function __construct() {
        parent::__construct();

        $this->view->css = array('../public/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css',
            '../public/awesome-bootstrap-checkbox/Font-Awesome/css/font-awesome.css',
            '../public/bootstrap-datetimepicker/css/bootstrap-datepicker3.css',
            '../public/bootstrap-timepicker/css/bootstrap-timepicker.css',
            '../public/css/no-more-tables.css',
            'products/css/default.css'
        );



        $this->view->js = array('supply/js/default.js',
            '../public/bootstrap-datetimepicker/js/bootstrap-datepicker.js',
            '../public/bootstrap-datetimepicker/locales/bootstrap-datepicker.th.min.js',
            '../public/bootstrap-timepicker/js/bootstrap-timepicker.js'
        );
    }

    function index() {
        $this->view->getShift = $this->getShift();
         $this->view->getOrderType = $this->getOrderType();
        $this->view->getDepart = $this->getDepart();
        $this->view->getPersonalSupplyConsignee = $this->getPersonal();
        $this->view->getPersonalSupplyConsignor = $this->getPersonal();
        $this->view->getPersonalSupplyDivider = $this->getPersonal();
        $this->view->getPersonalSupplyConsignor2 = $this->getPersonal();
        $this->view->getItemsStatusY = $this->getItemsStatusY();
        $this->view->rander('supply/index');
    }

    function putSession() {
        //Session::set('productItems_select_form',"{$_POST['value']}");
    }

    function getListings() {
        $data = $this->model->getDataListings();
        echo json_encode($data);
    }

    function Pagination($model = NULL) {
        if ($model) {
            $this->loadModel($model);
        }
        $data = $this->model->pagination();
        echo json_encode($data);
    }

    function getSupplyByID() {
        $data = $this->model->getDataSupplyByID();
        echo json_encode($data);
    }

    function getSupplyItemsByID() {
        $data = $this->model->getDataSupplyItemsByID();
        echo json_encode($data);
    }
    
    public function getDepart() {
        $this->loadModel('depart');
        return $this->model->departRs();
    }

    public function getPersonal() {
        $this->loadModel('personal');
        return $this->model->personalRs();
    }
    
     public function getItemsStatusY() {
        $this->loadModel('items');
        return $this->model->getDataItemsStatusY();
    }

    function getShift() {
        $result = $this->model->getDataShift();
        $enumList = explode(",", str_replace("'", "", substr($result, 5, (strlen($result) - 6))));

        return $enumList;
    }
    
    function getOrderType() {
        $result = $this->model->getDataOrderType();
        $enumList = explode(",", str_replace("'", "", substr($result, 5, (strlen($result) - 6))));
        //var_dump($enumList);
        return $enumList;
    }
    
}
