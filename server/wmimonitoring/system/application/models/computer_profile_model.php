<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Computer_profile_model extends Model{
    public function Computer_profile_model(){
        parent::Model();
    }
    function add($data){
        $data['dateadded']=date("y-m-d H:i:s");
        $this->db->insert("computer_profile",$data);
        return $this->db->affected_rows();
    }
    function delete($id){
//        $this->db->select("setting_computer.admin,Count(groupsetting) as Count_computer");
//        $this->db->from("setting_computer");
//        $this->db->join("computer","computer.groupsetting=setting_computer.id","left");
//        $this->db->where('setting_computer.id',$id);
//        $query=$this->db->get();
//        if($query->num_rows()>0){
//            $data=$query->row_array();
//            if($data['Count_computer']==0){
//                if($this->session->userdata('type')=='Super Admin'){
//                    $this->db->delete("setting_computer",array('id'=>$id));
//                    return $this->db->affected_rows();
//                }
//                elseif($data['admin']==$this->session->userdata('username')){
//                    $this->db->delete("setting_computer",array('id'=>$id));
//                    return $this->db->affected_rows();
//                }
//                else
//                    return -1;
//            }
//            else
//                return -1;
//        }
//        else
//            return 0;
        $this->db->delete("computer_profile",array('id'=>$id));
        return $this->db->affected_rows();
    }
    function active($name){
        $this->db->update("admin",array('status'=>1),array('username'=>$name));
        return $this->db->affected_rows();
    }
    function getall(){
        if($this->admin['type']=='Super Admin')
            return $this->db->get("computer_profile");
        else
            return $this->db->get_where("computer_profile",array("admin"=>$this->session->userdata('id')));
    }
    function getall_status($admin){
        $this->db->select("computer_profile.id,computer_profile.name,admin.username as admin,computer_profile.timing_audit_hw,computer_profile.timing_audit_sw,computer_profile.is_monitor_registry,computer_profile.is_monitor_process,computer_profile.dateadded,Count(computer_profile) as Count_computer");
        //$this->db->select("setting_computer.*,Count(groupsetting) as Count_computer");
        $this->db->from("computer_profile");
        $this->db->join("computer","computer.computer_profile = computer_profile.id","left");
        $this->db->join("admin","computer_profile.admin = admin.id");
        if($this->admin['type']!='Super Admin')
            $this->db->where('computer_profile.admin',$admin);
        $this->db->group_by('computer_profile.id');
        return $this->db->get();
    }
    function get_id(){
        if($this->admin['type']!='Super Admin'){
            $this->db->where('computer_profile.admin',$this->admin['id']);
            $this->db->or_where('admin.type','Super Admin');
        }
        $this->db->select('computer_profile.id,computer_profile.name,admin.username');
        $this->db->join('admin','computer_profile.admin=admin.id');
        $query=$this->db->get('computer_profile');
        //echo $this->db->last_query();
        return $query->result_array();
    }
    function getbyname($name,$admin,$id=null){
        if($id==null)
            return $this->db->get_where("computer_profile",array("name"=>$name,"admin"=>$admin));
        else
            return $this->db->get_where("computer_profile",array("name"=>$name,"admin"=>$admin,"id !="=>$id));
    }
    function getbyid_status($id){
        $this->db->select("computer_profile.id,computer_profile.name,computer_profile.admin,computer_profile.timing_audit_hw,computer_profile.timing_audit_sw,computer_profile.is_monitor_registry,computer_profile.is_monitor_process,computer_profile.dateadded,Count(computer_profile) as Count_computer");
        $this->db->from("computer_profile");
        $this->db->join("computer","computer.computer_profile=computer_profile.id","left");
        $this->db->where('computer_profile.id',$id);
        $this->db->group_by('computer_profile.id');
        return $this->db->get();
    }
    function getbyid($id){
        return $this->db->get_where("computer_profile",array('id'=>$id));
    }   
    function update($id,$data){
        $this->db->update("computer_profile",$data,array("id"=>$id));
        return $this->db->affected_rows();
    }
}

?>
