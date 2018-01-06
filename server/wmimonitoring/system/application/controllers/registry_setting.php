<?
class Registry_setting extends Controller {
    var $admin;
    function  Registry_setting(){
        parent::Controller();
	$this->load->helper('url');
	$this->load->database();
	$this->load->model('Registry_model');
        $this->load->library('session');
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
        //$this->load->library('user_agent');
        //$data['browser']=$this->agent->browser();
        $this->load->view('header',$this->admin);
	$this->load->view('registry_view');
    }
    function add(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
	foreach ($_POST as $key=>$value){
            $key1=str_replace("_displayed_", "", $key);
            $data[$key1]=$this->input->post($key, TRUE);
	}
        $data['addedby']=$this->session->userdata('id');
	$affected_rows=$this->Registry_model->addkey($data);
        if($affected_rows==1)
            echo "true";
        else
            echo "An unexpected error occurred";
    }
    function remove(){
	$affected_rows=$this->Registry_model->remove($this->uri->segment(3));
        if($affected_rows==1)
            echo "true";
        else
            echo "An unexpected error occurred";
    }
    function update(){
	header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache"); 
	foreach ($_POST as $key=>$value){
            $key1=str_replace("_displayed_", "", $key);
            $data[$key1]=$this->input->post($key, TRUE);
	}
        $data['addedby']=$this->session->userdata('id');
	$affected_rows=$this->Registry_model->update($this->uri->segment(3),$data);
        if($affected_rows==1)
            echo "true";
        else
            echo "An unexpected error occurred";
    }
    function databyid(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $query=$this->Registry_model->getbyid($this->uri->segment(3));
        //echo $this->uri->segment(3);
        //echo $query->num_rows();
        if($query->num_rows()>0){
            $data=$query->row_array();
            echo json_encode($data);
        }
    }
    function jsondata(){
        header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); // Date in the past
        header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
        $query=$this->Registry_model->getall();
        for($i=0; $i<$query->num_rows();$i++){
            $row=$query->row_array($i);
            $output[$i]['id']=$row['id'];
            $output[$i]['hive']=$row['hive'];
            $output[$i]['path']=$row['path'];
            $output[$i]['arch']=$row['arch'];
            $output[$i]['dateadded']=$row['dateadded'];
            $output[$i]['addedby']=$row['addedby'];
            $output[$i]['update']="<a href=\"javascript:parent.showupdate(".$row['id'].")\"><img src=\"".base_url()."images/icon/b_edit.png\" title=\"update\"/></a>";
            $output[$i]['delete']="<a href=\"javascript:parent.deletedata(".$row['id'].")\"><img src=\"".base_url()."images/icon/b_drop.png\" title=\"delete\"/></a>";
        }
        if($query->num_rows()==0)
            $output[0]=array('id'=>"",'hive'=>"",'path'=>"",'arch'=>"",'dateadded'=>"",'addedby'=>"",'update'=>"",'delete'=>"");
        $output=json_encode(array("identifier"=>"id","items"=>$output));
        echo $output;
    }
    function show_grid(){
        $this->load->view('grid_registry');
    }
}
 