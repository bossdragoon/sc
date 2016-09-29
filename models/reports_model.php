<?php

class Reports_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

 
    public function SumItemsPerUnit() {
        
       if($_POST['supply_depart'] !== null){
           $depart = "and s.supply_depart = '{$_POST['supply_depart']}";
       }else{
            $depart = '';
       }
        $sql = "SELECT 
                    si.items_id, i.items_name, 
                    sum(si.supply_items_send) as supply_items_send, 
                    sum(si.supply_items_receive) as supply_items_receive, 
                    sum(si.supply_items_divide) as supply_items_divide, 
                    sum(si.supply_items_remain) as supply_items_remain, 
                    it.*
                    FROM supply_items si
                    LEFT OUTER JOIN supply s on s.supply_id = si.supply_id
                    LEFT OUTER JOIN items i on i.items_id = si.items_id
                    LEFT OUTER JOIN items_type it on it.items_type_id = i.items_type
                    where s.supply_date BETWEEN '{$_POST['date1']}' and '{$_POST['date2']}'
                    {$depart}
                    GROUP BY si.items_id
                    ORDER BY it.items_type_id , i.items_name";
        //echo $sql;                
        return $this->db->select($sql);
    }
    
    
   //////////////////////////////////////////////////////  รายงานระบบซ่อม ////////////////////////
    public function PriceRepairPerUnit() {
        return $this->db->select("select a.depart_id,a.depart_name,a.recieve,
                                a.PartsPrice,a.JobsPrice,
                                (if(a.JobsPrice > 0,a.JobsPrice,0) + if(a.PartsPrice > 0,a.PartsPrice,0)) as sumPrice
                                from (select d.depart_name,d.depart_id,
                                    (select sum(j.jobs_sum_price) 
                                        from service s1 
                                        left outer join jobs_items j on j.service_id = s1.service_id 
                                        where s1.service_depart = s.service_depart 
                                        and s1.service_regdate between '{$_POST['date1']}' and '{$_POST['date2']}') as JobsPrice,
                                    sum(p.parts_qty * st.store_unit_price) as PartsPrice,
                                    count(distinct s.service_id) as recieve
                                    from depart d
                                    left outer join service s on d.depart_id = s.service_depart
                                    left outer join parts_items p on p.service_id = s.service_id
                                    left outer join store st on st.store_id = p.store_id
                                    where s.service_regdate between '{$_POST['date1']}' and '{$_POST['date2']}'
                                    group by s.service_depart) as a
                                where (if(a.JobsPrice > 0,a.JobsPrice,0) + if(a.PartsPrice > 0,a.PartsPrice,0)) > 0
                                order by sumPrice desc");
    }

    public function PriceRepairPerMonth() {
        return $this->db->select("select concat(s.service_year,'/',s.service_no) as service_no,d.depart_name,
                                (select sum(j.jobs_sum_price) from jobs_items j where j.service_id = s.service_id) as JobsPrice,
                                sum(p.parts_qty * st.store_unit_price) as PartsPrice,
                                ((select sum(j.jobs_sum_price) from jobs_items j where j.service_id = s.service_id) + sum(p.parts_qty * st.store_unit_price)) as SumPrice
                                from service s
                                left outer join depart d on d.depart_id = s.service_depart
                                left outer join parts_items p on p.service_id = s.service_id
                                left outer join store st on st.store_id = p.store_id
                                where s.service_regdate between '{$_POST['date1']}' and '{$_POST['date2']}'
                                group by s.service_id
                                order by s.service_id");
    }

    public function RepairPerUnit() {
        return $this->db->select("select d.depart_id,d.depart_name,jobs.jobs_id,jobs.jobs_name,count(distinct j.jobs_items_id) as countRecieve
                                from service s
                                left outer join depart d on d.depart_id = s.service_depart
                                left outer join jobs_items j on j.service_id = s.service_id
                                left outer join jobs on jobs.jobs_id = j.jobs_id
                                where s.service_regdate between '{$_POST['date1']}' and '{$_POST['date2']}'
                                and j.service_id is not null
                                group by d.depart_id,jobs.jobs_id
                                order by d.depart_id");
    }

    public function RepairPerMonth() {
        return $this->db->select("select jobs.jobs_name,count(distinct j.jobs_items_id) as countRecieve
                                from service s
                                left outer join jobs_items j on j.service_id = s.service_id
                                left outer join jobs on jobs.jobs_id = j.jobs_id
                                where s.service_regdate between '{$_POST['date1']}' and '{$_POST['date2']}'
                                and j.service_id is not null
                                group by jobs.jobs_id
                                order by count(distinct j.jobs_items_id) desc");
    }

    public function PartsPerUnit() {
        return $this->db->select("select d.depart_id,d.depart_name,st.store_type_id,st.store_type_name,
                                count(p.parts_items_id) as countRecept,sum(p.parts_qty) as sumCount,st.store_type_count
                                from service s
                                left outer join parts_items p on p.service_id = s.service_id
                                left outer join store so on so.store_id = p.store_id
                                left outer join store_type st on st.store_type_id = so.store_type_id
                                left outer join depart d on d.depart_id = s.service_depart
                                where s.service_regdate between '{$_POST['date1']}' and '{$_POST['date2']}'
                                and p.service_id is not null
                                group by s.service_depart,st.store_type_id
                                order by count(distinct p.parts_items_id) desc");
    }

    public function PartsPerMonth() {
        return $this->db->select("select st.store_type_name,count(p.parts_items_id) as countRecept,sum(p.parts_qty) as sumCount,st.store_type_count
                                from service s
                                left outer join parts_items p on p.service_id = s.service_id
                                left outer join store so on so.store_id = p.store_id
				left outer join store_type st on st.store_type_id = so.store_type_id
                                where s.service_regdate between '{$_POST['date1']}' and '{$_POST['date2']}'
                                and p.service_id is not null
                                group by st.store_type_id
                                order by count(distinct p.parts_items_id) desc");
    }

    //////////////////////////////////////////////////////  ทะเบียน

    public function RepairRegister() {
        return $this->db->select("select concat(s.service_year,'/',s.service_id) as service_id,s.service_regdate,s.service_user as person_id,d.depart_name,s.service_type,
                                st.sym_name,s.service_symptom_text
                                from service s
                                left outer join depart d on d.depart_id = s.service_depart
                                left outer join symptom st on st.sym_id = s.service_symptom
                                where s.service_regdate between '{$_POST['date1']}' and '{$_POST['date2']}'
                                order by s.service_id");
    }

    public function StoreRegister() {
        return $this->db->select("select s.store_lotno,s.serial_number,s.store_unit_price,s.store_max_count,s.store_adddate,st.store_type_name,st.store_type_keeping,st.store_type_count
                                from store s
                                left outer join store_type st on st.store_type_id = s.store_type_id
                                where s.store_adddate between '{$_POST['date1']}' and '{$_POST['date2']}'
                                order by s.store_adddate");
    }

    public function PartsDrawn() {
        return $this->db->select("select st.store_type_name,pi.parts_qty,st.store_type_count,s.store_unit_price,s.serial_number,(pi.parts_qty * s.store_unit_price) as sum_price,
                                pi.parts_staff as person_id,pi.parts_date
                                from parts_items pi 
                                left outer join store s on s.store_id = pi.store_id
                                left outer join store_type st on st.store_type_id = s.store_type_id
                                where pi.parts_date between '{$_POST['date1']}' and '{$_POST['date2']}'
                                order by pi.parts_date");
    }

    public function PartsRemaining() {
        return $this->db->select("select s.store_lotno,s.serial_number,s.store_unit_price,s.store_stock,s.store_max_count,s.store_adddate,st.store_type_name,st.store_type_keeping,st.store_type_count
                                from store s
                                left outer join store_type st on st.store_type_id = s.store_type_id
                                where s.store_closedate is null or s.store_closedate = ''
                                order by s.store_adddate");
    }

    //////////////////////////////////////////////////////  รายงานอื่นๆ 

    public function RepairOfDepart() {
        return $this->db->select("select d.depart_name ,count(s.service_id) as sumService
                                from service s
                                left outer join depart d on d.depart_id = s.service_depart
                                where s.service_regdate between '{$_POST['date1']}' and '{$_POST['date2']}'
                                and s.service_detail_status_id <> 0
                                group by d.depart_id
                                order by count(s.service_id) desc");
    }

    public function TechnicianPerformance() {
        $sta = $this->ServiceDetailStatus();
        $size = sizeof($sta);
        $subQuery = '';

        for ($i = 0; $i < $size; $i++) {
            if ($sta[$i]['status_id'] == 1) {
                $subQuery .= "count(distinct sd.service_id,if(sd.service_detail_status_id = {$sta[$i]['status_id']},1,null)) as sta{$sta[$i]['sort']},";
            } else {
                $subQuery .= "count(distinct s.service_id,if(s.service_detail_status_id = {$sta[$i]['status_id']},1,null)) as sta{$sta[$i]['sort']},";
            }
        }

        return $this->db->select("select sd.service_detail_user as person_id,{$subQuery}
                                count(distinct s.service_id) as sum_jobService
                                from service s
                                left outer join service_detail sd on sd.service_id = s.service_id and sd.service_detail_status_id not in ('0','1')
                                where s.service_regdate between '{$_POST['date1']}' and '{$_POST['date2']}'
                                and s.service_detail_status_id not in ('0','1')
                                group by sd.service_detail_user
                                order by count(distinct sd.service_id) desc");
    }

    public function RepairPerMonthTechnicianPerformance() {
        $sta = $this->ServiceDetailStatus();
        $size = sizeof($sta);
        $subQuery = '';

        for ($i = 0; $i < $size; $i++) {
            $subQuery .= "count(distinct sd.service_id,if(sd.service_detail_status_id = {$sta[$i]['status_id']},1,null)) as sta{$sta[$i]['sort']},";
        }

        return $this->db->select("select sd.service_detail_user as person_id,ht.hardware_type_id,ht.hardware_type_name,count(distinct st.sym_id) as countRecieve,{$subQuery}
                                count(distinct sd.service_id) as sum_jobService
                                from service s
                                left outer join service_detail sd on sd.service_id = s.service_id and sd.service_detail_status_id not in ('0','1')
                                left outer join symptom st on st.sym_id = s.service_symptom
                                left outer join hardware_type ht on ht.hardware_type_id = st.hardware_type_id
                                where s.service_regdate between '{$_POST['date1']}' and '{$_POST['date2']}'
                                and s.service_detail_status_id not in ('0','1')
                                and sd.service_id is not null
                                group by sd.service_detail_user,ht.hardware_type_id");
    }

    public function ServiceStatusTechnician() {
        $sta = $this->ServiceDetailStatus();
        $size = sizeof($sta);
        $subQuery = '';

        for ($i = 0; $i < $size; $i++) {
            $subQuery .= "count(distinct sd.service_id,if(sd.service_detail_status_id = {$sta[$i]['status_id']},1,null)) as sta{$sta[$i]['sort']},";
        }

        return $this->db->select("select sd.service_detail_user as person_id,ss.service_status_id,ss.service_status_name,count(distinct s.service_status_id) as countRecieve,{$subQuery}
                                count(distinct sd.service_id) as sum_jobService
                                from service s
                                left outer join service_detail sd on sd.service_id = s.service_id and sd.service_detail_status_id not in ('0','1')
                                left outer join service_status ss on ss.service_status_id = s.service_status_id
                                where s.service_regdate between '{$_POST['date1']}' and '{$_POST['date2']}'
                                and s.service_detail_status_id not in ('0','1')
                                and sd.service_id is not null
                                group by sd.service_detail_user,ss.service_status_id");
    }

    ////////////////////////////////////////////////////// 

    public function ServiceDetailStatus() {
        return $this->db->select("select status_id,status_name,sort from service_detail_status where status_id not in ('0','1') order by sort");
    }

    public function SummaryShowIndex() {
        //$year = $_POST["bgyear"];

        $data = $this->db->select("SELECT 
                        (SELECT if (MONTH(NOW()) between '10' and '12', year(NOW())+543+1, year(NOW())+543)) as year,
                        (SELECT count(service_id) as cntServiceId
                        from service 
                        where service_detail_status_id <> '0' and service_year = (SELECT if (MONTH(NOW()) between '10' and '12', year(NOW())+543+1, year(NOW())+543))) as cntService,
                        (SELECT sum(jobs_sum_price) 
                        from jobs_items j
                        LEFT OUTER JOIN service s on s.service_id = j.service_id
                        where s.service_detail_status_id <> '0' and s.service_year = (SELECT if (MONTH(NOW()) between '10' and '12', year(NOW())+543+1, year(NOW())+543))
                        ) as jobsPrice,
                        (SELECT sum(parts_sum_price) 
                        from parts_items p
                        LEFT OUTER JOIN service s on s.service_id = p.service_id
                        where s.service_detail_status_id <> '0' and s.service_year = (SELECT if (MONTH(NOW()) between '10' and '12', year(NOW())+543+1, year(NOW())+543))
                        ) as partsPrice
                        ");
        return $data;
    }

}
