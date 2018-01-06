<?php
class Interpreter_program extends Controller{
    var $admin;
    function Interpreter_program(){
        parent::Controller();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Interpreter_program_model');
        $this->load->library('session');
        if($this->session->userdata('id')===false)
            redirect("/admin/");            
        else{
            $this->load->model('Admin_model');
            $query=$this->Admin_model->getbyid($this->session->userdata('id'));
            if($query->num_rows()==1){
               $this->admin=$query->row_array();
               if($this->admin['status']==0)
                redirect("/admin/");
            }
            else
               redirect("/admin/");
        }
    }
    function index(){
        $this->load->view('header',$this->admin);
        $this->load->view('interpreter_view');
    }
    function add(){
        foreach($_POST as $key => $value){
            $key1=str_replace("_displayed_", "", $key);
            $data[$key1]=$this->input->post($key, TRUE);
        }
        $data['addedby']=$this->session->userdata('id');
        $affected_rows=$this->Interpreter_program_model->add($data);
        if($affected_rows==1)
            echo "true";
        else
            echo "An unexpected error occurred";
    }
    function delete(){
        $affected_rows=$this->Interpreter_program_model->remove($this->uri->segment(3));
        if($affected_rows==1)
            echo "true";
        else
            echo "An unexpected error occurred";
    }
    function showgrid(){
        $this->load->view('grid_interpreter');
    }
    function jsondata(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $query=$this->Interpreter_program_model->getall();
        if($query->num_rows()>0){
            for($i=0;$i<$query->num_rows;$i++){
                $row=$query->row_array($i);
                $output[$i]['id']=$row['id'];
                $output[$i]['name']=$row['name'];
                $output[$i]['command']=$row['command'];
                $output[$i]['addedby']=$row['addedby'];
                $output[$i]['dateadded']=$row['dateadded'];
                $output[$i]['update']="<a href=\"javascript:parent.showupdate('".$row['id']."')\"><img src=\"".base_url()."images/icon/b_edit.png\" title=\"update\"/></a>";
                $output[$i]['delete']="<a href=\"javascript:parent.deletedata(".$row['id'].")\"><img src=\"".base_url()."images/icon/b_drop.png\" title=\"delete\"/></a>";
            }
        }
        else
            $output[0]=array('id'=>'','name'=>'','command'=>'','addedby'=>'','dateadded'=>'','update'=>'','delete'=>'');
        $output=json_encode(array("identifier"=>"id","items"=>$output));
        echo $output;
    }
    function databyid(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $query=$this->Interpreter_program_model->getbyid($this->uri->segment(3));
        if($query->num_rows()>0)
            $data=$query->row_array();
        else
            $data=array('id'=>'','name'=>'','command'=>'','addedby'=>'','dateadded'=>'');
        echo json_encode($data);
    }
    function update(){
        foreach($_POST as $key => $value){
            $key1=str_replace("_displayed_", "", $key);
            $data[$key1]=$this->input->post($key, TRUE);
        }
        $data['addedby']=$this->session->userdata('id');
        $affected_rows=$this->Interpreter_program_model->update($this->uri->segment(3),$data);
        if($affected_rows==1)
            echo "true";
        else
            echo "An unexpected error occurred";
    }
}
?>
