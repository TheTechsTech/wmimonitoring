<?
class Report extends Controller {
    var $admin;
    function  Report(){
	parent::Controller();
	$this->load->helper('url');
	$this->load->database();
        $this->load->helper('inflector');
	$this->load->model('Report_model');
        $this->load->library('session');
        //print_r($this->session->userdata('id'));
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
        $hardware=$this->Report_model->summary_hardware();
        $software=$this->Report_model->summary_software();
        // echo $this->db->last_query();
        $computer=$this->Report_model->summary_computer();
        $output=array('computer'=>$computer,'hardware'=>$hardware,'software'=>$software);
        $this->load->view('header',$this->admin);
        $this->load->view('report_summary_view',$output);
    }
    function computer(){
        if($this->uri->segment(3)!='OS'&& $this->uri->segment(3)!='Manufacture')
            redirect('/admin/view/');
        $input=isset($_GET['printer'])?$_GET:$_POST;
        foreach($input as $key=>$value)
            $criteria[$key]=$this->input->get_post($key,true);
        if(isset($criteria)){
            $criteria['by']=$this->uri->segment(3);
            $data=$this->Report_model->get_computer($criteria);
            //echo $this->db->last_query();
            foreach($data as $row)
                $data_pie[]=array('y'=>$row['end_stock'],'text'=>$row['name'],'tooltip'=>$row['name']);
            $output=array('data'=>$data,'pie'=>json_encode($data_pie),'by'=>$this->uri->segment(3),'date_start'=>$criteria['date_start'],'date_end'=>$criteria['date_end']);
        }
        else
            $output=array('by'=>$this->uri->segment(3));
        if(isset($criteria['printer']))
            $this->load->view('print_report_computer_view',$output);
        else{
            $this->load->view('header',$this->admin);
            $this->load->view('report_computer_view',$output);
        }
    }
    function detail_computer(){
        $this->load->model('Computer_model');
        foreach($_GET as $key=>$value)
            $input[$key]=$this->input->get($key,true);
        if(isset($input['dateadded1'])){
            $criteria['dateadded']=array($input['dateadded1'],$input['dateadded2']);
            unset($input['dateadded1']);
            unset($input['dateadded2']);
        }
        if(isset($input['dateremove1'])){
            $criteria['dateremove']=array($input['dateremove1'],$input['dateremove2']);
            unset($input['dateremove1']);
            unset($input['dateremove2']);
        }
        if(isset($input['status2'])){            
            foreach ($input as $key=>$value) {                
                 if(strpos($key,'status')===0){                    
                    $criteria['status'][]=$value;
                    unset($input[$key]);
                 }
            }
        }        
        foreach ($input as $key=>$value)            
            $criteria[$key]=$value;        
        $data=$this->Computer_model->get($criteria);
        $data_hide=array('computer_profile','admin');
        for($i=0;$i<count($data);$i++){
            foreach ($data_hide as $value) {
                unset($data[$i][$value]);
            }
        }        
        $this->load->view('detail_computer_report_view',array('data'=>$data));
    }
    function stock_hardware(){
        $input=isset($_GET['printer'])?$_GET:$_POST;
        foreach($input as $key=>$value)
            $criteria[$key]=$this->input->get_post($key,true);
        if(isset($criteria)){
            $data=$this->Report_model->get_hardware($criteria);
            //echo $this->db->last_query();
            $output=array('data'=>$data,'date_start'=>$criteria['date_start'],'date_end'=>$criteria['date_end']);
        }
        else
            $output=array();
        if(isset($criteria['printer']))
            $this->load->view('print_report_hardware_view',$output);
        else{
            $this->load->view('header',$this->admin);
            $this->load->view('report_hardware_view',$output);
        }
    }
    function detail_hardware(){
        $this->load->model('Hardware_model');
        foreach($_GET as $key=>$value)
            $input[$key]=$this->input->get($key,true);
        $this->Hardware_model->item=$input['item'];
        unset($input['item']);
        if(isset($input['dateadded1'])){
            $criteria['dateadded']=array($input['dateadded1'],$input['dateadded2']);
            unset($input['dateadded1']);
            unset($input['dateadded2']);
        }
        if(isset($input['dateremove1'])){
            $criteria['dateremove']=array($input['dateremove1'],$input['dateremove2']);
            unset($input['dateremove1']);
            unset($input['dateremove2']);
        }
        if(isset($input['status2'])){
            foreach ($input as $key=>$value) {
                 if(strpos($key,'status')===0){
                    $criteria['status'][]=$value;
                    unset($input[$key]);
                 }
            }
        }
        foreach ($input as $key=>$value)
            $criteria[$key]=$value;
        //echo json_encode($criteria);
        $data=$this->Hardware_model->get($criteria);
        //echo $this->db->last_query();
        $data_hide=array('flag','adminapprove');
        for($i=0;$i<count($data);$i++){
            foreach ($data_hide as $value) {
                unset($data[$i][$value]);
            }
        }
        $this->load->view('detail_hardware_report_view',array('data'=>$data));
    }
    function stock_software(){
        $input=isset($_GET['printer'])?$_GET:$_POST;
        foreach($input as $key=>$value)
            $criteria[$key]=$this->input->get_post($key,true);
        if(isset($criteria)){
            $data=$this->Report_model->get_software($criteria);
            $output=array('data'=>$data,'date_start'=>$criteria['date_start'],'date_end'=>$criteria['date_end']);
        }
        else
            $output=array();
        if(isset($criteria['printer']))
            $this->load->view('print_report_software_view',$output);
        else{
            $this->load->view('header',$this->admin);
            $this->load->view('report_software_view',$output);
        }
    }
    function detail_software(){
        $this->load->model('Software_model');
        foreach($_GET as $key=>$value)
            $input[$key]=$this->input->get($key,true);
        if(isset($input['dateadded1'])){
            $criteria['dateadded']=array($input['dateadded1'],$input['dateadded2']);
            unset($input['dateadded1']);
            unset($input['dateadded2']);
        }
        if(isset($input['dateremove1'])){
            $criteria['dateremove']=array($input['dateremove1'],$input['dateremove2']);
            unset($input['dateremove1']);
            unset($input['dateremove2']);
        }
        if(isset($input['status2'])){
            foreach ($input as $key=>$value) {
                 if(strpos($key,'status')===0){
                    $criteria['status'][]=$value;
                    unset($input[$key]);
                 }
            }
        }
        foreach ($input as $key=>$value)
            $criteria[$key]=$value;
        $data=$this->Software_model->get($criteria);
        $data_hide=array('flag','adminapprove','id');
        for($i=0;$i<count($data);$i++){
            foreach ($data_hide as $value) {
                unset($data[$i][$value]);
            }
        }
        $this->load->view('detail_software_report_view',array('data'=>$data));
    }
    function distrusted_trace(){        
        $this->load->model('Monitoring_log_model');
        $year=$this->Monitoring_log_model->get_year();
        if(count($year)==0)
            redirect('/admin/view/');
        $input=isset($_GET['printer'])?$_GET:$_POST;
        foreach($input as $key=>$value)
            $criteria[$key]=$this->input->get_post($key,true);
        if(isset($criteria)){
            $data=$this->Report_model->get_trace($criteria);
            foreach($data as $row)
                $data_tabel[$row['type']][$row['month']-1]=$row['count'];
            foreach (array('process_trace','registry_trace') as $type) {
                for($i=0;$i<12;$i++)
                   $data_tabel[$type][$i]=(isset($data_tabel[$type][$i]))?$data_tabel[$type][$i]:0;
            }
            for($i=0;$i<12;$i++){
                $line_process[$i]=(int)$data_tabel['process_trace'][$i];
                $line_registry[$i]=(int)$data_tabel['registry_trace'][$i];
            }
            $output=array('data'=>$data_tabel,'year'=>$criteria['year'],'list_year'=>$year,'line_process'=>$line_process,'line_registry'=>$line_registry);
        }
        else
            $output=array('list_year'=>$year);
        if(isset($criteria['printer']))
            $this->load->view('print_report_trace_view',$output);
        else{
            $this->load->view('header',$this->admin);
            $this->load->view('report_trace_view',$output);
        }
    }
    function detail_trace(){        
        foreach($_GET as $key=>$value)
            $input[$key]=$this->input->get($key,true);
        $input['status']='distrusted';
        if($input['type']=='process_trace')
            $this->load->model('Process_monitor_model','Monitoring');
        elseif($input('type')=='registry_trace')
            $this->load->model('Registry_model','Monitoring');
        else
            redirect('/admin/view');
        unset($input['type']);
        $data=$this->Monitoring->get_trace($input);
        //echo $this->db->last_query();
        $data_hide=array('status','id');
        for($i=0;$i<count($data);$i++){
            foreach ($data_hide as $value) {
                unset($data[$i][$value]);
            }
        }
        $this->load->view('detail_trace_report_view',array('data'=>$data));
    }
}
