<?php
class Hardware extends Controller{
function Hardware() {
        parent::Controller();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('Hardware_model');
        $this->Hardware_model->item=$this->uri->segment(3);
    }
    function audit(){       
       if(strtolower($_POST['Hostname'])==$this->_hostname()&& $this->_useragent()){
            foreach ($_POST as $key => $variable) {
                if($key!='end'){
                    if(stripos("Size Capacity AdapterRAM", $key)===false)
                        $data[$key]=$this->input->post($key,true);
                    else
                        $data[$key]=$this->input->post($key,true)/1048576; //change to mega byte
                }
            }
            if(count($data)>1)
                $this->Hardware_model->audit($data);
            if (isset($_POST['end']))
                $this->Hardware_model->auditend($data['Hostname']);
        }
    }
    function _hostname(){
		$hostname=gethostbyaddr($this->input->ip_address());
		if(strtolower($hostname)=="localhost")
			$hostname=$_SERVER["SERVER_NAME"];
		else{
			$host= explode(".",$hostname);
			$hostname=$host[0];
		}
		return strtolower($hostname);
	}
    function _useragent(){
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
