<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Computer_profile extends Controller{
    var $admin;
   function Computer_profile() {
        parent::Controller();
	$this->load->database();
        $this->load->helper('url');
        $this->load->model('Computer_profile_model');
        $this->load->library('session');        
        if($this->session->userdata('id')===false)
            redirect("/admin/");
        else{
            $this->load->model('Admin_model');
            $query=$this->Admin_model->getbyid($this->session->userdata('id'));
            //echo $this->db->last_query();
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
        $this->load->view('computer_profile_view');
    }
    function add(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|callback_name_check');
        if($this->form_validation->run()){
            foreach ($_POST as $key=>$value){
                $key1=str_replace("_displayed_", "", $key);
                $data[$key1]=$this->input->post($key, TRUE);
                
            }
            $data['is_monitor_registry']=(isset ($data['is_monitor_registry'])?$data['is_monitor_registry']:0);
            $data['is_monitor_process']=(isset ($data['is_monitor_process'])?$data['is_monitor_process']:0);
            $data['admin']=$this->session->userdata('id');
            $affected_rows=$this->Computer_profile_model->add($data);
            if($affected_rows==1)
                echo "true";
            else
                echo "An unexpected error occurred";
        }
        else
            echo "Exist Name Profile";
    }
    function showgrid(){
        $this->load->view("grid_computer_profile");
    }
    function jsondata(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $query1=$this->Computer_profile_model->getall();
        //echo $this->admin['type'];
        //echo $this->db->last_query();
        $query=$this->Computer_profile_model->getall_status($this->session->userdata('id'));
        //echo $this->db->last_query();
        for($i=0; $i<$query->num_rows();$i++){
            $row=$query->row_array($i);
            $output[$i]['id']=$row['id'];
            $output[$i]['name']=$row['name'];
            $output[$i]['admin']=$row['admin'];
            $output[$i]['label']=$row['name']." - ".$row['admin'];
            $output[$i]['timing_audit_hw']=$row['timing_audit_hw'];
            $output[$i]['timing_audit_sw']=$row['timing_audit_sw'];
            $output[$i]['is_monitor_registry']=(($row['is_monitor_registry']==1)?"Yes":"No");
            $output[$i]['is_monitor_process']=(($row['is_monitor_process']==1)?"Yes":"No");
            $output[$i]['dateadded']=$row['dateadded'];
            $output[$i]['update']="<a href=\"javascript:parent.showupdate(".$row['id'].")\"><img src=\"".base_url()."images/icon/b_edit.png\"/></a>";
            $output[$i]['delete']=(($row['Count_computer']>0||$row['id']==1)?"":"<a href=\"javascript:parent.deletedata(".$row['id'].")\"><img src=\"".base_url()."images/icon/b_drop.png\" title=\"delete\"/></a>");
        }
        if($query1->num_rows()==0)
            $output[0]=array('id'=>"",'name'=>"",'admin'=>"",'timing_audit_hw'=>"",'timing_audit_sw'=>"",'is_monitor_registry'=>"",'is_monitor_process'=>"",'dateadded'=>"",'update'=>"",'delete'=>"");
        $output=json_encode(array("identifier"=>"id",'label'=>"label","items"=>$output));
        echo $output;
        //echo $this->db->last_query();
    }
    function databyid(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $query=$this->Computer_profile_model->getbyid($this->uri->segment(3));
        if($query->num_rows()>0){
            $data=$query->row_array();
            $data['is_monitor_registry']=(($data['is_monitor_registry']==1)?true:false);
            $data['is_monitor_process']=(($data['is_monitor_process']==1)?true:false);
        }
        else
            $data=array('id'=>"",'name'=>"",'admin'=>"",'timing_audit_hw'=>"",'timing_audit_sw'=>"",'is_monitor_registry'=>"",'is_monitor_process'=>"",'dateadded'=>"");
        echo json_encode($data);
    }
    function update(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|callback_name_check_id');
        if($this->form_validation->run()){
            foreach ($_POST as $key=>$value){
                $key1=str_replace("_displayed_", "", $key);
                //if(strpos("name", $key1)===false)
                $data[$key1]=$this->input->post($key, TRUE);
            }
            $data['is_monitor_registry']=(isset ($data['is_monitor_registry'])?$data['is_monitor_registry']:0);
            $data['is_monitor_process']=(isset ($data['is_monitor_process'])?$data['is_monitor_process']:0);
            if($this->admin['type']!="Super Admin"){
                $query=$this->Computer_profile_model->getbyid($this->uri->segment(3));
            }
            $affected_rows=$this->Computer_profile_model->update($this->uri->segment(3),$data);
            if($affected_rows==1)
                echo "true";
            else
                echo "An unexpected error occurred";
        }
        else
            echo "Exist Name Profile";
    }
    function delete(){
        $query1=$this->Computer_profile_model->getbyid($this->uri->segment(3));
        $query=$this->Computer_profile_model->getbyid_status($this->uri->segment(3));
        if($query1->num_rows()>0){
            $data=$query->row_array();
            if($data['Count_computer']==0 && $data['id']!=1){
                if($this->admin['type']=='Super Admin'){
                    $affected_rows=$this->Computer_profile_model->delete($this->uri->segment(3));
                }
                elseif($data['admin']==$this->session->userdata('id')){
                    $affected_rows=$this->Computer_profile_model->delete($this->uri->segment(3));
                }
                else
                    $affected_rows=-1;
            }
            else
                $affected_rows=-1;
            if($affected_rows==1)
                echo "true";
            elseif($affected_rows==-1)
                echo "Access Denied";
            else
                echo "An unexpected error occurred";
       }
       else
            echo "An unexpected error occurred";
    }    
    function name_check($str){
        $query=$this->Computer_profile_model->getbyname($str,$this->session->userdata('id'));
        if($query->num_rows()>0)
            return false;
        else
            return true;
    }
    function name_check_id($str){
        $query=$this->Computer_profile_model->getbyname($str,$this->session->userdata('id'),$this->uri->segment(3));
        if($query->num_rows()>0)
            return false;
        else
            return true;
        
    }
}