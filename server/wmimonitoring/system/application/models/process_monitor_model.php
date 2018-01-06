<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Process_monitor_model extends Model{
    function add($data){
        $data['dateadded']=date("y-m-d H:i:s");
        $data['loginby']=$this->get_last_user($data['Hostname']);
        $white_list=$this->get_white_list_by_executecommand($data['ExecuteCommand']);
        if(count($white_list)==0){
            $this->db->insert('process_trace',$data);
            return $this->db->affected_rows();
        }
        else
            return 0;
    }
    function get_white_list_by_executecommand($executecommand){
        $query=$this->db->get_where('white_list_program',array('executecommand'=>$executecommand));
        return $query->result_array();
    }
    function get_log($admin=null){
        if($admin==null)
            $query=$this->db->get('log_process');
        else
            $query=$this->db->get_where('log_process',array('admin'=>$admin));
        return $query->result_array();
    }
    function get_by_id($id){
        $query=$this->db->get_where('process_trace',array('id'=>$id));
        return $query->result_array();        
    }
    function add_white_list($data){
        $whitelist=$this->get_white_list_by_executecommand($data['executecommand']);
        if(count($whitelist)==0){
            $data['dateadded']=date("y-m-d H:i:s");
            $this->db->insert('white_list_program',$data);
            return $this->db->affected_rows();
        }
        else
            return 0;
    }        
    function change_status($id,$status,$admin){
        $this->db->update('process_trace',array('status'=>$status,'confirmby'=>$admin),array('id'=>$id));
        return $this->db->affected_rows();
    }
    function get_last_user($hostname){
        $this->db->select("username");
        $this->db->from("user_login");
        $this->db->where("hostname",$hostname);
        $this->db->order_by("id","desc");
        $this->db->limit(1);
        $query=$this->db->get();
        if($query->num_rows()>0)
            $result=$query->row_array(0);
        return $result["username"];
    }
    function get_log_by_id($id){
        $query=$this->db->get_where('log_process',array('id'=>$id));
        return $query->result_array();
    }
    function get_whitelist($criteria=null){
        $this->db->select('white_list_program.*, admin.name AS admin_name',false);
        $this->db->join('admin','white_list_program.addedby=admin.id');
        if($criteria==null)
            $query=$this->db->get('white_list_program');
        else
            $query=$this->db->get_where('white_list_program',$criteria);
        return $query->result_array();
    }
    function delete_whitelist($criteria){
        $this->db->delete('white_list_program',$criteria);
        return $this->db->affected_rows();
    }
    function get_trace($criteria){
        if(isset($criteria['year'])){
            $this->db->where('YEAR(process_trace.dateadded)',$criteria['year'],false);
            unset($criteria['year']);
        }
        if(isset($criteria['month'])){
            $this->db->where('MONTH(process_trace.dateadded)',$criteria['month'],false);
            unset($criteria['month']);
        }
        foreach($criteria as $key=>$value)
            $criteria1['process_trace.'.$key]=$value;
        $this->db->join('admin','process_trace.confirmby=admin.id');
        $this->db->select('process_trace.*,admin.name',false);
        $query=$this->db->get_where('process_trace',$criteria1);
        return $query->result_array();
    }
}

