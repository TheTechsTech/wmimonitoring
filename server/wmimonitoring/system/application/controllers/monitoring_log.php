<?php
class Monitoring_log extends Controller{
    var $admin;
    function Monitoring_log(){
        parent::Controller();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('Monitoring_log_model');
        $this->load->library('session');
        $this->load->model('Registry_model');
        $this->load->model('Process_monitor_model');
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
        $this->load->view('monitoring_log_view');
    }
    function json_log(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        if($this->admin['type']=='Super Admin')
            $data=$this->Monitoring_log_model->get();
        else
            $data=$this->Monitoring_log_model->get($this->session->userdata['id']);
        for($i=0;$i<count($data);$i++){
            $output[$i]['id']=$i;
            $output[$i]['type']=$data[$i]['type'];
            $output[$i]['hostname']=$data[$i]['hostname'];
            $output[$i]['loginby']=$data[$i]['loginby'];
            $output[$i]['dateadded']=$data[$i]['dateadded'];
            $output[$i]['detail']="<a href=\"javascript:parent.".$data[$i]['type']."_showdetail(".$data[$i]['id'].")\"><img src=\"".base_url()."images/icon/detail.png\" title=\"show detail\"/></a>";
        }
        if(count($data)==0)
            $output[0]=array('id'=>"",'type'=>"",'hostname'=>"",'dateadded'=>"",'loginby'=>"",'detail'=>"");
        echo json_encode(array("identifier"=>"id","items"=>$output));        
    }
    function grid_log(){
        $this->load->view('grid_monitoring_view');
    }
    function detail_registry_trace(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $data=$this->Registry_model->get_trace_by_id($this->uri->segment(3));
        if(count($data)==1){
            foreach ($data[0] as $key => $value) {
                if(strpos("id status confirmby", $key)===false)
                    $output[$key]=$value;
            }
        }
        echo json_encode($output);
    }
    function detail_process_trace(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $data=$this->Process_monitor_model->get_by_id($this->uri->segment(3));
        if(count($data)==1){
            foreach ($data[0] as $key => $value) {
                if(strpos("id status confirmby", $key)===false)
                    $output[$key]=$value;
            }
        }
        echo json_encode($output);
    }
    function change_status_registry(){
        if($this->admin['type']!='Super Admin'){
            $data=$this->Registry_model->get_trace_by_id($this->uri->segment(3));
            if($data[0]['admin']!=$this->session->userdata('id'))
                redirect("/admin/access_denied");
        }
        $result=$this->Registry_model->change_status($this->uri->segment(3),$_POST['status_registry'],$this->session->userdata('id'));
        echo($result==0)?'false':'true';
    }
    function change_status_process(){
        $data=$this->Process_monitor_model->get_log_by_id($this->uri->segment(3));
        if($this->admin['type']!='Super Admin'){            
            if($data[0]['admin']!=$this->session->userdata('id'))
                redirect("/admin/access_denied");
        }
        $result=$this->Process_monitor_model->change_status($this->uri->segment(3),$_POST['status_process'],$this->session->userdata('id'));
        if(isset($_POST['white_list'])){
            //echo $data[0]['executecommand'].":".$this->session->userdata('id');
            $this->Process_monitor_model->add_white_list(array('executecommand'=>$data[0]['executecommand'],'addedby'=>$this->session->userdata('id')));
        }
        echo($result==0)?'false':'true';
    }
}