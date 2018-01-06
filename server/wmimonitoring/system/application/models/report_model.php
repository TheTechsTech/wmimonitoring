<?php
class Report_model extends Model{
    function summary_hardware(){
        $query=$this->db->get('hardware_report');
        $result=$query->result_array();
        $this->db->select_sum('count');
        $query=$this->db->get('hardware_report');
        $item=$query->row_array();
        return array('all'=>$item['count'],'result'=>$result);
    }
    function summary_software(){
        $this->db->select('count(*) as count');
        $this->db->where_in('status',array('added','remove'));
        $query=$this->db->get('software');
        $item=$query->row_array();
        $this->db->distinct();
        $this->db->select('name, count(*) as count');
        $this->db->where_in('status',array('added','remove'));
        $this->db->group_by('name');
        $query=$this->db->get('software');
        $result=$query->result_array();
        return array('all'=>$item['count'],'result'=>$result);
    }
    function summary_computer(){
        $this->db->select('count(*) as count');
        $this->db->where_in('status',array('added','remove'));
        $query=$this->db->get('computer');
        $item=$query->row_array();
        return $item['count'];
    }
    function get_computer($criteria){
        if($criteria['by']=='Manufacture')
            $query=$this->db->query("CALL stock_computer_by_manufacture('".$criteria['date_start']."','".$criteria['date_end']."')");
        elseif($criteria['by']=='OS')
            $query=$this->db->query("CALL stock_computer_by_os('".$criteria['date_start']."','".$criteria['date_end']."')");
        return $query->result_array();
    }
    function get_hardware($criteria){
        $query=$this->db->query("CALL stock_harware('".$criteria['date_start']."','".$criteria['date_end']."')");
        return $query->result_array();
    }
    function get_software($criteria){
        $query=$this->db->query("CALL stock_software_by_name('".$criteria['date_start']."','".$criteria['date_end']."')");
        return $query->result_array();
    }
    function get_trace($criteria){
        $query=$this->db->query("CALL trace_report(".$criteria['year'].")");
        return $query->result_array();
    }
}

