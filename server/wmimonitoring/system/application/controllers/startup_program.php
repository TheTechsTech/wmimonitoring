<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Startup_program extends Controller{
    function Startup_program() {
        parent::Controller();
        $this->load->model('Startup_program_model');
        $this->load->database();
    }
    function audit(){
        if(strtolower($_POST['Hostname'])==$this->hostname()&& $this->useragent()){
            foreach ($_POST as $key => $variable) {
                if($key!='end')
                    $data[$key]=$this->input->post($key,true);
            }
            $this->Startup_program_model->audit($data);
            if (isset($_POST['end']))
                $this->Startup_program_model->auditend($data['Hostname']);
        }
    }
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