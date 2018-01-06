<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Software extends Controller{
    function Software() {
        parent::Controller();
        $this->load->database();
        $this->load->model('Software_model');
    }
    function audit(){
        if(strtolower($_POST['Hostname'])==$this->hostname()&& $this->useragent()){
            foreach ($_POST as $key => $variable) {
                if($key!='end')
                    $data[$key]=$this->input->post($key,true);
            }
            if(count($data)>1)
                $this->Software_model->audit($data);
            if (isset($_POST['end']))
                $this->Software_model->auditend($data['Hostname']);
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