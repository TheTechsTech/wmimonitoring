<?
class Logicaldisk_model extends Model {
	function audit($data){
        foreach ($data as $key=>$variabel){
            if($key!="FreeSpace")
                $data_status[$key]=$data[$key];
        }
        $data_status['status']='added';
		$this->db->update("logicaldisk",array("flag"=>1),$data_status);
		if($this->db->affected_rows()==0)
			$this->add_new($data);
        else
            $this->updatefrespace($data);
	}
	function add_new($data){
        $data['dateadded']=date('y-m-d H:i:s');
		$this->db->insert("logicaldisk",$data);
        //$this->db->insert("log_hardware",array("hostname"=>$data['Hostname'],"item"=>"logicaldisk",'date'=>date('y-m-d H:i:s'),"type"=>"add","reference"=>$this->db->insert_id()));
	}
	function auditend($hostname){
		$result=$this->db->get_where("logicaldisk",array("hostname"=>$hostname,"flag"=>0,'status'=>'added'));
		foreach ($result->result() as $row){
    		$this->remove($row->id);
		}
        $this->db->update("logicaldisk",array('flag'=>0),array('hostname'=>$hostname));
	}
	function remove($id,$hostname){
		$this->db->where("id",$id);
		$this->db->update("logicaldisk",array("status"=>"remove"));
		$this->db->insert("log_hardware",array("hostname"=>$hostname,"item"=>"logicaldisk",'date'=>date('y-m-d H:i:s'),"type"=>"remove","reference"=>$id));
	}
    function updatefreespace($data){
        foreach ($data as $key => $variable) {
            if($key=="FreeSpace")
                $FreeSpace=$variabel;
            else
                $datawhere[$key]=$data[$key];
        }
        $this->db->update("logicaldisk",array("FreeSpace"=>$FreeSpace),$datawhere);
    }
	function approve_add($id,$admin){
		$this->db->where("id",$id);
		$this->db->update("logicaldisk",array("status"=>"added",'adminapprove'=>$admin));
	}
	function approve_remove($id,$admin){
		$this->db->where("id",$id);
		$this->db->update("logicaldisk",array("status"=>"removed",'adminapprove'=>$admin));
	}
    function ignore_change($id,$admin){
        $query=$this->db->get_where("logicaldisk",array('id'=>$id));
        if($query->num_rows()==1){
            $data=$query->row_array();
            if($data['status']=='new')
                $this->db->update('logicaldisk',array("status"=>"removed",'adminapprove'=>$admin),array('id'=>$id));
            else if($data['status']=='remove')
                $this->db->update('logicaldisk',array("status"=>"added",'adminapprove'=>$admin),array('id'=>$id));
        }
    }
}
?>