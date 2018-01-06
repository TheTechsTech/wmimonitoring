<?
class Software_model extends Model {
	function audit($data){
        $data_status=$data;
        $data_status['status']='added';
		$this->db->update("software",array("flag"=>1),$data_status);
		if($this->db->affected_rows()==0)
			$this->add_new($data);
	}
	function add_new($data){
        $data['dateadded']=date('y-m-d H:i:s');
		$this->db->insert("software",$data);
		//$this->db->insert("log_item",array("item"=>"software",'date'=>date('y-m-d H:i:s'),"type"=>"add","reference"=>$this->db->insert_id()));
	}
	function auditend($hostname){
		$result=$this->db->get_where("software",array("hostname"=>$hostname,"flag"=>0,'status'=>'added'));
		foreach ($result->result() as $row){
    		$this->remove($row->id);
		}
        $this->db->update("software",array('flag'=>0),array('hostname'=>$hostname));
	}
	function remove($id){
		$this->db->where("id",$id);
		$this->db->update("software",array("status"=>"remove","dateremove"=>date('y-m-d H:i:s')));
		//$this->db->insert("log_item",array("item"=>"software",'date'=>date('y-m-d H:i:s'),"type"=>"remove","reference"=>$id));
	}	
	function approve_change($id,$admin){
        $query=$this->db->get_where('software',array('id'=>$id));
        $data=$query->result_array();
        if(count($data)==1){
            if($data[0]['status']=='new')
                $this->db->update('software',array('status'=>'added','adminapprove'=>$admin),array('id'=>$id));
            if($data[0]['status']=='remove')
                $this->db->update('software',array('status'=>'removed','adminapprove'=>$admin),array('id'=>$id));
            return $this->db->affected_rows();
        }
		else
            return 0;
	}
    function ignore_change($id,$admin){
        $query=$this->db->get_where("software",array('id'=>$id));
        if($query->num_rows()==1){
            $data=$query->row_array();
            if($data['status']=='new')
                $this->db->update('software',array("status"=>"ignored",'adminapprove'=>$admin),array('id'=>$id));
            else if($data['status']=='remove')
                $this->db->update('software',array("status"=>"added",'adminapprove'=>$admin),array('id'=>$id));
            return $this->db->affected_rows();
        }
        else
            return 0;
    }
    function get_log($admin=null){
        if($admin==null){
            $query=$this->db->get('log_software');
        }
        else{            
            $query=$this->db->get_where('log_software',array('admin'=>$admin));
        }
        return $query->result_array();
    }
    function get_by_id($id){
        $query=$this->db->get_where('software',array('id'=>$id));
        return $query->result_array();
    }
    function get_log_by_id($id){
        $query=$this->db->get_where('log_software',array('id'=>$id));
        return $query->result_array();
    }
    function get($criteria){
        if(isset($criteria['dateadded'])){
            $this->db->where('software.dateadded >=',$criteria['dateadded'][0]);
            $this->db->where('software.dateadded <',$criteria['dateadded'][1]);
            unset($criteria['dateadded']);
        }
        if(isset($criteria['dateremove'])){
            $this->db->where('software.dateremove >=',$criteria['dateremove'][0]);
            $this->db->where('software.dateremove <',$criteria['dateremove'][1]);
            unset($criteria['dateremove']);
        }
        if(count($criteria['status'])>1){
            $this->db->where_in('software.status',$criteria['status']);
            unset($criteria['status']);
        }
        foreach ($criteria as $key=>$value)
            $criteria1['software.'.$key]=$value;
        if(!isset($criteria1))
            $criteria1=array();
        $this->db->select("software.*,admin.name AS admin_name",false);
        $this->db->join('admin',"admin.id=software.adminapprove");
        $query=$this->db->get_where("software",$criteria1);
        return $query->result_array();
    }
    function deleted($admin,$criteria){
        if(count($criteria['status'])>1){
            $this->db->where_in('status',$criteria['status']);
            unset($criteria['status']);
        }
        $this->db->update("software",array("status"=>"removed","dateremove"=>date('y-m-d H:i:s'),'adminapprove'=>$admin),$criteria);
        $this->db->affected_rows();
    }
}