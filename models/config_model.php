<?php

class Config_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    
    function getVar() {
        
        $sql = "SELECT config.value from config where var = '{$_GET['var']}'  ";
        //echo $sql;
        return $this->db->select($sql);
     
    }
    
    function configRs() {
        
        $sql = "SELECT `config`.`value` as conf from `config`  ";
        //echo $sql;
        return $this->db->select($sql); 
     
    }
    

}
