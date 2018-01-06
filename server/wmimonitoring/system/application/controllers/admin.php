<?php
class Admin extends Controller{
    var $user;
    function Admin(){
        parent::Controller();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Admin_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        if($this->session->userdata('id')!=false){
            $query=$this->Admin_model->getbyid($this->session->userdata('id'));
            $this->user=$query->row_array();
        }
    }
    function login(){
        $this->form_validation->set_rules("username","Username","trim|required|xss_clean");
        $this->form_validation->set_rules("password","Password","trim|required|md5|callback_checklogin|xss_clean");        
        if($this->form_validation->run())
            redirect("/report/"); //print_r($this->session->userdata('id'));
        else
            $this->load->view("admin_login_view");


    }
    function checklogin($str){
        $this->form_validation->set_message('checklogin', 'Invalid username or password ');
        $data=$this->Admin_model->login(set_value('username'),$str);
        if($data===false)
            return false;
        else{
            $this->session->set_userdata(array('id'=>$data['id']));
            return true;
        }

    }
    function index(){
        if($this->session->userdata('id')===false)
            $this->load->view("admin_login_view");
        else{
            $query=$this->Admin_model->getbyid($this->session->userdata('id'));
            if($query->num_rows()==1){
               $this->admin=$query->row_array();
               if($this->admin['status']==0)
                $this->load->view("admin_login_view");
               else
                redirect("/report/");
            }
        }
    }
    function logout(){
        $this->session->sess_destroy();
        $this->load->view("admin_login_view");
    }
    function access_denied(){
        $this->load->view('access_denied_view');
    }
    function change_password(){
        $data="";
        if($this->user['status']==0){
            redirect('admin/login');
        }
        $this->form_validation->set_rules("newpassword","Password","trim|required|md5|xss_clean");
        $this->form_validation->set_rules("oldpassword","Password","trim|required|md5|callback_checkpass|xss_clean");        
        if($this->form_validation->run())
            $data['message']="Password has been change";
        $this->load->view('header',$this->user);
        $this->load->view('change_password_view',$data);
    }
    function checkpass($str){        
        $data=$this->Admin_model->check_pass($this->session->userdata('id'),$str);
        if(count($data)==1){
            $result=$this->Admin_model->update($this->session->userdata('id'),array('password'=>set_value('newpassword')));
            if($result==1)
                return true;
            else{
                $this->form_validation->set_message('checkpass', 'Same old password and new password');
                return false;
            }
        }
        else{
            $this->form_validation->set_message('checkpass', 'Invalid old password ');
            return false;    
        }        
    }
}
