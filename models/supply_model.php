<?php

class Supply_Model extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function sqlSupply() {
        $keyword = filter_input(INPUT_GET, 'keyword'); //false if not set,null if filter fail
        $dept = filter_input(INPUT_GET, 'select_dept'); //false if not set,null if filter fail
        $mode = filter_input(INPUT_GET, 'supply_mode'); //false if not set,null if filter fail

        
//        $sqlCondition .= ($date ? "AND (kpi_date BETWEEN '{$date1}' AND '{$date2}') " : "");
        $sqlCondition .= ($keyword ? "AND (kpi_name LIKE '%{$keyword}%' or kpi_jobs LIKE '%{$keyword}%' or kpi_note LIKE '%{$keyword}%') " : "");
        
        switch ($mode){
            case "receive2": $sqlCondition .= "AND si.supply_items_receive2 > 0 ";
            case "divide": $sqlCondition .= "AND si.supply_items_divide > 0 ";
            case "receive": $sqlCondition .= "AND si.supply_items_receive > 0 ";
            case "send": $sqlCondition .= "AND si.supply_items_send > 0 "; 
            default : break;
            
        }
        
        $sqlCondition .= ($dept ? "AND d.depart_id = {$dept} " : "");

        $sql = 'SELECT '
                . 's.supply_id, '
                . 's.supply_date, '
                . 's.supply_depart, '
                . 's.supply_consignee, '
                . 's.supply_consignor, '
                . 's.supply_divider, '
                . 's.supply_consignor2, '
                . 's.supply_consignee_time, '
                . 's.supply_consignor_time, '
                . 's.supply_divider_time, '
                . 's.supply_consignor2_time, '
                . 'si.supply_items_id, '
                . 'si.supply_items_send, '
                . 'si.supply_items_receive, '
                . 'si.supply_items_divide, '
                . 'si.supply_items_remain, '
                . 'si.supply_items_description, '
                . 'si.items_id, '
                . 'i.items_name, '
                . 'i.items_type, '
                . 'it.items_type_name, '
                . 'd.depart_name'
                . ' FROM'
                . ' supply AS s'
                . ' LEFT OUTER JOIN supply_items AS si ON s.supply_id = si.supply_id'
                . ' LEFT OUTER JOIN items AS i ON si.items_id = i.items_id'
                . ' LEFT OUTER JOIN items_type AS it ON i.items_type = it.items_type_id'
                . ' LEFT OUTER JOIN supply_depart AS d ON s.supply_depart = d.depart_id'
                . ' WHERE 1 ' . $sqlCondition
                . ' GROUP BY s.supply_id DESC'
                . ' ORDER BY s.supply_date DESC';

        return $sql;
    }

    public function pagination() {
        $perPage = filter_input(INPUT_GET, 'perPage'); //false if not set,null if filter fail

        $sql = $this->sqlSupply();

        $sth = $this->db->prepare($sql);
        $sth->execute();
        $row = $sth->rowCount();
        $data = array('allPage' => ceil($row / $perPage));
        return $data;
    }

    public function sqlLIMIT() {

//        $curPage = $_GET['curPage'];
//        $perPage = $_GET['perPage'];
        $curPage = filter_input(INPUT_GET, 'curPage'); //false if not set,null if filter fail
        $perPage = filter_input(INPUT_GET, 'perPage'); //false if not set,null if filter fail


        if ($curPage > 0) {
            $limit = " LIMIT " . (($curPage * $perPage) - $perPage) . ", {$perPage} ";
        } else {
            $limit = ($perPage) ? " LIMIT {$perPage} " : '';
        }

        return $limit;
    }

    function getDataListings() {
        $limit = $this->sqlLIMIT();

        $sql = $this->sqlSupply();
        $sql = $sql . $limit;
        $data = $this->db->select($sql);
        
        return $data;
    }    
    
    
    
    
    
    
    

//    public function Pagination() {
//        $word = explode(' ', $_POST['search']);
//        if ($_POST['search']) {
//            foreach ($word as $value) {
//                $condition .= " and concat(p.items_name,p.items_type,p.items_formula) like '%{$value}%' ";
//            }
//        } else {
//            $condition = '';
//        }
//
//        if ($_POST['form_code']) {
//            $condition .= " and p.items_form = '{$_POST['form_code']}' ";
//        }
//
//        if ($_POST['curPage'] > 0) {
//            $limit = " limit " . (($_POST['curPage'] * $_POST['perPage']) - $_POST['perPage']) . ", {$_POST['perPage']} ";
//        } else {
//            $limit = ($_POST['perPage']) ? " limit {$_POST['perPage']} " : '';
//        }
//
//        $sql = "SELECT p.*
//                FROM product_items p
//                WHERE 1 {$condition}
//                Order by p.items_code
//                ";
//
//        //echo $sql;
//        $sth = $this->db->prepare($sql);
//        $sth->execute();
//        $row = $sth->rowCount();
//        $data = array('allPage' => ceil($row / $_POST['perPage']),"rowCount" => $row);
//        echo json_encode($data);
//    }
//
//    public function getDataListings() {
//
//        $condition = '';
//        $word = explode(' ', $_GET['search']);
//        if ($_GET['search']) {
//            foreach ($word as $value) {
//                $condition .= " and concat(p.items_name,p.items_type,p.items_formula) like '%{$value}%' ";
//            }
//        }
//
//        if ($_GET['form_code']) {
//            $condition .= " and p.items_form = '{$_GET['form_code']}' ";
//        }
//
//        if ($_GET['curPage'] > 0) {
//            $limit = " limit " . (($_GET['curPage'] * $_GET['perPage']) - $_GET['perPage']) . ", {$_GET['perPage']} ";
//        } else {
//            $limit = ($_GET['perPage']) ? " limit {$_GET['perPage']} " : '';
//        }
//
//        $sql = "SELECT p.*
//                from product_items p 
//                WHERE 1 {$condition} 
//                ORDER BY p.items_form, p.items_index
//                {$limit} ";
//
//        //echo $sql;
//        $data = $this->db->select($sql);
//        return $data;
//    }
//
//    public function getFormStatus($Status = 'Y') {
//
//        $sql = "SELECT p.form_code, p.form_name
//                from product_items p 
//                WHERE 1 
//                and p.status = '{$Status}'
//                ORDER BY p.INDEX
//                ";
//        // echo $sql;
//        $data = $this->db->select($sql);
//        return $data;
//    }
//
//    function getDataByID() {
//        $sql = "SELECT p.* 
//                from product_items p 
//                WHERE p.items_code = '{$_GET['id']}' ";
//
//        $data = $this->db->select($sql);
//        return $data;
//    }
//
//    function getDataItemsIndex() {
//        $event = '';
//        if($_GET['event'] === 'up'){
//            $event = '-';
//        }else{
//            $event = '+';
//        }
//        $sql = "SELECT product_items.*
//                from product_items
//                where 1=1
//                and items_form = '{$_GET['items_form']}'
//                and items_index in (({$_GET['index']}{$event}1),'{$_GET['index']}')
//                ORDER BY items_index ";
//                
//        //echo $sql;
//        $data = $this->db->select($sql);
//        return $data;
//    }
//    
//     function getDataItemsIndexOver() {
//        $event = '';
//        if($_GET['event'] === 'del'){
//            $event = '>';
//        }else{
//            $event = '>=';
//        }
//       
//        $sql = "SELECT product_items.*
//                from product_items
//                where 1=1
//                and items_form = '{$_GET['items_form']}'
//                and items_index {$event}' {$_GET['index']}'
//                ORDER BY items_index ";
//                
//        //echo $sql;
//        $data = $this->db->select($sql);
//        return $data;
//    }
//    
//    function newIndex($items_form) {
//        $sql = "SELECT if(MAX(items_index) is NULL,1,MAX(items_index)+1 ) as items_index FROM product_items WHERE items_form = '{$items_form}' ";
//        $data = $this->db->select($sql);
//        return $data[0]['items_index'];
//    }
//
//    function newItemsCode($items_form) {
//        $sql = "SELECT if(MAX(items_code) is NULL,concat('{$items_form}','C00',1),concat('{$items_form}','C',LPAD(RIGHT(MAX(items_code),3)+1,3,0))) as items_code FROM product_items WHERE items_form = '{$items_form}' ";
//        $data = $this->db->select($sql);
//        return $data[0]['items_code'];
//    }
//
//    function getType() {
//        $sql = 'SHOW COLUMNS FROM product_items WHERE Field  = "items_type"';
//        $data = $this->db->select($sql);
//        return $data[0]['Type'];
//    }
//
//    function getInputReadonly() {
//        $sql = 'SHOW COLUMNS FROM product_items WHERE Field  = "items_form_input_readonly"';
//        $data = $this->db->select($sql);
//        return $data[0]['Type'];
//    }
//
//    function getFormInput() {
//        $sql = 'SHOW COLUMNS FROM product_items WHERE Field  = "items_form_input"';
//        $data = $this->db->select($sql);
//        return $data[0]['Type'];
//    }
//
//    function getDataFontBold() { //getFontBold
//        $sql = 'SHOW COLUMNS FROM product_items WHERE Field  = "items_font_bold"';
//        $data = $this->db->select($sql);
//        return $data[0]['Type'];
//    }
//
//    
//    function getDataNotNull() {
//        $sql = 'SHOW COLUMNS FROM product_items WHERE Field  = "items_not_null"';
//        $data = $this->db->select($sql);
//        return $data[0]['Type'];
//    }
//    
//    function getStatus() {
//        $sql = 'SHOW COLUMNS FROM product_items WHERE Field  = "items_status"';
//        $data = $this->db->select($sql);
//        return $data[0]['Type'];
//    }
//
//    public function insertDataByID() {
//
//        $items_code = $this->newItemsCode($_POST['items_form']);
//
//        if (($items_code < 0) Or ( $items_code === NULL)) {
//            $items_code = 1;
//        }
//
//        if (($_POST['items_index'] < 0) Or ( $_POST['items_index'] === "")) {
//            $items_index = $this->newIndex($_POST['items_form']);
//            if (($items_index < 0) Or ( $items_index === NULL)) {
//                $items_index = 1;
//            }
//        } else {
//            $items_index = $_POST['items_index'];
//        }
//
//        $sql = 'INSERT '
//                . 'INTO product_items (items_code, items_name, items_type, items_formula, items_form, items_form_input, items_form_input_readonly, items_font_bold, items_code_number, items_index, items_status, create_date) '
//                . 'VALUES (:items_code, :items_name, :items_type, :items_formula, :items_form, :items_form_input, :items_form_input_readonly, :items_font_bold, :items_code_number, :items_index, :items_status, :create_date)';
//        $sth = $this->db->prepare($sql);
//
//        $sth->execute(array(
//            ':items_code' => $items_code,
//            ':items_name' => $_POST['items_name'],
//            ':items_type' => $_POST['items_type'],
//            ':items_formula' => $_POST['items_formula'],
//            ':items_form' => $_POST['items_form'],
//            ':items_form_input' => $_POST['items_form_input'],
//            ':items_form_input_readonly' => $_POST['items_form_input_readonly'],
//            ':items_font_bold' => $_POST['items_font_bold'],
//            ':items_code_number' => NULL,
//            ':create_date' => date('Y-m-d h:i:s'),
//            ':items_index' => $items_index,
//            ':items_status' => $_POST['items_status']
//        )); //':items_code_number' => $_POST['items_code_number'],
//        //print_r($sth->errorInfo());
//        $errorInfo = $sth->errorInfo();
//        if ($errorInfo[0] === '00000') {
//            $chk = true;
//        } else {
//            $chk = false;
//        }
//
//        $data = array('sta' => 'add', 'result' => $chk);
//        echo json_encode($data);
//    }
//
//    public function updateDataByID() {
//        $sql = 'UPDATE product_items '
//                . 'SET items_name = :items_name '
//                . ',items_type = :items_type '
//                . ',items_formula = :items_formula '
//                . ',items_form = :items_form '
//                . ',items_form_input = :items_form_input '
//                . ',items_form_input_readonly = :items_form_input_readonly '
//                . ',items_font_bold = :items_font_bold '
//                . ',items_code_number = :items_code_number '
//                . ',items_last_update = :items_last_update '
//                . ',items_index = :items_index '
//                . ',items_status = :items_status '
//                . ' WHERE items_code = :items_code ';
//        //echo $sql;
//        $sth = $this->db->prepare($sql);
//
//        $sth->execute(array(
//            ':items_code' => $_POST['items_code'],
//            ':items_name' => $_POST['items_name'],
//            ':items_type' => $_POST['items_type'],
//            ':items_formula' => $_POST['items_formula'],
//            ':items_form' => $_POST['items_form'],
//            ':items_form_input' => $_POST['items_form_input'],
//            ':items_form_input_readonly' => $_POST['items_form_input_readonly'],
//            ':items_font_bold' => $_POST['items_font_bold'],
//            ':items_code_number' => $_POST['items_code_number'],
//            ':items_last_update' => date('Y-m-d h:i:s'),
//            ':items_index' => $_POST['items_index'],
//            ':items_status' => $_POST['items_status']
//        ));
//
//        //print_r($sth->errorInfo());
//        $errorInfo = $sth->errorInfo();
//        if ($errorInfo[0] === '00000') {
//            $chk = true;
//        } else {
//            $chk = false;
//        }
//
//        $data = array('sta' => 'update', 'result' => $chk);
//        echo json_encode($data);
//    }
//
//    function deleteDataByID() {
//        if ($this->checkDataUseByID() === false) {
//            $data = array('sta' => 'delete', 'result' => false);
//        } else {
//            $sql = 'DELETE FROM product_items WHERE items_code = "' . $_POST['id'] . '" ';
//            //$sql = '';
//            $sth = $this->db->prepare($sql);
//            $sth->execute();
//            $errorInfo = $sth->errorInfo();
//            if ($errorInfo[0] === '00000') {
//                $chk = true;
//            } else {
//                $chk = false;
//            }
//            $data = array('sta' => 'delete', 'result' => $chk);
//        }
//
//        echo json_encode($data);
//    }
//
//    public function upDataItemsIndex() {
//               
//        if ($_POST['event'] === 'up') {
//            $event_items_index = ($_POST['index']*1) + 1;
//        } else {
//            $event_items_index = ($_POST['index']*1) - 1;
//        }
//        $sql = 'UPDATE product_items '
//                . 'SET items_last_update = :items_last_update '
//                . ',items_index = :items_index '
//                . ' WHERE items_code = :items_code ';
//        //echo $sql;
//        $sth = $this->db->prepare($sql);
//
//        $sth->execute(array(
//            ':items_code' => $_POST['id'],
//            ':items_last_update' => date('Y-m-d h:i:s'),
//            ':items_index' => $event_items_index
//        ));
//
//        //print_r($sth->errorInfo());
//        $errorInfo = $sth->errorInfo();
//        if ($errorInfo[0] === '00000') {
//            $chk = true;
//        } else {
//            $chk = false;
//        }
//
//        $data = array('sta' => 'update', 'result' => $chk,'index' => $_POST['index']);
//        echo json_encode($data);
//    }
//
//    function checkDataUseByID() {
//        $sql = "SELECT  items_code as items_code FROM product_data WHERE items_code = '{$_POST['id']}' ";
//        //echo $sql;
//        $sth = $this->db->prepare($sql);
//        $sth->execute();
//        if ($sth->rowCount() > 0) {
//            return false;
//        } else {
//            return true;
//        }
//    }

}
