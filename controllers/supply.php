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

    function print_preview($supply_id) {
        $data = $this->model->getDataSupplyByIDForPDF($supply_id);
        $data2 = $this->model->getDataSupplyItemsByIDForPDF($supply_id);
        $this->view->print_preview = $data;
        $this->view->print_table = array($data2);
        //echo json_encode($data);
        //$this->view->getDataSupplyByID = $this->getSupplyByIDforPDF();
        $this->view->randerContent('supply/print_preview');
    }

    function putSession() {
        //Session::set('productItems_select_form',"{$_POST['value']}");
    }

    function getListings() {
        if (filter_input(INPUT_GET, 'user_type') === 'user') {
            $data = $this->model->getDataListingsByDepart();
        } else {
            $data = $this->model->getDataListings();
        }
        //echo filter_input(INPUT_GET, 'supply_mode');
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

    function getSupplyByIDforPDF() {
        return $this->model->getDataSupplyByID();
        //return $this->model->sqlSupply();
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

    function getOrderTypeJSon() {
        $result = $this->model->getDataOrderType();
        $enumList = explode(",", str_replace("'", "", substr($result, 5, (strlen($result) - 6))));
        echo json_encode($enumList);
    }

    function insertSupply() {
        //var_dump($_POST['arrSupplyHead']);
        //var_dump($_POST['arrSupplyItems']);

        $arrSupplyHead = $_POST['arrSupplyHead'];
        $arrSupplyItems = $_POST['arrSupplyItems'];
        $supply_id = '';
        $result = true;
        $result2 = true;
        $resultSupplyHead = true;
        $resultSupplyItems = true;

       // var_dump($arrSupplyHead);
        /*         * ** Supply *** */
        if (sizeof($_POST['arrSupplyHead']) > 0) {
           // var_dump($arrSupplyHead[0]["supply_date"]);
            $i = 1;
            foreach ($arrSupplyHead as $k => $v) {
               // var_dump($i);
                $i = $i+1;
                //echo 'supply_id:='+$v["supply_id"]+'....' ;

                if ($v["supply_id"] === "0" || $v["supply_id"] === "") {
                    //var_dump('in insertSupplyData');
                    $content = $v["supply_date"] . $v["supply_shift"] . $v["supply_depart"];
                    //var_dump($this->model->getDataSupplyIdByContent($content));
                    if ($this->model->getDataSupplyIdByContent($content) === NULL) {
                        
                        $result = $this->model->insertSupplyData($v);
                        if ($result !== false) {
                            $resultSupplyHead = $result;
                            $supply_id = $this->model->getDataSupplyIdByContent($content);
                            //var_dump('$supply_id insertSupplyData:=' + $supply_id);
                        }
                    } else {
                        //var_dump($content);
                        $resultSupplyHead = false;
                    }
                } else {
                    //var_dump('in updateSupplyData');
                    $supply_id = $v["supply_id"];
                    $result = $this->model->updateSupplyData($v);
                    if ($resultSupplyHead !== false) {
                        $resultSupplyHead = $result;
                    } else {
                        $resultSupplyHead = '';
                    }
                }
            }
        }

        /*         * ** SupplyItems *** */
        if (sizeof($_POST['arrSupplyItems']) > 0) {
            foreach ($arrSupplyItems as $k => $v) {
                if (isset($v["manage"])) {
                    $hos_guid = $v["hos_guid"];
                    $manage = strtoupper($v["manage"]);

                    if ($manage === 'NEW') {
                        $result = $this->model->insertSupplyItemsData($v, $supply_id);
                        //var_dump('insert SupplyItems supply_id:=' . $supply_id );
                        if ($resultSupplyItems !== false) {
                            $resultSupplyItems = $result;
                        }
                    } elseif ($manage === 'EDIT') {
                        $result = $this->model->updateSupplyItemsData($v, $hos_guid);
                        if ($resultSupplyItems !== false) {
                            $resultSupplyItems = $result;
                        }
                    } elseif ($manage === 'DELETE') {
                        $result = $this->model->deleteSupplyItemsDataById($v["hos_guid"]);
                        if ($resultSupplyItems !== false) {
                            $resultSupplyItems = $result;
                        }
                    }
                }
            }
        }
        if ($resultSupplyHead === true && $resultSupplyItems === true) {
            $result2 = true;
        } else {
            $result2 = false;
        }
        $data = array('resultUpdateSupply' => $result2, 'resultSupplyHead' => $resultSupplyHead, 'resultSupplyItems' => $resultSupplyItems);
        echo json_encode($data);
    }

    function insert($arrData) {
        return $this->model->insertData($arrData);
    }

}
