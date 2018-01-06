<? 
class Process_monitor extends Controller{
	function Process_monitor(){
		parent::Controller();
		$this->load->library('input');
        $this->load->database();
        $this->load->model('Process_monitor_model');
	}	
	function listing_interpreter(){
		if(strtolower($_POST['Hostname'])==$this->hostname()&& $this->useragent()){
            $this->load->model('Interpreter_program_model');
            $query=$this->Interpreter_program_model->getall();
            $output="";
            for($i=0;$i<$query->num_rows();$i++){
                $row=$query->row_array($i);
                $output=$output.$row['command']." ";
            }
			echo $output;
		}
	}
	function run(){
		if(strtolower($_POST['Hostname'])==$this->hostname()&& $this->useragent()){ 		
	        foreach ($_POST as $key => $value) {
	            $data[$key]=$this->input->post($key,true);
	        }            
            $this->Process_monitor_model->add($data);
            echo "true";
		}
	}
    function white_list(){
        $this->load->library('session');
        if ($this->session->userdata('id')===false) {
            redirect('/admin/');
        }
        else{
            $this->load->model('Admin_model');
            $this->load->helper('url');
            $query=$this->Admin_model->getbyid($this->session->userdata('id'));
            if($query->num_rows()==1){
               $admin=$query->row_array();
               if($admin['status']==0)
                redirect("/admin/");
               elseif($admin['type']!='Super Admin')
                redirect("/admin/access_denied");
            }
            foreach($_POST as $key=>$value){
                $this->Process_monitor_model->delete_whitelist(array('id'=>$key));
            }
            $output['data']=$this->Process_monitor_model->get_whitelist();
            //echo json_encode($this->Process_monitor_model->get_whitelist());
            $this->load->view('header',$admin);
            $this->load->view('whilelist_view',$output);
        }

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
