<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Computer_setting extends Controller{
     var $admin;
    function Computer_setting(){
        parent::Controller();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Computer_model');
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
        //$data["admin"]=$this->admin;
        //$this->load->view('computer_setting_view',$data);
    }
    function change_status(){
        if($this->admin['type']!='Super Admin'){
            redirect("/admin/access_denied");
        }
        $this->load->view('header',$this->admin);
        $this->load->view('change_status_view');
    }
    function set_computer_admin(){
        if($this->admin['type']!='Super Admin'){
            redirect("/admin/access_denied");
        }
        if($this->input->post('admin')!=false){
            foreach ($_POST as $key=>$value):
                $key1=str_replace("_displayed_", "", $key);
                $data_admin[$key1]=$this->input->post($key);
            endforeach;
            foreach($data_admin['admin']as $key=>$value){
                $this->Computer_model->set_admin($key,$value);
            }
        }
        $query=$this->Computer_model->get_all(true);
        if($query->num_rows()==0)
            $output['computer']=false;
        else{
            for($i=0;$i<$query->num_rows();$i++)
                $data[$i]=$query->row_array($i);
            $output['computer']=$data;
        }
        //echo json_encode($output);
        $this->load->view('header',$this->admin);
        $this->load->view('set_computer_admin_view',$output);
    }
    function show_detail(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $result=$this->Computer_model->get_by_id($this->uri->segment(3));
        if($result===false)
            echo json_encode(false);
        else{
            foreach ($result as $key=>$value):
                if(strpos("last_time_hw_audit last_time_sw_audit computer_profile admin reason", $key)===false)
                    $output[$key]=$result[$key];
            endforeach;
            echo json_encode($output);
        }
    }
    function save_status(){
        if($this->admin['type']!='Super Admin'){
            redirect("/admin/access_denied");
        }
        foreach ($_POST as $key=>$value):
            $key1=str_replace("_displayed_", "", $key);
            $data[$key1]=$this->input->post($key, TRUE);
        endforeach;
        $result=$this->Computer_model->update_status($data,$this->uri->segment(3),$this->session->userdata('id'));
        echo($result==1)?"true":"An unexpected error occurred";
    }
    function grid_log_computer(){
        $this->load->view('grid_log_computer_view');
    }
    function json_log_computer(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $query=$this->Computer_model->get_log();
        if($query->num_rows()==0)
            $data[0]=array('id'=>"",'hostname'=>"",'date'=>"",'detail'=>"");
        for($i=0;$i<$query->num_rows();$i++){
            $row=$query->row_array($i);
            $data[$i]['id']=$row['id'];
            $data[$i]['hostname']=$row['hostname'];
            $data[$i]['date']=$row['date'];
            $data[$i]['detail']="<a href=\"javascript:parent.showdetail(".$row['id'].",'".$row['status']."')\"><img src=\"".base_url()."images/icon/detail.png\" title=\"show detail\"/></a>";
        }
        $output=json_encode(array("identifier"=>"id","items"=>$data));
        echo $output;
    }
    function json_admin(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $query=$this->Admin_model->getactive();
        for($i=0;$i<$query->num_rows();$i++){
            $row=$query->row_array($i);
            $data[$i]['id']=$row['id'];
            $data[$i]['username']=$row['username'];
        }
        $output=array('identifier'=>"id",'label'=>"username",'items'=>$data);
        echo json_encode($output);
    }
    function json_computer_profile(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $this->load->model('Computer_profile_model');
        $result=$this->Computer_profile_model->get_id();
        ///echo json_encode($result);
        for($i=0; $i<count($result);$i++){
            $output[$i]['id']=$result[$i]['id'];
            $output[$i]['label']=$result[$i]['name']." - ".$result[$i]['username'];
        }
        if(count($result)==0)
            $output[0]=array('id'=>"",'label'=>"");
        $output=json_encode(array("identifier"=>"id",'label'=>"label","items"=>$output));
        echo $output;
    }
    function set_computer_profile(){        
        if($this->input->post('profile')!=false){
            foreach ($_POST as $key=>$value):
                $key1=str_replace("_displayed_", "", $key);
                $data_profile[$key1]=$this->input->post($key);
            endforeach;
            foreach($data_profile['profile']as $key=>$value){
                $this->Computer_model->set_profile($key,$value);
            }
        }
        if($this->admin['type']=='Super Admin')
            $query=$this->Computer_model->get_all(true);
        else
            $query=$this->Computer_model->get_all(true,$this->session->userdata('id'));
        if($query->num_rows()==0)
            $output['computer']=false;
        else{
            for($i=0;$i<$query->num_rows();$i++)
                $data[$i]=$query->row_array($i);
            $output['computer']=$data;
        }
        //echo json_encode($output);
        $this->load->view('header',$this->admin);
        $this->load->view('set_computer_profile_view',$output);
    }
    function detail(){
        $this->load->view('header',$this->admin);
        $this->load->view('detail_computer_view',$this->admin);
    }
    function json_computer(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        if($this->admin['type']=='Super Admin')
            $result=$this->Computer_model->get(array('status'=>array('added','remove')));
        else
            $result=$this->Computer_model->get(array('status'=>array('added','remove'),'admin'=>$this->session->userdata('id')));
        if(count($result)==0)
            $output[0]=array('id'=>'','hostname'=>'','date'=>'','admin'=>'','detail'=>'');
        else{
            for($i=0;$i<count($result);$i++){
                $output[$i]['id']=$result[$i]['id'];
                $output[$i]['hostname']=$result[$i]['hostname'];
                $output[$i]['admin']=$result[$i]['admin_name'];
                $output[$i]['date']=$result[$i]['dateadded'];
                $output[$i]['detail']="<a href=\"javascript:parent.showdetail(".$result[$i]['id'].")\"><img src=\"".base_url()."images/icon/detail.png\" title=\"show detail\"/></a>";
            }
        }
        echo json_encode(array('identifier'=>'id','items'=>$output));
    }
    function grid_computer(){
        $this->load->view('grid_computer_view');
    }
    function detail_computer(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $result=$this->Computer_model->get(array('id'=>$this->uri->segment(3)));
        $data_hide=array('dateremove','admin','adminapprove','reason','computer_profile');
        foreach ($data_hide as $value) {
            unset($result[0][$value]);
        }
        echo json_encode($result[0]);
    }
    function detail_hardware(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $this->Hardware_model->item=$this->input->get('item',true);
        $result=$this->Hardware_model->get(array('status'=>$this->input->get('status',true),'hostname'=>$this->input->get('hostname',true)));
        $data_hide=array('dateremove','flag','adminapprove');
        foreach ($data_hide as $value) {
            for($i=0;$i<count($result);$i++)
                unset($result[$i][$value]);
        }
        echo json_encode($result);
    }
    function detail_software(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $result=$this->Software_model->get(array('status'=>$this->input->get('status',true),'hostname'=>$this->input->get('hostname',true)));
        $data_hide=array('dateremove','flag','adminapprove');
        foreach ($data_hide as $value) {
            for($i=0;$i<count($result);$i++)
                unset($result[$i][$value]);
        }
        echo json_encode($result);
    }
    function detail_startup(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $result=$this->Startup_program_model->get(array('startup.status'=>$this->input->get('status',true),'startup.hostname'=>$this->input->get('hostname',true)));
        $data_hide=array('dateremove','flag','adminapprove');
        foreach ($data_hide as $value) {
            for($i=0;$i<count($result);$i++)
                unset($result[$i][$value]);
        }
        echo json_encode($result);
    }
    function delete_computer(){
        $item_hardware=array('base_board','cdrom','firewire','floppy','hardisk','keyboard','logicaldisk','memory','modem','monitor','mouse','networkcard','printer','processor','sound','usb','vga');
        if($this->admin['type']!='Super Admin'){
            redirect("/admin/access_denied");
        }
        $result=$this->Computer_model->get(array('id'=>$this->uri->segment(3)));
        if(count($result)==1){
            if($result[0]['status']=='remove'){
                $this->Computer_model->approve_remove($this->uri->segment(3),array('reason'=>'Broken Computer'),$this->session->userdata('id'));
                foreach($item_hardware as $item){
                    $this->Hardware_model->item=$item;
                    $harware=$this->Hardware_model->get(array('hostname'=>$result[0]['hostname'],'status'=>'remove'));
                    foreach($harware as $data)
                        $this->Hardware_model->approve_change($data['id'],$this->session->userdata('id'));
                }
                $software=$this->Software_model->get(array('hostname'=>$result[0]['hostname'],'status'=>'remove'));
                foreach($software as $data)
                    $this->Software_model->approve_change($data['id'],$this->session->userdata('id'));
                $startup=$this->Startup_program_model->get(array('hostname'=>$result[0]['hostname'],'status'=>'remove'));
                foreach($software as $data)
                    $this->Startup_program_model->approve_change($data['id'],$this->session->userdata('id'));
            }
            else{
                $this->Computer_model->deleted(array('id'=>$this->uri->segment(3)),$this->session->userdata('id'));
                foreach ($item_hardware as $item){
                    $this->Hardware_model->item=$item;
                    $this->Hardware_model->deleted($this->session->userdata('id'),array('hostname'=>$result[0]['hostname'],'status'=>array('added','new')));
                }
                $this->Software_model->deleted($this->session->userdata('id'),array('hostname'=>$result[0]['hostname'],'status'=>array('added','new')));
                $this->Startup_program_model->deleted($this->session->userdata('id'),array('hostname'=>$result[0]['hostname'],'status'=>array('added','new')));
            }
        echo 'true';
        }
        else
            echo 'false';
    }
}

