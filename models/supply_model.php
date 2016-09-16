<?php

class Supply_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function sqlSupply() {
        if (($user_type === 'admin') || ($user_type === 'staff')) {
            
        } else {
            
        }

        $sqlCondition = '';
        $sqlCondition2 = '';
        $UNION = "";
        $user_type = filter_input(INPUT_GET, 'user_type'); //false if not set,null if filter fail
        $dept = filter_input(INPUT_GET, 'select_dept'); //false if not set,null if filter fail
        $date = filter_input(INPUT_GET, 'supply_date'); //false if not set,null if filter fail
        $shift = filter_input(INPUT_GET, 'supply_shift'); //false if not set,null if filter fail
        $mode = filter_input(INPUT_GET, 'supply_mode'); //false if not set,null if filter fail

        $sqlCondition .= ($date ? "AND s.supply_date = '{$date}' " : "");
        $sqlCondition2 .= ($date ? "AND s.supply_date = '{$date}' " : "");

        $sqlCondition .= ($shift ? "AND s.supply_shift = '{$shift}' " : "");
        $sqlCondition2 .= ($shift ? "AND s.supply_shift = '{$shift}' " : "");


        switch ($mode) {
            case "send": $sqlCondition .= "";
                $UNION = " UNION
                SELECT 
                depart_id as supply_depart,
                depart_name,
                0 as supply_id,
                '0000-00-00' as supply_date,
                '' as supply_shift,
                '' as supply_consignee,
                '' as supply_consignee_name,
                '0000-00-00 00:00:00' as supply_consignee_time,
                '' as supply_consignor,
                '' as supply_consignor_name,
                '0000-00-00 00:00:00' as supply_consignor_time,
                '' as supply_divider,
                '' as supply_divider_name,
                '0000-00-00 00:00:00' as supply_divider_time,
                '' as supply_consignor2,
                '' as supply_consignor2_name,
                '0000-00-00 00:00:00' as supply_consignor2_time,
                0 as supply_items_id,
                0 as supply_items_send,
                0 as supply_items_receive,
                0 as supply_items_divide,
                0 as supply_items_remain,
                0 as supply_items_order_type,
                0 as cnt_items,
                '' as hos_guid,
                'not_send' as supply_status
                FROM supply_depart
                WHERE 1 = 1 
                and cssd_status = 'Y'
                AND depart_id not in (
                SELECT supply_depart from supply s
                where 1 = 1 
                {$sqlCondition2}
                )";

                break;
            case "receive": $sqlCondition .= "AND (s.supply_consignor = '' OR s.supply_consignor IS NULL) ";
                break;
            case "divide": $sqlCondition .= "AND (s.supply_consignor <> '' OR s.supply_consignor IS NOT NULL) AND (s.supply_divider = '' OR s.supply_divider IS NULL) ";
                break;
            case "receive2": $sqlCondition .= "AND (s.supply_consignor <> '' OR s.supply_consignor IS NOT NULL) AND (s.supply_divider <> '' OR s.supply_divider IS NOT NULL) AND (s.supply_divider = '' OR s.supply_consignor2 IS NULL) ";
                break;
            default : break;
        }

        $sql = "SELECT 
                s.supply_depart,
                d.depart_name,
                s.supply_id,
                s.supply_date,
                s.supply_shift,
                s.supply_consignee,
                CONCAT(p1.person_firstname,' ',p1.person_lastname) as supply_consignee_name,
                s.supply_consignee_time,
                s.supply_consignor,
                CONCAT(p2.person_firstname,' ',p2.person_lastname) as supply_consignor_name,
                s.supply_consignor_time,
                s.supply_divider,
                CONCAT(p3.person_firstname,' ',p3.person_lastname) as supply_divider_name,
                s.supply_divider_time,
                s.supply_consignor2,
                CONCAT(p4.person_firstname,' ',p4.person_lastname) as supply_consignor2_name,
                s.supply_consignor2_time,
                si.supply_items_id,
                sum(si.supply_items_send) as supply_items_send,
                si.supply_items_receive,
                si.supply_items_divide,
                si.supply_items_remain,
                si.supply_items_order_type,
                count(si.items_id) as cnt_items,
                si.hos_guid,
                'send' as supply_status
                FROM supply_items AS si
                LEFT OUTER JOIN supply AS s ON s.supply_id = si.supply_id
                LEFT OUTER JOIN supply_depart AS d ON d.depart_id = s.supply_depart
                LEFT OUTER JOIN personal AS p1 ON p1.person_id = s.supply_consignee
                LEFT OUTER JOIN personal AS p2 ON p2.person_id = s.supply_consignor
                LEFT OUTER JOIN personal AS p3 ON p3.person_id = s.supply_divider
                LEFT OUTER JOIN personal AS p4 ON p4.person_id = s.supply_consignor2
                WHERE 1 = 1
                {$sqlCondition}
                GROUP BY d.depart_name 
                {$UNION}
                ORDER BY supply_status desc, depart_name ";

        //$sqlCondition
        //echo $sql;
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
        //$sql = $sql . $limit;
        $data = $this->db->select($sql);

        return $data;
    }

    function getDataSupplyByID() {
        $sql = "SELECT
                    s.supply_id, s.supply_date, s.supply_shift, s.supply_depart, d.depart_name, s.supply_consignee,
                    CONCAT( p1.person_firstname,' ', p1.person_lastname) AS supply_consignee_name,
                    date(s.supply_consignee_time) as supply_consignee_date, time(s.supply_consignee_time) as supply_consignee_time, s.supply_consignor,
                    CONCAT(p2.person_firstname,' ',p2.person_lastname) AS supply_consignor_name,
                    date(s.supply_consignor_time) as supply_consignor_date, time(s.supply_consignor_time) as supply_consignor_time, s.supply_divider,
                    CONCAT(p3.person_firstname,' ',p3.person_lastname) AS supply_divider_name,
                    date(s.supply_divider_time) as supply_divider_date,  time(s.supply_divider_time) as supply_divider_time, s.supply_consignor2,
                    CONCAT(p4.person_firstname,' ',p4.person_lastname) AS supply_consignor2_name,
                    date(s.supply_consignor2_time) as supply_consignor2_date,
                    time(s.supply_consignor2_time) as supply_consignor2_time,
                    count(si.items_id) AS cnt_items
                FROM supply_items AS si
                LEFT OUTER JOIN supply AS s ON s.supply_id = si.supply_id
                LEFT OUTER JOIN supply_depart AS d ON d.depart_id = s.supply_depart
                LEFT OUTER JOIN personal AS p1 ON p1.person_id = s.supply_consignee
                LEFT OUTER JOIN personal AS p2 ON p2.person_id = s.supply_consignor
                LEFT OUTER JOIN personal AS p3 ON p3.person_id = s.supply_divider
                LEFT OUTER JOIN personal AS p4 ON p4.person_id = s.supply_consignor2
                WHERE 1 = 1
                AND s.supply_id = '{$_GET['supply_id']}'
                AND s.supply_date = '{$_GET['supply_date']}'
                AND s.supply_shift = '{$_GET['supply_shift']}'
                GROUP BY
                s.supply_id ";

        //echo $sql;
        $data = $this->db->select($sql);
        return $data;
    }

    function getDataSupplyItemsByID() {
        $sql = "SELECT si.*, i.items_name , it.items_type_name, '' as manage
                FROM supply_items si
                LEFT OUTER JOIN items i on i.items_id = si.items_id
                LEFT OUTER JOIN items_type it on it.items_type_id = i.items_type
                where 1=1
                and si.supply_id = '{$_GET['supply_id']}'
                order by i.items_name";

        $data = $this->db->select($sql);
        return $data;
    }

    function getDataSupplyIdByContent($content) {
        $sql = "SELECT supply_id
                FROM supply 
                WHERE 1=1
                AND CONCAT(supply_date,supply_shift,supply_depart) = '{$content}' 
                limit 1 ";

        //echo $sql;
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data['supply_id'];
    }

    function getDataShift() {
        $sql = 'SHOW COLUMNS FROM supply WHERE Field  = "supply_shift"';
        $data = $this->db->select($sql);
        return $data[0]['Type'];
    }

    function getDataOrderType() {
        $sql = 'SHOW COLUMNS FROM supply_items WHERE Field  = "supply_items_order_type"';
        $data = $this->db->select($sql);
        return $data[0]['Type'];
    }

    function getDataSupplyByIDForPDF($id) {
        $sql = "SELECT
                    s.supply_id, DATE_FORMAT(s.supply_date + INTERVAL 543 YEAR,'%d-%m-%Y') as supply_date, s.supply_shift, s.supply_depart, d.depart_name, s.supply_consignee,
                    CONCAT( p1.person_firstname,' ', p1.person_lastname) AS supply_consignee_name,
                    DATE_FORMAT(date(s.supply_consignee_time) + INTERVAL 543 YEAR,'%d-%m-%Y') as supply_consignee_date, time(s.supply_consignee_time) as supply_consignee_time, s.supply_consignor,
                    CONCAT(p2.person_firstname,' ',p2.person_lastname) AS supply_consignor_name,
                    DATE_FORMAT(date(s.supply_consignor_time) + INTERVAL 543 YEAR,'%d-%m-%Y') as supply_consignor_date, time(s.supply_consignor_time) as supply_consignor_time, s.supply_divider,
                    CONCAT(p3.person_firstname,' ',p3.person_lastname) AS supply_divider_name,
                    DATE_FORMAT(date(s.supply_divider_time) + INTERVAL 543 YEAR,'%d-%m-%Y') as supply_divider_date,  time(s.supply_divider_time) as supply_divider_time, s.supply_consignor2,
                    CONCAT(p4.person_firstname,' ',p4.person_lastname) AS supply_consignor2_name,
                    DATE_FORMAT(date(s.supply_consignor2_time) + INTERVAL 543 YEAR,'%d-%m-%Y') as supply_consignor2_date,
                    time(s.supply_consignor2_time) as supply_consignor2_time,
                    count(si.items_id) AS cnt_items
                FROM supply_items AS si
                LEFT OUTER JOIN supply AS s ON s.supply_id = si.supply_id
                LEFT OUTER JOIN supply_depart AS d ON d.depart_id = s.supply_depart
                LEFT OUTER JOIN personal AS p1 ON p1.person_id = s.supply_consignee
                LEFT OUTER JOIN personal AS p2 ON p2.person_id = s.supply_consignor
                LEFT OUTER JOIN personal AS p3 ON p3.person_id = s.supply_divider
                LEFT OUTER JOIN personal AS p4 ON p4.person_id = s.supply_consignor2
                WHERE 1 = 1
                AND s.supply_id = '{$id}'
                GROUP BY s.supply_id ";

        return $this->db->select($sql);
    }

    function getDataSupplyItemsByIDForPDF($id) {
        $sql = "SELECT si.*, i.items_name , it.items_type_name, '' as manage
                FROM supply_items si
                LEFT OUTER JOIN items i on i.items_id = si.items_id
                LEFT OUTER JOIN items_type it on it.items_type_id = i.items_type
                WHERE 1=1
                AND si.supply_id = '{$id}'";

        $data = $this->db->select($sql);
        return $data;
    }

    public function insertSupplyData($arr) {
        $sql = 'INSERT INTO supply (supply_date, supply_shift, supply_depart, supply_consignee, supply_consignee_time, supply_consignor, supply_consignor_time, supply_divider, supply_divider_time, supply_consignor2, supply_consignor2_time) '
                . ' VALUES (:supply_date, :supply_shift, :supply_depart, :supply_consignee, :supply_consignee_time, :supply_consignor, :supply_consignor_time, :supply_divider, :supply_divider_time, :supply_consignor2, :supply_consignor2_time ) ';

        $sth = $this->db->prepare($sql);
        if ($sth) {
            $data = array(
                'supply_date' => $arr['supply_date'],
                'supply_shift' => $arr['supply_shift'],
                'supply_depart' => $arr['supply_depart'],
                'supply_consignee' => $arr['supply_consignee'],
                'supply_consignee_time' => $arr['supply_consignee_time'],
                'supply_consignor' => $arr['supply_consignor'],
                'supply_consignor_time' => $arr['supply_consignor_time'],
                'supply_divider' => $arr['supply_divider'],
                'supply_divider_time' => $arr['supply_divider_time'],
                'supply_consignor2' => $arr['supply_consignor2'],
                'supply_consignor2_time' => $arr['supply_consignor2_time']
            );

            $sth->execute($data);

            $errorInfo = $sth->errorInfo();
            if ($errorInfo[0] === '00000') {
                return true;
            } else {
                return false;
            }
        }
        //var_dump($sth);
    }

    public function updateSupplyData($arr) {
 
        $supply_consignor_time = ($arr['supply_consignee_time'] <> " " ? "" : "");
        
        
//        if($arr['supply_consignee_time'] === " "){
//            $supply_consignor_time = "";
//        }else{
//            $supply_consignor_time = " supply_consignee_time = :supply_consignee_time, ";
//        }
        
        $sql = " UPDATE supply SET supply_date = :supply_date, supply_shift = :supply_shift, supply_depart = :supply_depart, 
                supply_consignee = :supply_consignee, 
                supply_consignee_time = :supply_consignee_time,
                supply_consignor = :supply_consignor, 
                supply_consignor_time = :supply_consignor_time, 
                supply_divider = :supply_divider, 
                supply_divider_time = :supply_divider_time, 
                supply_consignor2 = :supply_consignor2, 
                supply_consignor2_time = :supply_consignor2_time
                WHERE supply_id = :supply_id ";
        echo $sql;
        $sth = $this->db->prepare($sql);

        if ($sth) {
            $data = array(
                'supply_id' => $arr['supply_id'],
                'supply_date' => $arr['supply_date'],
                'supply_shift' => $arr['supply_shift'],
                'supply_depart' => $arr['supply_depart'],
                'supply_consignee' => $arr['supply_consignee'],
                'supply_consignee_time' => $arr['supply_consignee_time'],
                'supply_consignor' => $arr['supply_consignor'],
                'supply_consignor_time' => $arr['supply_consignor_time'],
                'supply_divider' => $arr['supply_divider'],
                'supply_divider_time' => $arr['supply_divider_time'],
                'supply_consignor2' => $arr['supply_consignor2'],
                'supply_consignor2_time' => $arr['supply_consignor2_time']
            );

            $sth->execute($data);
            $errorInfo = $sth->errorInfo();
            var_dump($errorInfo);
            if ($errorInfo[0] === '00000') {
                return true;
            } else {
                return false;
            }
        }
    }

    public function insertSupplyItemsData($arr, $supply_id) {
        $sql = 'INSERT INTO supply_items (supply_id, items_id, supply_items_send, supply_items_receive, supply_items_divide, supply_items_remain, supply_items_order_type, hos_guid) '
                . ' VALUES (:supply_id, :items_id, :supply_items_send, :supply_items_receive, :supply_items_divide, :supply_items_remain, :supply_items_order_type, concat("{",upper(uuid()),"}")) ';

        $sth = $this->db->prepare($sql);
        if ($sth) {
            $data = array(
                'supply_id' => $supply_id,
                'items_id' => $arr['items_id'],
                'supply_items_send' => $arr['supply_items_send'],
                'supply_items_receive' => $arr['supply_items_receive'],
                'supply_items_divide' => $arr['supply_items_divide'],
                'supply_items_remain' => $arr['supply_items_remain'],
                'supply_items_order_type' => $arr['supply_items_order_type']
            );

            $sth->execute($data);
            $errorInfo = $sth->errorInfo();
            //var_dump($errorInfo);
            if ($errorInfo[0] === '00000') {
                return true;
            } else {
                return false;
            }
        }
    }

    public function updateSupplyItemsData($arr, $hos_guid) {
        $sql = ' UPDATE supply_items SET supply_items_send = :supply_items_send,  '
                . ' supply_items_receive = :supply_items_receive, supply_items_divide = :supply_items_divide, '
                . ' supply_items_remain = :supply_items_remain, supply_items_order_type = :supply_items_order_type  '
                . ' WHERE hos_guid = :hos_guid ';

        $sth = $this->db->prepare($sql);
        if ($sth) {
            $data = array(
                'hos_guid' => $hos_guid,
                'supply_items_send' => $arr['supply_items_send'],
                'supply_items_receive' => $arr['supply_items_receive'],
                'supply_items_divide' => $arr['supply_items_divide'],
                'supply_items_remain' => $arr['supply_items_remain'],
                'supply_items_order_type' => $arr['supply_items_order_type']
            );

            $sth->execute($data);
            $errorInfo = $sth->errorInfo();
            //var_dump($errorInfo);
            if ($errorInfo[0] === '00000') {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteSupplyItemsDataById($hos_guid) {
        $sth = $this->db->prepare("DELETE FROM supply_items WHERE hos_guid = '{$hos_guid}' ");
        $sth->execute();
        $errorInfo = $sth->errorInfo();
        //var_dump($errorInfo);
        if ($errorInfo[0] === '00000') {
            return true;
        } else {
            return false;
        }
    }

}
