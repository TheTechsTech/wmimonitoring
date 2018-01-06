<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Logicaldisk extends Controller{
    function Logicaldisk() {
        parent::Controller();
        $this->load->model('Logicaldisk_model');
        $this->load->database();
    }
    function audit(){
        if(strtolower($_POST['Hostname'])==$this->hostname()&& $this->useragent()){
            foreach ($_POST as $key => $variable) {
                if($key!='end'){
                    if($key=='FreeSpace'||$key=='Size')
                        $data[$key]=$this->input->post($key,true)/1048576; //change to mega byte
                    else
                        $data[$key]=$this->input->post($key,true);
                }
            }
            $this->Logicaldisk_model->audit($data);
            if (isset($_POST['end']))
                $this->Logicaldisk_model->auditend($data['Hostname']);
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