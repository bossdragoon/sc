<?php

class Items_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function Pagination() {
        $word = explode(' ', $_POST['search']);
        if ($_POST['search']) {
            foreach ($word as $value) {
                $condition .= " and concat(p.items_name ) like '%{$value}%' ";
            }
        } else {
            $condition = '';
        }

        if ($_POST['items_type']) {
            $condition .= " and p.items_type = '{$_POST['items_type']}' ";
        }

        if ($_POST['curPage'] > 0) {
            $limit = " limit " . (($_POST['curPage'] * $_POST['perPage']) - $_POST['perPage']) . ", {$_POST['perPage']} ";
        } else {
            $limit = ($_POST['perPage']) ? " limit {$_POST['perPage']} " : '';
        }

        $sql = "SELECT p.*
                FROM items p
                WHERE 1 {$condition}
                ";
        //echo $sql;
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $row = $sth->rowCount();
        $data = array('allPage' => ceil($row / $_POST['perPage']));
        echo json_encode($data);
    }

    public function getDataListings() {

        $condition = '';
        $word = explode(' ', $_GET['search']);
        if ($_GET['search']) {
            foreach ($word as $value) {
                $condition .= " and concat(p.items_name ) like '%{$value}%' ";
            }
        }

        if ($_GET['items_type']) {
            $condition .= " and p.items_type = '{$_GET['items_type']}' ";
        }

        if ($_GET['curPage'] > 0) {
            $limit = " limit " . (($_GET['curPage'] * $_GET['perPage']) - $_GET['perPage']) . ", {$_GET['perPage']} ";
        } else {
            $limit = ($_GET['perPage']) ? " limit {$_GET['perPage']} " : '';
        }

        $sql = "SELECT p.*
                from items p 
                WHERE 1=1
                {$condition}
                {$limit} ";
        //echo $sql;
        $data = $this->db->select($sql);
        return $data;
    }

    function getDataByID() {
        $sql = "SELECT p.* 
                from items p 
                WHERE p.items_id = '{$_GET['id']}' ";

        $data = $this->db->select($sql);
        return $data;
    }

    function getDataStatus() {
        $sql = 'SHOW COLUMNS FROM items WHERE Field  = "status"';
        $data = $this->db->select($sql);
        return $data[0]['Type'];
    }

    public function insertDataByID() {
        $sql = 'INSERT '
                . 'INTO items (items_name, items_type, items.status) '
                . 'VALUES (:items_name, :items_type, :status)';
        $sth = $this->db->prepare($sql);

        $sth->execute(array(
            ':items_name' => $_POST['items_name'],
            ':items_type' => $_POST['items_type'],
            ':status' => $_POST['status']
        ));

        //print_r($sth->errorInfo());
        $errorInfo = $sth->errorInfo();
        if ($errorInfo[0] === '00000') {
            $chk = true;
        } else {
            $chk = false;
        }

        $data = array('sta' => 'add', 'result' => $chk);
        echo json_encode($data);
    }

    public function updateDataByID() {
        $sql = 'UPDATE items '
                . 'SET items_name = :items_name '
                . ',items.status = :status '
                . ' WHERE items_id = :items_id ';
        //echo $sql;
        $sth = $this->db->prepare($sql);

        $sth->execute(array(
            ':items_id' => $_POST['items_id'],
            ':items_name' => $_POST['items_name'],
            ':status' => $_POST['status']
        ));

        //print_r($sth->errorInfo());
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
        if ($this->checkDataUseByID() === false) {
            $data = array('sta' => 'delete', 'result' => false);
        } else {
            $sql = 'DELETE FROM items WHERE items_id = "' . $_POST['id'] . '" ';
            //$sql = '';
            $sth = $this->db->prepare($sql);
            $sth->execute();
            $errorInfo = $sth->errorInfo();
            if ($errorInfo[0] === '00000') {
                $chk = true;
            } else {
                $chk = false;
            }
            $data = array('sta' => 'delete', 'result' => $chk);
        }

        echo json_encode($data);
    }

    function checkDataUseByID() {
        $sql = "SELECT items_id from supply_items where 1 and items_id = '{$_POST['id']}' ";
        //echo $sql;
        $sth = $this->db->prepare($sql);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

}
