<?php
class Change_log extends Controller{
    var $admin;
    function Change_log(){
        parent::Controller();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Hardware_model');
        $this->load->model('Software_model');
        $this->load->model('Startup_program_model');
        if($this->session->userdata('id')===false)
            redirect("/admin/");
        else{
            $this->load->model('Admin_model');
            $query=$this->Admin_model->getbyid($this->session->userdata('id'));
            if($query->num_rows()==1){
               $this->admin=$query->row_array();
               if($this->admin['status']==0){
                redirect("/admin/");
               }
            }
            else{
               redirect("/admin/");
            }
        }
    }
    function index(){
        //$this->load->view('change_log_view');
    }
    function change_status_hardware(){
        $this->load->view('header',$this->admin);
        $this->load->view('change_status_hardware_view');
    }
    function change_status_software(){
        $this->load->view('header',$this->admin);
        $this->load->view('change_status_software_view');
    }
    function change_status_startup(){
        $this->load->view('header',$this->admin);
        $this->load->view('change_status_startup_view');
    }
    function json_log_hardware(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        if ($this->admin['type']=="Super Admin")
            $result=$this->Hardware_model->get_log();
        else
            $result=$this->Hardware_model->get_log($this->admin['id']);
            //print_r($result);
        for ($i=0;$i<count($result);$i++){
            $data[$i]['id']=$i;
            $data[$i]['hostname']=$result[$i]['hostname'];
            $data[$i]['date']=$result[$i]['date'];
            $data[$i]['item']=$result[$i]['item'];
            $data[$i]['status']=$result[$i]['status'];
            $data[$i]['approve']="<input type=\"radio\" name=\"".$result[$i]['item']."[".$result[$i]['id']."]\" value=\"approve\"/>";
            $data[$i]['ignore']="<input type=\"radio\" name=\"".$result[$i]['item']."[".$result[$i]['id']."]\" value=\"ignore\"/>";
            $data[$i]['detail']="<a href=\"javascript:parent.showdetail(".$result[$i]['id'].",'".$result[$i]['item']."')\"><img src=\"".base_url()."images/icon/detail.png\" title=\"show detail\"/></a>";
        }
        if(count($result)==0)
            $data[0]=array('id'=>'','hostname'=>'','date'=>'','item'=>'','status'=>'','approve'=>'','ignore'=>'','detail'=>'');
        echo json_encode(array("identifier"=>"id","items"=>$data));
    }
    function json_log_software(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        if ($this->admin['type']=="Super Admin")
            $result=$this->Software_model->get_log();
        else
            $result=$this->Software_model->get_log($this->admin['id']);
         for ($i=0;$i<count($result);$i++){
            $data[$i]['id']=$result[$i]['id'];
            $data[$i]['hostname']=$result[$i]['hostname'];
            $data[$i]['date']=$result[$i]['date'];
            $data[$i]['status']=$result[$i]['status'];
            $data[$i]['approve']="<input type=\"radio\" name=\"".$result[$i]['id']."\" value=\"approve\"/>";
            $data[$i]['ignore']="<input type=\"radio\" name=\"".$result[$i]['id']."\" value=\"ignore\"/>";
            $data[$i]['detail']="<a href=\"javascript:parent.showdetail(".$result[$i]['id'].")\"><img src=\"".base_url()."images/icon/detail.png\" title=\"show detail\"/></a>";
        }
        if(count($result)==0)
            $data[0]=array('id'=>'','hostname'=>'','date'=>'','status'=>'','approve'=>'','ignore'=>'','detail'=>'');
        echo json_encode(array("identifier"=>"id","items"=>$data));
    }
    function json_log_startup(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        if ($this->admin['type']=="Super Admin")
            $result=$this->Startup_program_model->get_log();
        else
            $result=$this->Startup_program_model->get_log($this->admin['id']);
        for($i=0;$i<count($result);$i++){
            $data[$i]['id']=$result[$i]['id'];
            $data[$i]['hostname']=$result[$i]['hostname'];
            $data[$i]['date']=$result[$i]['date'];
            $data[$i]['status']=$result[$i]['status'];
            $data[$i]['approve']="<input type=\"radio\" name=\"".$result[$i]['id']."\" value=\"approve\"/>";
            $data[$i]['ignore']="<input type=\"radio\" name=\"".$result[$i]['id']."\" value=\"ignore\"/>";
            $data[$i]['detail']="<a href=\"javascript:parent.showdetail(".$result[$i]['id'].")\"><img src=\"".base_url()."images/icon/detail.png\" title=\"show detail\"/></a>";
        }
        if(count($result)==0)
            $data[0]=array('id'=>"",'hostname'=>"",'date'=>"",'status'=>"",'approve'=>"",'ignore'=>"",'detail'=>"");
        echo json_encode(array("identifier"=>"id","items"=>$data));
    }
    function grid_log_hardware(){
        $this->load->view('grid_log_hardware_view');
    }
    function grid_log_software(){
        $this->load->view('grid_log_software_view');
    }
    function grid_log_startup(){
        $this->load->view('grid_log_startup_view');
    }
    function detail_hardware(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        foreach($_GET as $key=>$value){
            $get[$key]=$this->input->get($key,TRUE);
        }
        $data=$this->Hardware_model->get_detail($get['id'],$get['item']);
        if(count($data)==1){
            foreach($data[0] as $key=>$value){
                if(strpos("dateremove status flag status adminapprove id", $key)===false)
                if(is_int(strpos("size capacity adapterram",$key)))
                    $output[$key]=$data[0][$key]." MB";
                else
                    $output[$key]=$data[0][$key];
            }
        }
        echo json_encode($output);
    }
    function detail_software(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $data=$this->Software_model->get_by_id($this->uri->segment(3));
        if(count($data)==1){
            foreach($data[0] as $key=>$value){
                if(strpos("dateremove status flag status adminapprove id", $key)===false)
                    $output[$key]=$data[0][$key];
            }
        }
        echo json_encode($output);
    }
    function detail_startup(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $data=$this->Startup_program_model->get_by_id($this->uri->segment(3));
        if(count($data)==1){
            foreach($data[0] as $key=>$value){
                if(strpos("dateremove status flag status adminapprove id", $key)===false)
                    $output[$key]=$data[0][$key];
            }
        }
        echo json_encode($output);
    }
    function save_hardware_status(){
        foreach ($_POST as $key1 => $variable) {
            foreach ($variable as $key2 => $value) {
                $this->Hardware_model->item=$key1;
                if($this->admin['type']!='Super Admin'){
                    $data=$this->Hardware_model->get_log_by_id($key2);
                    if($data[0]['admin']!=$this->session->userdata('id'))
                        redirect("/admin/access_denied");
                }
                if($value=='approve')
                    $this->Hardware_model->approve_change($key2,$this->session->userdata('id'));                
                if($value=='ignore')
                    $this->Hardware_model->ignore_change($key2,$this->session->userdata('id'));                
            }
        }
        echo 'true';
    }
    function save_software_status(){
        foreach ($_POST as $key1 => $variable) {            
            if($this->admin['type']!='Super Admin'){
                $data=$this->Software_model->get_log_by_id($key1);
                if($data[0]['admin']!=$this->session->userdata('id'))
                    redirect("/admin/access_denied");
            }
            if($variable=='approve')
                $this->Software_model->approve_change($key1,$this->session->userdata('id'));                
            if($variable=='ignore')
                $this->Software_model->ignore_change($key1,$this->session->userdata('id'));               
        }
        echo 'true';
    }
    function save_startup_status(){
        foreach ($_POST as $key1 => $variable) {            
            if($this->admin['type']!='Super Admin'){
                $data=$this->Startup_program_model->get_log_by_id($key1);
                if($data[0]['admin']!=$this->session->userdata('id'))
                    redirect("/admin/access_denied");
            }
            if($variable=='approve')
                $this->Startup_program_model->approve_change($key1,$this->session->userdata('id'));                
            if($variable=='ignore')
                $this->Startup_program_model->ignore_change($key1,$this->session->userdata('id'));               
        }
        echo 'true';
    }


}