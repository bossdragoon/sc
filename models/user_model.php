<?php

class User_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getDataListings() {
        $subQuery = (($_GET['person_id'] == '') ? '' : " and p.person_id = '{$_GET['store_type_id']}' ");
        $word = explode(' ', $_GET['search']);
        if ($_GET['search']) {
            foreach ($word as $value) {
                $subQuery .= " and concat(p.person_id,pf.prefix_name,p.person_firstname,person_lastname,o.ward_name) like '%{$value}%' ";
            }
        }
        if ($_GET['curPage'] > 0) {
            $limit = " limit " . (($_GET['curPage'] * $_GET['perPage']) - $_GET['perPage']) . ", {$_GET['perPage']} ";
        } else {
            $limit = ($_GET['perPage']) ? " limit {$_GET['perPage']} " : '';
        }
        $data = $this->db_user->select("
                SELECT p.person_id ,pf.prefix_name as prefix,p.person_firstname as firstname,person_lastname as lastname
                       ,o.ward_name as office,p.Supply_system
                FROM personal p
                LEFT OUTER JOIN prefix pf ON pf.prefix_id = p.person_prefix
                LEFT OUTER JOIN office_sit o ON o.ward_id = p.office_id
                WHERE 1 {$subQuery} order by o.ward_name
                {$limit} ");
        return $data;
    }

//    public function insertDataByID() {
//        $sth = $this->db->prepare('INSERT INTO technician (technician_cid, technician_status) 
//                                    SELECT :technician_cid, technician_status ');
//
//        $sth->execute(array(
//            ':technician_cid' => $_POST['technician_cid'],
//            ':technician_status' => 'Y'
//        ));
//    }
//
//    public function editDataByID() {
//        $sql = 'UPDATE technician  SET technician_cid = :technician_cid, technician_status= :technician_status WHERE technician_cid = "' . $_POST['id'] . '" ';
//        $sth = $this->db->prepare($sql);
//        $sth->execute(array(
//            ':technician_cid' => $_POST['technician_cid'],
//            ':technician_status' => $_POST['tech_status']
//        ));
//    }

    public function updatePersonByID() {
        $Supply_system = implode("",$_POST["Supply_system"]);
        //echo var_dump($Supply_system);
        $sth = $this->db_user->prepare("SELECT * FROM personal WHERE person_id = '{$_POST['person_id']}'");
        $sth->execute();

        if ($sth->rowCount() > 0) {
            $sql = "UPDATE personal SET  office_id = :office_id, productivity_depart_id = :productivity_depart_id, Supply_system = :Supply_system WHERE person_id = :person_id ";
        } 

        $sth1 = $this->db_user->prepare($sql);
        $sth1->execute(array(
            ':person_id' => $_POST['person_id'],
            ':office_id' => $_POST['office_id'],
            ':productivity_depart_id' => $_POST['productivity_depart_id'],
            ':Supply_system' => $Supply_system
        ));
        
        $errorInfo = $sth->errorInfo();
        if ($errorInfo[0] === '00000') {
            $chk = true;
        } else {
            $chk = false;
        }

        $data = array('sta' => 'update', 'result' => $chk);
        echo json_encode($data);
    }

    function deleteDataByID() {
        $sth = $this->db->prepare('DELETE FROM technician WHERE technician_cid = "' . $_POST['id'] . '" ');
        $sth->execute();
    }

    function getDataByID() {
        //$technician = $this->db->select("SELECT technician_cid,technician_status FROM technician WHERE technician_cid = '{$_POST['id']}'");
        $person = $this->db_user->select("SELECT p.person_id, p.office_id, pf.prefix_name as prefix, p.person_firstname as firstname, person_lastname as lastname, p.Supply_system, productivity_depart_id
                FROM personal p
                LEFT OUTER JOIN prefix pf ON pf.prefix_id = p.person_prefix
                WHERE p.person_id = '{$_POST['id']}' ");
        echo json_encode($person);
    }

    function checkDataUseByID() {
        $sth = $this->db->prepare("SELECT * FROM service WHERE service_technician = '{$_POST['id']}'");
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    function searchDataByID() {
        $sth = $this->db_user->prepare("SELECT * FROM personal WHERE person_id like '%{$_POST['technician_cid']}%' ORDER BY person_firstname");
        $sth->execute();
    }

    //create by komsan 09/06/2558
    function getPersonalByID() {
        $data = $this->db_user->select("SELECT p.person_id as technician_cid,p.person_id,pf.prefix_name as prefix,p.person_firstname as firstname,person_lastname as lastname
                ,p.person_prefix AS prefixID,p.person_photo AS photo,p.office_id AS officeID,p.position_id AS positionID
                FROM personal p
                LEFT OUTER JOIN prefix pf ON pf.prefix_id = p.person_prefix
                WHERE p.person_id = '{$_POST['person_id']}'");
        echo json_encode($data);
    }

    //create by Shikaru 09/06/2558
    function getPersonNameById($person_id = null) {
        $person_id = (is_null($person_id)) ? $_POST['person_id'] : $person_id;
        $data = $this->db_user->select("SELECT p.person_id as technician_cid,p.person_id,pf.prefix_name as prefix,p.person_firstname as firstname,person_lastname as lastname
                ,p.person_prefix AS prefixID,p.person_photo AS photo,p.office_id AS officeID,p.position_id AS positionID
                FROM personal p
                LEFT OUTER JOIN prefix pf ON pf.prefix_id = p.person_prefix
                WHERE p.person_id = '{$person_id}'");
        return $data;
    }

    public function personalRs() {
        $word = explode(' ', $_GET['search']);
        if ($_GET['search']) {
            foreach ($word as $value) {
                $subQuery .= " and concat(p.person_id,p.person_firstname,p.person_lastname,o.ward_name) like '%{$value}%' ";
            }
        } else {
            $subQuery = '';
        }
        if ($_GET['curPage'] > 0) {
            $limit = " limit " . (($_GET['curPage'] * $_GET['perPage']) - $_GET['perPage']) . ", {$_GET['perPage']} ";
        } else {
            $limit = ($_GET['perPage']) ? " limit {$_GET['perPage']} " : '';
        }
        $data = $this->db_user->select("SELECT p.person_id,px.prefix_name as pname,p.person_firstname as fname,p.person_lastname as lname,o.ward_name as office
                FROM personal p
                LEFT OUTER JOIN office_sit o on o.ward_id = p.office_id
                LEFT OUTER JOIN prefix px on px.prefix_id = p.person_prefix
                WHERE 1 {$subQuery} order by p.person_firstname {$limit}");
        echo json_encode($data);
//        return $data;
    }

    public function prefixRs() {
        $data = $this->db_user->select("SELECT * FROM prefix");
        return $data;
    }

    public function positionRs() {
        $data = $this->db_user->select("SELECT '0' as order_id ,position_id,position_name FROM position WHERE position_id = 1
            UNION SELECT '1' as order_id ,position_id,position_name FROM position WHERE position_id <> 1
            ORDER BY order_id,position_id ASC");
        return $data;
    }

    public function officeRs() {
        $data = $this->db_user->select("SELECT '0' as order_id ,ward_id,ward_name FROM office_sit WHERE ward_id = 1
                 UNION SELECT '1' as order_id ,ward_id,ward_name FROM office_sit WHERE ward_id <> 1
                 ORDER BY order_id, ward_name ASC");
        return $data;
    }

     public function QitRs() {
         $sql = "SELECT '0' as order_id , ward_id , ward_name FROM office_sit WHERE ward_id = 1
                 UNION SELECT '1' as order_id ,ward_id,ward_name FROM office_sit WHERE ward_id <> 1
                 ORDER BY order_id, ward_name ASC";
         
          return $this->db_user->select($sql);
    }
    
    public function Pagination() {
        $word = explode(' ', $_POST['search']);
        if ($_POST['search']) {
            foreach ($word as $value) {
                $subQuery .= " and concat(p.person_id,p.person_firstname,p.person_lastname,o.ward_name) like '%{$value}%' ";
            }
        } else {
            $subQuery = '';
        }
        if ($_POST['curPage'] > 0) {
            $limit = " limit " . (($_POST['curPage'] * $_POST['perPage']) - $_POST['perPage']) . ", {$_POST['perPage']} ";
        } else {
            $limit = ($_POST['perPage']) ? " limit {$_POST['perPage']} " : '';
        }
        $sth = $this->db_user->prepare("SELECT p.person_id ,pf.prefix_name as prefix,p.person_firstname as firstname,person_lastname as lastname
                       ,o.ward_name as office,p.Supply_system
                FROM personal p
                LEFT OUTER JOIN prefix pf ON pf.prefix_id = p.person_prefix
                LEFT OUTER JOIN office_sit o ON o.ward_id = p.office_id
                WHERE 1 {$subQuery}");
        $sth->execute();
        $row = $sth->rowCount();
        $data = array('allPage' => ceil($row / $_POST['perPage']));
        echo json_encode($data);
    }

}
