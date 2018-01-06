<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_model extends Model{
    function add($data){
        $data['dateadded']=date("y-m-d H:i:s");
        $this->db->insert("admin",$data);
        return $this->db->affected_rows();
    }
    function deactive($id){
        $this->db->update("admin",array('status'=>0),array('id'=>$id));
        return $this->db->affected_rows();
    }
    function active($id){
        $this->db->update("admin",array('status'=>1),array('id'=>$id));
        return $this->db->affected_rows();
    }
    function getall(){
        return $this->db->get("admin");
    }
    function getbyname($name){
        return $this->db->get_where("admin",array("username"=>$name));
    }
    function getbyid($id){
        return $this->db->get_where("admin",array("id"=>$id));
    }
    function getbyname_id($name,$id){
        //echo $name." ".$id;
        $this->db->where('username',$name);
        $this->db->where('id !=',$id);
        return $this->db->get("admin");
        
    }
    function login($name,$password){
        $query=$this->db->get_where("admin",array("username"=>$name,"password"=>$password,"status"=>1));
        if($query->num_rows()==1){
            $data=$query->row_array();            
            return $data;
        }
        else
            return false;
    }
    function logout(){        
    }
    function update($id,$data){
        $this->db->update("admin",$data,array("id"=>$id));
        return $this->db->affected_rows();
    }
    function getactive(){
        return $this->db->get_where("admin",array("status"=>1));
    }
    function check_pass($id,$pass){
        $query=$this->db->get_where('admin',array('id'=>$id,'password'=>$pass));
        return $query->result_array();
    }
}

?>
