<?php

class Personal_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    function getDataListings() {
        $subQuery = '';
        if (!empty($_GET['search'])) {
            $subQuery .= " WHERE depart_name LIKE '%{$_GET['search']}%' ";
        }


        if ($_GET['curPage'] > 0) {
            $limit = " limit " . (($_GET['curPage'] * $_GET['perPage']) - $_GET['perPage']) . ", {$_GET['perPage']} ";
        } else {
            $limit = ($_GET['perPage']) ? " limit {$_GET['perPage']} " : '';
        }

        $sql = 'SELECT depart_id, depart_name, depart_tel , depart_status, if(depart_status ="1","ใช้งาน","ยกเลิกใช้งาน") as depart_status_name  '
                . ' FROM depart '
                . $subQuery
                . ' ORDER BY depart_name '
                . $limit;
        $data = $this->db->select($sql);
        echo json_encode($data);
    }

    public function insertDataByID() {
        $sth = $this->db->prepare('INSERT INTO depart (depart_name, depart_tel, depart_status) 
                                    SELECT :depart_name, :depart_tel, :depart_status ');

        $sth->execute(array(
            ':depart_name' => $_POST['depart_name'],
            ':depart_tel' => $_POST['depart_tel'],
            ':depart_status' => $_POST['depart_status_value'] //modify of depart_status
        ));
    }

    public function editDataByID() {
        $sql = 'UPDATE depart  SET depart_name = :depart_name, depart_tel= :depart_tel, depart_status= :depart_status'
                . ' WHERE depart_id = :depart_id ';
        $sth = $this->db->prepare($sql);
        $sth->execute(array(
            ':depart_id' => $_POST['depart_id'],
            ':depart_name' => $_POST['depart_name'],
            ':depart_tel' => $_POST['depart_tel'],
            ':depart_status' => $_POST['depart_status_value'] //modify of depart_status
        ));
    }

    function deleteDataByID() {
        $sth = $this->db->prepare('DELETE FROM depart WHERE depart_id = "' . $_POST['id'] . '" ');
        $sth->execute();
    }

    function getDataDepartNameByID() {
        $sql = 'SELECT *
                FROM depart
                WHERE depart_id = "' . $_GET['depart_id'] . '" ';
        
       // echo $sql;
        return $this->db->select($sql);
        
        // $data = $this->db->select($sql);
        // print_r($data->errorInfo());
        //return $data;
        
    }

    function getDataByID() {
        $data = $this->db->select('SELECT *
                                    FROM depart
                                    WHERE depart_id = "' . $_POST['id'] . '" ');
        echo json_encode($data);
    }

    function checkDataUseByID() {
        $sth = $this->db->prepare("SELECT * FROM service WHERE service_depart = '{$_POST['id']}'");
        $sth->execute();

        $sth2 = $this->db->prepare("SELECT * FROM items WHERE depart_id = '{$_POST['id']}'");
        $sth2->execute();

        if (($sth->rowCount() > 0) || ($sth2->rowCount() > 0)) {
            return false;
        } else {
            return true;
        }
    }

    public function Pagination() {
        $subQuery = '';
        if (!empty($_POST['search'])) {
            $subQuery .= " WHERE depart_name LIKE '%{$_POST['search']}%' ";
        }
        $sth = $this->db->prepare('SELECT depart_id FROM depart ' . $subQuery . ' ORDER BY depart_name ');
        $sth->execute();
        $row = $sth->rowCount();
        $data = array('allPage' => ceil($row / $_POST['perPage']));
        echo json_encode($data);
    }

    public function personalRs() {  
        $sql = "SELECT person_id, concat(person_firstname, ' ', person_lastname) as person_name FROM personal where Supply_system is not null  ORDER BY person_name ";
       // echo $sql;
        return $this->db->select($sql);
    }

}
