<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Interpreter_program_model extends Model{
    function getbyid($id){
        return $this->db->get_where('interpreter_program',array('id'=>$id));
    }
    function getall(){
        $this->db->select("interpreter_program.id,interpreter_program.name,interpreter_program.command,admin.username as addedby,interpreter_program.dateadded");
        $this->db->from("interpreter_program");
        $this->db->join("admin","interpreter_program.addedby = admin.id");
        return $this->db->get();
    }
    function update($id,$data){
        $data['dateadded']=date("y-m-d H:i:s");
        $this->db->update('interpreter_program',$data,array('id'=>$id));
        return $this->db->affected_rows();
    }
    function remove($id){
        $this->db->delete('interpreter_program',array('id'=>$id));
        return $this->db->affected_rows();
    }
    function add($data){
        $data['dateadded']=date("y-m-d H:i:s");
        $this->db->insert("interpreter_program",$data);
        return $this->db->affected_rows();
    }
}

?>
