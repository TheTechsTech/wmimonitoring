<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Computer extends Controller{
    function Computer() {
        parent::Controller();
        $this->load->model('Computer_model');
        $this->load->database();
    }
    function audit(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $this->load->helper('date');
        if(strtolower($_POST['Hostname'])==$this->hostname()&& $this->useragent()){
            $this->load->model('Computer_profile_model');
            foreach ($_POST as $key => $variable) {
                if($key!='username')
                    $data[$key]=$this->input->post($key,true);
                else
                    $loginuser[$key]=$this->input->post($key,true);
            }
            $computer_data=$this->Computer_model->audit($data);
            $loginuser['Hostname']=$data['Hostname'];
            $this->Computer_model->loguser($loginuser);
            if($computer_data!="new"){
                $result=$this->Computer_model->get_status(array('hostname'=>$data['Hostname'],'status'=>$computer_data[0]['status']));
                $status=$result[0];
            }
            else{
                $profile=$this->Computer_model->get_profile(array('id'=>1));
                $status=array('audit_hw'=>1,'audit_sw'=>1,'monitor_registry'=>$profile[0]['is_monitor_registry'],'monitor_process'=>$profile[0]['is_monitor_process']);
            }
           if($status['audit_hw']==1)
                $this->Computer_model->update_last_time_hw_audit($data['Hostname']);
           if($status['audit_sw']==1)
                $this->Computer_model->update_last_time_sw_audit($data['Hostname']);
           echo json_encode($status);
        }        
    }
//    function tes(){
//        $status=array('audit_hw'=>$audit_hw,'audit_sw'=>$audit_sw,'monitor_registry'=>$profile['is_monitor_registry'],'monitor_process'=>$profile['is_monitor_process']);
//        echo json_encode($status);
//    }
    private function hostname(){
		$hostname=gethostbyaddr($this->input->ip_address());
		if(strtolower($hostname)=="localhost")
			$hostname=$_SERVER["SERVER_NAME"];
		else{
			$host= explode(".",$hostname);
			$hostname=$host[0];
		}
		return strtolower($hostname);
	}
    private function useragent(){
        $this->load->library('user_agent');
        if(($this->agent->browser()=="Internet Explorer")){
        	$hasil=true;
        }else{
        	$hasil=false;
        }
		return $hasil;
	}
}

?>
