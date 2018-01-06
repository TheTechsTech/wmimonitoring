<?
class Registry_monitor extends Controller{
	function Registry_monitor(){
		parent::Controller();
		$this->load->library('input');
        $this->load->database();
        $this->load->model('Registry_model');
	}	
	function tree_change(){
		if(strtolower($_POST['Hostname'])==$this->hostname()&& $this->useragent()){
            foreach ($_POST as $key => $value) {
	            $data[$key]=$this->input->post($key,true);
	        }
	        $this->Registry_model->add_trace($data);
            echo "true";
		}
	}
	function get_list(){
		$this->load->helper('url');
        $this->load->model('Registry_model');
		$list_key=null;
		//$list_key=array(array("root"=>"HKEY_LOCAL_MACHINE","key"=>"SOFTWARE\\\\Microsoft\\\\Windows\\\\CurrentVersion\\\\Run"),array("root"=>"HKEY_CURRENT_USER","key"=>"Software\\\\Microsoft\\\\Windows\\\\CurrentVersion\\\\Run"));
        $query=$this->Registry_model->getbyarch($this->uri->segment(3));
        for($i=0;$i<$query->num_rows();$i++){
            $row=$query->row_array($i);
            $key=str_replace("\\", "\\\\", $row['path']);
            $list_key[]=array('root'=>$row['hive'],'key'=>$key);
        }
		$jsondata=json_encode($list_key);
		echo $jsondata;
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
	private function hostname(){
		$hostname=gethostbyaddr($this->input->ip_address());
		if(strtolower($hostname)=="localhost")
			$host[0]="canggih";
		else
			$host= explode(".",$hostname);
		return $host[0];
	}
}
?>