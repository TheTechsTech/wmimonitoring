<?php
class Monitoring_log_model extends Model{
    function get($admin=null){
        if($admin==null)
            $query=$this->db->get('log_monitoring');
        else
            $query=$this->db->get_where('log_monitoring',array('admin'=>$admin));
        return $query->result_array();
    }
    function get_by_id($type,$id){
        $query=$this->db->get_where('log_monitoring',array('id'=>$id,'type'=>$type));
        return $query->result_array();
    }
    function get_year(){
        $this->db->distinct();
        $query=$this->db->get('year_monitoring');
        return $query->result_array();
    }
}
