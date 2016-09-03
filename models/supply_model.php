<?php

class Supply_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function sqlSupply() {
        $keyword = filter_input(INPUT_GET, 'keyword'); //false if not set,null if filter fail
        //$dept = filter_input(INPUT_GET, 'select_dept'); //false if not set,null if filter fail
        $shift = filter_input(INPUT_GET, '$supply_shift'); //false if not set,null if filter fail
        $mode = filter_input(INPUT_GET, 'supply_mode'); //false if not set,null if filter fail

        switch ($mode) {
//            case "send": $sqlCondition .= "";
//                break;
            case "receive": $sqlCondition .= "AND (si.supply_consignee IS NOT NULL) ";
                break;
            case "divide": $sqlCondition .= "AND (si.supply_consignor IS NOT NULL) ";
                break;
            case "receive2": $sqlCondition .= "AND (si.supply_divider IS NOT NULL) ";
                break;
            default : break;
        }

//        $sqlCondition .= ($shift ? "AND supply_shift = '{$shift}' " : "");

        $sql = 'SELECT'
                . ' s.supply_depart,'
                . ' d.depart_name,'
                . ' s.supply_id,'
                . ' s.supply_date,'
                . ' s.supply_shift,'
                . ' '
                . ' s.supply_consignee,'
                . ' CONCAT(p1.person_firstname," ",p1.person_lastname) as supply_consignee_name,'
                . ' s.supply_consignee_time,'
                . ' '
                . ' s.supply_consignor,'
                . ' CONCAT(p2.person_firstname," ",p2.person_lastname) as supply_consignor_name,'
                . ' s.supply_consignor_time,'
                . ' '
                . ' s.supply_divider,'
                . ' CONCAT(p3.person_firstname," ",p3.person_lastname) as supply_divider_name,'
                . ' s.supply_divider_time,'
                . ' '
                . ' s.supply_consignor2,'
                . ' CONCAT(p4.person_firstname," ",p4.person_lastname) as supply_consignor2_name,'
                . ' s.supply_consignor2_time,'
                . ' '
                . ' si.supply_items_id,'
                . ' sum(si.supply_items_send) as supply_items_send,'
                . ' si.supply_items_receive,'
                . ' si.supply_items_divide,'
                . ' si.supply_items_remain,'
                . ' si.supply_items_order_type,        '
                . ' count(si.items_id) as cnt_items,'
                . ' si.hos_guid,'
                . ' "send" as supply_status'
                . ' FROM supply_items AS si'
                . ' LEFT OUTER JOIN supply AS s ON s.supply_id = si.supply_id'
                . ' LEFT OUTER JOIN supply_depart AS d ON d.depart_id = s.supply_depart'
                . ' LEFT OUTER JOIN personal AS p1 ON p1.person_id = s.supply_consignee'
                . ' LEFT OUTER JOIN personal AS p2 ON p2.person_id = s.supply_consignor'
                . ' LEFT OUTER JOIN personal AS p3 ON p3.person_id = s.supply_divider'
                . ' LEFT OUTER JOIN personal AS p4 ON p4.person_id = s.supply_consignor2'
                . ' WHERE 1 = 1 '
                . ' and s.supply_date = "2016-08-23"'
//                . ' and s.supply_shift = "morning"'
                . ($shift ? "AND s.supply_shift = '{$shift}' " : "")
                . ' GROUP BY d.depart_name '
                . ' '
                . ' UNION'
                . ' '
                . ' SELECT '
                . ' depart_id as supply_depart,'
                . ' depart_name,'
                . ' 0 as supply_id,'
                . ' "0000-00-00" as supply_date,'
                . ' "" as supply_shift,'
                . ' "" as supply_consignee,'
                . ' "" as supply_consignee_name,'
                . ' "0000-00-00 00:00:00" as supply_consignee_time,'
                . ' "" as supply_consignor,'
                . ' "" as supply_consignor_name,'
                . ' "0000-00-00 00:00:00" as supply_consignor_time,'
                . ' "" as supply_divider,'
                . ' "" as supply_divider_name,'
                . ' "0000-00-00 00:00:00" as supply_divider_time,'
                . ' '
                . ' "" as supply_consignor2,'
                . ' "" as supply_consignor2_name,'
                . ' "0000-00-00 00:00:00" as supply_consignor2_time,'
                . ' 0 as supply_items_id,'
                . ' 0 as supply_items_send,'
                . ' 0 as supply_items_receive,'
                . ' 0 as supply_items_divide,'
                . ' 0 as supply_items_remain,'
                . ' 0 as supply_items_order_type,'
                . ' 0 as cnt_items,'
                . ' "" as hos_guid,'
                . ' "not_send" as supply_status'
                . ' FROM supply_depart'
                . ' WHERE 1 = 1 '
                . ' and cssd_status = "Y"'
                . ' AND depart_id not in ('
                . ' SELECT supply_depart from supply'
                . ' where supply_date = "2016-08-23"'
//                . ' and supply_shift = "morning"'
                . ($shift ? "AND supply_shift = '{$shift}' " : "")                        
                . ' )'
                . ' ORDER BY supply_status desc, depart_name';

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

        $data = $this->db->select($sql);
        return $data;
    }

    function getDataSupplyItemsByID() {
        $sql = "SELECT si.*, i.items_name , it.items_type_name, '' as manage
                FROM supply_items si
                LEFT OUTER JOIN items i on i.items_id = si.items_id
                LEFT OUTER JOIN items_type it on it.items_type_id = i.items_type
                where 1=1
                and si.supply_id = '{$_GET['supply_id']}' ";

        $data = $this->db->select($sql);
        return $data;
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

}
