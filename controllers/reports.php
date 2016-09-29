<?php

//    make by Shikaru 
class Reports extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->css = array('../public/bootstrap-datetimepicker/css/bootstrap-datepicker3.css',
            '../public/css/no-more-tables.css',
            'reports/css/default.css'
        );
        $this->view->js = array('reports/js/default.js',
            '../public/bootstrap-datetimepicker/js/bootstrap-datepicker.js',
            '../public/bootstrap-datetimepicker/locales/bootstrap-datepicker.th.min.js',
            '../public/tableexport/tableExport.js',
            '../public/tableexport/jquery.base64.js',
            '../public/tableexport/html2canvas.js',
            '../public/tableexport/jspdf/libs/base64.js',
            '../public/tableexport/jspdf/libs/sprintf.js',
            '../public/tableexport/jspdf/jspdf.js'
        );
    }

    function index() {
        $this->view->getDepart = $this->getDepart();
        $this->view->rander('reports/index');
    }

    function template($report) {        
       // if($report == 'TechnicianPerformance' || $report == 'RepairPerMonthTechnicianPerformance'){
        //    $this->view->detailStatus = $this->detailStatus();
        //}
        
        $data = $this->model->$report();
        //for ($i = 0; $i < sizeof($data); $i++) {
         //   $valname = $this->getPersonNameById($data[$i]['person_id']);
        //    $data[$i]['person_name'] = $valname[0]['prefix'] . $valname[0]['firstname'] . ' ' . $valname[0]['lastname'];
        //}
        $this->view->arrReport = $data;
        return $this->view->randerContent('reports/template/r' . $report);
    }

    function detailStatus() {
        return $this->model->ServiceDetailStatus();
    }

    function Export($type) {
        $this->view->randerContent("reports/{$type}");
    }
    
    function showSummary() {
        $data = $this->model->SummaryShowIndex();
      return $data;
    }

    //create by shikaru 15-09-2558
    public function getPersonNameById($person_id) {
        $this->loadModel('technician');
        return $this->model->getPersonNameById($person_id);
    }
    
    public function getDepart() {
        $this->loadModel('depart');
        return $this->model->departRs();
    }

}
