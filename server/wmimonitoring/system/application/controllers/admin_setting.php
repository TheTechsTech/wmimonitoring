<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_setting extends Controller{
   var $admin;
   function Admin_setting() {
        parent::Controller();
		$this->load->database();
        $this->load->helper('url');
        $this->load->model('Admin_model');
        $this->load->library('session');
        if($this->session->userdata('id')===false)
            redirect("/admin/");
        else{
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
        if($this->admin['type']!='Super Admin')
            redirect("/admin/access_denied");
        $data['username']=$this->session->userdata('username');
        $data['usertype']=$this->session->userdata('type');
        $this->load->view('header',$this->admin);
        $this->load->view('admin_view',$data);
    }
    function add(){
        if($this->admin['type']!='Super Admin')
            redirect("/admin/access_denied");
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'callback_username_check');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|md5');
        if($this->form_validation->run()){
            foreach ($_POST as $key=>$value){
                if(strpos($key, "password1")===false){
                    $key1=str_replace("_displayed_", "", $key);
                    $data[$key1]=$this->input->post($key, TRUE);
                }
            }
            $affected_rows=$this->Admin_model->add($data);
            if($affected_rows==1)
                echo "true";
            else
                echo "An unexpected error occurred";
        }
        else
            echo "Exist Username";
    }
    function showgrid(){
        $this->load->view("grid_admin");
    }
    function jsondata(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $query=$this->Admin_model->getall();
        for($i=0; $i<$query->num_rows();$i++){
            $row=$query->row_array($i);
            $output[$i]['username']=$row['username'];
            $output[$i]['name']=$row['name'];
            $output[$i]['type']=$row['type'];            
            $output[$i]['dateadded']=$row['dateadded'];
            $output[$i]['status']=(($row['status']==1)?"Active":"Deactive");
            $output[$i]['update']="<a href=\"javascript:parent.showupdate('".$row['id']."')\"><img src=\"".base_url()."images/icon/b_edit.png\" title=\"update\"/></a>";
            $output[$i]['delete']="<a href=\"javascript:parent.".(($row['status']==1)?"deactivedata":"activedata")."('".$row['id']."')\"><img src=\"".base_url()."images/icon/".(($row['status']==1)?"b_drop.png":"check.png")."\" title=\"".(($row['status']==1)?"Deactive":"Active")."\"/></a>";
        }
        if($query->num_rows()==0)
            $output[0]=array('username'=>"",'name'=>"",'type'=>"",'dateadded'=>"",'status'=>"",'update'=>"",'delete'=>"");
        $output=json_encode(array("identifier"=>"username","items"=>$output));
        echo $output;
    }
    function databyid(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $query=$this->Admin_model->getbyid($this->uri->segment(3));
        if($query->num_rows()>0)
            $data=$query->row_array();
        else
            $data=array('id'=>"",'username'=>"",'name'=>"",'type'=>"",'dateadded'=>"",'status'=>"",'update'=>"",'delete'=>"");
        echo json_encode($data);        
    }
    function update(){
        if($this->admin['type']!='Super Admin')
            redirect("/admin/access_denied");
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'callback_username_id');
        if($this->form_validation->run()){
            foreach ($_POST as $key=>$value){
                $key1=str_replace("_displayed_", "", $key);
                if(strpos("password password1",$key)===false)
                    $data[$key1]=$this->input->post($key, TRUE);
            }
            $affected_rows=$this->Admin_model->update($this->uri->segment(3),$data);
            if($affected_rows==1)
                echo "true";
            else
                echo "An unexpected error occurred";
        }
        else
            echo "Exist Username";
    }
    function deactivate(){
        $affected_rows=$this->Admin_model->deactive($this->uri->segment(3));
        if($affected_rows==1)
            echo "true";
        else
            echo "An unexpected error occurred";
    }
    function activate(){
        $affected_rows=$this->Admin_model->active($this->uri->segment(3));
        if($affected_rows==1)
            echo "true";
        else
            echo "An unexpected error occurred";
    }
    function username_check($str){
        $query=$this->Admin_model->getbyname($str);
        if($query->num_rows()==1)
            return false;
        else
            return true;
    }
    function username_id($str){
        $query=$this->Admin_model->getbyname_id($str,$this->uri->segment(3));
        //echo $this->db->last_query();
        if($query->num_rows()==1)
            return false;
        else
            return true;

    }
}