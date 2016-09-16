<?php

//    make by Shikaru 
class Login_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function dataRun() { 
        //,p.NurseManage_system
        // database name db_skh from 192.168.2.250
        $sql = "SELECT p.person_id,pf.prefix_name as prefix,p.person_firstname as firstname,person_lastname as lastname,o.ward_id,o.ward_name as office,po.position_name as position
                                ,p.person_username,p.person_photo,p.Supply_system
                                FROM personal p
                                LEFT OUTER JOIN prefix pf ON pf.prefix_id = p.person_prefix
                                LEFT OUTER JOIN office_sit o ON o.ward_id = p.office_id
                                LEFT OUTER JOIN position po ON po.position_id = p.position_id 
                                WHERE p.person_username = :username AND p.person_password = :password";
        //echo $sql;
        
        $login = $this->db_user->prepare($sql );
        //var_dump($login);
        $login->execute(array(
            ':username' => $_POST['username'],
            ':password' => md5($_POST['password'])
        ));
        //print_r($login->errorInfo());
        $data = $login->fetch(PDO::FETCH_ASSOC);

        $tech = $this->db->prepare("SELECT * FROM technician WHERE technician_cid = '{$data['person_id']}'");
        $tech->execute();
        
        $depart = $this->db->prepare("SELECT depart_id,depart_name,depart_tel FROM depart WHERE office_sit = '{$data['ward_id']}' limit 1");
        $depart->execute();
        $data += $depart->fetch(PDO::FETCH_ASSOC);

        if ($tech->rowCount() > 0) {
            $data += array('type' => 'staff');
            Session::init();
            Session::set('User', $data);
            $data = array(
                'chk' => true,
                'url' => URL);
//            header('location: ' . URL . 'index');
            
        } else if ($login->rowCount() > 0) {
            $data += array('type' => 'member');
            Session::init();
            Session::set('User', $data);
            $data = array(
                'chk' => true,
                'url' => URL);
//            header('location: ' . URL . 'index');
            
        } else {
//            header('location: ' . URL . 'login?login_stat=false');
            $data = array('chk' => false);
            
        }
        echo json_encode($data);
//        $technician = $tech->fetch(PDO::FETCH_ASSOC);
    }

}
