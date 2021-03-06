<?php

class Supply_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function sqlSupply() {

        $sqlCondition = '';
        $sqlShift = '';
        $sqlDate = '';
        $sqlDept = '';
        $UNION = "";

        $user_type = filter_input(INPUT_GET, 'user_type'); //false if not set,null if filter fail
        $dept = filter_input(INPUT_GET, 'supply_depart'); //false if not set,null if filter fail
        $date = filter_input(INPUT_GET, 'supply_date'); //false if not set,null if filter fail
        $shift = filter_input(INPUT_GET, 'supply_shift'); //false if not set,null if filter fail
        $mode = filter_input(INPUT_GET, 'supply_mode'); //false if not set,null if filter fail

        $sqlDate .= ($date ? " AND s.supply_date = '{$date}' " : "");

        if ($user_type <> "user") {
            $sqlShift .= ($shift ? " AND s.supply_shift = '{$shift}' " : "");
        } else {
            $sqlDept .= ($dept ? " AND s.supply_depart = '{$dept}' " : "");
        }

        // var_dump($dept);

        switch ($mode) {
            case "send": $sqlCondition .= "";
                //if ($user_type <> "user") {
                $UNION = " UNION
                        SELECT 
                        depart_id as supply_depart,
                        depart_name,
                        0 as supply_id,
                        null as supply_date,
                        '' as supply_shift,
                        '' as supply_consignee,
                        '' as supply_consignee_name,
                        null as supply_consignee_time,
                        '' as supply_consignor,
                        '' as supply_consignor_name,
                        null as supply_consignor_time,
                        '' as supply_divider,
                        '' as supply_divider_name,
                        null as supply_divider_time,
                        '' as supply_consignor2,
                        '' as supply_consignor2_name,
                        null as supply_consignor2_time,
                        0 as supply_items_id,
                        0 as supply_items_send,
                        0 as supply_items_receive,
                        0 as supply_items_divide,
                        0 as supply_items_remain,
                        0 as supply_items_order_type,
                        0 as cnt_items,
                        '' as hos_guid,
                        'not_send' as supply_status,
                        'none' as step_status
                        FROM supply_depart
                        WHERE 1 = 1 
                        and cssd_status = 'Y'
                        AND depart_id not in (
                        SELECT supply_depart from supply s
                        where 1 = 1 
                        {$sqlDate}
                        {$sqlShift}
                        {$sqlDept}
                        )";
                // }
                break;
            case "receive": $sqlCondition .= "AND (s.supply_consignee <> '' OR s.supply_consignee <> '') AND (s.supply_consignor = '' OR s.supply_consignor = '') ";
                break;
            case "divide": $sqlCondition .= "AND (s.supply_consignee <> '' OR s.supply_consignee <> '') AND (s.supply_consignor <> '' OR s.supply_consignor <> '') AND (s.supply_divider = '' OR s.supply_divider = '') ";
                break;
            case "receive2": $sqlCondition .= "AND (s.supply_consignee <> '' OR s.supply_consignee <> '') AND (s.supply_consignor <> '' OR s.supply_consignor <> '') AND (s.supply_divider <> '' OR s.supply_divider <> '') AND (s.supply_consignor2 = '' ) ";
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
                DATE_FORMAT(s.supply_consignee_time, '%d-%m-%Y %H:%i') as supply_consignee_time,
                s.supply_consignor,
                CONCAT(p2.person_firstname,' ',p2.person_lastname) as supply_consignor_name,
                DATE_FORMAT(s.supply_consignor_time, '%d-%m-%Y %H:%i') as supply_consignor_time,
                s.supply_divider,
                CONCAT(p3.person_firstname,' ',p3.person_lastname) as supply_divider_name,
                DATE_FORMAT(s.supply_divider_time, '%d-%m-%Y %H:%i') as supply_divider_time,
                s.supply_consignor2,
                CONCAT(p4.person_firstname,' ',p4.person_lastname) as supply_consignor2_name,
                DATE_FORMAT(s.supply_consignor2_time, '%d-%m-%Y %H:%i') as supply_consignor2_time,
                si.supply_items_id,
                sum(si.supply_items_send) as supply_items_send,
                si.supply_items_receive,
                si.supply_items_divide,
                si.supply_items_remain,
                si.supply_items_order_type,
                count(si.items_id) as cnt_items,
                si.hos_guid,
                'send' as supply_status,
                if((s.supply_consignee <> '') and (s.supply_consignor <> '') and (s.supply_divider <> '') and (s.supply_consignor2 <> ''),4,if((s.supply_consignee <> '') and (s.supply_consignor <> '') and (s.supply_divider <> '') and (s.supply_consignor2 = ''),3,if((s.supply_consignee <> '') and (s.supply_consignor <> '') and (s.supply_divider = '') and (s.supply_consignor2 = ''),2,if((s.supply_consignee <> '') and (s.supply_consignor = '') and (s.supply_divider = '') and (s.supply_consignor2 = ''),1,if((s.supply_consignee = '') and (s.supply_consignor = '') and (s.supply_divider = '') and (s.supply_consignor2 = ''),0,0))))) as step_status
                FROM supply_items AS si
                LEFT OUTER JOIN supply AS s ON s.supply_id = si.supply_id
                LEFT OUTER JOIN supply_depart AS d ON d.depart_id = s.supply_depart
                LEFT OUTER JOIN personal AS p1 ON p1.person_id = s.supply_consignee
                LEFT OUTER JOIN personal AS p2 ON p2.person_id = s.supply_consignor
                LEFT OUTER JOIN personal AS p3 ON p3.person_id = s.supply_divider
                LEFT OUTER JOIN personal AS p4 ON p4.person_id = s.supply_consignor2
                WHERE 1 = 1
                {$sqlCondition}
                {$sqlDate}
                {$sqlShift}
                {$sqlDept}
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

    function getDataListingsByDepart() {

        $UNION = "";
        $mode = filter_input(INPUT_GET, 'supply_mode');

        switch ($mode) {
            case "send": $sqlCondition .= "";
                $UNION = "  UNION
                                SELECT 
                                    depart_id as supply_depart,
                                    depart_name,
                                    0 as supply_id,
                                    '{$_GET['supply_date']}' as supply_date,
                                    'morning' as supply_shift,
                                    '' as supply_consignee,
                                    '' as supply_consignee_name,
                                    null as supply_consignee_time,
                                    '' as supply_consignor,
                                    '' as supply_consignor_name,
                                    null as supply_consignor_time,
                                    '' as supply_divider,
                                    '' as supply_divider_name,
                                    null as supply_divider_time,
                                    '' as supply_consignor2,
                                    '' as supply_consignor2_name,
                                    null as supply_consignor2_time,
                                    0 as supply_items_id,
                                    0 as supply_items_send,
                                    0 as supply_items_receive,
                                    0 as supply_items_divide,
                                    0 as supply_items_remain,
                                    0 as supply_items_order_type,
                                    0 as cnt_items,
                                    '' as hos_guid,
                                    'not_send' as supply_status,
                                    'none' as step_status
                                    FROM supply_depart
                                    WHERE 1 = 1 
                                    AND depart_id = '{$_GET['supply_depart']}'  
                            UNION
                                    SELECT 
                                    depart_id as supply_depart,
                                    depart_name,
                                    0 as supply_id,
                                    '{$_GET['supply_date']}' as supply_date,
                                    'afternoon' as supply_shift,
                                    '' as supply_consignee,
                                    '' as supply_consignee_name,
                                    null as supply_consignee_time,
                                    '' as supply_consignor,
                                    '' as supply_consignor_name,
                                    null as supply_consignor_time,
                                    '' as supply_divider,
                                    '' as supply_divider_name,
                                    null as supply_divider_time,
                                    '' as supply_consignor2,
                                    '' as supply_consignor2_name,
                                    null as supply_consignor2_time,
                                    0 as supply_items_id,
                                    0 as supply_items_send,
                                    0 as supply_items_receive,
                                    0 as supply_items_divide,
                                    0 as supply_items_remain,
                                    0 as supply_items_order_type,
                                    0 as cnt_items,
                                    '' as hos_guid,
                                    'not_send' as supply_status,
                                    'none' as step_status
                                    FROM supply_depart
                                    WHERE 1 = 1 
                                    AND depart_id = '{$_GET['supply_depart']}' ";

                break;
            case "receive": $sqlCondition .= "AND (s.supply_consignee <> '' OR s.supply_consignee <> '') AND (s.supply_consignor = '' OR s.supply_consignor = '') ";
                break;
            case "divide": $sqlCondition .= "AND (s.supply_consignee <> '' OR s.supply_consignee <> '') AND (s.supply_consignor <> '' OR s.supply_consignor <> '') AND (s.supply_divider = '' OR s.supply_divider = '') ";
                break;
            case "receive2": $sqlCondition .= "AND (s.supply_consignee <> '' OR s.supply_consignee <> '') AND (s.supply_consignor <> '' OR s.supply_consignor <> '') AND (s.supply_divider <> '' OR s.supply_divider <> '') AND (s.supply_consignor2 = '' ) ";
                break;
            default : break;
        }

        $sql = "    SELECT * FROM (SELECT 
                        s.supply_depart,
                        d.depart_name,
                        s.supply_id,
                        s.supply_date,
                        s.supply_shift,
                        s.supply_consignee,
                        CONCAT(p1.person_firstname,' ',p1.person_lastname) as supply_consignee_name,
                        DATE_FORMAT(s.supply_consignee_time, '%d-%m-%Y %H:%i') as supply_consignee_time,
                        s.supply_consignor,
                        CONCAT(p2.person_firstname,' ',p2.person_lastname) as supply_consignor_name,
                        DATE_FORMAT(s.supply_consignor_time, '%d-%m-%Y %H:%i') as supply_consignor_time,
                        s.supply_divider,
                        CONCAT(p3.person_firstname,' ',p3.person_lastname) as supply_divider_name,
                        DATE_FORMAT(s.supply_divider_time, '%d-%m-%Y %H:%i') as supply_divider_time,
                        s.supply_consignor2,
                        CONCAT(p4.person_firstname,' ',p4.person_lastname) as supply_consignor2_name,
                        DATE_FORMAT(s.supply_consignor2_time, '%d-%m-%Y %H:%i') as supply_consignor2_time,
                        si.supply_items_id,
                        sum(si.supply_items_send) as supply_items_send,
                        si.supply_items_receive,
                        si.supply_items_divide,
                        si.supply_items_remain,
                        si.supply_items_order_type,
                        count(si.items_id) as cnt_items,
                        si.hos_guid,
                        'send' as supply_status,
                        if((s.supply_consignee <> '') and (s.supply_consignor <> '') and (s.supply_divider <> '') and (s.supply_consignor2 <> ''),4,if((s.supply_consignee <> '') and (s.supply_consignor <> '')
                        and (s.supply_divider <> '') and (s.supply_consignor2 = ''),3,if((s.supply_consignee <> '') and (s.supply_consignor
                        <> '') and (s.supply_divider = '') and (s.supply_consignor2 = ''),2,if((s.supply_consignee <> '') and
                        (s.supply_consignor = '') and (s.supply_divider = '') and (s.supply_consignor2 = ''),1,if((s.supply_consignee
                        = '') and (s.supply_consignor = '') and (s.supply_divider = '') and (s.supply_consignor2 = ''),0,0)
                       )))) as step_status
                        FROM supply_items AS si
                        LEFT OUTER JOIN supply AS s ON s.supply_id = si.supply_id
                        LEFT OUTER JOIN supply_depart AS d ON d.depart_id = s.supply_depart
                        LEFT OUTER JOIN personal AS p1 ON p1.person_id = s.supply_consignee
                        LEFT OUTER JOIN personal AS p2 ON p2.person_id = s.supply_consignor
                        LEFT OUTER JOIN personal AS p3 ON p3.person_id = s.supply_divider
                        LEFT OUTER JOIN personal AS p4 ON p4.person_id = s.supply_consignor2
                        WHERE 1 = 1
                        AND s.supply_date = '{$_GET['supply_date']}'  
                        AND s.supply_depart = '{$_GET['supply_depart']}' 
                            $sqlCondition
                        GROUP BY si.supply_id
                        {$UNION}

               
          ) as x
                WHERE x.supply_shift is not NULL
		GROUP BY x.supply_depart, x.supply_date, x.supply_shift
		ORDER BY FIELD(x.supply_shift,'morning','afternoon')";


        //echo $sql;
        $data = $this->db->select($sql);
        return $data;
    }

    function getDataSupplyByID() {
        $sql = "SELECT
                    s.supply_id, s.supply_date, s.supply_shift, s.supply_depart, d.depart_name, s.supply_consignee,
                    CONCAT( p1.person_firstname,' ', p1.person_lastname) AS supply_consignee_name,
                    DATE(s.supply_consignee_time)as supply_consignee_date, 
                    DATE_FORMAT(s.supply_consignee_time, '%H:%i') as supply_consignee_time, 
                    s.supply_consignor,
                    CONCAT(p2.person_firstname,' ',p2.person_lastname) AS supply_consignor_name,
                    
                    DATE(s.supply_consignor_time) as supply_consignor_date, 
                    DATE_FORMAT(s.supply_consignor_time, '%H:%i') as supply_consignor_time, 
                    
                    s.supply_divider,
                    CONCAT(p3.person_firstname,' ',p3.person_lastname) AS supply_divider_name,
                    DATE(s.supply_divider_time) as supply_divider_date,  
                    DATE_FORMAT(s.supply_divider_time, '%H:%i') as supply_divider_time, 
                    s.supply_consignor2,
                    CONCAT(p4.person_firstname,' ',p4.person_lastname) AS supply_consignor2_name,
                    DATE(s.supply_consignor2_time) as supply_consignor2_date,
                    DATE_FORMAT(s.supply_consignor2_time, '%H:%i') as supply_consignor2_time,

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
                    DATE_FORMAT(date(s.supply_consignee_time) + INTERVAL 543 YEAR,'%d-%m-%Y') as supply_consignee_date, DATE_FORMAT(s.supply_consignee_time, '%H:%i') as supply_consignee_time, s.supply_consignor,
                    CONCAT(p2.person_firstname,' ',p2.person_lastname) AS supply_consignor_name,
                    DATE_FORMAT(date(s.supply_consignor_time) + INTERVAL 543 YEAR,'%d-%m-%Y') as supply_consignor_date, DATE_FORMAT(s.supply_consignor_time, '%H:%i') as supply_consignor_time, s.supply_divider,
                    CONCAT(p3.person_firstname,' ',p3.person_lastname) AS supply_divider_name,
                    DATE_FORMAT(date(s.supply_divider_time) + INTERVAL 543 YEAR,'%d-%m-%Y') as supply_divider_date,  DATE_FORMAT(s.supply_divider_time, '%H:%i') as supply_divider_time, s.supply_consignor2,
                    CONCAT(p4.person_firstname,' ',p4.person_lastname) AS supply_consignor2_name,
                    DATE_FORMAT(date(s.supply_consignor2_time) + INTERVAL 543 YEAR,'%d-%m-%Y') as supply_consignor2_date,
                    DATE_FORMAT(s.supply_consignor2_time, '%H:%i') as supply_consignor2_time,
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
        //echo var_dump($arr);

        $supply_consignee_time = ($arr['supply_consignee_time'] === " " || $arr['supply_consignee_time'] === " 0:00" ? NULL : $arr['supply_consignee_time']);
        $supply_consignor_time = ($arr['supply_consignor_time'] === " " || $arr['supply_consignor_time'] === " 0:00" ? NULL : $arr['supply_consignor_time']);
        $supply_divider_time = ($arr['supply_divider_time'] === " " || $arr['supply_divider_time'] === " 0:00" ? NULL : $arr['supply_divider_time']);
        $supply_consignor2_time = ($arr['supply_consignor2_time'] === " " || $arr['supply_consignor2_time'] === " 0:00" ? NULL : $arr['supply_consignor2_time']);

        $sql = 'INSERT INTO supply (supply_date, supply_shift, supply_depart, supply_consignee, supply_consignee_time, supply_consignor, supply_consignor_time, supply_divider, supply_divider_time, supply_consignor2, supply_consignor2_time) '
                . ' VALUES (:supply_date, :supply_shift, :supply_depart, :supply_consignee, :supply_consignee_time, :supply_consignor, :supply_consignor_time, :supply_divider, :supply_divider_time, :supply_consignor2, :supply_consignor2_time ) ';

        //echo $sql;
        $sth = $this->db->prepare($sql);
        if ($sth) {

            $data = array(
                'supply_date' => $arr['supply_date'],
                'supply_shift' => $arr['supply_shift'],
                'supply_depart' => $arr['supply_depart'],
                'supply_consignee' => $arr['supply_consignee'],
                'supply_consignee_time' => $supply_consignee_time,
                'supply_consignor' => $arr['supply_consignor'],
                'supply_consignor_time' => $supply_consignor_time,
                'supply_divider' => $arr['supply_divider'],
                'supply_divider_time' => $supply_divider_time,
                'supply_consignor2' => $arr['supply_consignor2'],
                'supply_consignor2_time' => $supply_consignor2_time
            );

            $sth->execute($data);

            $errorInfo = $sth->errorInfo();
            // echo var_dump($errorInfo);
            if ($errorInfo[0] === '00000') {
                return true;
            } else {
                return false;
            }
        }
        //var_dump($sth);
    }

    public function updateSupplyData($arr) {

        // $arr['supply_consignee_time']
        //OR $arr['supply_consignee_time'] === "0:00" 
        //OR $arr['supply_consignor_time'] === "0:00" 
        //OR $arr['supply_divider_time'] === "0:00" 
        //OR $arr['supply_consignor2_time'] === "0:00" 

        $supply_consignee_time = ($arr['supply_consignee_time'] === " " || $arr['supply_consignee_time'] === " 0:00" ? NULL : $arr['supply_consignee_time']);
        $supply_consignor_time = ($arr['supply_consignor_time'] === " " || $arr['supply_consignor_time'] === " 0:00" ? NULL : $arr['supply_consignor_time']);
        $supply_divider_time = ($arr['supply_divider_time'] === " " || $arr['supply_divider_time'] === " 0:00" ? NULL : $arr['supply_divider_time']);
        $supply_consignor2_time = ($arr['supply_consignor2_time'] === " " || $arr['supply_consignor2_time'] === " 0:00" ? NULL : $arr['supply_consignor2_time']);


//        if ($arr['supply_consignor2_time'] === " ") {
//            $supply_consignor2_time = NULL;
//        } else {
//            $supply_consignor2_time = $arr['supply_consignor2_time'];
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
        //echo $sql;
        $sth = $this->db->prepare($sql);

        if ($sth) {
            $data = array(
                'supply_id' => $arr['supply_id'],
                'supply_date' => $arr['supply_date'],
                'supply_shift' => $arr['supply_shift'],
                'supply_depart' => $arr['supply_depart'],
                'supply_consignee' => $arr['supply_consignee'],
                'supply_consignee_time' => $supply_consignee_time,
                'supply_consignor' => $arr['supply_consignor'],
                'supply_consignor_time' => $supply_consignor_time,
                'supply_divider' => $arr['supply_divider'],
                'supply_divider_time' => $supply_divider_time,
                'supply_consignor2' => $arr['supply_consignor2'],
                'supply_consignor2_time' => $supply_consignor2_time
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
